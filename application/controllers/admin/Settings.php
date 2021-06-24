<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['site_model', 'country_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('site_name', 'site_name', 'required|trim');
		$this->form_validation->set_rules('site_tagline', 'site_tagline', 'required|trim');
		$this->form_validation->set_rules('site_description', 'site_description', 'trim');
		$this->form_validation->set_rules('site_tags', 'site_tags', 'trim');
		$this->form_validation->set_rules('site_analytics', 'site_analytics', 'trim');
		$this->form_validation->set_rules('free_credits', 'free_credits', 'required|is_natural|trim');
		$this->form_validation->set_rules('vip_user_unlocking_cost', 'vip_user_unlocking_cost', 'required|is_natural|trim');
		$this->form_validation->set_rules('basic_user_unlocking_cost', 'basic_user_unlocking_cost', 'required|is_natural|trim');
		$this->form_validation->set_rules('site_age_limit', 'site_age_limit', 'required|trim');
		$this->form_validation->set_rules('fb_url', 'fb_url', 'trim');
		$this->form_validation->set_rules('twitter_url', 'twitter_url', 'trim');
		$this->form_validation->set_rules('instagram_url', 'instagram_url', 'trim');
		$this->form_validation->set_rules('youtube_url', 'youtube_url', 'trim');
		$this->form_validation->set_rules('app_ios', 'app_ios', 'trim');
		$this->form_validation->set_rules('app_android', 'app_android', 'trim');
		$this->form_validation->set_rules('from_email', 'from_email', 'required|trim');
		$this->form_validation->set_rules('email_protocol', 'email_protocol', 'required|trim');
		$this->form_validation->set_rules('smtp_host', 'smtp_host', 'trim');
		$this->form_validation->set_rules('smtp_user', 'smtp_user', 'trim');
		$this->form_validation->set_rules('smtp_pass', 'smtp_pass', 'trim');
		$this->form_validation->set_rules('smtp_port', 'smtp_port', 'trim');
		$this->form_validation->set_rules('default_country', 'default_country', 'required|trim');

        if ($this->form_validation->run() != FALSE) {
        	$country_info = $this->country_model->get_country_info_by_abbr($this->input->post('default_country'));

			$site_settings = array(
				'site_name' 		=> $this->input->post('site_name'),
				'site_tagline' 		=> $this->input->post('site_tagline'),
				'site_description'	=> $this->input->post('site_description'),
				'site_tags'			=> $this->input->post('site_tags'),
				'site_analytics'	=> $this->input->post('site_analytics'),
				'site_age_limit'	=> $this->input->post('site_age_limit'),
				'free_credits'		=> $this->input->post('free_credits'),
				'vip_user_unlocking_cost'		=> $this->input->post('vip_user_unlocking_cost'),
				'basic_user_unlocking_cost'		=> $this->input->post('basic_user_unlocking_cost'),
				'fb_url'	 		=> $this->input->post('fb_url'),
				'twitter_url'		=> $this->input->post('twitter_url'),
				'instagram_url'		=> $this->input->post('instagram_url'),
				'youtube_url' 		=> $this->input->post('youtube_url'),
				'app_ios' 			=> $this->input->post('app_ios'),
				'app_android' 		=> $this->input->post('app_android'),
				'from_email' 		=> $this->input->post('from_email'),
				'email_protocol' 	=> $this->input->post('email_protocol'),
				'smtp_host' 		=> $this->input->post('smtp_host'),
				'smtp_user' 		=> $this->input->post('smtp_user'),
				'smtp_pass' 		=> $this->input->post('smtp_pass'),
				'smtp_port' 		=> $this->input->post('smtp_port'),
				'default_country_abbr' 	=> $this->input->post('default_country'),
				'default_language' 	=> $country_info['language_name']
			);

			$update_flg = $this->site_model->update_site_setting($site_settings);
			
			if($update_flg) {
				$this->session->set_flashdata('message', $this->lang->line('site_settings_has_been_updated_successfully'));
				$settings = $this->site_model->get_website_settings();
				$this->session->set_userdata('site_setting', $settings);
				$this->session->set_userdata('site_language', $site_settings["default_language"]);
				$this->session->set_userdata('site_country_abbr', $site_settings["default_country_abbr"]);
				$this->lang->load('user_lang', $this->session->userdata('site_language'));
			}
		}

		$data["settings"] = $settings;
		$data["countries"] = $this->country_model->get_active_countries_list();
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$this->load->view('admin/settings/index', $data);
	}
	


}
