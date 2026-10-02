<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cash_balance_model extends CI_Model
{
    private $table = 'cash_balance';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_balance()
    {
        $query = $this->db->query('SELECT current_balance FROM `cash_balance` order by id asc');
        return $query->result_array();
    }

    // Add cash
    public function add_cash($amount)
    {
        $amount = (int) str_replace(',', '', $amount); // Remove commas and cast to int
        if ($amount <= 0) return false;

        $this->db->set('current_balance', 'current_balance + ' . $amount, FALSE);
        $this->db->set('last_updated', date('Y-m-d H:i:s'));
        $this->db->where('id', 1);
        return $this->db->update($this->table);
    }

    // Deduct cash
    public function deduct_cash($amount)
    {
        $amount = (int) str_replace(',', '', $amount); // Remove commas and cast to int
        if ($amount <= 0) return false;

        $this->db->set('current_balance', 'current_balance - ' . $amount, FALSE);
        $this->db->set('last_updated', date('Y-m-d H:i:s'));
        $this->db->where('id', 1);
        return $this->db->update($this->table);
    }
}
