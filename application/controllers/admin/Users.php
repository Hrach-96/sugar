<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();
        if($this->session->userdata('user_type') != 'admin') {
            redirect(base_url());
        }
    }

    public function index() {
        $data = array();

        $this->load->helper('form');
        $this->load->model(['user_model', 'country_model']);

        $user_id = $this->session->userdata('user_id');
        $user_gender = $this->session->userdata('user_gender');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        // if clicked on search then show users as per the search key
        $search_key = '';
        $search_email = '';
        $search_gender = '';
        $search_online = '';
        $search_country = '';
        $search_vip = '';
        if($this->input->get('key') != '') {
            $search_key = $this->input->get('key');
        }     
        if($this->input->get('email') != '') {
            $search_email = $this->input->get('email');
        }        
        if($this->input->get('gender') != '') {
            $search_gender = $this->input->get('gender');
        }
        if($this->input->get('online') != '') {
            $search_online = $this->input->get('online');
        }
        if($this->input->get('country') != '') {
            $search_country = $this->input->get('country');
        }
        if($this->input->get('vip') != '') {
            $search_vip = $this->input->get('vip');
        }

        $per_page = 12;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;

        $data["users"] = $this->user_model->get_all_users_list_new($per_page, $offset, $search_key,$search_email, $search_gender, $search_online, $search_country, $search_vip);

        if($data["users"] == false) {
            if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
                redirect(base_url('admin/users'));
            }
        }
        $total_users = $this->user_model->count_all_users_new($search_key,$search_email, $search_gender, $search_online, $search_country, $search_vip);
        
        $url = base_url().'admin/users';
        $url_params = array();
        if($search_key != '') {
            array_push($url_params, 'key='.$search_key);
        }
        if($search_email != '') {
            array_push($url_params, 'email='.$search_email);
        }
        if($search_gender != '') {
            array_push($url_params, 'gender='.$search_gender);
        }
        if($search_online != '') {
            array_push($url_params, 'online='.$search_online);
        }
        if($search_country != '') {
            array_push($url_params, 'country='.$search_country);
        }
        if($search_vip != '') {
            array_push($url_params, 'vip='.$search_vip);
        }
        if(!empty($url_params)) {
            $url = $url.'?'.implode('&', $url_params);
        }

        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['total_users'] = $total_users;
        $data['countries'] = $this->country_model->get_active_countries_list();

        $this->load->view('admin/users/manage', $data);
    }
    
    public function reported() {
        $data = array();

        $this->load->model(['user_model', 'report_user_model']);

        $user_id = $this->session->userdata('user_id');
        $user_gender = $this->session->userdata('user_gender');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        // if clicked on search then show users as per the search key
        if(isset($_POST['btn-search'])) {
            $this->session->set_userdata('search_key_for_reported_users', $this->input->post('search_text'));
        }
        $search_key = $this->session->userdata('search_key_for_reported_users');


        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;

        $data["users"] = $this->report_user_model->get_all_reported_users_list($per_page, $offset, $search_key);

        if($data["users"] == false) {
            if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
                redirect(base_url('admin/users/reported'));
            }
        }
        $total_users = $this->report_user_model->count_all_reported_users($search_key);

        $url = base_url().'admin/users/reported';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['search_key'] = $search_key;
        $this->load->view('admin/users/reported', $data);
    }    

    public function editProfile() {
        $data = array();
        $member_id_enc = $this->input->get('user_hash');

        $this->load->model(['user_model','sport_model','language_model', 'interest_model','contact_request_model', 'static_data_model','vip_package_model', 'credit_package_model','diamond_package_model']);

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
            $redirect_url = base_url('admin/dashboard');
            if($this->input->server('HTTP_REFERER')) {
                $redirect_url = $this->input->server('HTTP_REFERER');
            }
            $this->session->set_userdata('message', $this->lang->line('no_profile_found'));
            redirect($redirect_url);
        }                
        $data['user_sports'] = $this->sport_model->get_user_sports_list($member_id);
        $data['user_spoken_languages'] = $this->language_model->get_user_spoken_language_list($member_id);
        $data['user_interests'] = $this->interest_model->get_user_interest_list($member_id);
        $data['user_contact_requests'] = $this->contact_request_model->get_user_contact_request_list($member_id);
        $data["user_photos"] = $this->user_model->get_user_all_photos($member_id);
        //$data['figure_list'] = $this->static_data_model->get_figure_list();
        //$data['job_list'] = $this->static_data_model->get_job_list();
        //$data['ethnicity_list'] = $this->static_data_model->get_ethnicity_list();
        //$data['eye_color_list'] = $this->static_data_model->get_eye_color_list();
        //$data['hair_color_list'] = $this->static_data_model->get_hair_color_list();

        $data["vip_purchase"] = $this->vip_package_model->get_buy_vip_package_list_for_user($member_id, 25, 0);
        $data["credit_purchase"] = $this->credit_package_model->get_buy_credit_package_list_for_user($member_id, 25, 0);
        $data["diamond_purchase"] = $this->diamond_package_model->get_buy_diamond_package_list_for_user($member_id, 25, 0);

        $this->load->view('admin/users/edit', $data);
    }

    public function blockUser() {

        $data = array();

        $this->load->model(['user_model','email_model','photo_model']);

        $member_id_enc = $this->input->get('user_hash');
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $status_arr = array('user_status' => 'blocked');
        $success_flg = $this->user_model->update_user($member_id, $status_arr);

        if($success_flg) {
            $user_info = $this->user_model->get_user_information($member_id);
            if($user_info['user_country'] == 'United Kingdom'){
                $this->lang->load('user_lang', 'english');
            }
            else{
                $this->lang->load('user_lang', $this->session->userdata('site_language'));
            }
            $to_email = $user_info['user_email'];
            $data['user_profile_pic'] = base_url("images/avatar/".$user_info['user_gender'].".png");
            $profile_pic = $this->photo_model->get_active_user_profile_pic($member_id);
            if($profile_pic) {
                $data['user_profile_pic'] = base_url($profile_pic['photo_thumb_url']);
            }
            $subject = $this->lang->line('profile_blocked');
            $data['user_name'] = $user_info['user_access_name'];
            $data['email_template'] = 'email/block_user_account';
            $email_message = $this->load->view('templates/email/main', $data, true);
            // $response = $this->email_model->sendEMail($to_email, $subject, $email_message);
            $this->load->library('email');
            $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
            $this->email->set_mailtype("html");
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($email_message);
            $this->email->send();
            $this->session->set_flashdata('message', $this->lang->line('user_profile_has_been_blocked_successfully'));            
        } else {
            $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
        }
        redirect(base_url('admin/users'));
    }


    public function activateUser() {
        $data = array();

        $this->load->model(['user_model', 'email_model', 'photo_model']);
    

        $member_id_enc = $this->input->get('user_hash');
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $user_info = $this->user_model->get_user_information($member_id);
        if($user_info['user_country'] == 'United Kingdom'){
            $this->lang->load('user_lang', 'english');
        }
        else{
            $this->lang->load('user_lang', $this->session->userdata('site_language'));
        }
        $status_arr = array('user_status' => 'active');
        // $this->user_model->add_admin_active_column_to_users_table();
        $success_flg = $this->user_model->update_user_activate_user($member_id, $status_arr);

        if($success_flg) {
            // Send Email to user for account activated
            $to_email = $user_info['user_email'];
            $subject = $this->lang->line('account_activated');            
            $data['user_name'] = $user_info['user_access_name'];

            $data['user_profile_pic'] = base_url("images/avatar/".$user_info['user_gender'].".png");
            $profile_pic = $this->photo_model->get_active_user_profile_pic($member_id);
            if($profile_pic) {
                $data['user_profile_pic'] = base_url($profile_pic['photo_thumb_url']);
            }
            $data['email_template'] = 'email/activate_user_account';
            $email_message = $this->load->view('templates/email/main', $data, true);
            // @$this->email_model->sendEMail($to_email, $subject, $email_message);
            $this->load->library('email');
            $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
            $this->email->set_mailtype("html");
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($email_message);
            $this->email->send();
            $this->session->set_flashdata('message', $this->lang->line('user_profile_has_been_activated_successfully'));            
        } else {
            $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
        }
        redirect(base_url('admin/users'));
    }

    public function deleteUser() {
        $data = array();

        $this->load->model(['user_model','sport_model','language_model', 'question_model','visitor_model', 'photo_model', 'kiss_model', 'interest_model', 'favorite_model','document_model', 'dislike_model', 'contact_request_model', 'chat_model', 'saved_search_model', 'unlock_request_model', 'credit_package_model', 'diamond_package_model', 'user_content_model', 'report_user_model']);
    
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $member_id_enc = $this->input->get('user_hash');
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $this->db->trans_begin();
        // $this->sport_model->delete_all_user_sports($member_id);
        // $this->language_model->delete_all_user_languages($member_id);
        // $this->question_model->delete_all_user_questions($member_id);
        // $this->visitor_model->delete_all_user_profile_visitors($member_id);
        // $this->photo_model->delete_all_user_photos($member_id);
        // $this->kiss_model->delete_all_user_kisses($member_id);
        // $this->interest_model->delete_all_user_interests($member_id);
        // $this->favorite_model->delete_all_user_favorites($member_id);
        // $this->document_model->delete_all_user_documents($member_id);
        // $this->dislike_model->delete_all_user_dislikes($member_id);
        // $this->contact_request_model->delete_all_user_contact_request($member_id);
        // $this->chat_model->delete_all_user_chat_messages($member_id);
        // $this->saved_search_model->delete_user_saved_search($member_id);
        // $this->unlock_request_model->delete_all_user_unlock_requests($member_id);
        // $this->credit_package_model->delete_user_credits_used($member_id);
        // $this->diamond_package_model->delete_user_buy_diamonds($member_id);
        // $this->diamond_package_model->delete_user_diamonds_used($member_id);
        // $this->user_content_model->delete_all_user_content($member_id);
        // $this->report_user_model->delete_user_reported($member_id);

        //$this->user_model->delete_user_info($member_id);
        $this->user_model->delete_user($member_id);
        // if (file_exists("./uploads/documents/" . $member_id . "/")) {
        //     @rmdir("./uploads/documents/" . $member_id . "/");
        // }
        // if (file_exists("./uploads/photos/" . $member_id . "/")) {
        //     @rmdir("./uploads/photos/" . $member_id . "/");
        // }

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
        } else {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', $this->lang->line('user_profile_has_been_deleted_successfully'));
        }
        redirect(base_url('admin/users'));
    }

    public function updateUserRank() {      

        $this->load->model(['user_model', 'photo_model']);

        $users = $this->user_model->get_all_users();

        if(!empty($users)) {
            foreach ($users as $urow) {

                $isProfilePicture = false;
                $isPictureApproved = false;

                if(empty($urow['user_active_photo_thumb'])) {
                    $isPictureApproved = false;
                    $isProfilePicture  = $this->photo_model->is_pending_profile_picture_for_user($urow['user_id']);
                } else {
                    $isProfilePicture = true;
                    $isPictureApproved = true;
                }

                $user_data = array(
                    'user_rank' => calculate_user_profile_rank($urow['user_is_vip'], $urow['user_verified'], $isProfilePicture, $isPictureApproved)
                );
                $this->user_model->update_user($urow['user_id'], $user_data);
            }
        }

        $response = array(
            'status' => true
        );
        echo json_encode($response);

    }


}
