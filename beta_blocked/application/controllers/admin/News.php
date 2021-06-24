<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['news_model']);
		$settings = $this->session->userdata('site_setting');		
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;		
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];


        $per_page = 20;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        $data["users"] = $this->news_model->get_all_subscribers_list($per_page, $offset);
        $data["offset"] = $offset;
		if($data["users"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/news'));
			}
		}

		$total_users = $this->news_model->count_all_subscribers_list();

        $url = base_url().'admin/news';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/news/subscribed', $data);
	}

    public function addNews() {
        $data = array();

        $this->load->model(['news_model', 'email_model']);
        $settings = $this->session->userdata('site_setting');               
        $this->lang->load('user_lang', $this->session->userdata('site_language'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('news_title', 'news_title', 'required|trim');
        $this->form_validation->set_rules('news_content', 'news_content', 'required|trim');    

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->form_validation->set_message('required', $this->lang->line('please_correct_your_information'));

        if ($this->form_validation->run() != FALSE) {
            // Send Email to all active subscribers
            $subject = $this->input->post('news_title');            
            $data['email_content'] = $this->input->post('news_content');
            $data['email_template'] = 'email/newsletter';
            $email_message = $this->load->view('templates/email/main', $data, true);

            // Get List of all subscribers
            $subscribers = $this->news_model->get_all_active_subscribers_list();

            if(!empty($subscribers)) {
                foreach ($subscribers as $user) {
                    $to_email = $user['news_subscriber_email'];
                    @$this->email_model->sendEMail($to_email, $subject, $email_message);
                }
            }

            $this->session->set_flashdata('message', $this->lang->line('news_has_been_sent_successfully_to_all_subscribers'));
            redirect(base_url('admin/news'));
        }
        $data["settings"] = $settings;      
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $this->load->view('admin/news/add', $data);
    }

}
