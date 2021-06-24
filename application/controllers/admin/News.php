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

        $search_email = '';
        if($this->input->get('email') != '') {
            $search_email = $this->input->get('email');
        }   
        $data["settings"] = $settings;      
        $data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];


        $per_page = 20;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
        $data["users"] = $this->news_model->get_all_subscribers_list_new($per_page, $offset,$search_email);
        $data["offset"] = $offset;
        if($data["users"] == false) {
            if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
                redirect(base_url('admin/news'));
            }
        }

        $total_users = $this->news_model->count_all_subscribers_list_new($search_email);

        $url = base_url().'admin/news';
        $this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_users, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $this->load->view('admin/news/subscribed', $data);
    }
    public function report() {
        $this->load->model(['news_model']);
        $this->lang->load('user_lang', $this->session->userdata('site_language'));
        $current_list_ids = $this->input->get('array');
        $type = $this->input->get('type');
        $current_list_ids_exploded = explode(',',$current_list_ids);
        $data['list'] = [
        ];
        foreach($current_list_ids_exploded as $key=>$value){
            $news_info = $this->news_model->get_news_subscribed_info_by_id($value);
            $data['list'][] = [
                $news_info->news_subscriber_email,$news_info->news_subscriber_status,$news_info->news_subscriber_added_date
            ];
        }
        if($type == 'pdf') {
            
            $this->load->library('tc_pdf');
            $pdf = $this->tc_pdf->pdf;
    
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Sugarbabe deluxe');
            $pdf->SetTitle('Report');
            $pdf->SetSubject('Purchase Report');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);         
            // add a page
            $pdf->AddPage();
            $report_html = $this->load->view('admin/news/report_pdf', $data, true);
            $pdf->writeHTML($report_html, true, false, true, false, '');

            $filename = 'Purchase_report_'.date('Ymd').'.pdf';
            $pdf->Output($filename, 'D');
            exit;
        } else if($type == 'csv') {
           // file name
           $filename = 'report_'.date('Ymd').'.csv';
           header("Content-Description: File Transfer"); 
           header("Content-Disposition: attachment; filename=$filename"); 
           header("Content-Type: application/csv; ");

           // file creation 
           $file = fopen('php://output', 'w');
         
           $header = array($this->lang->line('email_address'),$this->lang->line('status'),$this->lang->line('date')); 
           fputcsv($file, $header);

            if($data['list']) {
                foreach ($data['list'] as $row){ 
                    // $line = array($row['news_subscriber_email'], $this->lang->line($row['news_subscriber_status']), convert_date_to_local($row['news_subscriber_added_date'], SITE_DATETIME_FORMAT));
                    fputcsv($file, $row); 
                }
            }

           fclose($file); 
           exit;
        }
    }
    public function remove_email($email_id) {
        $this->load->model(['news_model']);
        $this->news_model->remove_individual_email($email_id);
        redirect(base_url('admin/news'));
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
