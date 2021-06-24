<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kisses extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

	public function index() {		
		if($this->input->get('type') == 'sent') {
			$kiss_type = 'sent';
		} else {
			$kiss_type = 'received';
		}

    	$data = array();
    	$data['kiss_type'] = $kiss_type;

	    $this->load->model(['kiss_model', 'favorite_model','question_model']);

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

    	if($kiss_type == 'received') {
    		$this->kiss_model->update_unseen_as_seen_to_user($user_id);
			$data["users"] = $this->kiss_model->get_active_received_kisses_list($user_id, $per_page, $offset);
    	} else {
			$data["users"] = $this->kiss_model->get_active_sent_kisses_list($user_id, $per_page, $offset);
		}

		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('kisses'));
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

        if($kiss_type == 'received') {
			$total_users = $this->kiss_model->get_active_received_kisses_count($user_id);
        } else {
			$total_users = $this->kiss_model->get_active_sent_kisses_count($user_id);
		}

        $url = base_url().'kisses?type='.$kiss_type;
	    $this->load->library("pagination");
		$config = pagination_config($url, $per_page, $total_users, 4);
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();

		$data['questions'] = $this->question_model->get_active_question_list($user_gender, 30, 0);
		$this->load->view('user/kisses/index', $data);
	}

	// we service for sending kiss to member
	public function send_kiss() {
		$this->load->model(['kiss_model', 'user_model', 'email_model']);

		$member_id_enc = $this->input->post('member_id');
		$user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$alreadyAdded = $this->kiss_model->is_member_kissed($user_id, $member_id);

		if($alreadyAdded == true) {
			$response['status'] = false;
			$response['errorCode'] = 0;
			$response['message'] = $this->lang->line('already_kissed');
		} else {
			$insertData = array(
				'kiss_sender_id' => $user_id, 
				'kiss_receiver_id' => $member_id,
				'kiss_added_date' => date('Y-m-d H:i:s')
			);
			$success = $this->kiss_model->insert_user_kiss($insertData);

			if($success > 0) {
                // Send Email to Kiss receiver
                $member_info = $this->user_model->get_active_user_information($member_id);
                $to_email = $member_info['user_email'];
                $subject = $this->lang->line('kiss_received');
                $data['message_sender_name'] = $this->session->userdata('user_username');
                $data['message_receiver_name'] = $member_info['user_access_name'];
                $data['message_sender_pic'] = base_url($this->session->userdata('user_avatar'));
                $data['email_template'] = 'email/send_kiss';
                $email_message = $this->load->view('templates/email/main', $data, true);
                @$this->email_model->sendEMail($to_email, $subject, $email_message);

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

	// we service for removing kiss sent to member
	public function remove_kiss() {
		$this->load->model(['kiss_model']);

		$member_id_enc = $this->input->post('member_id');
		$user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$alreadyAdded = $this->kiss_model->is_member_kissed($user_id, $member_id);

		if($alreadyAdded == false) {
			$response['status'] = false;
			$response['errorCode'] = 0;
			$response['message'] = $this->lang->line('already_removed');
		} else {
			$delete_where = array(
				'kiss_sender_id' => $user_id, 
				'kiss_receiver_id' => $member_id
			);
			$success = $this->kiss_model->delete_kisses($delete_where);

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
