<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Mailer_sendgrid
 *
 * @author Mehshan Mustafa <m.mustafa@mehshan.com>
 */
class Mailer_sendgrid extends CI_Driver {

	/**
	 * E-mail template bindings
	 * 
	 * @var array 
	 */
	protected $templates;

	public function __construct($config = array()) {
		$CI = & get_instance();

		$CI->config->load('sendgrid', FALSE, TRUE);

		$this->templates = $CI->config->item('sendgrid_templates');
	}

	/**
	 * Generates SMTP headers for email template integration.
	 * 
	 * @param array $user
	 * @return array
	 */
	public function get_smtp_headers() {
		$user = $this->user;
		$SMTPAPI = array();

		$SMTPAPI["sub"] = array(
			'-id-' => [$user['uid']],
			'-username-' => [$user['username']],
			'-photo-' => [(isset($user['thumb_url']) ? base_url($user['thumb_url']) : base_url('images/avatar.png'))],
			'-country-' => [(isset($user['country']) ? $user['country'] : "")]
		);

		$template = $this->get_template();

		if (!empty($template)) {
			$filters = array("templates" => ["settings" => ["enable" => 1, "template_id" => $template]]);
			$SMTPAPI["filters"] = $filters;
		}

		$headers['X-SMTPAPI'] = json_encode($SMTPAPI);

		return $headers;
	}

	/**
	 * Returns template for subject.
	 * 
	 * @return string
	 */
	public function get_template() {
		if (isset($this->templates)) {
			$subject = $this->subject;
			return @$this->templates[$subject];
		}

		return null;
	}

}
