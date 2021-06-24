<?php
class Sport_model extends CI_Model
{
	private $table_sports = 'tbl_sports';
	private $table_user_sports = 'tbl_user_sports';
	private $table_sports_k = 'tbl_sports s';
	private $table_user_sports_k = 'tbl_user_sports us';

	public function get_active_sports_list() {
		$this->db->select("*");
		$this->db->from($this->table_sports);
		$this->db->where('sport_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_sports_list($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_sports_k);
		$this->db->join($this->table_sports_k, 'us.user_sport_ref_id = s.sport_id');
		$this->db->where('us.sport_user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function insert_user_sport($data) {
        $return = $this->db->insert($this->table_user_sports, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_from_user_sport($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_sports);

        return $this->db->affected_rows();
	}

	public function delete_removed_user_sports($user_id, $sport_arr) {
		$this->db->where('sport_user_id', $user_id);
		$this->db->where_not_in('user_sport_ref_id', $sport_arr, false);
        $this->db->delete($this->table_user_sports);

        return $this->db->affected_rows();
	}	

	public function delete_all_user_sports($user_id) {
		$this->db->where('sport_user_id', $user_id);
        $this->db->delete($this->table_user_sports);

        return $this->db->affected_rows();
	}

	public function is_already_present($user_id, $sport_id) {
		$this->db->from($this->table_user_sports);
		$this->db->where('sport_user_id', $user_id);
		$this->db->where('user_sport_ref_id', $sport_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

}