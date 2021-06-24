<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {


	public function index() {

		if($this->session->has_userdata('user_id')) {
			redirect(base_url() . "home");
		} else {
			$this->load->library('user_agent');
			$this->load->model(['site_model', 'contact_request_model', 'sport_model', 'language_model', 'interest_model', 'static_data_model', 'language_model']);
					
			if(!$this->session->has_userdata('site_setting')) {
				$settings = $this->site_model->get_website_settings();
				$site_defaults = TRUE;
				// Identify user country as per their IP Address
				$this->load->library('geoip');
				try {
					// IF IP found					
					$ip_info = $this->geoip->get_country_info($this->input->server('REMOTE_ADDR'));
					
					$currency_symbol = $this->country_model->get_country_info_by_abbr($ip_info->country->isoCode);
					if(!empty($currency_symbol)) {
						$site_defaults = FALSE;
						
						$this->session->set_userdata('site_language', $currency_symbol["language_name"]);
						$this->session->set_userdata('site_country_abbr', $currency_symbol["country_abbr"]);
						$this->session->set_userdata('site_currency_symbol', $currency_symbol['country_currency_text']);
						$this->session->set_userdata('site_timezone', $ip_info->location->timeZone);
						
						$user_currlocation = array(
							'country' => $ip_info->country->name,
							'city' => $ip_info->city->name,
							'latitude' => $ip_info->location->latitude,
							'longitude' => $ip_info->location->longitude
						);
						$this->session->set_userdata('user_currlocation', $user_currlocation);
					} else {
						$site_defaults = FALSE;
						
						// If IP Not Found
						$currency_symbol = $this->country_model->get_country_info_by_abbr($settings["default_country_abbr"]);

						$this->session->set_userdata('site_language', $settings["default_language"]);
						$this->session->set_userdata('site_country_abbr', $settings["default_country_abbr"]);
						$this->session->set_userdata('site_currency_symbol', $currency_symbol['country_currency_text']);
						$this->session->set_userdata('site_timezone', $ip_info->location->timeZone);
					}
				} catch(Exception $ae) {
					// SHow if any error
				}

				if($site_defaults == TRUE) {
					// If IP Not Found
					$currency_symbol = $this->country_model->get_country_info_by_abbr($settings["default_country_abbr"]);

					$this->session->set_userdata('site_language', $settings["default_language"]);
					$this->session->set_userdata('site_country_abbr', $settings["default_country_abbr"]);
					$this->session->set_userdata('site_currency_symbol', $currency_symbol['country_currency_text']);
					$this->session->set_userdata('site_timezone', DEFAULT_TIMEZONE);
				}				

				$this->session->set_userdata('site_setting', $settings);
			}
			$settings = $this->session->userdata('site_setting');
			$this->lang->load('site_lang', $this->session->userdata('site_language'));
			
			// Captcha for security purpose 
			$this->load->helper('captcha');
			$captcha_vals = array(
		        'img_path'      => './images/captcha/',
		        'img_url'       => base_url().'images/captcha/',
       			'word_length'   => 6,
       			'pool'			=> '0123456789',
        		'font_size'     => 22,
   				'colors'        => array(
                	'background' => array(9, 2, 22),
                	'border' => array(9, 2, 22),
                	'text' => array(239, 232, 11),
                	'grid' => array(12, 79, 193)
        		)
			);
			$cap_res = create_captcha($captcha_vals);
			$this->session->set_userdata('captcha_text', $cap_res['word']);

			$data = array(
				"title" => $settings["site_name"] . " - " . $settings["site_tagline"],
				"fb_login_url" => $this->facebook->login_url(),
				"is_mobile" => $this->agent->is_mobile(),
				"settings" => $settings,
				"contact_requests" =>$this->contact_request_model->get_active_contact_request_list(),
				"sports" => $this->sport_model->get_active_sports_list(),
				"language_list" => $this->language_model->get_spoken_language_list(),
				"interests" => $this->interest_model->get_active_interest_list(),				
        		"figure_list" => $this->static_data_model->get_figure_list(),
        		"job_list" => $this->static_data_model->get_job_list(),
        		"ethnicity_list" => $this->static_data_model->get_ethnicity_list(),
        		"eye_color_list" => $this->static_data_model->get_eye_color_list(),
        		"hair_color_list" => $this->static_data_model->get_hair_color_list(),
        		"captcha_image_url" => base_url('images/captcha/'.$cap_res['filename']),
        		"site_language_list" => $this->language_model->get_languages_used_for_site(),
			);

			$this->load->view('site/welcome', $data);
		}
	}
	
	public function newsSubscription() {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_email', 'user_email', 'required|valid_email|trim');

        if($this->input->server('HTTP_REFERER')) {
            $this->session->set_userdata('back_url', $this->input->server('HTTP_REFERER'));
        } else {
            if($this->session->userdata('back_url') == '') {
                $this->session->set_userdata('back_url', base_url());
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('message', 'please_enter_valid_email');
        } else {
			$this->load->model(['news_model', 'email_model']);
			$user_email = $this->input->post('user_email');
			$news_info = $this->news_model->get_news_subscribed_info($user_email);

			if($news_info) {
				if($news_info['news_subscriber_status'] == 'subscribed') {
					$this->session->set_userdata('message', 'you_have_already_subscribed');
				} else {
					$news_data = array(
						"news_subscriber_status" => 'subscribed',
						"news_subscriber_added_date" => gmdate('Y-m-d H:i:s'),
						"news_subscriber_flag" => 'web'
					);
					$success = $this->news_model->update_news_subscription($user_email, $news_data);
					if($success) {
						// Send Subscription Email
		                $email_data = array(
		                    'to_email' => $user_email,
		                    'base_url' => base_url()
		                );
		                @$this->email_model->newsSubscriptionEmail($email_data);

						$this->session->set_userdata('message', 'you_have_been_subscribed_successfully_for_upcoming_news_and_offers');
					} else {
						$this->session->set_userdata('message', 'internal_server_error');
					}
				}
			} else {
				$news_data = array(
					"news_subscriber_email" => $user_email,
					"news_subscriber_status" => 'subscribed',
					"news_subscriber_added_date" => gmdate('Y-m-d H:i:s'),
					"news_subscriber_flag" => 'web'
				);

				$success = $this->news_model->insert_news_subscription($news_data);
				if($success) {
					// Send Subscription Email
	                $email_data = array(
	                    'to_email' => $user_email,
	                    'base_url' => base_url()
	                );
	                @$this->email_model->newsSubscriptionEmail($email_data);

					$this->session->set_userdata('message', 'you_have_been_subscribed_successfully_for_upcoming_news_and_offers');
				} else {
					$this->session->set_userdata('message', 'internal_server_error');
				}
			}
        }
        redirect($this->session->userdata('back_url'));
	}
}
