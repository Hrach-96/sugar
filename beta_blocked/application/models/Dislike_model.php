<?php
class Dislike_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';
	private $table_user_dislike = 'tbl_user_dislike';
	private $table_user_dislike_k = 'tbl_user_dislike ud';

	public function get_active_users_disliked_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_dislike_k);
		$this->db->join($this->table_user, 'ud.dislike_to_user_id = u.user_id');
		$this->db->join($this->table_user_info, 'ud.dislike_to_user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('ud.dislike_from_user_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('ud.dislike_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_users_disliked_count($user_id) {
		$this->db->from($this->table_user_dislike_k);
		$this->db->join($this->table_user, 'ud.dislike_to_user_id = u.user_id');
		$this->db->join($this->table_user_info, 'ud.dislike_to_user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('ud.dislike_from_user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function is_member_disliked($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_dislike);
		$this->db->where('dislike_from_user_id', $user_id);
		$this->db->where('dislike_to_user_id', $member_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_dislike($data) {
        $return = $this->db->insert($this->table_user_dislike, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function unblock_user($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_dislike);

        return $this->db->affected_rows();
	}

	public function delete_all_user_dislikes($user_id) {
		$this->db->where("dislike_from_user_id", $user_id);
		$this->db->or_where("dislike_to_user_id", $user_id);
        $this->db->delete($this->table_user_dislike);

        return $this->db->affected_rows();
	}	
	
}