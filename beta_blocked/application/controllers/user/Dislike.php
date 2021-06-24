<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dislike extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

	// we service for dislike member
	public function add_to_dislike() {
		$this->load->model(['dislike_model']);

		$member_id_enc = $this->input->post('member_id');
		$user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $settings = $this->session->userdata('site_setting');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$alreadyDisliked = $this->dislike_model->is_member_disliked($user_id, $member_id);

		if($alreadyDisliked == true) {
			$response['status'] = false;
			$response['errorCode'] = 0;
			$response['message'] = $this->lang->line('already_disliked');
		} else {
			$insertData = array(
				'dislike_from_user_id' => $user_id, 
				'dislike_to_user_id' => $member_id,
				'dislike_added_date' => date('Y-m-d H:i:s')
			);
			$success = $this->dislike_model->insert_user_dislike($insertData);

			if($success > 0) {
				$response['status'] = true;
			} else {
				$response['status'] = false;
				$response['errorCode'] = 1;
				$response['message'] = $this->lang->line('internal_server_error');
			}
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}


}
