<?php
class Vip_package_model extends CI_Model
{
	private $table_vip_package = 'tbl_vip_packages';
	private $table_user_buy_vip = 'tbl_user_buy_vip';
	private $table_user_buy_vip_k = 'tbl_user_buy_vip uv';
	private $table_users_k = 'tbl_users u';

	public function get_total_collected_amount() {
		$this->db->select("sum(vip_package_amount) as total");
		$this->db->where('package_activated_using', 'amount');
		$this->db->from($this->table_user_buy_vip);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('total');
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function get_buy_vip_package_list_for_user($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip_k);
		$this->db->where('uv.purchased_user_id', $user_id);
		$this->db->where('uv.package_activated_using', 'amount');
		$this->db->order_by('uv.buy_vip_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_all_user_buy_vip_package_list($start_date = '', $end_date = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip_k);
		$this->db->join($this->table_users_k, "uv.purchased_user_id=u.user_id");
		$this->db->where('uv.package_activated_using', 'amount');
		if($start_date != '' && $end_date != '') {
			$this->db->where('uv.buy_vip_date >=', $start_date);
			$this->db->where('uv.buy_vip_date <=', $end_date);
		}
		$this->db->order_by('uv.buy_vip_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_buy_vip_package_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip_k);
		$this->db->join($this->table_users_k, "uv.purchased_user_id=u.user_id");
		$this->db->where('uv.package_activated_using', 'amount');		
		$this->db->order_by('uv.buy_vip_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_user_buy_vip_package_list() {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip_k);
		$this->db->where('uv.package_activated_using', 'amount');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

	public function get_user_buy_vip_package($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip);
		$this->db->where('purchased_user_id', $user_id);
		$this->db->order_by('buy_vip_id', 'desc');
		$this->db->limit(1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_vip_package_list($gender, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_vip_package);
		$this->db->where('package_status', 'active');
		$this->db->where('package_for', $gender);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('package_id', 'asc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_package_info($package_id) {
		$this->db->select("*");
		$this->db->from($this->table_vip_package);
		$this->db->where('package_status', 'active');
		$this->db->where('package_id', $package_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_all_vip_package_list() {
		$this->db->select("*");
		$this->db->from($this->table_vip_package);
		$this->db->where('package_status !=', 'deleted');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_vip_package_info($package_id) {
		$this->db->select("*");
		$this->db->where('package_id', $package_id);
		$this->db->from($this->table_vip_package);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_free_vip_package_info() {
		$this->db->select("*");
		$this->db->where('package_total_amount', 0);
		$this->db->from($this->table_vip_package);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function update_vip_package($package_id, $data)  {
		$this->db->where('package_id', $package_id);
		$this->db->update($this->table_vip_package, $data);
		
		return $this->db->affected_rows();
	}	

	public function insert_vip_package($data) {
        $return = $this->db->insert($this->table_vip_package, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function insert_user_buy_vip($data) {
        $return = $this->db->insert($this->table_user_buy_vip, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}


}