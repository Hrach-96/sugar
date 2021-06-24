<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContactUs extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['contact_us_model']);
		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $per_page = 15;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        $data["offset"] = $offset;
		$data["messages"] = $this->contact_us_model->get_contact_us_list($per_page, $offset);
		$total_messages = $this->contact_us_model->count_contact_us_list();

        $url = base_url().'admin/contactUs';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_messages, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/contact_us/view', $data);
	}
    // archive the meessage
    public function archive($message_id) {
        $this->load->model(['contact_us_model']);
        $data = [
            'archived' => 1
        ];
        $this->contact_us_model->update_contact_message($message_id,$data);
        redirect(base_url('admin/contactUs'));
    }
    public function reply($message_id) {
        $this->load->model(['contact_us_model', 'email_model']);
        $settings = $this->session->userdata('site_setting');
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $data = array();
        $data["message"] = $this->contact_us_model->get_message_info_by_id($message_id);
        
        if(empty($data["message"])) {
            $this->session->set_flashdata('message', $this->lang->line('unauthorized_access'));
            redirect(base_url('admin/contactUs'));            
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('message_title', 'message_title', 'required|trim');
        $this->form_validation->set_rules('message_content', 'message_content', 'required|trim');    

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));

        if ($this->form_validation->run() != FALSE) {   
            $user_id = $this->session->userdata('user_id');

            $update_array = array(
                'message_reply_by' => $user_id,
                'message_reply_text' => $this->input->post('message_content'),
                'message_reply_date' => gmdate('Y-m-d H:i:s')
            );
            $success_flg = $this->contact_us_model->update_contact_message($message_id, $update_array);

            if($success_flg) {
                // Send Email Message to User
                $to_email = $data["message"]['email_address'];
                $subject = $this->input->post('message_title');
                $data['email_content'] = $this->input->post('message_content');
                $data['email_template'] = 'email/newsletter';
                $email_message = $this->load->view('templates/email/main', $data, true);
                @$this->email_model->sendEMail($to_email, $subject, $email_message);

                $this->session->set_flashdata('message', $this->lang->line('your_message_has_been_sent_successfuly'));
            } else {
                $this->session->set_flashdata('message', $this->lang->line('internal_server_error'));
            }
            redirect(base_url('admin/contactUs'));
        }
        $data["settings"] = $settings;
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $this->load->view('admin/contact_us/reply', $data);
    }    

}
