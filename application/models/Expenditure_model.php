<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditure_model extends CI_Model {

    private $table = 'expenditures';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->order_by('expense_date', 'DESC')->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
