<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchases extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['credit_package_model', 'site_model', 'diamond_package_model', 'vip_package_model']);
	    $this->load->helper('form');

		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];


		$data["total_vip_collected_amount"] = number_format($this->vip_package_model->get_total_collected_amount(), 2);
		$data["total_credit_collected_amount"] = number_format($this->credit_package_model->get_total_collected_amount(), 2);
		$data["total_diamond_collected_amount"] = number_format($this->diamond_package_model->get_total_collected_amount(), 2);

		// get_recent_purchase trnasactions
		$data["vip_purchase"] = $this->vip_package_model->get_user_buy_vip_package_list(5, 0);
		$data["credit_purchase"] = $this->credit_package_model->get_user_buy_credit_package_list(5, 0);
		$data["diamond_purchase"] = $this->diamond_package_model->get_user_buy_diamond_package_list(5, 0);	
		$data["invoice_number"] = $this->site_model->get_settings_by_type('bill_invoice_number')['value'];	

		$this->load->view('admin/purchases/view', $data);
	}

	public function vip() {
    	$data = array();

	    $this->load->model(['vip_package_model','site_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 20;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_recent_purchase transactions
		$data["vip_purchase"] = $this->vip_package_model->get_user_buy_vip_package_list($per_page, $offset);

		if($data["vip_purchase"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/purchases/vip'));
			}
		}

		$data["offset"] = $offset;
		$total_transactions = $this->vip_package_model->count_user_buy_vip_package_list();

        $url = base_url().'admin/purchases/vip';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_transactions, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$data["invoice_number"] = $this->site_model->get_settings_by_type('bill_invoice_number')['value'];	

		$this->load->view('admin/purchases/view_vip', $data);
	}

	public function credit() {
    	$data = array();

	    $this->load->model(['credit_package_model','site_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 20;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_recent_purchase transactions
		$data["credit_purchase"] = $this->credit_package_model->get_user_buy_credit_package_list($per_page, $offset);

		if($data["credit_purchase"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/purchases/credit'));
			}
		}

		$data["offset"] = $offset;
		$total_transactions = $this->credit_package_model->count_user_buy_credit_package_list();

        $url = base_url().'admin/purchases/credit';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_transactions, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$data["invoice_number"] = $this->site_model->get_settings_by_type('bill_invoice_number')['value'];	

		$this->load->view('admin/purchases/view_credit', $data);
	}

	public function diamond() {
    	$data = array();

	    $this->load->model(['diamond_package_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 20;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_recent_purchase transactions
		$data["diamond_purchase"] = $this->diamond_package_model->get_user_buy_diamond_package_list($per_page, $offset);

		if($data["diamond_purchase"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/purchases/diamond'));
			}
		}

		$data["offset"] = $offset;
		$total_transactions = $this->diamond_package_model->count_user_buy_diamond_package_list();

        $url = base_url().'admin/purchases/diamond';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_transactions, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/purchases/view_diamond', $data);
	}

	public function report() {
		$data = array();
		$this->load->model(['credit_package_model', 'vip_package_model', 'diamond_package_model']);

		$start_date = '';
		$end_date = '';
		if($this->input->post('report_by') == 'by_date') {
			if($this->input->post('start_date') < $this->input->post('end_date')) {
				$start_date = date('Y-m-d 00:00:00', strtotime($this->input->post('start_date')));
				$end_date = date('Y-m-d 11:59:59', strtotime($this->input->post('end_date')));
			} else {
				$start_date = date('Y-m-d 00:00:00', strtotime($this->input->post('end_date')));
				$end_date = date('Y-m-d 11:59:59', strtotime($this->input->post('start_date')));
			}
		}

		if($this->input->post('report_category') == 'credit') {
			$data["credit"] = $this->credit_package_model->get_all_user_buy_credit_package_list($start_date, $end_date);
			$data['vip'] = array();
			$data['diamond'] = array();
		} else if($this->input->post('report_category') == 'vip') {
			$data['vip'] = $this->vip_package_model->get_all_user_buy_vip_package_list($start_date, $end_date);
			$data['credit'] = array();
			$data['diamond'] = array();
		} else if($this->input->post('report_category') == 'diamond') {
			$data["diamond"] = $this->diamond_package_model->get_all_user_buy_diamond_package_list($start_date, $end_date);
			$data['vip'] = array();
			$data['credit'] = array();
		} else {
			// all categories
			$data['vip'] = $this->vip_package_model->get_all_user_buy_vip_package_list($start_date, $end_date);
			$data["credit"] = $this->credit_package_model->get_all_user_buy_credit_package_list($start_date, $end_date);
			$data["diamond"] = $this->diamond_package_model->get_all_user_buy_diamond_package_list($start_date, $end_date);
		}

		if($this->input->post('report_type') == 'pdf') {
			
			$this->lang->load('user_lang', $this->session->userdata('site_language'));
	        $this->load->library('tc_pdf');
	        $pdf = $this->tc_pdf->pdf;
	
	        // set document information
	        $pdf->SetCreator(PDF_CREATOR);
	        $pdf->SetAuthor('Sugarbabe deluxe');
	        $pdf->SetTitle('Report');
	        $pdf->SetSubject('Purchase Report');
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
	        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	        // set image scale factor
	        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);	        
	        // add a page
	        $pdf->AddPage();

	        $report_html = $this->load->view('admin/purchases/report_pdf', $data, true);
	        $pdf->writeHTML($report_html, true, false, true, false, '');

	        $filename = 'Purchase_report_'.date('Ymd').'.pdf';
	        $pdf->Output($filename, 'D');
	        exit;
		} else if($this->input->post('report_type') == 'csv') {
		   // file name
		   $filename = 'report_'.date('Ymd').'.csv';
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");

		   // file creation 
		   $file = fopen('php://output', 'w');
		 
		   $header = array("Name","Package Name","Amount","Date"); 
		   fputcsv($file, $header);

		   	if($data['vip']) {
			   	foreach ($data['vip'] as $row){ 
			   		$line = array($row['user_access_name'], $row['vip_package_name'], $row['vip_package_amount'], $row['buy_vip_date']);
			     	fputcsv($file, $line); 
			   	}
			}

			if($data['credit']) {
			   	foreach ($data['credit'] as $row){ 
			   		$line = array($row['user_access_name'], $row['credit_package_name'], $row['credit_package_amount'], $row['buy_credit_date']);
			     	fputcsv($file, $line); 
			   	}
			}

			if($data['diamond']) {
			   	foreach ($data['diamond'] as $row){ 
			   		$line = array($row['user_access_name'], $row['diamond_package_name'], $row['diamond_package_amount'], $row['buy_diamond_date']);
			     	fputcsv($file, $line); 
			   	}
		   	}

		   fclose($file); 
		   exit;
		}
		redirect(base_url('admin/purchases'));
	}
	public function report_cancel_vip() {
		$this->lang->load('user_lang', $this->session->userdata('site_language'));
		$this->load->model(['vip_package_model']);
		$per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_recent_purchase transactions
		$users = $this->vip_package_model->get_cancel_vip_history($per_page, $offset);
		foreach($users as $key=>$value){
			$data['vip'][] = $value;
		}
		$filename = 'report_'.date('Ymd').'.csv';
	    header("Content-Description: File Transfer"); 
	    header("Content-Disposition: attachment; filename=$filename"); 
	    header("Content-Type: application/csv; ");
 	    // file creation 
 	    $file = fopen('php://output', 'w');
 	    $header = array($this->lang->line('nic_name'),$this->lang->line('name'),$this->lang->line('country'),$this->lang->line('location'),$this->lang->line('street'),$this->lang->line('house_nr'),$this->lang->line('email_address_short'),$this->lang->line('telephone_number_short'),$this->lang->line('vip'),$this->lang->line('buy_date'),$this->lang->line('cancel_date'),'W',$this->lang->line('abo_ende'),$this->lang->line('k_beendigung'),$this->lang->line('email'),'Anwalt',); 
 	    fputcsv($file, $header);
    	foreach ($data['vip'] as $row){ 
    		$buy_vip_date = new DateTime($row['buy_vip_date']);
	    	$expire_date = $buy_vip_date->modify('+' . $row['package_validity_in_months'] . ' month');

    		$line = array($row['user_access_name'], $row['user_firstname'] . " " . $row['user_lastname'], $row['user_country'], $row['user_city'], $row['user_street'], $row['user_house_no'], $row['user_email'], $row['user_telephone'], preg_replace('/[^0-9]/', '', $row['vip_package_name']), convert_date_to_local($row['buy_vip_date'], SITE_DATETIME_FORMAT), convert_date_to_local($row['canceled_date'], SITE_DATETIME_FORMAT),$row['w_yes_no'],$expire_date->format('Y-m-d'),$row['k_termination'],$row['email_cancel'],$row['anwalt']);
      	fputcsv($file, $line); 
    	}
 	    fclose($file); 
	    exit;
	}

	public function update_invoice_number() {
		$this->load->model(['site_model']);
		$invoice_number = $this->input->post('invoice_number');
		$invoice_number = preg_replace('/[^0-9]/', '', $invoice_number);
		$data_invoice_update = [
        	'value' => $invoice_number
        ];
        $this->site_model->update_settings_by_type('bill_invoice_number',$data_invoice_update);
        return true;
	}
	public function invoiceVIP($invoiceID, $fileName) {

		$this->load->model(['vip_package_model', 'user_model','site_model']);
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$package_info = $this->vip_package_model->get_user_buy_vip_package_information($invoiceID);
		$user_info = $this->user_model->get_user_information_for_payment($package_info['purchased_user_id']);
		$curdate = strtotime('2021-03-17');
		$mydate = strtotime($package_info['buy_vip_date']);
		$currency = 'Eur';
		if($package_info['currency'] == ''){
			if($curdate < $mydate)
			{
				if($user_info['user_country'] == 'Switzerland' || $user_info['user_country'] == 'Schweiz'){
					$currency = 'CHF';
				}
				else if($user_info['user_country'] == 'United Kingdom'){
					$currency = 'GBP';
				}
			}
		}
		else{
			$currency = $package_info['currency'];
		}
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
		$payment_mode = 'SEPA';
		if($package_info['payment_stripe_id']){
			$payment_mode = 'Credit Card';
		}
		$currency_icon = "CHF";
		if(strtolower($currency) == 'eur'){
			$currency_icon = '€';
		}
		else if(strtolower($currency) == 'gbp'){
			$currency_icon = '£';
		}
        $data['vat_procent_number'] = $vat_procent_number;
        $data['user_name'] = $user_info['user_access_name'];
        $data['buy_vip_date'] = date("d-m-Y", strtotime($package_info['buy_vip_date']));
        $data['package_duration'] = $package_info['package_validity_in_months'];
        $data['purchase_amount'] = $package_info['vip_package_amount'];
        $data['purchase_currency'] = $currency_icon;
        $data['package_expire_date'] = convert_date_to_local(date('Y-m-d', strtotime('+'.$package_info['package_validity_in_months'].' months', strtotime($package_info['buy_vip_date']))), 'd.m.Y');
        $last_invoice_number = $this->site_model->get_settings_by_type('bill_invoice_number');
        $data['first_name'] = $user_info['user_firstname'];
        $data['last_name'] = $user_info['user_lastname'];
        $data['street_or_no'] = $user_info['user_street'];
        $data['location'] = $user_info['user_city'];
        $data['country'] = $user_info['user_country'];
        $data['email'] = $user_info['user_email'];
        $data['telephone'] = $user_info['user_telephone'];
        $data['payment_mode'] = $payment_mode;
        $data['invoice_number'] = $package_info['invoice_number'];
        // $data_invoice_update = [
        // 	'value' => $last_invoice_number['value'] + 1
        // ];
        // $this->site_model->update_settings_by_type('bill_invoice_number',$data_invoice_update);

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
        ob_end_clean();
        $filename = "vip_invoice.pdf";
        $pdf->Output($filename, 'D');
	}

	public function invoiceCredit($invoiceID, $fileName) {

		$this->load->model(['credit_package_model', 'user_model','site_model']);
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$package_info = $this->credit_package_model->get_user_buy_credit_package_information($invoiceID);
		$user_info = $this->user_model->get_user_information_for_payment($package_info['purchased_user_id']);
       	$curdate = strtotime('2021-03-17');
		$mydate = strtotime($package_info['buy_credit_date']);

		$currency = 'Euro';
		if($package_info['currency'] == ''){
			if($curdate < $mydate)
			{
				if($user_info['user_country'] == 'Switzerland' || $user_info['user_country'] == 'Schweiz'){
					$currency = 'CHF';
				}
				else if($user_info['user_country'] == 'United Kingdom'){
					$currency = 'GBP';
				}
			}
		}
		else{
			$currency = $package_info['currency'];
		}
        // Send Credits Purchased Email to User
        $last_invoice_number = $this->site_model->get_settings_by_type('bill_invoice_number');
        $data['user_name'] = $user_info['user_access_name'];
        $data['buy_credit_date'] = date("d-m-Y", strtotime($package_info['buy_credit_date']));
        $data['purchased_credits'] = $package_info['credit_package_credits'];
        $data['purchase_currency'] = $currency;
        $data['purchase_amount'] = $package_info['credit_package_amount'];

        $data['first_name'] = $user_info['user_firstname'];
        $data['last_name'] = $user_info['user_lastname'];
        $data['street_or_no'] = $user_info['user_street'];
        $data['location'] = $user_info['user_city'];
        $data['country'] = $user_info['user_country'];
        $data['email'] = $user_info['user_email'];
        $data['telephone'] = $user_info['user_telephone'];
        $data['payment_mode'] = 'Credit Card';
        $data['invoice_number'] = $package_info['invoice_number'];
        // $data_invoice_update = [
        // 	'value' => $last_invoice_number['value'] + 1
        // ];
        // $this->site_model->update_settings_by_type('bill_invoice_number',$data_invoice_update);

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

        ob_end_clean();
        $filename = "credit_invoice.pdf";
        $pdf->Output($filename, 'D');
	}

}
