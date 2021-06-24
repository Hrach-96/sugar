<?php

/**
 * Description of Mailer
 *
 * @author Mehshan Mustafa <m.mustafa@mehshan.com>
 */
class Mailer extends CI_Driver_Library {

	/**
	 * Valid drivers
	 *
	 * @var array
	 */
	protected $valid_drivers = array(
		'mandrill', 'sendgrid'
	);

	/**
	 * Reference to the driver
	 *
	 * @var mixed
	 */
	protected $_adapter = 'sendgrid';

	/**
	 *
	 * @var mixed CodeIgniter instance 
	 */
	protected $CI;
	public $user;
	public $subject;
	public $message;

	/**
	 * Constructor
	 *
	 * Initialize class properties based on the configuration array.
	 *
	 * @param	array	$config = array()
	 * @return	void
	 */
	public function __construct($config = array()) {
		$this->CI = & get_instance();
	}

	/**
	 * Generates SMTP headers for email template integration.
	 * 
	 * @param array $user
	 * @return array
	 */
	public function get_smtp_headers() {
		return $this->{$this->_adapter}->get_smtp_headers();
	}

	/**
	 * Sends e-mail.
	 * 
	 * @return boolean
	 */
	public function email() {
		$this->CI->load->library('email');
		$this->CI->load->model("site_model");

		$settings = $this->CI->site_model->get_website_settings()->result_array()[0];
		$config = array(
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'priority' => '1'
		);

		$this->CI->email->initialize($config);
		$this->CI->email->from($settings["from_email"], $settings["site_name"]);
		$this->CI->email->to($this->user["email"]);
		$this->CI->email->subject($this->subject);
		$this->CI->email->message($this->message);

		$headers = $this->get_smtp_headers();

		foreach ($headers as $key => $value) {
			$this->CI->email->set_header($key, $value);
		}

		$result = $this->CI->email->send();
		log_message('debug', 'E-mail to ' . $this->user["username"] . ': ' . $this->CI->email->print_debugger());

		return $result;
	}

}
