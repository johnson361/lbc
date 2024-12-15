<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    // List all users
    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $data['page_content'] = 'users/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }

    // Add a new user
    public function create() {
        if ($this->input->post()) {
            // Get form data
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone_number' => $this->input->post('phone_number'),
            );
            // Insert user into database
            $this->User_model->create_user($data);
            redirect('users');  // Redirect to the list of users
        }
        $data['page_content'] = 'users/create';
        $this->load->view('layouts/navbar', $data);
        $this->load->view('layouts/main', $data);
    }

    // Edit user details
    public function edit($id) {
        if ($this->input->post()) {
            // Get form data
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone_number' => $this->input->post('phone_number'),
            );
            // Update user data
            $this->User_model->update_user($id, $data);
            redirect('users');
        }
        $data['user'] = $this->User_model->get_user_by_id($id);
        $data['page_content'] = 'users/edit';
        $this->load->view('layouts/navbar', $data);
        $this->load->view('layouts/main', $data);
    }

    // Delete a user
    public function delete($id) {
        $this->User_model->delete_user($id);
        redirect('users');  // Redirect to the list of users
    }
}
