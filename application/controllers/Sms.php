<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sms extends CI_Controller
{
    private $sms_user   = 'BAPTIST_SMS';
    private $sms_pass   = '123456';
    private $sms_sender = 'BCSLGD';


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Offering_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data['service_dates'] = $this->Offering_model->get_last_30_days_service_dates();
        $data['page_content'] = 'sms/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }

    public function send_offering_sms()
    {
        $service_date = $this->input->post('service_date', TRUE);

        // === Validate date format ===
        if (!$service_date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $service_date)) {
            show_error('Invalid or missing service_date. Use format YYYY-MM-DD.', 400);
        }

        // === Validate within last month ===
        $serviceDateObj = new DateTime($service_date);
        $oneMonthAgo = new DateTime('-1 month');
        if ($serviceDateObj < $oneMonthAgo) {
            show_error('Date must be within the last 1 month.', 400);
        }

        // === Fetch offerings ===
        $offerings = $this->Offering_model->get_offerings_by_date($service_date);
        if (empty($offerings)) {
            echo "No offerings found for {$service_date}.";
            return;
        }
        // echo "<pre>";
        // print_r($offerings);
        // die('test -- test');

        $i = 1;
        foreach ($offerings as $row) {
            $name      = $row['full_name'];
            $phone     = $row['phone'];
            $amount    = number_format($row['total_amount'], 2); // 1,000.00
            $date_fmt  = date('d-m-Y', strtotime($row['service_date']));
            $offering_ids = $row['offering_ids'];
            $user_id = $row['user_id'];
            $offering_type = $row['offering_type'];

            // === Prepare SMS text ===
            $text = "Dear {$name}, We are deeply thankful for your faithful {$offering_type} offering Rs:- {$amount}. "
                . "Your generosity is not just a financial blessing but also a reflection of your trust in God's provision "
                . "and your commitment to his work through our church {$date_fmt} (Treasurer) "
                . "Centenary Baptist Church South Lallaguda";

            $text_encoded = urlencode($text);

            $api_url = "http://bhashsms.com/api/sendmsg.php?"
                . "user={$this->sms_user}"
                . "&pass={$this->sms_pass}"
                . "&sender={$this->sms_sender}"
                . "&phone=" . urlencode($phone)
                . "&text={$text_encoded}"
                . "&priority=ndnd"
                . "&stype=normal";

            // === Send SMS ===
            $response = @file_get_contents($api_url);

            // === Update DB with response ===
            $this->Offering_model->log_message(
                $offering_ids,
                $user_id,
                $service_date,
                $phone,
                $text,           // original message text
                $response,        // API response
                $row['total_amount']
            );

            echo "$i) SMS sent to {$name} ({$phone}) - Response: {$response}<br>";
            $i++;
        }
    }
}
