<?php
class Visitor_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';
	private $table_user_visitor = 'tbl_user_profile_visitors uv';
	private $table_user_visitor_t = 'tbl_user_profile_visitors';

	public function get_active_visitors_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_visitor);
		$this->db->join($this->table_user, 'uv.profile_visitor_id = u.user_id');
		$this->db->join($this->table_user_info, 'uv.profile_visitor_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uv.profile_visited_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uv.user_profile_visitor_no', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_visitors_count($user_id) {
		$this->db->from($this->table_user_visitor);
		$this->db->join($this->table_user, 'uv.profile_visitor_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uv.profile_visited_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function get_active_profile_visited_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_visitor);
		$this->db->join($this->table_user, 'uv.profile_visited_id = u.user_id');
		$this->db->join($this->table_user_info, 'uv.profile_visited_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uv.profile_visitor_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uv.user_profile_visitor_no', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_profile_visited_count($user_id) {
		$this->db->from($this->table_user_visitor);
		$this->db->join($this->table_user, 'uv.profile_visited_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uv.profile_visitor_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function get_user_profile_visited_info($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_visitor);
		$this->db->where('uv.profile_visitor_id', $user_id);
		$this->db->where('uv.profile_visited_id', $member_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_profile_visitors($data) {
        $return = $this->db->insert($this->table_user_visitor_t, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function update_profile_visitors($where, $data) {
		$this->db->where($where);
		$return = $this->db->update($this->table_user_visitor_t, $data);
		return $return;
	}

	public function delete_all_user_profile_visitors($user_id){
		$this->db->where("profile_visitor_id", $user_id);
		$this->db->or_where("profile_visited_id", $user_id);
		$this->db->delete($this->table_user_visitor_t);
		return $this->db->affected_rows();
	}

	public function count_last_visited_to_users_afterdate($user_id, $date) {		
		$this->db->from($this->table_user_visitor);
		$this->db->join($this->table_user, 'uv.profile_visitor_id = u.user_id');
		$this->db->where("uv.profile_visited_id", $user_id);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where("uv.profile_visited_date >= '".$date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function count_new_unseen_visitors($user_id) {
		$this->db->from($this->table_user_visitor);
		$this->db->join($this->table_user, 'uv.profile_visitor_id = u.user_id');
		$this->db->where("uv.profile_visited_id", $user_id);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('uv.visitor_user_viewed', 'no');
		
		return $this->db->count_all_results();
    }  

	public function update_unseen_as_seen_to_user($user_id) {
		$this->db->where('visitor_user_viewed', 'no');
		$this->db->where('profile_visited_id', $user_id);
		$this->db->set('visitor_user_viewed', 'yes');
		$this->db->update($this->table_user_visitor_t);
    
        return $this->db->affected_rows();
	}      

}