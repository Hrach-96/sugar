<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vip extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['vip_package_model']);
		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$data['packages_multicurrency'] = $this->vip_package_model->get_package_multicurrency();
		$data["packages"] = $this->vip_package_model->get_all_vip_package_list();
		$this->load->view('admin/vip/packages', $data);
	}
	public function change_manually_vip_for_user() {
	    $this->load->model(['user_model']);
		$user_id = $this->input->post('id');
		$val = $this->input->post('val');
		if($val == 0){
			$this->user_model->update_user($user_id, array('user_is_vip' => 'no','blocked_vip'=>2));
		}
		else{
			$this->user_model->update_user($user_id, array('user_is_vip' => 'yes','blocked_vip'=>1));
		}
		return true;
	}
	public function editMulticurrencyPrices() {
	    $this->load->model(['vip_package_model']);
	    $this->vip_package_model->update_multicurrency_vip($this->input->post());
		$this->session->set_flashdata('message', $this->lang->line('package_has_been_updated_successfully'));
		redirect(base_url('admin/vip'));
	}
	public function addPackage() {
    	$data = array();

	    $this->load->model(['vip_package_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'package_name', 'required|trim');
		$this->form_validation->set_rules('package_for', 'package_for', 'required|trim');
		$this->form_validation->set_rules('package_validity_total_months', 'package_validity_total_months', 'required|is_natural_no_zero|trim');
		$this->form_validation->set_rules('package_total_amount', 'package_total_amount', 'required|decimal|greater_than[0]|trim');
		$this->form_validation->set_rules('package_total_diamonds', 'package_total_diamonds', 'required|is_natural_no_zero|trim');
		$this->form_validation->set_rules('package_status', 'package_status', 'required|trim');

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('greater_than', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('decimal', $this->lang->line('please_insert_decimal_number'));

        if ($this->form_validation->run() != FALSE) {
        	$total_months = $this->input->post('package_validity_total_months');
        	$package_amount_per_month = $this->input->post('package_total_amount') / $total_months;
        	$package_diamonds_per_month = $this->input->post('package_total_diamonds') / $total_months;

			$package_data = array(
				'package_name' => $this->input->post('package_name'),
				'package_for' => $this->input->post('package_for'),
				'package_validity_total_months'	=> $total_months,
				'package_amount_per_month' => $package_amount_per_month,
				'package_total_amount' => $this->input->post('package_total_amount'),
				'package_diamonds_per_month' => $package_diamonds_per_month,
				'package_total_diamonds' => $this->input->post('package_total_diamonds'),
				'package_status' => $this->input->post('package_status'),
				'package_added_date' => gmdate('Y-m-d H:i:s'),
				'package_flag' => 'web'
			);

			$success_flg = $this->vip_package_model->insert_vip_package($package_data);
			
			if($success_flg) {
				$this->session->set_flashdata('message', $this->lang->line('package_has_been_added_successfully'));
			} else {
				$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
			}
			redirect(base_url('admin/vip'));
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$this->load->view('admin/vip/add', $data);
	}	
	public function update_invoice_number_for_vip() {
		$this->load->model(['vip_package_model']);
		$vip_id = $this->input->post('vip_id');
		$value = $this->input->post('value');
		$data = [
			'invoice_number' => $value
		];
	    $this->vip_package_model->update_buy_vip_info($vip_id,$data);
	    return true;
	}
	public function editPackage($package_id) {
    	$data = array();

	    $this->load->model(['vip_package_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'package_name', 'required|trim');
		$this->form_validation->set_rules('package_for', 'package_for', 'required|trim');
		$this->form_validation->set_rules('package_validity_total_months', 'package_validity_total_months', 'required|is_natural_no_zero|trim');
		$this->form_validation->set_rules('package_total_amount', 'package_total_amount', 'required|decimal|greater_than[0]|trim');
		$this->form_validation->set_rules('package_total_diamonds', 'package_total_diamonds', 'required|is_natural_no_zero|trim');
		$this->form_validation->set_rules('package_status', 'package_status', 'required|trim');

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('greater_than', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('is_natural_no_zero', $this->lang->line('please_correct_your_information'));
		$this->form_validation->set_message('decimal', $this->lang->line('please_insert_decimal_number'));
		
        if ($this->form_validation->run() != FALSE) {
        	$total_months = $this->input->post('package_validity_total_months');
        	$package_amount_per_month = $this->input->post('package_total_amount') / $total_months;
        	$package_diamonds_per_month = $this->input->post('package_total_diamonds') / $total_months;

			$package_data = array(
				'package_name' => $this->input->post('package_name'),
				'package_for' => $this->input->post('package_for'),
				'package_validity_total_months'	=> $total_months,
				'package_amount_per_month' => $package_amount_per_month,
				'package_total_amount' => $this->input->post('package_total_amount'),
				'package_diamonds_per_month' => $package_diamonds_per_month,
				'package_total_diamonds' => $this->input->post('package_total_diamonds'),
				'package_status' => $this->input->post('package_status'),
			);

			$update_flg = $this->vip_package_model->update_vip_package($package_id, $package_data);
			
			if($update_flg) {
				$this->session->set_flashdata('message', $this->lang->line('package_has_been_updated_successfully'));
				redirect(base_url('admin/vip'));
			}			
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["package"] = $this->vip_package_model->get_vip_package_info($package_id);
		$this->load->view('admin/vip/edit', $data);
	}
	public function save_additional_info_for_cancel_vip() {
	    $this->load->model(['user_model','vip_package_model']);
	    $data = [
	    	$this->input->post('column_name') => $this->input->post('val')
	    ];
	    $this->vip_package_model->update_cancel_vip_package($this->input->post('row_id'), $data);
	    return true;
	}
	public function historyCancelVip() {
		$data = array();

	    $this->load->model(['user_model','vip_package_model']);
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
		$users = $this->vip_package_model->get_cancel_vip_history($per_page, $offset);
		$data['users'] = [];
		foreach($users as $key=>$value){
			$canceled_date = strtotime(explode(' ' , $value['buy_vip_date'])[0]);
			$buy_date = strtotime($value['canceled_date']);
			$datediff = $buy_date - $canceled_date;
			$days = round($datediff / (60 * 60 * 24));
			if($days >= 0 && $days < 14){
				$data['users'][] = $value;
			}
		}
		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/vip/historyCancelVip'));
			}
		}

		$data["offset"] = $offset;
		$total_cancel_vip_history = $this->vip_package_model->count_cancel_vip_history_list();
		$data["total_cancel_vip_history"] = $total_cancel_vip_history;

        $url = base_url().'admin/vip/historyCancelVip';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_cancel_vip_history, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/vip/canceled_vip', $data);
	}
	public function get_all_vip_bill_for_user() {
	    $this->load->model(['user_model','vip_package_model']);
		$purchased_vip_id = $this->input->post('purchased_vip_id');
		$package_info = $this->vip_package_model->get_user_buy_vip_package_information($purchased_vip_id);
	    $allvipsBill = $this->vip_package_model->get_all_vip_bill_for_user($package_info['purchased_user_id']);
		print json_encode($allvipsBill);die;
	}
	public function addFreeVIP() {
    	$data = array();

	    $this->load->model(['vip_package_model', 'user_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_id', 'package_id', 'required|trim');
		
        if ($this->form_validation->run() != FALSE) {
            if($this->session->userdata('user_is_vip') == 'no') {
                $package_id = $this->input->post('package_id');
                $user_id = $this->session->userdata('user_id');

                $package_info = $this->vip_package_model->get_vip_package_info($package_id);
                if($package_info) {                
                    $buy_vip_package = array(
                        'purchased_user_id' => $user_id,
                        'vip_package_id' => $package_info['package_id'],
                        'vip_package_name' => $package_info['package_name'],
                        'vip_package_diamonds' => $package_info['package_total_diamonds'],
                        'vip_package_amount' => $package_info['package_total_amount'],
                        'package_validity_in_months' => $package_info['package_validity_total_months'],
                        'package_activated_using' => 'amount',
                        'transaction_id_ref' => NULL,
                        'buy_vip_date' => gmdate('Y-m-d H:i:s'),
                        'buy_vip_flag' => 'web'
                    );

                    $this->db->trans_begin();
                    $this->vip_package_model->insert_user_buy_vip($buy_vip_package);
                    $this->user_model->update_user($user_id, array('user_is_vip' => 'yes'));

                    if($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_userdata('user_is_vip', 'yes');
                        
                        $this->session->set_flashdata('message', $this->lang->line('your_vip_package_has_been_activated_successfully'));
                    }
                } else {
                    $this->session->set_flashdata('message', $this->lang->line('this_package_is_not_active_please_choose_another_package'));
                }
            } else {
                $this->session->set_flashdata('message', $this->lang->line('already_vip_member'));
            }

			redirect(base_url('admin/vip'));
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["package"] = $this->vip_package_model->get_free_vip_package_info();
		$this->load->view('admin/vip/free_vip', $data);
	}

}
