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

	    $this->load->model(['credit_package_model', 'diamond_package_model', 'vip_package_model']);
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

		$this->load->view('admin/purchases/view', $data);
	}

	public function vip() {
    	$data = array();

	    $this->load->model(['vip_package_model']);
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

		$this->load->view('admin/purchases/view_vip', $data);
	}

	public function credit() {
    	$data = array();

	    $this->load->model(['credit_package_model']);
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


}
