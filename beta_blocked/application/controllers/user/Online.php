<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

    // Web service for synchronizatio betwwen Client and Server
	public function sync() {
		$this->load->model(['user_model', 'chat_model', 'auth_model']);
		$response = array();
		
		$this->auth_model->update_last_activity($this->session->userdata('user_id'));

		$user_id = $this->session->userdata('user_id');
		$user_interested_in = $this->session->userdata('user_interested_in');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

	    $online_user_list = $this->user_model->get_active_online_users($user_id, $user_interested_in);
	    // Sync parameters 
	    if($online_user_list) {
	    	$response['total_online_users'] = count($online_user_list);
			
			$online_user_hash_list = array();
	    	if($response['total_online_users'] > 0) {
	    		foreach ($online_user_list as $user_row) {

	    			$tmp_array = array(
	    				'user_id' => $user_row['user_id'],
	    				'user_hash' => urlencode($user_row['user_id_encrypted']),
	    				'message_count' => $this->chat_model->count_unseen_message_count($user_id, $user_row['user_id']),
	    				'user_access_name' => $user_row['user_access_name'],
	    				'user_active_photo_thumb' => $user_row['user_active_photo_thumb'],
	    				'user_age' => $user_row['user_age'],
	    				'user_city' => $user_row['user_city'],
	    				'distance' => $user_row['distance'],
	    				'user_is_vip' => $user_row['user_is_vip'],
	    				'user_id_encrypted' => $user_row['user_id_encrypted'],
	    				'is_kissed' => $this->kiss_model->is_member_kissed($user_id, $user_row['user_id']),
						'is_favorite' => $this->favorite_model->is_favorite_member($user_id, $user_row['user_id'])
	    			);

	    			if($user_row['user_active_photo_thumb'] == '') {
	    				$tmp_array['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
	    			}
	    			$online_user_hash_list[] = $tmp_array;
	    		}
	    	}
	    	$response['online_users_hash'] = $online_user_hash_list;
	    } else {
	    	$response['total_online_users'] = 0;
	    }

		$response['total_online_new_users'] = $this->user_model->count_active_online_new_users($user_id, $user_interested_in);

		header('Content-Type: application/json');
		echo json_encode($response);
	}


	// Web service for listing Users for Chatting
	public function getOnlineUsers() {
		$this->load->model(['user_model', 'chat_model']);
		
		$user_id = $this->session->userdata('user_id');
		$user_interested_in = $this->session->userdata('user_interested_in');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

		$per_page = 10;
		$offset = ($per_page * $this->input->post('page_no'));
		$search_key = $this->input->post('search_key');
		$onlineUsers = $this->user_model->get_active_online_users_list($user_id, $user_interested_in, $search_key, $per_page, $offset);

		if($onlineUsers) {
			$tmp_array = array();

			foreach ($onlineUsers as $oUser) {
				$member_id = $oUser['user_id'];
				unset($oUser['user_id']);
				$oUser['user_hash'] = urlencode($oUser['user_hash']);
				if($oUser['user_active_photo_thumb'] == '')
					$oUser['user_active_photo_thumb'] = "images/avatar/".$oUser['user_gender'].".png";
				$tmp_array[] = $oUser;
			}

			$response['status'] = true;
			$response['errorCode'] = 0;
			$response['data'] = $tmp_array;
			$response['message'] = $this->lang->line('success');
		} else {
			$response['status'] = false;
			$response['errorCode'] = 1;
			$response['message'] = $this->lang->line('no_one_found');
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}
	


}
