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
        $data['service_date'] = convertToMySQLDate($data['service_date']);
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

    // public function getExistingData($service_id, $service_date)
    // {
    //     $service_date = convertToMySQLDate($service_date);
    //     $sql = "SELECT * FROM view_detail_offerings WHERE service_id = ? AND service_date = ?";
    //     $query = $this->db->query($sql, [$service_id, $service_date]);
    //     return $query->result_array(); // Returns the data as an array
    // }

    public function get_headers_by_date($service_date)
    {
        $query = $this->db->query("
            SELECT DISTINCT service_id, service_name 
            FROM view_detail_offerings 
            WHERE service_date = ? 
            ORDER BY service_name
        ", [$service_date]);
        return $query->result_array();
    }

    public function get_details_by_service($service_id, $service_date)
    {
        $query = $this->db->query("
            SELECT * 
            FROM view_detail_offerings 
            WHERE service_id = ? 
              AND service_date = ?
        ", [$service_id, $service_date]);
        return $query->result_array();
    }
}
