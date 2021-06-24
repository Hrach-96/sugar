<?php
class Contact_request_model extends CI_Model
{
	private $table_contact_requests = 'tbl_contact_requests';
	private $table_user_contact_requests = 'tbl_user_contact_requests';
	private $table_contact_requests_k = 'tbl_contact_requests r';
	private $table_user_contact_requests_k = 'tbl_user_contact_requests ur';

	public function get_active_contact_request_list() {
		$this->db->select("*");
		$this->db->from($this->table_contact_requests);
		$this->db->where('contact_request_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_contact_request_list($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_contact_requests_k);
		$this->db->join($this->table_contact_requests_k, 'ur.contact_request_contact_id = r.contact_request_id');
		$this->db->where('ur.contact_request_user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function insert_user_contact_request($data) {
        $return = $this->db->insert($this->table_user_contact_requests, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_from_user_contact_request($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_contact_requests);

        return $this->db->affected_rows();
	}

	public function delete_removed_user_contact_request($user_id, $user_cont_req_arr_str) {
		$this->db->where('contact_request_user_id', $user_id);
		$this->db->where_not_in('contact_request_contact_id', $user_cont_req_arr_str, false);
        $this->db->delete($this->table_user_contact_requests);

        return $this->db->affected_rows();
	}	
	public function delete_all_user_contact_request($user_id) {
		$this->db->where('contact_request_user_id', $user_id);
        $this->db->delete($this->table_user_contact_requests);

        return $this->db->affected_rows();
	}	

	public function is_already_present($user_id, $contact_req_id) {
		$this->db->from($this->table_user_contact_requests);
		$this->db->where('contact_request_user_id', $user_id);
		$this->db->where('contact_request_contact_id', $contact_req_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}
}