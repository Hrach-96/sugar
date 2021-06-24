<?php

class OK_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Returns user's language or website default language.
	 * 
	 * @param string $user_id
	 * @return string
	 */
	protected function get_language_setting($user_id = '') {
		// if (!empty($user_id)) {
		// 	$this->load->model("user_model");
		// 	$language_result = $this->user_model->get_user_language($user_id)->result_array();

		// 	if (sizeof($language_result) > 0) {
		// 		return $language_result[0]["language"];
		// 	}
		// }

		// $this->load->model('site_model');
		// $settings_result = $this->site_model->get_website_settings();

		// if (sizeof($settings_result) > 0) {
		// 	return $settings_result["default_language"];
		// }

		return '';
	}

}
