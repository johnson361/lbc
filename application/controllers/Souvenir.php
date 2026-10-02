<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Souvenir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the model
        $this->load->model('souvenir_model');
        // Load the helper for base_url()
        $this->load->helper('url');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        // Fetch all the data
        $data['payments'] = $this->souvenir_model->get_all_payments();
        $data['member_stats'] = $this->souvenir_model->get_committee_totals();
        $data['page_size_stats'] = $this->souvenir_model->get_page_size_stats();
        $data['ad_type_stats'] = $this->souvenir_model->get_ad_type_stats();
        
        $data['page_content'] = 'souvenir/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }
}