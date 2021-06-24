<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class CI_Push_parse extends CI_Driver {

	const PARSE_API_ENDPOINT = 'https://parseapi.back4app.com/';

	protected $app_id;
	protected $rest_key;

	public function __construct() {
		$CI = & get_instance();
		$CI->config->load('parse', FALSE, TRUE);

		$this->app_id = $CI->config->item('parse_app_id');
		$this->rest_key = $CI->config->item('parse_rest_key');
	}

	public function link($userId, $installationId) {
		$handle = curl_init(CI_Push_parse::PARSE_API_ENDPOINT . "classes/_Installation/" . $installationId);
		$parameters = array('userId' => strval($userId));
		$json = json_encode($parameters);
		$headers = array('Content-Type: application/json',
			'Content-Length: ' . strlen($json),
			'X-Parse-Application-Id: ' . $this->app_id,
			'X-Parse-REST-API-Key: ' . $this->rest_key);

		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($handle, CURLOPT_POSTFIELDS, $json);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($handle);
		log_message('debug', 'Link ' . $userId . '/' . $installationId . ' response: (' . curl_getinfo($handle, CURLINFO_HTTP_CODE) . ') ' . $response);

		curl_close($handle);

		return true;
	}

	public function push($userId, $message) {
		$handle = curl_init(CI_Push_parse::PARSE_API_ENDPOINT . "push");
		$parameters = array('where' => array('userId' => strval($userId)), 'data' => array('alert' => $message));
		$json = json_encode($parameters);
		$headers = array('Content-Type: application/json',
			'Content-Length: ' . strlen($json),
			'X-Parse-Application-Id: ' . $this->app_id,
			'X-Parse-REST-API-Key: ' . $this->rest_key);

		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_POSTFIELDS, $json);
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($handle);
		log_message('debug', 'Push to ' . $userId . ' response: (' . curl_getinfo($handle, CURLINFO_HTTP_CODE) . ') ' . $response);

		curl_close($handle);

		return true;
	}

	public function is_supported() {
		return (isset($this->app_id) && isset($this->rest_key));
	}

}
