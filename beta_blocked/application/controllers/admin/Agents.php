<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agents extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('user_type') != 'admin') {
            redirect(base_url());
        }
    }

	public function index() {
    	$data = array();

        $this->load->model(['user_model', 'user_content_model', 'photo_model']);

	    $user_id = $this->session->userdata('user_id');
        $user_gender = $this->session->userdata('user_gender');

	    $settings = $this->session->userdata('site_setting');
	    $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        // if clicked on search then show users as per the search key
        if(isset($_POST['btn-search'])) {
            $this->session->set_userdata('search_key_for_manage_agents', $this->input->post('search_text'));
        }
        $search_key = $this->session->userdata('search_key_for_manage_agents');


    	$per_page = 12;
    	$page_no = 0;
    	if(isset($_GET['per_page'])) {
    		$page_no = $_GET['per_page'] - 1;
    	}
    	$offset = $page_no * $per_page;

        $data["users"] = $this->user_model->get_all_agents_list($per_page, $offset, $search_key);

		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/agents'));
			}
		}

        $tmp_user_array = array();
        if(!empty($data["users"])) {
            foreach ($data["users"] as $user_row) {
                $user_row["todays_content_approved"] =  $this->user_content_model->count_today_agent_approvals($user_row['user_id']);
                $user_row["total_content_approved"] =  $this->user_content_model->count_total_agent_approvals($user_row['user_id']);
                $user_row["todays_images_approved"] =  $this->photo_model->count_today_agent_approvals($user_row['user_id']);
                $user_row["total_images_approved"] =  $this->photo_model->count_total_agent_approvals($user_row['user_id']);
                $tmp_user_array[] = $user_row;
            }

        }
        $data['users'] = $tmp_user_array;
        $total_users = $this->user_model->count_all_agents($search_key);

        $url = base_url().'admin/agents';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
		$this->pagination->initialize($config);
		$data["links"] = $this->pagination->create_links();

        $data['search_key'] = $search_key;
		$this->load->view('admin/agents/manage', $data);
	}

    public function addAgent() {
        $data = array();

        $this->load->model(['auth_model', 'user_model']);
        $settings = $this->session->userdata('site_setting');               
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'user_name', 'required|is_unique[tbl_users.user_access_name]|trim');
        $this->form_validation->set_rules('user_password', 'user_password', 'required|trim');    
        $this->form_validation->set_rules('email_address', 'email_address', 'required|valid_email|is_unique[tbl_users.user_email]|trim');
        $this->form_validation->set_rules('user_postcode', 'user_postcode', 'required|trim');
        $this->form_validation->set_rules('user_location', 'user_location', 'required|trim');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));
        $this->form_validation->set_message('valid_email', $this->lang->line('please_correct_your_information'));
        $this->form_validation->set_message('decimal', $this->lang->line('please_insert_decimal_number'));
        $this->form_validation->set_message('is_unique', $this->lang->line('already_added'));

        if ($this->form_validation->run() != FALSE) {
            $user_password = sha1($this->input->post('user_password'));

            $login_register_array = array(
                'user_access_name' => $this->input->post('user_name'),
                'user_password' => $user_password,
                'user_email' => $this->input->post('email_address'),
                'user_type' => 'agent',
                'user_status' => 'active',
                'user_verified' => 'no',
                'user_is_vip' => 'no',
                'user_flag' => 'web',
                'user_credits' => 0,
                'user_diamonds' => 0,
                'user_taken_free_credits' => 0
            );

            // START Transaction
            $this->db->trans_begin();
            $user_id = $this->auth_model->create_user($login_register_array);

            if($user_id) { 
                // Use : user Transaction strategy
                $this->load->library('encryption');
                $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
                $user_enc_id = $this->encryption->encrypt($user_id);

                $u_user_array = array(
                    'user_id_encrypted' => $user_enc_id
                );
                $this->auth_model->update_user($user_id, $u_user_array);

                $user_city = explode(',', $this->input->post('user_location'));
                $date_of_birth = $this->input->post('dateofbirth_year').'-'.$this->input->post('dateofbirth_month').'-'.$this->input->post('dateofbirth_day');
                $user_interested_in = ($this->input->post('user_gender') == 'male')?'female':'male';
                $user_information_array = array(
                    'user_id_ref' => $user_id,
                    'user_gender' => $this->input->post('user_gender'),
                    'user_interested_in' => $user_interested_in,
                    'user_birthday' => $date_of_birth,
                    'user_country' => $this->input->post('user_country'),
                    'user_postcode' => $this->input->post('user_postcode'),
                    'user_city' => $user_city[0],
                    'user_latitude' => $this->input->post('user_latitude'),
                    'user_longitude' => $this->input->post('user_longitude'),
                    'language_id_ref' => 1,
                    'user_active_photo' => '',
                    'user_active_photo_thumb' => '',
                    'show_upload_profile_pic_count' => 0,
                    'user_info_flag' => 'web'
                ); 
                $this->auth_model->create_user_info($user_information_array);
            }

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('message', $this->lang->line('agent_has_been_added_successfully'));
            }
            redirect(base_url('admin/agents'));
        }

        $data["settings"] = $settings;      
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $this->load->view('admin/agents/add', $data);
    }
	
    public function editProfile() {
        $data = array();
        $member_id_enc = $this->input->get('user_hash');

        $this->load->model(['user_model']);

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        // Member profile information
        $data["user_row"] = $this->user_model->get_user_information($member_id);
        // if record found this redirect to back page
        if(empty($data["user_row"])) {
            $redirect_url = base_url('admin/agents');
            if($this->input->server('HTTP_REFERER')) {
                $redirect_url = $this->input->server('HTTP_REFERER');
            }
            $this->session->set_userdata('message', $this->lang->line('no_profile_found'));
            redirect($redirect_url);
        }

        $this->load->view('admin/agents/edit', $data);
    }

    public function blockUser() {
        $data = array();

        $this->load->model(['user_model']);
    
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $member_id_enc = $this->input->get('user_hash');
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $status_arr = array('user_status' => 'blocked');
        $success_flg = $this->user_model->update_user($member_id, $status_arr);

        if($success_flg) {
            $this->session->set_flashdata('message', $this->lang->line('user_profile_has_been_blocked_successfully'));            
        } else {
            $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
        }
        redirect(base_url('admin/agents'));
    }


    public function activateUser() {
        $data = array();

        $this->load->model(['user_model', 'email_model', 'photo_model']);
    
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $member_id_enc = $this->input->get('user_hash');
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $user_info = $this->user_model->get_user_information($member_id);

        $status_arr = array('user_status' => 'active');
        $success_flg = $this->user_model->update_user($member_id, $status_arr);

        if($success_flg) {
            // Send Email to user for account activated
            $to_email = $user_info['user_email'];
            $subject = $this->lang->line('account_activated');            
            $data['user_name'] = $user_info['user_access_name'];

            $data['user_profile_pic'] = base_url("images/avatar/".$user_info['user_gender'].".png");
            // Get active profile picture photo
            $profile_pic = $this->photo_model->get_user_profile_pic($member_id);
            if($profile_pic) {
                $data['user_profile_pic'] = base_url($profile_pic['photo_thumb_url']);
            }
            $data['email_template'] = 'email/activate_user_account';
            $email_message = $this->load->view('templates/email/main', $data, true);
            @$this->email_model->sendEMail($to_email, $subject, $email_message);

            $this->session->set_flashdata('message', $this->lang->line('user_profile_has_been_activated_successfully'));            
        } else {
            $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
        }
        redirect(base_url('admin/agents'));
    }


}
