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

		$data["packages"] = $this->vip_package_model->get_all_vip_package_list();
		$this->load->view('admin/vip/packages', $data);
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
