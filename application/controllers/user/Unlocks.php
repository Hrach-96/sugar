<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unlocks extends CI_Controller {

    function __construct() {
        parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }
    
    public function index() 
    {   
        $unlock_type = 'open';
        if($this->input->get('type') == 'open' || $this->input->get('type') == 'active' || $this->input->get('type') == 'rejected') {
            $unlock_type = $this->input->get('type');
        }

        $filter_type =  FALSE;
        if($this->input->get('filter') == 'chat_request' || $this->input->get('filter') == 'images_request' )
        {
            $filter_type = $this->input->get('filter');
        }

        $data = array();
        $data['unlock_type'] = $unlock_type;

        $this->load->model(['unlock_request_model']);
        $user_id = $this->session->userdata('user_id');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        if($unlock_type = 'open') {
            $this->unlock_request_model->update_unseen_as_seen_to_user($user_id);
        }
        $data["requests"] = $this->unlock_request_model->get_users_unlocked_request_list($user_id, $unlock_type, $filter_type, $per_page, $offset);
        if($data["requests"] == false) {
            if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
                redirect(base_url('user/unlocks'));
            }
        }
        $total_requests = $this->unlock_request_model->count_users_unlocked_request_list($user_id, $unlock_type, $filter_type);
        
        $url = base_url().'unlocks';
        $url_params = array();
        if($unlock_type != '') {
            array_push($url_params, 'type='.$unlock_type);
        }
        if($filter_type != '') {
            array_push($url_params, 'filter='.$filter_type);
        }
        if(!empty($url_params)) {
            $url = $url.'?'.implode('&', $url_params);
        }

        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_requests, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $this->load->view('user/unlocks/view', $data);
    }

    public function sendImageRequest() {
        $this->load->model(['unlock_request_model', 'photo_model', 'user_model', 'email_model']);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $member_id_enc = $this->input->post('user_hash');
        $picture_id = $this->input->post('picture_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);
        $user_id = $this->session->userdata('user_id');

        if($member_id != '' && $picture_id != '') {

            $photo_info = $this->photo_model->get_photo_info($picture_id);            
            if($photo_info) {
                if($photo_info['photo_type'] == 'private') {
                    $isAlreadySent = $this->unlock_request_model->is_already_request_sent($user_id, $member_id, 'images_request', $picture_id);
                    if(!$isAlreadySent) {
                        $uncomplete_request_count = $this->unlock_request_model->uncompleted_image_request_counts($user_id, $member_id);
                        if($uncomplete_request_count > 1) {
                            $response['status'] = false;
                            $response['errorCode'] = 2;
                            $response['message'] = $this->lang->line('illegal_request');
                        } else {
                            $unlock_data_array = array(
                                'unlock_request_sender_id' => $user_id,
                                'unlock_request_receiver_id' => $member_id,
                                'unlock_request_type' => 'images_request',
                                'unlock_user_image_id' => $picture_id,
                                'unlock_request_date' => gmdate('Y-m-d H:i:s'),
                                'unlock_request_status' => 'open',
                                'unlock_request_flag' => 'web'
                            );

                            $success = $this->unlock_request_model->insert_user_unlock_request($unlock_data_array);

                            if($success) {
                                // Send Email to Unlock request receiver
                                $member_info = $this->user_model->get_active_user_information($member_id);
                                $to_email = $member_info['user_email'];
                                $subject = $this->lang->line('unlock_request_received');
                                $data['message_sender_name'] = $this->session->userdata('user_username');
                                $data['message_receiver_name'] = $member_info['user_access_name'];
                                $data['message_sender_pic'] = base_url($this->session->userdata('user_avatar'));
                                $data['email_template'] = 'email/send_unlock_request';
                                $email_message = $this->load->view('templates/email/main', $data, true);
                                @$this->email_model->sendEMail($to_email, $subject, $email_message);

                                $response['status'] = true;
                                $response['errorCode'] = 0;
                                $response['message'] = $this->lang->line('unlock_request_has_been_sent_successfully');
                            } else {
                                $response['status'] = false;
                                $response['errorCode'] = 1;
                                $response['message'] = $this->lang->line('internal_server_error');
                            }
                        }
                    } else {
                        $response['status'] = false;
                        $response['errorCode'] = 3;
                        $response['message'] = $this->lang->line('already_unlock_request_sent');
                    } 
                } else {
                    $response['status'] = false;
                    $response['errorCode'] = 4;
                    $response['message'] = $this->lang->line('illegal_request');
                }
            } else {
                $response['status'] = false;
                $response['errorCode'] = 4;
                $response['message'] = $this->lang->line('illegal_request');
            }         
        } else {
            $response['status'] = false;
            $response['errorCode'] = 5;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function sendChatUnlockRequest() {
        $this->load->model(['unlock_request_model', 'user_model', 'email_model']);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $member_id_enc = $this->input->post('user_hash');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);
        $user_id = $this->session->userdata('user_id');

        if($member_id != '') {
            $valid_upto_date = date('Y-m-d H:i:s', strtotime('-'.CHAT_ACTIVATION_VALID_UPTO_MONTHS.' month'));
            $isAlreadyUnlocked = $this->unlock_request_model->is_already_chat_unlocked($user_id, $member_id, $valid_upto_date);

            if($isAlreadyUnlocked) {
                $response['status'] = false;
                $response['message'] = $this->lang->line('already_unlocked');
            } else {
                $isAlreadySent = $this->unlock_request_model->is_already_chat_request_sent($user_id, $member_id);

                if(!$isAlreadySent) {
                    $unlock_data_array = array(
                        'unlock_request_sender_id' => $user_id,
                        'unlock_request_receiver_id' => $member_id,
                        'unlock_request_type' => 'chat_request',
                        'unlock_user_image_id' => NULL,
                        'unlock_request_date' => gmdate('Y-m-d H:i:s'),
                        'unlock_request_status' => 'open',
                        'unlock_request_activated_date' => NULL,
                        'unlock_request_flag' => 'web'
                    );

                    $success = $this->unlock_request_model->insert_user_unlock_request($unlock_data_array);

                    if($success) {
                        // Send Email to Unlock request receiver
                        $member_info = $this->user_model->get_active_user_information($member_id);
                        $to_email = $member_info['user_email'];
                        $subject = $this->lang->line('you_have_a_chatrequest_from') . " " . $this->session->userdata('user_username') . " " . $this->lang->line('erhalten_only_deutch') ;
                        $data['message_sender_name'] = $this->session->userdata('user_username');
                        $data['message_receiver_name'] = $member_info['user_access_name'];
                        $data['message_sender_pic'] = base_url($this->session->userdata('user_avatar'));
                        $data['email_template'] = 'email/send_unlock_request_profile';
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
                        $response['message'] = $this->lang->line('unlock_request_has_been_sent_successfully');                    
                    } else {
                        $response['status'] = false;
                        $response['message'] = $this->lang->line('internal_server_error');
                    }
                } else {
                    $response['status'] = false;
                    $response['message'] = $this->lang->line('already_unlock_request_sent');
                }
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function sendChatUnlockRequestInChat() {
        $this->load->model(['unlock_request_model', 'user_model', 'email_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $member_id_enc =  urldecode($this->input->post('user_hash'));

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);
        $user_id = $this->session->userdata('user_id');

        if($member_id != '') {
            $valid_upto_date = date('Y-m-d H:i:s', strtotime('-'.CHAT_ACTIVATION_VALID_UPTO_MONTHS.' month'));
            $isAlreadyUnlocked = $this->unlock_request_model->is_already_chat_unlocked($user_id, $member_id, $valid_upto_date);

            if($isAlreadyUnlocked) {
                $response['status'] = false;
                $response['message'] = $this->lang->line('already_unlocked');
            } else {
                $isAlreadySent = $this->unlock_request_model->is_already_chat_request_sent($user_id, $member_id);

                if(!$isAlreadySent) {
                    $unlock_data_array = array(
                        'unlock_request_sender_id' => $user_id,
                        'unlock_request_receiver_id' => $member_id,
                        'unlock_request_type' => 'chat_request',
                        'unlock_user_image_id' => NULL,
                        'unlock_request_date' => gmdate('Y-m-d H:i:s'),
                        'unlock_request_status' => 'open',
                        'unlock_request_activated_date' => NULL,
                        'unlock_request_flag' => 'web'
                    );

                    $success = $this->unlock_request_model->insert_user_unlock_request($unlock_data_array);

                    if($success) {
                        // Send Email to Unlock request receiver
                        $member_info = $this->user_model->get_active_user_information($member_id);
                        if($member_info['user_country'] == 'United Kingdom'){
                            $this->lang->load('user_lang', 'english');
                        }
                        else{
                            $this->lang->load('user_lang', 'german');
                        }
                        $to_email = $member_info['user_email'];
                        $subject = $this->lang->line('you_have_a_chatrequest_from') . " " . $this->session->userdata('user_username') . " " . $this->lang->line('erhalten_only_deutch') ;
                        $data['message_sender_name'] = $this->session->userdata('user_username');
                        $data['message_receiver_name'] = $member_info['user_access_name'];
                        $data['message_sender_pic'] = base_url($this->session->userdata('user_avatar'));
                        $data['email_template'] = 'email/send_unlock_request_profile';
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
                        $response['message'] = $this->lang->line('unlock_request_has_been_sent_successfully');                    
                    } else {
                        $response['status'] = false;
                        $response['message'] = $this->lang->line('internal_server_error');
                    }
                } else {
                    $response['status'] = false;
                    $response['message'] = $this->lang->line('already_unlock_request_sent');
                }
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function disableImageUnlockRequest() {
        $this->load->model(['unlock_request_model']);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $unlock_id = $this->input->post('unlock_id');
        $user_id = $this->session->userdata('user_id');

        if($unlock_id != '') {
            $request_info = $this->unlock_request_model->get_user_unlocked_request_info($unlock_id);

            if($request_info) {
                if($request_info['unlock_request_receiver_id'] == $user_id && $request_info['unlock_request_type'] == 'images_request') {

                    $success = $this->unlock_request_model->delete_user_request_by_unlock_id($unlock_id);

                    if($success) {
                        $response['status'] = true;
                        $response['message'] = $this->lang->line('success');
                    } else {
                        $response['status'] = false;
                        $response['message'] = $this->lang->line('internal_server_error');
                    }
                } else {
                    $response['status'] = false;
                    $response['message'] = $this->lang->line('internal_server_error');
                }
            } else {
                $response['status'] = false;
                $response['message'] = $this->lang->line('unauthorized_access');
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function rejectUnlockRequest() {
        $this->load->model(['unlock_request_model','user_model','photo_model']);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $unlock_id = $this->input->post('unlock_id');
        $user_id = $this->session->userdata('user_id');

        if($unlock_id != '') {
            $request_info = $this->unlock_request_model->get_user_unlocked_request_info($unlock_id);
            $request_sender_info = $this->user_model->get_active_user_information($request_info['unlock_request_sender_id']);
            $request_receiver_info = $this->user_model->get_active_user_information($user_id);
            if($request_info) {
                if($request_info['unlock_request_receiver_id'] == $user_id && $request_info['unlock_request_status'] == 'open') {
                    $update_unlock_data_array = array(
                        'unlock_request_status' => 'rejected',
                        'unlock_request_activated_date' => gmdate('Y-m-d H:i:s')
                    );

                    $success = $this->unlock_request_model->update_unlock_request($unlock_id, $update_unlock_data_array);

                    $lang = 'german';
                    if($request_sender_info['user_country'] == 'United Kingdom'){
                        $lang = 'english';
                    }
                    $this->lang->load('user_lang', $lang);
                    $to_email = $request_sender_info['user_email'];
                    $subject = $this->lang->line('your_chat_request_to') . " " . $request_receiver_info['user_access_name'] . " " . $this->lang->line('was_declined') ;
                    $data['request_sender_name'] = $request_sender_info['user_access_name'];
                    $data['request_receiver_name'] = $request_receiver_info['user_access_name'];
                    $request_receiver_profile_pic = $this->photo_model->get_user_profile_pic($user_id);
                    $data['request_receiveruser_profile_pic'] = base_url("images/avatar/".$request_receiver_info['user_gender'].".png");
                    if($request_receiver_profile_pic) {
                        $data['request_receiveruser_profile_pic'] = base_url($request_receiver_profile_pic['photo_thumb_url']);
                    }
                    $data['email_template'] = 'email/chat_request_declined';
                    $email_message = $this->load->view('templates/email/main', $data, true);
                    $this->load->library('email');
                    $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
                    $this->email->set_mailtype("html");
                    $this->email->to($to_email);
                    $this->email->subject($subject);
                    $this->email->message($email_message);
                    $this->email->send();
                    $this->lang->load('user_lang', $this->session->userdata('site_language'));

                    if($success) {
                        $response['status'] = true;
                        $response['message'] = $this->lang->line('success');
                    } else {
                        $response['status'] = false;
                        $response['message'] = $this->lang->line('internal_server_error');
                    }
                } else {
                    $response['status'] = false;
                    $response['message'] = $this->lang->line('internal_server_error');
                }
            } else {
                $response['status'] = false;
                $response['message'] = $this->lang->line('unauthorized_access');
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function unlockRequestForChat() {
        $this->load->model(['unlock_request_model', 'credit_package_model','photo_model', 'user_model', 'chat_model']);
        $user_id = $this->session->userdata('user_id');
        $unlock_id = $this->input->post('unlock_request_id');
        $unlocking_cost = $this->input->post('unlocking_cost');
        $available_credits = $this->session->userdata('user_credits');        
        if($unlocking_cost <= $available_credits) {            

            $request_info = $this->unlock_request_model->get_user_unlocked_request_info($unlock_id);
            $request_sender_info = $this->user_model->get_active_user_information($request_info['unlock_request_sender_id']);
            $request_receiver_info = $this->user_model->get_active_user_information($user_id);
            if($request_info) {
                if($request_info['unlock_request_receiver_id'] == $user_id) {
                    $this->db->trans_begin();
                    //set unlock request status as open
                    $update_unlock_data_array = array(
                        'unlock_request_status' => 'active',
                        'unlock_request_activated_date' => gmdate('Y-m-d H:i:s')
                    );
                    $this->unlock_request_model->update_unlock_request($unlock_id, $update_unlock_data_array);

                    // Insert Welcome message from
                    $message_array = array(
                        'message_sender_id' => $user_id,
                        'message_receiver_id' => $request_info['unlock_request_sender_id'],
                        'message_text' => ' ',
                        'message_status' => 'unseen',
                        'message_flag' => 'web'
                    );
                    $this->chat_model->save_user_chat_message($message_array);

                    // add used credits
                    $used_credits = array(
                        'credits_used_by' => $user_id,
                        'total_cedits_used' => $unlocking_cost,
                        'user_was_vip' => $this->session->userdata('user_is_vip'),
                        'credits_used_date' => gmdate('Y-m-d H:i:s'),
                        'credits_used_reason' => 'by_member_unlock_request_id',
                        'unlock_request_id_ref' => $unlock_id,
                        'credits_used_flag' => 'web'
                    );
                    $this->credit_package_model->insert_user_credits_used($used_credits);

                    // update user available credits 
                    $available_credits = $available_credits - $unlocking_cost;
                    $this->user_model->update_user_credits($user_id, $available_credits);

                    $lang = 'german';
                    if($request_sender_info['user_country'] == 'United Kingdom'){
                        $lang = 'english';
                    }
                    $this->lang->load('user_lang', $lang);
                    $to_email = $request_sender_info['user_email'];
                    $subject = $this->lang->line('your_chat_request_to') . " " . $request_receiver_info['user_access_name'] . " " . $this->lang->line('was_accepted') ;
                    $data['request_sender_name'] = $request_sender_info['user_access_name'];
                    $data['request_receiver_name'] = $request_receiver_info['user_access_name'];
                    $request_receiver_profile_pic = $this->photo_model->get_user_profile_pic($user_id);
                    $data['request_receiveruser_profile_pic'] = base_url("images/avatar/".$request_receiver_info['user_gender'].".png");
                    if($request_receiver_profile_pic) {
                        $data['request_receiveruser_profile_pic'] = base_url($request_receiver_profile_pic['photo_thumb_url']);
                    }
                    $data['email_template'] = 'email/chat_request_accepted';
                    $email_message = $this->load->view('templates/email/main', $data, true);
                    $this->load->library('email');
                    $this->email->from('support@sugarbabe-deluxe.eu', 'Sugarbabe-Deluxe');
                    $this->email->set_mailtype("html");
                    $this->email->to($to_email);
                    $this->email->subject($subject);
                    $this->email->message($email_message);
                    $this->email->send();
                    $this->lang->load('user_lang', $this->session->userdata('site_language'));

                    if($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_userdata('message', $this->lang->line('internal_server_error'));
                        redirect(base_url('user/unlocks'));
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_userdata('user_credits', $available_credits);
                        $this->session->set_userdata('message', 'unlock_successfull');
                        redirect(base_url('user/unlocks'));
                    }
                } else {
                    $this->session->set_userdata('message', 'unauthorized_access');
                    redirect(base_url('user/unlocks'));
                }
            } else {
                $this->session->set_userdata('message', 'unauthorized_access');
                redirect(base_url('user/unlocks'));
            }
        } else {
            $this->session->set_userdata('message', 'your_credits_are_less_than_unlocking_cost_please_buy_more_credits');
            redirect(base_url('buy/credit'));
        }
    }

    public function unlockRequestForImage() {
        $this->load->model(['unlock_request_model', 'credit_package_model', 'user_model']);

        $user_id = $this->session->userdata('user_id');
        $unlock_id = $this->input->post('unlock_request_id');

        $request_info = $this->unlock_request_model->get_user_unlocked_request_info($unlock_id);

        if($request_info) {           
            if($request_info['unlock_request_receiver_id'] == $user_id) {
                //set unlock request status as open
                $update_unlock_data_array = array(
                    'unlock_request_status' => 'active',
                    'unlock_request_activated_date' => gmdate('Y-m-d H:i:s')
                );
                $success = $this->unlock_request_model->update_unlock_request($unlock_id, $update_unlock_data_array);

                if($success) {
                    $this->session->set_userdata('message', 'unlock_successfull');
                } else {
                    $this->session->set_userdata('message', 'internal_server_error');
                }
            } else {
                $this->session->set_userdata('message', 'unauthorized_access');
            }
        } else {
            $this->session->set_userdata('message', 'unauthorized_access');            
        }
        redirect(base_url('user/unlocks'));
    }

    public function unlockUserRequest() {
        $this->load->model(['unlock_request_model', 'credit_package_model', 'user_model', 'photo_model', 'chat_model']);        
        $unlock_member_id_enc = $this->input->post('unlock_member_id');

        if($this->input->server('HTTP_REFERER')) {
            $this->session->set_userdata('back_url', $this->input->server('HTTP_REFERER'));
        } else {
            if($this->session->userdata('back_url') == '') {
                $this->session->set_userdata('back_url', base_url('unlocks'));
            }
        }

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));

        $member_id = $this->encryption->decrypt($unlock_member_id_enc);
        $user_id = $this->session->userdata('user_id');
        $unlocking_cost = $this->input->post('unlocking_cost');
        $available_credits = $this->session->userdata('user_credits');

        if($member_id == '' || $unlocking_cost == '') {
            $this->session->set_userdata('message', 'unauthorized_access');
            redirect($this->session->userdata('back_url'));
        } else {
            $valid_upto_date = date('Y-m-d H:i:s', strtotime('-'.CHAT_ACTIVATION_VALID_UPTO_MONTHS.' month'));
            $isAlreadyUnlocked = $this->unlock_request_model->is_already_chat_unlocked($user_id, $member_id, $valid_upto_date);

            if($isAlreadyUnlocked) {
                $this->session->set_userdata('message', 'already_unlocked');
                redirect($this->session->userdata('back_url'));
            } else {
                if($unlocking_cost <= $available_credits) {
                    $this->db->trans_begin();
                    //set unlock request status as open
                    $unlock_data_array = array(
                        'unlock_request_sender_id' => $member_id,
                        'unlock_request_receiver_id' => $user_id,
                        'unlock_request_type' => 'chat_request',
                        'unlock_user_image_id' => NULL,
                        'unlock_request_date' => gmdate('Y-m-d H:i:s'),
                        'unlock_request_status' => 'active',
                        'unlock_request_activated_date' => gmdate('Y-m-d H:i:s'),
                        'unlock_request_flag' => 'web'
                    );
                    $unlock_id = $this->unlock_request_model->insert_user_unlock_request($unlock_data_array);

                    // Insert Welcome message from
                    $message_array = array(
                        'message_sender_id' => $user_id,
                        'message_receiver_id' => $member_id,
                        'message_text' => ' ',
                        'message_status' => 'unseen',
                        'message_flag' => 'web'
                    );
                    $this->chat_model->save_user_chat_message($message_array);

                    // add used credits
                    $used_credits = array(
                        'credits_used_by' => $user_id,
                        'total_cedits_used' => $unlocking_cost,
                        'user_was_vip' => $this->session->userdata('user_is_vip'),
                        'credits_used_date' => gmdate('Y-m-d H:i:s'),
                        'credits_used_reason' => 'by_user_unlock_request_id',
                        'unlock_request_id_ref' => $unlock_id,
                        'credits_used_flag' => 'web'
                    );
                    $this->credit_package_model->insert_user_credits_used($used_credits);

                    // update user available credits 
                    $available_credits = $available_credits - $unlocking_cost;
                    $this->user_model->update_user_credits($user_id, $available_credits);

                    if($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $this->session->set_userdata('message', 'internal_server_error');
                    } else {
                        $this->db->trans_commit();
                        $this->session->set_userdata('user_credits', $available_credits);
                        $this->session->set_userdata('message', 'unlock_successfull');
                    }
                    redirect($this->session->userdata('back_url'));
                } else {
                    $this->session->set_userdata('message', 'your_credits_are_less_than_unlocking_cost_please_buy_more_credits');
                    redirect(base_url('buy/credit'));
                }
            }
        }
    }

    public function isValidImageUnlockRequest() {
        $this->load->model(['unlock_request_model', 'photo_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id_enc = $this->input->post('user_hash');

        $member_id = $this->encryption->decrypt($member_id_enc);
        $user_id = $this->session->userdata('user_id');
        $unlock_picture_id = $this->input->post('unlock_picture_id');

        $photo_info = $this->photo_model->get_photo_info($unlock_picture_id);            
        if($photo_info) {            
            if($photo_info['photo_type'] == 'private') {
                $isAlreadyUnlocked = $this->unlock_request_model->is_already_request_unlocked($member_id, $user_id, 'images_request', $unlock_picture_id);

                if($isAlreadyUnlocked) {
                    $response['status'] = false;
                    $response['message'] = $this->lang->line('already_unlocked');
                } else {
                    $response['status'] = true;
                    $response['message'] = $this->lang->line('success');
                }
            } else if($photo_info['photo_type'] == 'vip' && $this->session->userdata('user_is_vip') == 'no') {
                $response['status'] = false;
                $response['message'] = 'Only VIP Member Can view this Picture';
            } else {
                $response['status'] = false;
                $response['message'] = $this->lang->line('already_unlocked');
            }
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('illegal_request');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function unlockChatRequest() {
        $this->load->model(['unlock_request_model', 'credit_package_model', 'user_model', 'chat_model']);        
        $unlock_member_id_enc = urldecode($this->input->post('unlock_member_id'));

        if($this->input->server('HTTP_REFERER')) {
            $this->session->set_userdata('back_url', $this->input->server('HTTP_REFERER'));
        } else {
            if($this->session->userdata('back_url') == '') {
                $this->session->set_userdata('back_url', base_url('unlocks'));
            }
        }

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));

        $member_id = $this->encryption->decrypt($unlock_member_id_enc);
        $user_id = $this->session->userdata('user_id');
        $unlocking_cost = $this->input->post('unlocking_cost');
        $available_credits = $this->session->userdata('user_credits');

        $valid_upto_date = date('Y-m-d H:i:s', strtotime('-'.CHAT_ACTIVATION_VALID_UPTO_MONTHS.' month'));
        $isAlreadyUnlocked = $this->unlock_request_model->is_already_chat_unlocked($user_id, $member_id, $valid_upto_date);

        if($isAlreadyUnlocked) {
            $this->session->set_userdata('message', 'already_unlocked');
            $this->session->set_userdata('active_user_chat', $member_id);
            redirect($this->session->userdata('back_url'));
        } else {
            if($unlocking_cost <= $available_credits) {
                $this->db->trans_begin();
                //set unlock request status as open
                $unlock_data_array = array(
                    'unlock_request_sender_id' => $member_id,
                    'unlock_request_receiver_id' => $user_id,
                    'unlock_request_type' => 'chat_request',
                    'unlock_user_image_id' => NULL,
                    'unlock_request_date' => gmdate('Y-m-d H:i:s'),
                    'unlock_request_status' => 'active',
                    'unlock_request_activated_date' => gmdate('Y-m-d H:i:s'),
                    'unlock_request_flag' => 'web'
                );
                $unlock_id = $this->unlock_request_model->insert_user_unlock_request($unlock_data_array);

                // Insert Welcome message from
                $message_array = array(
                    'message_sender_id' => $user_id,
                    'message_receiver_id' => $member_id,
                    'message_text' => ' ',
                    'message_status' => 'unseen',
                    'message_flag' => 'web'
                );
                $this->chat_model->save_user_chat_message($message_array);

                // add used credits
                $used_credits = array(
                    'credits_used_by' => $user_id,
                    'total_cedits_used' => $unlocking_cost,
                    'user_was_vip' => $this->session->userdata('user_is_vip'),
                    'credits_used_date' => gmdate('Y-m-d H:i:s'),
                    'credits_used_reason' => 'by_user_unlock_request_id',
                    'unlock_request_id_ref' => $unlock_id,
                    'credits_used_flag' => 'web'
                );
                $this->credit_package_model->insert_user_credits_used($used_credits);

                // update user available credits 
                $available_credits = $available_credits - $unlocking_cost;
                $this->user_model->update_user_credits($user_id, $available_credits);

                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $this->session->set_userdata('message', $this->lang->line('internal_server_error'));
                } else {                    
                    $this->db->trans_commit();
                    $this->session->set_userdata('active_user_chat', $member_id);
                    $this->session->set_userdata('user_credits', $available_credits);
                    $this->session->set_userdata('message', 'unlock_successfull');
                }
                redirect($this->session->userdata('back_url'));
            } else {
                $this->session->set_userdata('message', 'your_credits_are_less_than_unlocking_cost_please_buy_more_credits');
                redirect(base_url('buy/credit'));
            }
        }
    }

    public function isValidChatUnlockRequest() {
        $this->load->model(['unlock_request_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id_enc = urldecode($this->input->post('user_hash'));

        $member_id = $this->encryption->decrypt($member_id_enc);
        $user_id = $this->session->userdata('user_id');

        if($member_id == '' || $user_id == '') {
            $response['status'] = false;
            $response['message'] = $this->lang->line('unauthorized_access');
        } else {
            $valid_upto_date = date('Y-m-d H:i:s', strtotime('-'.CHAT_ACTIVATION_VALID_UPTO_MONTHS.' month'));
            $isAlreadyUnlocked = $this->unlock_request_model->is_already_chat_unlocked($user_id, $member_id, $valid_upto_date);

            if($isAlreadyUnlocked) {
                $response['status'] = false;
                $response['message'] = $this->lang->line('already_unlocked');
            } else {
                $response['status'] = true;
                $response['message'] = $this->lang->line('success');
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


}
