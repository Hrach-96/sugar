<?php
class Unlock_request_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';	
	private $table_user_unlock_requests = 'tbl_user_unlock_requests';
	private $table_user_unlock_requests_k = 'tbl_user_unlock_requests urq';
	private $table_user_photo_k = 'tbl_user_photos up';

	public function get_user_unlocked_request_info($request_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('unlock_request_id', $request_id);		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_unlocked_photo_list($user_id, $member_id) {
		$this->db->select("unlock_user_image_id");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('((unlock_request_sender_id='.$user_id.' and unlock_request_receiver_id='.$member_id.') or (unlock_request_sender_id='.$member_id.' and unlock_request_receiver_id='.$user_id.'))');
		$this->db->where('unlock_request_type', 'images_request');
		$this->db->where('unlock_request_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_users_unlocked_request_list($user_id, $status, $filter_type=FALSE, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests_k);
		$this->db->join($this->table_user, 'urq.unlock_request_sender_id = u.user_id');
		$this->db->join($this->table_user_info, 'urq.unlock_request_sender_id = ui.user_id_ref', 'left');
		$this->db->join($this->table_user_photo_k, 'up.photo_id = urq.unlock_user_image_id', 'left');
		$this->db->where('u.user_status', 'active');
		if($filter_type != FALSE) { 
			$this->db->where('urq.unlock_request_type', $filter_type);
		}
		$this->db->where('urq.unlock_request_status', $status);
		$this->db->where('urq.unlock_request_receiver_id', $user_id);
        $this->db->order_by('urq.unlock_request_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_users_unlocked_request_list($user_id, $status, $filter_type=FALSE) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests_k);
		$this->db->join($this->table_user, 'urq.unlock_request_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		if($filter_type != FALSE) { 
			$this->db->where('urq.unlock_request_type', $filter_type);
		}
		$this->db->where('urq.unlock_request_status', $status);
		$this->db->where('urq.unlock_request_receiver_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function is_already_request_sent($user_id, $member_id, $request_type, $picture_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('unlock_request_sender_id', $user_id);
		$this->db->where('unlock_request_receiver_id', $member_id);
		$this->db->where('unlock_request_type', $request_type);
		$this->db->where('unlock_user_image_id', $picture_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_already_chat_request_sent($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('unlock_request_sender_id', $user_id);
		$this->db->where('unlock_request_receiver_id', $member_id);
		$this->db->where('unlock_request_type', 'chat_request');
		$this->db->where('unlock_request_status', 'open');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_already_request_unlocked($user_id, $member_id, $request_type, $picture_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('((unlock_request_sender_id='.$user_id.' and unlock_request_receiver_id='.$member_id.') or (unlock_request_sender_id='.$member_id.' and unlock_request_receiver_id='.$user_id.'))');
		// $this->db->where('unlock_request_sender_id', $user_id);
		// $this->db->where('unlock_request_receiver_id', $member_id);
		$this->db->where('unlock_request_type', $request_type);
		$this->db->where('unlock_user_image_id', $picture_id);
		$this->db->where('unlock_request_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_already_chat_unlocked($user_id, $member_id, $upto_date) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('((unlock_request_sender_id='.$user_id.' and unlock_request_receiver_id='.$member_id.') or (unlock_request_sender_id='.$member_id.' and unlock_request_receiver_id='.$user_id.'))');
		$this->db->where('unlock_request_type', 'chat_request');
		$this->db->where('unlock_request_status', 'active');
		$this->db->where("unlock_request_activated_date >= '".$upto_date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_unlock_request($data) {
        $return = $this->db->insert($this->table_user_unlock_requests, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_all_user_unlock_requests($user_id) {
		$this->db->where("unlock_request_sender_id", $user_id);
		$this->db->or_where("unlock_request_receiver_id", $user_id);
        $this->db->delete($this->table_user_unlock_requests);

        return $this->db->affected_rows();
	}	

	public function delete_user_request_by_unlock_id($unlock_id) {
		$this->db->where("unlock_request_id", $unlock_id);
        $this->db->delete($this->table_user_unlock_requests);

        return $this->db->affected_rows();
	}	

	public function update_unlock_request($unlock_id, $data) {
		$this->db->where('unlock_request_id', $unlock_id);
        $this->db->update($this->table_user_unlock_requests, $data);

        return $this->db->affected_rows();
	}

	public function uncompleted_image_request_counts($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests);
		$this->db->where('unlock_request_sender_id', $user_id);
		$this->db->where('unlock_request_receiver_id', $member_id);
		$this->db->where('unlock_request_type', 'images_request');
		$this->db->where('unlock_request_status', 'open');

		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}	

	public function count_last_unlocks_to_users_afterdate($user_id, $date) {
		$this->db->select("*");
		$this->db->from($this->table_user_unlock_requests_k);
		$this->db->join($this->table_user, 'urq.unlock_request_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('urq.unlock_request_status', 'open');
		$this->db->where('urq.unlock_request_receiver_id', $user_id);
		$this->db->where("urq.unlock_request_date >= '".$date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_new_unseen_unlocks_to_users($user_id) {
		$this->db->from($this->table_user_unlock_requests_k);
		$this->db->join($this->table_user, 'urq.unlock_request_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('urq.unlock_request_status', 'open');
		$this->db->where('urq.unlock_request_receiver_id', $user_id);
		$this->db->where('urq.unlock_request_viewed', 'no');

		return $this->db->count_all_results();
	}

	public function update_unseen_as_seen_to_user($user_id) {
		$this->db->where('unlock_request_viewed', 'no');
		$this->db->where('unlock_request_receiver_id', $user_id);
		$this->db->set('unlock_request_viewed', 'yes');
        $this->db->update($this->table_user_unlock_requests);

        return $this->db->affected_rows();
	}


}