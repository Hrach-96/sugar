<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }
	
    public function index() {   
		$data = array();
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $this->load->view('user/chat/index', $data);
    }

    // Web service for listing already chatted Users
    public function getChattingUsers() {
        $this->load->model(['user_model', 'chat_model']);
        
        $user_id = $this->session->userdata('user_id');
        $user_interested_in = $this->session->userdata('user_interested_in');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $per_page = 10;
        $offset = ($per_page * $this->input->post('page_no'));
        $search_key = $this->input->post('search_key');
        $onlineUsers = $this->user_model->get_already_chatted_users_list($user_id, $user_interested_in, $search_key, $per_page, $offset);


        $tmp_array = array();
        $active_chatting_user = $this->session->userdata('active_user_chat');
        $present_active_user = false;

        if($onlineUsers) {
            foreach ($onlineUsers as $oUser) {
                $member_id = $oUser['user_id'];
                $oUser['user_hash'] = urlencode($oUser['user_hash']);
                unset($oUser['user_id']);
                if($oUser['user_active_photo_thumb'] == '') {
                    $oUser['user_active_photo_thumb'] = "images/avatar/".$oUser['user_gender'].".png";
                }

                $oUser['unseen_message_count'] = $this->chat_model->count_unseen_message_count($user_id, $member_id);
                // FOr last message and message time
                $oUser['last_message'] = $this->chat_model->get_last_message_text($user_id, $member_id);

                if($oUser['last_message'] != '') {
                    $con_date = convert_date_to_local($oUser['last_message']->message_sent_date, 'Y-m-d');
                    if($con_date != get_local_date('Y-m-d')) {
                        $oUser['last_message']->message_sent_time = convert_date_to_local($oUser['last_message']->message_sent_date, MESSAGE_DATE_FORMAT);
                    } else {
                        $today = date_create(get_local_date('Y-m-d H:i:s'));
                        $message_date = date_create(convert_date_to_local($oUser['last_message']->message_sent_date, 'Y-m-d H:i:s'));

                        $user_online_ago = date_diff($today, $message_date);
                        $user_message_sent_str = '';                      
                        if ($user_online_ago->h > 0) {
                            $user_message_sent_str = $user_online_ago->h.' '.strtolower($this->lang->line('hour'));
                        } else {
                            $user_message_sent_str = $user_online_ago->i.' '.strtolower($this->lang->line('mins'));
                        }
                        $oUser['last_message']->message_sent_time = $user_message_sent_str;
                    }   

                    if(trim($oUser['last_message']->message_text) == '') {
                         $oUser['last_message']->message_text = '&nbsp;';
                    } else {
                        // Parse smileys in last message text
                        $oUser['last_message']->message_text = parse_text_smileys($oUser['last_message']->message_text);
                    }
                } else {
                    $lmsg = new stdClass;
                    $lmsg->message_sent_time = '';
                    $lmsg->message_text = '&nbsp;';
                    $oUser['last_message'] = $lmsg;
                }

                if($active_chatting_user == $member_id) {
                    $oUser['active_chat'] = true;
                    $present_active_user = true;
                    array_unshift($tmp_array, $oUser);
                } else {
                    $oUser['active_chat'] = false;
                    $tmp_array[] = $oUser;
                }               
            }
        }

        if($this->session->userdata('active_user_chat') != null) {
            // load active chat user to top in list

            if($present_active_user == false) {

                $onlineActiveChatUser = $this->user_model->get_active_online_single_users_info($active_chatting_user);
                if($onlineActiveChatUser) {
                    if($onlineActiveChatUser['user_active_photo_thumb'] == '') {
                        $onlineActiveChatUser['user_active_photo_thumb'] = "images/avatar/".$onlineActiveChatUser['user_gender'].".png";
                    }
                    $onlineActiveChatUser['user_hash'] = urlencode($onlineActiveChatUser['user_hash']);
                    $onlineActiveChatUser['unseen_message_count'] = $this->chat_model->count_unseen_message_count($user_id, $active_chatting_user);
                    $onlineActiveChatUser['last_message'] = $this->chat_model->get_last_message_text($user_id, $active_chatting_user);
                    if($onlineActiveChatUser['last_message'] != '') {
                        $con_date = convert_date_to_local($onlineActiveChatUser['last_message']->message_sent_date, 'Y-m-d');
                        if($con_date != get_local_date('Y-m-d')) {
                            $onlineActiveChatUser['last_message']->message_sent_time = convert_date_to_local($onlineActiveChatUser['last_message']->message_sent_date, MESSAGE_DATE_FORMAT);
                        } else {
                            $today = date_create(get_local_date('Y-m-d H:i:s'));
                            $message_date = date_create(convert_date_to_local($onlineActiveChatUser['last_message']->message_sent_date, 'Y-m-d H:i:s'));

                            $user_online_ago = date_diff($today, $message_date);
                            $user_message_sent_str = '';                      
                            if ($user_online_ago->h > 0) {
                                $user_message_sent_str = $user_online_ago->h.' '.strtolower($this->lang->line('hour'));
                            } else {
                                $user_message_sent_str = $user_online_ago->i.' '.strtolower($this->lang->line('mins'));
                            }
                            $onlineActiveChatUser['last_message']->message_sent_time = $user_message_sent_str;
                        }
                        if(trim($onlineActiveChatUser['last_message']->message_text) == '') {
                             $onlineActiveChatUser['last_message']->message_text = '&nbsp;';
                        } else {
                            // Parse smileys in last message text
                            $onlineActiveChatUser['last_message']->message_text = parse_text_smileys($onlineActiveChatUser['last_message']->message_text);
                        }                        
                    } else {
                        $lmsg = new stdClass;
                        $lmsg->message_sent_time = '';
                        $lmsg->message_text = '&nbsp;';
                        $onlineActiveChatUser['last_message'] = $lmsg;
                    }

                    $onlineActiveChatUser['active_chat'] = true;                        
                    if(count($tmp_array) > 0) {
                        array_unshift($tmp_array, $onlineActiveChatUser);
                    } else {
                        $tmp_array[] = $onlineActiveChatUser;
                    }
                }
            }
            $this->session->unset_userdata('active_user_chat');
        }

        if(count($tmp_array) > 0) {
            $response['status'] = true;
            $response['errorCode'] = 0;
            $response['data'] = $tmp_array;
            $response['message'] = $this->lang->line('success');
        } else {
            $response['status'] = false;
            $response['errorCode'] = 1;
            $response['message'] = $this->lang->line('no_one_found');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Web service for retrieving users recent messages
    public function loadUserChatMessages() {
        $this->load->model(['chat_model', 'favorite_model', 'user_model', 'unlock_request_model']);
        
        $user_id = $this->session->userdata('user_id');
        $member_id_enc = urldecode($this->input->post('user_hash'));
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $per_page = 25;
        $offset = ($per_page * 0);
        $this->chat_model->mark_messages_as_seen_by_user($user_id, $member_id);
        $chatMessages = $this->chat_model->get_user_recent_chat_messages($user_id, $member_id, $per_page, $offset);

        $response['isFavorite'] = $this->favorite_model->is_favorite_member($user_id, $member_id);

        $tmp_msg_array = array();
        if($chatMessages) {
            for($i= (count($chatMessages) - 1); $i>=0; $i--) {
                // parse smileys into text message
                $chatMessages[$i]['message_text'] = parse_text_smileys($chatMessages[$i]['message_text']);

                if($chatMessages[$i]['message_sender_id'] == $user_id) {
                    $chatMessages[$i]['message_ack'] = 'replies';
                } else {
                    $chatMessages[$i]['message_ack'] = 'sent';
                }
                if(convert_date_to_local($chatMessages[$i]['message_sent_date'], 'Y-m-d') == get_local_date('Y-m-d')) {
                    $chatMessages[$i]['message_sent_date'] = convert_date_to_local($chatMessages[$i]['message_sent_date'], MESSAGE_TIME_FORMAT);
                } else {
                    $chatMessages[$i]['message_sent_date'] = convert_date_to_local($chatMessages[$i]['message_sent_date'], MESSAGE_DATE_FORMAT);
                }

                unset($chatMessages[$i]['message_id']);
                unset($chatMessages[$i]['message_sender_id']);
                unset($chatMessages[$i]['message_receiver_id']);
                unset($chatMessages[$i]['message_flag']);
                $tmp_msg_array[] = $chatMessages[$i];
            }            
        }

        // If BOTH Users are VIP user then Unlock chat
        $member_info = $this->user_model->get_active_user_information($member_id);
        if($member_info) {
            if($this->session->userdata('user_is_vip') == 'yes' && $member_info['user_is_vip'] == 'yes') {
                $response['status'] = true;
                $response['errorCode'] = 0;
                $response['data'] = $tmp_msg_array;
                $response['message'] = $this->lang->line('success');
            } else {
                // if conversation unlocked by anyone from both of then then unlock chat
                $valid_upto_date = date('Y-m-d H:i:s', strtotime('-'.CHAT_ACTIVATION_VALID_UPTO_MONTHS.' month'));
                $conversation_unlocked = $this->unlock_request_model->is_already_chat_unlocked($user_id, $member_id, $valid_upto_date);

                if($conversation_unlocked) {
                    $response['status'] = true;
                    $response['errorCode'] = 0;
                    $response['data'] = $tmp_msg_array;
                    $response['message'] = $this->lang->line('success');
                } else {
                    $unlock_chat_html = '<div class="btn_container col-sm-12" style="margin-top: 50px;">
                        <div class="text-center">
                            <i class="fa fa-comments fa-5x"></i>
                            <h4>'.$this->lang->line('unlock_conversation').'</h4>
                        </div>
                        <h5 style="margin-top: 50px;">'.$this->lang->line('if_you_want_to_send_messages_you_need_to_unlock_this_conversation').'</h5>
                        <a class="action_btns continue_btn btn_hover btn-show-chat-unlock-by-me-model">'.$this->lang->line('unlock').'</a>
                        <a class="action_btns continue_btn btn_hover btn-chat-unlock-request-in-chat">'.$this->lang->line('unlock_request').'</a>
                    </div>';

                    $response['status'] = true;
                    $response['errorCode'] = 2;
                    $response['data'] = $unlock_chat_html;
                    $response['message'] = $this->lang->line('success');
                }
            }
        } else {
            $response['status'] = false;
            $response['errorCode'] = 2;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Web service for sending chat message (SendMessage)
    public function sendChatMessage() {
        $this->load->model(['chat_model']);
        
        $user_id = $this->session->userdata('user_id');
        $member_id_enc = urldecode($this->input->post('user_hash'));
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $message_text = trim($this->input->post('message_text'));
        $msg_text = str_replace(array(' ', '<br>', '&nbsp;'), '', $message_text);

        if($msg_text != '') {

            $message_array = array(
                'message_sender_id' => $user_id,
                'message_receiver_id' => $member_id,
                'message_text' => strip_tags(parse_smileys_text($message_text)),
                'message_status' => 'unseen',
                //'message_sent_date' => 'UTC_TIMESTAMP()',
                'message_flag' => 'web'
            );

            $success = $this->chat_model->save_user_chat_message($message_array);

            if($success) {
                $response['status'] = true;
                $response['messageTime'] = get_local_date(MESSAGE_TIME_FORMAT);
                $response['messageText'] = parse_text_smileys(strip_tags(parse_smileys_text($message_text)));
                $response['message'] = $this->lang->line('success');
                $response['errorCode'] = 0;
            } else {
                $response['errorCode'] = 1;
                $response['status'] = false;
                $response['message'] = $this->lang->line('internal_server_error');
            }
        } else {
            $response['errorCode'] = 3;
            $response['status'] = false;
            $response['message'] = $this->lang->line('no_message_found');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Web service for recent user chat messages
    public function getRecentChatMessage() {
        $this->load->model(['chat_model']);
        
        $user_id = $this->session->userdata('user_id');
        $member_id_enc = urldecode($this->input->post('user_hash'));
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);
        
        $chatMessages = $this->chat_model->get_user_recent_unseen_received_chat_messages($user_id, $member_id);

        // Mark them as readed
        $this->chat_model->mark_messages_as_seen_by_user($user_id, $member_id);

        if($chatMessages) {

            $tmp_array = array();
            for($i=0; $i < count($chatMessages); $i++) {
                if(convert_date_to_local($chatMessages[$i]['message_sent_date'], 'Y-m-d') == get_local_date('Y-m-d')) {
                    $chatMessages[$i]['message_sent_date'] = convert_date_to_local($chatMessages[$i]['message_sent_date'], MESSAGE_TIME_FORMAT);
                } else {
                    $chatMessages[$i]['message_sent_date'] = convert_date_to_local($chatMessages[$i]['message_sent_date'], MESSAGE_DATE_FORMAT);
                }
                // Parse smileys in message text
                $chatMessages[$i]['message_text'] = parse_text_smileys($chatMessages[$i]['message_text']);
                unset($chatMessages[$i]['message_id']);
                unset($chatMessages[$i]['message_sender_id']);
                unset($chatMessages[$i]['message_receiver_id']);
                unset($chatMessages[$i]['message_flag']);
                $tmp_array[] = $chatMessages[$i];
            }            


            $response['status'] = true;
            $response['message'] = $this->lang->line('success');
            $response['data'] = $tmp_array;
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('internal_server_error');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Web service for update user activity of typing message
    public function updateUserMessageTypingActivity() {
        $this->load->model(['user_model']);
        
        // update user typing message
        $user_id = $this->session->userdata('user_id');
        $member_id_enc = urldecode($this->input->post('user_hash'));
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $success = $this->user_model->update_last_message_typing_activity($user_id, $member_id);

        if($success) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }


    // Web service for get friend activity of typing message
    public function getFriendMessageTypingActivity() {
        $this->load->model(['user_model']);
        
        $user_id = $this->session->userdata('user_id');
        $member_id_enc = urldecode($this->input->post('user_hash'));
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);


        $success = $this->user_model->is_user_typing_message_activity($user_id, $member_id);

        if($success) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Web service for get friend activity of typing message
    public function setActiveChat() {
                
        //$member_id_enc = urldecode($this->input->post('user_hash'));
        $member_id_enc = $this->input->post('user_hash');
        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $this->session->set_userdata('active_user_chat', $member_id);

        $response['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

}
