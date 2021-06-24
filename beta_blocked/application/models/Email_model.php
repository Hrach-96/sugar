<?php
class Email_model extends CI_Model {

	public function newsSubscriptionEmail($row) {
		$to_email = $row['to_email'];
		$base_url = $row['base_url'];
		$subject =	"Email Subscribed for News and Offers";

		$message = '<div style="background-color:black;height:600px;color:#c4a80f;padding:10px 20px;font-size:16px;">
			<div style="text-align:center;padding-top:10px;"><img src="'.$base_url.'images/logo.png" style="width:100px;"></div>
				<div style="border:1px solid yellow;margin-top:20px;padding:20px;background:#111111;">
				<p>Hi,</p>
				<p style="padding-left:10px;">Thank you for news and offers subscription on Sugarbabe-Deluxe.</p>
				<p style="padding-left:10px;">You will receive latest news and offers from Sugarbabe-Deluxe.</p>
				<p>Regards,<br>Sugarbabe-Deluxe</p>
			</div>
			<div style="text-align:center;color:white;">
				<h3 class="apptxt">Download Sugarbabe-Deluxe app</h3>
				<img src="'.$base_url.'images/ios.png" class="ios">
				<img src="'.$base_url.'images/android.png" class="android">
			</div>
		</div>';
		return $this->sendEMail($to_email, $subject, $message);
	}

	public function faqMessage($row) {
		$to_email = $row['to_email'];
		$base_url = $row['base_url'];
		$user_name = $row['user_name'];
		$subject =	"Thank you for your question";

		$message = '<div style="background-color:black;height:600px;color:#c4a80f;padding:10px 20px;font-size:16px;">
			<div style="text-align:center;padding-top:10px;"><img src="'.$base_url.'images/logo.png" style="width:100px;"></div>
				<div style="border:1px solid yellow;margin-top:20px;padding:20px;background:#111111;">
				<p>Dear '.$user_name.',</p>
				<p style="padding-left:10px;">Thank you for your query to us. We will reply to you shortly. </p>
				<p>Regards,<br>Sugarbabe-Deluxe</p>
			</div>
			<div style="text-align:center;color:white;">
				<h3 class="apptxt">Download Sugarbabe-Deluxe app</h3>
				<img src="'.$base_url.'images/ios.png" class="ios">
				<img src="'.$base_url.'images/android.png" class="android">
			</div>
		</div>';
		return $this->sendEMail($to_email, $subject, $message);
	}

	public function sendEMail($to_email, $subject, $message, $attachment='') {
		$settings = $this->session->userdata('site_setting');

		$config = array(
			'protocol'	=> $settings['email_protocol'],
			'crlf' 		=> '\r\n',
			'mailtype' 	=> 'html',			
			'charset' 	=> 'utf-8',
			'wordwrap' 	=> TRUE,
			'newline'	=> '\r\n'
        );

		if($settings['email_protocol'] == 'smtp') {
			$config['smtp_host'] = $settings['smtp_host'];
			$config['smtp_user'] = $settings['smtp_user'];
			$config['smtp_pass'] = $settings['smtp_pass'];
			$config['smtp_port'] = $settings['smtp_port'];
		}

		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->from($settings['from_email'], 'Sugarbabe-Deluxe');
		$this->email->to($to_email);
		$this->email->subject($subject);
		$this->email->message($message);
		if(!empty($attachment))
		{
			$this->email->attach($attachment);
		}
	 	$this->email->send();
		return $this->email->print_debugger();
	}
	
}