<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    public function get_offerings_report($service_ids = null)
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        // Base SQL query (without WHERE clause yet)
        $sql = "SELECT
            o.service_date,
            SUM(o.total_amount) AS total_amount,
            SUM(o.check_amount) AS check_amount,

            COUNT(CASE WHEN o.is_cheque = 1 AND o.cheque_rejected = 1 THEN 1 END) AS rejected_cheque_count,
            SUM(CASE WHEN o.is_cheque = 1 AND o.cheque_rejected = 1 THEN COALESCE(o.check_amount, 0) ELSE 0 END) AS rejected_cheque_amount,
            GROUP_CONCAT(CASE WHEN o.is_cheque = 1 AND o.cheque_rejected = 1
                            THEN CONCAT('₹', o.check_amount, ' (', o.check_no, ')')
                        END ORDER BY o.check_amount ASC SEPARATOR '\n') AS rejected_cheque_list,

            COUNT(CASE WHEN o.is_cheque = 1 AND o.cheque_rejected = 0 THEN 1 END) AS valid_cheque_count,
            SUM(CASE WHEN o.is_cheque = 1 AND o.cheque_rejected = 0 THEN COALESCE(o.check_amount, 0) ELSE 0 END) AS valid_cheque_amount,
            GROUP_CONCAT(CASE WHEN o.is_cheque = 1 AND o.cheque_rejected = 0
                            THEN CONCAT('₹', o.check_amount, ' (', o.check_no, ')')
                        END ORDER BY o.check_amount ASC SEPARATOR '\n') AS valid_cheque_list,

            SUM(o.grand_total) AS grand_total,
            d.id as deposit_id, d.notes, d.deposit_date, d.amount as deposit_amount, d.bank
        FROM offerings o
        left JOIN deposit_amount d ON o.service_date = d.service_date ";

        $where_conditions = [];

        // 1. Service ID Filter
        if (!empty($service_ids) && is_array($service_ids)) {
            // Use CodeIgniter's $this->db->escape_str for safer string formatting,
            // though array_map('intval', ...) is already quite safe for integers.
            $id_list = implode(',', array_map('intval', $service_ids));
            $where_conditions[] = "o.service_id IN ({$id_list})";
        }

        // 💡 ADDITION: Start Date Filter
        if (!empty($start_date)) {
            // Use $this->db->escape() for proper SQL escaping of the date string
            $escaped_start_date = $this->db->escape($start_date);
            $where_conditions[] = "o.service_date >= {$escaped_start_date}";
        }

        // 💡 ADDITION: End Date Filter
        if (!empty($end_date)) {
            // Use $this->db->escape() for proper SQL escaping of the date string
            $escaped_end_date = $this->db->escape($end_date);
            $where_conditions[] = "o.service_date <= {$escaped_end_date}";
        }

        // Construct the WHERE clause if conditions exist
        if (!empty($where_conditions)) {
            $sql .= " WHERE " . implode(' AND ', $where_conditions);
        }

        // Append GROUP BY and ORDER BY
        $sql .= " GROUP BY o.service_date ORDER BY o.service_date DESC";

        // You may remove the semicolon here as CI's query method handles it,
        // but it's fine to leave it.

        return $this->db->query($sql)->result_array();
    }

    public function upsert_deposit_full($data, $user_id)
    {
        $db_data = [
            'service_date' => $data['service_date'],
            'deposit_date' => $data['deposit_date'],
            'amount'       => $data['amount'],
            'bank'         => $data['bank'],
            'created_by'   => $user_id,
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        // Include the ID only if it exists
        if (!empty($data['id'])) {
            $db_data['id'] = $data['id'];
        } else {
            $db_data['created_at'] = date('Y-m-d H:i:s');
        }

        // replace() performs an automatic INSERT or UPDATE based on keys
        return $this->db->replace('deposit_amount', $db_data);
    }
}
