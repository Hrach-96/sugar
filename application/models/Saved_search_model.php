<?php
class Saved_search_model extends CI_Model
{
	private $table_user_saved_search = 'tbl_user_saved_search';

	public function get_user_saved_search($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_saved_search);
		$this->db->where('saved_search_by_user', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_saved_search($data) {
        $return = $this->db->insert($this->table_user_saved_search, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function is_already_present($user_id) {
		$this->db->from($this->table_user_saved_search);
		$this->db->where('saved_search_by_user', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

	public function delete_user_saved_search($user_id) {
		$this->db->where('saved_search_by_user', $user_id);
        $this->db->delete($this->table_user_saved_search);

        return $this->db->affected_rows();
	}

	public function update_user_saved_search($user_id, $data) {
		$this->db->where('saved_search_by_user', $user_id);
		$this->db->update($this->table_user_saved_search, $data);

		return $this->db->affected_rows();
	}


}