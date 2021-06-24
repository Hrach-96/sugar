<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vouchers extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
	    $this->load->model(['voucher_model']);
    }

	public function index() {
		$data = array();

		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $per_page = 5;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        // get_vouchers
		$data["vouchers"] = $this->voucher_model->get_vouchers($per_page, $offset);

		if($data["vouchers"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/vouchers'));
			}
		}
		$data["offset"] = $offset;
		$total_transactions = $this->voucher_model->count_vouchers();

        $url = base_url().'admin/vouchers';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_transactions, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/voucher/view_voucher', $data);
	}
	public function generateVoucherCode() {
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 8; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		$exist = $this->voucher_model->checkVoucherExist($res);
		if($exist == 0){
			return $res;
		}
		else{
			$this->generateVoucherCode();
		}
	}
	public function removeVoucher($id) {
		$this->lang->load('user_lang', $this->session->userdata('site_language'));
		$this->voucher_model->removeVoucher($id);
		$this->session->set_flashdata('message', $this->lang->line('voucher_has_removed'));
		redirect(base_url('admin/vouchers'));
	}
	public function editVoucher($id) {
		$data = array();

		$settings = $this->session->userdata('site_setting');				
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

 		$this->load->helper('form');
 		$this->load->library('form_validation');
		$this->form_validation->set_rules('procent', 'procent', 'required|trim');

		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		$this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
		
        if ($this->form_validation->run() != FALSE) {
			$voucher_data = array(
				'procent' => $this->input->post('procent'),
			);

			$update_flg = $this->voucher_model->update_voucher($id, $voucher_data);
			
			if($update_flg) {
				$this->session->set_flashdata('message', $this->lang->line('voucher_has_been_updated_successfully'));
				redirect(base_url('admin/vouchers'));
			}			
		}

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["voucher"] = $this->voucher_model->getVoucherById($id);
		$this->load->view('admin/voucher/edit_voucher', $data);
	}
	public function addVoucher() {
		$data = array();
        $settings = $this->session->userdata('site_setting');               
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('procent', 'procent', 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));

        if ($this->form_validation->run() != FALSE) {
            $user_password = sha1($this->input->post('user_password'));

            $voucher_register_array = array(
                'procent' => $this->input->post('procent'),
                'code' => $this->generateVoucherCode(),
            );

            $success_flg = $this->voucher_model->create_voucher($voucher_register_array);

            if($success_flg) {
				$this->session->set_flashdata('message', $this->lang->line('voucher_has_been_added_successfully'));
			} else {
				$this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
			}
            redirect(base_url('admin/vouchers'));
        }

        $data["settings"] = $settings;      
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $this->load->view('admin/voucher/add_voucher', $data);
	}
}