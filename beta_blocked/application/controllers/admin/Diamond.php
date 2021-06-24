<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diamond extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['diamond_package_model']);
		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["packages"] = $this->diamond_package_model->get_all_diamond_package_list();
		$this->load->view('admin/diamond/packages', $data);
	}

	public function addPackage() {
    	$data = array();

	    $this->load->model(['diamond_package_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'package_name', 'required|trim');
		$this->form_validation->set_rules('package_diamonds', 'package_diamonds', 'required|is_natural_no_zero|trim');	
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
				'package_diamonds' => $this->input->post('package_diamonds'),
				'package_amount'	=> $this->input->post('package_amount'),
				'package_status' => $this->input->post('package_status'),
				'package_added_date' => gmdate('Y-m-d H:i:s'),
				'package_flag' => 'web'
			);

			$success_flg = $this->diamond_package_model->insert_diamond_package($package_data);
			
			if($success_flg) {
				$this->session->set_flashdata('message', $this->lang->line('package_has_been_added_successfully'));
			} else {
				$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
			}
			redirect(base_url('admin/diamond'));
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$this->load->view('admin/diamond/add', $data);
	}	

	public function editPackage($package_id) {
    	$data = array();

	    $this->load->model(['diamond_package_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('package_name', 'package_name', 'required|trim');
		$this->form_validation->set_rules('package_diamonds', 'package_diamonds', 'required|is_natural_no_zero|trim');	
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
				'package_diamonds' => $this->input->post('package_diamonds'),
				'package_amount'	=> $this->input->post('package_amount'),
				'package_status' => $this->input->post('package_status')
			);

			$update_flg = $this->diamond_package_model->update_diamond_package($package_id, $package_data);
			
			if($update_flg) {
				$this->session->set_flashdata('message', $this->lang->line('package_has_been_updated_successfully'));
				redirect(base_url('admin/diamond'));
			}			
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["package"] = $this->diamond_package_model->get_diamond_package_info($package_id);
		$this->load->view('admin/diamond/edit', $data);
	}	


}
