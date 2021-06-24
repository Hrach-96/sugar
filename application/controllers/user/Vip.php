<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vip extends CI_Controller {

    function __construct() {
        parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }
    
    public function index() {
        $this->load->helper('cookie');
        $data = array();
        $this->load->model(['member_feature_model','user_model', 'vip_package_model']);

        $user_gender = $this->session->userdata('user_gender');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $user_id = $this->session->userdata('user_id');
        $userInfo = $this->user_model->get_active_user_information($user_id);
        $data["userInfo"] = $userInfo;
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data['member_features'] = $this->member_feature_model->get_active_feature_list($user_gender, 100, 0);
        $data['vip_packages'] = $this->vip_package_model->get_active_vip_package_list($user_gender, 4, 0);

        $this->load->view('user/vip/index', $data);
    }
    public function sendCreditEmail() {
        $this->load->model(['user_model','language_model', 'email_model', 'photo_model']);
        $user_id = $this->session->userdata('user_id');
        $userInfo = $this->user_model->get_active_user_information($user_id);
        if($userInfo['user_country'] == 'United Kingdom'){
            $this->lang->load('user_lang', 'english');
        }
        else{
            $this->lang->load('user_lang', $this->session->userdata('site_language'));
        }
        //
         $data['user_pic'] = base_url("images/avatar/".$userInfo['user_gender'].".png");
        $profile_pic = $this->photo_model->get_active_user_profile_pic($user_id);
        if($profile_pic) {
            $data['user_pic'] = base_url($profile_pic['photo_thumb_url']);
        }
        $data['user_pic'] = base_url("images/avatar/".$userInfo['user_gender'].".png");
        $data['user_name'] = $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];
        $data['email_template'] = 'email/vip_60_credits';
        $subject = $this->lang->line('vip_60_credits');
        $email_message = $this->load->view('templates/email/main', $data, true);
        $this->load->library('email');
        $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
        $this->email->set_mailtype("html");
        $this->email->to($userInfo['user_email']);
        $this->email->subject($subject);
        $this->email->message($email_message);
        var_dump($this->email->send(),'sent');die;
    }
    public function buyVIPVoucher($package_id) {
        $settings = $this->session->userdata('site_setting');
        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data["package_id"] = $package_id;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $this->load->view('payment/buy_vip_voucher', $data);
    }
    public function buyVIP($package_id) {
        $this->load->helper('cookie');
        $data = array();
        $voucher_code = '';
        if(isset($_GET['voucher_code'])){
            $voucher_code = $_GET['voucher_code'];
        }
        $this->load->model(['payment_gateway_model', 'vip_package_model', 'oppwa_payment_token_model', 'user_model', 'country_model','voucher_model']);

        $user_id = $this->session->userdata('user_id');
        // Get Package Info
        $package_info = $this->vip_package_model->get_vip_package_info($package_id);

        if(empty($package_info)) {
            $this->session->set_userdata('message', 'this_package_is_not_active_please_choose_another_package');
            redirect(base_url('user/vip'));
        }

        if($package_info['package_for'] != $this->session->userdata('user_gender')) {
            $this->session->set_userdata('message', 'this_package_is_not_active_please_choose_another_package');
            redirect(base_url('user/vip'));
        }

        if($this->session->userdata('user_is_vip') == 'yes') {
            $this->session->set_userdata('message', 'already_vip_member');
            redirect(base_url('user/vip'));
        }

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        // Use oppwa for Credit Card        
        $credentials = $this->payment_gateway_model->get_oppwa_credentials();
        if(empty($credentials)) {
            $this->session->set_userdata('message', 'oppwa_credential_not_found');
            redirect(base_url('user/vip'));
        }

        $config = array(
            'entityId' => $credentials['client_id'],
            'accessToken' => $credentials['client_acces_token'],
            'url' => $credentials['url'],
            'currency' => $credentials['currency']
        );

        $this->load->library('oppwa', $config);
        $package_total_amount = $package_info['package_total_amount'];
        $this->session->unset_userdata('used_voucher');
        $voucher_info;
        if($voucher_code != ''){
            $voucher_info = $this->voucher_model->getVoucherByCode($voucher_code);
            if(!is_null($voucher_info)){
                $this->session->set_userdata('used_voucher', $voucher_info->id);
                $package_total_amount = $package_total_amount - (($voucher_info->procent / 100) * $package_total_amount);
                $package_total_amount = number_format($package_total_amount, 2, '.', '');
            }
        }

        $checkout = json_decode($this->oppwa->prepareCheckout($package_total_amount));

        if(!isset($checkout->id)) {            
            $this->session->set_userdata('message', 'oppwa_credential_not_working');
            redirect(base_url('user/vip'));
        }

        $data['checkout_id'] = $checkout->id;
        $data['oppwa_url'] = $credentials['url'];
        $data['repsonse_url'] = base_url('user/vip/oppwaResponse');

        // Insert Oppwa Token
        $checkout_token_data = array(
            'token' => $checkout->id,
            'package_type' => 'vip',
            'package_id' => $package_id,
            'user_id' => $this->session->userdata('user_id'),
            'status' => 'pending',
            'token_added_date' => gmdate('Y-m-d H:i:s')
        );
        $this->oppwa_payment_token_model->insert_token($checkout_token_data);

        // User Information
        $data['user_info'] = $this->user_model->get_user_information_for_payment($user_id);
        $data['countries'] = $this->country_model->get_active_countries_list();
        $package_info['package_total_amount'] = $package_total_amount;
        $data['package'] = $package_info;
        $this->load->view('payment/buy_vip', $data);
    }
    public function oppwaResponse() {

        $this->load->model(['payment_gateway_model', 'oppwa_payment_token_model', 'vip_package_model', 'user_model', 'email_model', 'payment_transaction_model', 'credit_package_model','voucher_model']);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        var_dump('Please Use Stripe');die;
        if(!isset($_GET['id'])) {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect(base_url('user/vip'));
        }
        $checkout_id = $_GET['id'];
    
        // get token information
        $token_info = $this->oppwa_payment_token_model->get_token_info($checkout_id);
        if(empty($token_info)) {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect(base_url('user/vip'));
        }

        if($token_info['status'] != 'pending') {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect(base_url('user/vip'));
        }

        $credentials = $this->payment_gateway_model->get_oppwa_credentials();
        if(empty($credentials)) {
            $this->session->set_userdata('message', 'oppwa_credential_not_found');
            redirect(base_url('user/vip'));
        }

        // Get Package Info
        $package_info = $this->vip_package_model->get_vip_package_info($token_info['package_id']);

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
            $package_total_amount = $package_info['package_total_amount'];
            if(!is_null($this->session->userdata('used_voucher'))){
                $voucher_id = $this->session->userdata('used_voucher');
                $voucher_info = $this->voucher_model->getVoucherById($voucher_id);
                // Insert To Loc Table
                $data['user_id'] = $this->session->userdata('user_id');
                $data['voucher_id'] = $voucher_id;
                $data['package_type'] = 'vip';
                $data['package_id'] = $package_info['package_id'];
                $data['used_datetime'] = date("Y-m-d H:i:s");
                $this->voucher_model->addUsedTable($data);
                if(!is_null($voucher_info)){
                    $this->session->unset_userdata('used_voucher');
                    $this->session->set_userdata('voucher_used_code', $voucher_info->code);
                    $package_total_amount = $package_total_amount - (($voucher_info->procent / 100) * $package_total_amount);
                    $package_total_amount = number_format($package_total_amount, 2, '.', '');
                }
            }

            // Update token status as success
            $this->oppwa_payment_token_model->update_token_status($checkout_id, 'success');

            $this->db->trans_begin();
            // Store Transaction
            $transaction_data = array(
                'gateway_id_ref' => OPPWA_PAYMENT_GATEWAY,
                'txn_id' => $checkout_id,
                'payment_gross' => $package_total_amount,
                'currency' => $credentials['currency'],
                'txn_date' => gmdate('Y-m-d H:i:s'),
                'payment_status' => 'success'
            );
            $transaction_id = $this->payment_transaction_model->insert_transaction($transaction_data);

            // Activate package
            $buy_vip_package = array(
                'purchased_user_id' => $token_info['user_id'],
                'vip_package_id' => $package_info['package_id'],
                'vip_package_name' => $package_info['package_name'],
                'vip_package_diamonds' => $package_info['package_total_diamonds'],
                'vip_package_amount' => $package_total_amount,
                'package_validity_in_months' => $package_info['package_validity_total_months'],
                'package_activated_using' => 'amount',
                'transaction_id_ref' => $transaction_id,
                'buy_vip_date' => gmdate('Y-m-d H:i:s'),
                'buy_vip_flag' => 'web'
            );
            $buy_vip_id = $this->vip_package_model->insert_user_buy_vip($buy_vip_package);
            $buy_vip_registration_array = array(
                'buy_vip_id' => $buy_vip_id,
                'registration_id' => $payment_status->registrationId,
            );
            $this->vip_package_model->insert_user_buy_vip_registration($buy_vip_registration_array);

            $this->user_model->update_user($token_info['user_id'], array('user_is_vip' => 'yes','buy_vip_id_num'=> $buy_vip_id));
            
            //
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_userdata('message', 'internal_server_error');
            } else {
                $this->db->trans_commit();           
                $user_current_credits = $this->session->userdata('user_credits');
                $this->session->set_userdata('user_credits', $user_current_credits);
                $this->session->set_userdata('user_is_vip', 'yes');
                $this->session->set_userdata('message', 'your_vip_package_has_been_activated_successfully');
                $this->session->set_userdata('webgain_script', true);
                $this->session->set_userdata('package_amount', $package_total_amount);

                $user_info = $this->user_model->get_user_information_for_payment($token_info['user_id']);

                // Send VIP Memebership Purchased Email to User
                $to_email = $this->session->userdata('user_email');
                $subject = $this->lang->line('vip_memebership_purchased');
                $data['user_name'] = $this->session->userdata('user_username');
                $data['user_profile_pic'] = base_url($this->session->userdata('user_avatar'));
                $data['package_duration'] = $package_info['package_validity_total_months'];
                $data['purchase_amount'] = $package_total_amount;
                $data['package_expire_date'] = convert_date_to_local(date('Y-m-d', strtotime('+'.$package_info['package_validity_total_months'].' months')), 'd.m.Y');

                $data['first_name'] = $user_info['user_firstname'];
                $data['last_name'] = $user_info['user_lastname'];
                $data['street_or_no'] = $user_info['user_street'];
                $data['location'] = $user_info['user_city'];
                $data['country'] = $user_info['user_country'];
                $data['email'] = $user_info['user_email'];
                $data['telephone'] = $user_info['user_telephone'];
                $data['payment_mode'] = 'Credit Card';

                $data['email_template'] = 'email/vip_membership_purchased';
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

                $vip_invoice_html = $this->load->view('email/vip_invoice_pdf', $data, true);
                $pdf->writeHTML($vip_invoice_html, true, false, true, false, '');

                $filename = $transaction_id."_vip_purchase.pdf";
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
        redirect(base_url('user/vip'));
    }

    public function buyUsingDiamonds() {
        $this->load->model(['vip_package_model', 'user_model', 'diamond_package_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('vip_package_id', 'vip_package_id', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('message', 'unauthorized_access');
        } else {
            if($this->session->userdata('user_is_vip') == 'no') {
                $package_id = $this->input->post('vip_package_id');
                $user_id = $this->session->userdata('user_id');

                $package_info = $this->vip_package_model->get_active_package_info($package_id);
                if($package_info) {                    

                    if($package_info['package_total_diamonds'] <=  $this->session->userdata('user_diamonds')) {
                        $used_diamonds = array(
                            'diamonds_used_by' => $user_id,
                            'total_diamonds_used' => $package_info['package_total_diamonds'],
                            'diamonds_used_for' => 'buy_vip',
                            'diamonds_used_date' => gmdate('Y-m-d H:i:s'),
                            'diamonds_used_flag' => 'web'
                        );

                        $this->db->trans_begin();
                        $transaction_id = $this->diamond_package_model->insert_user_diamonds_used($used_diamonds);

                        $buy_vip_package = array(
                            'purchased_user_id' => $user_id,
                            'vip_package_id' => $package_info['package_id'],
                            'vip_package_name' => $package_info['package_name'],
                            'vip_package_diamonds' => $package_info['package_total_diamonds'],
                            'vip_package_amount' => $package_info['package_total_amount'],
                            'package_validity_in_months' => $package_info['package_validity_total_months'],
                            'package_activated_using' => 'diamonds',
                            'transaction_id_ref' => $transaction_id,
                            'buy_vip_date' => gmdate('Y-m-d H:i:s'),
                            'buy_vip_flag' => 'web'
                        );
                        
                        $this->vip_package_model->insert_user_buy_vip($buy_vip_package);

                        $available_diamonds = $this->session->userdata('user_diamonds') - $package_info['package_total_diamonds'];
                        $this->user_model->update_user($user_id, array('user_is_vip' => 'yes', 'user_diamonds' => $available_diamonds));

                        if($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $this->session->set_userdata('message', 'internal_server_error');
                        } else {
                            $this->db->trans_commit();
                            $this->session->set_userdata('user_is_vip', 'yes');
                            $this->session->set_userdata('user_diamonds', $available_diamonds);
                            $this->session->set_userdata('message', 'your_vip_package_has_been_activated_successfully');
                        }
                    } else {
                        $this->session->set_userdata('message', 'your_diamonds_are_less_than_your_choosen_package');
                    }
                } else {
                    $this->session->set_userdata('message', 'this_package_is_not_active_please_choose_another_package');
                }
            } else {
                $this->session->set_userdata('message', 'already_vip_member');
            }
        }
        redirect(base_url('user/vip'));
    }    


}
