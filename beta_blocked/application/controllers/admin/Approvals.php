<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['user_content_model', 'photo_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["photo_count_statuswise"] = $this->photo_model->count_user_photo_as_per_status();
		$data["content_count_statuswise"] = $this->user_content_model->count_user_content_as_per_status();

		// get_first_old_approvals
		$data["images_approvals"] =  $this->photo_model->get_all_photos_list(5, 0);
		$data["content_approvals"] = $this->user_content_model->get_user_content_list(5, 0);

		$this->load->view('admin/approvals/view', $data);
	}

	public function content() {
    	$data = array();
    	$this->load->helper('form');

	    $this->load->model(['user_content_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $search_by_status = '';
        if($this->input->get('status') != '') {
            $search_by_status = $this->input->get('status');
        }

        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
		$data["approvals"] = $this->user_content_model->get_user_content_list($per_page, $offset, $search_by_status);

		if($data["approvals"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/approvals/content'));
			}
		}

		$data["offset"] = $offset;
		$data['search_by_status'] = $search_by_status;
		$total_approvals = $this->user_content_model->count_user_content_list($search_by_status);

		if($search_by_status != '') {
        	$url = base_url().'admin/approvals/content?status='.$search_by_status;
        } else {
        	$url = base_url().'admin/approvals/content';
        }
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_approvals, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/approvals/view_content', $data);
	}

	public function image() {
    	$data = array();
    	$this->load->helper('form');

	    $this->load->model(['photo_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $search_by_status = '';
        $profile_type = '';
        if($this->input->get('status') != '') {
            $search_by_status = $this->input->get('status');
        }
        if($this->input->get('type') != '') {
            $profile_type = $this->input->get('type');
        }

        $per_page = 5;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
		$data["approvals"] = $this->photo_model->get_all_photos_list($per_page, $offset, $search_by_status, $profile_type);

		if($data["approvals"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/approvals/image'));
			}
		}

		$data["offset"] = $offset;
		$data['search_by_status'] = $search_by_status;
		$data['profile_type'] = $profile_type;
		$total_approvals = $this->photo_model->count_user_photo_list($search_by_status, $profile_type);

		$url = base_url().'admin/approvals/image';
		$url_params = array();
		if($search_by_status != '') {
        	array_push($url_params, 'status='.$search_by_status);
        }
		if($profile_type != '') {
        	array_push($url_params, 'type='.$profile_type);
        }
        if(!empty($url_params)) {
        	$url = $url.'?'.implode('&', $url_params);
        }

        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_approvals, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/approvals/view_image', $data);
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

				$userData[$req_info['content_type']] = $req_info['content_text'];
				$this->user_model->update_user_info($req_info['content_user_id'], $userData);

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

				if($req_info['is_profile_photo'] == 'yes' && $photo_status == 'active') {
					$act_photo_url = '';
					$act_photo_thumb_url = '';
					if($photo_status == 'active') {
						$act_photo_url = $req_info['photo_url'];
						$act_photo_thumb_url = $req_info['photo_thumb_url'];
					}
					$user_info_array = array(
						'user_active_photo' => $act_photo_url,
						'user_active_photo_thumb' => $act_photo_thumb_url
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


    public function updatePicture() {
        $this->lang->load('user_lang', $this->session->userdata('site_language'));        

        $photoURL= explode('/uploads/photos/', $this->input->post('url'));
        $tempFile   = $_FILES['file']['tmp_name'];
        $targetFile = "./uploads/photos/".$photoURL[1];

        $photoSubUrl = explode('/', $photoURL[1]);
        $targetFileThumb = "./uploads/photos/".$photoSubUrl[0] . "/thumbnails/".$photoSubUrl[1];

        $this->load->helper('image_helper');
        $profille_photo = image_compress($tempFile, $targetFile, 100);
        $profille_photo_thumb = image_compress_thumbnail($tempFile, $targetFileThumb, 70);

	    $response["status"] = true;

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
