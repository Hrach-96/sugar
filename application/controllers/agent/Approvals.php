<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'agent') {
    		redirect(base_url());
    	}
    }

	public function content() {
    	$data = array();
    	$agent_id = $this->session->userdata('user_id');

	    $this->load->model(['user_content_model', 'agent_access_log_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];


		// 1. Get list of online agents with their image access log
		$online_agents = $this->agent_access_log_model->get_online_agents_with_access_log($agent_id, 'content');

		$accessed_records_arr = array();
		if(!empty($online_agents)) {
			foreach ($online_agents as $rw) {
				$accessed_records_arr[] = "uc.content_id NOT BETWEEN ".$rw['min_access_record_id']." AND ".$rw['max_access_record_id'];
			}
		}
		$accessed_records_str = implode(' AND ', $accessed_records_arr);

		// 2. Make query to retrive these records with size
		$data["approvals"] = $this->user_content_model->get_approval_content_list_for_agent($accessed_records_str);
		
		if(!empty($data["approvals"]) && count($data["approvals"]) >= 2) {
			// 3. Delete Previous Access Log if any
			$this->agent_access_log_model->delete_agent_access_log($agent_id, 'content');

			// 4. Insert current access log
			$insert_array = array(
				'access_user_id' => $agent_id,
				'access_type' => 'content',
				'min_access_record_id' => $data["approvals"][0]['content_id'],
				'max_access_record_id' => $data["approvals"][count($data["approvals"])-1]['content_id'],
				'access_date' => gmdate('Y-m-d H:i:s'),
				'access_flag' => 'web'
			);
			$this->agent_access_log_model->insert_agent_access_log($insert_array);
		}

		$this->load->view('agent/approvals/view_content', $data);
	}

	public function image() {
    	$data = array();
    	$agent_id = $this->session->userdata('user_id');

	    $this->load->model(['photo_model', 'agent_access_log_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		// 1. Get list of online agents with their image access log
		$online_agents = $this->agent_access_log_model->get_online_agents_with_access_log($agent_id, 'image');

		$accessed_records_arr = array();
		if(!empty($online_agents)) {
			foreach ($online_agents as $rw) {
				$accessed_records_arr[] = "up.photo_id NOT BETWEEN ".$rw['min_access_record_id']." AND ".$rw['max_access_record_id'];
			}
		}
		$accessed_records_str = implode(' AND ', $accessed_records_arr);

		// 2. Make query to retrive these records with size
		$data["approvals"] = $this->photo_model->get_approval_photos_list_for_agent($accessed_records_str);
		
		if(!empty($data["approvals"]) && count($data["approvals"]) >= 2) {
			// 3. Delete Previous Access Log if any
			$this->agent_access_log_model->delete_agent_access_log($agent_id, 'image');

			// 4. Insert current access log
			$insert_array = array(
				'access_user_id' => $agent_id,
				'access_type' => 'image',
				'min_access_record_id' => $data["approvals"][0]['photo_id'],
				'max_access_record_id' => $data["approvals"][count($data["approvals"])-1]['photo_id'],
				'access_date' => gmdate('Y-m-d H:i:s'),
				'access_flag' => 'web'
			);
			$this->agent_access_log_model->insert_agent_access_log($insert_array);
		}

		$this->load->view('agent/approvals/view_image', $data);
	}

	public function approve_user_content() {
		$this->load->model(['user_content_model', 'user_model', 'email_model']);

		$content_id = $this->input->post('content_id');
		$content_status = $this->input->post('content_status');
		$user_id = $this->session->userdata('user_id');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$req_info = $this->user_content_model->get_request_content_info($content_id);

		if($req_info) {
			if($req_info['content_status'] == 'pending') {
				$updateData = array(
					'content_status' => $content_status,
					'content_cheked_by' => $user_id,
					'content_cheked_date' => gmdate('Y-m-d H:i:s')
				);

				$this->db->trans_begin();
				$this->user_content_model->update_user_content($content_id, $updateData);
				if($content_status == 'approved') {
					$userData[$req_info['content_type']] = $req_info['content_text'];
					$this->user_model->update_user_info($req_info['content_user_id'], $userData);
				}

            	if($this->db->trans_status() === FALSE) {
                	$this->db->trans_rollback();
					$response['status'] = false;
					$response['errorCode'] = 2;
					$response['message'] = $this->lang->line('internal_server_error');
            	} else {
                	$this->db->trans_commit();
					$response['status'] = true;
					$response['data'] = $this->lang->line($content_status);

					$member_info = $this->user_model->get_user_information($req_info['content_user_id']);

					// Send Email to user for Unlocking text
		            $to_email = $member_info['user_email'];
	                $data['user_name'] = $member_info['user_access_name'];
	                $data['user_profile_pic'] = base_url("images/avatar/".$member_info['user_gender'].".png");	
	                if($member_info['user_active_photo_thumb'] != '') {
	                	$data['user_profile_pic'] = base_url($member_info['user_active_photo_thumb']);
	                }
					if($content_status == 'approved') {
		                // Send email for FliertText has been unlocked
		                $subject = $this->lang->line('flirttext_unlocked');
		                $data['email_template'] = 'email/flirttext_unlocked';
					} else {
		                // Send email for FliertText has not been unlocked - rejected
		                $subject = $this->lang->line('flirttext_not_unlocked');
		                $data['email_template'] = 'email/flirttext_not_unlocked';
					}
	                $email_message = $this->load->view('templates/email/main', $data, true);
	                @$this->email_model->sendEMail($to_email, $subject, $email_message);
                }
			} else {
				$response['status'] = false;
				$response['errorCode'] = 1;
				$response['message'] = $this->lang->line('already_approved');
				$response['requestStatus'] = $req_info['content_status'];
				$response['requestStatusMsg'] = $this->lang->line($req_info['content_status']);				
			}
		} else {			
			$response['status'] = false;
			$response['errorCode'] = 3;
			$response['message'] = $this->lang->line('unauthorized_access');
		}

		header('Content-Type: application/json');
		echo json_encode($response);		
	}

	public function approve_user_photo() {
		$this->load->model(['photo_model', 'user_model', 'email_model']);

		$photo_id = $this->input->post('photo_id');
		$photo_status = $this->input->post('photo_status');
		$user_id = $this->session->userdata('user_id');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$req_info = $this->photo_model->get_photo_info($photo_id);

		if($req_info) {
			if($req_info['photo_status'] == 'inactive') {
				$updateData = array(
					'photo_status' => $photo_status,
					'photo_checked_by' => $user_id,
					'photo_checked_date' => gmdate('Y-m-d H:i:s')
				);

				$this->db->trans_begin();
				$this->photo_model->update_photo_info($photo_id, $updateData);

				if($req_info['is_profile_photo'] == 'yes') {
					$user_info_array = array(
						'user_active_photo' => $req_info['photo_url'],
						'user_active_photo_thumb' => $req_info['photo_thumb_url']
					);
					$this->user_model->update_user_info($req_info['photo_user_id_ref'], $user_info_array);
				}

            	if($this->db->trans_status() === FALSE) {
                	$this->db->trans_rollback();
					$response['status'] = false;
					$response['errorCode'] = 2;
					$response['message'] = $this->lang->line('internal_server_error');
            	} else {
                	$this->db->trans_commit();
					$response['status'] = true;
					$response['data'] = $this->lang->line($photo_status);

					$member_info = $this->user_model->get_user_information($req_info['photo_user_id_ref']);

					// Send Email to user for Unlocking text
		            $to_email = $member_info['user_email'];
	                $data['user_name'] = $member_info['user_access_name'];
	                $data['user_profile_pic'] = base_url("images/avatar/".$member_info['user_gender'].".png");	
	                if($member_info['user_active_photo_thumb'] != '') {
	                	$data['user_profile_pic'] = base_url($member_info['user_active_photo_thumb']);
	                }
					if($photo_status == 'active') {
		                // Send email for Picture has been unlocked
		                $subject = $this->lang->line('picture_unlocked');
		                $data['email_template'] = 'email/picture_unlocked';
					} else {
		                // Send email for Picture has not been unlocked - rejected
		                $subject = $this->lang->line('picture_not_unlocked');
		                $data['email_template'] = 'email/picture_not_unlocked';
					}
	                $email_message = $this->load->view('templates/email/main', $data, true);
	                @$this->email_model->sendEMail($to_email, $subject, $email_message);
                }
			} else {
				$response['status'] = false;
				$response['errorCode'] = 1;
				$response['message'] = $this->lang->line('already_approved');
				$response['requestStatus'] = $req_info['photo_status'];
				$response['requestStatusMsg'] = $this->lang->line($req_info['photo_status']);				
			}
		} else {			
			$response['status'] = false;
			$response['errorCode'] = 3;
			$response['message'] = $this->lang->line('unauthorized_access');
		}

		header('Content-Type: application/json');
		echo json_encode($response);		
	}


}
