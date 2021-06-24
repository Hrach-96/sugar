<?php
class User_content_model extends CI_Model
{
	private $table_user_content = 'tbl_user_content';
	private $table_user_content_k = 'tbl_user_content uc';
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';

	public function get_approval_content_list_for_agent($accessed_records_str) {
		$this->db->select("*");
		$this->db->from($this->table_user_content_k);
		$this->db->join($this->table_user, 'uc.content_user_id = u.user_id');
		$this->db->join($this->table_user_info, 'uc.content_user_id = ui.user_id_ref', 'left');
		$this->db->where('uc.content_status', 'pending');
		if($accessed_records_str != '')
			$this->db->where($accessed_records_str, NULL, false);
		$this->db->order_by('uc.content_id', 'desc');
		$this->db->limit(AGENT_MAX_READ_RECORDS);

		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;		
	}

	public function count_today_agent_approvals($agent_id) {
		$today_date = date('Y-m-d');

		$this->db->from($this->table_user_content);
		$this->db->where('content_cheked_by', $agent_id);
		$this->db->like('content_cheked_date', $today_date, 'both');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_total_agent_approvals($agent_id) {
		$this->db->from($this->table_user_content);
		$this->db->where('content_cheked_by', $agent_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_user_content_as_per_status() {
		$SQL = "SELECT count(*) as total, count(CASE WHEN `content_status` ='approved' THEN 1 END) as approved, count(CASE WHEN `content_status` ='pending' THEN 1 END) as pending, count(CASE WHEN `content_status` ='rejected' THEN 1 END) as rejected FROM `tbl_user_content`";

		$Q = $this->db->query($SQL);

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}


	public function count_user_content_list($search_by_status = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_content);
		if($search_by_status != '')
			$this->db->where('content_status', $search_by_status);		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

	public function get_user_content_list($per_page, $offset, $search_by_status = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_content_k);
		$this->db->join($this->table_user, 'uc.content_user_id = u.user_id');
		$this->db->join($this->table_user_info, 'uc.content_user_id = ui.user_id_ref', 'left');
		if($search_by_status != '')
			$this->db->where('uc.content_status', $search_by_status);
		$this->db->order_by('uc.content_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_last_added_content($user_id, $content_type) {
		$this->db->select("*");
		$this->db->from($this->table_user_content);
		$this->db->where("content_user_id", $user_id);
		$this->db->where("content_type", $content_type);
		$this->db->order_by('content_id', 'desc');
		$this->db->limit(1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_any_pending_request($user_id, $content_type) {
		$this->db->select("content_id");
		$this->db->from($this->table_user_content);
		$this->db->where("content_user_id", $user_id);
		$this->db->where("content_type", $content_type);
		$this->db->where("content_status", 'pending');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('content_id');
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_request_already_approved($content_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_content);
		$this->db->where("content_id", $content_id);
		$this->db->where("content_status", 'pending');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_request_content_info($content_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_content);
		$this->db->where("content_id", $content_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_content($data) {
        $return = $this->db->insert($this->table_user_content, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function update_user_content($content_id, $data) {
		$this->db->where('content_id', $content_id);
		$this->db->update($this->table_user_content, $data);

		return $this->db->affected_rows();
	}

	public function delete_all_user_content($user_id) {
		$this->db->where("content_user_id", $user_id);
        $this->db->delete($this->table_user_content);

        return $this->db->affected_rows();
	}
		
}