<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cheque_model extends CI_Model
{

    public function get_all_cheques()
    {
        $this->db->select('o.id, o.service_date, o.check_no, o.check_amount, o.cheque_rejected, u.name as user_name');
        $this->db->from('offerings o');
        $this->db->join('users u', 'o.user_id = u.id');
        $this->db->where('o.is_cheque', 1);
        $this->db->order_by('o.service_date', 'DESC');
        return $this->db->get()->result_array();
    }

    public function reject_cheque($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('offerings', ['cheque_rejected' => 1]);
    }
}
