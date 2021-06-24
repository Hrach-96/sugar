<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocked extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

    public function index() {
        $data = array();

        $this->load->model(['dislike_model']);

        $user_id = $this->session->userdata('user_id');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 20;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;

        $data["users"] = $this->dislike_model->get_active_users_disliked_list($user_id, $per_page, $offset);

        if($data["users"] == false) {
            if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
                redirect(base_url('user/blocked'));
            }
        }

        $total_users = $this->dislike_model->get_active_users_disliked_count($user_id);

        $url = base_url().'user/blocked';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $this->load->view('user/blocked/view', $data);
    }


    // we service for unblocking member by user
    public function unblockUser() {
        $this->load->model(['dislike_model']);

        $member_id_enc = $this->input->post('member_hash');
        $user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $settings = $this->session->userdata('site_setting');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        
        $alreadyUnblocked = $this->dislike_model->is_member_disliked($user_id, $member_id);

        if($alreadyUnblocked == false) {
            $response['status'] = false;
            $response['errorCode'] = 0;
            $response['message'] = $this->lang->line('already_unblocked');
        } else {
            $updateData = array(
                'dislike_from_user_id' => $user_id, 
                'dislike_to_user_id' => $member_id,
            );
            $success = $this->dislike_model->unblock_user($updateData);

            if($success > 0) {
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['errorCode'] = 1;
                $response['message'] = $this->lang->line('internal_server_error');
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
