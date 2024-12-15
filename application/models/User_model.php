<?php
class User_model extends CI_Model {

    // Get all users
    public function get_all_users() {
        return $this->db->get('users')->result_array();
    }

    // Get a user by ID
    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    // Insert a new user
    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

    // Update an existing user
    public function update_user($id, $data) {
        return $this->db->update('users', $data, ['id' => $id]);
    }

    // Delete a user
    public function delete_user($id) {
        return $this->db->delete('users', ['id' => $id]);
    }
}
