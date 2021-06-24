<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if(!$this->session->has_userdata('user_id')) {
			redirect(base_url());
		}
    }

    public function view() {        
        //error_reporting(E_ALL); ini_set("error_reporting", E_ALL);

        $this->load->model(['user_model', 'visitor_model','kiss_model', 'favorite_model','dislike_model','report_user_model','question_model', 'unlock_request_model', 'sport_model','language_model', 'interest_model','contact_request_model']);

        $member_id_enc = $this->input->get('query');

        if($member_id_enc == '') {
            redirect(base_url());
        }
        $data = array();

        if($this->input->server('HTTP_REFERER')) {
            $this->session->set_userdata('back_url', $this->input->server('HTTP_REFERER'));
        } else {
            if($this->session->userdata('back_url') == '') {
                $this->session->set_userdata('back_url', base_url());
            }
        }

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        //$member_id = $this->encryption->decrypt(url_decode($member_id_enc));
        $member_id = $this->encryption->decrypt($member_id_enc);
        $user_id = $this->session->userdata('user_id');
        $user_gender = $this->session->userdata('user_gender');

        if($member_id == '') {
            if($this->session->userdata('back_url') != '') {
                redirect($this->session->userdata('back_url'));
            } else {
                redirect(base_url());
            }
        }

        // Member profile information
        if($this->session->userdata('user_type') == 'user') {
            $data["user_row"] = $this->user_model->get_active_user_information($member_id);
        } else {
            $data["user_row"] = $this->user_model->get_user_information($member_id);
        }
        $data['is_kissed'] = $this->kiss_model->is_member_kissed($user_id, $member_id);
        $data['is_favorite'] = $this->favorite_model->is_favorite_member($user_id, $member_id);
        $data['is_disliked'] = $this->dislike_model->is_member_disliked($user_id, $member_id);
        $data['is_reported'] = $this->report_user_model->is_member_reported($user_id, $member_id);
        
        $data['user_sports'] = $this->sport_model->get_user_sports_list($member_id);
        $data['user_spoken_languages'] = $this->language_model->get_user_spoken_language_list($member_id);
        $data['user_interests'] = $this->interest_model->get_user_interest_list($member_id);
        $data['user_contact_requests'] = $this->contact_request_model->get_user_contact_request_list($member_id);
        
        $user_unlocked_photos = $this->unlock_request_model->get_user_unlocked_photo_list($user_id, $member_id);



        $user_unlocked_photo_arr = array();
        if($user_unlocked_photos) {
            foreach ($user_unlocked_photos as $photos) {
                array_push($user_unlocked_photo_arr, $photos['unlock_user_image_id']);
            }
        }
        $data['user_unlocked_photo_arr'] = $user_unlocked_photo_arr;

        // if record found this redirect to back page
        if(empty($data["user_row"])) {
            $redirect_url = base_url();
            if($this->input->server('HTTP_REFERER')) {
                $redirect_url = $this->input->server('HTTP_REFERER');
            }
            $this->session->set_userdata('message', $this->lang->line('no_profile_found'));
            redirect($redirect_url);
        }

        // Profile visited by User
        if($user_id != $member_id) {
            $checkAlreadyVisited = $this->visitor_model->get_user_profile_visited_info($user_id, $member_id);
            //print_r($checkAlreadyVisited);die;

            if(!empty($checkAlreadyVisited)) {
                // update profile visited date
                $where_arr = array(
                    'user_profile_visitor_no' => $checkAlreadyVisited['user_profile_visitor_no']
                );

                $updateData = array(
                    'profile_visited_date' => gmdate('Y-m-d H:i:s')
                );
                $this->visitor_model->update_profile_visitors($where_arr, $updateData);
            } else {
                // add record if not inserted
                $insertData = array(
                    'profile_visitor_id' => $user_id,
                    'profile_visited_id' => $member_id,
                    'visitor_user_viewed' => 'no',
                    'profile_visited_date' => gmdate('Y-m-d H:i:s'),
                    'user_profile_visitor_flag' => 'web'
                );
                $this->visitor_model->insert_profile_visitors($insertData);
            }
        }

        $data["user_photos"] = $this->user_model->get_user_active_photos($member_id);


        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data["user_latitude"] = $this->session->userdata('user_latitude');
        $data["user_longitude"] = $this->session->userdata('user_longitude');

        $data['questions'] = $this->question_model->get_active_question_list($user_gender, 30, 0);
        //print_r($data);die;
        $this->load->view('user/profile/view', $data);
    }
    

    public function edit() {
        $data = array();

        $this->load->model(['user_model', 'sport_model','language_model', 'interest_model','contact_request_model', 'photo_model', 'static_data_model', 'document_model', 'user_content_model']);

        $user_id = $this->session->userdata('user_id');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_location', 'lang:location', 'required|trim');
        $this->form_validation->set_rules('user_latitude', 'lang:location', 'trim');
        $this->form_validation->set_rules('user_longitude', 'lang:location', 'trim');
        $this->form_validation->set_rules('user_figure', 'figure', 'required|trim');
        $this->form_validation->set_rules('user_size', 'lang:size', 'numeric|trim');
        $this->form_validation->set_rules('user_job', 'user_job', 'required|trim');
        $this->form_validation->set_rules('user_ethnicity', 'user_ethnicity', 'required|trim');

        // if($this->session->userdata('user_gender') == 'female') {
        //     $this->form_validation->set_rules('user_arangement[]', 'lang:arangement', 'required|trim');
        // }

        $this->form_validation->set_rules('serious_relationship_interested', 'serious_relationship', '');
        $this->form_validation->set_rules('user_contact_request', 'user_contact_request', '');
        //$this->form_validation->set_rules('my_description', 'lang:my_description', 'required|trim');
        //$this->form_validation->set_rules('how_can_man_impress_you', 'lang:how_can_impress_you', 'required|trim');

        $this->form_validation->set_rules('user_sports_selected[]', 'user_sports', 'trim');
        $this->form_validation->set_rules('user_interests_selected[]', 'user_interests', 'trim');
        $this->form_validation->set_rules('user_languages_selected[]', 'user_languages', 'trim');

        $this->form_validation->set_rules('user_hair_color', 'user_hair_color', 'required|trim');
        $this->form_validation->set_rules('user_eye_color', 'user_eye_color', 'required|trim');
        //$this->form_validation->set_rules('user_is_smoker', 'lang:smoker', 'required|trim');
        //$this->form_validation->set_rules('user_has_child', 'lang:children', 'required|trim');
        $this->form_validation->set_error_delimiters('<div class="form-error text-danger">', '</div>');

        if ($this->form_validation->run() != FALSE) {

            // if($this->session->userdata('user_gender') == 'female') {
            //     $user_arangement = implode(',', $this->input->post('user_arangement'));
            // } else {
            //     $user_arangement = '';
            // }
            // Update User information
            $user_information_array = array(
                'user_figure' => $this->input->post('user_figure'),
                'user_height' => $this->input->post('user_size'),
                'user_city' => $this->input->post('user_location'),
                'user_job' => $this->input->post('user_job'),
                'user_ethnicity' => $this->input->post('user_ethnicity'),
                //'user_arangement' => $user_arangement,
                'user_hair_color' => $this->input->post('user_hair_color'),
                'user_eye_color' => $this->input->post('user_eye_color'),
                'user_smoker' => $this->input->post('user_is_smoker'),
                'user_has_child' => $this->input->post('user_has_child'),
                'how_many_childrens' => $this->input->post('how_many_childrens'),
            );

            if($this->input->post('user_latitude') != '' && $this->input->post('user_longitude') != '') {
                $user_information_array['user_latitude'] = $this->input->post('user_latitude');
                $user_information_array['user_longitude'] = $this->input->post('user_longitude');

                $this->session->set_userdata('user_latitude', $this->input->post('user_latitude'));
                $this->session->set_userdata('user_longitude', $this->input->post('user_longitude'));
            }

            if($this->input->post('serious_relationship_interested') == 'yes') {
                $user_information_array['interested_in_serious_relationship'] = 'yes';                
            } else {
                $user_information_array['interested_in_serious_relationship'] = 'no';
            }
            // START Transaction
            $this->db->trans_begin();
            $this->user_model->update_user_info($user_id, $user_information_array);

            // Insert user about us info for approval if changed
            if($this->input->post('my_description') != $this->input->post('old_my_description')) {
                $last_request_id = $this->user_content_model->is_any_pending_request($user_id, 'user_about');

                $user_content_array = array(
                    'content_user_id' => $user_id,
                    'content_text' => $this->input->post('my_description'),
                    'content_type' => 'user_about',
                    'content_status' => 'pending',
                    'content_added_date' => gmdate('Y-m-d H:i:s'),
                    'content_flag' => 'web'
                );
                if($last_request_id) {
                    $this->user_content_model->update_user_content($last_request_id, $user_content_array);
                } else {
                    $this->user_content_model->insert_user_content($user_content_array);
                }
            }

            // Insert user man impress you info for approval if changed
            if($this->input->post('how_can_man_impress_you') != $this->input->post('old_how_can_man_impress_you')) {
                $last_request_id = $this->user_content_model->is_any_pending_request($user_id, 'user_how_impress');

                $user_content_array = array(
                    'content_user_id' => $user_id,
                    'content_text' => $this->input->post('how_can_man_impress_you'),
                    'content_type' => 'user_how_impress',
                    'content_status' => 'pending',
                    'content_added_date' => gmdate('Y-m-d H:i:s'),
                    'content_flag' => 'web'
                );
                if($last_request_id) {
                    $this->user_content_model->update_user_content($last_request_id, $user_content_array);
                } else {
                    $this->user_content_model->insert_user_content($user_content_array);
                }
            }

            // Insert User Contact Request : insert if user is not interested in serious relationship
            if($this->input->post('serious_relationship_interested') != 'yes') {

                if($this->input->post('user_contact_request') != '') {
                    $user_cont_req_arr = $this->input->post('user_contact_request');
                    //remove all deleted contact request records
                    $user_cont_req_arr_str =implode(',', $user_cont_req_arr);
                    $this->contact_request_model->delete_removed_user_contact_request($user_id, $user_cont_req_arr_str);

                    foreach ($user_cont_req_arr as $req_id) {
                        $checkAlreadyAdded = $this->contact_request_model->is_already_present($user_id, $req_id);
                        if($checkAlreadyAdded == false) {
                            $user_contact_req_array = array(
                                'contact_request_contact_id' => $req_id,
                                'contact_request_user_id' => $user_id,
                                'user_contact_request_added_date' => gmdate('Y-m-d H:i:s'),
                                'user_contact_request_flag' => 'web'
                            );
                            $this->contact_request_model->insert_user_contact_request($user_contact_req_array);
                        }
                    }
                }
            } else {
                //if interested in serious relationship then remove all contact request records
                $this->contact_request_model->delete_all_user_contact_request($user_id);
            }


            // Insert User Sports
            if($this->input->post('user_sports_selected') != '') {
                $user_sports_arr = $this->input->post('user_sports_selected');
                //remove all deleted sports records
                $user_sports_arr_str =implode(',', $user_sports_arr);
                $this->sport_model->delete_removed_user_sports($user_id, $user_sports_arr_str);

                foreach ($user_sports_arr as $sport_id) {
                    $checkAlreadyAdded = $this->sport_model->is_already_present($user_id, $sport_id);
                    if($checkAlreadyAdded == false) {
                        $user_sports_array = array(
                            'user_sport_ref_id' => $sport_id,
                            'sport_user_id' => $user_id,
                            'user_sport_added_date' => gmdate('Y-m-d H:i:s'),
                            'user_sport_flag' => 'web'
                        );
                        $this->sport_model->insert_user_sport($user_sports_array);
                    }
                }
            } else {
                // Delete all sports
                $this->sport_model->delete_all_user_sports($user_id);
            }

            // Insert User Interests
            if($this->input->post('user_interests_selected') != '') {
                $user_interests_arr = $this->input->post('user_interests_selected');
                //remove all deleted interests records
                $user_interests_arr_str =implode(',', $user_interests_arr);
                $this->interest_model->delete_removed_user_interests($user_id, $user_interests_arr_str);

                foreach ($user_interests_arr as $interest_id) {
                    $checkAlreadyAdded = $this->interest_model->is_already_present($user_id, $interest_id);
                    if($checkAlreadyAdded == false) {
                        $user_interests_array = array(
                            'interest_id_ref' => $interest_id,
                            'interest_user_id' => $user_id,
                            'user_interest_added_date' => gmdate('Y-m-d H:i:s'),
                            'user_interest_flag' => 'web'
                        );
                        $this->interest_model->insert_user_interest($user_interests_array);
                    }
                }
            } else {
                // Delete all interests
                $this->interest_model->delete_all_user_interests($user_id);
            }

            // Insert User Spoken Languages
            if($this->input->post('user_languages_selected') != '') {
                $user_languages_arr = $this->input->post('user_languages_selected');
                //remove all deleted interests records
                $user_languages_arr_str =implode(',', $user_languages_arr);
                $this->language_model->delete_removed_user_languages($user_id, $user_languages_arr_str);

                foreach ($user_languages_arr as $language_id) {
                    $checkAlreadyAdded = $this->language_model->is_already_present($user_id, $language_id);
                    if($checkAlreadyAdded == false) {
                        $user_languages_array = array(
                            'spoken_language_ref_lang_id' => $language_id,
                            'spoken_language_user_id' => $user_id,
                            'spoken_language_added_date' => gmdate('Y-m-d H:i:s'),
                            'spoken_language_flag' => 'web'
                        );
                        $this->language_model->insert_user_spoken_language($user_languages_array);
                    }
                }
            } else {
                // Delete all languages
                $this->language_model->delete_all_user_languages($user_id);
            }

            // Upload documents
            // Check if the directory already exists
            if (!file_exists("./uploads/documents/" . $user_id . "/")) {
                mkdir("./uploads/documents/" . $user_id . "/");
            }

            //START: Upload Reality Check Document
            if(isset($_FILES['reality_check_file']['tmp_name']) && $_FILES['reality_check_file']['error'] == 0){
                $nameFile = rand(0,999999).time();
                $config['upload_path'] = "./uploads/documents/" . $user_id . "/";
                $config['allowed_types'] = '*';
                $config['file_name'] = $nameFile;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('reality_check_file')) {
                    //$error = $this->upload->display_errors();
                    // skip errors
                } else {
                    $uploaded_data = $this->upload->data();
                    $document_array = array(
                        'document_user_id' => $user_id,
                        'document_url' => "uploads/documents/" . $user_id . "/".$uploaded_data['orig_name'],
                        'document_name' => $uploaded_data['client_name'],
                        'document_added_date' => gmdate('Y-m-d H:i:s'),
                        'document_type' => 'reality_check_file',
                        'document_status' => 'pending',
                        'document_flag' => 'web'
                    );
                    $this->document_model->insert_user_document($document_array);
                }
            }
            //END: Upload Reality Check Document

            //START: Upload gift delivery check Document
            if(isset($_FILES['gift_delivery_check_file']['tmp_name']) && $_FILES['gift_delivery_check_file']['error'] == 0){
                $nameFile = rand(0,999999).time();
                $config['upload_path'] = "./uploads/documents/" . $user_id . "/";
                $config['allowed_types'] = '*';
                $config['file_name'] = $nameFile;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('gift_delivery_check_file')) {
                    //$error = $this->upload->display_errors();
                    // skip errors
                } else {
                    $uploaded_data = $this->upload->data();
                    $document_array = array(
                        'document_user_id' => $user_id,
                        'document_url' => "uploads/documents/" . $user_id . "/".$uploaded_data['orig_name'],
                        'document_name' => $uploaded_data['client_name'],
                        'document_added_date' => gmdate('Y-m-d H:i:s'),
                        'document_type' => 'gift_delivery_check_file',
                        'document_status' => 'pending',
                        'document_flag' => 'web'
                    );
                    $this->document_model->insert_user_document($document_array);
                }
            }
            //END: Upload gift delivery check Document

            //START: Upload asset check file check Document
            if(isset($_FILES['asset_check_file']['tmp_name']) && $_FILES['asset_check_file']['error'] == 0){
                $nameFile = rand(0,999999).time();
                $config['upload_path'] = "./uploads/documents/" . $user_id . "/";
                $config['allowed_types'] = '*';
                $config['file_name'] = $nameFile;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('asset_check_file')) {
                    //$error = $this->upload->display_errors();
                    // skip errors
                } else {
                    $uploaded_data = $this->upload->data();
                    $document_array = array(
                        'document_user_id' => $user_id,
                        'document_url' => "uploads/documents/" . $user_id . "/".$uploaded_data['orig_name'],
                        'document_name' => $uploaded_data['client_name'],
                        'document_added_date' => gmdate('Y-m-d H:i:s'),
                        'document_type' => 'asset_check_file',
                        'document_status' => 'pending',
                        'document_flag' => 'web'
                    );
                    $this->document_model->insert_user_document($document_array);
                }
            }
            //END: Upload asset check file Document

            // END Transaction
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata("message", "please_try_again_after_some_time");
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata("message", "your_profile_has_been_updated_successfully");
            }     
            redirect(base_url('user/profile/edit'));

        }

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        /* User Information */
        $data["user_row"] = $this->user_model->get_active_user_information($user_id);
        $data['user_photos'] = $this->photo_model->get_user_all_photos_list($user_id);
        $data['user_sports'] = $this->sport_model->get_user_sports_list($user_id);
        $data['user_spoken_languages'] = $this->language_model->get_user_spoken_language_list($user_id);
        $data['user_interests'] = $this->interest_model->get_user_interest_list($user_id);
        $data['user_contact_requests'] = $this->contact_request_model->get_user_contact_request_list($user_id);
        $data['user_city'] = $this->user_content_model->get_user_last_added_content($user_id, 'user_city');
        $data['user_about'] = $this->user_content_model->get_user_last_added_content($user_id, 'user_about');
        $data['user_how_impress'] = $this->user_content_model->get_user_last_added_content($user_id, 'user_how_impress');
        $data['reality_check_documents'] = $this->document_model->get_user_reality_documents($user_id);
        $data['asset_check_documents'] = $this->document_model->get_user_asset_documents($user_id);

        /* Required Data */
        $data['figure_list'] = $this->static_data_model->get_figure_list();
        $data['job_list'] = $this->static_data_model->get_job_list();
        $data['ethnicity_list'] = $this->static_data_model->get_ethnicity_list();
        $data['contact_requests'] = $this->contact_request_model->get_active_contact_request_list();
        $data['eye_color_list'] = $this->static_data_model->get_eye_color_list();
        $data['hair_color_list'] = $this->static_data_model->get_hair_color_list();
        $data['sports'] = $this->sport_model->get_active_sports_list();
        $data['languages'] = $this->language_model->get_spoken_language_list();
        $data['interests'] = $this->interest_model->get_active_interest_list();

        $this->load->view('user/profile/edit', $data);
    }

    public function manage() {
        $data = array();

        //$this->load->model(['site_model']);

        $user_id = $this->session->userdata('user_id');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data["user_latitude"] = $this->session->userdata('user_latitude');
        $data["user_longitude"] = $this->session->userdata('user_longitude');


        $this->load->view('user/profile/manage', $data);
    }

    public function status() {
        $data = array();

        $this->load->model(['vip_package_model', 'user_model']);

        $user_id = $this->session->userdata('user_id');
        $user_gender = $this->session->userdata('user_gender');

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $data["user_row"] = $this->user_model->get_active_user_information($user_id);
        $data['vip_packages'] = $this->vip_package_model->get_active_vip_package_list($user_gender, 4, 0);

        $this->load->view('user/profile/status', $data);
    }

    public function uploadProfilePic() {
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $this->load->model(['photo_model']);

        $photo_type = $this->input->post('type');
        $user_id = $this->session->userdata('user_id');

        $picture_count = $this->photo_model->get_user_photo_count_by_photo_type($user_id, $photo_type);
        if(($photo_type == 'profile' && $picture_count < PROFILE_PICTURE_UPLOAD_LIMIT) || ($photo_type == 'vip' && $picture_count < VIP_PICTURE_UPLOAD_LIMIT) || ($photo_type == 'private' && $picture_count < PRIVATE_PICTURE_UPLOAD_LIMIT)) {
            if (!empty($_FILES)) {
                

                // Check if the directory already exists
                if (!file_exists("./uploads/photos/" . $user_id . "/")) {
                    mkdir("./uploads/photos/" . $user_id . "/");
                    mkdir("./uploads/photos/" . $user_id . "/thumbnails/");
                }

                $nameFile   = rand(0,999999).time();
                $tempFile   = $_FILES['file']['tmp_name'];
                $fileTypes  = array('jpg','jpeg','png', 'JPG', 'JPEG', 'PNG');
                $fileParts  = pathinfo($_FILES['file']['name']);

                $targetPath = "./uploads/photos/" . $user_id . "/";
                $targetPathThumb = $targetPath . "thumbnails/";

                $targetPathEchoThumb = "/uploads/photos/" . $user_id . "/thumbnails/";
                $targetPathEcho = "/uploads/photos/" . $user_id . "/";
                
                $targetFile =  str_replace('//','/',$targetPath) . $nameFile . "." . $fileParts["extension"];
                $targetFileThumb = str_replace('//','/',$targetPathThumb) . $nameFile . "." . $fileParts["extension"];
                $targetFileEcho = str_replace('//','/',$targetPathEcho) . $nameFile . "." . $fileParts["extension"];
                $targetFileEchoThumb = str_replace('//','/',$targetPathEchoThumb) . $nameFile . "." . $fileParts["extension"];
            
                $this->load->helper('image_helper');
                if (in_array($fileParts['extension'], $fileTypes)) {

                    $profille_photo = image_compress($tempFile, $targetFile, 100);
                    $profille_photo_thumb = image_compress_thumbnail($tempFile, $targetFileThumb, 70);

                    $profille_photo = substr($profille_photo, 2);
                    $profille_photo_thumb = substr($profille_photo_thumb, 2);
                    // Store iamge info in photo model
                    $this->load->model(['photo_model','user_model']);
                    $photo_array = array(
                        'photo_user_id_ref' => $user_id,
                        'photo_url' => $profille_photo,
                        'photo_thumb_url' => $profille_photo_thumb,
                        'photo_added_date' => gmdate("Y-m-d H:i:s"),
                        'photo_type' => $this->input->post('type'),
                        'photo_status' => 'inactive',
                        'is_profile_photo' => $this->input->post('profile'),
                        'photo_flag' => 'web'
                    );

                    if($this->input->post('profile') == 'yes') {
                        //Remove previous default profile photo if any
                        $this->photo_model->remove_as_default_photo($user_id);

                        $user_info_array = array(
                            'user_active_photo' => '',
                            'user_active_photo_thumb' => '',
                        );
                        $this->user_model->update_user_info($user_id, $user_info_array);
                    }

                    $success = $this->photo_model->insert_user_photo($photo_array);

                    if($success) {
                        if($this->input->post('profile') == 'yes') {
                            $this->session->set_userdata("user_avatar", $profille_photo_thumb);
                        }
                        $response["status"] = true;
                        $response["errorCode"] = 0;
                        $response["message"] = $this->lang->line('your_picture_has_been_uploaded_successfully');
                        $this->session->set_flashdata("message", "your_picture_has_been_uploaded_successfully");
                    } else {
                        $response["status"] = false;
                        $response["errorCode"] = 2;
                        $response["message"] = $this->lang->line('please_try_again_after_some_time');
                        $this->session->set_flashdata("message", "please_try_again_after_some_time");
                    }
                } else {
                    $response["status"] = false;
                    $response["errorCode"] = 1;
                    $response["message"] = $this->lang->line('please_upload_correct_image_file');
                    $this->session->set_flashdata("message", "please_upload_correct_image_file");
                }
            } else {
                $response["status"] = false;
                $response["errorCode"] = 1;
                $response["message"] = $this->lang->line('please_upload_correct_image_file');
                $this->session->set_flashdata("message", "please_upload_correct_image_file");
            }
        } else {
            $response["status"] = false;
            $response["errorCode"] = 1;
            $response["message"] = $this->lang->line('max_picture_upload_limit_has_been_reached');
            $this->session->set_flashdata("message", "max_picture_upload_limit_has_been_reached");
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function setAsProfilePicture() {
        $this->load->model(['user_model', 'photo_model']);

        $photo_id = $this->input->post('pic_data');
        $user_id = $this->session->userdata('user_id');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $isMyPic = $this->photo_model->get_user_photo_info($user_id, $photo_id);
        if($isMyPic == false) {
            $response['status'] = false;
            $response['errorCode'] = 0;
            $response['message'] = $this->lang->line('unauthorized_access');
        } else {
            //Remove previous default photo if any
           $this->photo_model->remove_as_default_photo($user_id);

           if($isMyPic['photo_status'] == 'active') {
                $this->db->trans_begin();

                // Update as default photo
                $this->photo_model->update_as_default_photo_info($user_id, $photo_id);

                $user_info_array = array(
                    'user_active_photo' => $isMyPic['photo_url'],
                    'user_active_photo_thumb' => $isMyPic['photo_thumb_url'],
                );
                $this->user_model->update_user_info($user_id, $user_info_array);

                // END Transaction
                if($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();

                    $response['status'] = false;
                    $response['errorCode'] = 1;
                    $response['message'] = $this->lang->line('please_try_again_after_some_time');
                } else {
                    $this->db->trans_commit();

                    $this->session->set_userdata("user_avatar", $isMyPic['photo_thumb_url']);
                    $response['status'] = true;
                    $response['data'] = base_url($isMyPic);
                }
           } else {

                // Update as default photo
                $this->photo_model->update_as_default_photo_info($user_id, $photo_id);
                $profile_pic = "images/avatar/".$this->session->userdata('user_gender').".png";

                $user_info_array = array(
                    'user_active_photo' => '',
                    'user_active_photo_thumb' => '',
                );
                $this->user_model->update_user_info($user_id, $user_info_array);

                $response['status'] = false;
                $response['errorCode'] = 2;
                $response['data'] = base_url($profile_pic);
                $this->session->set_userdata("user_avatar", $profile_pic);
                $response['message'] = $this->lang->line('already_blocked');
           }
       }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function moveToVIPPicture() {
        $this->load->model(['user_model', 'photo_model']);

        $photo_id = $this->input->post('pic_data');
        $user_id = $this->session->userdata('user_id');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));        

        $picture_count = $this->photo_model->get_user_photo_count_by_photo_type($user_id, 'vip');

        if($picture_count < VIP_PICTURE_UPLOAD_LIMIT) {
            $isMyPic = $this->photo_model->get_user_photo_info($user_id, $photo_id);

            if($isMyPic == false) {
                $response['status'] = false;
                $response['errorCode'] = 0;
                $response['message'] = $this->lang->line('unauthorized_access');
            } else {
               // Update as VIP photo
                $success = $this->photo_model->update_user_photo_status($user_id, $photo_id, 'vip');

                if($success > 0) {
                    // set to default avtar
                    $response['status'] = true;
                } else {
                    $response['status'] = false;
                    $response['errorCode'] = 1;
                    $response['message'] = $this->lang->line('internal_server_error');
                }
            }
        } else {
            $response['status'] = false;
            $response['errorCode'] = 1;
            $response['message'] = $this->lang->line('max_vip_picture_limit_has_been_reached');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function moveToProfilePicture() {
        $this->load->model(['user_model', 'photo_model']);

        $photo_id = $this->input->post('pic_data');
        $user_id = $this->session->userdata('user_id');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));        

        $picture_count = $this->photo_model->get_user_photo_count_by_photo_type($user_id, 'profile');        

        if($picture_count < PROFILE_PICTURE_UPLOAD_LIMIT) {            
            $isMyPic = $this->photo_model->get_user_photo_info($user_id, $photo_id);

            if($isMyPic == false) {
                $response['status'] = false;
                $response['errorCode'] = 0;
                $response['message'] = $this->lang->line('unauthorized_access');
            } else {
               // Update as Profile photo
                $success = $this->photo_model->update_user_photo_status($user_id, $photo_id, 'profile');

                if($success > 0) {
                    // set to default avtar
                    $response['status'] = true;
                } else {
                    $response['status'] = false;
                    $response['errorCode'] = 1;
                    $response['message'] = $this->lang->line('internal_server_error');
                }
            }
        } else {
            $response['status'] = false;
            $response['errorCode'] = 1;
            $response['message'] = $this->lang->line('max_profile_picture_limit_has_been_reached');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function clearMyPicture() {
        $this->load->model(['user_model', 'photo_model']);

        $photo_id = $this->input->post('pic_data');
        $user_id = $this->session->userdata('user_id');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));        

        $isMyPic = $this->photo_model->get_user_photo_info($user_id, $photo_id);

        if($isMyPic == false) {
            $response['status'] = false;
            $response['errorCode'] = 0;
            $response['message'] = $this->lang->line('unauthorized_access');
        } else {
            // if it as default photo then remove default photo
            $response['setAvatar'] = false;
            if($isMyPic['is_profile_photo'] == 'yes') {
                // remove from prfile photo 
                $avatar = "images/avatar/".$this->session->userdata('user_gender').".png";
                $user_info_array = array(
                    'user_active_photo' => NULL,
                    'user_active_photo_thumb' => NULL,
                );
                $success_s = $this->user_model->update_user_info($user_id, $user_info_array);

                // change user avatar image
                $this->session->set_userdata("user_avatar", $avatar);
                $response['setAvatar'] = true;
                $response['avatar'] = base_url($avatar);
            }

            //Remove user photo
            $success = $this->photo_model->remove_user_photo($user_id, $photo_id);

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

    public function changeEmail() {
        $this->load->model(['user_model']);        
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldemail', 'oldemail', 'required|valid_email|trim');
        $this->form_validation->set_rules('newemail', 'newemail', 'required|valid_email|trim');

        if ($this->form_validation->run() == FALSE) {
            $response["status"] = false;
            $response["error"]  = 1;
            $response["message"] = $this->lang->line('please_correct_your_information');
            $response["error_array"] = $this->form_validation->error_array();
        } else {
            $user_id = $this->session->userdata('user_id');
            $oldemail = $this->input->post('oldemail');
            $newemail = $this->input->post('newemail');

            if($oldemail == $newemail) {
                $response['status'] = false;
                $response['errorCode'] = 2;
                $response['message'] = $this->lang->line('please_correct_your_information');
            } else {
                $useroldemail = $this->user_model->get_user_email($user_id);

                if($oldemail == $useroldemail) {
                    $isAlreadyTaken = $this->user_model->is_email_already_taken($user_id, $newemail);

                    if($isAlreadyTaken == true) {
                        $response['status'] = false;
                        $response['errorCode'] = 2;
                        $response['message'] = $this->lang->line('this_email_is_already_taken');
                    } else {
                        $update_array = array(
                            'user_email' => $newemail
                        );

                        $success = $this->user_model->update_user($user_id, $update_array);
                        if($success) {
                            $response['status'] = true;
                            $response['errorCode'] = 0;
                            $response['message'] = $this->lang->line('your_email_has_been_changed_successfully');
                        } else {
                            $response['status'] = false;
                            $response['errorCode'] = 2;
                            $response['message'] = $this->lang->line('please_correct_your_information');
                        }
                    }
                } else {
                    $response['status'] = false;
                    $response['errorCode'] = 2;
                    $response['message'] = $this->lang->line('your_old_email_is_wrong');
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function changePassword() {
        $this->load->model(['user_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPwd', 'oldPwd', 'required|trim');
        $this->form_validation->set_rules('newPwd', 'newPwd', 'required|trim');
        $this->form_validation->set_rules('rptnewPwd', 'rptnewPwd', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $response["status"] = false;
            $response["error"]  = 1;
            $response["message"] = $this->lang->line('please_correct_your_information');
            $response["error_array"] = $this->form_validation->error_array();
        } else {
            $user_id = $this->session->userdata('user_id');
            $oldPwd = $this->input->post('oldPwd');
            $newPwd = $this->input->post('newPwd');
            $rptnewPwd = $this->input->post('rptnewPwd');

            if($newPwd != $rptnewPwd) {
                $response['status'] = false;
                $response['errorCode'] = 2;
                $response['message'] = $this->lang->line('password_mismatch');
            } else {
                $user_row = $this->user_model->get_user_information($user_id);
                $oldPwd_hash = sha1($oldPwd);

                if($user_row['user_password'] == $oldPwd_hash) {
                    $update_array = array(
                        'user_password' => sha1($newPwd)
                    );

                    $success = $this->user_model->update_user($user_id, $update_array);
                    if($success) {
                        $response['status'] = true;
                        $response['errorCode'] = 0;
                        $response['message'] = $this->lang->line('your_password_has_been_changed_successfully');

                    } else {
                        $response['status'] = false;
                        $response['errorCode'] = 2;
                        $response['message'] = $this->lang->line('please_correct_your_information');
                    }
                } else {
                    $response['status'] = false;
                    $response['errorCode'] = 2;
                    $response['message'] = $this->lang->line('your_old_password_is_wrong');
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function deleteProfile() {
        $this->load->model(['user_model','sport_model','language_model', 'question_model','visitor_model', 'photo_model', 'kiss_model', 'interest_model', 'favorite_model','document_model', 'dislike_model', 'contact_request_model', 'chat_model', 'saved_search_model', 'unlock_request_model', 'credit_package_model', 'diamond_package_model', 'user_content_model', 'report_user_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $user_id = $this->session->userdata('user_id');

        if(isset($_POST['delete_token'])) {

            $sts = $this->user_model->delete_user($user_id);

            if(!$sts) {
                $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
                redirect(base_url('user/profile/manage'));
            } else {
                $this->user_model->clear_user_login_session();
                $this->session->set_flashdata('message', $this->lang->line('your_profile_has_been_deleted_successfully'));
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('message', 'unauthorized_access');
            redirect(base_url('user/profile/manage'));
        }        
    }

    public function deactivateProfile() {
        $this->load->model(['user_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        if(isset($_POST['deactivate_token'])) {
            $user_id = $this->session->userdata('user_id');

            $update_array = array(
                'user_status' => 'inactive'
            );
            $success = $this->user_model->update_user($user_id, $update_array);

            if($success) {
                $this->user_model->clear_user_login_session();
                $this->session->set_flashdata('message', $this->lang->line('your_profile_has_been_deactivated_successfully'));
                redirect(base_url(''));
            } else {
                $this->session->set_flashdata('message', 'internal_server_error');
                redirect(base_url('user/profile/manage'));
            }
        } else {
            $this->session->set_flashdata('message', 'unauthorized_access');
            redirect(base_url('user/profile/manage'));
        }
    }

    public function cancelVIPMembership() {
        $this->load->model(['user_model', 'email_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        if(isset($_POST['cancel_vip_token'])) {
            $user_id = $this->session->userdata('user_id');

            $update_array = array(
                'user_is_vip' => 'no'
            );
            $success = $this->user_model->update_user($user_id, $update_array);

            if($success) {
                $this->session->set_userdata('user_is_vip', 'no');
                $this->session->set_flashdata('message', 'your_vip_membership_has_been_canceled_successfully');

                // Send email for VIP Memebership has been Canceled
                $to_email = $this->session->userdata('user_email');
                $subject = $this->lang->line('vip_memebership_canceled');
                $data['user_name'] = $this->session->userdata('user_username');
                $data['user_profile_pic'] = base_url($this->session->userdata('user_avatar'));
                $data['expired_date'] = get_local_date('d.m.Y');

                $data['email_template'] = 'email/cancel_vip_membership';
                $email_message = $this->load->view('templates/email/main', $data, true);
                @$this->email_model->sendEMail($to_email, $subject, $email_message);
            } else {
                $this->session->set_flashdata('message', 'internal_server_error');
            }
        } else {
            $this->session->set_flashdata('message', 'unauthorized_access');
        }
        redirect(base_url('user/profile/manage'));
    }

    public function onlineSwitcher() {
        $swicher_value = $this->input->post('switcher_value');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        if($this->session->userdata('user_is_vip') == 'yes' && ($swicher_value == 'online' || $swicher_value == 'offline')) {
            if($swicher_value == 'online') {                
                $this->session->set_userdata('user_is_online', 'yes');
                $this->session->set_userdata('user_offline_activity_start_date', '');
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->load->model(['auth_model']);

                $this->auth_model->set_online_switcher_date($user_id);
                $this->session->set_userdata('user_is_online', 'no');
                $this->session->set_userdata('user_offline_activity_start_date', gmdate('Y-m-d H:i:s'));
            }

            $response['status'] = true;
            $response['message'] = $this->lang->line('success');
        } else {
            $response['status'] = false;
            $response['message'] = $this->lang->line('unauthorized_access');
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function blurPicture($photo_id = '') {
        $this->load->model(['photo_model']);
        $photo_info = $this->photo_model->get_photo_info($photo_id);

        if($photo_info) {
            $config['image_library'] = 'gd2';
            $config['source_image'] = $photo_info['photo_url'];
            $config['dynamic_output'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['quality']        = '2%';
            $config['width']         = 220;
            $config['height']       = 220;

            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
        }
    }


    public function updateProfileInfo() {
        $data = array();

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model(['user_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->form_validation->set_rules('first_name', 'first_name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'last_name', 'required|trim');
        $this->form_validation->set_rules('telephone', 'telephone', 'required|trim');
        $this->form_validation->set_rules('street', 'street', 'trim');
        $this->form_validation->set_rules('house_no', 'house_no', 'trim');
        $this->form_validation->set_rules('company', 'company', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $data["status"] = false;
            $data["errorCode"]  = 1;
            $data["message"] = $this->lang->line('please_correct_your_information');
            $data["errors"]  = $this->form_validation->error_array();
        } else {
            // User Info
            $user_info_data = array(
                'user_firstname' => $this->input->post('first_name'),
                'user_lastname' => $this->input->post('last_name'),
                'user_telephone' => $this->input->post('telephone'),
                'user_street' => $this->input->post('street'),
                'user_house_no' => $this->input->post('house_no'),
                'user_company' => $this->input->post('company'),
            );

            $user_id = $this->session->userdata('user_id');
            $sts = $this->user_model->update_user_info($user_id, $user_info_data);

            if($sts) {
                $data['status'] = true;
            } else {
                $data["status"] = false;
                $data["errorCode"]  = 2;
                $data["message"] = $this->lang->line('please_try_again_after_some_time');
            }
        }

        header('Content-type:application/json');
        echo json_encode($data);
    }

}
