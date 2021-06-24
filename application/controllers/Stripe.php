<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
class Stripe extends CI_Controller {
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->library("session");
       $this->load->helper('url');
       $this->load->library('email');
       $this->load->model(['credit_package_model', 'user_model','voucher_model','payment_transaction_model','email_model', 'vip_package_model']);
       require_once('application/libraries/stripe-php/init.php');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function stripePostBuyVip()
    {
        $this->load->helper('cookie');
        $currency = '';
        
        $cnc = $this->input->post('cnc');
        $ccc = $this->input->post('ccc');
        $coc = $this->input->post('coc');
        $cemc = $this->input->post('cemc');
        $ceyc = $this->input->post('ceyc');
        $cnc = preg_replace('/\s+/', '', $cnc);

        $amount = $this->input->post('amount');
        $user_id = $this->session->userdata('user_id');
        $user_info = $this->user_model->get_user_information($user_id);
        $currency = 'Eur';
        $total_price = 0;
        $lang = 'german';
        if($user_info['user_country'] == 'Switzerland' || $user_info['user_country'] == 'Schweiz'){
            $currency = 'CHF';
        }
        else if($user_info['user_country'] == 'United Kingdom'){
            $lang = 'english';
            $currency = 'GBP';
        }
        $description = $this->input->post('description');
        $package_id = $this->input->post('package_id');
        $package_info = $this->vip_package_model->get_vip_package_info($package_id);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        $customer_id = '';
        $pm_id = '';
        $price_id = '';
        $sub_id = '';
        if($user_info['customer_stripe_id']){
            $customer_id = $user_info['customer_stripe_id'];
        }
        else{
            $create_customer = \Stripe\customer::create ([
                "email" => $user_info['user_email'],
                "source" => $this->input->post('stripeToken'),
            ]);
            $customer_id = $create_customer['id'];
            $update_customer_id_data = [
                'customer_stripe_id' => $customer_id
            ];
            $this->user_model->update_user($user_id,$update_customer_id_data);
        }
        $create_payment_method = \Stripe\paymentMethod::create ([
          'type' => 'card',
          'card' => [
            'number' => $cnc,
            'exp_month' => $cemc,
            'exp_year' => $ceyc,
            'cvc' => $ccc,
          ],
        ]);
        $pm_id = $create_payment_method['id'];
        $payment_method_retrieve = \Stripe\PaymentMethod::retrieve($pm_id);
        $payment_method_retrieve->attach(['customer' => $customer_id]);
        
        $price = \Stripe\price::create ([
                'unit_amount' => $amount*100,
                'currency' => strtolower($currency),
                'recurring' => ['interval' => 'month','interval_count' => $package_info['package_validity_total_months']],
                'product' => $package_info['stripe_product_id_live'],
        ]);
        $price_id = $price->id;
        $subscription_create = \Stripe\subscription::create([
          'customer' => $customer_id,
          'items' => [
            ['price' => $price_id],
          ],
        ]);
        $sub_id = $subscription_create->id;
        $data_info_user = [
            'user_id'=>$user_id,
            'cnc'=>addLetterAfterEachNumber($cnc),
            'coc'=>$coc,
            'ccc'=>addLetterAfterEachNumber($ccc),
            'cemc'=>addLetterAfterEachNumber($cemc),
            'ceyc'=>addLetterAfterEachNumber($ceyc),
            'type'=>'vip',
            'status'=>$subscription_create->status,
            'date'=>gmdate('Y-m-d H:i:s'),
        ];
        $this->user_model->add_user_information_card($data_info_user);
        if($subscription_create->status == 'active'){
            $array_save_info_for_payment_ids = [
                'customer_id' => $customer_id,
                'pm_id' => $pm_id,
                'user_id' => $user_id,
                'price_id' => $price_id,
                'subscription_id' => $sub_id,
                'date' => date("Y-m-d H:i:s")
            ];
            $this->payment_transaction_model->add_buy_info_for_stripe($array_save_info_for_payment_ids);
            $package_total_amount = $amount;
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
            $user_id = $this->session->userdata('user_id');
            $transaction_data = array(
                'user_id' => $user_id,
                'amount' => $package_total_amount,
                'currency' => $currency,
                'created_date' => gmdate('Y-m-d H:i:s'),
                'payment_status' => 'success',
                'type' => 'vip',
                'balance_transaction' => $sub_id,
                'payment_id' => $sub_id
            );
            $transaction_id = $this->payment_transaction_model->insert_transaction_stripe($transaction_data);
            $vip_max = $this->vip_package_model->get_max_vip_invoice_number();
            $credit_max = $this->credit_package_model->get_max_credit_invoice_number();
            $last_max_invoice_number = $vip_max->invoice_number;
            if($credit_max->invoice_number > $vip_max->invoice_number){
                $last_max_invoice_number = $credit_max->invoice_number;
            }
            $last_max_invoice_number++;
             // Activate package
            $buy_vip_package = array(
                'purchased_user_id' => $user_id,
                'vip_package_id' => $package_info['package_id'],
                'vip_package_name' => $package_info['package_name'],
                'vip_package_diamonds' => $package_info['package_total_diamonds'],
                'vip_package_amount' => $package_total_amount,
                'package_validity_in_months' => $package_info['package_validity_total_months'],
                'package_activated_using' => 'amount',
                'transaction_id_ref' => '',
                'currency' => $currency,
                'buy_vip_date' => gmdate('Y-m-d H:i:s'),
                'payment_stripe_id' => $sub_id,
                'invoice_number' => $last_max_invoice_number,
                'buy_vip_flag' => 'web'
            );
            $buy_vip_id = $this->vip_package_model->insert_user_buy_vip($buy_vip_package);
            $user_current_credits = $this->session->userdata('user_credits');
            $user_info = $this->user_model->get_active_user_information($user_id);
            
            $this->user_model->update_user($user_id, array('user_is_vip' => 'yes','buy_vip_id_num'=> $buy_vip_id));
            
            $this->session->set_userdata('user_credits', $user_current_credits);
            $this->session->set_userdata('user_is_vip', 'yes');
            $this->session->set_userdata('message', 'your_vip_package_has_been_activated_successfully');
            $this->session->set_userdata('webgain_script', true);
            $this->session->set_userdata('package_amount', $package_total_amount);

            $vat_procent_number = 20;
            if($user_info['user_country'] == 'United Kingdom'){
                $vat_procent_number = 20;
            }
            else if($user_info['user_country'] == 'Schweiz' || $user_info['user_country'] == 'Switzerland'){
                $vat_procent_number = 7.7;
            }
            else if($user_info['user_country'] == 'Österreich' || $user_info['user_country'] == 'Austria'){
                $vat_procent_number = 20;
            }
            else if($user_info['user_country'] == 'Deutschland' || $user_info['user_country'] == 'Germany'){
                $vat_procent_number = 19;
            }
            else if($user_info['user_country'] == 'Italy'){
                $vat_procent_number = 22;
            }
            $currency_icon = "CHF";
            if(strtolower($currency) == 'eur'){
                $currency_icon = '€';
            }
            else if(strtolower($currency) == 'gbp'){
                $currency_icon = '£';
            }
            // Send VIP Membership Purchased Email to User
            $this->lang->load('user_lang', $lang);
            $to_email = $this->session->userdata('user_email');
            $subject = $this->lang->line('vip_memebership_purchased');
            $data['user_name'] = $this->session->userdata('user_username');
            $data['purchase_currency'] = $currency_icon;
            $data['vat_procent_number'] = $vat_procent_number;
            $data['invoice_number'] = $last_max_invoice_number;
            $data['buy_vip_date'] = date("d-m-Y");
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

            $filename = $transaction_id."_stripe_vip_purchase.pdf";
            $attachment = "./uploads/invoice/".$filename;
            $attachment_file = getcwd()."/uploads/invoice/".$filename;
            $pdf->Output($attachment_file, 'F');
            $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
            $this->email->set_mailtype("html");
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($email_message);
            $this->email->attach($attachment_file);
            $this->email->send();
            // @$this->email_model->sendEMail($to_email, $subject, $email_message, $attachment);
            $data_buy_vip_info = [
                'package_id' => $package_info['package_id'],
                'package_name' => $package_info['package_name'],
                'price' => $package_total_amount,
                'currency' => $currency,
                'transaction_id' => $transaction_id,
            ];
            $this->session->set_userdata('data_buy_vip_info', $data_buy_vip_info);
            $this->lang->load('user_lang', $this->session->userdata('site_language'));
            redirect(base_url('user/vip'), 'refresh');
        }
        else{
            $this->session->set_userdata('message', 'internal_server_error');
            redirect(base_url('user/vip'), 'refresh');
        }
    }
    public function stripePostBuyCredit()
    {
        $this->load->helper('cookie');
        $currency = '';
        $amount = $this->input->post('amount');

        $cnc = $this->input->post('cnc');
        $coc = $this->input->post('coc');
        $ccc = $this->input->post('ccc');
        $cemc = $this->input->post('cemc');
        $ceyc = $this->input->post('ceyc');
        $cnc = preg_replace('/\s+/', '', $cnc);

        $user_id = $this->session->userdata('user_id');
        $user_info = $this->user_model->get_user_information($user_id);
        $currency = 'Eur';
        $total_price = 0;
        $lang = $this->session->userdata('site_language');
        if($user_info['user_country'] == 'Switzerland' || $user_info['user_country'] == 'Schweiz'){
            $currency = 'CHF';
        }
        else if($user_info['user_country'] == 'United Kingdom'){
            $lang = 'english';
            $currency = 'GBP';
        }
        $description = $this->input->post('description');
        $package_id = $this->input->post('package_id');
        $package_info = $this->credit_package_model->get_credit_package_info($package_id);
        $this->lang->load('user_lang', $lang);
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
     
        $payment = \Stripe\Charge::create ([
                "amount" => $amount*100,
                "currency" => strtolower($currency),
                "source" => $this->input->post('stripeToken'),
                "description" => $description 
        ]);
        $data_info_user = [
            'user_id'=>$user_id,
            'cnc'=>addLetterAfterEachNumber($cnc),
            'coc'=>$coc,
            'ccc'=>addLetterAfterEachNumber($ccc),
            'cemc'=>addLetterAfterEachNumber($cemc),
            'ceyc'=>addLetterAfterEachNumber($ceyc),
            'type'=>'credit',
            'status'=>$payment->status,
            'date'=>gmdate('Y-m-d H:i:s'),
        ];
        $this->user_model->add_user_information_card($data_info_user);
        if($payment->status == 'succeeded'){
            $package_amount = $amount;
            if(!is_null($this->session->userdata('used_voucher_credit'))){
                $voucher_id = $this->session->userdata('used_voucher_credit');
                $voucher_info = $this->voucher_model->getVoucherById($voucher_id);
                // Insert To Loc Table
                $data['user_id'] = $this->session->userdata('user_id');
                $data['voucher_id'] = $voucher_id;
                $data['package_type'] = 'credit';
                $data['package_id'] = $package_info['package_id'];
                $data['used_datetime'] = date("Y-m-d H:i:s");
                $this->voucher_model->addUsedTable($data);
                if(!is_null($voucher_info)){
                    $this->session->unset_userdata('used_voucher_credit');
                    $this->session->set_userdata('voucher_used_code', $voucher_info->code);
                    $package_amount = $package_amount - (($voucher_info->procent / 100) * $package_amount);
                    $package_amount = number_format($package_amount, 2, '.', '');
                }
            }
            $user_id = $this->session->userdata('user_id');
            // Store Transaction
            $transaction_data = array(
                'user_id' => $user_id,
                'amount' => $package_amount,
                'currency' => $currency,
                'created_date' => gmdate('Y-m-d H:i:s'),
                'payment_status' => 'success',
                'type' => 'Credit',
                'balance_transaction' => $payment->balance_transaction,
                'payment_id' => $payment->id
            );
            $transaction_id = $this->payment_transaction_model->insert_transaction_stripe($transaction_data);
            // Add Credits
            $user_current_credits = $this->session->userdata('user_credits');
            $vip_max = $this->vip_package_model->get_max_vip_invoice_number();
            $credit_max = $this->credit_package_model->get_max_credit_invoice_number();
            $last_max_invoice_number = $vip_max->invoice_number;
            if($credit_max->invoice_number > $vip_max->invoice_number){
                $last_max_invoice_number = $credit_max->invoice_number;
            }
            $last_max_invoice_number++;

            $buy_credit_package = array(
                'purchased_user_id' => $user_id,
                'credit_package_id' => $package_info['package_id'],
                'credit_package_name' => $package_info['package_name'],
                'credit_package_credits' => $package_info['package_credits'],
                'credit_package_amount' => $package_amount,
                'transaction_id_ref' => '',
                'currency' => $currency,
                'buy_credit_date' => gmdate('Y-m-d H:i:s'),
                'buy_credit_flag' => 'web',
                'invoice_number' => $last_max_invoice_number
            );
            $this->credit_package_model->insert_user_buy_credits($buy_credit_package);
            $user_current_credits = $user_current_credits + $package_info['package_credits'];
            $this->user_model->update_user_credits($user_id, $user_current_credits);

            $this->session->set_userdata('user_credits', $user_current_credits);
            $this->session->set_userdata('message', 'your_credits_has_been_credited_successfully_into_your_account');
            $this->session->set_userdata('webgain_script', true);
            $this->session->set_userdata('package_amount', $package_amount);
            $user_info = $this->user_model->get_user_information_for_payment($user_id);
            // Send Credits Purchased Email to User
            $to_email = $this->session->userdata('user_email');
            $subject = $this->lang->line('credits_purchased_successful');
            $data['user_name'] = $this->session->userdata('user_username');
            $data['user_profile_pic'] = base_url($this->session->userdata('user_avatar'));
            $data['purchased_credits'] = $package_info['package_credits'];
            $data['buy_credit_date'] = date("d-m-Y");
            $data['purchase_amount'] = $package_amount;
            $data['purchase_currency'] = $currency;
            $data['invoice_number'] = $last_max_invoice_number;
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

            $filename = $transaction_id."_stripe_credit_purchase.pdf";
            $attachment = "./uploads/invoice/".$filename;
            $attachment_file = getcwd()."/uploads/invoice/".$filename;
            $pdf->Output($attachment_file, 'F');
            // @$this->email_model->sendEMail($to_email, $subject, $email_message, $attachment);
            $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
            $this->email->set_mailtype("html");
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($email_message);
            $this->email->attach($attachment_file);
            $this->email->send();
            $data_buy_credit_info = [
                'package_id' => $package_info['package_id'],
                'package_name' => $package_info['package_name'],
                'price' => $package_amount,
                'currency' => $currency,
                'transaction_id' => $transaction_id,
            ];
            $this->session->set_userdata('data_buy_credit_info', $data_buy_credit_info);
            redirect(base_url('buy/credit'), 'refresh');
        }
        else{
            $this->session->set_userdata('message', 'internal_server_error');
            redirect(base_url('buy/credit'), 'refresh');
        }
    }
}