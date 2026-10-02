<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposit_model extends CI_Model
{

    private $table = "deposit_amount";

    const BANK_MAP = [
        'axis' => 1,
        'sbi'  => 2,
    ];

    public function get_all()
    {
        return $this->db->order_by("id", "DESC")->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // public function insert($data)
    // {
    //     $data['created_by'] = $this->session->userdata('user_id');
    //     return  $this->db->insert($this->table, $data);
    // }

    public function insert($data)
    {
        $bank_name_key = strtolower($data['bank']);
        $cash_balance_id = self::BANK_MAP[$bank_name_key] ?? null;
        if ($cash_balance_id === null) {
            error_log("Deposit Error: Cannot map bank name '{$data['bank']}' to a cash_balance ID.");
            return FALSE;
        }

        $data['created_by'] = $this->session->userdata('user_id');
        $deposit_insert_result = $this->db->insert($this->table, $data);

        if ($deposit_insert_result) {
            $deposit_amount = (int) $data['amount'];
            $this->db->set('current_balance', 'current_balance + ' . $deposit_amount, FALSE);
            $this->db->where('id', $cash_balance_id);
            $this->db->update('cash_balance');
            if ($this->db->affected_rows() === 0) {
                error_log("Error: cash_balance ID ({$cash_balance_id}) not found for update.");
            }
        }
        return $deposit_insert_result;
    }

    public function update($id, $data)
    {
        $data['created_by'] = $this->session->userdata('user_id');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
