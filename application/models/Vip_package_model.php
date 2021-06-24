<?php
class Vip_package_model extends CI_Model
{
	private $table_additional_prices_vip = 'tbl_additional_package_prices_vip';
	private $table_vip_package = 'tbl_vip_packages';
	private $table_cancelled_vip_package = 'tbl_vip_cancelled_dates tvcd';
	private $table_user_buy_vip = 'tbl_user_buy_vip';
	private $table_vip_registration_ids = 'tbl_vip_registration_ids';
	private $table_user_buy_vip_k = 'tbl_user_buy_vip uv';
	private $table_users_k = 'tbl_users u';
	private $table_user_info = 'tbl_user_info';
	public function get_max_vip_invoice_number() {
		$this->db->select_max('invoice_number');
		$this->db->from($this->table_user_buy_vip);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_vip_info_via_month_and_gender($month,$gender) {
		$this->db->select("*");
		$this->db->from($this->table_vip_package);
		$this->db->where('package_validity_total_months', $month);
		$this->db->where('package_for', $gender);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_vip_multicurrency($select_lang) {
		$currency = '';
		if($select_lang == 'CH'){
			$currency = 'swiss_franc';
		}
		else if ($select_lang == 'UK'){
			$currency = 'pfund_sterling';
		}
		$this->db->select("*");
		$this->db->from($this->table_additional_prices_vip);
		$this->db->join($this->table_vip_package, 'tbl_vip_packages.package_id = tbl_additional_package_prices_vip.vip_package_id', 'left');
		$this->db->where('currency', $currency);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_user_buy_plans_for_free_credit() {
		
		$today_date = gmdate('Y-m-d');
		$today_day = gmdate('d');

		$this->db->select("*, DATE_ADD(buy_vip_date, INTERVAL package_validity_in_months MONTH) AS expire_date");
		$this->db->from($this->table_user_buy_vip_k);
		$this->db->having('DATE(expire_date) >=', $today_date);
		$this->db->having('DAY(expire_date)', $today_day);
		$this->db->where('uv.package_validity_in_months >', 1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}
	public function get_package_multi_currency($currency_variable,$package_id) {
		$this->db->select("*");
		$this->db->from($this->table_additional_prices_vip);
		$this->db->where('vip_package_id', $package_id);
		$this->db->where('currency', $currency_variable);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_cancel_vip_exist($buy_vip_id) {
		$this->db->select("*");
		$this->db->from($this->table_cancelled_vip_package);
		$this->db->where('buy_vip_id_col', $buy_vip_id);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_package_multicurrency() {
		$this->db->select("*");
		$this->db->from($this->table_additional_prices_vip);
		$this->db->join($this->table_vip_package, 'tbl_vip_packages.package_id = tbl_additional_package_prices_vip.vip_package_id', 'left');
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	public function get_cancel_vip_history($per_page, $offset) {
		
		$this->db->select("*");
		$this->db->from($this->table_cancelled_vip_package);
		$this->db->join($this->table_user_buy_vip, 'tvcd.buy_vip_id_col = tbl_user_buy_vip.buy_vip_id', 'left');
		$this->db->join($this->table_users_k, 'tvcd.user_id = u.user_id', 'left');
		$this->db->join($this->table_user_info, 'u.user_id = tbl_user_info.user_id_ref', 'left');
		$this->db->where('tbl_user_buy_vip.vip_package_amount >', 0);
		$this->db->order_by('tvcd.canceled_date', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}
	public function get_cancel_vip_history_all() {
		
		$this->db->select("*");
		$this->db->from($this->table_cancelled_vip_package);
		$this->db->join($this->table_user_buy_vip, 'tvcd.buy_vip_id_col = tbl_user_buy_vip.buy_vip_id', 'left');
		$this->db->join($this->table_users_k, 'tvcd.user_id = u.user_id', 'left');
		$this->db->join($this->table_user_info, 'u.user_id = tbl_user_info.user_id_ref', 'left');
		$this->db->where('tbl_user_buy_vip.vip_package_amount >', 0);
		$this->db->order_by('tvcd.canceled_date', 'desc');
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}
	public function count_cancel_vip_history_list() {
		$this->db->from($this->table_cancelled_vip_package);
		$this->db->join($this->table_user_buy_vip, 'tvcd.buy_vip_id_col = tbl_user_buy_vip.buy_vip_id', 'left');
		$this->db->where('tbl_user_buy_vip.vip_package_amount >', 0);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}
	public function get_vip_users_for_last_days() {
		$date_17 = new DateTime();
        $date_17->modify("-17 day");
        $day_17_ago = $date_17->format("Y-m-d H:i:s");
		$date_13 = new DateTime();
        $date_13->modify("-13 day");
        $day_13_ago = $date_13->format("Y-m-d H:i:s");
		$this->db->select("*");
		$this->db->where('buy_vip_date >=',$day_17_ago);
		$this->db->where('buy_vip_date <=',$day_13_ago);
		$this->db->from($this->table_user_buy_vip);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

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
		$this->db->order_by('uv.buy_vip_date', 'desc');
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
		$this->db->join($this->table_user_info, "u.user_id=tbl_user_info.user_id_ref");
		$this->db->where('uv.package_activated_using', 'amount');		
		$this->db->order_by('uv.buy_vip_date', 'desc');
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

	public function get_user_buy_vip_package_information($buy_vip_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip);
		$this->db->where('buy_vip_id', $buy_vip_id);
		$this->db->limit(1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}
	public function get_all_vip_bill_for_user($purchased_user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_buy_vip);
		$this->db->join($this->table_users_k, 'tbl_user_buy_vip.purchased_user_id = u.user_id', 'left');
		$this->db->join($this->table_user_info, 'u.user_id = tbl_user_info.user_id_ref', 'left');
		$this->db->join($this->table_cancelled_vip_package, 'tbl_user_buy_vip.buy_vip_id = tvcd.buy_vip_id_col', 'left');
		$this->db->where('purchased_user_id', $purchased_user_id);
		$this->db->where('vip_package_amount >', 0);
		$this->db->order_by('tbl_user_buy_vip.buy_vip_date', 'desc');

		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
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
	public function update_buy_vip_info($buy_vip_id, $data)  {
		$this->db->where('buy_vip_id', $buy_vip_id);
		$this->db->update($this->table_user_buy_vip, $data);
		
		return $this->db->affected_rows();
	}
	public function update_cancel_vip_package($id, $data)  {
		$this->db->where('id', $id);
		$this->db->update($this->table_cancelled_vip_package, $data);
		
		return $this->db->affected_rows();
	}
	public function update_multicurrency_vip($data)  {
		$dataUp = [
			1 => $data['value_for_1'],
			2 => $data['value_for_2'],
			3 => $data['value_for_3'],
			4 => $data['value_for_4'],
			5 => $data['value_for_5'],
			6 => $data['value_for_6'],
			7 => $data['value_for_7'],
			8 => $data['value_for_8'],
			9 => $data['value_for_9'],
			10 => $data['value_for_10'],
			11 => $data['value_for_11'],
			12 => $data['value_for_12'],
			13 => $data['value_for_13'],
			14 => $data['value_for_14'],
			15 => $data['value_for_15'],
			16 => $data['value_for_16'],
		];
		for($i = 1 ; $i <= count($data) ; $i++){
			$this->db->where('id', $i);
			$this->db->update($this->table_additional_prices_vip, ['value' => $dataUp[$i]]);
		}
		return true;
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
	public function update_user_buy_vip($data,$id) {
        $this->db->where('buy_vip_id', $id);
		$this->db->update($this->table_user_buy_vip, $data);
		return $this->db->affected_rows();
	}
	public function insert_user_buy_vip_registration($data) {
        $return = $this->db->insert($this->table_vip_registration_ids, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function getRegistrationInfo($buy_vip_id) {
		$this->db->select("*");
		$this->db->where('buy_vip_id', $buy_vip_id);
		$this->db->from($this->table_vip_registration_ids);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = false;
		}
		return $res;
	}

	public function getStripeSubscribers() {
		$this->db->select("*");
		$this->db->where('repeated !=','1');
		$this->db->where('payment_stripe_id is NOT NULL', NULL, FALSE);
		$this->db->from($this->table_user_buy_vip);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}
	public function getLastSubscribers($startDate) {
		$this->db->select("*");
		$this->db->where('buy_vip_date >=', $startDate);
		$this->db->where('buy_vip_date >=', '2020-07-07');
		$this->db->where('repeated !=','1');
		$this->db->from($this->table_user_buy_vip);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

}