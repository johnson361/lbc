<?php
class User_model extends CI_Model
{

    // Get all users
    public function get_all_users()
    {
        return $this->db->get('users')->result_array();
    }

    // Get a user by ID
    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    // Insert a new user
    public function create_user($data)
    {
        return $this->db->insert('users', $data);
    }

    // Update an existing user
    public function update_user($id, $data)
    {
        return $this->db->update('users', $data, ['id' => $id]);
    }

    // Delete a user
    public function delete_user($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function search_users($query)
    {
        $this->db->select("id, CONCAT(IFNULL(name, ''), '-', IFNULL(phone, '')) AS name");
        $this->db->like('name', $query);
        $query = $this->db->get('users');

        //log_message('info', 'Last query executed: ' . $this->db->last_query());
        return $query->result_array();
    }

    public function get_or_create_user($name)
    {
        $this->db->where('name', $name);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }

        $data = ['name' => $name];

        if ($this->db->insert('users', $data)) {
            return $this->db->insert_id();
        }

        return false;
    }
}
