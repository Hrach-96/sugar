<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checks extends CI_Controller {

    function __construct() {
    	parent::__construct();
    	if($this->session->userdata('user_type') != 'admin') {
    		redirect(base_url());
    	}
    }

	public function index() {
    	$data = array();

	    $this->load->model(['document_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

		$data["reality_doc_count"] = $this->document_model->count_all_reality_documents_as_per_status();
		$data["asset_doc_count"] = $this->document_model->count_all_asset_documents_as_per_status();

		// get_first_old_approvals
		$data["reality_documents"] =  $this->document_model->get_all_reality_documents_list(5, 0);
		$data["asset_documents"] = $this->document_model->get_all_asset_documents_list(5, 0);

		$this->load->view('admin/checks/view', $data);
	}

	public function reality() {
    	$data = array();
    	$this->load->helper('form');

	    $this->load->model(['document_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $search_by_status = '';
        if($this->input->get('status') != '') {
            $search_by_status = $this->input->get('status');
        }

        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
		$data["documents"] = $this->document_model->get_all_reality_documents_list($per_page, $offset, $search_by_status);

		if($data["documents"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/checks/reality'));
			}
		}

		$data["offset"] = $offset;
		$total_approvals = $this->document_model->count_all_reality_documents_list($search_by_status);

		if($search_by_status != '') {
			$url = base_url().'admin/checks/reality?status='.$search_by_status;
        } else {
        	$url = base_url().'admin/checks/reality';
        }        
       	$this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_approvals, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/checks/reality', $data);
	}


	public function asset() {
    	$data = array();
    	$this->load->helper('form');

	    $this->load->model(['document_model']);
		$settings = $this->session->userdata('site_setting');
		$this->lang->load('user_lang', $this->session->userdata('site_language'));

		$data["settings"] = $settings;
		$data["title"] = $settings["site_name"] . " - " . $settings["site_tagline"];

        $search_by_status = '';
        if($this->input->get('status') != '') {
            $search_by_status = $this->input->get('status');
        }

        $per_page = 10;
        $page_no = 0;
        if(isset($_GET['per_page'])) {
            $page_no = $_GET['per_page'] - 1;
        }
        $offset = $page_no * $per_page;
		$data["documents"] = $this->document_model->get_all_asset_documents_list($per_page, $offset, $search_by_status);

		if($data["documents"] == false) {
			if(isset($_GET['per_page']) && $_GET['per_page'] > 1) {
				redirect(base_url('admin/checks/asset'));
			}
		}

		$data["offset"] = $offset;
		$total_approvals = $this->document_model->count_all_asset_documents_list($search_by_status);

		if($search_by_status != '') {
			$url = base_url().'admin/checks/asset?status='.$search_by_status;
        } else {
        	$url = base_url().'admin/checks/asset';
        }        
       	$this->load->library("pagination");
        $config = pagination_config($url, $per_page, $total_approvals, 4);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

		$this->load->view('admin/checks/asset', $data);
	}

	public function approve_reality_document() {
		$this->load->model(['document_model', 'user_model', 'email_model']);

		$document_id = $this->input->post('document_id');
		$document_status = $this->input->post('document_status');
		$user_id = $this->session->userdata('user_id');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$req_info = $this->document_model->get_document_info($document_id);

		if($req_info) {
			if($req_info['document_status'] == 'pending') {
				$user_verified_status = ($document_status == 'verified') ? 'yes' : 'no';

				$updateData = array(
					'document_status' => $document_status,
					'document_checked_by' => $user_id,
					'document_checked_date' => gmdate('Y-m-d H:i:s')
				);

				$this->db->trans_begin();
				$this->document_model->update_document($document_id, $updateData);

				if($user_verified_status == 'yes') {
					$userData['user_verified'] = $user_verified_status;
					$this->user_model->update_user($req_info['document_user_id'], $userData);
				}

            	if($this->db->trans_status() === FALSE) {
                	$this->db->trans_rollback();
					$response['status'] = false;
					$response['errorCode'] = 2;
					$response['message'] = $this->lang->line('internal_server_error');
            	} else {
                	$this->db->trans_commit();
					$response['status'] = true;
					$response['data'] = $this->lang->line($document_status);
					$response['userStatus'] = $this->lang->line($user_verified_status);
                }
			} else {
				$response['status'] = false;
				$response['errorCode'] = 1;
				$response['message'] = $this->lang->line('already_verified');
				$response['requestStatus'] = $req_info['document_status'];
				$response['requestStatusMsg'] = $this->lang->line($req_info['document_status']);
			}
		} else {
			$response['status'] = false;
			$response['errorCode'] = 3;
			$response['message'] = $this->lang->line('unauthorized_access');
		}

		header('Content-Type: application/json');
		echo json_encode($response);		
	}

	public function approve_asset_document() {
		$this->load->model(['document_model', 'email_model']);

		$document_id = $this->input->post('document_id');
		$document_status = $this->input->post('document_status');
		$user_id = $this->session->userdata('user_id');

        $this->lang->load('user_lang', $this->session->userdata('site_language'));
		
		$req_info = $this->document_model->get_document_info($document_id);

		if($req_info) {
			if($req_info['document_status'] == 'pending') {
				$user_verified_status = ($document_status == 'verified') ? 'yes' : 'no';

				$updateData = array(
					'document_status' => $document_status,
					'document_checked_by' => $user_id,
					'document_checked_date' => gmdate('Y-m-d H:i:s')
				);

				$this->db->trans_begin();
				$this->document_model->update_document($document_id, $updateData);

				if($user_verified_status == 'yes') {
					$userData['user_verified'] = $user_verified_status;
					$this->user_model->update_user($req_info['document_user_id'], $userData);
				}
				
            	if($this->db->trans_status() === FALSE) {
                	$this->db->trans_rollback();
					$response['status'] = false;
					$response['errorCode'] = 2;
					$response['message'] = $this->lang->line('internal_server_error');
            	} else {
                	$this->db->trans_commit();
					$response['status'] = true;
					$response['data'] = $this->lang->line($document_status);
                }
			} else {
				$response['status'] = false;
				$response['errorCode'] = 1;
				$response['message'] = $this->lang->line('already_verified');
				$response['requestStatus'] = $req_info['document_status'];
				$response['requestStatusMsg'] = $this->lang->line($req_info['document_status']);
			}
		} else {
			$response['status'] = false;
			$response['errorCode'] = 3;
			$response['message'] = $this->lang->line('unauthorized_access');
		}

		header('Content-Type: application/json');
		echo json_encode($response);		
	}


}
