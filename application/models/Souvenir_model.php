<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Souvenir_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load the database library if not auto-loaded
        $this->load->database();
    }

    // Function to fetch all data
    public function get_all_payments()
    {
        // Equivalent to: SELECT * FROM souvenir_payments_2025;
        $this->db->order_by('book_receipt_number', 'ASC'); // or 'DESC' for descending
        $query = $this->db->get('souvenir_payments_2025');
        return $query->result_array(); // Returns data as an array of objects
    }

    public function get_committee_totals()
    {
        // Define common online payment modes for grouping
        $online_modes = ['Online'];

        $this->db->select('
            committee_member AS Name,
            COUNT(*) AS Pages_Count, 
            SUM(amount) AS Total,
            
            /* Online Totals and Counts */
            SUM(CASE WHEN payment_mode IN ("' . implode('", "', $online_modes) . '") THEN amount ELSE 0 END) AS Online_Total,
            SUM(CASE WHEN payment_mode IN ("' . implode('", "', $online_modes) . '") THEN 1 ELSE 0 END) AS Online_Count, /* <--- NEW COUNT */
            
            /* Cash Totals and Counts */
            SUM(CASE WHEN payment_mode = "Cash" THEN amount ELSE 0 END) AS Cash_Total,
            SUM(CASE WHEN payment_mode = "Cash" THEN 1 ELSE 0 END) AS Cash_Count,       /* <--- NEW COUNT */
            
            /* Cheque Totals and Counts */
            SUM(CASE WHEN payment_mode = "cheque" THEN amount ELSE 0 END) AS Cheque_Total,
            SUM(CASE WHEN payment_mode = "cheque" THEN 1 ELSE 0 END) AS Cheque_Count,     /* <--- NEW COUNT */
            
            /* Total Transaction Count (same as Pages_Count, but good for completeness) */
            COUNT(*) AS Total_Count                                                      /* <--- NEW COUNT */
        ');
        $this->db->from('souvenir_payments_2025');
        $this->db->where('committee_member IS NOT NULL');
        $this->db->group_by('committee_member');
        $this->db->order_by('Total', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_page_size_stats()
    {
        $this->db->select('page_size, COUNT(*) as count');
        $this->db->from('souvenir_payments_2025');
        $this->db->group_by('page_size');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ad_type_stats()
    {
        $this->db->select('type_of_ad, COUNT(*) as count');
        $this->db->from('souvenir_payments_2025');
        $this->db->group_by('type_of_ad');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
