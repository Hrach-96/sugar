<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function index() {
        $this->rankAllUsers();
    }

    function freeVIPCredits() {
        
        $this->load->model(['vip_package_model', 'credit_package_model', 'user_model', 'email_model', 'photo_model']);
        $this->lang->load('user_lang', DEFAULT_LANGUAGE);

        $users = $this->vip_package_model->get_user_buy_plans_for_free_credit();        

        if(!empty($users)) {
            // Get Free VIP Credits Package Info
            $package_info = $this->credit_package_model->get_free_credit_package_info();

            if($package_info) {
                foreach ($users as $urow) {

                    // Add 60 Free Credits
                    $user_info = $this->user_model->get_user_information($urow['purchased_user_id']);
                    $buy_credit_package = array(
                        'purchased_user_id'     => $urow['purchased_user_id'],
                        'credit_package_id'     => $package_info['package_id'],
                        'credit_package_name'   => 'VIP 60 free credits',
                        'credit_package_credits' => $package_info['package_credits'],
                        'credit_package_amount' => $package_info['package_amount'],
                        'buy_credit_date'       => gmdate('Y-m-d H:i:s'),
                        'buy_credit_flag'       => 'web'
                    );
                    if($user_info['user_country'] == 'United Kingdom'){
                        $this->lang->load('user_lang', 'english');
                    }
                    $this->db->trans_begin();
                    $this->credit_package_model->insert_user_buy_credits($buy_credit_package);

                    $user_current_credits = $user_info['user_credits'] + $package_info['package_credits'];
                    $this->user_model->update_user_credits($urow['purchased_user_id'], $user_current_credits);

                    // Send Email for 60 credits
                    $data['user_pic'] = base_url("images/avatar/".$user_info['user_gender'].".png");
                    $profile_pic = $this->photo_model->get_active_user_profile_pic($urow['purchased_user_id']);
                    if($profile_pic) {
                        $data['user_pic'] = base_url($profile_pic['photo_thumb_url']);
                    }

                    $data['user_name'] = $user_info['user_firstname'] . " " . $user_info['user_lastname'];
                    $data['email_template'] = 'email/vip_60_credits';
                    $subject = $this->lang->line('vip_60_credits');
                    $email_message = $this->load->view('templates/email/main', $data, true);
                    $this->load->library('email');
                    $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
                    $this->email->set_mailtype("html");
                    $this->email->to($user_info['user_email']);
                    $this->email->subject($subject);
                    $this->email->message($email_message);
                    $this->email->send();
                    // Check already given credits or not

                    if($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                        // Send Email for For credits
                        $to_email = $user_info['user_email'];
                        // if(!empty($to_email)) {
                        //     $subject = $this->lang->line('free_credits_recived');
                        //     $data['user_name'] = $user_info['user_access_name'];

                        //     $data['user_profile_pic'] = base_url($user_info['user_active_photo_thumb']);
                        //     if(empty($user_info['user_active_photo_thumb'])) {
                        //         $data['user_profile_pic'] = "images/avatar/".$user_info['user_gender'].".png";
                        //     }
                        //     $data['free_credits'] = $package_info['package_credits'];

                        //     $data['email_template'] = 'email/free_credits_received';
                        //     $email_message = $this->load->view('templates/email/main', $data, true);
                        //     @$this->email_model->sendEMail($to_email, $subject, $email_message);
                        // }
                    }
                }
            } else {
                echo "No free package found";
            }
        }
        echo "Free VIP CREDITS: Cron Job Success";
    }
    function automaticallyRenewSubscriptionsVipGift() {
        $this->load->model(['vip_package_model','user_model','gift_model']);
        $vip_users_of_stripe = $this->gift_model->get_gift_vip_users();
        foreach($vip_users_of_stripe as $key=>$value){
            $date_of_buy = strtotime(explode(' ',$value['added_date'])[0]);
            $final_date = new DateTime(date("Y-m-d", strtotime("+" . preg_replace('/[^0-9]/', '', $value['name']) . " month", $date_of_buy)));
            $final_date_format = $final_date->format('Y-m-d');
            $days_limit = round((strtotime(date("Y-m-d")) - strtotime($final_date_format)) / (60 * 60 * 24));
            if($days_limit == 0){
                $this->user_model->update_user($value['user_id'], array('user_is_vip' => 'no'));
            }
        }
        return true;
    }
    function automaticallyRenewSubscriptionsVipStripe() {
        die;
        $this->load->model(['vip_package_model','user_model', 'email_model']);
        $vip_users_of_stripe = $this->vip_package_model->getStripeSubscribers();
        if($vip_users_of_stripe > 0){
            foreach($vip_users_of_stripe as $key=>$vip_user ){
                $date_of_buy = strtotime(explode(' ',$vip_user['buy_vip_date'])[0]);
                $final_date = new DateTime(date("Y-m-d", strtotime("+" . $vip_user['package_validity_in_months'] . " month", $date_of_buy)));
                $final_date_format = $final_date->format('Y-m-d');
                $days_limit = round((strtotime(date("Y-m-d")) - strtotime($final_date_format)) / (60 * 60 * 24));
                if($days_limit == 0){
                    $userInfo = $this->user_model->get_user_information($vip_user['purchased_user_id']);
                    $canceled_date = $this->user_model->get_cancell_info_by_buy_id($vip_user['buy_vip_id']);
                    $continue_process = true;
                    if($canceled_date){
                        $cancelled_datetime = date_create($canceled_date->canceled_date);
                        $buyed_datetime = date_create($vip_user['buy_vip_date']);
                        $diff = date_diff($buyed_datetime,$cancelled_datetime);
                        if($diff->format("%a") < 14){ //is equal <= 14
                            // $continue_process = false;
                        }
                        $days = round((strtotime($final_date_format) - strtotime($canceled_date->canceled_date)) / (60 * 60 * 24));
                        if($days >= 7 || $days <= 0){
                            $continue_process = false;
                        }
                        if($days == 7){
                            if($userInfo['user_is_vip'] == 'yes'){
                                $this->sendExpireNotificationEmail($vip_user['purchased_user_id'] , 'Uw abonnement is verlopen, wordt automatisch verlengd');
                            }
                        }
                    }
                    if($continue_process){
                        $data_update = [
                            'repeated' => 1
                        ];
                        $this->vip_package_model->update_user_buy_vip($data_update,$vip_user['buy_vip_id']);
                        $this->addUserSuccessVip($vip_user);
                    }
                }

            }
         
        }
    }
    function addUserSuccessVip($vip_user) {
        $this->lang->load('user_lang', 'german');
        $this->load->library('email');
        $this->load->model(['vip_package_model','payment_transaction_model','user_model', 'email_model']);
        $userInfo = $this->user_model->get_user_information($vip_user['purchased_user_id']);

        $user_id = $vip_user['purchased_user_id'];
        $package_total_amount = $vip_user['vip_package_amount'];
        $balance_transaction = $vip_user['payment_stripe_id'];
        $transaction_data = array(
                'user_id' => $user_id,
                'amount' => $package_total_amount,
                'currency' => $vip_user['currency'],
                'created_date' => gmdate('Y-m-d H:i:s'),
                'payment_status' => 'success',
                'type' => 'vip',
                'balance_transaction' => $balance_transaction,
                'payment_id' => $balance_transaction
            );
            $transaction_id = $this->payment_transaction_model->insert_transaction_stripe($transaction_data);

             // Activate package
            $buy_vip_package = array(
                'purchased_user_id' => $user_id,
                'vip_package_id' => $vip_user['vip_package_id'],
                'vip_package_name' => $vip_user['vip_package_name'],
                'vip_package_diamonds' => $vip_user['vip_package_diamonds'],
                'vip_package_amount' => $vip_user['vip_package_amount'],
                'package_validity_in_months' => $vip_user['package_validity_in_months'],
                'package_activated_using' => $vip_user['package_activated_using'],
                'transaction_id_ref' => '',
                'currency' => $vip_user['currency'],
                'buy_vip_date' => gmdate('Y-m-d H:i:s'),
                'payment_stripe_id' => $vip_user['payment_stripe_id'],
                'buy_vip_flag' => 'web'
            );
            $buy_vip_id = $this->vip_package_model->insert_user_buy_vip($buy_vip_package);
            $user_current_credits = $userInfo['user_credits'];
            
            $this->user_model->update_user($user_id, array('user_is_vip' => 'yes','buy_vip_id_num'=> $buy_vip_id));

            // Send VIP Membership Purchased Email to User
            $to_email = $userInfo['user_email'];
            $subject = $this->lang->line('vip_memebership_purchased');
            $data['user_name'] = $userInfo['user_access_name'];
            $data['user_profile_pic'] = base_url('/images/avatar/' . $userInfo['user_gender'] . ".png");
            $data['package_duration'] = $vip_user['package_validity_in_months'];
            $data['purchase_amount'] = $vip_user['vip_package_amount'];
            $data['package_expire_date'] = convert_date_to_local(date('Y-m-d', strtotime('+'.$vip_user['package_validity_in_months'].' months')), 'd.m.Y');
            $data['first_name'] = $userInfo['user_firstname'];
            $data['last_name'] = $userInfo['user_lastname'];
            $data['street_or_no'] = $userInfo['user_street'];
            $data['location'] = $userInfo['user_city'];
            $data['country'] = $userInfo['user_country'];
            $data['email'] = $userInfo['user_email'];
            $data['telephone'] = $userInfo['user_telephone'];
            $data['payment_mode'] = 'Credit Card';
            $data['email_template'] = 'email/vip_membership_purchased';
            $email_message = $this->load->view('templates/email/main', $data, true);
            $attachment = '';
            $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
            $this->email->set_mailtype("html");
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($email_message);
            $this->email->send();
    }
    function automaticallyRenewSubscriptionsVip() {
        $this->load->model(['vip_package_model','user_model', 'email_model']);
        $startDate = date('Y-m-d',strtotime("-380 days"));
        $vip_users = $this->vip_package_model->getLastSubscribers($startDate);
        if($vip_users > 0){
            foreach($vip_users as $key=>$vip_user ){
                if($vip_user['package_validity_in_months'] == 1){
                    $date_of_buy = strtotime(explode(' ',$vip_user['buy_vip_date'])[0]);
                    $final_date = new DateTime(date("Y-m-d", strtotime("+1 month", $date_of_buy)));
                    $datetime2 = new DateTime(date('Y-m-d'));
                    $interval = $final_date->diff($datetime2);
                    $interval = $interval->format('%R%a');
                    if($interval == -1){
                        $userInfo = $this->user_model->get_user_information($vip_user['purchased_user_id']);
                        if($userInfo['user_is_vip'] == 'yes'){
                            $this->sendExpireNotificationEmail($vip_user['purchased_user_id'] , 'Uw abonnement is verlopen, wordt automatisch verlengd');
                        }
                        else{
                            $canceled_date = $this->user_model->get_canceled_date_of_vip($userInfo['user_id']);
                            if($canceled_date){
                                $date = new DateTime(date('Y-m-d'));
                                $date->modify('-1 day');
                                $yesterday = $date->format('Y-m-d');
                                if($canceled_date->canceled_date >= $yesterday){
                                    $this->sendExpireNotificationEmail($vip_user['purchased_user_id'] , 'Uw abonnement is verlopen, wordt automatisch verlengd');
                                }
                            }
                        }
                    }
                    if($interval == +0){
                        $userInfo = $this->user_model->get_user_information($vip_user['purchased_user_id']);
                        $sendRepeatTransfer = true;
                        if($userInfo['user_is_vip'] == 'no'){
                            $canceled_date = $this->user_model->get_canceled_date_of_vip($userInfo['user_id']);
                            if($canceled_date){
                                $date = new DateTime(date('Y-m-d'));
                                $date->modify('-1 day');
                                $yesterday = $date->format('Y-m-d');
                                if($canceled_date->canceled_date < $yesterday){
                                    $sendRepeatTransfer = false;
                                }
                            }
                        }
                        if($sendRepeatTransfer){
                            $this->repeatedPaymentForSubscribe($vip_user);
                        }
                    }
                }
                if($vip_user['package_validity_in_months'] == 3 || $vip_user['package_validity_in_months'] == 6 || $vip_user['package_validity_in_months'] == 12){
                    $date_of_buy = strtotime(explode(' ',$vip_user['buy_vip_date'])[0]);
                    $final_date = new DateTime(date("Y-m-d", strtotime("+" . $vip_user['package_validity_in_months'] . " month", $date_of_buy)));
                    $datetime2 = new DateTime(date('Y-m-d'));
                    $interval = $final_date->diff($datetime2);
                    $interval = $interval->format('%R%a');
                    if($interval == -7){
                        $userInfo = $this->user_model->get_user_information($vip_user['purchased_user_id']);
                        if($userInfo['user_is_vip'] == 'yes'){
                            $this->sendExpireNotificationEmail($vip_user['purchased_user_id'] , 'Uw abonnement is verlopen, wordt automatisch verlengd');
                        }
                        else{
                            $canceled_date = $this->user_model->get_canceled_date_of_vip($userInfo['user_id']);
                            if($canceled_date){
                                $date = new DateTime(date('Y-m-d'));
                                $date->modify('-7 day');
                                $before_7_day = $date->format('Y-m-d');
                                if($canceled_date->canceled_date >= $before_7_day){
                                    $this->sendExpireNotificationEmail($vip_user['purchased_user_id'] , 'Uw abonnement is verlopen, wordt automatisch verlengd');
                                }
                            }
                        }
                    }
                    if($interval == +0){
                        $userInfo = $this->user_model->get_user_information($vip_user['purchased_user_id']);
                        $sendRepeatTransfer = true;
                        if($userInfo['user_is_vip'] == 'no'){
                            $canceled_date = $this->user_model->get_canceled_date_of_vip($userInfo['user_id']);
                            if($canceled_date){
                                $date = new DateTime(date('Y-m-d'));
                                $date->modify('-7 day');
                                $yesterday = $date->format('Y-m-d');
                                if($canceled_date->canceled_date < $yesterday){
                                    $sendRepeatTransfer = false;
                                }
                            }
                        }
                        if($sendRepeatTransfer){
                            $this->repeatedPaymentForSubscribe($vip_user);
                        }
                    }
                }
            }
        }
        echo "Automatically Renew Subscribers : Cron Job Success";
    }
    function repeatedPaymentForSubscribe($vip_user) {
        $this->load->model(['payment_gateway_model', 'payment_transaction_model', 'vip_package_model', 'credit_package_model','user_model','email_model']);
        $this->load->library('tc_pdf');
        $this->load->library('email');
        $this->lang->load('user_lang', 'german');
        $credentials = $this->payment_gateway_model->get_oppwa_credentials();

        // Get Payment Status
        $config = array(
            'entityId' => $credentials['client_id'],
            'accessToken' => $credentials['client_acces_token'],
            'url' => $credentials['url'],
            'currency' => $credentials['currency']
        );
        $registrationInfo = $this->vip_package_model->getRegistrationInfo($vip_user['buy_vip_id']);
        $this->load->library('oppwa', $config);
        $payment_status = json_decode($this->oppwa->sendRepeatedPayment($vip_user['vip_package_amount'],$registrationInfo->registration_id));
        if($credentials['mode'] == 'test') {
            $payment_success_code = OPPWA_REPEAT_PAYMENT_SUCCESS_CODE_TEST;
        } else {
            $payment_success_code = OPPWA_REPEAT_PAYMENT_SUCCESS_CODE_LIVE;
        }
        if(isset($payment_status->result->code) && $payment_status->result->code == $payment_success_code) {
            // Activate package
            $package_info = $this->vip_package_model->get_vip_package_info($vip_user['vip_package_id']);
            $this->db->trans_begin();
            // Store Transaction
            $transaction_data = array(
                'gateway_id_ref' => OPPWA_PAYMENT_GATEWAY,
                'txn_id' => $payment_status->id,
                'payment_gross' => $vip_user['vip_package_amount'],
                'currency' => $credentials['currency'],
                'txn_date' => gmdate('Y-m-d H:i:s'),
                'payment_status' => 'success'
            );
            $transaction_id = $this->payment_transaction_model->insert_transaction($transaction_data);
            $buy_vip_package = array(
                'purchased_user_id' => $vip_user['purchased_user_id'],
                'vip_package_id' => $vip_user['vip_package_id'],
                'vip_package_name' => $vip_user['vip_package_name'],
                'vip_package_amount' => $vip_user['vip_package_amount'],
                'vip_package_diamonds' => $vip_user['vip_package_diamonds'],
                'package_validity_in_months' => $vip_user['package_validity_in_months'],
                'package_activated_using' => $vip_user['package_activated_using'],
                'transaction_id_ref' => $transaction_id,
                'buy_vip_flag' => $vip_user['buy_vip_flag'],
                'currency' => $vip_user['currency'],
                'buy_vip_date' => gmdate('Y-m-d H:i:s'),
            );
            $buy_vip_id = $this->vip_package_model->insert_user_buy_vip($buy_vip_package);
            $buy_vip_registration_array = array(
                'buy_vip_id' => $buy_vip_id,
                'registration_id' => $payment_status->id,
            );
            $this->vip_package_model->insert_user_buy_vip_registration($buy_vip_registration_array);
            $buy_vip_package_update = array(
                'repeated' => '1',
            );
            $buy_vip_id = $this->vip_package_model->update_user_buy_vip($buy_vip_package_update,$vip_user['buy_vip_id']);
            $userInfo = $this->user_model->get_active_user_information($vip_user['purchased_user_id']);
            $this->user_model->update_user( $vip_user['purchased_user_id'], array('user_is_vip' => 'yes','buy_vip_id_num'=> $buy_vip_id));
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $user_info = $this->user_model->get_user_information_for_payment($vip_user['purchased_user_id']);
                // Send VIP Memebership Purchased Email to User
                $to_email = $user_info['user_email'];
                $subject = $this->lang->line('vip_memebership_purchased');
                $data['user_name'] = $user_info['user_access_name'];
                $data['user_profile_pic'] = base_url('/images/avatar/' . $userInfo['user_gender'] . ".png");
                $data['package_duration'] = $package_info['package_validity_total_months'];
                $data['purchase_amount'] = $vip_user['vip_package_amount'];
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
                $attachment = '';
                $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
                $this->email->set_mailtype("html");
                $this->email->to($to_email);
                $this->email->subject($subject);
                $this->email->message($email_message);
                $this->email->send();
            }
            echo "Repeated Payment : Cron Job Success";
        }
    }
    function sendExpireNotificationEmail($user_id,$automaticaly_renew_text) {
        $this->load->model(['user_model','language_model', 'email_model']);
        $this->lang->load('user_lang', 'german');
        $userInfo = $this->user_model->get_active_user_information($user_id);
        $data['user_pic'] = base_url("images/avatar/".$userInfo['user_gender'].".png");
        $data['user_name'] = $userInfo['user_firstname'] . " " . $userInfo['user_lastname'];
        $data['automaticaly_renew_text'] = $automaticaly_renew_text;
        $data['email_template'] = 'email/vip_expire_notification';
        $subject = 'Abonnement verloopt';
        $email_message = $this->load->view('templates/email/main', $data, true);
        $this->load->library('email');
        $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
        $this->email->set_mailtype("html");
        $this->email->to($userInfo['user_email']);
        $this->email->subject($subject);
        $this->email->message($email_message);
        $sent = $this->email->send();
        if($sent){
            echo "Expire Notification Sent : Cron Job Success";
        }
    }
    // get free Vip credits after 15 days of registration
    function sendVipCreditsAfterTime() {
        $this->load->model(['vip_package_model', 'user_model', 'email_model','credit_package_model','photo_model']);
        $this->lang->load('user_lang', DEFAULT_LANGUAGE);
        $users = $this->vip_package_model->get_vip_users_for_last_days();
        if($users){
            $now = time();
            foreach($users as $key=>$value){
                $exploded_date = explode(' ',$value['buy_vip_date']);
                $your_date = strtotime($exploded_date[0]);
                $datediff = $now - $your_date;
                if(round($datediff / (60 * 60 * 24)) == 15){
                    // 60 Freee Credits
                    $user_info = $this->user_model->get_user_information($value['purchased_user_id']);
                    $user_current_credits = $user_info['user_credits'];
                    $free_info = $this->credit_package_model->get_free_credit_package_info();
                    $buy_credit_package = array(
                        'purchased_user_id'     => $value['purchased_user_id'],
                        'credit_package_id'     => $free_info['package_id'],
                        'credit_package_name'   => 'VIP 60 free credits',
                        'credit_package_credits' => $free_info['package_credits'],
                        'credit_package_amount' => $free_info['package_amount'],
                        'buy_credit_date'       => gmdate('Y-m-d H:i:s'),
                        'buy_credit_flag'       => 'web'
                    );
                    $this->credit_package_model->insert_user_buy_credits($buy_credit_package);
                    $user_current_credits = $user_current_credits + $free_info['package_credits'];
                    $this->user_model->update_user($value['purchased_user_id'], array('user_is_vip' => 'yes', 'user_credits' => $user_current_credits));
                    if($user_info['user_country'] == 'United Kingdom'){
                        $this->lang->load('user_lang', 'english');
                    }
                    // send email for 60 credits
                    $data['user_pic'] = base_url("images/avatar/".$user_info['user_gender'].".png");
                    $profile_pic = $this->photo_model->get_active_user_profile_pic($value['purchased_user_id']);
                    if($profile_pic) {
                        $data['user_pic'] = base_url($profile_pic['photo_thumb_url']);
                    }

                    $data['user_name'] = $user_info['user_firstname'] . " " . $user_info['user_lastname'];
                    $data['email_template'] = 'email/vip_60_credits';
                    $subject = $this->lang->line('vip_60_credits');
                    $email_message = $this->load->view('templates/email/main', $data, true);
                    $this->load->library('email');
                    $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
                    $this->email->set_mailtype("html");
                    $this->email->to($user_info['user_email']);
                    $this->email->subject($subject);
                    $this->email->message($email_message);
                    $this->email->send();
                }
            }
            return true;
        }
        return false;
    }
    function rankAllUsers() {
        
        $this->load->model(['user_model', 'photo_model']);

        $users = $this->user_model->get_all_users();

        if(!empty($users)) {
            foreach ($users as $urow) {

                $isProfilePicture = false;
                $isPictureApproved = false;

                if(empty($urow['user_active_photo_thumb'])) {
                    $isPictureApproved = false;
                    $isProfilePicture  = $this->photo_model->is_pending_profile_picture_for_user($urow['user_id']);
                } else {
                    $isProfilePicture = true;
                    $isPictureApproved = true;
                }

                $user_data = array(
                    'user_rank' => calculate_user_profile_rank($urow['user_is_vip'], $urow['user_verified'], $isProfilePicture, $isPictureApproved)
                );
                $this->user_model->update_user($urow['user_id'], $user_data);
            }
        }
        echo "Rank Users: Cron Job Success";
    }


}
