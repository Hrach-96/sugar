<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }
	
    public function index() {   
        if($this->input->get('type') == 'sent') {
            $question_type = 'sent';
        } else {
            $question_type = 'received';
        }

        $data = array();
        $data['question_type'] = $question_type;

        $this->load->model(['question_model']);

        $user_id = $this->session->userdata('user_id');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        if($question_type == 'received') {
            $this->question_model->update_unseen_as_seen_to_user($user_id);
            $data["users"] = $this->question_model->get_active_received_question_list($user_id, 100, 0);
        } else {
            $data["users"] = $this->question_model->get_active_sent_question_list($user_id, 100, 0);
        }
        //print_r($data["users"]);die;
        $this->load->view('user/questions/view', $data);
    }

    // we service for sending question to member
    public function sendQuestion() {
        $this->load->model(['question_model' ,'user_model', 'email_model', 'photo_model']);

        $member_id_enc = $this->input->post('member_data');
        $question_id = $this->input->post('question_id');
        $user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        
        $alreadyAsked = $this->question_model->is_already_question_asked($question_id, $user_id, $member_id);

        if($alreadyAsked == true) {
            $response['status'] = false;
            $response['errorCode'] = 0;
            $response['message'] = $this->lang->line('question_already_sent');
        } else {
            $insertData = array(
                'user_question_ref_id' => $question_id,
                'user_question_sender_id' => $user_id,
                'user_question_receiver_id' => $member_id,
                'user_question_answered' => 'no',
                'user_question_status' => 'active',
                'user_question_added_date' => date('Y-m-d H:i:s'),
                'user_question_flag' => 'web'
            );
            $success = $this->question_model->insert_user_question($insertData);

            if($success > 0) {
                // Send Email to Question receiver
                $member_info = $this->user_model->get_active_user_information($member_id);
                if($member_info['user_country'] == 'United Kingdom'){
                    $this->lang->load('user_lang', 'english');
                }
                else{
                    $this->lang->load('user_lang', 'german');
                }
                $to_email = $member_info['user_email'];
                $subject = $this->session->userdata('user_username') . " " . $this->lang->line('has_asked_you_a_question');
                $data['message_sender_name'] = $this->session->userdata('user_username');
                $data['message_receiver_name'] = $member_info['user_access_name'];

                $sender_info = $this->user_model->get_active_user_information($user_id);
                $data['message_sender_pic'] = base_url("images/avatar/".$sender_info['user_gender'].".png");
                $profile_pic = $this->photo_model->get_active_user_profile_pic($user_id);
                if($profile_pic) {
                    $data['message_sender_pic'] = base_url($profile_pic['photo_thumb_url']);
                }
                $data['email_template'] = 'email/send_question';
                $email_message = $this->load->view('templates/email/main', $data, true);
                // @$this->email_model->sendEMail($to_email, $subject, $email_message);
                $this->load->library('email');
                $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
                $this->email->set_mailtype("html");
                $this->email->to($to_email);
                $this->email->subject($subject);
                $this->email->message($email_message);
                $this->email->send();

                $response['status'] = true;
                $this->lang->load('user_lang', $this->session->userdata('site_language'));
                $response['message'] = $this->lang->line('question_sent');
            } else {
                $response['status'] = false;
                $response['errorCode'] = 1;
                $response['message'] = $this->lang->line('internal_server_error');
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // we service for answer user question
    public function answerQuestion() {
        $this->load->model(['question_model','user_model','photo_model']);

        $question_id = $this->input->post('question_id');
        $user_id = $this->session->userdata('user_id');
        $question_answer = $this->input->post('question_answer');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        
        $alreadyDeleted = $this->question_model->is_already_question_deleted($question_id, $user_id);

        if($alreadyDeleted == true) {
            $response['status'] = false;
            $response['errorCode'] = 0;
            $response['message'] = $this->lang->line('already_deleted');
        } else {
            $questData = array(
                'user_question_answered' => 'yes',
                'user_question_answer_text' => $question_answer,
                'user_question_answer_date' => date('Y-m-d H:i:s'),
            );
            $success = $this->question_model->update_user_question($question_id, $questData);

            $question_info = $this->question_model->get_active_question_by_id($question_id);
            $question_sender_info = $this->user_model->get_active_user_information($question_info['user_question_sender_id']);
            $question_receiver_info = $this->user_model->get_active_user_information($user_id);
            $lang = 'german';
            if($question_sender_info['user_country'] == 'United Kingdom'){
                $lang = 'english';
            }
            $this->lang->load('user_lang', $lang);
            $to_email = $question_sender_info['user_email'];
            $subject =  $question_receiver_info['user_access_name'] . " " . $this->lang->line('was_answered_to_your_question');
            $data['title_of_content'] = $question_receiver_info['user_access_name'] . " " . $this->lang->line('was_answered_to_your_question');;
            $data['question_sender_name'] = $question_sender_info['user_access_name'];
            $data['question_receiver_name'] = $question_receiver_info['user_access_name'];
            $data['request_receiveruser_profile_pic'] = base_url("images/avatar/".$question_receiver_info['user_gender'].".png");
            $request_receiver_profile_pic = $this->photo_model->get_active_user_profile_pic($user_id);
            if($request_receiver_profile_pic) {
                $data['request_receiveruser_profile_pic'] = base_url($request_receiver_profile_pic['photo_thumb_url']);
            }

            $data['email_template'] = 'email/question_answered';
            $email_message = $this->load->view('templates/email/main', $data, true);
            $this->load->library('email');
            $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
            $this->email->set_mailtype("html");
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($email_message);
            $this->email->send();
            $this->lang->load('user_lang', $this->session->userdata('site_language'));

            if($success > 0) {
                $response['status'] = true;
                $response['message'] = $this->lang->line('question_answered');
            } else {
                $response['status'] = false;
                $response['errorCode'] = 1;
                $response['message'] = $this->lang->line('internal_server_error');
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // we service for deletetion of asked or sent question
    public function deleteQuestion() {
        $this->load->model(['question_model']);

        $question_id = $this->input->post('question_id');
        $user_id = $this->session->userdata('user_id');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $alreadyDeleted = $this->question_model->is_already_question_deleted($question_id, $user_id);

        if($alreadyDeleted == true) {
            $response['status'] = false;
            $response['errorCode'] = 0;
            $response['message'] = $this->lang->line('already_deleted');
        } else {
            $success = $this->question_model->delete_user_question($question_id, $user_id);

            if($success > 0) {
                $response['status'] = true;
                $response['message'] = $this->lang->line('question_deleted');
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
