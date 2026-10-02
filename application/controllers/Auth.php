<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
    }

    public function login() {
        $this->load->view('login');
    }

    public function do_login() {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->Auth_model->get_user_by_username($username);

        if ($user && $user->password === $password) {
            // Set session data
            $this->session->set_userdata([
                'user_id' => $user->id,
                'username'   => $user->username,
                'name'   => $user->name,
                'role'    => $user->role,
                'logged_in' => TRUE
            ]);
            redirect('/'); // Redirect after successful login
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
