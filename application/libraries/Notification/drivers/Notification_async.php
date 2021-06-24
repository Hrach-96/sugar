<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notify_async
 *
 * @author Mehshan Mustafa <m.mustafa@mehshan.com>
 */
class CI_Notification_async extends CI_Driver {

	public function send($user_id) {
		$parameters = array('uid' => $user_id);

		if ($this->can_push()) {
			$parameters['push'] = $this->push;
		}

		if ($this->can_email()) {
			$parameters['subject'] = $this->subject;
			$parameters['message'] = $this->message;
		}

		$this->CI->config->load('async', FALSE, TRUE);
		$key = $this->CI->config->item('async_key');

		if (!empty($key)) {
			$parameters['key'] = $key;
		}

		$url = base_url('async/notify?') . http_build_query($parameters);
		$handle = curl_init($url);

		curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($handle, CURLOPT_HEADER, false);
		curl_setopt($handle, CURLOPT_NOBODY, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($handle, CURLOPT_TIMEOUT, 1);

		$response = curl_exec($handle);
		log_message('debug', 'Send to ' . $user_id . ' async: ' . curl_getinfo($handle, CURLINFO_HTTP_CODE));

		curl_close($handle);

		return true;
	}

}
