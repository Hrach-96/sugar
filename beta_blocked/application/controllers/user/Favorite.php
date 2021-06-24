<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favorite extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

	public function index() {
    	$data = array();
		if($this->input->get('type') == 'to_me') {
			$favorite_type = 'to_me';
		} else {
			$favorite_type = 'by_me';
		}
		$data['favorite_type'] = $favorite_type;

	    $this->load->model(['kiss_model', 'favorite_model', 'question_model']);

	    $user_id = $this->session->userdata('user_id');
	    $user_gender = $this->session->userdata('user_gender');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
    	$data["user_latitude"] = $this->session->userdata('user_latitude');
		$data["user_longitude"] = $this->session->userdata('user_longitude');

    	$per_page = 12;
    	$page_no = 0;
    	if(isset($_GET['per_page'])) {
    		$page_no = $_GET['per_page'] - 1;
    	}
    	$offset = $page_no * $per_page;

		if($favorite_type == 'by_me') {
			$data["users"] = $this->favorite_model->get_active_by_me_favorites_list($user_id, $per_page, $offset);
		} else {
			$this->favorite_model->update_unseen_as_seen_to_user($user_id);
			$data["users"] = $this->favorite_model->get_active_to_me_favorites_list($user_id, $per_page, $offset);
		}

		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('favorites'));
			}
		}

        $tmp_users = array();
        // check user is kissed and favorite
        if($data["users"]) {
	        foreach ($data["users"] as $member_row) {
	            $member_row['is_kissed'] = $this->kiss_model->is_member_kissed($user_id, $member_row['user_id']);
	            $member_row['is_favorite'] = $this->favorite_model->is_favorite_member($user_id, $member_row['user_id']);
	            $tmp_users[] = $member_row;
	        }
    	}
        $data["users"] = $tmp_users;
        if($favorite_type == 'by_me') {        
			$total_users = $this->favorite_model->get_active_by_me_favorites_count($user_id);
		} else {
			$total_users = $this->favorite_model->get_active_to_me_favorites_count($user_id);
		}

        $url = base_url().'favorites?type='.$favorite_type;
	    $this->load->library("pagination");
		$config = pagination_config($url, $per_page, $total_users, 4);
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();

		$data['questions'] = $this->question_model->get_active_question_list($user_gender, 30, 0);
		$this->load->view('user/favorite/index', $data);
	}
	
	// we service for adding member in user favorite list
	public function add_to_favorite() {
		$this->load->model(['favorite_model']);

		$member_id_enc = $this->input->post('member_id');
		$user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $settings = $this->session->userdata('site_setting');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$alreadyAdded = $this->favorite_model->is_favorite_member($user_id, $member_id);

		if($alreadyAdded == true) {
			$response['status'] = false;
			$response['errorCode'] = 0;
			$response['message'] = $this->lang->line('already_added');
		} else {
			$insertData = array(
				'user_favorite_from_id' => $user_id, 
				'user_favorite_to_id' => $member_id,
				'user_favorite_added_date' => date('Y-m-d H:i:s')
			);
			$success = $this->favorite_model->insert_user_favorite($insertData);

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

	// we service for deleting member from user favorite list
	public function delete_from_favorite() {
		$this->load->model(['favorite_model']);

		$member_id_enc = $this->input->post('member_id');
		$user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $settings = $this->session->userdata('site_setting');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$alreadyAdded = $this->favorite_model->is_favorite_member($user_id, $member_id);

		if($alreadyAdded == false) {
			$response['status'] = false;
			$response['errorCode'] = 0;
			$response['message'] = $this->lang->line('already_removed');
		} else {
			$delete_where = array(
				'user_favorite_from_id' => $user_id, 
				'user_favorite_to_id' => $member_id
			);
			$success = $this->favorite_model->delete_from_favorite($delete_where);

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
