<?php
class Diamond_package_model extends CI_Model
{
	private $table_diamond_package = 'tbl_diamond_packages';
	private $table_user_buy_diamonds = 'tbl_user_buy_diamonds';
	private $table_user_diamonds_used = 'tbl_user_diamonds_used';
	private $table_user_buy_diamonds_k = 'tbl_user_buy_diamonds ud';
	private $table_users_k = 'tbl_users u';

	public function get_total_collected_amount() {
		$this->db->select("sum(diamond_package_amount) as total");
		$this->db->from($this->table_user_buy_diamonds);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('total');
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function get_buy_diamond_package_list_for_user($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_diamonds_k);
		$this->db->where('ud.purchased_user_id', $user_id);
		$this->db->order_by('ud.buy_diamond_id', 'desc');
		$this->db->limit($per_page, $offset);		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_all_user_buy_diamond_package_list($start_date = '', $end_date = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_diamonds_k);
		$this->db->join($this->table_users_k, "ud.purchased_user_id=u.user_id");
		if($start_date != '' && $end_date != '') {
			$this->db->where('ud.buy_diamond_date >=', $start_date);
			$this->db->where('ud.buy_diamond_date <=', $end_date);
		}
		$this->db->order_by('ud.buy_diamond_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_buy_diamond_package_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_diamonds_k);
		$this->db->join($this->table_users_k, "ud.purchased_user_id=u.user_id");
		$this->db->order_by('ud.buy_diamond_id', 'desc');
		$this->db->limit($per_page, $offset);		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_user_buy_diamond_package_list() {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_diamonds_k);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

	public function get_active_package_info($package_id) {
		$this->db->select("*");
		$this->db->from($this->table_diamond_package);
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

	public function get_active_diamond_package_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_diamond_package);
		$this->db->where('package_status', 'active');
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

	public function get_all_diamond_package_list() {
		$this->db->select("*");
		$this->db->from($this->table_diamond_package);
		$this->db->where('package_status !=', 'deleted');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_diamond_package_info($package_id) {
		$this->db->select("*");
		$this->db->where('package_id', $package_id);
		$this->db->from($this->table_diamond_package);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function update_diamond_package($package_id, $data)  {
		$this->db->where('package_id', $package_id);
		$this->db->update($this->table_diamond_package, $data);
		
		return $this->db->affected_rows();
	}	

	public function insert_diamond_package($data) {
        $return = $this->db->insert($this->table_diamond_package, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function insert_user_buy_diamonds($data) {
        $return = $this->db->insert($this->table_user_buy_diamonds, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function insert_user_diamonds_used($data) {
        $return = $this->db->insert($this->table_user_diamonds_used, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_user_buy_diamonds($user_id) {
		$this->db->where('purchased_user_id', $user_id);
        $this->db->delete($this->table_user_buy_diamonds);

        return $this->db->affected_rows();
	}

	public function delete_user_diamonds_used($user_id) {
		$this->db->where('diamonds_used_by', $user_id);
        $this->db->delete($this->table_user_diamonds_used);

        return $this->db->affected_rows();
	}

}