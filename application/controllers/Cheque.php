<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cheque extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cheque_model');
        $this->load->helper(['url', 'form']);
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Show all cheques
    public function index()
    {
        $data['cheques'] = $this->Cheque_model->get_all_cheques();
        // $this->load->view('cheque/index', $data);
        $data['page_content'] = 'cheque/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }

    // Reject a cheque
    public function reject($id)
    {
        $this->Cheque_model->reject_cheque($id);
        $this->session->set_flashdata('success', 'Cheque has been rejected.');
        redirect('cheque');
    }
}
