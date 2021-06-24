<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Online extends CI_Controller {


    // Web service for synchronizatio betwwen Client and Server
	public function sync() {

		if($this->session->has_userdata('user_id')) {

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
					$todayGMT = gmdate('Y-m-d');
		    		foreach ($online_user_list as $user_row) {
		    			$is_new = false;
						if(strtotime($user_row["user_register_date"]) >= strtotime('-'.IS_NEW_USER_FOR_DAYS.' days', strtotime($todayGMT))) {
							$is_new = true;
						}
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
							'is_new' => $is_new,
							'is_favorite' => $this->favorite_model->is_favorite_member($user_id, $user_row['user_id'])
		    			);

		    			if($user_row['user_active_photo_thumb'] == '') {
		    				$tmp_array['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
		    			}
		    			$online_user_hash_list[] = $tmp_array;
		    		}
		    	}
		    	$response['online_users_hash'] = $online_user_hash_list;

		    	// Online Home Users List
				$online_user_home_list = $this->user_model->get_active_online_users($user_id, $user_interested_in);

				$online_home_users_hash = array();
		    	if(!empty($online_user_home_list)) {
					$todayGMT = gmdate('Y-m-d');
		    		foreach ($online_user_home_list as $user_row) {
						$is_new = false;
						if(strtotime($user_row["user_register_date"]) >= strtotime('-'.IS_NEW_USER_FOR_DAYS.' days', strtotime($todayGMT))) {
							$is_new = true;
						}
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
							'is_new' => $is_new,
							'is_favorite' => $this->favorite_model->is_favorite_member($user_id, $user_row['user_id'])
		    			);

		    			if($user_row['user_active_photo_thumb'] == '') {
		    				$tmp_array['user_active_photo_thumb'] = "images/avatar/".$user_row['user_gender'].".png";
		    			}
		    			$online_home_users_hash[] = $tmp_array;
		    		}
		    	}
		    	$response['online_home_users_hash'] = $online_home_users_hash;
		    	$response['total_online_home_users'] = count($online_home_users_hash);
		    } else {
		    	$response['total_online_users'] = 0;
		    }

		    $response['status'] = true;
			$response['total_online_new_users'] = $this->user_model->count_active_online_new_users($user_id, $user_interested_in);
		} else {
			$response['status'] = false;
			$response['message'] = "User session has been expired";
			$response['redirect_url'] = base_url();
		}

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
		// $onlineUsers = $this->user_model->get_active_online_users_list($user_id, $user_interested_in, $search_key, $per_page, $offset);
		$onlineUsers = $this->user_model->get_active_users_searched_list($user_id, $user_interested_in, $per_page, $offset);

		if($onlineUsers) {
			$tmp_array = array();

			foreach ($onlineUsers as $oUser) {
				$member_id = $oUser['user_id'];
				unset($oUser['user_id']);
				$oUser['user_hash'] = urlencode($oUser['user_id_encrypted']);
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
