<?php
class Country_model extends CI_Model
{
	private $table_countries = 'tbl_countries';
	private $table_countries_k = 'tbl_countries c';
	private $table_languages = 'tbl_languages l';

	public function get_all_countries_list() {
		$this->db->select("*");
		$this->db->from($this->table_countries_k);
		$this->db->join($this->table_languages, 'c.country_language=l.language_id');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_countries_list() {
		$this->db->select("*");
		$this->db->from($this->table_countries);
		$this->db->where('country_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_country_info_by_abbr($country_abbr) {
		$this->db->select("*");
		$this->db->from($this->table_countries_k);		
		$this->db->join($this->table_languages, 'c.country_language=l.language_id');
		$this->db->where('c.country_abbr', $country_abbr);
		$this->db->where('c.country_status', 'active');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

}