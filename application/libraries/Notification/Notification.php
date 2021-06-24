<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

class Notification extends CI_Driver_Library {

	/**
	 * Valid drivers
	 *
	 * @var array
	 */
	protected $valid_drivers = array(
		'async'
	);

	/**
	 * Reference to the driver
	 *
	 * @var mixed
	 */
	protected $_adapter = 'async';

	/**
	 * E-mail subject
	 * 
	 * @var string 
	 */
	public $subject;

	/**
	 * E-mail message
	 * 
	 * @var string 
	 */
	public $message;

	/**
	 * Short push message
	 * 
	 * @var string
	 */
	public $push;

	/**
	 * @var mixed CodeIgniter instance 
	 */
	public $CI;

	public function __construct() {
		$this->CI = & get_instance();
	}

	/**
	 * 
	 * @param string $user_id
	 * @return boolean
	 */
	public function send($user_id) {
		if ($this->can_email() || $this->can_push()) {
			return $this->{$this->_adapter}->send($user_id);
		} else {
			log_message('error', 'Notification skipped, no email/push info.');
			return false;
		}
	}

	public function can_email() {
		return (isset($this->message) && isset($this->subject));
	}

	public function can_push() {
		return isset($this->push);
	}

}
