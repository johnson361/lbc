<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function get_user_by_username($username) {
        $query = $this->db->get_where('login_users', ['username' => $username, 'status' => 1]);
        return $query->row(); // single row as object
    }
}
