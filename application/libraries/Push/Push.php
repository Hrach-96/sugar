<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Push extends CI_Driver_Library {
	/**
	 * Valid drivers
	 *
	 * @var array
	 */
	protected $valid_drivers = array(
		'parse'
	);

	/**
	 * Reference to the driver
	 *
	 * @var mixed
	 */
	protected $_adapter = 'parse';

	/**
	 * Constructor
	 *
	 * Initialize class properties based on the configuration array.
	 *
	 * @param	array	$config = array()
	 * @return	void
	 */
	public function __construct($config = array()) {
		
	}

	public function link($userId, $externalId) {
		if ($this->is_supported($this->_adapter)) {
			return $this->{$this->_adapter}->link($userId, $externalId);
		} else {
			log_message('error', 'Link ignored due to unsupported driver.');
			return false;
		}
	}

	public function push($userId, $message) {
		if ($this->is_supported($this->_adapter)) {
			return $this->{$this->_adapter}->push($userId, $message);
		} else {
			log_message('error', 'Push ignored due to unsupported driver.');
			return false;
		}
	}

	public function is_supported($driver) {
		return $this->{$driver}->is_supported();
	}

}
