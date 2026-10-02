<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Edifice_model extends CI_Model
{
    private $table = 'edifice';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all edifice records
     */
    public function get_all()
    {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }

    /**
     * Get edifice record by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Insert new edifice record
     */
    public function insert($data)
    {
        $data['created_by'] = $this->session->userdata('user_id');
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update edifice record
     */
    public function update($id, $data)
    {
        $data['updated_by'] = $this->session->userdata('user_id');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete edifice record
     */
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Get records by date range
     */
    public function get_by_date_range($start_date, $end_date)
    {
        return $this->db->where('receipt_date >=', $start_date)
                        ->where('receipt_date <=', $end_date)
                        ->order_by('receipt_date', 'DESC')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Get records by book owner
     */
    public function get_by_book_owner($book_owner_name)
    {
        return $this->db->where('book_owner_name', $book_owner_name)
                        ->order_by('receipt_date', 'DESC')
                        ->get($this->table)
                        ->result();
    }

    /**
     * Get total cash and cheque amounts
     */
    public function get_totals()
    {
        $this->db->select('SUM(cash_amount) as total_cash, SUM(cheque_amount) as total_cheque, SUM(total_amount) as grand_total');
        return $this->db->get($this->table)->row();
    }

    /**
     * Get summary by book number
     */
    public function get_summary_by_book()
    {
        $query = $this->db->query("
            SELECT book_number, book_owner_name, SUM(total_amount) as book_total
            FROM `{$this->table}`
            GROUP BY book_number, book_owner_name
            ORDER BY CAST(book_number AS UNSIGNED) ASC
        ");
        return $query->result();
    }

    /**
     * Get summary by payment type (Online/Cash/Cheque)
     */
    public function get_summary_by_payment_type()
    {
        $query = $this->db->query("
            SELECT
                SUM(CASE WHEN cash_amount > 0 AND cheque_amount = 0 THEN total_amount ELSE 0 END) as cash_total,
                SUM(CASE WHEN cheque_amount > 0 THEN total_amount ELSE 0 END) as cheque_total
            FROM `{$this->table}`
        ");
        return $query->row();
    }
}
