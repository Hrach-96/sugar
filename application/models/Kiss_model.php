<?php
class Kiss_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';
	private $table_user_kisses = 'tbl_user_kisses uk';
	private $table_user_kisses_k = 'tbl_user_kisses';

	public function get_active_received_kisses_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_kisses);
		$this->db->join($this->table_user, 'uk.kiss_sender_id = u.user_id');
		$this->db->join($this->table_user_info, 'uk.kiss_sender_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uk.kiss_receiver_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uk.user_kiss_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_received_kisses_count($user_id) {
		$this->db->from($this->table_user_kisses);
		$this->db->join($this->table_user, 'uk.kiss_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uk.kiss_receiver_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function get_active_sent_kisses_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_kisses);
		$this->db->join($this->table_user, 'uk.kiss_receiver_id = u.user_id');
		$this->db->join($this->table_user_info, 'uk.kiss_receiver_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uk.kiss_sender_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uk.user_kiss_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_sent_kisses_count($user_id) {
		$this->db->from($this->table_user_kisses);
		$this->db->join($this->table_user, 'uk.kiss_receiver_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uk.kiss_sender_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function is_member_kissed($user_id, $member_id) {
		$this->db->from($this->table_user_kisses);
		$this->db->where('uk.kiss_sender_id', $user_id);
		$this->db->where('uk.kiss_receiver_id', $member_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

	public function insert_user_kiss($data) {
        $return = $this->db->insert($this->table_user_kisses_k, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_kisses($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_kisses_k);

        return $this->db->affected_rows();
	}

	public function delete_all_user_kisses($user_id) {
		$this->db->where("kiss_sender_id", $user_id);
		$this->db->or_where("kiss_receiver_id", $user_id);
        $this->db->delete($this->table_user_kisses_k);

        return $this->db->affected_rows();
	}

	public function count_last_kisses_sent_to_users_afterdate($user_id, $date) {
		$this->db->from($this->table_user_kisses);
		$this->db->join($this->table_user, 'uk.kiss_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uk.kiss_receiver_id', $user_id);
		$this->db->where("uk.kiss_added_date >= '".$date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function count_new_unseen_kisses_sent_to_user($user_id) {
		$this->db->from($this->table_user_kisses);
		$this->db->join($this->table_user, 'uk.kiss_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uk.kiss_receiver_id', $user_id);
		$this->db->where('uk.kiss_user_viewed', 'no');
		
		return $this->db->count_all_results();
    }

	public function update_unseen_as_seen_to_user($user_id) {
		$this->db->where('kiss_user_viewed', 'no');
		$this->db->where('kiss_receiver_id', $user_id);
		$this->db->set('kiss_user_viewed', 'yes');
		$this->db->update($this->table_user_kisses_k);
    
        return $this->db->affected_rows();
	}

}