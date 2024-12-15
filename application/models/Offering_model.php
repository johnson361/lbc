<?php
class Offering_model extends CI_Model {

    // Insert a new offering
    public function create_offering($data) {
        return $this->db->insert('offerings', $data);
    }

    // Fetch all offerings
    public function get_all_offerings() {
        return $this->db->get('offerings')->result_array();
    }
}
