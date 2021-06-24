<?php
class Language_model extends CI_Model
{
	private $table_languages = 'tbl_languages';
	private $table_user_languages = 'tbl_user_spoken_languages';
	private $table_languages_k = 'tbl_languages l';
	private $table_user_languages_k = 'tbl_user_spoken_languages sl';

	public function get_all_language_list() {
		$this->db->select("*");
		$this->db->from($this->table_languages);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_language_info($language_id) {
		$this->db->select("*");
		$this->db->from($this->table_languages);
		$this->db->where('language_id', $language_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_languages_abbr_by_name($language_name) {
		$this->db->select("*");
		$this->db->from($this->table_languages);
		$this->db->where('language_name', $language_name);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('language_abbr');
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_spoken_language_list() {
		$this->db->select("*");
		$this->db->from($this->table_languages);
		$this->db->where('language_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_languages_used_for_site() {
		$this->db->select("*");
		$this->db->from($this->table_languages);
		$this->db->where('language_status', 'active');
		$this->db->where('used_for_website', 'yes');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_spoken_language_list($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_languages_k);
		$this->db->join($this->table_languages_k, 'sl.spoken_language_ref_lang_id = l.language_id');
		$this->db->where('sl.spoken_language_user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function insert_user_spoken_language($data) {
        $return = $this->db->insert($this->table_user_languages, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_from_user_spoken_language($where) {
		$this->db->where($where);
        $this->db->delete($this->table_user_languages);

        return $this->db->affected_rows();
	}

	public function delete_removed_user_languages($user_id, $language_arr) {
		$this->db->where('spoken_language_user_id', $user_id);
		$this->db->where_not_in('spoken_language_ref_lang_id', $language_arr, false);
        $this->db->delete($this->table_user_languages);

        return $this->db->affected_rows();
	}	

	public function delete_all_user_languages($user_id) {
		$this->db->where('spoken_language_user_id', $user_id);
        $this->db->delete($this->table_user_languages);

        return $this->db->affected_rows();
	}

	public function is_already_present($user_id, $language_id) {
		$this->db->from($this->table_user_languages);
		$this->db->where('spoken_language_user_id', $user_id);
		$this->db->where('spoken_language_ref_lang_id', $language_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}
}