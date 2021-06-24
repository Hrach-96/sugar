<?php
class Contact_us_model extends CI_Model
{
	private $table_user_contact_us = 'tbl_contact_us';

	public function get_contact_us_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_contact_us);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('contact_us_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_message_info_by_id($message_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_contact_us);
		$this->db->where('contact_us_id', $message_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_contact_us_list() {
		$this->db->from($this->table_user_contact_us);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function insert_conact_us($data) {
        $return = $this->db->insert($this->table_user_contact_us, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function update_contact_message($message_id, $data) {
		$this->db->where('contact_us_id', $message_id);
		$this->db->update($this->table_user_contact_us, $data);

		return $this->db->affected_rows();
	}
	
}