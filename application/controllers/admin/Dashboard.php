<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['site_model', 'user_model', 'credit_package_model', 'diamond_package_model', 'vip_package_model']);
		$settings = $this->session->userdata('site_setting');
		$data["settings"] = $settings;
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$total_vip_collected_amount = $this->vip_package_model->get_total_collected_amount();
		$total_credit_collected_amount = $this->credit_package_model->get_total_collected_amount();
		$total_diamond_collected_amount = $this->diamond_package_model->get_total_collected_amount();

		$data["total_users"] =  $this->user_model->count_all_users();
		$data["new_users_today"] =  $this->user_model->count_today_registered_users();
		$data["total_purchases"] = number_format(($total_vip_collected_amount + $total_credit_collected_amount + $total_diamond_collected_amount), 2);

		$this->load->view('admin/dashboard/index', $data);
	}
	


}
