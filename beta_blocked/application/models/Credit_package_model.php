<?php
class Credit_package_model extends CI_Model
{
	private $table_credit_package = 'tbl_credit_packages';
	private $table_user_buy_credits = 'tbl_user_buy_credits';
	private $table_user_buy_credits_k = 'tbl_user_buy_credits uc';
	private $table_users_k = 'tbl_users u';
	private $table_user_credits_used = 'tbl_user_credits_used';

	public function get_total_collected_amount() {
		$this->db->select("sum(credit_package_amount) as total");
		$this->db->from($this->table_user_buy_credits);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('total');
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function get_buy_credit_package_list_for_user($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_credits_k);
		$this->db->where('uc.purchased_user_id', $user_id);
		$this->db->order_by('uc.buy_credit_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_all_user_buy_credit_package_list($start_date = '', $end_date = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_credits_k);
		$this->db->join($this->table_users_k, "uc.purchased_user_id=u.user_id");
		if($start_date != '' && $end_date != '') {
			$this->db->where('uc.buy_credit_date >=', $start_date);
			$this->db->where('uc.buy_credit_date <=', $end_date);
		}
		$this->db->order_by('uc.buy_credit_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_buy_credit_package_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_credits_k);
		$this->db->join($this->table_users_k, "uc.purchased_user_id=u.user_id");
		$this->db->order_by('uc.buy_credit_id', 'desc');
		$this->db->limit($per_page, $offset);		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_user_buy_credit_package_list() {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_credits_k);
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
		$this->db->from($this->table_credit_package);
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

	public function get_active_credit_package_list($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_credit_package);
		$this->db->where('package_status', 'active');
		$this->db->limit($per_page, $offset);
		$this->db->order_by('package_credits', 'asc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_all_credit_package_list() {
		$this->db->select("*");
		$this->db->from($this->table_credit_package);
		$this->db->where('package_status !=', 'deleted');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_credit_package_info($package_id) {
		$this->db->select("*");
		$this->db->where('package_id', $package_id);
		$this->db->from($this->table_credit_package);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_free_credit_package_info() {
		$this->db->select("*");
		$this->db->where('package_amount', 0);
		$this->db->from($this->table_credit_package);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function update_credit_package($package_id, $data)  {
		$this->db->where('package_id', $package_id);
		$this->db->update($this->table_credit_package, $data);
		
		return $this->db->affected_rows();
	}	

	public function insert_credit_package($data) {
        $return = $this->db->insert($this->table_credit_package, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function insert_user_buy_credits($data) {
        $return = $this->db->insert($this->table_user_buy_credits, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}	

	public function insert_user_credits_used($data) {
        $return = $this->db->insert($this->table_user_credits_used, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}	

	public function delete_user_credits_used($user_id) {
		$this->db->where("credits_used_by", $user_id);
        $this->db->delete($this->table_user_credits_used);

        return $this->db->affected_rows();
	}	

}