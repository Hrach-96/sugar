<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('user_type') != 'admin') {
            redirect(base_url());
        }
	    $this->load->model(['user_model','credit_package_model','vip_package_model','gift_model']);
    }

	public function index() {
    	$data = array();
		if($this->input->get('info')){
			$info = $this->input->get('info');
			$data['user_list'] = $this->user_model->search_users_by_like($info);
		}

		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["credit_packages"] = $this->credit_package_model->get_all_credits();
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$this->load->view('admin/gift/index', $data);
	}
	public function history() {
		$data = array();

		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));
		$info = '';
		if($this->input->get('info')){
			$info = $this->input->get('info');
		}
		$data['history_user_list'] = $this->gift_model->get_history_of_gift($info);
		$data["settings"] = $settings;		
		$data["credit_packages"] = $this->credit_package_model->get_all_credits();
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$this->load->view('admin/gift/history', $data);
	}
	public function canceled() {
    	$data = array();

		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data['canceled_user_list_himself'] = $this->vip_package_model->get_cancel_vip_history_all();
		if($this->input->get('info')){
			$info = $this->input->get('info');
			$data['canceled_user_list'] = $this->gift_model->get_gift_canceled_users_like($info);
		}else{
			$data['canceled_user_list'] = $this->gift_model->get_gift_canceled_users();
		}
		$data["settings"] = $settings;		
		$data["credit_packages"] = $this->credit_package_model->get_all_credits();
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$this->load->view('admin/gift/canceled', $data);
	}
	public function cancel_gifts_from_user() {
		$user_array = $this->input->post('choosed_user_array');
		foreach($user_array as $value){
			$select_gift_history = $this->gift_model->get_added_gift_by_id($value);
			$userInfo = $this->user_model->get_active_user_information($select_gift_history['user_id']);
			if($select_gift_history['type'] == 'credit'){
				$gift_credit = preg_replace('/[^0-9]/', '', $select_gift_history['name']);
				$new_credit = $userInfo['user_credits'] - $gift_credit;
				$this->user_model->update_user($select_gift_history['user_id'],array('user_credits'=>$new_credit));
			}
			else if($select_gift_history['type'] == 'vip'){
				$this->user_model->update_user($select_gift_history['user_id'],array('user_is_vip'=>'no'));
			}
			$this->gift_model->update_gift_info($value,array('canceled_date'=>gmdate("Y-m-d H:i:s")));
		}
		return true;
	}
	public function add_gifts_to_user() {
		$user_array = $this->input->post('choosed_user_array');
		$vip_gift_value = $this->input->post('vip_gift_value');
		$credit_gift_value = $this->input->post('credit_gift_value');
		if($vip_gift_value){
			foreach($user_array as $key=>$value){
				$user_info = $this->user_model->get_user_information($value);
				$get_vip_info = $this->vip_package_model->get_vip_info_via_month_and_gender($vip_gift_value,$user_info['user_gender']);
				$data_buy_vip = [
					'purchased_user_id' => $value,
					'vip_package_id' => $get_vip_info->package_id,
					'vip_package_name' => "Geschenk " . $get_vip_info->package_name,
					'vip_package_amount' => '0',
					'vip_package_diamonds' => $get_vip_info->package_total_diamonds,
					'package_validity_in_months' => $get_vip_info->package_validity_total_months,
					'package_activated_using' => 'amount',
					'transaction_id_ref' => '',
					'buy_vip_date' => gmdate('Y-m-d H:i:s'),
					'buy_vip_flag' => 'web',
					'repeated' => '1',
				];
				$data_gift_info = [
					'user_id' => $value,
					'type' => 'vip',
					'name' => $get_vip_info->package_name,
					'status' => 'active',
					'added_date' => gmdate('Y-m-d H:i:s'),
				];
				$insert_buy_vip_info = $this->gift_model->insert_gift_info($data_gift_info);
				$insert_buy_vip_info = $this->vip_package_model->insert_user_buy_vip($data_buy_vip);
				$update_user = $this->user_model->update_user($value,array('user_is_vip'=>'yes'));
			}
		}
		if($credit_gift_value){
			foreach($user_array as $key=>$value){
				$user_info = $this->user_model->get_user_information($value);
				$credit_package_info = $this->credit_package_model->get_active_package_info($credit_gift_value);
				$new_credit = $credit_package_info['package_credits'] + $user_info['user_credits'];
				$update_user = $this->user_model->update_user($value,array('user_credits'=>$new_credit));
				$data_buy_credit = [
					'purchased_user_id' => $value,
					'credit_package_id' => $credit_package_info['package_id'],
					'credit_package_name' => "Geschenk " . $credit_package_info['package_name'],
					'credit_package_credits' => $credit_package_info['package_credits'],
					'credit_package_amount' => '0',
					'transaction_id_ref' => '',
					'buy_credit_date' => gmdate('Y-m-d H:i:s'),
					'buy_credit_flag' => 'web',
				];
				$insert_buy_credit_info = $this->credit_package_model->insert_user_buy_credits($data_buy_credit);
				$data_gift_info = [
					'user_id' => $value,
					'type' => 'credit',
					'name' => $credit_package_info['package_name'],
					'status' => 'active',
					'added_date' => gmdate('Y-m-d H:i:s'),
				];
				$insert_buy_vip_info = $this->gift_model->insert_gift_info($data_gift_info);
			}
		}
		return true;
	}
}