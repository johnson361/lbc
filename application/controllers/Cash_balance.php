<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash_balance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cash_balance_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // // Display cash in hand page
    // public function index()
    // {
    //     $data['cash_balance'] = $this->Cash_balance_model->get_balance();
    //     $this->load->view('cash_balance/index', $data);
    // }

    public function add_cash()
    {
        $amount = (int) str_replace(',', '', $this->input->post('amount')); // cast to int

        if ($amount > 0) {
            $this->Cash_balance_model->add_cash($amount);
            $this->session->set_flashdata('success', 'Cash added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Please enter a valid amount.');
        }

        redirect('Expenditure');
    }

    // Deduct cash
    public function deduct_cash()
    {
        $amount = (int) str_replace(',', '', $this->input->post('amount')); // cast to int

        if ($amount > 0) {
            $this->Cash_balance_model->deduct_cash($amount);
            $this->session->set_flashdata('success', 'Cash deducted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Please enter a valid amount.');
        }

        redirect('Expenditure');
    }
}
