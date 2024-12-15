<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Service_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    // public function index() {
    //     $data['services'] = $this->Service_model->get_all_services();
    //     $this->load->view('services/index', $data);
    // }

    public function index() {
        $data['page_content'] = 'services/index';
        $data['services'] = $this->Service_model->get_all_services();
        $this->load->view('layouts/navbar', $data);
        $this->load->view('layouts/main', $data);
    }
    

    public function create() {
        $data['languages'] = $this->Service_model->get_languages();
        $data['offering_types'] = $this->Service_model->get_offering_types();

        if ($this->input->post()) {
            $this->form_validation->set_rules('language_id', 'Language', 'required');
            $this->form_validation->set_rules('offering_type_id', 'Offering Type', 'required');
            $this->form_validation->set_rules('service_slot', 'Service Slot', 'required');

            if ($this->form_validation->run()) {
                $service_data = array(
                    'language_id' => $this->input->post('language_id'),
                    'offering_type_id' => $this->input->post('offering_type_id'),
                    'service_slot' => $this->input->post('service_slot'),
                );

                $this->Service_model->insert_service($service_data);
                redirect('services');
            }
        }

        $this->load->view('services/create', $data);
    }

    public function edit($id) {
        $data['service'] = $this->Service_model->get_service($id);
        $data['languages'] = $this->Service_model->get_languages();
        $data['offering_types'] = $this->Service_model->get_offering_types();

        if ($this->input->post()) {
            $this->form_validation->set_rules('language_id', 'Language', 'required');
            $this->form_validation->set_rules('offering_type_id', 'Offering Type', 'required');
            $this->form_validation->set_rules('service_slot', 'Service Slot', 'required');

            if ($this->form_validation->run()) {
                $service_data = array(
                    'language_id' => $this->input->post('language_id'),
                    'offering_type_id' => $this->input->post('offering_type_id'),
                    'service_slot' => $this->input->post('service_slot'),
                );

                $this->Service_model->update_service($id, $service_data);
                redirect('services');
            }
        }

        $this->load->view('services/edit', $data);
    }

    public function delete($id) {
        $this->Service_model->delete_service($id);
        redirect('services');
    }
}
