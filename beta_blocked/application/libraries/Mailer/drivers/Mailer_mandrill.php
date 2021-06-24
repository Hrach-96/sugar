<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Mailer_mandrill
 *
 * @author Mehshan Mustafa <m.mustafa@mehshan.com>
 */
class Mailer_mandrill extends CI_Driver {

	/**
	 * Generates SMTP headers for email template integration.
	 * 
	 * @param array $user
	 * @return array
	 */
	public function get_smtp_headers() {
		$user = $this->user;
		$headers = array();

		$variables = array(
			'id' => $user['uid'],
			'username' => $user['username'],
			'photo' => isset($user['thumb_url']) ? base_url($user['thumb_url']) : base_url('images/avatar.png'),
			'country' => isset($user['country']) ? $user['country'] : ""
		);
		
		$headers['X-MC-MergeVars'] = json_encode($variables);

		return $headers;
	}

}
