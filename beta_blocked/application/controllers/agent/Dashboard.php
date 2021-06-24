<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'agent') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

    	$agent_id = $this->session->userdata('user_id'); 
	    $this->load->model(['user_content_model', 'photo_model']);
		$settings = $this->session->userdata('site_setting');
		$data["settings"] = $settings;
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["pending_content_approvals"] =  $this->user_content_model->count_user_content_list('pending');
		$data["pending_images_approvals"] =  $this->photo_model->count_user_photo_list('inactive');

		$data["todays_content_approved"] =  $this->user_content_model->count_today_agent_approvals($agent_id);
		$data["todays_images_approved"] =  $this->photo_model->count_today_agent_approvals($agent_id);

		$this->load->view('agent/dashboard/index', $data);
	}
	


}
