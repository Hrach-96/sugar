<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diamonds extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }
	
    public function index() {   
		$data = array();
		$this->load->model(['diamond_package_model']);

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data['diamond_packages'] = $this->diamond_package_model->get_active_diamond_package_list(4, 0);
        $this->load->view('user/diamonds/view', $data);
    }


    public function buy() {
        $this->load->model(['diamond_package_model', 'user_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('diamond_package_id', 'diamond_package_id', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_userdata('message', 'Unauthorized Access');
        } else {
            $package_id = $this->input->post('diamond_package_id');
            $user_id = $this->session->userdata('user_id');

            $package_info = $this->diamond_package_model->get_active_package_info($package_id);

            if($package_info) {
                $user_current_diamonds = $this->session->userdata('user_diamonds');

                $buy_diamond_package = array(
                    'purchased_user_id' => $user_id,
                    'diamond_package_id' => $package_info['package_id'],
                    'diamond_package_name' => $package_info['package_name'],
                    'diamond_package_diamonds' => $package_info['package_diamonds'],
                    'diamond_package_amount' => $package_info['package_amount'],
                    'buy_diamond_date' => gmdate('Y-m-d H:i:s'),
                    'buy_diamond_flag' => 'web'
                );

                $this->db->trans_begin();
                $this->diamond_package_model->insert_user_buy_diamonds($buy_diamond_package);

                $user_current_diamonds = $user_current_diamonds + $package_info['package_diamonds'];
                $this->user_model->update_user_diamonds($user_id, $user_current_diamonds);

                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_userdata('message', 'internal_server_error');
                } else {
                    $this->db->trans_commit();                    
                    $this->session->set_userdata('user_diamonds', $user_current_diamonds);
                    $this->session->set_userdata('message', 'your_diamonds_has_been_credited_successfully_into_your_account');
                }
            } else {
                $this->session->set_userdata('message', 'this_package_is_not_active_please_choose_another_package');
            }
        }
        redirect(base_url('buy/diamond'));
    }

}
