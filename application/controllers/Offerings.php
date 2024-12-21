<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offerings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Offering_model');
        $this->load->model('Service_model');
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['services'] = $this->Service_model->get_all_services();
        $data['users'] = $this->User_model->get_all_users();

        $data['page_content'] = 'offerings/index';  // Path to the offerings view
        $this->load->view('layouts/navbar', $data);
        $this->load->view('layouts/main', $data);
    }

    public function add()
    {
        $post = $this->input->post();
        $data = $post['data'][0];
        // print_r($data);
        if (empty($data)) {
            echo json_encode(['success' => false, 'message' => 'No offerings data provided.']);
            return;
        }

        if (empty($data['service_id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid service_id data.']);
            return;
        }

        $data['user_id'] = $this->getUserIdFromMember($data['autocomplete_member']);
        if (!$data['user_id']) {
            echo json_encode(['success' => false, 'message' => 'Failed to process user data.']);
            return;
        }

        $result = $this->Offering_model->add_offerings($data);
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Offering added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add offering.']);
        }
    }

    public function getUserIdFromMember($autocomplete_member)
    {
        if (!empty($autocomplete_member)) {
            $parts = explode('-', $autocomplete_member);
            $name = trim($parts[0]);
            $phone = isset($parts[1]) ? trim($parts[1]) : null;

            $user_id = $this->User_model->get_or_create_user($name, $phone);

            if ($user_id) {
                return $user_id;
            }
        }

        return false;
    }



    // public function save() {
    //     if ($this->input->post()) {
    //         $offerings = $this->input->post('offerings');  // Get the offerings data
    //         $service_id = $this->input->post('service_id'); 

    //         // Insert each offering
    //         foreach ($offerings as $offering) {
    //             $data = [
    //                 'service_id' => $service_id,
    //                 'user_id' => $offering['user_id'],
    //                 'denomination_500' => $offering['denomination_500'],
    //                 'denomination_200' => $offering['denomination_200'],
    //                 'denomination_100' => $offering['denomination_100'],
    //                 'denomination_50' => $offering['denomination_50'],
    //                 'denomination_20_notes' => $offering['denomination_20_notes'],
    //                 'denomination_20_coins' => $offering['denomination_20_coins'],
    //                 'denomination_10_notes' => $offering['denomination_10_notes'],
    //                 'denomination_10_coins' => $offering['denomination_10_coins'],
    //                 'denomination_5_notes' => $offering['denomination_5_notes'],
    //                 'denomination_5_coins' => $offering['denomination_5_coins'],
    //                 'denomination_2_notes' => $offering['denomination_2_notes'],
    //                 'denomination_2_coins' => $offering['denomination_2_coins'],
    //                 'denomination_1_notes' => $offering['denomination_1_notes'],
    //                 'denomination_1_coins' => $offering['denomination_1_coins']
    //             ];
    //             // Insert into the offerings table
    //             $this->Offering_model->create_offering($data);
    //         }

    //         // Redirect after saving
    //         redirect('offerings');
    //     }
    // }
}
