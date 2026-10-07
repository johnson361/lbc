<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sms extends CI_Controller
{
    // private $sms_user   = 'BAPTIST_SMS';
    // private $sms_pass   = '123456';
    // private $sms_sender = 'BCSLGD';
    private $sms_pass   = '575393ARon901WEl6ab79f6dP1';
    private $template_id   = '6ab7a347b96dd2399d04b943';
    private $integrated_number = '919052158544';

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
        $data['sms_service_dates'] = $this->Offering_model->get_last_30_days_service_dates('SMS');
        $data['whatsapp_service_dates'] = $this->Offering_model->get_last_30_days_service_dates('WhatsApp');
        $data['page_content'] = 'sms/index';
        $this->load->view('layouts/navbar', $data);  // Navbar included here
        $this->load->view('layouts/main', $data);    // Main layout
    }

    // =========================================================================
    // PUBLIC CONTROLLER METHODS
    // =========================================================================

    public function send_offering_sms()
    {
        $service_date = $this->validate_service_date();

        $data = $this->prepare_offering_recipients($service_date, 'SMS', function ($row, $phone, $amount, $date_fmt) {
            return [
                'mobiles' => $phone,
                'var1'    => $row['full_name'],
                'var2'    => $row['offering_type'],
                'var3'    => $amount,
                'var4'    => $date_fmt
            ];
        });

        if (!$data) return;

        $payload = [
            'template_id' => $this->template_id,
            'recipients'  => $data['recipients']
        ];

        $response = $this->send_msg91_request(
            "https://control.msg91.com/api/v5/flow",
            $payload
        );

        $this->log_and_render_results($data['logs'], $service_date, $response, 'SMS');
    }

    public function send_offering_whatsapp()
    {
        $service_date = $this->validate_service_date();

        $data = $this->prepare_offering_recipients($service_date, 'WhatsApp', function ($row, $phone, $amount, $date_fmt) {
            return [
                'to' => [$phone],
                'components' => [
                    'body_var_1' => ['type' => 'text', 'value' => $row['full_name'], 'parameter_name' => 'var_1'],
                    'body_var_2' => ['type' => 'text', 'value' => $row['offering_type'], 'parameter_name' => 'var_2'],
                    'body_var_3' => ['type' => 'text', 'value' => $amount, 'parameter_name' => 'var_3'],
                    'body_var_4' => ['type' => 'text', 'value' => $date_fmt, 'parameter_name' => 'var_4']
                ]
            ];
        });

        if (!$data) return;

        $payload = [
            'integrated_number' => $this->integrated_number,
            'content_type'      => 'template',
            'payload'           => [
                'messaging_product' => 'whatsapp',
                'type'              => 'template',
                'template'          => [
                    'name'              => 'tithe_and_thanks',
                    'language'          => ['code' => 'en', 'policy' => 'deterministic'],
                    'namespace'         => 'eca6ad4c_549b_4934_bfc4_1772820f0552',
                    'to_and_components' => $data['recipients']
                ]
            ]
        ];

        $response = $this->send_msg91_request(
            "https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/",
            $payload
        );

        $this->log_and_render_results($data['logs'], $service_date, $response, 'WhatsApp');
    }

// =========================================================================
// PRIVATE HELPER METHODS
// =========================================================================

    /**
     * Validates post date format and 1-month threshold.
     */
    private function validate_service_date()
    {
        $service_date = $this->input->post('service_date', TRUE);

        if (!$service_date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $service_date)) {
            show_error('Invalid or missing service_date. Use format YYYY-MM-DD.', 400);
        }

        $serviceDateObj = new DateTime($service_date);
        $oneMonthAgo    = new DateTime('-1 month');

        if ($serviceDateObj < $oneMonthAgo) {
            show_error('Date must be within the last 1 month.', 400);
        }

        return $service_date;
    }

    /**
     * Normalizes phone numbers to standard 12-digit Indian MSISDN with '91' prefix.
     */
    private function format_phone_number($phone)
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        return (strlen($cleaned) === 10) ? '91' . $cleaned : $cleaned;
    }

    /**
     * Fetches offerings and maps data for payload structure and log arrays.
     */
    private function prepare_offering_recipients($service_date, $channel_label, callable $recipient_formatter)
    {
        $offerings = $this->Offering_model->get_offerings_by_date($service_date, $channel_label);

        if (empty($offerings)) {
            show_error("No offerings found for {$service_date}.", 404);
            return null;
        }

        $recipients = [];
        $logs = [];

        foreach ($offerings as $row) {
            $phone    = $this->format_phone_number($row['phone']);
            $amount   = number_format($row['total_amount'], 2);
            $date_fmt = date('d-m-Y', strtotime($row['service_date']));
            $name     = $row['full_name'];
            $type     = $row['offering_type'];

            $recipients[] = $recipient_formatter($row, $phone, $amount, $date_fmt);

            $logs[] = [
                'offering_ids' => $row['offering_ids'],
                'user_id'      => $row['user_id'],
                'phone'        => $phone,
                'name'         => $name,
                'total_amount' => $row['total_amount'],
                'message_text' => "Name: {$name}, Type: {$type}, Amount: {$amount}, Date: {$date_fmt}"
            ];
        }

        return [
            'recipients' => $recipients,
            'logs'       => $logs
        ];
    }

    /**
     * Standardized cURL runner for MSG91 endpoints.
     */
    private function send_msg91_request($url, array $payload)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                "Content-Type: application/json",
                "accept: application/json",
                "authkey: " . $this->sms_pass
            ],
        ]);

        $response = curl_exec($curl);
        $err      = curl_error($curl);
        curl_close($curl);

        return $err ? "cURL Error #: " . $err : $response;
    }

    /**
     * Handles database logging and response output.
     */
    private function log_and_render_results(array $logs, $service_date, $api_response, $channel_label)
    {
        foreach ($logs as $i => $log) {
            $this->Offering_model->log_message(
                $log['offering_ids'],
                $log['user_id'],
                $service_date,
                $log['phone'],
                $log['message_text'],
                $api_response,
                $log['total_amount'],
                $channel_label
            );

            $index = $i + 1;
            echo "{$index}) {$channel_label} request processed for {$log['name']} ({$log['phone']}) - Response: {$api_response}<br>";
        }
    }

    // public function send_offering_sms()
    // {
    //     $service_date = $this->input->post('service_date', TRUE);

    //     // === Validate date format ===
    //     if (!$service_date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $service_date)) {
    //         show_error('Invalid or missing service_date. Use format YYYY-MM-DD.', 400);
    //     }

    //     // === Validate within last month ===
    //     $serviceDateObj = new DateTime($service_date);
    //     $oneMonthAgo = new DateTime('-1 month');
    //     if ($serviceDateObj < $oneMonthAgo) {
    //         show_error('Date must be within the last 1 month.', 400);
    //     }

    //     // === Fetch offerings ===
    //     $offerings = $this->Offering_model->get_offerings_by_date($service_date);
    //     if (empty($offerings)) {
    //         echo "No offerings found for {$service_date}.";
    //         return;
    //     }
    //     // echo "<pre>";
    //     // print_r($offerings);
    //     // die('test -- test');

    //     $i = 1;
    //     foreach ($offerings as $row) {
    //         $name      = $row['full_name'];
    //         $phone     = $row['phone'];
    //         $amount    = number_format($row['total_amount'], 2); // 1,000.00
    //         $date_fmt  = date('d-m-Y', strtotime($row['service_date']));
    //         $offering_ids = $row['offering_ids'];
    //         $user_id = $row['user_id'];
    //         $offering_type = $row['offering_type'];

    //         // === Prepare SMS text ===
    //         $text = "Dear {$name}, We are deeply thankful for your faithful {$offering_type} offering Rs:- {$amount}. "
    //             . "Your generosity is not just a financial blessing but also a reflection of your trust in God's provision "
    //             . "and your commitment to his work through our church {$date_fmt} (Treasurer) "
    //             . "Centenary Baptist Church South Lallaguda";

    //         $text_encoded = urlencode($text);

    //         $api_url = "http://bhashsms.com/api/sendmsg.php?"
    //             . "user={$this->sms_user}"
    //             . "&pass={$this->sms_pass}"
    //             . "&sender={$this->sms_sender}"
    //             . "&phone=" . urlencode($phone)
    //             . "&text={$text_encoded}"
    //             . "&priority=ndnd"
    //             . "&stype=normal";

    //         // === Send SMS ===
    //         $response = @file_get_contents($api_url);

    //         // === Update DB with response ===
    //         $this->Offering_model->log_message(
    //             $offering_ids,
    //             $user_id,
    //             $service_date,
    //             $phone,
    //             $text,           // original message text
    //             $response,        // API response
    //             $row['total_amount']
    //         );

    //         echo "$i) SMS sent to {$name} ({$phone}) - Response: {$response}<br>";
    //         $i++;
    //     }
    // }


    // public function send_offering_sms()
    // {
    //     $service_date = $this->input->post('service_date', TRUE);

    //     // === Validate date format ===
    //     if (!$service_date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $service_date)) {
    //         show_error('Invalid or missing service_date. Use format YYYY-MM-DD.', 400);
    //     }

    //     // === Validate within last month ===
    //     $serviceDateObj = new DateTime($service_date);
    //     $oneMonthAgo = new DateTime('-1 month');
    //     if ($serviceDateObj < $oneMonthAgo) {
    //         show_error('Date must be within the last 1 month.', 400);
    //     }

    //     // === Fetch offerings ===
    //     $offerings = $this->Offering_model->get_offerings_by_date($service_date);
    //     if (empty($offerings)) {
    //         echo "No offerings found for {$service_date}.";
    //         return;
    //     }

    //     // === Build MSG91 Recipients Array ===
    //     $recipients = [];
    //     $logs_data = [];

    //     foreach ($offerings as $row) {
    //         $name          = $row['full_name'];
    //         $phone         = preg_replace('/[^0-9]/', '', $row['phone']); // Clean non-digits

    //         // Ensure standard 10-digit Indian numbers get country code prefix '91'
    //         if (strlen($phone) === 10) {
    //             $phone = '91' . $phone;
    //         }

    //         $amount        = number_format($row['total_amount'], 2);
    //         $date_fmt      = date('d-m-Y', strtotime($row['service_date']));
    //         $offering_type = $row['offering_type'];

    //         // Add to MSG91 payload recipients list
    //         $recipients[] = [
    //             'mobiles' => $phone,
    //             'var1'    => $name,
    //             'var2'    => $offering_type,
    //             'var3'    => $amount,
    //             'var4'    => $date_fmt
    //         ];

    //         // Store reference data for database logging
    //         $logs_data[] = [
    //             'offering_ids' => $row['offering_ids'],
    //             'user_id'      => $row['user_id'],
    //             'phone'        => $phone,
    //             'name'         => $name,
    //             'total_amount' => $row['total_amount'],
    //             'message_text' => "Name: {$name}, Type: {$offering_type}, Amount: {$amount}, Date: {$date_fmt}"
    //         ];
    //     }

    //     // === Prepare Payload for MSG91 Flow API ===
    //     $payload = [
    //         'template_id' => $this->template_id,
    //         'recipients'  => $recipients
    //     ];

    //     // === Execute MSG91 cURL Request ===
    //     $curl = curl_init();

    //     curl_setopt_array($curl, [
    //         CURLOPT_URL            => "https://control.msg91.com/api/v5/flow",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING       => "",
    //         CURLOPT_MAXREDIRS      => 10,
    //         CURLOPT_TIMEOUT        => 30,
    //         CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST  => "POST",
    //         CURLOPT_POSTFIELDS     => json_encode($payload),
    //         CURLOPT_HTTPHEADER     => [
    //             "accept: application/json",
    //             "authkey: " . $this->sms_pass, // Replace with your MSG91 Authkey variable if different
    //             "content-type: application/json"
    //         ],
    //     ]);

    //     $response = curl_exec($curl);
    //     $err      = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         $api_response = "cURL Error #: " . $err;
    //         echo $api_response;
    //     } else {
    //         $api_response = $response;
    //     }

    //     // === Log execution to DB & Output Results ===
    //     $i = 1;
    //     foreach ($logs_data as $log) {
    //         $this->Offering_model->log_message(
    //             $log['offering_ids'],
    //             $log['user_id'],
    //             $service_date,
    //             $log['phone'],
    //             $log['message_text'],
    //             $api_response,
    //             $log['total_amount']
    //         );

    //         echo "{$i}) SMS request processed for {$log['name']} ({$log['phone']}) - Response: {$api_response}<br>";
    //         $i++;
    //     }
    // }

    // public function send_offering_whatsapp()
    // {
    //     $service_date = $this->input->post('service_date', TRUE);

    //     // === Validate date format ===
    //     if (!$service_date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $service_date)) {
    //         show_error('Invalid or missing service_date. Use format YYYY-MM-DD.', 400);
    //     }

    //     // === Validate within last month ===
    //     $serviceDateObj = new DateTime($service_date);
    //     $oneMonthAgo = new DateTime('-1 month');
    //     if ($serviceDateObj < $oneMonthAgo) {
    //         show_error('Date must be within the last 1 month.', 400);
    //     }

    //     // === Fetch offerings ===
    //     $offerings = $this->Offering_model->get_offerings_by_date($service_date);
    //     if (empty($offerings)) {
    //         echo "No offerings found for {$service_date}.";
    //         return;
    //     }

    //     // === Build MSG91 WhatsApp Outbound Bulk Payload ===
    //     $to_and_components = [];
    //     $logs_data = [];

    //     foreach ($offerings as $row) {
    //         $name          = $row['full_name'];
    //         $phone         = preg_replace('/[^0-9]/', '', $row['phone']); // Clean non-digits

    //         // Ensure standard 10-digit Indian numbers get country code prefix '91'
    //         if (strlen($phone) === 10) {
    //             $phone = '91' . $phone;
    //         }

    //         $amount        = number_format($row['total_amount'], 2);
    //         $date_fmt      = date('d-m-Y', strtotime($row['service_date']));
    //         $offering_type = $row['offering_type'];

    //         // Construct recipient component mapping for MSG91 WhatsApp
    //         $to_and_components[] = [
    //             'to' => [$phone],
    //             'components' => [
    //                 'body_var_1' => [
    //                     'type' => 'text',
    //                     'value' => $name,
    //                     'parameter_name' => 'var_1'
    //                 ],
    //                 'body_var_2' => [
    //                     'type' => 'text',
    //                     'value' => $offering_type,
    //                     'parameter_name' => 'var_2'
    //                 ],
    //                 'body_var_3' => [
    //                     'type' => 'text',
    //                     'value' => $amount,
    //                     'parameter_name' => 'var_3'
    //                 ],
    //                 'body_var_4' => [
    //                     'type' => 'text',
    //                     'value' => $date_fmt,
    //                     'parameter_name' => 'var_4'
    //                 ]
    //             ]
    //         ];

    //         // Store reference data for database logging
    //         $logs_data[] = [
    //             'offering_ids' => $row['offering_ids'],
    //             'user_id'      => $row['user_id'],
    //             'phone'        => $phone,
    //             'name'         => $name,
    //             'total_amount' => $row['total_amount'],
    //             'message_text' => "Name: {$name}, Type: {$offering_type}, Amount: {$amount}, Date: {$date_fmt}"
    //         ];
    //     }

    //     $payload = [
    //         'integrated_number' => $this->integrated_number,
    //         'content_type'      => 'template',
    //         'payload'           => [
    //             'messaging_product' => 'whatsapp',
    //             'type'              => 'template',
    //             'template'          => [
    //                 'name'              => 'tithe_and_thanks',
    //                 'language'          => [
    //                     'code'   => 'en',
    //                     'policy' => 'deterministic'
    //                 ],
    //                 'namespace'         => 'eca6ad4c_549b_4934_bfc4_1772820f0552',
    //                 'to_and_components' => $to_and_components
    //             ]
    //         ]
    //     ];

    //     // === Execute MSG91 cURL Request ===
    //     $curl = curl_init();

    //     curl_setopt_array($curl, [
    //         CURLOPT_URL            => "https://api.msg91.com/api/v5/whatsapp/whatsapp-outbound-message/bulk/",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING       => "",
    //         CURLOPT_MAXREDIRS      => 10,
    //         CURLOPT_TIMEOUT        => 30,
    //         CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST  => "POST",
    //         CURLOPT_POSTFIELDS     => json_encode($payload),
    //         CURLOPT_HTTPHEADER     => [
    //             "Content-Type: application/json",
    //             "authkey: " . $this->sms_pass
    //         ],
    //     ]);

    //     $response = curl_exec($curl);
    //     $err      = curl_error($curl);

    //     curl_close($curl);

    //     if ($err) {
    //         $api_response = "cURL Error #: " . $err;
    //         echo $api_response;
    //     } else {
    //         $api_response = $response;
    //     }

    //     // === Log execution to DB & Output Results ===
    //     $i = 1;
    //     foreach ($logs_data as $log) {
    //         $this->Offering_model->log_message(
    //             $log['offering_ids'],
    //             $log['user_id'],
    //             $service_date,
    //             $log['phone'],
    //             $log['message_text'],
    //             $api_response,
    //             $log['total_amount']
    //         );

    //         echo "{$i}) WhatsApp request processed for {$log['name']} ({$log['phone']}) - Response: {$api_response}<br>";
    //         $i++;
    //     }
    // }
}
