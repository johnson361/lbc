<?php
class Offering_model extends CI_Model
{

    // Insert a new offering
    public function create_offering($data)
    {

        $data['created_by'] = $this->session->userdata('user_id');
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
        $data['created_by'] = $this->session->userdata('user_id');
        $this->db->insert('offerings', $data);

        if ($this->db->affected_rows() > 0) {
            // return true; // Success
            return $this->db->insert_id();
        }

        return false; // Failure
    }

    public function update_offerings($data)
    {
        unset($data['autocomplete_member']); //because i donto wnt to update this IN USERS TABLE
        $data['service_date'] = convertToMySQLDate($data['service_date']);
        // print_r($data);
        // exit;users.name
        if (empty($data) || empty($data['id']) || !is_array($data)) {
            return false; // Return false if no data or data is invalid
        }
        $data['created_by'] = $this->session->userdata('user_id');
        $this->db->where('id', $data['id']);
        $this->db->update('offerings', $data);

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
            ORDER BY order_by
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

    public function get_last_30_days_service_dates()
    {
        $sql = "
        SELECT DISTINCT service_date
        FROM offerings
        WHERE service_id IN (11, 13, 21, 23, 31, 33, 41, 43)
        AND service_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)  -- last 30 days
            AND service_date NOT IN (
            SELECT DISTINCT service_date
            FROM offering_messages
            WHERE service_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            )
        ORDER BY service_date DESC
    ";
        return $this->db->query($sql)->result_array();
    }

    public function get_offerings_by_date($service_date)
    {
        $sql = "
            SELECT 
                users.id as user_id,
                users.name AS full_name,
                offering_types.offering_name as offering_type,
                users.phone, 
                GROUP_CONCAT(offerings.id SEPARATOR ',') AS offering_ids, 
                offerings.service_date AS service_date, 
                sum(offerings.grand_total) AS total_amount
            FROM ((((
                services 
                LEFT JOIN languages ON services.language_id = languages.id
            ) 
                JOIN offering_types ON services.offering_type_id = offering_types.id
            )
                JOIN offerings ON services.id = offerings.service_id
            )
                JOIN users ON offerings.user_id = users.id
            )
            WHERE offerings.service_date = ?
              AND users.phone IS NOT NULL 
              AND users.phone != '' 
              AND offerings.service_id IN (11, 13, 21, 23, 31, 33, 41, 43)
            group by users.id , offerings.service_id
			ORDER BY languages.language_name;
        ";

        return $this->db->query($sql, [$service_date])->result_array();
    }

    public function log_message($offering_ids, $user_id, $service_date, $phone, $message_text, $api_response, $amount)
    {
        $data = [
            'offering_ids'  => $offering_ids,
            'user_id'      => $user_id,
            'service_date' => $service_date,
            'phone'        => $phone,
            'message_text' => $message_text,
            'api_response' => $api_response,
            'amount' => $amount,
            'created_by' => $this->session->userdata('user_id')
        ];

        return $this->db->insert('offering_messages', $data);
    }
}
