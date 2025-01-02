<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {

    public function get_all_services() {
        $this->db->select('services.*, languages.language_name, offering_types.offering_name');
        $this->db->from('services');
        $this->db->join('languages', 'services.language_id = languages.id', 'left');
        $this->db->join('offering_types', 'services.offering_type_id = offering_types.id');
        $this->db->order_by('services.id', 'ASC'); // Orders by 'id' in ascending order (ASC)
        return $this->db->get()->result_array();
    }

    public function get_languages() {
        return $this->db->get('languages')->result_array();
    }

    public function get_offering_types() {
        return $this->db->get('offering_types')->result_array();
    }

    public function get_service($id) {
        return $this->db->get_where('services', array('id' => $id))->row_array();
    }

    public function insert_service($data) {
        return $this->db->insert('services', $data);
    }

    public function update_service($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('services', $data);
    }

    public function delete_service($id) {
        $this->db->where('id', $id);
        return $this->db->delete('services');
    }
}
