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
