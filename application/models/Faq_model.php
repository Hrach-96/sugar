<?php
class Faq_model extends CI_Model
{
	private $table_faq = 'tbl_faq';

	public function get_faq_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_faq);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('faq_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_faq_info_by_id($message_id) {
		$this->db->select("*");
		$this->db->from($this->table_faq);
		$this->db->where('faq_id', $message_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_faq_list() {
		$this->db->from($this->table_faq);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function insert_faq_question($data) {
        $return = $this->db->insert($this->table_faq, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function update_faq_message($message_id, $data) {
		$this->db->where('faq_id', $message_id);
		$this->db->update($this->table_faq, $data);

		return $this->db->affected_rows();
	}
	
}