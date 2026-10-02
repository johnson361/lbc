<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenditure extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expenditure_model');
        $this->load->model('Cash_balance_model');

        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['expenditures'] = $this->Expenditure_model->get_all();
        $data['cash_balance'] = $this->Cash_balance_model->get_balance();

        // $this->load->view('expenditure/index', $data);


        $data['page_content'] = 'expenditure/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }

    // In your Expenditure Controller

    // Mapping and Constants remain the same
    const BANK_MAP = [
        'axis' => 1,
        'sbi'  => 2,
    ];
    const CASH_IN_HAND_ID = 3;

    //-------------------------------------------------------------------------
    // PUBLIC METHOD (The only change here is how we handle the result of _updateBalances)
    //-------------------------------------------------------------------------
    public function save()
    {
        // 1. Validation Rules (No change)
        $this->form_validation->set_rules('title', 'Title', 'required');
        // ... (rest of validation) ...

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        // 2. Collect Data (No change)
        $amount         = (float) $this->input->post('amount');
        $payment_method = $this->input->post('payment_method');
        $payment_to     = $this->input->post('payment_to');
        $bank_name      = strtolower($this->input->post('bank_name'));
        $user_id        = $this->session->userdata('user_id');
        $id             = $this->input->post('id');

        $data = [
            // ... (rest of data array) ...
            'title'          => $this->input->post('title'),
            'amount'         => $amount,
            'expense_date'   => $this->input->post('expense_date'),
            'comments'       => $this->input->post('comments'),
            'payment_method' => $payment_method,
            'payment_to'     => $payment_to,
            'cheque_number'  => $this->input->post('cheque_number') ?: null,
            'bank_name'      => $bank_name,
            'created_by'     => $user_id,
        ];

        // 3. Start Database Transaction
        $this->db->trans_start();

        $balance_check_passed = TRUE;

        // 4. Update Balances (Only for new records)
        if (!$id) {
            $balance_check_passed = $this->_updateBalances($payment_method, $payment_to, $bank_name, $amount);
        }

        if ($balance_check_passed === TRUE) {
            // 5. Save Expenditure Record (Only if the balance checks passed)
            if ($id) {
                $this->Expenditure_model->update($id, $data);
                $message = 'Expenditure updated successfully';
            } else {
                $this->Expenditure_model->insert($data);
                $message = 'Expenditure added successfully';
            }
        }

        // 6. Complete Transaction (Will rollback if _updateBalances failed or if a query failed)
        $this->db->trans_complete();

        // 7. Check Transaction Status and Respond
        if ($this->db->trans_status() === FALSE || $balance_check_passed === FALSE) {
            // The transaction will have auto-rolled back if a check failed before the commit
            $error_message = $balance_check_passed === FALSE
                ? 'Error: Insufficient funds in the source account to cover this expenditure.'
                : 'Transaction failed due to a database error. Please try again.';

            echo json_encode(['status' => 'error', 'message' => $error_message]);
        } else {
            // Transaction succeeded
            echo json_encode(['status' => 'success', 'message' => $message]);
        }
    }

    //-------------------------------------------------------------------------
    // PRIVATE HELPER METHODS
    //-------------------------------------------------------------------------

    /**
     * Determines which account balances need to be adjusted.
     * @return bool TRUE on success, FALSE if any adjustment would result in a negative balance.
     */
    private function _updateBalances($payment_method, $payment_to, $bank_name, $amount)
    {
        // Case 1: Paid by physical CASH
        if ($payment_method === 'cash') {
            // Decrease Cash in Hand balance
            return $this->_adjustBalance(self::CASH_IN_HAND_ID, -$amount);
        }

        // Case 2: Paid by CHEQUE/Bank Transfer
        if ($payment_method === 'cheque') {
            if (isset(self::BANK_MAP[$bank_name])) {
                $bank_id = self::BANK_MAP[$bank_name];

                if ($payment_to === 'Self') {
                    // 2a. Transfer: Decrease Bank balance (Source)
                    if (!$this->_adjustBalance($bank_id, -$amount)) {
                        return FALSE; // Insufficient Bank balance
                    }
                    // 2b. Transfer: Increase Cash in Hand balance (Destination)
                    // (This will always succeed as it's an increase)
                    $this->_adjustBalance(self::CASH_IN_HAND_ID, $amount);
                    return TRUE;
                } else {
                    // 2c. Direct Expense: Decrease Bank balance
                    return $this->_adjustBalance($bank_id, -$amount);
                }
            }
        }
        return TRUE; // No cash/bank interaction (e.g., RTGS to unmapped bank or unknown method)
    }

    /**
     * Executes the direct SQL update to adjust a single account balance, 
     * but only if the change is valid.
     * * @param int $id The cash_balance table ID.
     * @param float $amount_change The amount to change (+ for increase, - for decrease)
     * @return bool TRUE if balance was successfully adjusted or if it was an increase, FALSE on insufficient funds.
     */
    private function _adjustBalance($id, $amount_change)
    {
        // If it's an increase, skip the check and proceed.
        if ($amount_change >= 0) {
            $operator = '+';
            $abs_amount = $amount_change;
        } else {
            // It's a decrease, we must check the balance first.
            $abs_amount = abs($amount_change);

            // Fetch the current balance within the transaction (optional for simple check, but safer)
            $current_balance = $this->db->select('current_balance')
                ->where('id', $id)
                ->get('cash_balance')
                ->row()
                ->current_balance ?? 0;

            if ($current_balance < $abs_amount) {
                // If funds are insufficient, force a rollback.
                $this->db->trans_rollback();
                return FALSE;
            }

            $operator = '-';
        }

        // Perform the update
        $this->db->set('current_balance', "current_balance {$operator} {$abs_amount}", FALSE)
            ->where('id', $id)
            ->update('cash_balance');

        return TRUE;
    }

    public function delete($id)
    {
        $this->Expenditure_model->delete($id);
        redirect('expenditure');
    }

    // Get single record (AJAX)
    public function get($id)
    {
        $data = $this->Expenditure_model->get($id);
        echo json_encode($data);
    }
}
