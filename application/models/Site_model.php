<?php
class site_model extends CI_Model 
{
	private $table = 'tbl_site';
	private $table_settings = 'tbl_settings';

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
	function get_settings_by_type($type)  {
		$this->db->select("*");
		$this->db->from($this->table_settings);
		$this->db->where('type', $type);

		$query = $this->db->get()->row_array();		 
		return $query;
	}	
	function update_settings_by_type($type,$data)  {
		$this->db->where('type', $type);
		$this->db->update($this->table_settings, $data);
		
		return $this->db->affected_rows();
	}	

   
}