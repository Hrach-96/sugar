<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credits extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

    public function index() {
        $data = array();
        $this->load->model(['credit_package_model']);

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data['credit_packages'] = $this->credit_package_model->get_active_credit_package_list(4, 0);

        $credit_coin_img_arr = array(
            "images/Gold-Coin-2.png",
            "images/Gold-Coin-2-copia-3.png",
            "images/Gold-Coin-2-copia-32.png",
            "images/Gold-Coin-2-copia-33.png"
        );
        $data['coin_image'] = $credit_coin_img_arr;
        $this->load->view('user/credits/view', $data);
    }

    public function buyCredit($package_id) {
        $data = array();
        $this->load->model(['payment_gateway_model', 'credit_package_model', 'oppwa_payment_token_model', 'user_model']);

        $user_id = $this->session->userdata('user_id');
        // Get Package Info
        $package_info = $this->credit_package_model->get_credit_package_info($package_id);

        if(empty($package_info)) {
            $this->session->set_userdata('message', 'this_package_is_not_active_please_choose_another_package');
            redirect(base_url('buy/credit'));
        }

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;        
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        // Use oppwa for Credit Card
        $credentials = $this->payment_gateway_model->get_oppwa_credentials();
        if(empty($credentials)) {
            $this->session->set_userdata('message', 'oppwa_credential_not_found');
            redirect(base_url('buy/credit'));
        }

        $config = array(
            'entityId' => $credentials['client_id'],
            'accessToken' => $credentials['client_acces_token'],
            'url' => $credentials['url'],
            'currency' => $credentials['currency']
        );

        $this->load->library('oppwa', $config);
        $checkout = json_decode($this->oppwa->prepareCheckout($package_info['package_amount']));

        if(!isset($checkout->id)) {            
            $this->session->set_userdata('message', 'oppwa_credential_not_working');
            redirect(base_url('buy/credit'));
        }

        $data['checkout_id'] = $checkout->id;
        $data['oppwa_url'] = $credentials['url'];
        $data['repsonse_url'] = base_url('user/credits/oppwaResponse');

        // Insert Oppwa Token
        $checkout_token_data = array(
            'token' => $checkout->id,
            'package_type' => 'credit',
            'package_id' => $package_id,
            'user_id' => $user_id,
            'status' => 'pending',
            'token_added_date' => gmdate('Y-m-d H:i:s')
        );
        $this->oppwa_payment_token_model->insert_token($checkout_token_data);

        // User Information
        $data['user_info'] = $this->user_model->get_user_information_for_payment($user_id);
        $data['countries'] = $this->country_model->get_active_countries_list();

        $data['package'] = $package_info;
        $this->load->view('payment/buy_credit', $data);
    }

    public function oppwaResponse() {
        $this->load->model(['payment_gateway_model', 'credit_package_model', 'oppwa_payment_token_model', 'user_model', 'email_model', 'payment_transaction_model']);
        
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        if(!isset($_GET['id'])) {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect(base_url('buy/credit'));
        }
        $checkout_id = $_GET['id'];
    
        // get token information
        $token_info = $this->oppwa_payment_token_model->get_token_info($checkout_id);
        if(empty($token_info)) {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect(base_url('buy/credit'));
        }

        if($token_info['status'] != 'pending') {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect(base_url('buy/credit'));
        }

        $credentials = $this->payment_gateway_model->get_oppwa_credentials();
        if(empty($credentials)) {
            $this->session->set_userdata('message', 'oppwa_credential_not_found');
            redirect(base_url('buy/credit'));
        }

        // Get Package Info
        $package_info = $this->credit_package_model->get_credit_package_info($token_info['package_id']);

        // Get Payment Status
        $config = array(
            'entityId' => $credentials['client_id'],
            'accessToken' => $credentials['client_acces_token'],
            'url' => $credentials['url'],
            'currency' => $credentials['currency']
        );
        $this->load->library('oppwa', $config);
        $payment_status = json_decode($this->oppwa->paymentStatus($checkout_id));

        if($credentials['mode'] == 'test') {
            $payment_success_code = OPPWA_PAYMENT_SUCCESS_CODE_TEST;
        } else {
            $payment_success_code = OPPWA_PAYMENT_SUCCESS_CODE_LIVE;
        }
        if(isset($payment_status->result->code) && $payment_status->result->code == $payment_success_code) {

            // Update token status as success
            $this->oppwa_payment_token_model->update_token_status($checkout_id, 'success');

            $this->db->trans_begin();
            // Store Transaction
            $transaction_data = array(
                'gateway_id_ref' => OPPWA_PAYMENT_GATEWAY,
                'txn_id' => $checkout_id,
                'payment_gross' => $package_info['package_amount'],
                'currency' => $credentials['currency'],
                'txn_date' => gmdate('Y-m-d H:i:s'),
                'payment_status' => 'success'
            );
            $transaction_id = $this->payment_transaction_model->insert_transaction($transaction_data);

            // Add Credits
            $user_current_credits = $this->session->userdata('user_credits');

            $buy_credit_package = array(
                'purchased_user_id' => $token_info['user_id'],
                'credit_package_id' => $package_info['package_id'],
                'credit_package_name' => $package_info['package_name'],
                'credit_package_credits' => $package_info['package_credits'],
                'credit_package_amount' => $package_info['package_amount'],
                'transaction_id_ref' => $transaction_id,
                'buy_credit_date' => gmdate('Y-m-d H:i:s'),
                'buy_credit_flag' => 'web'
            );

            $this->credit_package_model->insert_user_buy_credits($buy_credit_package);
            $user_current_credits = $user_current_credits + $package_info['package_credits'];
            $this->user_model->update_user_credits($token_info['user_id'], $user_current_credits);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_userdata('message', 'internal_server_error');
            } else {
                $this->db->trans_commit();
                $this->session->set_userdata('user_credits', $user_current_credits);
                $this->session->set_userdata('message', 'your_credits_has_been_credited_successfully_into_your_account');

                $user_info = $this->user_model->get_user_information_for_payment($token_info['user_id']);

                // Send Credits Purchased Email to User
                $to_email = $this->session->userdata('user_email');
                $subject = $this->lang->line('credits_purchased_successful');
                $data['user_name'] = $this->session->userdata('user_username');
                $data['user_profile_pic'] = base_url($this->session->userdata('user_avatar'));
                $data['purchased_credits'] = $package_info['package_credits'];
                $data['purchase_amount'] = $package_info['package_amount'];

                $data['first_name'] = $user_info['user_firstname'];
                $data['last_name'] = $user_info['user_lastname'];
                $data['street_or_no'] = $user_info['user_street'];
                $data['location'] = $user_info['user_city'];
                $data['country'] = $user_info['user_country'];
                $data['email'] = $user_info['user_email'];
                $data['telephone'] = $user_info['user_telephone'];
                $data['payment_mode'] = 'Credit Card';
                $data['email_template'] = 'email/credits_purchased';
                $email_message = $this->load->view('templates/email/main', $data, true);

                $this->load->library('tc_pdf');
                $pdf = $this->tc_pdf->pdf;
        
                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Sugarbabe deluxe');
                $pdf->SetTitle('Invoice');
                $pdf->SetSubject('Purchase Invoice');
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(0);
                $pdf->SetFooterMargin(0);
                // remove default footer
                $pdf->setPrintFooter(false);
                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // add a page
                $pdf->AddPage();
                $bMargin = $pdf->getBreakMargin();
                $auto_page_break = $pdf->getAutoPageBreak();
                $pdf->SetAutoPageBreak(false, 0);
                $img_file = base_url('images/Letterhead_v2.jpg');
                $pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
                $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
                $pdf->setPageMark();

                $credit_invoice_html = $this->load->view('email/credit_invoice_pdf', $data, true);
                $pdf->writeHTML($credit_invoice_html, true, false, true, false, '');

                $filename = $transaction_id."_credit_purchase.pdf";
                $attachment = "./uploads/invoice/".$filename;
                $attachment_file = getcwd()."/uploads/invoice/".$filename;
                $pdf->Output($attachment_file, 'F');

                @$this->email_model->sendEMail($to_email, $subject, $email_message, $attachment);
            }
        } else {
            // Updated checkout token status as failed
            $this->oppwa_payment_token_model->update_token_status($checkout_id, 'failed');
            $this->session->set_userdata('message', 'internal_server_error');
        }
        redirect(base_url('buy/credit'));
    }

}
