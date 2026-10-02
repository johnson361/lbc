<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposit extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Deposit_model');
        $this->load->helper(['form', 'url']);
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['deposits'] = $this->Deposit_model->get_all();
        // $this->load->view('deposit/index', $data);

        $data['page_content'] = 'deposit/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }

    public function store()
    {
        $data = [
            'amount'       => $this->input->post('amount'),
            'service_date' => $this->input->post('service_date'),
            'notes'        => $this->input->post('notes'),
            'bank'        => $this->input->post('bank'),
            'created_by'   => $this->session->userdata('user_id')
        ];
        $this->Deposit_model->insert($data);
        redirect('deposit');
    }

    public function update($id)
    {
        $data = [
            'amount'       => $this->input->post('amount'),
            'service_date' => $this->input->post('service_date'),
            'notes'        => $this->input->post('notes'),
            'bank'        => $this->input->post('bank'),
            'created_by'   => $this->session->userdata('user_id')
        ];
        $this->Deposit_model->update($id, $data);
        redirect('deposit');
    }

    public function delete($id)
    {
        $this->Deposit_model->delete($id);
        redirect('deposit');
    }
}
