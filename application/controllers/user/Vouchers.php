<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if(!$this->session->has_userdata('user_id')) {
			redirect(base_url());
		}
        $this->load->model('voucher_model');
    }
	
	public function getVoucherInfo() {
		$voucher_code = $this->input->post('voucher_code');
		$voucherInfo = $this->voucher_model->getVoucherByCode($voucher_code);
		print json_encode( $voucherInfo);die;
	}
}