<?php
class Interest_model extends CI_Model
{
	private $table_interests = 'tbl_interests';
	private $table_user_interests = 'tbl_user_interests';
	private $table_interests_k = 'tbl_interests i';
	private $table_user_interests_k = 'tbl_user_interests ui';

	public function get_active_interest_list() {
		$this->db->select("*");
		$this->db->from($this->table_interests);
		$this->db->where('interest_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_interest_list($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_interests_k);
		$this->db->join($this->table_interests_k, 'ui.interest_id_ref = i.interest_id');
		$this->db->where('ui.interest_user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function insert_user_interest($data) {
        $return = $this->db->insert($this->table_user_interests, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_from_user_interest($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_interests);

        return $this->db->affected_rows();
	}

	public function delete_removed_user_interests($user_id, $interest_arr) {
		$this->db->where('interest_user_id', $user_id);
		$this->db->where_not_in('interest_id_ref', $interest_arr, false);
        $this->db->delete($this->table_user_interests);

        return $this->db->affected_rows();
	}	

	public function delete_all_user_interests($user_id) {
		$this->db->where('interest_user_id', $user_id);
        $this->db->delete($this->table_user_interests);

        return $this->db->affected_rows();
	}

	public function is_already_present($user_id, $interest_id) {
		$this->db->from($this->table_user_interests);
		$this->db->where('interest_user_id', $user_id);
		$this->db->where('interest_id_ref', $interest_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}
}