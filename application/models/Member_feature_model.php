<?php
class Member_feature_model extends CI_Model
{
	private $table_member_feature = 'tbl_member_features';

	public function get_active_feature_list($user_gender, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_member_feature);
		$this->db->where('feature_status', 'active');
		$this->db->where('feature_for', $user_gender);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('feature_id', 'asc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}




}