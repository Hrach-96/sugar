<?php 
	$this->load->view('templates/email/header');
	$this->load->view($email_template);
	$this->load->view('templates/email/footer');
?>