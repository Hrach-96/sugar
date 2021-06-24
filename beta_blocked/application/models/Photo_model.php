<?php
class Photo_model extends CI_Model
{
	private $table_user_photos = 'tbl_user_photos';
	private $table_user_photos_k = 'tbl_user_photos up';
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';	

	public function get_approval_photos_list_for_agent($accessed_records_str) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos_k);
		$this->db->join($this->table_user, 'up.photo_user_id_ref = u.user_id');
		$this->db->join($this->table_user_info, 'up.photo_user_id_ref = ui.user_id_ref', 'left');
		$this->db->where('up.photo_status', 'inactive');
		if($accessed_records_str != '')
			$this->db->where($accessed_records_str, NULL, false);
		$this->db->order_by('up.photo_id', 'desc');
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

		$this->db->from($this->table_user_photos);
		$this->db->where('photo_checked_by', $agent_id);
		$this->db->like('photo_checked_date', $today_date, 'both');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_total_agent_approvals($agent_id) {
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_checked_by', $agent_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_user_photo_as_per_status() {
		$SQL = "SELECT count(*) as total, count(CASE WHEN `photo_status` ='active' THEN 1 END) as approved, count(CASE WHEN `photo_status` ='inactive' THEN 1 END) as pending, count(CASE WHEN `photo_status` ='blocked' THEN 1 END) as rejected, count(CASE WHEN `photo_status` ='deleted' THEN 1 END) as deleted FROM `tbl_user_photos`";

		$Q = $this->db->query($SQL);

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function count_user_photo_list($search_by_status = '', $profile_type = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_photos_k);
		if($search_by_status != '')
			$this->db->where('photo_status', $search_by_status);
		if($profile_type != '')
			$this->db->where('up.photo_type', $profile_type);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

	public function get_all_photos_list($per_page, $offset, $search_by_status = '', $profile_type = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_photos_k);
		$this->db->join($this->table_user, 'up.photo_user_id_ref = u.user_id');
		$this->db->join($this->table_user_info, 'up.photo_user_id_ref = ui.user_id_ref', 'left');
		if($search_by_status != '')
			$this->db->where('up.photo_status', $search_by_status);
		if($profile_type != '')
			$this->db->where('up.photo_type', $profile_type);
		$this->db->order_by('up.photo_id', 'desc');
		$this->db->limit($per_page, $offset);

		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_all_photos_list($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_status !=', 'deleted');
		$this->db->where('photo_user_id_ref', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_pending_profile_picture_for_user($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_status', 'pending');
		$this->db->where('photo_type', 'profile');
		$this->db->where('photo_user_id_ref', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_photo_info($user_id, $photo_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('photo_id', $photo_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_profile_pic($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('is_profile_photo', 'yes');
		$this->db->where('photo_status !=', 'deleted');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_photo($data) {
        $return = $this->db->insert($this->table_user_photos, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function remove_as_default_photo($user_id) {
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('is_profile_photo', 'yes');
		$data = array('is_profile_photo' => 'no');
		$this->db->update($this->table_user_photos, $data);

		return $this->db->affected_rows();
	}

	public function remove_user_photo($user_id, $photo_id) {
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('photo_id', $photo_id);
		$data = array('photo_status' => 'deleted');
		$this->db->update($this->table_user_photos, $data);

		return $this->db->affected_rows();
	}

	public function delete_from_user_photo($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_photos);

        return $this->db->affected_rows();
	}

	public function delete_all_user_photos($user_id) {
		$this->db->where('photo_user_id_ref', $user_id);
        $this->db->delete($this->table_user_photos);

        return $this->db->affected_rows();
	}

	public function is_user_picture($user_id, $photo_id) {
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('photo_id', $photo_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

	public function update_user_photo_status($user_id, $photo_id, $status) {
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('photo_id', $photo_id);
		$data = array('photo_type' => $status);
		$this->db->update($this->table_user_photos, $data);

		return $this->db->affected_rows();
	}

	public function update_as_default_photo_info($user_id, $photo_id) {
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('photo_id', $photo_id);
		$data = array('is_profile_photo' => 'yes');
		$this->db->update($this->table_user_photos, $data);

		return $this->db->affected_rows();
	}

	public function update_photo_info($photo_id, $data) {
		$this->db->where('photo_id', $photo_id);
		$this->db->update($this->table_user_photos, $data);

		return $this->db->affected_rows();
	}

	public function get_photo_info($photo_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_id', $photo_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_photo_count_by_photo_type($user_id, $photo_type) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('photo_status !=', 'deleted');
		$this->db->where('photo_user_id_ref', $user_id);
		$this->db->where('photo_type', $photo_type);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

}