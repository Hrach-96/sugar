<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['credit_package_model']);
		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$data['packages_multicurrency'] = $this->credit_package_model->get_package_multicurrency();
		$data["packages"] = $this->credit_package_model->get_all_credit_package_list();
		$this->load->view('admin/credit/packages', $data);
	}

	public function addPackage() {
    	$data = array();

	    $this->load->model(['credit_package_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'package_name', 'required|trim');
		$this->form_validation->set_rules('package_credits', 'package_credits', 'required|is_natural_no_zero|trim');	
		$this->form_validation->set_rules('package_amount', 'package_amount', 'required|decimal|greater_than[0]|trim');
		$this->form_validation->set_rules('package_status', 'package_status', 'required|trim');

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('greater_than', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('decimal', $this->lang->line('please_insert_decimal_number'));

        if ($this->form_validation->run() != FALSE) {
			$package_data = array(
				'package_name' => $this->input->post('package_name'),
				'package_credits' => $this->input->post('package_credits'),
				'package_amount'	=> $this->input->post('package_amount'),
				'package_status' => $this->input->post('package_status'),
				'package_added_date' => gmdate('Y-m-d H:i:s'),
				'package_flag' => 'web'
			);

			$success_flg = $this->credit_package_model->insert_credit_package($package_data);
			
			if($success_flg) {
				$this->session->set_flashdata('message', $this->lang->line('package_has_been_added_successfully'));
			} else {
				$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
			}
			redirect(base_url('admin/credit'));
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$this->load->view('admin/credit/add', $data);
	}	
	public function editMulticurrencyPrices() {
	    $this->load->model(['credit_package_model']);
	    $this->credit_package_model->update_multicurrency_credit($this->input->post());
		$this->session->set_flashdata('message', $this->lang->line('package_has_been_updated_successfully'));
		redirect(base_url('admin/credit'));
	}
	public function editPackage($package_id) {
    	$data = array();

	    $this->load->model(['credit_package_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'package_name', 'required|trim');
		$this->form_validation->set_rules('package_credits', 'package_credits', 'required|is_natural_no_zero|trim');	
		$this->form_validation->set_rules('package_amount', 'package_amount', 'required|decimal|greater_than[0]|trim');
		$this->form_validation->set_rules('package_status', 'package_status', 'required|trim');

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('greater_than', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('decimal', $this->lang->line('please_insert_decimal_number'));
		
        if ($this->form_validation->run() != FALSE) {
			$package_data = array(
				'package_name' => $this->input->post('package_name'),
				'package_credits' => $this->input->post('package_credits'),
				'package_amount'	=> $this->input->post('package_amount'),
				'package_status' => $this->input->post('package_status')
			);

			$update_flg = $this->credit_package_model->update_credit_package($package_id, $package_data);
			
			if($update_flg) {
				$this->session->set_flashdata('message', $this->lang->line('package_has_been_updated_successfully'));
				redirect(base_url('admin/credit'));
			}			
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["package"] = $this->credit_package_model->get_credit_package_info($package_id);
		$this->load->view('admin/credit/edit', $data);
	}

	public function addFreeCredits() {
    	$data = array();

	    $this->load->model(['credit_package_model', 'user_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_id', 'package_id', 'required|trim');
		
        if ($this->form_validation->run() != FALSE) {
        	$package_id = $this->input->post('package_id');
            $user_id = $this->session->userdata('user_id');

            $package_info = $this->credit_package_model->get_credit_package_info($package_id);

            if($package_info) {
                $user_current_credits = $this->session->userdata('user_credits');

                $buy_credit_package = array(
                    'purchased_user_id' => $user_id,
                    'credit_package_id' => $package_info['package_id'],
                    'credit_package_name' => $package_info['package_name'],
                    'credit_package_credits' => $package_info['package_credits'],
                    'credit_package_amount' => $package_info['package_amount'],
                    'buy_credit_date' => gmdate('Y-m-d H:i:s'),
                    'buy_credit_flag' => 'web'
                );

                $this->db->trans_begin();
                $this->credit_package_model->insert_user_buy_credits($buy_credit_package);

                $user_current_credits = $user_current_credits + $package_info['package_credits'];
                $this->user_model->update_user_credits($user_id, $user_current_credits);

                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
                } else {
                    $this->db->trans_commit();                    
                    $this->session->set_userdata('user_credits', $user_current_credits);
                    $this->session->set_flashdata('message', $this->lang->line('your_credits_has_been_credited_successfully_into_your_account'));
                }
            } else {
                $this->session->set_flashdata('message', $this->lang->line('this_package_is_not_active_please_choose_another_package'));
            }			
			redirect(base_url('admin/credit'));
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["package"] = $this->credit_package_model->get_free_credit_package_info();
		$this->load->view('admin/credit/free_credits', $data);
	}
	public function reportHistory() {
		$data = array();
		$this->load->model(['credit_package_model','vip_package_model']);

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

		$data['credit'] = $this->credit_package_model->get_all_user_buy_credit_package_list_admin($start_date, $end_date);
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

		   	if($data['credit']) {
			   	foreach ($data['credit'] as $row){ 
			   		$line = array($row['user_access_name'], $row['credit_package_name'], $row['credit_package_amount'], $row['buy_credit_date']);
			     	fputcsv($file, $line); 
			   	}
			}

		   fclose($file); 
		   exit;
		}
		redirect(base_url('admin/purchases'));
	}
	public function update_invoice_number_for_credit() {
		$this->load->model(['credit_package_model']);
		$credit_id = $this->input->post('credit_id');
		$value = $this->input->post('value');
		$data = [
			'invoice_number' => $value
		];
	    $this->credit_package_model->update_buy_credit_info($credit_id,$data);
	    return true;
	}
	public function get_all_credit_bill_for_user() {
	    $this->load->model(['user_model','credit_package_model']);
		$purchased_credit_id = $this->input->post('purchased_credit_id');
		$package_info = $this->credit_package_model->get_user_buy_credit_package_information($purchased_credit_id);
	    $allCreditsBill = $this->credit_package_model->get_all_credit_bill_for_user($package_info['purchased_user_id']);
		print json_encode($allCreditsBill);die;
	}
	public function historyBuyCredits() {
		$data = array();

	    $this->load->model(['user_model','site_model','credit_package_model']);
	    $this->load->helper('form');
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_recent_purchase transactions
		$data["users"] = $this->credit_package_model->get_credit_history($per_page, $offset);
		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/credit/historyBuyCredits'));
			}
		}

		$data["offset"] = $offset;
		$total_credit_history = $this->credit_package_model->count_buy_credit_history_list();
		$data["total_credit_history"] = $total_credit_history;
		$last_invoice_number = $this->site_model->get_settings_by_type('bill_invoice_number');
		$data['invoice_number'] = $last_invoice_number['value'];
        $url = base_url().'admin/credit/historyBuyCredits';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_credit_history, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/credit/buy_credit_history', $data);
	}
	public function usedFreeCredits() {
    	$data = array();

	    $this->load->model(['user_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_recent_purchase transactions
		$data["users"] = $this->user_model->get_free_credits_users_list($per_page, $offset);

		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/credit/usedFreeCredits'));
			}
		}

		$data["offset"] = $offset;
		$total_users = $this->user_model->count_free_credits_users_list();
		$data["total_users"] = $total_users;
		$data["total_free_credits"] = $this->user_model->count_total_free_credits();

        $url = base_url().'admin/credit/usedFreeCredits';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/credit/used_free_credits', $data);
	}

}
