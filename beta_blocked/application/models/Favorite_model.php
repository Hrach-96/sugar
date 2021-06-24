<?php
class Favorite_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';
	private $table_user_favorites = 'tbl_user_favorites uf';
	private $table_user_favorites_k = 'tbl_user_favorites';

	public function get_active_by_me_favorites_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_favorites);
		$this->db->join($this->table_user, 'uf.user_favorite_to_id = u.user_id');
		$this->db->join($this->table_user_info, 'uf.user_favorite_to_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uf.user_favorite_from_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uf.user_favorite_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_by_me_favorites_count($user_id) {
		$this->db->from($this->table_user_favorites);
		$this->db->join($this->table_user, 'uf.user_favorite_to_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uf.user_favorite_from_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function get_active_to_me_favorites_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_favorites);
		$this->db->join($this->table_user, 'uf.user_favorite_from_id = u.user_id');
		$this->db->join($this->table_user_info, 'uf.user_favorite_from_id=ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uf.user_favorite_to_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uf.user_favorite_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_to_me_favorites_count($user_id) {
		$this->db->from($this->table_user_favorites);
		$this->db->join($this->table_user, 'uf.user_favorite_from_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uf.user_favorite_to_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function is_favorite_member($user_id, $member_id) {
		$this->db->from($this->table_user_favorites);
		$this->db->where('uf.user_favorite_from_id', $user_id);
		$this->db->where('uf.user_favorite_to_id', $member_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

	public function insert_user_favorite($data) {
        $return = $this->db->insert($this->table_user_favorites_k, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_from_favorite($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_favorites_k);

        return $this->db->affected_rows();
	}

	public function delete_all_user_favorites($user_id) {
		$this->db->where("user_favorite_from_id", $user_id);
		$this->db->or_where("user_favorite_to_id", $user_id);
        $this->db->delete($this->table_user_favorites_k);

        return $this->db->affected_rows();
	}	

	public function count_last_favorite_to_users_afterdate($user_id, $date) {
		$this->db->from($this->table_user_favorites);
		$this->db->join($this->table_user, 'uf.user_favorite_from_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uf.user_favorite_to_id', $user_id);
		$this->db->where("uf.user_favorite_added_date >= '".$date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function count_new_unseen_favorites_to_user($user_id) {
		$this->db->from($this->table_user_favorites);
		$this->db->join($this->table_user, 'uf.user_favorite_from_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uf.user_favorite_to_id', $user_id);
		$this->db->where('uf.user_favorite_viewed', 'no');

		return $this->db->count_all_results();
    }

	public function update_unseen_as_seen_to_user($user_id) {
		$this->db->where('user_favorite_viewed', 'no');
		$this->db->where('user_favorite_to_id', $user_id);
		$this->db->set('user_favorite_viewed', 'yes');
		$this->db->update($this->table_user_favorites_k);
    
        return $this->db->affected_rows();
	}
	
}