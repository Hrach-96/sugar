<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        } else {
            $this->load->model("auth_model");
            $this->auth_model->update_last_activity($this->session->userdata('user_id'));
        }
    }

    // Web service for synchronizatio betwwen Client and Server
	public function sync() {
	
		$response = array();
		//$this->load->model(['user_model', 'chat_model']);

		$response['new_image_added'] = true;
		$response['new_content_added'] = true;

		header('Content-Type: application/json');
		echo json_encode($response);
	}


}
