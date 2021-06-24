<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function login() {
		$data = array();
		$this->load->model(['auth_model','site_model', 'vip_package_model', 'user_model', 'photo_model']);

		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));
			
		$res = $this->auth_model->login(
			$this->input->post('username'),
			$this->input->post('password')
		);
			
		if ($res !== false ) {
			
			if($res->user_status == 'blocked') {
				$data["status"] = false;
				$data["error"]	= 999;
				$data["message"] = $this->lang->line('banned_error');
			} else {

				if($res->user_status == 'active') {

					// Get active profile picture photo
					$profile_pic = $this->photo_model->get_user_profile_pic($res->user_id);

					$isProfilePicture = false;
					$isPictureApproved = false;
					if($profile_pic) {
						$avatar = $profile_pic['photo_thumb_url'];
						$isProfilePicture = true;
						if($profile_pic['photo_status'] == 'active') {
							$isPictureApproved = true;
						}
					} else {
						$avatar = "images/avatar/".$res->user_gender.".png";
					}

				    $this->session->set_userdata(
						array(
							"user_id"		=> $res->user_id,
							"user_username"	=> $res->user_access_name,
							"user_email"	=> $res->user_email,
							"user_avatar"	=> $avatar,
							"user_type"		=> $res->user_type,
							"user_gender"	=> $res->user_gender,
							"user_is_vip"	=> $res->user_is_vip,
							"user_city"		=> $res->user_city,
							"user_latitude"	=> $res->user_latitude,
							"user_longitude"=> $res->user_longitude,
							"user_interested_in" => $res->user_interested_in,
							"user_credits"=> $res->user_credits,
							"user_diamonds" => $res->user_diamonds,
							"user_is_online" => 'yes',
							"user_offline_activity_start_date" => '',
							"user_last_login_date" => $res->user_last_login_date,
							"welcome_note_shown" => false
						)
					);

				    if($res->online_switcher_activated_date != '') {
						$today = date_create(gmdate('Y-m-d H:i:s'));
						$switcher_activated = date_create($res->online_switcher_activated_date);
						$diff_d = date_diff($today, $switcher_activated);

						if($diff_d->h < 24 && $diff_d->d <= 0) {
	                		$this->session->set_userdata('user_is_online', 'no');
	                		$this->session->set_userdata('user_offline_activity_start_date', $res->online_switcher_activated_date);
						}
					}

					// Check User is VIP or Not
					$user_is_vip = 'no';
					$curr_vip_package = $this->vip_package_model->get_user_buy_vip_package($res->user_id);
					if($curr_vip_package) {
						$expiry_date = date('Y-m-d', strtotime("+".$curr_vip_package['package_validity_in_months']." months", strtotime($curr_vip_package['buy_vip_date'])));
						if($expiry_date >= gmdate('Y-m-d')) {
							$user_is_vip = 'yes';
						}
					}
					$this->session->set_userdata('user_is_vip', $user_is_vip);

					// check user uploaded photo or not. If not then show him upload profile pic dialong for first 3 logins
					if($res->user_active_photo_thumb == '' && $res->show_upload_profile_pic_count > 0) {
						$show_upload_profile_pic_count = $res->show_upload_profile_pic_count - 1;
						$this->session->set_userdata('show_upload_profile_pic_dialog', true);
						$this->auth_model->update_user_info($res->user_id, array('show_upload_profile_pic_count' => $show_upload_profile_pic_count));
					}

					$userRank = calculate_user_profile_rank($user_is_vip, $res->user_verified, $isProfilePicture, $isPictureApproved, true);

					$this->user_model->update_user($res->user_id, array('user_is_vip' => $user_is_vip, 'user_last_login_date' => gmdate('Y-m-d H:i:s'), 'user_rank' => $userRank));

					// Response
					$data["status"] = true;
					$data["message"] = $this->lang->line('login_success');
					$data["error"]= 0;
					if($res->user_type == 'admin') {
						$data["url_redirect"] = base_url('admin/dashboard');
					} else if($res->user_type == 'agent') {
						$data["url_redirect"] = base_url('agent/dashboard');
					} else {
						$data["url_redirect"] = base_url('home');
					}
				} else {
					$data["status"] = false;
					$data["error"]	= 998;
					$data["message"] = $this->lang->line('account_not_active');
				}		
			}
		} else {
			$data["status"]	= false;
			$data["error"]	= 999;
			$data["message"] = $this->lang->line('invalid_username_password');
		}
		
    	header('Content-type: application/json;');
		echo json_encode($data);
	}


	function logout() {
		$this->load->model(['user_model']);
		$this->user_model->clear_user_login_session();
		//$this->session->unset_userdata('fb_token');

		$this->session->sess_destroy();
		redirect(base_url());
    }


	function checkUsernameExists() {
 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->lang->load('site_lang', $this->session->userdata('site_language'));
		$this->form_validation->set_rules('username', 'username', 'is_unique[tbl_users.user_access_name]');

        if ($this->form_validation->run() == FALSE) {
            $data["status"]	= false;
			$data["error"]	= 1;
			$data["message"] = $this->lang->line('this_username_is_already_taken');
        } else {
			$data["status"]	= true;
			$data["error"]	= 0;
			$data["message"] = $this->lang->line('success');
		}
		
    	header('Content-type: application/json;');
		echo json_encode($data);
	}

	function checkEmailExists() {
 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->lang->load('site_lang', $this->session->userdata('site_language'));
		$this->form_validation->set_rules('email', 'email', 'is_unique[tbl_users.user_email]');

        if ($this->form_validation->run() == FALSE) {
            $data["status"]	= false;
			$data["error"]	= 1;
			$data["message"] = $this->lang->line('this_email_is_already_registered');
        } else {
			$data["status"]	= true;
			$data["error"]	= 0;
			$data["message"] = $this->lang->line('success');
		}
		
    	header('Content-type: application/json;');
		echo json_encode($data);
	}

	function verifyCaptcha() {
		$this->lang->load('site_lang', $this->session->userdata('site_language'));

        if ($this->input->post('captcha_text') != $this->session->userdata('captcha_text')) {
            $data["status"]	= false;
			$data["message"] = $this->lang->line('please_enter_image_text');
        } else {
			$data["status"]	= true;
			$data["message"] = $this->lang->line('success');
		}
		
    	header('Content-type: application/json;');
		echo json_encode($data);
	}

	function register() {

 		$this->load->helper('form');
 		$this->load->library('form_validation');

		$this->load->model(['auth_model','site_model', 'contact_request_model', 'language_model','interest_model', 'sport_model', 'photo_model', 'email_model', 'user_content_model']);

		$settings = $this->session->userdata('site_setting');
		$this->lang->load('site_lang', $this->session->userdata('site_language'));

		$this->form_validation->set_rules('user_gender', 'user_gender', 'required|trim');
		$this->form_validation->set_rules('user_inerested_in', 'user_inerested_in', 'required|trim');
		$this->form_validation->set_rules('captcha_text', 'captcha_text', 'required|trim');
		$this->form_validation->set_rules('user_email', 'user_email', 'required|valid_email|trim|is_unique[tbl_users.user_email]', array('is_unique' => $this->lang->line('this_email_is_already_registered')));
		$this->form_validation->set_rules('username', 'username', 'required|trim|is_unique[tbl_users.user_access_name]', array('is_unique' => $this->lang->line('this_username_is_already_taken')));
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('date_of_birth', 'date_of_birth', 'required|trim');
		
		//if($this->input->post('user_gender') == 'female') {
		//$this->form_validation->set_rules('user_arangement', 'user_arangement', 'required|trim');
		//}

		$this->form_validation->set_rules('serious_relationship', 'serious_relationship', '');
		$this->form_validation->set_rules('user_contact_request', 'user_contact_request', '');

		$this->form_validation->set_rules('user_postcode', 'user_postcode', 'required|numeric|trim');
		$this->form_validation->set_rules('user_location', 'user_location', 'required|trim');
		$this->form_validation->set_rules('user_figure', 'user_figure', 'required|trim');
		$this->form_validation->set_rules('user_size', 'user_size', 'numeric|trim');
		$this->form_validation->set_rules('user_hair_color', 'user_hair_color', 'required|trim');
		$this->form_validation->set_rules('user_eye_color', 'user_eye_color', 'required|trim');
		$this->form_validation->set_rules('user_ethnicity', 'user_ethnicity', 'required|trim');
		$this->form_validation->set_rules('user_job', 'user_job', 'required|trim');
		$this->form_validation->set_rules('user_is_smoker', 'user_is_smoker', 'trim');
		$this->form_validation->set_rules('user_has_child', 'user_has_child', 'trim');

		$this->form_validation->set_rules('user_sports', 'user_sports', 'trim');
		$this->form_validation->set_rules('user_interests', 'user_interests', 'trim');
		$this->form_validation->set_rules('user_languages', 'user_languages', 'trim');

		$this->form_validation->set_rules('my_description', 'my_description', 'trim');
		$this->form_validation->set_rules('how_can_man_impress_you', 'how_can_man_impress_you', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $data["status"]	= false;
			$data["error"]	= 1;
			$data["message"] = $this->lang->line('please_try_again_later');
			$data["error_array"] = $this->form_validation->error_array();
        } else {
	         if ($this->input->post('captcha_text') != $this->session->userdata('captcha_text')) {
	            $data["status"]	= false;
				$data["error"]	= 1;
				$data["message"] = $this->lang->line('please_try_again_later');
				$data["error_array"]["captcha_text"] = $this->lang->line('please_enter_image_text');
				// Captcha for security purpose 
				$this->load->helper('captcha');
				$captcha_vals = array(
			        'img_path'      => './images/captcha/',
			        'img_url'       => base_url().'images/captcha/',
	       			'word_length'   => 6,
	        		'font_size'     => 22,
	        		'pool'			=> '0123456789',
	   				'colors'        => array(
	                	'background' => array(9, 2, 22),
	                	'border' => array(9, 2, 22),
	                	'text' => array(239, 232, 11),
	                	'grid' => array(12, 79, 193)
	        		)
				);
				$cap_res = create_captcha($captcha_vals);
				$this->session->set_userdata('captcha_text', $cap_res['word']);
				$data["captcha_image_url"] = base_url('images/captcha/'.$cap_res['filename']);
	         } else {
	        	$user_password = sha1($this->input->post('password'));

	        	$login_register_array = array(
	        		'user_access_name' => $this->input->post('username'),
	        		'user_password' => $user_password,
	        		'user_email' => $this->input->post('user_email'),
	        		'user_type' => 'user',
	        		'user_status' => 'pending',
	        		'user_verified' => 'no',
	        		'user_is_vip' => 'no',
	        		'user_rank' => 29,
	        		'user_flag' => 'web',
	        		'user_credits' => $settings['free_credits'],
	        		'user_diamonds' => 0,
	        		'user_taken_free_credits' => $settings['free_credits'],
	        		'ip_address' => $this->input->ip_address()
	        	);

	        	// START Transaction
	            $this->db->trans_begin();
	        	$user_id = $this->auth_model->create_user($login_register_array);

	        	if($user_id) {
	        		$profille_photo = "";
					$profille_photo_thumb = "";
					$show_upload_profile_pic_count = SHOW_UPLOAD_PROFILE_PICTURE_DIALOG_COUNT;

		        	// Upload user image
					if (!empty($_FILES)) {
				    	// Check if the directory already exists
			        	if (!file_exists("./uploads/photos/" . $user_id . "/")) {
			        		mkdir("./uploads/photos/" . $user_id . "/");
			        		mkdir("./uploads/photos/" . $user_id . "/thumbnails/");
			        	}

						$nameFile 	= rand(0,999999).time();
					    $tempFile 	= $_FILES['profile_pic']['tmp_name'];
					    $fileTypes 	= array('jpg','jpeg','png', 'JPG', 'JPEG', 'PNG');
					    $fileParts 	= pathinfo($_FILES['profile_pic']['name']);

					    $targetPath = "./uploads/photos/" . $user_id . "/";
					    $targetPathThumb = $targetPath . "thumbnails/";

					    $targetPathEchoThumb = "uploads/photos/" . $user_id . "/thumbnails/";
					    $targetPathEcho = "uploads/photos/" . $user_id . "/";
					    
					    $targetFile =  str_replace('//','/',$targetPath) . $nameFile . "." . $fileParts["extension"];
					    $targetFileThumb = str_replace('//','/',$targetPathThumb) . $nameFile . "." . $fileParts["extension"];
					    $targetFileEcho = str_replace('//','/',$targetPathEcho) . $nameFile . "." . $fileParts["extension"];
					    $targetFileEchoThumb = str_replace('//','/',$targetPathEchoThumb) . $nameFile . "." . $fileParts["extension"];
					
						$this->load->helper('image_helper');
					    if (in_array($fileParts['extension'], $fileTypes)) {
							$pr_photo = image_compress($tempFile, $targetFile, 100);
					    	$pr_photo_thumb = image_compress_thumbnail($tempFile, $targetFileThumb, 70);
							$profille_photo = $targetFileEcho;
							$profille_photo_thumb = $targetFileEchoThumb;

			                $photo_array = array(
			                    'photo_user_id_ref' => $user_id,
			                    'photo_url' => $profille_photo,
			                    'photo_thumb_url' => $profille_photo_thumb,
			                    'photo_added_date' => gmdate("Y-m-d H:i:s"),
			                    'photo_type' => 'profile',
			                    'photo_status' => 'inactive',
			                    'is_profile_photo' => 'yes',
			                    'photo_flag' => 'web'
			                );
			                $this->photo_model->insert_user_photo($photo_array);
			                $show_upload_profile_pic_count = 0;
						}
					}

	        		// Use : user Transaction strategy
	        		$this->load->library('encryption');
	        		$this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
	        		$user_enc_id = $this->encryption->encrypt($user_id);

	        		$u_user_array = array(
	        			'user_id_encrypted' => $user_enc_id
	        		);
					$this->auth_model->update_user($user_id, $u_user_array);

					$user_city = explode(',', $this->input->post('user_location'));
					$user_country = $this->input->post('user_country');

					if($this->input->post('user_country') == '') {
						if($this->session->has_userdata('user_currlocation')) {
							$cur_loc_arr = $this->session->userdata('user_currlocation');
							$user_country = $cur_loc_arr['country'];
						}
					}

	        		// Insert User information
		        	$user_latitude = $this->input->post('user_latitude');
		        	$user_longitude = $this->input->post('user_longitude');
		        	
		        	if($user_latitude == '' || $user_longitude == '') {
		        		if($this->session->has_userdata('user_currlocation')) {
		        			$cur_loc_arr = $this->session->userdata('user_currlocation');
		        			$user_latitude = $cur_loc_arr['latitude'];
		        			$user_longitude = $cur_loc_arr['longitude'];
		        		}
		        	}

		        	if($this->session->has_userdata('site_language')) {
		        		$language_id_ref =  $this->session->userdata('site_language');
		        	} else {
		        		$language_id_ref =  DEFAULT_LANGUAGE;
		        	}

		        	$user_information_array = array(
		        		'user_id_ref' => $user_id,
		        		'user_gender' => $this->input->post('user_gender'),
		        		'user_interested_in' => $this->input->post('user_inerested_in'),
		        		'user_birthday' => $this->input->post('date_of_birth'),
		        		//'user_about' => $this->input->post('my_description'),
		        		//'user_how_impress' => $this->input->post('how_can_man_impress_you'),
		        		'user_country' => $user_country,
		        		'user_postcode' => $this->input->post('user_postcode'),
		        		'user_city' => $user_city[0],
		        		'user_latitude' => $user_latitude,
		        		'user_longitude' => $user_longitude,
		        		'language_id_ref' => $language_id_ref,
		        		'user_figure' => $this->input->post('user_figure'),
		        		'user_height' => $this->input->post('user_size'),
		        		'user_job' => $this->input->post('user_job'),
		        		'user_ethnicity' => $this->input->post('user_ethnicity'),
		        		'user_arangement' => $this->input->post('user_arangement'),
		        		'user_hair_color' => $this->input->post('user_hair_color'),
		        		'user_eye_color' => $this->input->post('user_eye_color'),
		        		'user_smoker' => $this->input->post('user_is_smoker'),
		        		'user_has_child' => $this->input->post('user_has_child'),
		        		'user_active_photo' => NULL,
		        		'user_active_photo_thumb' => NULL,
		        		'show_upload_profile_pic_count' => $show_upload_profile_pic_count,
		        		'user_info_flag' => 'web'
		        	);

		        	if($this->input->post('serious_relationship') == 'yes') {
		        		$user_information_array['interested_in_serious_relationship'] = 'yes';
		        	}
		        	$this->auth_model->create_user_info($user_information_array);	

            		// Insert user about us info for approval
            		if($this->input->post('my_description') != '') {
		                $user_content_array = array(
		                    'content_user_id' => $user_id,
		                    'content_text' => $this->input->post('my_description'),
		                    'content_type' => 'user_about',
		                    'content_status' => 'pending',
		                    'content_added_date' => gmdate('Y-m-d H:i:s'),
		                    'content_flag' => 'web'
		                );
                    	$this->user_content_model->insert_user_content($user_content_array);
            		}

		            // Insert user man impress you info for approval
		            if($this->input->post('how_can_man_impress_you') != '') {
		                $user_content_array = array(
		                    'content_user_id' => $user_id,
		                    'content_text' => $this->input->post('how_can_man_impress_you'),
		                    'content_type' => 'user_how_impress',
		                    'content_status' => 'pending',
		                    'content_added_date' => gmdate('Y-m-d H:i:s'),
		                    'content_flag' => 'web'
		                );
		                $this->user_content_model->insert_user_content($user_content_array);
		            }

		            // Insert User Sports
		            if(!empty($this->input->post('user_sports'))) {
		                $user_sports_arr = explode(',', $this->input->post('user_sports'));
		                foreach ($user_sports_arr as $sport_id) {
	                        $user_sports_array = array(
	                            'user_sport_ref_id' => $sport_id,
	                            'sport_user_id' => $user_id,
	                            'user_sport_added_date' => date('Y-m-d H:i:s'),
	                            'user_sport_flag' => 'web'
	                        );
	                        $this->sport_model->insert_user_sport($user_sports_array);
		                }
		            }

		            // Insert User Interests
		            if(!empty($this->input->post('user_interests'))) {
		                $user_interests_arr = explode(',', $this->input->post('user_interests'));
		                foreach ($user_interests_arr as $interest_id) {
		                    $user_interests_array = array(
		                        'interest_id_ref' => $interest_id,
		                        'interest_user_id' => $user_id,
		                        'user_interest_added_date' => date('Y-m-d H:i:s'),
		                        'user_interest_flag' => 'web'
		                    );
		                    $this->interest_model->insert_user_interest($user_interests_array);
		                }
		            }

		            // Insert User Spoken Languages
		            if(!empty($this->input->post('user_languages'))) {
		                $user_languages_arr = explode(',', $this->input->post('user_languages'));
		                foreach ($user_languages_arr as $language_id) {
		                    $user_languages_array = array(
		                        'spoken_language_ref_lang_id' => $language_id,
		                        'spoken_language_user_id' => $user_id,
		                        'spoken_language_added_date' => date('Y-m-d H:i:s'),
		                        'spoken_language_flag' => 'web'
		                    );
		                    $this->language_model->insert_user_spoken_language($user_languages_array);
		                }
		            }

		        	// Insert User Contact Request : insert if user is not interested in serious relationship
		        	if($this->input->post('serious_relationship') != 'yes') {
			        	if($this->input->post('user_contact_request') != '') {
			        		$user_cont_req_arr = explode(',', $this->input->post('user_contact_request'));
			        		foreach ($user_cont_req_arr as $req_id) {
					        	$user_contact_req_array = array(
					        		'contact_request_contact_id' => $req_id,
					        		'contact_request_user_id' => $user_id,
					        		'user_contact_request_added_date' => date('Y-m-d H:i:s'),
					        		'user_contact_request_flag' => 'web'
					        	);
					        	$this->contact_request_model->insert_user_contact_request($user_contact_req_array);
				        	}
			        	}
		        	}

		        	if($this->db->trans_status() === FALSE) {
		        		$this->db->trans_rollback();
						$data["status"]	= false;
						$data["error"]	= 2;
						$data["message"] = $this->lang->line('internal_server_error');
		        	} else {
		        		$this->db->trans_commit();
						$data["status"]	= true;
						$data["error"]	= 0;
						$data["message"] = $this->lang->line('success');

						// send confirmation email
						if($profille_photo_thumb == '') {
							$profille_photo_thumb = "images/avatar/".$this->input->post('user_gender').".png";
						}
		        		$this->lang->load('user_lang', $this->session->userdata('site_language'));
		        		$encrypt_email = $this->encryption->encrypt($this->input->post('user_email'));
		        		$verify_url = base_url('auth/verify?hash='.urlencode($encrypt_email));		        		
                        $to_email = $this->input->post('user_email');
                        $subject = $this->lang->line('account_created_verify_your_email');
                        $data['user_pic'] = base_url($profille_photo_thumb);
                        $data['user_email_verify_url'] = $verify_url;
                        $data['email_template'] = 'email/user_registration';
                        $email_message = $this->load->view('templates/email/main', $data, true);
                        @$this->email_model->sendEMail($to_email, $subject, $email_message);
						$this->session->unset_userdata('captcha_text');
		        	}
	        	} else {
	        		$this->db->trans_rollback();
					$data["status"]	= false;
					$data["error"]	= 2;
					$data["message"] = $this->lang->line('internal_server_error');
	        	}
        	}
        }
		
    	header('Content-type: application/json;');
		echo json_encode($data);
	}
    
    function fb_login()
	{
		if($this->session->has_userdata('user_id')) {
			redirect(base_url() . "home");
		}

		$this->load->model(['site_model','photo_model','vip_package_model', 'user_model', 'auth_model']);
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		if ($this->facebook->logged_in())
		{ 
			$fb_user = $this->facebook->user();
			// Facebook login OK
			if ($fb_user['code'] === 200)
			{
				// User is logging in
				$fb_user_info = $this->user_model->get_user_info_by_fb_id($fb_user['data']['id']);
				// If user fb id not present then check is that email is already register or not
				if(empty($fb_user_info)) {
					$fb_user_info = $this->user_model->get_user_info_by_email($fb_user['data']['email']);
					// Then Update FB ID for that perticular user
					if(!empty($fb_user_info)) {
						$this->user_model->update_user($fb_user_info['user_id'], array('user_fb_id' => $fb_user['data']["id"]));
					}
				}

				if(!empty($fb_user_info))
				{
					// If already user info present then login directly
					if($fb_user_info["user_status"] == 'blocked') {
						$this->session->set_flashdata('message', $this->lang->line('banned_error'));
						redirect(base_url());
					} else {
						if($fb_user_info["user_status"] == 'active') {
							// Get active profile picture photo
							$profile_pic = $this->photo_model->get_user_profile_pic($fb_user_info['user_id']);
							if($profile_pic) {
								$avatar = $profile_pic['photo_thumb_url'];
							}

							$this->session->set_userdata(
								array(
									"user_id"		=> $fb_user_info['user_id'],
									"user_username"	=> $fb_user_info['user_access_name'],
									"user_email"	=> $fb_user_info['user_email'],
									"user_avatar"	=> $avatar,
									"user_type"		=> $fb_user_info['user_type'],
									"user_gender"	=> $fb_user_info['user_gender'],
									"user_is_vip"	=> $fb_user_info['user_is_vip'],
									"user_city"		=> $fb_user_info['user_city'],
									"user_latitude"	=> $fb_user_info['user_latitude'],
									"user_longitude"=> $fb_user_info['user_longitude'],
									"user_interested_in" => $fb_user_info['user_interested_in'],
									"user_credits"	=> $fb_user_info['user_credits'],
									"user_diamonds" => $fb_user_info['user_diamonds'],
									"user_is_online" => 'yes',
									"user_offline_activity_start_date" => '',
									"user_last_login_date" => $fb_user_info['user_last_login_date'],
									"welcome_note_shown" => false
								)
							);

							if($fb_user_info['online_switcher_activated_date'] != '') {
								$today = date_create(gmdate('Y-m-d H:i:s'));
								$switcher_activated = date_create($fb_user_info['online_switcher_activated_date']);
								$diff_d = date_diff($today, $switcher_activated);

								if($diff_d->h < 24 && $diff_d->d <= 0) {
			                		$this->session->set_userdata('user_is_online', 'no');
			                		$this->session->set_userdata('user_offline_activity_start_date', $fb_user_info['online_switcher_activated_date']);
								}
							}

							// Check User is VIP or Not
							$user_is_vip = 'no';
							$curr_vip_package = $this->vip_package_model->get_user_buy_vip_package($fb_user_info['user_id']);
							if($curr_vip_package) {
								$expiry_date = date('Y-m-d', strtotime("+".$curr_vip_package['package_validity_in_months']." months", strtotime($curr_vip_package['buy_vip_date'])));
								if($expiry_date >= gmdate('Y-m-d')) {
									$user_is_vip = 'yes';
								}
							}
							$this->session->set_userdata('user_is_vip', $user_is_vip);
							$this->user_model->update_user($fb_user_info['user_id'], array('user_is_vip' => $user_is_vip));

							// check user uploaded photo or not. If not then show him upload profile pic dialong for first 3 logins
							if($fb_user_info['user_active_photo_thumb'] == '' && $fb_user_info['show_upload_profile_pic_count'] > 0) {
								$show_upload_profile_pic_count = $fb_user_info['show_upload_profile_pic_count'] - 1;
								$this->session->set_userdata('show_upload_profile_pic_dialog', true);
								$this->auth_model->update_user_info($fb_user_info['user_id'], array('show_upload_profile_pic_count' => $show_upload_profile_pic_count));
							}

							redirect(base_url('home'));
						} else {
							$this->session->set_flashdata('message', $this->lang->line('account_not_active'));
							redirect(base_url());
						}
					}
				} else {
					// If user not found then register it
					$this->load->library('form_validation');

					$settings = $this->site_model->get_website_settings();
					$this->lang->load('site_lang', $this->session->userdata('site_language'));

					$data["settings"] = $settings;
					$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

					$this->load->view('site/register_via_facebook', $data);
				}
			} else {
				$this->session->set_flashdata('message', 'Facebook Server Error. Please try again later');
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('message', 'Internal Server Error. Please try again later');
			redirect(base_url());
		}
	}

	// Verify User Email and Activate user account
    public function verify() {
	    $this->load->model(['auth_model', 'email_model', 'photo_model']);
		$this->lang->load('site_lang', $this->session->userdata('site_language'));
		$settings = $this->session->userdata('site_setting');

		// Use : user Transaction strategy
		$email_hash = $this->input->get('hash');

		if($email_hash != '') {
			$this->load->library('encryption');
			$this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
			$email = $this->encryption->decrypt($email_hash);

			if($email != '') {
				$ustatus = $this->auth_model->isUserPendingByEmail($email);
				if($ustatus) {
			 		$this->load->helper('form');
			 		$this->load->library('form_validation');
					$this->form_validation->set_rules('first_condition', 'first_condition', 'required');
					$this->form_validation->set_rules('second_condition', 'second_condition', 'required');
					$this->form_validation->set_rules('third_condition', 'third_condition', 'required');

        			if ($this->form_validation->run() != FALSE) {
        				$ustatus = $this->auth_model->updateUserStatusAsActive($email);

						if($ustatus) {							
							$res = $this->auth_model->getUserInfoByEmail($email);

							$avatar = "images/avatar/".$res->user_gender.".png";

							// Get active profile picture photo
							$profile_pic = $this->photo_model->get_user_profile_pic($res->user_id);
							if($profile_pic) {
								$avatar = $profile_pic['photo_thumb_url'];
							}

						    $this->session->set_userdata(
								array(
									"user_id"		=> $res->user_id,
									"user_username"	=> $res->user_access_name,
									"user_email"	=> $res->user_email,
									"user_avatar"	=> $avatar,
									"user_type"		=> $res->user_type,
									"user_gender"	=> $res->user_gender,
									"user_is_vip"	=> $res->user_is_vip,
									"user_city"		=> $res->user_city,
									"user_latitude"	=> $res->user_latitude,
									"user_longitude"=> $res->user_longitude,
									"user_credits"	=> $res->user_credits,
									"user_diamonds" => $res->user_diamonds,
									"user_interested_in" => $res->user_interested_in,
									"user_is_online" => 'yes',
									"user_last_login_date" => $res->user_last_login_date,
									"welcome_note_shown" => false
								)
							);
							
							$this->session->set_flashdata('message', 'your_email_has_been_verified_successfully');
							
							// check user uploaded photo or not. If not then show him upload profile pic dialong for first 3 logins
							if($res->user_active_photo_thumb == '' && $res->show_upload_profile_pic_count > 0) {
								$show_upload_profile_pic_count = $res->show_upload_profile_pic_count - 1;
								$this->session->set_userdata('show_upload_profile_pic_dialog', true);
								$this->auth_model->update_user_info($res->user_id, array('show_upload_profile_pic_count' => $show_upload_profile_pic_count));
							}

			                // Send Email to Verify Email
			                $this->lang->load('user_lang', $this->session->userdata('site_language'));			                
			                $to_email = $email;
			                $subject = $this->lang->line('your_email_has_been_verified');
			                $data['user_name'] = $res->user_access_name;
			                $data['user_pic'] = base_url($avatar);
			                $data['email_template'] = 'email/user_email_verified';
			                $email_message = $this->load->view('templates/email/main', $data, true);
			                @$this->email_model->sendEMail($to_email, $subject, $email_message);
							
							redirect(base_url('home'));
						} else {
							$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
							redirect(base_url());							
						}
        			}
					$data = array(
						"title" => $settings["site_name"] . " - " . $settings["site_tagline"],
						"settings" => $settings,
					);
        			$this->load->view('site/verify_email', $data);
				} else {
					$this->session->set_flashdata('message', $this->lang->line('this_link_has_been_expired'));
					redirect(base_url());
				}
			} else {
				$this->session->set_flashdata('message', $this->lang->line('unauthorized_access_your_activity_has_been_recorded'));
				redirect(base_url());				
			}
		} else {
			$this->session->set_flashdata('message', $this->lang->line('unauthorized_access_your_activity_has_been_recorded'));
			redirect(base_url());
		}
    }

    function switch_language() {
    	$language_id = $this->input->post('lang_id');
		$this->load->model('language_model');
		$lang_info = $this->language_model->get_language_info($language_id);

		if($lang_info) {
			$this->session->set_userdata('site_language', $lang_info["language_name"]);
			$response['status'] = true;
		} else {
			$response['status'] = false;
		}

		header('Content-type:application/json');
		echo json_encode($response);
    }

    function switch_country() {
    	$country_abbr = $this->input->post('country_abbr');
		$this->load->model(['country_model', 'user_model']);
		$country_info = $this->country_model->get_country_info_by_abbr($country_abbr);

		if($country_info) {
			$this->session->set_userdata('site_language', $country_info["language_name"]);
			$this->session->set_userdata('site_country_abbr', $country_info['country_abbr']);
			$this->session->set_userdata('site_currency_symbol', $country_info['country_currency_text']);

			// if user logged then set his language
			if($this->session->has_userdata('user_id')) {
				$user_data = array('language_id_ref' => $country_info["language_name"]);
				$this->user_model->update_user_info($this->session->userdata('user_id'), $user_data);
			}

			$response['status'] = true;
		} else {
			$response['status'] = false;
		}

		header('Content-type:application/json');
		echo json_encode($response);
    }    


	function recover_password() {
		$response = array();
		$email = $this->input->post('email');

		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		if ($email == '') {
			$response["error"] = 999;
			$response["message"] = $this->lang->line('please_enter_username_or_email');
		} else {
			
			// Check email exists
			$this->load->model(['user_model', 'photo_model', 'email_model']);
			$user_info = $this->user_model->get_user_info_using_email_or_username($email);

			if($user_info) {
				$recovery_token = sha1(time() . $user_info["user_access_name"]);
				$user_data = array('password_token' => $recovery_token);
				$status = $this->user_model->update_user($user_info["user_id"], $user_data);

				if($status) {
					$response["error"] = 0;
					$response["message"] = $this->lang->line('password_recovery_text_message');
					$response["url_redirect"] = base_url();

					$avatar = "images/avatar/".$user_info['user_gender'].".png";

					// Get active profile picture photo
					$profile_pic = $this->photo_model->get_user_profile_pic($user_info["user_id"]);
					if($profile_pic) {
						$avatar = $profile_pic['photo_thumb_url'];
					}
					
					// Send Password Recovery Email
	                $to_email = $user_info["user_email"];
	                $subject = $this->lang->line('recover_your_password');
	                
	                $data['user_name'] = $user_info["user_access_name"];
	                $data['user_pic'] = base_url($avatar);
	                $data['recovery_token_url'] = base_url('auth/new_password?token='.urlencode($recovery_token));
	                $data['email_template'] = 'email/password_recovery_email';
	                $email_message = $this->load->view('templates/email/main', $data, true);
	                @$this->email_model->sendEMail($to_email, $subject, $email_message);
            	} else {
					$response["error"] = 999;
					$response["message"] = $this->lang->line('please_enter_username_or_email');
            	}
			} else {
				$response["error"] = 998;
				$response["message"] = $this->lang->line('no_such_user_found');
			}
		}

		header('Content-type: application/json;');
		echo json_encode($response);
	}

	function new_password() {
		$token = urldecode($this->input->get('token'));
		$data = array();
		$this->load->model(['user_model', 'site_model','vip_package_model']);

		$settings = $this->site_model->get_website_settings();
		$this->lang->load('site_lang', $this->session->userdata('site_language'));

		$user_info = $this->user_model->get_user_info_using_passwordtoken($token);

		if(empty($token)) {
			$this->session->set_flashdata('message', $this->lang->line('unauthorized_access_your_activity_has_been_recorded'));
			redirect(base_url());
		} else {
		if($user_info) {
				$this->load->helper('form');
		 		$this->load->library('form_validation');
		 		$this->form_validation->set_rules('new_password', 'new_password', 'required|trim');
				$this->form_validation->set_rules('confirm_new_password', 'confirm_new_password', 'required|matches[new_password]|trim');
				if ($this->form_validation->run() != FALSE) {

		        	$user_password = sha1($this->input->post('new_password'));
		        	$userdata_array = array(
		        		'user_password' => $user_password,
		        		'password_token' => NULL
		        	);
		        	$status = $this->user_model->update_user($user_info["user_id"], $userdata_array);
		        	if($status) {
		        		$this->session->set_flashdata('message', $this->lang->line('your_password_has_been_changed_successfully'));
						redirect(base_url());
					} else {
		        		$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
						redirect(base_url());
					}
		        }
				$data["settings"] = $settings;
				$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
				$this->load->view('site/new_password', $data);
			} else {
				$this->session->set_flashdata('message', $this->lang->line('token_has_been_expired'));
				redirect(base_url());
			}
		}
	}

	public function fb_register()
    {
		if($this->session->has_userdata('user_id')) {
			redirect(base_url() . "home");
		}

		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->load->model(['auth_model','photo_model', 'site_model']);
		$settings = $this->session->userdata('site_setting');
    	$this->lang->load('site_lang', $this->session->userdata('site_language'));

		$this->form_validation->set_rules('i_am_a', 'gender', 'required|trim');
		$this->form_validation->set_rules('i_am_inerested_in', 'i_am_inerested_in', 'required|trim');
		$this->form_validation->set_rules('user_username', 'username', 'required|trim|is_unique[tbl_users.user_access_name]', array('is_unique' => $this->lang->line('this_username_is_already_taken')));
		$this->form_validation->set_rules('dateofbirth_day', 'date', 'required|trim');
		$this->form_validation->set_rules('dateofbirth_month', 'date', 'required|trim');
		$this->form_validation->set_rules('dateofbirth_year', 'date', 'required|trim');
		$this->form_validation->set_rules('user_postcode', 'postcode', 'required|numeric|trim');
		$this->form_validation->set_rules('user_location', 'location', 'required|trim');
		$this->form_validation->set_rules('user_size', 'size', 'numeric|trim|required');

		if ($this->form_validation->run() == FALSE) {
			// If user not found then register it
			$this->load->library('form_validation');

			$data["settings"] = $settings;
			$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

			$this->load->view('site/register_via_facebook', $data);
		} else {
			$fb_user = $this->facebook->user();

    		// Use : user Transaction strategy
        	$user_password = sha1(rand(11111111, 9999999));

        	$login_register_array = array(
        		'user_access_name' => $this->input->post('user_username'),
        		'user_password' => $user_password,
        		'user_email' => $fb_user['data']['email'],
        		'user_type' => 'user',
        		'user_status' => 'active',
        		'user_verified' => 'no',
        		'user_is_vip' => 'no',
        		'user_flag' => 'web',
        		'user_credits' => $settings['free_credits'],
        		'user_diamonds' => 0,
        		'user_taken_free_credits' => $settings['free_credits']
        	);

        	// START Transaction
            $this->db->trans_begin();
        	$user_id = $this->auth_model->create_user($login_register_array);

    		$profille_photo = "";
			$profille_photo_thumb = "";
			$show_upload_profile_pic_count = SHOW_UPLOAD_PROFILE_PICTURE_DIALOG_COUNT;

        	// Upload user image
			$profilePic = file_get_contents('https://graph.facebook.com/'.$fb_user['data']["id"].'/picture?type=large');

	    	// Check if the directory already exists
        	if (!file_exists("./uploads/photos/" . $user_id . "/")) {
        		mkdir("./uploads/photos/" . $user_id . "/");
        		mkdir("./uploads/photos/" . $user_id . "/thumbnails/");
        	}

			$profilePic = file_get_contents('https://graph.facebook.com/'.$fb_user['data']["id"].'/picture?type=large');

			if(!empty($profilePic)) {
				$file_name = rand(0,999999).time().'.jpg';
				$file = "./uploads/photos/" . $user_id . "/".$file_name;
				$fileEcho = "uploads/photos/" . $user_id . "/".$file_name;
				file_put_contents($file, $profilePic);

				$fileThumb = "./uploads/photos/" . $user_id . "/thumbnails/".$file_name;
				$fileThumbEcho = "uploads/photos/" . $user_id . "/thumbnails/".$file_name;
				file_put_contents($fileThumb, $profilePic);

				$this->load->helper('image_helper');
				$pr_photo = image_compress($file, $file, 100);
		    	$pr_photo_thumb = image_compress_thumbnail($fileThumb, $fileThumb, 70);

	            $photo_array = array(
                    'photo_user_id_ref' => $user_id,
                    'photo_url' => $fileEcho,
                    'photo_thumb_url' => $fileThumbEcho,
                    'photo_added_date' => gmdate("Y-m-d H:i:s"),
                    'photo_type' => 'profile',
                    'photo_status' => 'inactive',
                    'is_profile_photo' => 'yes',
                    'photo_flag' => 'web'
	            );
	            $this->photo_model->insert_user_photo($photo_array);
	            $show_upload_profile_pic_count = 0;

				$profille_photo = $fileEcho;
				$profille_photo_thumb = $fileThumbEcho;
			}

    		// Use : user Transaction strategy
    		$this->load->library('encryption');
    		$this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
    		$user_enc_id = $this->encryption->encrypt($user_id);

    		$u_user_array = array(
    			'user_id_encrypted' => $user_enc_id
    		);
			$this->auth_model->update_user($user_id, $u_user_array);

			$user_city = explode(',', $this->input->post('user_location'));
			$user_country = $this->input->post('user_country');

			if($this->input->post('user_country') == '') {
				if($this->session->has_userdata('user_currlocation')) {
					$cur_loc_arr = $this->session->userdata('user_currlocation');
					$user_country = $cur_loc_arr['country'];
				}
			}

    		// Insert User information
        	$user_latitude = $this->input->post('user_latitude');
        	$user_longitude = $this->input->post('user_longitude');
        	
        	if($user_latitude == '' || $user_longitude == '') {
        		if($this->session->has_userdata('user_currlocation')) {
        			$cur_loc_arr = $this->session->userdata('user_currlocation');
        			$user_latitude = $cur_loc_arr['latitude'];
        			$user_longitude = $cur_loc_arr['longitude'];
        		}
        	}

        	if($this->session->has_userdata('site_language')) {
        		$language_id_ref =  $this->session->userdata('site_language');
        	} else {
        		$language_id_ref =  DEFAULT_LANGUAGE;
        	}

        	$date_of_birth = $this->input->post('dateofbirth_year').'-'.$this->input->post('dateofbirth_month').'-'.$this->input->post('dateofbirth_day');

        	$user_information_array = array(
        		'user_id_ref' => $user_id,
        		'user_gender' => $this->input->post('i_am_a'),
        		'user_interested_in' => $this->input->post('i_am_inerested_in'),
        		'user_birthday' => $date_of_birth,
        		'user_country' => $user_country,
        		'user_postcode' => $this->input->post('user_postcode'),
        		'user_city' => $user_city[0],
        		'user_latitude' => $user_latitude,
        		'user_longitude' => $user_longitude,
        		'language_id_ref' => $language_id_ref,
        		'user_height' => $this->input->post('user_size'),
        		'user_active_photo' => NULL,
        		'user_active_photo_thumb' => NULL,
        		'show_upload_profile_pic_count' => $show_upload_profile_pic_count,
        		'user_info_flag' => 'web',
        		'interested_in_serious_relationship' => 'yes'
        	);

	        $this->auth_model->create_user_info($user_information_array);

        	if($this->db->trans_status() === FALSE) {
        		$this->db->trans_rollback();
				$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
				redirect(base_url());
        	} else {
        		$this->db->trans_commit();

        		// login inside directly
				$res = $this->auth_model->getUserInfoByEmail($fb_user['data']['email']);

				$avatar = "images/avatar/".$res->user_gender.".png";

				// Get active profile picture photo
				$profile_pic = $this->photo_model->get_user_profile_pic($res->user_id);
				if($profile_pic) {
					$avatar = $profile_pic['photo_thumb_url'];
				}

			    $this->session->set_userdata(
					array(
						"user_id"		=> $res->user_id,
						"user_username"	=> $res->user_access_name,
						"user_email"	=> $res->user_email,
						"user_avatar"	=> $avatar,
						"user_type"		=> $res->user_type,
						"user_gender"	=> $res->user_gender,
						"user_is_vip"	=> $res->user_is_vip,
						"user_city"		=> $res->user_city,
						"user_latitude"	=> $res->user_latitude,
						"user_longitude"=> $res->user_longitude,
						"user_credits"	=> $res->user_credits,
						"user_diamonds" => $res->user_diamonds,
						"user_interested_in" => $res->user_interested_in,
						"user_is_online" => 'yes',
						"user_offline_activity_start_date" => '',
						"user_last_login_date" => $res->user_last_login_date,						
						"welcome_note_shown" => false
					)
				);
				redirect(base_url('home'));
        	}
		}
    }

}
