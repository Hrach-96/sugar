<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitors extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if(!$this->session->has_userdata('user_id')) {
			redirect(base_url());
		}
    }

	public function index() {
        if($this->input->get('type') == 'by_me') {
            $visitor_type = 'by_me';
        } else {
            $visitor_type = 'to_me';
        }

    	$data = array();
        $data['visitor_type'] = $visitor_type;
        $this->load->model(['visitor_model', 'kiss_model', 'favorite_model', 'question_model']);

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

        if($visitor_type == 'to_me') {
            $this->visitor_model->update_unseen_as_seen_to_user($user_id);
		    $data["users"] = $this->visitor_model->get_active_visitors_list($user_id, $per_page, $offset);
        } else {
            $data["users"] = $this->visitor_model->get_active_profile_visited_list($user_id, $per_page, $offset);
        }

		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('visitors'));
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
        if($visitor_type == 'to_me') {
		    $total_users = $this->visitor_model->get_active_visitors_count($user_id);
        } else {
            $total_users = $this->visitor_model->get_active_profile_visited_count($user_id);
        }

        $url = base_url().'visitors?type='.$visitor_type;
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();

        $data['questions'] = $this->question_model->get_active_question_list($user_gender, 30, 0);
		$this->load->view('user/visitors/view', $data);
	}


}
