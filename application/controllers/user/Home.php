<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $per_page = 16;

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url(),'location',301);
        }
    }
    public function getuserinfo(){
	    // $this->load->model(['Vip_package_model', 'user_model', 'kiss_model', 'favorite_model', 'question_model', 'contact_request_model','language_model', 'saved_search_model', 'static_data_model']);
	    // $vip = $this->Vip_package_model->get_all_vip_package_list();
	    // print "<pre>";
	    // var_dump($vip);die;
    	// $userInfo = $this->user_model->get_user_by_username($_GET['username'])->row();
    	// print "<pre>";
    	// var_dump($userInfo);die;
    	// $username = $_GET['username'];
    	$data = [
    		'package_status' => 'active',
    	];
    	$this->Vip_package_model->update_vip_package('8',$data);
    }
	public function index() {
    	$data = array();

	    $this->load->model(['site_model', 'user_model', 'kiss_model', 'favorite_model', 'question_model', 'contact_request_model','language_model', 'saved_search_model', 'static_data_model']);

		if(!$this->session->has_userdata('site_setting')) {
			$settings = $this->site_model->get_website_settings();
			$this->session->set_userdata('site_language', $settings["default_language"]);
			$this->session->set_userdata('site_setting', $settings);
		}

	    $user_id = $this->session->userdata('user_id');
	    $user_gender = $this->session->userdata('user_gender');
	    $user_interested_in = $this->session->userdata('user_interested_in');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
    	$data["user_latitude"] = $this->session->userdata('user_latitude');
		$data["user_longitude"] = $this->session->userdata('user_longitude');

		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == base_url('home')) {
				if($this->session->has_userdata("home_search_parameters")) {
					$this->session->unset_userdata("home_search_parameters");
					$this->session->unset_userdata("home_search_type");
					$this->session->unset_userdata("using_saved_search");
				}
			}
		}

		if(isset($_POST['btn-search'])) {
			// BASIC SEARCH MODULE
			$this->session->unset_userdata("home_search_parameters");

			$age_range = explode(',', $this->input->post('age_range'));
			$distance = explode(',',  $this->input->post('distance'));
			$basic_search_array = array(
				'location' => $this->input->post('location'),
				'location_latitude' => $this->input->post('location_latitude'),
				'location_longitude' => $this->input->post('location_longitude'),
				'age_range' => $this->input->post('age_range'),
				'start_age_range' => date('Y-m-d',strtotime('-'.trim($age_range[0]).' year')),
				'end_age_range' => date('Y-m-d',strtotime('-'.trim($age_range[1]+1).' year')),
				'distance' => $this->input->post('distance'),
				'min_distance' => $distance[0],
				'max_distance' => $distance[1],
			);

			$this->session->set_userdata("using_saved_search", false);
			$this->session->set_userdata("home_search_type", 'basic');
			$this->session->set_userdata("home_search_parameters", $basic_search_array);
		}
		if(isset($_POST['btn-start-search'])) {
			// ADVANCED SEARCH MODULE
			$this->session->unset_userdata("home_search_parameters");
			$age_range = explode(',', $this->input->post('age_range'));
			$distance = explode(',',  $this->input->post('distance'));
			$size_range = explode(',',  $this->input->post('size_range'));
			$serious_relationship = ($this->input->post('serious_relationship'))?'yes':'no';
			$contact_request = '';
			if($serious_relationship == 'no') {
				if($this->input->post('contact_request')) {
					$contact_request = implode(',', $this->input->post('contact_request'));
				}
			}
			$activity_and_quality = '';
			if($this->input->post('activity_and_quality')) {
				$activity_and_quality = implode(',', $this->input->post('activity_and_quality'));
			}

			$advanced_search_array = array(
				'location' => $this->input->post('location'),
				'location_latitude' => $this->input->post('location_latitude'),
				'location_longitude' => $this->input->post('location_longitude'),		
				'age_range' => $this->input->post('age_range'),
				'start_age_range' => date('Y-m-d',strtotime('-'.trim($age_range[0]).' year')),
				'end_age_range' => date('Y-m-d',strtotime('-'.trim($age_range[1]+1).' year')),
				'distance' => $this->input->post('distance'),
				'min_distance' => $distance[0],
				'max_distance' => $distance[1],
				'size_range' => $this->input->post('size_range'),
				'min_size_range' => $size_range[0],
				'max_size_range' => $size_range[1],
				'figure' => $this->input->post('figure'),
				'ethnicity' => $this->input->post('ethnicity'),
				'hair_color' => $this->input->post('hair_color'),
				'eye_color' => $this->input->post('eye_color'),
				'smoker' => $this->input->post('smoker'),
				'user_languages' => $this->input->post('user_languages'),
				'serious_relationship' => $serious_relationship,
				'contact_request' => $contact_request,
				'activity_and_quality' => $activity_and_quality,
			);

			$this->session->set_userdata("using_saved_search", false);
			$this->session->set_userdata("home_search_type", 'advanced');
			$this->session->set_userdata("home_search_parameters", $advanced_search_array);
		}

		if(isset($_POST['btn-saved-search'])) {
			// use saved search for searching data
			$saved_search = $this->saved_search_model->get_user_saved_search($user_id);

			if($saved_search) {
				$this->session->unset_userdata("home_search_parameters");
				$age_range = explode(',', $saved_search['age_range']);
				$distance = explode(',',  $saved_search['distance']);
				$size_range = explode(',',  $saved_search['size_range']);
				
				$advanced_search_array = array(
					'location' => $saved_search['location'],
					'location_latitude' => $saved_search['location_latitude'],
					'location_longitude' => $saved_search['location_longitude'],
					'age_range' => $saved_search['age_range'],
					'start_age_range' => date('Y-m-d',strtotime('-'.trim($age_range[0]).' year')),
					'end_age_range' => date('Y-m-d',strtotime('-'.trim($age_range[1]+1).' year')),
					'distance' => $saved_search['distance'],
					'min_distance' => $distance[0],
					'max_distance' => $distance[1],
					'size_range' => $saved_search['size_range'],
					'min_size_range' => $size_range[0],
					'max_size_range' => $size_range[1],
					'figure' => $saved_search['figure'],
					'ethnicity' => $saved_search['ethnicity'],
					'hair_color' => $saved_search['hair_color'],
					'eye_color' => $saved_search['eye_color'],
					'smoker' => $saved_search['smoker'],
					'user_languages' => $saved_search['user_languages'],
					'serious_relationship' => $saved_search['serious_relationship'],
					'contact_request' => $saved_search['contact_request'],
					'activity_and_quality' => $saved_search['activity_and_quality'],
				);

				$this->session->set_userdata("using_saved_search", true);
				$this->session->set_userdata("home_search_type", 'advanced');
				$this->session->set_userdata("home_search_parameters", $advanced_search_array);
			} else {
				$this->session->set_flashdata('message', 'no_any_saved_search_found');
			}
		}

		if(isset($_POST['btn-delete-search'])) {
			$isalreadySaved = $this->saved_search_model->is_already_present($user_id);

			if($isalreadySaved) {
				$success_flg = $this->saved_search_model->delete_user_saved_search($user_id);

				if($success_flg) {
					$this->session->set_userdata("using_saved_search", false);
					$this->session->set_flashdata('message', 'your_search_has_been_deleted_successfully');
				}						
			} else {
				$this->session->set_flashdata('message', 'no_any_saved_search_found');	
			}
		}

		if(isset($_POST['btn-save-search'])) {
			// Saving or updating search
			$serious_relationship = ($this->input->post('serious_relationship'))?'yes':'no';
			$contact_request = '';
			if($serious_relationship == 'no') {
				if($this->input->post('contact_request')) {
					$contact_request = implode(',', $this->input->post('contact_request'));
				}
			}
			$activity_and_quality = '';
			if($this->input->post('activity_and_quality')) {
				$activity_and_quality = implode(',', $this->input->post('activity_and_quality'));
			}

			$saving_data_array = array(
				'location' => $this->input->post('location'),
				'location_latitude' => $this->input->post('location_latitude'),
				'location_longitude' => $this->input->post('location_longitude'),
				'age_range' => $this->input->post('age_range'),
				'distance' => $this->input->post('distance'),
				'size_range' => $this->input->post('size_range'),
				'figure' => $this->input->post('figure'),
				'ethnicity' => $this->input->post('ethnicity'),
				'hair_color' => $this->input->post('hair_color'),
				'eye_color' => $this->input->post('eye_color'),
				'smoker' => $this->input->post('smoker'),
				'user_languages' => $this->input->post('user_languages'),
				'serious_relationship' => $serious_relationship,
				'contact_request' => $contact_request,
				'activity_and_quality' => $activity_and_quality,
				'saved_search_flag' => 'web'
			);

			$isalreadySaved = $this->saved_search_model->is_already_present($user_id);
			if($isalreadySaved) {
				$success_flg = $this->saved_search_model->update_user_saved_search($user_id, $saving_data_array);
			} else {
				$saving_data_array['saved_search_by_user'] = $user_id;
				$success_flg = $this->saved_search_model->insert_user_saved_search($saving_data_array);
			}
			if($success_flg) {
				$this->session->set_flashdata('message', 'your_search_has_been_saved_successfully');
			}
		}
		if(!isset($_POST['btn-saved-search']) && !isset($_POST['btn-search'])){
			$default_values = array(
				'location' => '',
				'age_range' => '18,65',
				'start_age_range' => '2002-06-07',
				'end_age_range' => '1954-06-07',
				'distance' => '0,1000',
				'min_distance' => '0',
				'max_distance' => '1000',
			);
			$this->session->set_userdata("home_search_type", 'basic');
			$this->session->set_userdata("home_search_parameters", $default_values);
		}
		if($this->input->post('location') != ''){
			$this->session->set_userdata("home_search_type", 'basic');
		}
		$data["users"] = false;
		$total_users = $this->user_model->get_active_users_searched_count($user_id, $user_interested_in);

		/* Static Data model */
		$data["figure_list"] = $this->static_data_model->get_figure_list();
		$data["ethnicity_list"] = $this->static_data_model->get_ethnicity_list();
		$data["eye_color_list"] = $this->static_data_model->get_eye_color_list();
		$data["hair_color_list"] = $this->static_data_model->get_hair_color_list();

		unset($data["figure_list"][0]);
		unset($data["ethnicity_list"][0]);
		unset($data["eye_color_list"][0]);
		unset($data["hair_color_list"][0]);
		
		$data["contact_requests"] = $this->contact_request_model->get_active_contact_request_list();
		$data["languages"] = $this->language_model->get_spoken_language_list();
		$data['questions'] = $this->question_model->get_active_question_list($user_gender, 30, 0);
		$this->load->view('user/home/index', $data);
	}
	

	// Web service for listing Users for Chatting
	public function getHomeUsers() {
		$this->load->model(['user_model', 'kiss_model', 'favorite_model']);
		
		$user_id = $this->session->userdata('user_id');
		$user_interested_in = $this->session->userdata('user_interested_in');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

		$per_page = $this->per_page;
		$offset = ($per_page * $this->input->post('page_no'));

    	$homeUsers = $this->user_model->get_active_users_searched_list($user_id, $user_interested_in, $per_page, $offset);

		if($homeUsers) {
			$todayGMT = gmdate('Y-m-d');

			foreach ($homeUsers as $key => $member_row) {
				if($member_row['user_active_photo_thumb'] == '') {
					$homeUsers[$key]['user_active_photo_thumb'] = "images/avatar/".$member_row['user_gender'].".png";
				}

				$homeUsers[$key]['is_kissed'] = $this->kiss_model->is_member_kissed($user_id, $member_row['user_id']);
				$homeUsers[$key]['is_favorite'] = $this->favorite_model->is_favorite_member($user_id, $member_row['user_id']);

				// is Online now
				if($member_row["last_online_time"] <= USER_IS_ONLINE_CHECK_TIME && $member_row["last_online_time"] != "") {
					$homeUsers[$key]['is_online'] = true;
				} else {
					$homeUsers[$key]['is_online'] = false;
				}

				// is new user
				if(strtotime($member_row["user_register_date"]) >= strtotime('-'.IS_NEW_USER_FOR_DAYS.' days', strtotime($todayGMT))) {
					$homeUsers[$key]['is_new'] = true;
				} else {
					$homeUsers[$key]['is_new'] = false;
				}
			}

			$response['status'] = true;
			$response['errorCode'] = 0;
			$response['data'] = $homeUsers;
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
