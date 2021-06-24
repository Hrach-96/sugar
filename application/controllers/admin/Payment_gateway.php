<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_gateway extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['payment_gateway_model']);
		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["gateways"] = $this->payment_gateway_model->get_all_gateway_list();
		$this->load->view('admin/payment_gateway/view', $data);
	}

	public function edit($gateway_id) {
    	$data = array();

	    $this->load->model(['payment_gateway_model']);
		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('client_id', 'client_id', 'required|trim');
		$this->form_validation->set_rules('access_token', 'access_token', 'required|trim');	
		$this->form_validation->set_rules('currency', 'currency', 'required|trim');	
		$this->form_validation->set_rules('url', 'url', 'required|trim');
		$this->form_validation->set_rules('mode', 'mode', 'required|trim');
		$this->form_validation->set_rules('status', 'status', 'required|trim');

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
		
        if ($this->form_validation->run() != FALSE) {
			$package_data = array(
				'client_id' => $this->input->post('client_id'),
				'client_acces_token' => $this->input->post('access_token'),
				'currency'	=> $this->input->post('currency'),
				'url' => $this->input->post('url'),
				'mode' => $this->input->post('mode'),
				'status' => $this->input->post('status')
			);

			$update_flg = $this->payment_gateway_model->update_gateway_info($gateway_id, $package_data);
			
			if($update_flg) {
				$this->session->set_flashdata('message', $this->lang->line('payment_gateway_has_been_updated_successfully'));
				redirect(base_url('admin/payment_gateway'));
			}			
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["gateway"] = $this->payment_gateway_model->get_gateway_info($gateway_id);
		$this->load->view('admin/payment_gateway/edit', $data);
	}	


}
