<?php
class Offering_model extends CI_Model
{

    // Insert a new offering
    public function create_offering($data)
    {
        return $this->db->insert('offerings', $data);
    }

    public function get_all_offerings()
    {
        return $this->db->get('offerings')->result_array();
    }

    public function add_offerings($data)
    {
        unset($data['autocomplete_member']); //because i donto wnt to insert this IN USERS TABLE
        // print_r($data);
        // exit;
        if (empty($data) || !is_array($data)) {
            return false; // Return false if no data or data is invalid
        }
        $this->db->insert('offerings', $data);

        if ($this->db->affected_rows() > 0) {
            return true; // Success
        }

        return false; // Failure
    }
}
