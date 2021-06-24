<?php
if( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Oppwa {

	private $entityId;
	private $accessToken;
	private $url;
	private $currency;

	public function __construct($config = array()) {
		// Store the config values
		$this->entityId = $config['entityId'];
		$this->accessToken = $config['accessToken'];
		$this->url = $config['url'];
		$this->currency = $config['currency'];
	}
	public function sendRepeatedPayment($amount,$registration_id) {
		$data = "entityId=" . $this->entityId;
	    $data .= "&amount=" . $amount ;
	    $data .= "&currency=" . $this->currency;
	    $data .= "&paymentType=DB";
	    $data .= "&recurringType=REPEATED";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url.'v1/registrations/' . $registration_id . '/payments');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$this->accessToken));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$responseData = curl_exec($ch);
		if(curl_errno($ch)) {
			return curl_error($ch);
		}
		curl_close($ch);
		return $responseData;
	}
	public function prepareCheckout($amount) {
		$data = "entityId=" . $this->entityId;
	    $data .= "&amount=" . $amount;
	    $data .= "&currency=" . $this->currency;
	    $data .= "&paymentType=DB";
	    $data .= "&createRegistration=true";
	    $data .= "&recurringType=INITIAL";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url.'v1/checkouts');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$this->accessToken));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$responseData = curl_exec($ch);
		if(curl_errno($ch)) {
			return curl_error($ch);
		}
		curl_close($ch);
		return $responseData;
	}

	public function paymentStatus($checkoutId) {
		$url = $this->url . "v1/checkouts/" . $checkoutId . "/payment";
		$url .= "?entityId=".$this->entityId;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$this->accessToken));
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$responseData = curl_exec($ch);
		if(curl_errno($ch)) {
			return curl_error($ch);
		}
		curl_close($ch);
		return $responseData;
	}


}
