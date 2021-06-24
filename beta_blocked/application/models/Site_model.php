<?php
class site_model extends CI_Model 
{
	private $table = 'tbl_site';

	function get_website_settings() {
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->limit(1);
		
		$query = $this->db->get()->row_array();		 
		return $query;
	}

	function update_site_setting($data)  {
		$this->db->update($this->table, $data);
		
		return $this->db->affected_rows();
	}	

   
}