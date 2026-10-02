<?php
/*defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model('Reports_model');
    }

    public function offerings()
    {
        $data['report'] = $this->Reports_model->get_offerings_report();
        // $this->load->view('reports/offerings_report', $data);

        $data['page_content'] = 'reports/offerings_report';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }
}*/

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model('Reports_model');
        // Load the Service_model
        $this->load->model('Service_model');
    }

    public function offerings()
    {
        // Get filter data from POST request (for form submission) or GET
        // Using POST here for form submission, but you might use GET for clean URLs/reload
        $service_ids = $this->input->post('service_id');

        // Fetch all services for the filter dropdown
        $data['services'] = $this->Service_model->get_all_services();

        // Pass the selected service IDs back to the view to maintain the selection
        $data['selected_service_ids'] = $service_ids;

        // Pass the filter to the model to fetch the report data
        $data['report'] = $this->Reports_model->get_offerings_report($service_ids);

        $data['page_content'] = 'reports/index';
        $this->load->view('layouts/navbar', $data);
        $this->load->view('layouts/main', $data);
    }

    public function upsert_deposit()
    {
        // Basic Security: Check if AJAX
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data = [
            'id'             => $this->input->post('deposit_id'),
            'service_date'   => $this->input->post('service_date'),
            'deposit_date'   => $this->input->post('deposit_date'),
            'amount'         => $this->input->post('deposit_amount'), // Maps JS 'deposit_amount' to DB 'amount'
            'bank'           => $this->input->post('bank')
        ];

        $user_id = $this->session->userdata('user_id') ?? 0;

        // Validate that we at least have a Service Date (the unique anchor)
        if ($data['service_date']) {
            $success = $this->Reports_model->upsert_deposit_full($data, $user_id);

            if ($success) {
                echo json_encode(['status' => 'success']);
            } else {
                $this->output->set_status_header(500);
                echo json_encode(['status' => 'error', 'message' => 'Database Update Failed']);
            }
        } else {
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing Service Date']);
        }
    }
}
