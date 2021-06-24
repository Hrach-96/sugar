<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function faq() {
    	$data = array();

	    $this->load->model(['vip_package_model', 'credit_package_model', 'faq_model', 'email_model']);

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'faq_lang'), $this->session->userdata('site_language'));

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('full_name', 'lang:first_name', 'required|trim');
        $this->form_validation->set_rules('email_address', 'lang:email_address', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone_number', 'lang:phone_number', 'trim');
        $this->form_validation->set_rules('captcha_text_ans', 'lang:captcha_text_text', 'required|trim');
        $this->form_validation->set_rules('captcha_text', 'lang:captcha_text', 'required|matches[captcha_text_ans]|trim');        
        $this->form_validation->set_rules('message', 'lang:message', 'required|trim');
        $this->form_validation->set_error_delimiters('<div class="form-error text-danger">', '</div>');

        if ($this->form_validation->run() != FALSE) {
            //print_r($_POST);die;
            $faq_array = array(
                'full_name' => $this->input->post('full_name'),
                'email_address' => $this->input->post('email_address'),
                'phone_number' => $this->input->post('phone_number'),
                'question' => $this->input->post('message'),
                'faq_added_date' => gmdate('Y-m-d H:i:s'),
                'faq_flag' => 'web'
            );

            $success = $this->faq_model->insert_faq_question($faq_array);
            if($success) {
                $this->session->set_userdata('message', 'your_message_has_been_sent_successfuly');

                $email_data = array(
                    'user_name' => $this->input->post('full_name'),
                    'base_url' => base_url(),
                    'to_email' => $this->input->post('email_address')
                );
                @$this->email_model->faqMessage($email_data);
            } else {
                $this->session->set_userdata('message', 'internal_server_error');
            }
            redirect(base_url('page/faq'));
        }

        // Captcha for security purpose 
        $this->load->helper('captcha');
        $captcha_vals = array(
            'img_path'      => './images/captcha/',
            'img_url'       => base_url().'images/captcha/',
            'word_length'   => 6,
            'pool'          => '0123456789',
            'font_size'     => 22,
            'colors'        => array(
                'background' => array(9, 2, 22),
                'border' => array(9, 2, 22),
                'text' => array(239, 232, 11),
                'grid' => array(12, 79, 193)
            )
        );
        $cap_res = create_captcha($captcha_vals);
        $this->session->set_userdata('captcha_text', $cap_res['word']);

        $data["captcha_image_url"] = base_url('images/captcha/'.$cap_res['filename']);
    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		
        $data['vip_packages_male'] = $this->vip_package_model->get_active_vip_package_list('male', 4, 0);
        $data['vip_packages_female'] = $this->vip_package_model->get_active_vip_package_list('female', 4, 0);
        $data['credit_packages'] = $this->credit_package_model->get_active_credit_package_list(4, 0);
        $this->load->view('page/faq', $data);
	}
	
	public function contactUs() {
    	$data = array();
        $this->load->model(['contact_us_model', 'email_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'lang:first_name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'lang:last_name', 'required|trim');
        $this->form_validation->set_rules('email_address', 'lang:email_address', 'required|valid_email|trim');
        $this->form_validation->set_rules('phone_number', 'lang:phone_number', 'trim');
        $this->form_validation->set_rules('captcha_text_ans', 'lang:captcha_text_text', 'required|trim');
        $this->form_validation->set_rules('captcha_text', 'lang:captcha_text', 'required|matches[captcha_text_ans]|trim');
        $this->form_validation->set_rules('message', 'lang:message', 'required|trim');
        $this->form_validation->set_error_delimiters('<div class="form-error text-danger">', '</div>');

        if ($this->form_validation->run() != FALSE) {
            $contact_us_array = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email_address' => $this->input->post('email_address'),
                'phone_number' => $this->input->post('phone_number'),
                'message' => $this->input->post('message'),
                'message_date' => gmdate('Y-m-d H:i:s'),
                'contact_us_flag' => 'web'
            );

            // Upload message attachment if any
            if(isset($_FILES['attachment']['tmp_name']) && $_FILES['attachment']['error'] == 0) {
                $nameFile = rand(0,999999).time();
                $config['upload_path'] = "./uploads/contactus/";
                $config['allowed_types'] = '*';
                $config['file_name'] = $nameFile;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('attachment')) {
                    //$error = $this->upload->display_errors();
                    // skip errors
                } else {
                    $uploaded_data = $this->upload->data();
                    $contact_us_array['attachment'] = "uploads/contactus/".$uploaded_data['orig_name'];
                }
            }
            //END: Upload message attachment

            $success = $this->contact_us_model->insert_conact_us($contact_us_array);
            if($success) {                
                $this->session->set_userdata('message', 'your_message_has_been_sent_successfuly');

                // Send Email to message receive acknowledgement to user
                $to_email = $this->input->post('email_address');
                $subject = $this->lang->line('thank_you_for_your_message');
                $data['message_sender_name'] = $this->input->post('first_name');
                $data['email_template'] = 'email/contact_us_message';
                $email_message = $this->load->view('templates/email/main', $data, true);
                @$this->email_model->sendEMail($to_email, $subject, $email_message);
            } else {
                $this->session->set_userdata('message', 'internal_server_error');
            }
            redirect(base_url('page/contactUs'));
        }	    

        // Captcha for security purpose 
        $this->load->helper('captcha');
        $captcha_vals = array(
            'img_path'      => './images/captcha/',
            'img_url'       => base_url().'images/captcha/',
            'word_length'   => 6,
            'pool'          => '0123456789',
            'font_size'     => 22,
            'colors'        => array(
                'background' => array(9, 2, 22),
                'border' => array(9, 2, 22),
                'text' => array(239, 232, 11),
                'grid' => array(12, 79, 193)
            )
        );
        $cap_res = create_captcha($captcha_vals);
        $this->session->set_userdata('captcha_text', $cap_res['word']);            

        $settings = $this->session->userdata('site_setting');
        $data["captcha_image_url"] = base_url('images/captcha/'.$cap_res['filename']);
        $data["settings"] = $settings;        
    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$this->load->view('page/contact_us', $data);
	}

	public function assetCheck() {
    	$data = array();

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'asset_check_lang'), $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$this->load->view('page/asset_check_info', $data);
	}

	public function realityCheck() {
    	$data = array();

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'reality_check_lang'), $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$this->load->view('page/reality_check_info', $data);
	}

	public function realityGiftCheck() {
    	$data = array();

	    //$this->load->model(['site_model']);
        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

    	$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
		$this->load->view('page/reality_giftdelivery_check_info', $data);
	}

    public function terms_of_use() {
        $data = array();

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'terms_of_use_lang'), $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $this->load->view('page/terms_of_use', $data);
    }

    public function privacy_statement() {
        $data = array();

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'privacy_statement_lang'), $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $this->load->view('page/privacy_statement', $data);
    }

    public function imprint() {
        $data = array();
        
        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'imprint_lang'), $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $this->load->view('page/imprint', $data);
    }

    public function cancellation_terms() {
        $data = array();

        $settings = $this->session->userdata('site_setting');
        $data["settings"] = $settings;
        $this->lang->load(array('user_lang', 'cancellation_terms_lang'), $this->session->userdata('site_language'));

        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];
        $this->load->view('page/cancellation_terms', $data);
    }        

}
