<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    function __construct() {
    	parent::__construct();
        if(!$this->session->has_userdata('user_id')) {
            redirect(base_url());
        }
    }

	// web service to add reported member by user
	public function send() {

		$this->load->model(['report_user_model','user_model','email_model']);

		$member_id_enc = $this->input->post('report_member_data');
		$report_reason = $this->input->post('report_reason');
		$other_reason = $this->input->post('other_reason');
		$user_id = $this->session->userdata('user_id');

        $this->load->library('encryption');
        $this->encryption->initialize(array('driver' => ENCRYPTION_DRIVER));
        $member_id = $this->encryption->decrypt($member_id_enc);

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		if($member_id_enc == '' || $report_reason == '') {
			$response['status'] = false;
			$response['errorCode'] = 1;
			$response['message'] = $this->lang->line('internal_server_error');
		} else {
			$alreadyReported = $this->report_user_model->is_member_reported($user_id, $member_id);		

			if($alreadyReported == true) {
				$response['status'] = false;
				$response['errorCode'] = 0;
				$response['message'] = $this->lang->line('already_reported');
			} else {
				$insertData = array(
					'report_from_user_id' => $user_id,
					'report_to_user_id' => $member_id,
					'report_reason_text' => $report_reason,
					'report_user_comment' => $other_reason,
					'report_added_date' => date('Y-m-d H:i:s')
				);
				$success = $this->report_user_model->insert_user_report($insertData);
				if($success > 0){	 
					 $member_info = $this->user_model->get_active_user_information($member_id);
                     $to_email = $member_info['user_email'];
                     $subject = $this->lang->line('profile_reported');
                     $data['user_name'] = $member_info['user_access_name'];
                     $data['user_profile_pic'] = $member_info['user_active_photo'];
                     $data['report_reason'] = $this->lang->line($report_reason);
                     $data['other_reason'] = $other_reason;
                     $data['email_template'] = 'email/report_to_user';
                     $email_message = $this->load->view('templates/email/main', $data, true);
                     $response['errors'] = $this->email_model->sendEMail($to_email, $subject, $email_message);
                     $response['status'] = true;
					 $response['message'] = $this->lang->line('user_has_been_reported_successfully');
                    } else {
                    	$response['status'] = false;
						$response['errorCode'] = 1;
						$response['message'] = $this->lang->line('internal_server_error');
					}
			}
		}

		header("Content-Type: application/json");
		echo json_encode($response);
	}


}
