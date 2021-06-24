<?php
class Gift_model extends CI_Model
{
	private $table_gift_info = 'tbl_gift_info';
	private $table_gift_info_tgi = 'tbl_gift_info tgi';
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';

	public function get_gift_vip_users() {
		$this->db->select("*");
		$this->db->from($this->table_gift_info_tgi);
		$this->db->where('type', 'vip');
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_gift_canceled_users() {
		$this->db->select("*");
		$this->db->from($this->table_gift_info_tgi);
		$this->db->join($this->table_user, 'u.user_id = tgi.user_id', 'left');
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('canceled_date IS NOT NULL', null, false);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_history_of_gift($info) {
		$this->db->select("*");
		$this->db->from($this->table_gift_info_tgi);
		$this->db->join($this->table_user, 'u.user_id = tgi.user_id', 'left');
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		if(!empty($info)){
			$this->db->group_start();
			$this->db->like('u.user_access_name', $info);
			$this->db->or_like('u.user_email', $info);
			$this->db->or_like('ui.user_firstname', $info);
			$this->db->or_like('ui.user_lastname', $info);
			$this->db->group_end();
		}
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	// Update gift info table
	public function update_gift_info($id, $data) {		
		$this->db->where('id', $id);
		$this->db->update($this->table_gift_info, $data);
	}
	public function get_added_gift_by_id($id) {
		$this->db->select("*");
		$this->db->from($this->table_gift_info);
		$this->db->where('id',$id);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_gift_canceled_users_like($info) {
		$this->db->select("*");
		$this->db->from($this->table_gift_info_tgi);
		$this->db->join($this->table_user, 'u.user_id = tgi.user_id', 'left');
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('canceled_date IS NOT NULL', null, false);
		$this->db->group_start();
		$this->db->like('u.user_access_name', $info);
		$this->db->or_like('u.user_email', $info);
		$this->db->or_like('ui.user_firstname', $info);
		$this->db->or_like('ui.user_lastname', $info);
		$this->db->group_end();
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function insert_gift_info($data) {
		$this->db->insert($this->table_gift_info, $data);
		return true;
	}
}