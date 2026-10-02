<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Edifice extends CI_Controller
{
    // Book Owner Names List
    const BOOK_OWNERS = [
        'Mr Zapnath Israel',
        'Mrs Hepsibah Samson',
        'Mr Aluri David',
        'Mr C R Moses',
        'Mr Sandra Yona Raju',
        'Secretary & Treasurer',
        'Pas Onisum',
        'Out Station Churches'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Edifice_model');
        $this->load->helper(['form', 'url']);
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    /**
     * Display all edifice records
     */
    public function index()
    {
        $data['edifices'] = $this->Edifice_model->get_all();
        $data['totals'] = $this->Edifice_model->get_totals();
        $data['book_owners'] = self::BOOK_OWNERS;
        $data['summary_by_book'] = $this->Edifice_model->get_summary_by_book();
        $data['summary_by_payment'] = $this->Edifice_model->get_summary_by_payment_type();

        $data['page_content'] = 'edifice/index';
        $this->load->view('layouts/navbar', $data);
        $this->load->view('layouts/main', $data);
    }

    /**
     * Store new edifice record
     */
    public function store()
    {
        $data = [
            'receipt_date' => $this->input->post('receipt_date'),
            'book_number' => $this->input->post('book_number'),
            'receipt_no' => $this->input->post('receipt_no'),
            'reference_number' => $this->input->post('reference_number'),
            'name' => $this->input->post('name'),
            'mobile' => $this->input->post('mobile'),
            'cash_amount' => (int)str_replace(',', '', $this->input->post('cash_amount')) ?: 0,
            'cheque_amount' => (int)str_replace(',', '', $this->input->post('cheque_amount')) ?: 0,
            'cheque_number' => $this->input->post('cheque_number'),
            'book_owner_name' => $this->input->post('book_owner_name'),
            'cheque_rejected_status' => $this->input->post('cheque_rejected_status') ? 1 : 0
        ];

        if ($this->Edifice_model->insert($data)) {
            $this->session->set_flashdata('success', 'Edifice record added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add record.');
        }
        redirect('edifice');
    }

    /**
     * Update edifice record
     */
    public function update($id)
    {
        $data = [
            'receipt_date' => $this->input->post('receipt_date'),
            'book_number' => $this->input->post('book_number'),
            'receipt_no' => $this->input->post('receipt_no'),
            'reference_number' => $this->input->post('reference_number'),
            'name' => $this->input->post('name'),
            'mobile' => $this->input->post('mobile'),
            'cash_amount' => (int)str_replace(',', '', $this->input->post('cash_amount')) ?: 0,
            'cheque_amount' => (int)str_replace(',', '', $this->input->post('cheque_amount')) ?: 0,
            'cheque_number' => $this->input->post('cheque_number'),
            'book_owner_name' => $this->input->post('book_owner_name'),
            'cheque_rejected_status' => $this->input->post('cheque_rejected_status') ? 1 : 0
        ];

        if ($this->Edifice_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Edifice record updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update record.');
        }
        redirect('edifice');
    }

    /**
     * Delete edifice record
     */
    public function delete($id)
    {
        if ($this->Edifice_model->delete($id)) {
            $this->session->set_flashdata('success', 'Edifice record deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete record.');
        }
        redirect('edifice');
    }
}
