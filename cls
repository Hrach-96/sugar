warning: LF will be replaced by CRLF in application/libraries/mpdf/mpdf.php.
The file will have its original line endings in your working directory
[1mdiff --git a/application/config/facebook.php b/application/config/facebook.php[m
[1mindex b29c599..3183832 100644[m
[1m--- a/application/config/facebook.php[m
[1m+++ b/application/config/facebook.php[m
[36m@@ -17,8 +17,8 @@[m [mdefined('BASEPATH') OR exit('No direct script access allowed');[m
 |  facebook_permissions          array   The permissions you need.[m
 */[m
 [m
[31m-$config['facebook_app_id']              = 'your-app-id';[m
[31m-$config['facebook_app_secret']          = 'your-app-secret';[m
[32m+[m[32m$config['facebook_app_id']              = '655914244859037';[m
[32m+[m[32m$config['facebook_app_secret']          = 'fe1a15998ad474c0b4c5ceabf9560ac1';[m
 $config['facebook_login_type']          = 'web';[m
 $config['facebook_login_redirect_url']  = 'auth/fb_login';[m
 $config['facebook_logout_redirect_url'] = 'auth/logout';[m
[1mdiff --git a/application/controllers/Auth.php b/application/controllers/Auth.php[m
[1mindex 052ab94..062ae8a 100644[m
[1m--- a/application/controllers/Auth.php[m
[1m+++ b/application/controllers/Auth.php[m
[36m@@ -514,126 +514,121 @@[m [mclass Auth extends CI_Controller {[m
     function fb_login()[m
 	{[m
 		$this->lang->load("user");[m
[31m-		if(DEMO_MODE == 1) {[m
[31m-			echo 'error';[m
[31m-			die();[m
[31m-			redirect(base_url() . "?error=demo_mode");[m
[31m-			exit;[m
[31m-		}[m
[31m-			[m
[31m-		if ($this->facebook->logged_in())[m
[31m-		{[m
[31m-			$fb_user = $this->facebook->user();[m
[31m-			// Facebook login OK[m
[31m-			if ($fb_user['code'] === 200)[m
[32m+[m		[32m$this->load->model(['site_model','photo_model']);[m
[32m+[m			[32mif ($this->facebook->logged_in())[m
 			{[m
[31m-				unset($fb_user['data']['permissions']);[m
[31m-				$user = $fb_user['data'];[m
[31m-				[m
[31m-				$this->load->model("user_model");[m
[31m-				$this->load->model("site_model");[m
[31m-				[m
[31m-				// User is logging in[m
[31m-				if($this->user_model->check_facebook_user_exists($user["id"])) {[m
[31m-					$user_log = $this->user_model->get_facebook_user($user["id"])->result_array();[m
[32m+[m[41m             [m
[32m+[m				[32m$fb_user = $this->facebook->user();[m
[32m+[m				[32m// Facebook login OK[m
[32m+[m				[32mif ($fb_user['code'] === 200)[m
[32m+[m				[32m{[m
[32m+[m					[32munset($fb_user['data']['permissions']);[m
[32m+[m					[32m$user = $fb_user['data'];[m
[32m+[m[41m					[m
[32m+[m					[32m$this->load->model("user_model");[m
[32m+[m					[32m$this->load->model("site_model");[m
[32m+[m					[32m$this->load->model("auth_model");[m
[32m+[m					[32m$settings = $this->session->userdata('site_setting');[m
[32m+[m[41m					[m
[32m+[m					[32m// User is logging in[m
[32m+[m					[32mif($this->user_model->check_facebook_user_exists($user["id"])) {[m
 [m
[31m-					$user_log = $user_log[0];[m
[31m-				[m
[31m-					if($user_log["banned"] == 1) {[m
[31m-						redirect(base_url() . "?action=login_banned");[m
[31m-					} else {[m
[31m-						[m
[31m-						$settings = $this->site_model->get_website_settings()->result_array();[m
[31m-						$settings = $settings[0];[m
[31m-						[m
[31m-						$avatar = base_url() . "images/avatar.png";[m
[31m-				[m
[31m-						if(($user_log["thumb_url"] == "" || $user_log["photostatus"] == 0) && $user_log["gender"] == 0) {[m
[31m-							$avatar = base_url() . "images/avatar.png";[m
[31m-						} else if(($user_log["thumb_url"] == "" || $user_log["photostatus"] == 0) && $user_log["gender"] == 1) {[m
[31m-							$avatar = base_url() . "images/avatar.png";[m
[31m-						} else if($user_log["thumb_url"] != "") {[m
[31m-							$avatar = $user_log["thumb_url"];[m
[32m+[m						[32m$user_log = $this->user_model->get_facebook_user($user["id"]);[m
[32m+[m						[32m$user_log = $user_log[0];[m
[32m+[m						[32mif($user_log["user_status"] == 'blocked') {[m
[32m+[m							[32mredirect(base_url() . "/site");[m
[32m+[m						[32m} else {[m
[32m+[m						[32m// Get active profile picture photo[m
[32m+[m						[32m$profile_pic = $this->photo_model->get_user_profile_pic($user_log['user_id']);[m
[32m+[m
[32m+[m						[32mif($profile_pic) {[m
[32m+[m							[32m$avatar = $profile_pic['photo_thumb_url'];[m
 						}[m
[32m+[m							[32m$this->session->set_userdata([m
[32m+[m									[32marray([m
[32m+[m										[32m"user_id"		=> $user_log['user_id'],[m
[32m+[m										[32m"user_username"	=> $user_log['user_access_name'],[m
[32m+[m										[32m"user_email"	=> $user_log['user_email'],[m
[32m+[m										[32m"user_avatar"	=> $avatar,[m
[32m+[m										[32m"user_type"		=> $user_log['user_type'],[m
[32m+[m										[32m"user_gender"	=> $user_log['user_gender'],[m
[32m+[m										[32m"user_is_vip"	=> $user_log['user_is_vip'],[m
[32m+[m										[32m"user_latitude"	=> $user_log['user_latitude'],[m
[32m+[m										[32m"user_longitude"=> $user_log['user_longitude'],[m
[32m+[m										[32m"user_interested_in" => $user_log['user_interested_in'],[m
[32m+[m										[32m"user_credits"=> $user_log['user_credits'],[m
[32m+[m										[32m"user_diamonds" => $user_log['user_diamonds'],[m
[32m+[m										[32m"user_is_online" => 'yes',[m
[32m+[m										[32m"user_offline_activity_start_date" => '',[m
[32m+[m										[32m"user_last_login_date" => $user_log['user_last_login_date'][m
[32m+[m									[32m)[m
[32m+[m								[32m);[m
 [m
[31m-						$this->session->set_userdata([m
[31m-							array([m
[31m-								"user_id"		=> $user_log["uid"],[m
[31m-								"fb_id"			=> $user_log["fb_id"],[m
[31m-								"user_username"	=> $user_log["username"],[m
[31m-								"user_email"	=> $user_log["email"],[m
[31m-								"user_rank"		=> $user_log["rank"],[m
[31m-								"user_firstform"=> $user_log["first_step_form"],[m
[31m-								"user_avatar"	=> $avatar[m
[31m-							)[m
[32m+[m[41m							[m
[32m+[m							[32mredirect(base_url().'home');[m
[32m+[m[41m							[m
[32m+[m						[32m}[m
[32m+[m					[32m}[m[41m [m
[32m+[m					[32m// User is creating a new account[m
[32m+[m					[32melse {[m
[32m+[m
[32m+[m						[32m$user_fb_info = array([m
[32m+[m							[32m'user_fb_id'=>$user["id"],[m
[32m+[m							[32m'user_access_name'=>$user["name"],[m
[32m+[m							[32m'user_email'=>$user["email"],[m
[32m+[m							[32m'user_type' => 'user',[m
[32m+[m		[41m        [m		[32m    'user_status' => 'pending',[m
[32m+[m		[41m        [m			[32m'user_verified' => 'no',[m
[32m+[m		[41m        [m			[32m'user_is_vip' => 'no',[m
[32m+[m		[41m        [m			[32m'user_flag' => 'web',[m
[32m+[m		[41m        [m			[32m'user_credits' => $settings['free_credits'],[m
[32m+[m		[41m        [m			[32m'user_diamonds' => 0,[m
[32m+[m		[41m        [m			[32m'user_taken_free_credits' => $settings['free_credits'][m
 						);[m
[32m+[m
[32m+[m[41m							[m
[32m+[m						[32m$uid = $this->auth_model->create_user($user_fb_info);[m
[32m+[m						[32m$img = file_get_contents('https://graph.facebook.com/'.$user["id"].'/picture?type=large');[m[41m					[m
[32m+[m						[32m// Check if the directory already exists[m
[32m+[m			[41m        [m	[32mif (!file_exists("./uploads/photos/" . $uid . "/")) {[m
[32m+[m			[41m        [m		[32mmkdir("./uploads/photos/" . $uid . "/");[m
[32m+[m			[41m        [m		[32mmkdir("./uploads/photos/" . $uid . "/thumbnails/");[m
[32m+[m			[41m        [m	[32m}[m
[32m+[m[41m			        	[m
[32m+[m			[41m        [m	[32m$file_name = time().'.jpg';[m[41m		[m
[32m+[m						[32m$file = "./uploads/photos/" . $uid . "/".$file_name;[m
[32m+[m						[32m$fileEcho = "uploads/photos/" . $uid . "/".$file_name;[m
[32m+[m[41m				[m
[32m+[m						[32mfile_put_contents($file, $img);[m
 						[m
[31m-						$this->user_model->update_login($user_log["uid"]);[m
[31m-                                                $this->installation_link($user_log["uid"]);[m
[32m+[m						[32m$file_2 = "./uploads/photos/" . $uid . "/thumbnails/".$file_name;[m
[32m+[m						[32m$file_2Echo = "uploads/photos/" . $uid . "/thumbnails/".$file_name;[m
[32m+[m						[32mfile_put_contents($file_2, $img);[m
[32m+[m[41m						[m
[32m+[m						[32m$this->load->model(['photo_model','site_model']);[m
[32m+[m						[32m$user_photo_data = array([m
[32m+[m							[32m'photo_user_id_ref'=>$uid,[m
[32m+[m							[32m'photo_url'=>$fileEcho,[m
[32m+[m							[32m'photo_thumb_url'=>$file_2Echo,[m
[32m+[m							[32m'photo_added_date' => gmdate("Y-m-d H:i:s"),[m
[32m+[m							[32m'photo_type'=>'profile',[m
[32m+[m							[32m'photo_status'=>'inactive',[m
[32m+[m							[32m'is_profile_photo'=>'yes',[m
[32m+[m							[32m'photo_flag' => 'web'[m
[32m+[m						[32m);[m
[32m+[m						[32m$pic_id = $this->photo_model->insert_user_photo($user_photo_data);[m
[32m+[m				[41m [m		[32m$settings = $this->site_model->get_website_settings();[m
[32m+[m						[32m$this->lang->load('site_lang', $this->session->userdata('site_language'));[m
[32m+[m						[32m$data["settings"] = $settings;[m
[32m+[m						[32m$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];[m
[32m+[m				[32m        $data["user_id"] = $uid;[m
[32m+[m				[32m        $this->load->view('site/register_via_facebook',$data);[m
 						[m
[31m-						if($user_log["first_step_form"] == 1)[m
[31m-							redirect(base_url() . "?success=login_success");[m
[31m-						else[m
[31m-							redirect(base_url() . "user/firstloginfb?error=first_login");[m
 					}[m
[31m-				} [m
[31m-				// User is creating a new account[m
[31m-				else {[m
[31m-										[m
[31m-					if($this->input->cookie('bepoke_gender') == "") {[m
[31m-						header("Location: " . base_url() . "?error=cookie");	[m
[31m-						exit;[m
[31m-					}	[m
[31m-					[m
[31m-					$uid = $this->user_model->create_social_account($user["id"], $user["name"], $user["email"]);[m
[31m-					[m
[31m-					$gender			= $this->security->xss_clean($this->input->cookie('bepoke_gender', TRUE));[m
[31m-					$interested_in	= $this->security->xss_clean($this->input->cookie('bepoke_interested_in', TRUE));[m
[31m-					[m
[31m-					$this->user_model->create_info($uid, $gender, $interested_in);[m
[31m-					[m
[31m-					$img = file_get_contents('https://graph.facebook.com/'.$user["id"].'/picture?type=large');[m
[31m-					[m
[31m-					// Check if the directory already exists[m
[31m-		        	if (!file_exists("./uploads/photos/" . $uid . "/")) {[m
[31m-		        		mkdir("./uploads/photos/" . $uid . "/");[m
[31m-		        		mkdir("./uploads/photos/" . $uid . "/thumbnails/");[m
[31m-		        	}[m
[31m-		        	[m
[31m-		        	$file_name = time().'.jpg';[m
[31m-					[m
[31m-					$file = "./uploads/photos/" . $uid . "/".$file_name;[m
[31m-					$fileEcho = "/uploads/photos/" . $uid . "/".$file_name;[m
[31m-					[m
[31m-					file_put_contents($file, $img);[m
[31m-					[m
[31m-					$file_2 = "./uploads/photos/" . $uid . "/thumbnails/".$file_name;[m
[31m-					$file_2Echo = "/uploads/photos/" . $uid . "/thumbnails/".$file_name;[m
[31m-					file_put_contents($file_2, $img);[m
[31m-					[m
[31m-					$this->load->model("photo_model");[m
[31m-					$pic_id = $this->photo_model->add($fileEcho, $file_2Echo, $uid);[m
[31m-					[m
[31m-					$this->user_model->update_info($uid, array("main_photo" => $pic_id));[m
[31m-										[m
[31m-					$this->session->set_userdata([m
[31m-						array([m
[31m-							"user_id"		=> $uid,[m
[31m-							"fb_id"			=> $user["id"],[m
[31m-							"user_username"	=> $user["name"],[m
[31m-							"user_email"	=> $user["email"],[m
[31m-							"user_rank"		=> 0,[m
[31m-							"first_login"	=> 0,[m
[31m-							"user_avatar"	=> 'uploads/photos/' . $uid . '/' . $file_name[m
[31m-						)[m
[31m-					);[m
[31m-					[m
[31m-					redirect(base_url() . "user/firstloginfb");[m
[32m+[m				[32m} else {[m
[32m+[m					[32mredirect(base_url() . "?action=login_error");[m
 				}[m
[31m-			} else {[m
[31m-				redirect(base_url() . "?action=login_error");[m
[31m-			}[m
[31m-		}[m
[32m+[m			[32m}[m[41m [m
 	}    [m
 [m
 	// Verify User Email and Activate user account[m
[36m@@ -877,5 +872,134 @@[m [mclass Auth extends CI_Controller {[m
 		}[m
 	}[m
 [m
[31m-    [m
[32m+[m	[32mpublic function registerViaFacebbok()[m
[32m+[m[32m    {[m
[32m+[m
[32m+[m			[32m$this->load->helper('form');[m
[32m+[m	[41m [m		[32m$this->load->library('form_validation');[m
[32m+[m	[41m [m		[32m$this->load->model(['auth_model','photo_model']);[m[41m        [m
[32m+[m	[32m        $settings = $this->session->userdata('site_setting');[m
[32m+[m			[32m$this->lang->load('site_lang', $this->session->userdata('site_language'));[m
[32m+[m
[32m+[m			[32m$this->form_validation->set_rules('user_gender', 'user_gender', 'required|trim');[m
[32m+[m			[32m$this->form_validation->set_rules('user_inerested_in', 'user_inerested_in', 'required|trim');[m
[32m+[m			[32m$this->form_validation->set_rules('username', 'username', 'required|trim|is_unique[tbl_users.user_access_name]', array('is_unique' => $this->lang->line('this_username_is_already_taken')));[m
[32m+[m			[32m$this->form_validation->set_rules('date_of_birth', 'date_of_birth', 'required|trim');[m
[32m+[m			[32m$this->form_validation->set_rules('user_postcode', 'user_postcode', 'required|numeric|trim');[m
[32m+[m			[32m$this->form_validation->set_rules('user_location', 'user_location', 'required|trim');[m
[32m+[m			[32m$this->form_validation->set_rules('user_size', 'user_size', 'numeric|trim');[m
[32m+[m			[32m$this->form_validation->set_rules('user_id', 'user_id', 'numeric|trim');[m
[32m+[m[41m			[m
[32m+[m
[32m+[m			[32mif ($this->form_validation->run() == FALSE) {[m
[32m+[m	[32m            $data["status"]	= false;[m
[32m+[m				[32m$data["error"]	= 1;[m
[32m+[m				[32m$data["message"] = $this->lang->line('please_try_again_later');[m
[32m+[m				[32m$data["error_array"] = $this->form_validation->error_array();[m
[32m+[m	[32m        }[m
[32m+[m	[32m        else{[m
[32m+[m					[32m// Use : user Transaction strategy[m
[32m+[m	[41m        [m		[32m$this->load->library('encryption');[m
[32m+[m	[41m        [m		[32m$this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));[m
[32m+[m	[41m        [m		[32m$user_enc_id = $this->encryption->encrypt($this->input->post('user_id'));[m
[32m+[m
[32m+[m	[41m        [m		[32m$u_user_array = array([m
[32m+[m	[41m        [m			[32m'user_access_name' => $this->input->post('username'),[m
[32m+[m	[41m        [m			[32m'user_id_encrypted' => $user_enc_id[m
[32m+[m	[41m        [m		[32m);[m
[32m+[m					[32m$this->auth_model->update_user($this->input->post('user_id'), $u_user_array);[m
[32m+[m
[32m+[m
[32m+[m	[41m    [m			[32m$user_city = explode(',', $this->input->post('user_location'));[m
[32m+[m					[32m$user_country = $this->input->post('user_country');[m
[32m+[m					[32mif($this->input->post('user_country') == '') {[m
[32m+[m							[32mif($this->session->has_userdata('user_currlocation')) {[m
[32m+[m								[32m$cur_loc_arr = $this->session->userdata('user_currlocation');[m
[32m+[m								[32m$user_country = $cur_loc_arr['country'];[m
[32m+[m							[32m}[m
[32m+[m					[32m}[m
[32m+[m		[41m        [m		[32m// Insert User information[m
[32m+[m		[41m        [m	[32m$user_latitude = $this->input->post('user_latitude');[m
[32m+[m		[41m        [m	[32m$user_longitude = $this->input->post('user_longitude');[m
[32m+[m		[41m        [m	[32mif($user_latitude == '' || $user_longitude == '') {[m
[32m+[m		[41m        [m		[32mif($this->session->has_userdata('user_currlocation')) {[m
[32m+[m		[41m        [m			[32m$cur_loc_arr = $this->session->userdata('user_currlocation');[m
[32m+[m		[41m        [m			[32m$user_latitude = $cur_loc_arr['latitude'];[m
[32m+[m		[41m        [m			[32m$user_longitude = $cur_loc_arr['longitude'];[m
[32m+[m		[41m        [m		[32m}[m
[32m+[m		[41m        [m	[32m}[m
[32m+[m
[32m+[m[41m			        	[m
[32m+[m				[32m        $this->db->trans_begin();[m[41m [m
[32m+[m				[41m       [m	[32m$user_information_array = array([m
[32m+[m							[32m'user_id_ref' => $this->input->post('user_id'),[m
[32m+[m			[41m        [m		[32m'user_gender' => $this->input->post('user_gender'),[m
[32m+[m			[41m        [m		[32m'user_interested_in' => $this->input->post('user_inerested_in'),[m
[32m+[m			[41m        [m		[32m'user_birthday' => $this->input->post('date_of_birth'),[m
[32m+[m			[41m        [m		[32m'user_postcode' => $this->input->post('user_postcode'),[m
[32m+[m			[41m        [m		[32m'language_id_ref' => 1,[m
[32m+[m			[41m        [m		[32m'user_height' => $this->input->post('user_size'),[m
[32m+[m			[41m        [m		[32m'user_info_flag' => 'web',[m
[32m+[m			[41m        [m		[32m'interested_in_serious_relationship'=>'yes',[m
[32m+[m			[41m        [m		[32m'user_latitude' => $user_latitude,[m
[32m+[m			[41m        [m		[32m'user_longitude' => $user_longitude,[m
[32m+[m			[41m        [m		[32m'user_country' => $user_country,[m
[32m+[m			[41m        [m		[32m'user_city' => $user_city[0][m
[32m+[m			[41m        [m	[32m);[m
[32m+[m
[32m+[m					[32m$this->auth_model->create_user_info($user_information_array);[m
[32m+[m
[32m+[m			[41m     [m	[32m$user_log = $this->auth_model->getUserInfo($this->input->post('user_id'));[m
[32m+[m					[32m// Get active profile picture photo[m
[32m+[m					[32m$profile_pic = $this->photo_model->get_user_profile_pic($user_log->user_id);[m
[32m+[m					[32mif($profile_pic) {[m
[32m+[m									[32m$avatar = $profile_pic['photo_thumb_url'];[m
[32m+[m								[32m}[m
[32m+[m			[41m    [m	[32m$this->session->set_userdata([m
[32m+[m						[32marray([m
[32m+[m								[32m"user_id"		=> $user_log->user_id,[m
[32m+[m								[32m"user_username"	=> $user_log->user_access_name,[m
[32m+[m								[32m"user_email"	=> $user_log->user_email,[m
[32m+[m					[41m   [m			[32m"user_avatar"	=> $avatar,[m
[32m+[m								[32m"user_type"		=> $user_log->user_type,[m
[32m+[m								[32m"user_gender"	=> $user_log->user_gender,[m
[32m+[m								[32m"user_is_vip"	=> $user_log->user_is_vip,[m
[32m+[m								[32m"user_latitude"	=> $user_log->user_latitude,[m
[32m+[m								[32m"user_longitude"=> $user_log->user_longitude,[m
[32m+[m								[32m"user_interested_in" => $user_log->user_interested_in,[m
[32m+[m								[32m"user_credits"=> $user_log->user_credits,[m
[32m+[m								[32m"user_diamonds" => $user_log->user_diamonds,[m
[32m+[m								[32m"user_is_online" => 'yes',[m
[32m+[m								[32m"user_offline_activity_start_date" => '',[m
[32m+[m								[32m"user_last_login_date" => $user_log->user_last_login_date[m
[32m+[m								[32m)[m
[32m+[m							[32m);[m
[32m+[m
[32m+[m			[41m    [m		[32mif($this->db->trans_status() === FALSE) {[m
[32m+[m					[32m        $this->db->trans_rollback();[m
[32m+[m							[32m$data["status"]	= false;[m
[32m+[m							[32m$data["error"]	= 2;[m
[32m+[m							[32m$data["message"] = $this->lang->line('internal_server_error');[m
[32m+[m					[32m        } else {[m
[32m+[m					[41m       [m		[32m$this->db->trans_commit();[m
[32m+[m								[32m$data["status"]	= true;[m
[32m+[m								[32m$data["error"]	= 0;[m
[32m+[m								[32m$data["message"] = $this->lang->line('success');[m
[32m+[m						[41m   [m	[32m}[m
[32m+[m					[32m}[m[41m	         [m
[32m+[m		[41m    [m	[32mheader('Content-type: application/json;');[m
[32m+[m				[32mecho json_encode($data);[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    public function test()[m
[32m+[m[32m    {[m
[32m+[m[41m    [m	[32m$this->load->model('site_model');[m
[32m+[m[41m    [m	[32m$settings = $this->site_model->get_website_settings();[m
[32m+[m						[32m$this->lang->load('site_lang', $this->session->userdata('site_language'));[m
[32m+[m						[32m$data["settings"] = $settings;[m
[32m+[m						[32m$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];[m
[32m+[m				[32m        $data["user_id"] = $uid;[m
[32m+[m				[32m        $this->load->view('site/register_via_facebook',$data);[m
[32m+[m[32m    }[m
[32m+[m
 }[m
[1mdiff --git a/application/controllers/Site.php b/application/controllers/Site.php[m
[1mindex 31288cb..8ffbcaf 100644[m
[1m--- a/application/controllers/Site.php[m
[1m+++ b/application/controllers/Site.php[m
[36m@@ -33,6 +33,7 @@[m [mclass Site extends CI_Controller {[m
 				try {[m
 					// IF IP found					[m
 					$ip_info = $this->geoip->get_country_info($this->input->server('REMOTE_ADDR'));[m
[32m+[m					[32m//$ip_info = $this->geoip->get_country_info('223.229.162.164');[m
 					$currency_symbol = $this->country_model->get_country_info_by_abbr($ip_info->country->isoCode);[m
 					if(!empty($currency_symbol)) {[m
 						$site_defaults = FALSE;[m
[36m@@ -178,6 +179,4 @@[m [mclass Site extends CI_Controller {[m
         }[m
         redirect($this->session->userdata('back_url'));[m
 	}[m
[31m-[m
[31m-[m
 }[m
[1mdiff --git a/application/controllers/user/Credits.php b/application/controllers/user/Credits.php[m
[1mindex ad835b7..2fbfbbb 100644[m
[1m--- a/application/controllers/user/Credits.php[m
[1m+++ b/application/controllers/user/Credits.php[m
[36m@@ -1,6 +1,6 @@[m
 <?php[m
 defined('BASEPATH') OR exit('No direct script access allowed');[m
[31m-error_reporting(0);[m
[32m+[m[32m//error_reporting(0);[m
 [m
 class Credits extends CI_Controller {[m
 [m
[1mdiff --git a/application/models/Auth_model.php b/application/models/Auth_model.php[m
[1mindex 001f8b4..b8342b2 100644[m
[1m--- a/application/models/Auth_model.php[m
[1m+++ b/application/models/Auth_model.php[m
[36m@@ -148,6 +148,21 @@[m [mclass Auth_model extends CI_Model[m
 [m
 		return $this->db->affected_rows();[m
 	}[m
[32m+[m
[32m+[m	[32mpublic function getUserInfo($userid) {[m
[32m+[m		[32m$this->db->select('user_id, user_access_name, user_email, user_type, user_gender, user_active_photo,user_active_photo_thumb, user_is_vip, user_last_login_date, user_latitude, user_longitude, user_status, user_interested_in, online_switcher_activated_date, user_credits, user_diamonds, show_upload_profile_pic_count');[m
[32m+[m		[32m$this->db->from($this->table_user_k);[m
[32m+[m		[32m$this->db->join($this->table_user_info_k, 'u.user_id = ui.user_id_ref', 'left');[m
[32m+[m		[32m$this->db->where("u.user_id = '".$userid."'");[m
[32m+[m		[32m$this->db->limit(1);[m
[32m+[m		[32m$result = $this->db->get();[m
[32m+[m[41m						[m
[32m+[m		[32mif($result->num_rows() == 1) {[m
[32m+[m			[32mreturn $result->row();[m
[32m+[m		[32m} else {[m
[32m+[m			[32mreturn false;[m
[32m+[m		[32m}[m
[32m+[m	[32m}[m
 	[m
 [m
 }[m
\ No newline at end of file[m
[1mdiff --git a/application/models/Email_model.php b/application/models/Email_model.php[m
[1mindex 6d9da36..83cd2c8 100644[m
[1m--- a/application/models/Email_model.php[m
[1m+++ b/application/models/Email_model.php[m
[36m@@ -75,8 +75,8 @@[m [mclass Email_model extends CI_Model {[m
 		{[m
 			$this->email->attach($attachment);[m
 		}[m
[31m-	 	return $this->email->send();[m
[31m-		//$this->email->print_debugger();[m
[32m+[m	[41m [m	[32m$this->email->send();[m
[32m+[m		[32mreturn $this->email->print_debugger();[m
 	}[m
 	[m
 }[m
\ No newline at end of file[m
[1mdiff --git a/application/models/User_model.php b/application/models/User_model.php[m
[1mindex b26b572..d744c45 100644[m
[1m--- a/application/models/User_model.php[m
[1m+++ b/application/models/User_model.php[m
[36m@@ -707,4 +707,32 @@[m [mclass User_model extends CI_Model[m
         $this->session->unset_userdata('user_last_login_date');[m
     }[m
 [m
[32m+[m[32m    public function check_facebook_user_exists($user_fb_id)[m
[32m+[m[32m    {[m
[32m+[m[41m    [m	[32m$this->db->select('*');[m
[32m+[m[41m    [m	[32m$this->db->from($this->table_user_k);[m
[32m+[m[41m    [m	[32m$this->db->where('user_fb_id',$user_fb_id);[m
[32m+[m[41m    [m	[32m$count = $this->db->get();[m
[32m+[m[41m    [m	[32mif ($count->num_rows() > 0) {[m
[32m+[m[41m    [m		[32mreturn true;[m
[32m+[m[41m    [m	[32m} else {[m
[32m+[m[41m    [m		[32mreturn false;[m
[32m+[m[41m    [m	[32m}[m
[32m+[m[32m    }[m
[32m+[m
[32m+[m[32m    public function get_facebook_user($user_fb_id) {[m
[32m+[m		[32m$this->db->select("*");[m
[32m+[m		[32m$this->db->from($this->table_user);[m
[32m+[m		[32m$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');[m
[32m+[m		[32m$this->db->where('u.user_fb_id', $user_fb_id);[m
[32m+[m		[32m$Q = $this->db->get();[m
[32m+[m
[32m+[m		[32mif($Q->num_rows() > 0) {[m
[32m+[m			[32m$res = $Q->result_array();[m
[32m+[m		[32m} else {[m
[32m+[m			[32m$res = false;[m
[32m+[m		[32m}[m[41m		[m
[32m+[m		[32mreturn $res;[m
[32m+[m	[32m}[m
[32m+[m
 }[m
\ No newline at end of file[m
[1mdiff --git a/application/views/site/welcome.php b/application/views/site/welcome.php[m
[1mindex b1a479c..b4a8c21 100644[m
[1m--- a/application/views/site/welcome.php[m
[1m+++ b/application/views/site/welcome.php[m
[36m@@ -99,7 +99,7 @@[m
 						<a href="javascript:void(0);" class="continue_btn RegBtn register_btn btn_hover" data-toggle="modal" data-target="#registerModal" data-backdrop="static" data-keyboard="false" id="next"><span class="cont_span"><?php echo $this->lang->line('try_for_free_and_anonymously'); ?></span></a>[m
 						<p class="or_p"><?php echo $this->lang->line('or'); ?></p>[m
 						[m
[31m-						<a href="javascript:void(0);" class="continue_btn next member_login register_btn fb_i" data-toggle="modal" data-target="#login_modal" data-keyboard="false"><span class="cont_span"><img src="images/fb_icon.png"><?php echo $this->lang->line('login_with_facebook'); ?></span></a>[m
[32m+[m						[32m<a href="<?php echo $this->facebook->login_url(); ?>" class="continue_btn next member_login register_btn fb_i"  data-keyboard="false"><span class="cont_span"><img src="images/fb_icon.png"><?php echo $this->lang->line('login_with_facebook'); ?></span></a>[m
 						<a href="javascript:void(0);" class="continue_btn next member_login register_btn btn_hover" data-toggle="modal" data-target="#login_modal" data-keyboard="false"><span class="cont_span"><?php echo $this->lang->line('member_login'); ?></span></a>[m
 [m
 						<a href="#"><img src="<?php echo base_url('images/home-amazon-256.png'); ?>" class="home-amazon-256" alt="Sugarbabe"></a>[m
[36m@@ -365,7 +365,7 @@[m
 							</div>[m
 							<div class="col-md-12 text-center">[m
 								<h4 class="fcbk_lbl"><?php echo $this->lang->line('if_facebook'); ?></h4>[m
[31m-								<a href="#" class="fb_btn"><img src="images/fb_icon.png"><?php echo $this->lang->line('facebook_connect'); ?></a>[m
[32m+[m								[32m<a href="<?php echo $this->facebook->login_url(); ?>" class="fb_btn"><img src="images/fb_icon.png"><?php echo $this->lang->line('facebook_connect'); ?></a>[m
 							</div>[m
 						</div>[m
 					</div>[m
[1mdiff --git a/application/views/templates/footers/welcome_footer.php b/application/views/templates/footers/welcome_footer.php[m
[1mindex 360831b..b00d24d 100644[m
[1m--- a/application/views/templates/footers/welcome_footer.php[m
[1m+++ b/application/views/templates/footers/welcome_footer.php[m
[36m@@ -214,6 +214,7 @@[m
     <script src="<?php echo base_url(); ?>js/jquery.cookie.min.js"></script>[m
     <script src="<?php echo base_url(); ?>js/custom.js"></script>[m
     <script src="<?php echo base_url(); ?>js/pages/welcome_ok.js?ver=1"></script>[m
[32m+[m[32m    <script src="<?php echo base_url(); ?>js/pages/register_fb.js"></script>[m
 	[m
 	<!-- Geolocation API -->    [m
 	<script src="http://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo GOOGLE_MAP_API_KEY; ?>"></script>[m
[1mdiff --git a/application/views/user/profile/view.php b/application/views/user/profile/view.php[m
[1mindex 5f5b862..6a5f3b4 100644[m
[1m--- a/application/views/user/profile/view.php[m
[1m+++ b/application/views/user/profile/view.php[m
[36m@@ -63,7 +63,7 @@[m
 								<center>[m
 									<img src="<?php echo base_url('images/basis-usr-gold.png'); ?>" class="UserStImg">[m
 									<br>[m
[31m-									<h3 class="text-center"><?php echo $this->lang->line('only_viscmdible_to_vip_members'); ?></h3>[m
[32m+[m									[32m<h3 class="text-center"><?php echo $this->lang->line('only_visible_to_vip_members'); ?></h3>[m
 									<br>[m
 									<a href="<?php echo base_url('user/vip'); ?>" class="buy_nw_credit btn_hover"><?php echo $this->lang->line('become_a_vip_now'); ?></a>[m
 								</center>[m
[1mdiff --git a/system/language/english/site_lang.php b/system/language/english/site_lang.php[m
[1mindex e7f215c..61e0dcd 100644[m
[1m--- a/system/language/english/site_lang.php[m
[1m+++ b/system/language/english/site_lang.php[m
[36m@@ -96,6 +96,7 @@[m [m$lang['location'] = 'Location';[m
 $lang['enter_location'] = 'Enter location';[m
 $lang['figure'] = 'Figure';[m
 $lang['size'] = 'Size';[m
[32m+[m[32m$lang['enter_size'] = 'Enter Size';[m
 $lang['hair_color'] = 'Hair Color';[m
 $lang['eye_color'] = 'Eye Color';[m
 $lang['ethnic_affiliation'] = 'Ethnic affiliation';[m
[1mdiff --git a/system/language/english/user_lang.php b/system/language/english/user_lang.php[m
[1mindex 4df651f..c3da3a8 100644[m
[1m--- a/system/language/english/user_lang.php[m
[1m+++ b/system/language/english/user_lang.php[m
[36m@@ -470,6 +470,7 @@[m [m$lang['month'] = 'Month';[m
 $lang['year'] = 'Year';[m
 $lang['my_description'] = 'My Description';[m
 $lang['enter_location'] = 'Enter location';[m
[32m+[m[32m$lang['enter_username'] = 'Enter username';[m
 $lang['how_can_man_impress_you'] = 'How can a man impress you?';[m
 $lang['how_can_women_impress_you'] = 'How can a women impress you?';[m
 $lang['how_can_man_impress_to'] = 'How can a man impress to me?';[m
[1mdiff --git a/system/language/german/site_lang.php b/system/language/german/site_lang.php[m
[1mindex 1019ffb..a8df482 100644[m
[1m--- a/system/language/german/site_lang.php[m
[1m+++ b/system/language/german/site_lang.php[m
[36m@@ -96,6 +96,7 @@[m [m$lang['location'] = 'Ort';[m
 $lang['enter_location'] = 'Ort eingeben';[m
 $lang['figure'] = 'Figur';[m
 $lang['size'] = 'Größe';[m
[32m+[m[32m$lang['enter_size'] = 'Größe eingeben';[m
 $lang['hair_color'] = 'Haarfarbe';[m
 $lang['eye_color'] = 'Augenfarbe';[m
 $lang['ethnic_affiliation'] = 'ethnische Zugehörigkeit';[m
[1mdiff --git a/system/language/german/user_lang.php b/system/language/german/user_lang.php[m
[1mindex f66cb84..815d0c9 100644[m
[1m--- a/system/language/german/user_lang.php[m
[1m+++ b/system/language/german/user_lang.php[m
[36m@@ -470,6 +470,7 @@[m [m$lang['month'] = 'Monat';[m
 $lang['year'] = 'Jahr';[m
 $lang['my_description'] = 'Meine Beschreibung';[m
 $lang['enter_location'] = 'Ort eingeben';[m
[32m+[m[32m$lang['enter_username'] = 'Ort Nutzername';[m
 $lang['how_can_man_impress_you'] = 'Wie kann ein Mann Sie beeindrucken?';[m
 $lang['how_can_women_impress_you'] = 'Wie können Frauen Sie beeindrucken?';[m
 $lang['how_can_man_impress_to'] = 'Wie kann mich ein Mann beeindrucken?';[m
[1mdiff --git a/system/language/italian/site_lang.php b/system/language/italian/site_lang.php[m
[1mindex b9c9ebd..1e4e4c6 100644[m
[1m--- a/system/language/italian/site_lang.php[m
[1m+++ b/system/language/italian/site_lang.php[m
[36m@@ -96,6 +96,7 @@[m [m$lang['location'] = 'Posizione';[m
 $lang['enter_location'] = 'Inserisci posizione';[m
 $lang['figure'] = 'Figure';[m
 $lang['size'] = 'Dimensione';[m
[32m+[m[32m$lang['enter_size'] = 'inserisci la dimensione';[m
 $lang['hair_color'] = 'Colore capelli';[m
 $lang['eye_color'] = 'Colore occhi';[m
 $lang['ethnic_affiliation'] = 'affiliazione etnica';[m
[1mdiff --git a/system/language/italian/user_lang.php b/system/language/italian/user_lang.php[m
[1mindex 3d7cd3e..816ca60 100644[m
[1m--- a/system/language/italian/user_lang.php[m
[1m+++ b/system/language/italian/user_lang.php[m
[36m@@ -470,6 +470,7 @@[m [m$lang['month'] = 'Mese';[m
 $lang['year'] = 'Year';[m
 $lang['my_description'] = 'La mia descrizione';[m
 $lang['enter_location'] = 'Inserisci posizione';[m
[32m+[m[32m$lang['enter_username'] = 'Inserisci username';[m
 $lang['how_can_man_impress_you'] = 'Come può un uomo impressionarti?';[m
 $lang['how_can_women_impress_you'] = 'Come può una donna impressionarti?';[m
 $lang['how_can_man_impress_to'] = 'Come può un uomo impressionarmi?';[m
