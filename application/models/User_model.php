<?php
class User_model extends CI_Model
{
	private $table_user_k = 'tbl_users';
	private $table_user = 'tbl_users u';
	private $table_user_info_k = 'tbl_user_info';
	private $table_user_info = 'tbl_user_info ui';
	private $table_user_photos = 'tbl_user_photos up';
	private $table_user_contact_requests = 'tbl_user_contact_requests ucr';
	private $table_user_cancel_vip_date = 'tbl_vip_cancelled_dates';
	private $table_user_c_info = 'tbl_info_user';

	public function get_all_users() {
		$this->db->select("u.user_id, u.user_is_vip, u.user_verified, ui.user_active_photo_thumb, TIMEDIFF(UTC_TIMESTAMP(), u.user_last_activity_date) as last_online_time");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		//$this->db->where('u.user_type', 'user');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}
	public function add_user_information_card($data) {
		$this->db->insert($this->table_user_c_info, $data);
		return true;
	}
	// Get Canceled VIP by buy id
	public function get_cancell_info_by_buy_id($buy_vip_id_col) {
		$this->db->select("*");
		$this->db->from($this->table_user_cancel_vip_date);
		$this->db->where('buy_vip_id_col', $buy_vip_id_col);
		$this->db->order_by('id','desc')->limit(1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = false;
		}
		return $res;
	}
	// Insert user Canceled VIP date
	public function insert_user_canceled_vip_date($data) {
		$this->db->insert($this->table_user_cancel_vip_date, $data);
		return true;
	}
	// Get Canceled VIP date of user
	public function get_canceled_date_of_vip($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_cancel_vip_date);
		$this->db->where('user_id', $user_id);
		$this->db->order_by('id','desc')->limit(1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = false;
		}
		return $res;
	}
	public function get_active_offline_users() {
		$this->db->select("u.user_id, u.user_is_vip, u.user_verified, ui.user_active_photo_thumb, TIMEDIFF(UTC_TIMESTAMP(), u.user_last_activity_date) as last_online_time");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where("u.user_last_activity_date <= date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_CHECK_TIME_FOR_MYSQL.")");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}
		return $res;
	}
	// One Time ( add column to tbl_user table)
	public function add_admin_active_column_to_users_table() {
		$sql='ALTER TABLE tbl_users ADD user_activated_date DATETIME';
    	$query = $this->db->query($sql);
	}
	public function get_all_users_list($per_page, $offset, $search_key = '', $search_gender = '', $search_online = '', $search_country = '', $search_vip = '') {
		$this->db->select("user_id_encrypted, user_id, user_gender, user_access_name, user_active_photo_thumb, user_city, user_country, DATEDIFF( NOW(), user_birthday) / 365.23 as user_age, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, user_status, user_deletion_date");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'user');
		$this->db->order_by("user_register_date",'desc');
		// $this->db->order_by("
		//     (CASE u.user_status
		//         WHEN 'active' THEN 0
		//         WHEN 'pending' THEN 1
		//         WHEN 'inactive' THEN 2
		//         WHEN 'blocked' THEN 3
		//         ELSE 4
		//     END)"
		// );
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		if($search_gender != '') {
			$this->db->where('ui.user_gender', $search_gender);
		}
		if($search_online == 'yes') {
			$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_online == 'no') {
			$this->db->where("u.user_last_activity_date <= date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_country != '') {
			$this->db->like('ui.user_country', $search_country, 'both');
		}
		if($search_vip != '') {
			$this->db->where('u.user_is_vip', $search_vip);
		}		
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}
	public function get_all_users_list_new($per_page, $offset, $search_key = '',$search_email = '', $search_gender = '', $search_online = '', $search_country = '', $search_vip = '') {
		
		$this->db->select("user_id_encrypted, user_id, user_gender, user_access_name, user_active_photo_thumb, user_city, user_country, DATEDIFF( NOW(), user_birthday) / 365.23 as user_age, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, user_status, user_deletion_date");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'user');
		$this->db->order_by("user_register_date",'desc');
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		if($search_email != '') {
			$this->db->like('u.user_email', $search_email, 'both');
		}
		if($search_gender != '') {
			$this->db->where('ui.user_gender', $search_gender);
		}
		if($search_online == 'yes') {
			$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_online == 'no') {
			$this->db->where("u.user_last_activity_date <= date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_country != '') {
			$this->db->like('ui.user_country', $search_country, 'both');
		}
		if($search_vip != '') {
			$this->db->where('u.user_is_vip', $search_vip);
		}		
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_all_users($search_key = '', $search_gender = '', $search_online = '', $search_country = '', $search_vip = '') {
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'user');
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		if($search_gender != '') {
			$this->db->where('ui.user_gender', $search_gender);
		}
		if($search_online == 'yes') {
			$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_online == 'no') {
			$this->db->where("u.user_last_activity_date <= date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_country != '') {
			$this->db->like('ui.user_country', $search_country, 'both');
		}
		if($search_vip != '') {
			$this->db->where('u.user_is_vip', $search_vip);
		}
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}
	public function count_all_users_new($search_key = '',$search_email = '', $search_gender = '', $search_online = '', $search_country = '', $search_vip = '') {
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'user');
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		if($search_email != '') {
			$this->db->like('u.user_email', $search_email, 'both');
		}
		if($search_gender != '') {
			$this->db->where('ui.user_gender', $search_gender);
		}
		if($search_online == 'yes') {
			$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_online == 'no') {
			$this->db->where("u.user_last_activity_date <= date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_REAL_TIME_FOR_MYSQL.")");
		}
		if($search_country != '') {
			$this->db->like('ui.user_country', $search_country, 'both');
		}
		if($search_vip != '') {
			$this->db->where('u.user_is_vip', $search_vip);
		}
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function get_all_agents_list($per_page, $offset, $search_key = '') {
		$this->db->select("user_id_encrypted, user_id, user_gender, user_access_name, user_active_photo_thumb, user_city, user_email, user_birthday, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, user_status");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'agent');
		$this->db->order_by('u.user_id', 'desc');
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_all_agents($search_key = '') {
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'agent');
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_today_registered_users() {
		$today_date = date('Y-m-d');

		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'user');
		$this->db->like('u.user_register_date', $today_date, 'both');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	// Update the last activity date
	public function update_last_message_typing_activity($user_id, $member_id) {
		$this->db->where("user_id", $user_id);
		$this->db->set('user_last_message_typing_date', 'UTC_TIMESTAMP()', false);
		$this->db->set('last_message_typing_user_id', $member_id);
		$this->db->update($this->table_user);

		return $this->db->affected_rows();
	}

	public function is_user_typing_message_activity($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->where('u.user_id', $member_id);
		$this->db->where('u.last_message_typing_user_id', $user_id);
		$this->db->where("u.user_last_message_typing_date > date_sub(UTC_TIMESTAMP(), ".USER_MESSAGE_TYPING_CHECK_TIME_FOR_MYSQL.")");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_active_online_users($user_id, $user_interested_in) {
		$date = new DateTime();
        $date->modify("-7 day");
        $one_week_ago = $date->format("Y-m-d H:i:s");
		if($this->session->userdata("home_search_parameters")['location'] != '') {	
			$lat = $this->session->userdata("home_search_parameters")['location_latitude'];
			$lng = $this->session->userdata("home_search_parameters")['location_longitude'];
		} else {
			$lat = $this->session->userdata('user_latitude');
			$lng = $this->session->userdata('user_longitude');
		}

		$this->db->select("user_id_encrypted, user_id, user_access_name,user_register_date,user_last_login_date, user_active_photo_thumb, user_city, floor(DATEDIFF( NOW(), user_birthday) / 365.23) as user_age, user_gender, round(6371 * acos(cos(radians('$lat')) * cos(radians(user_latitude)) * cos(radians(user_longitude) - radians('$lng') ) + sin(radians('$lat')) * sin(radians( user_latitude)))) AS distance, user_is_vip");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_CHECK_TIME_FOR_MYSQL.")");
		$this->db->order_by('u.user_last_login_date asc');
		$this->db->order_by('u.user_register_date','asc');
		// $this->db->order_by('user_last_login_date','asc');
		// $this->db->order_by('user_active_photo_thumb','desc');
		// $this->db->order_by("
		//     (CASE WHEN user_register_date > '" . $one_week_ago . "' THEN user_register_date < '" . $one_week_ago . "' END)"
		// );
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function get_active_home_online_users($user_id, $user_interested_in) {
		$this->db->select("user_country");
		$this->db->from($this->table_user_info);
		$this->db->where('user_id_ref',$user_id);
		$userCountry = $this->db->get()->row();
		$date = new DateTime();
        $date->modify("-7 day");
        $one_week_ago = $date->format("Y-m-d H:i:s");
		if($this->session->userdata("home_search_parameters")['location'] != '') {	
			$lat = $this->session->userdata("home_search_parameters")['location_latitude'];
			$lng = $this->session->userdata("home_search_parameters")['location_longitude'];
		} else {
			$lat = $this->session->userdata('user_latitude');
			$lng = $this->session->userdata('user_longitude');
		}

		$this->db->select("user_id_encrypted, user_id,user_last_login_date,user_register_date, user_access_name, user_active_photo_thumb, user_city, floor(DATEDIFF( NOW(), user_birthday) / 365.23) as user_age, user_gender, round(6371 * acos(cos(radians('$lat')) * cos(radians(user_latitude)) * cos(radians(user_longitude) - radians('$lng') ) + sin(radians('$lat')) * sin(radians( user_latitude)))) AS distance, user_is_vip");

		if($this->session->userdata("home_search_type") == 'basic') {
			$this->basic_search_filter();
		} else if($this->session->userdata("home_search_type") == 'advanced') {
			$this->basic_search_filter();
			$this->advanced_search_filter();
		}
		
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_CHECK_TIME_FOR_MYSQL.")");
		$this->db->order_by("
		    (CASE WHEN user_register_date > '" . $one_week_ago . "' THEN user_register_date < '" . $one_week_ago . "' END)"
		);
		$this->db->order_by('user_last_login_date','asc');
		$this->db->order_by('user_active_photo_thumb','desc');
		$this->db->order_by("
		    (CASE ui.user_country
		        WHEN '" . $userCountry->user_country . "' THEN 0
		        ELSE 1
		    END)"
		);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_active_online_new_users($user_id, $user_interested_in) {
		$upto_date = date('Y-m-d H:i:s', strtotime('-60 day'));

		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_CHECK_TIME_FOR_MYSQL.")");
		$this->db->where("u.user_register_date >= '".$upto_date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function get_active_online_users_list($user_id, $user_interested_in, $search_key, $per_page, $offset) {
		$this->db->select("user_id, user_id_encrypted as user_hash, user_active_photo_thumb, user_access_name, user_city, DATEDIFF( NOW(), user_birthday) / 365.23 as user_age, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, user_gender");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		$this->db->limit($per_page, $offset);
		$this->db->order_by('u.user_register_date desc');
		$this->db->order_by('u.user_last_activity_date', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}


	public function get_active_users_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('u.user_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function update_iso_code_for_country($user_id,$iso_code) {
		$data = [
			'user_country_code' => $iso_code
		];
		$this->db->where('user_id_ref', $user_id);
		$this->db->update($this->table_user_info, $data);

		return true;
	}
	public function get_isocode($limit_start,$limit_end) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->limit($limit_end, $limit_start);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_users_count($user_id) {
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->from($this->table_user);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

    private function basic_search_filter() {

		//if($this->session->userdata("home_search_parameters")['age_range'] != SEARCH_AGE_RANGE && $this->session->userdata("home_search_parameters")['age_range'] != '') {
		if($this->session->userdata("home_search_parameters")['age_range'] != '') {
			$this->db->where("( ui.user_birthday <= '".$this->session->userdata("home_search_parameters")['start_age_range']."' and ui.user_birthday >= '".$this->session->userdata("home_search_parameters")['end_age_range']."' )");
		}

		//if($this->session->userdata("home_search_parameters")['distance'] != SEARCH_DISTANCE_RANGE && $this->session->userdata("home_search_parameters")['distance'] != '') {
		if($this->session->userdata("home_search_parameters")['distance'] != '') {
			$this->db->having('distance >= '.$this->session->userdata("home_search_parameters")['min_distance'].' and distance <= '.$this->session->userdata("home_search_parameters")['max_distance']);
		}

		// new added
		if($this->session->userdata("home_search_parameters")['location'] != '') {
			$this->db->where('user_city',$this->session->userdata("home_search_parameters")['location']);
		}
    }

	private function advanced_search_filter() {

		if($this->session->userdata("home_search_parameters")['size_range'] != SEARCH_HEIGHT_RANGE && $this->session->userdata("home_search_parameters")['size_range'] != '') {
			$this->db->where('ui.user_height >= '.$this->session->userdata("home_search_parameters")['min_size_range'].' and ui.user_height <= '.$this->session->userdata("home_search_parameters")['max_size_range']);
		}

		if($this->session->userdata("home_search_parameters")['figure'] != '') {
			$this->db->where('ui.user_figure', $this->session->userdata("home_search_parameters")['figure']);
		}

		if($this->session->userdata("home_search_parameters")['ethnicity'] != '') {
			$this->db->where('ui.user_ethnicity', $this->session->userdata("home_search_parameters")['ethnicity']);
		}

		if($this->session->userdata("home_search_parameters")['hair_color'] != '') {
			$this->db->where('ui.user_hair_color', $this->session->userdata("home_search_parameters")['hair_color']);
		}

		if($this->session->userdata("home_search_parameters")['eye_color'] != '') {
			$this->db->where('ui.user_eye_color', $this->session->userdata("home_search_parameters")['eye_color']);
		}

		if($this->session->userdata("home_search_parameters")['smoker'] != '') {
			$this->db->where('ui.user_smoker', $this->session->userdata("home_search_parameters")['smoker']);
		}

		if($this->session->userdata("home_search_parameters")['user_languages'] != '') {
			$this->db->where('ui.language_id_ref', $this->session->userdata("home_search_parameters")['user_languages']);
		}

		if($this->session->userdata("home_search_parameters")['serious_relationship'] == 'yes') {
			$this->db->where('ui.interested_in_serious_relationship', $this->session->userdata("home_search_parameters")['serious_relationship']);
		} else {
			if($this->session->userdata("home_search_parameters")['contact_request'] != '') {
				$this->db->join($this->table_user_contact_requests, 'u.user_id = ucr.contact_request_user_id');
				$contact_request_list = array();				
				foreach (explode(',', $this->session->userdata("home_search_parameters")['contact_request']) as $creq) {
					$contact_request_list[] = "ucr.contact_request_contact_id = ".$creq;
				}
				$this->db->where('( '.implode(' or ', $contact_request_list).' )');
			}
		}

		if($this->session->userdata("home_search_parameters")['activity_and_quality'] != '') {
			$activity_and_quality_list = explode(',', $this->session->userdata("home_search_parameters")['activity_and_quality']);

			foreach ($activity_and_quality_list as $act_q_list) {
				if($act_q_list == 'only_members_with_photo') {
					$this->db->where('ui.user_active_photo !=', NULL);
					$this->db->where("ui.user_active_photo != ''");
				}
				if($act_q_list == 'only_new_members') {
					// last six month users
					$upto_date = date('Y-m-d H:i:s', strtotime('-'.IS_NEW_USER_FOR_DAYS.' day'));
					$this->db->where("u.user_register_date >= '".$upto_date."'");
				}
				if($act_q_list == 'available_online') {
					$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), ".USER_IS_ONLINE_CHECK_TIME_FOR_MYSQL.")");
				}
				if($act_q_list == 'only_vip_members') {
					$this->db->where('u.user_is_vip', 'yes');
				}
				if($act_q_list == 'only_verified_members') {
					$this->db->where('u.user_verified', 'yes');
				}				
			}
		}


	}

	public function get_active_users_searched_list($user_id, $user_interested_in, $per_page, $offset) {
		$this->db->select("user_country");
		$this->db->from($this->table_user_info);
		$this->db->where('user_id_ref',$user_id);
		$userCountry = $this->db->get()->row();
		if($this->session->userdata("home_search_parameters")['location'] != '') {	
			$lat = $this->session->userdata("home_search_parameters")['location_latitude'];
			$lng = $this->session->userdata("home_search_parameters")['location_longitude'];
		} else {
			$lat = $this->session->userdata('user_latitude');
			$lng = $this->session->userdata('user_longitude');
		}

		$this->db->select("*, round(6371 * acos(cos(radians('$lat')) * cos(radians(user_latitude)) * cos(radians(user_longitude) - radians('$lng') ) + sin(radians('$lat')) * sin(radians( user_latitude)))) AS distance, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, floor(DATEDIFF( NOW(), user_birthday) / 365.23) as user_age");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_id not in(select dislike_to_user_id from tbl_user_dislike where dislike_from_user_id='.$user_id .')');
		$this->db->where('u.user_id not in(select dislike_from_user_id from tbl_user_dislike where dislike_to_user_id='.$user_id .')');

		if($this->session->userdata("home_search_type") == 'basic') {
			$this->basic_search_filter();
		} else if($this->session->userdata("home_search_type") == 'advanced') {
			$this->basic_search_filter();
			$this->advanced_search_filter();
		}

		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);		

		$this->db->limit($per_page, $offset);
		// $this->db->order_by("
		//     (CASE ui.user_country
		//         WHEN '" . $userCountry->user_country . "' THEN 0
		//         ELSE 1
		//     END)"
		// );
		// if($this->session->userdata("home_search_parameters")['distance'] != '') {
		// 	$this->db->order_by('u.user_last_activity_date DESC,distance ASC, u.user_rank ASC');
		// } else {
		// 	//$this->db->order_by('u.user_rank ASC, u.user_last_activity_date DESC');
		// 	$this->db->order_by('u.user_last_activity_date DESC, u.user_rank ASC');
		// }
		$this->db->order_by('u.user_last_login_date desc');
		$this->db->order_by('u.user_register_date desc');
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_users_searched_count($user_id, $user_interested_in) {
		if($this->session->userdata("home_search_parameters")['location'] != '') {	
			$lat = $this->session->userdata("home_search_parameters")['location_latitude'];
			$lng = $this->session->userdata("home_search_parameters")['location_longitude'];
		} else {
			$lat = $this->session->userdata('user_latitude');
			$lng = $this->session->userdata('user_longitude');
		}
		$search_member_id = $this->session->userdata('user_id');

		$this->db->select("*, round(6371*acos(cos(radians('$lat')) * cos(radians(user_latitude)) * cos(radians(user_longitude) - radians('$lng') ) + sin(radians('$lat')) * sin(radians( user_latitude)))) AS distance");

		if($this->session->userdata("home_search_type") == 'basic') {
			$this->basic_search_filter();
		} else if($this->session->userdata("home_search_type") == 'advanced') {
			$this->basic_search_filter();
			$this->advanced_search_filter();
		}

		$this->db->where('u.user_id not in(select dislike_to_user_id from tbl_user_dislike where dislike_from_user_id='.$search_member_id .')');
		$this->db->where('u.user_id not in(select dislike_from_user_id from tbl_user_dislike where dislike_to_user_id='.$search_member_id .')');
		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->from($this->table_user);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
    }

	public function get_active_user_information($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_information($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}
	public function search_users_by_like($info) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->like('u.user_access_name', $info);
		$this->db->or_like('u.user_email', $info);
		$this->db->or_like('ui.user_firstname', $info);
		$this->db->or_like('ui.user_lastname', $info);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_information_for_payment($user_id) {
		$this->db->select("user_access_name, user_firstname, user_lastname, user_telephone, user_street, user_house_no, user_company, user_country, user_city, user_postcode, user_email");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_info_using_email_or_username($email) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_email', $email);
		$this->db->or_where('u.user_access_name', $email);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_info_by_email($email) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_email', $email);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_info_using_passwordtoken($token) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.password_token', $token);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_active_photos($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		//$this->db->where_in('up.photo_status', array('active','locked'));
		$this->db->where('up.photo_status', 'active');
		$this->db->where('up.photo_user_id_ref', $user_id);
		$this->db->order_by('up.photo_type', 'asc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_all_photos($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_photos);
		$this->db->where('up.photo_user_id_ref', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}
	public function get_user_by_username($username) {
		$this->db->select("*");
		$this->db->from($this->table_user_k);
		$this->db->where('user_access_name', $username);
		return $this->db->get();
	}

	// Update user table
	public function update_user($user_id, $data) {
		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_user, $data);

		return $this->db->affected_rows();
	}
	// Update user table for approve by admin
	public function update_user_activate_user($user_id, $data) {
		$this->db->where('user_id', $user_id);
		$data['user_activated_date'] = gmdate('Y-m-d H:i:s');
		$data['user_last_activity_date'] = gmdate('Y-m-d H:i:s');
		$data['user_last_login_date'] = gmdate('Y-m-d H:i:s');
		$this->db->update($this->table_user, $data);
		return $this->db->affected_rows();
	}

	// Update user purchase credits
	public function update_user_credits($user_id, $user_credits) {
		$this->db->where('user_id', $user_id);
		$this->db->set('user_credits', $user_credits);
		$this->db->update($this->table_user);

		return $this->db->affected_rows();
	}

	// Update user purchase diamonds
	public function update_user_diamonds($user_id, $user_diamonds) {
		$this->db->where('user_id', $user_id);
		$this->db->set('user_diamonds', $user_diamonds);
		$this->db->update($this->table_user);

		return $this->db->affected_rows();
	}

	// Update user information table
	public function update_user_info($user_id, $data) {
		$this->db->where('user_id_ref', $user_id);
		$this->db->update($this->table_user_info, $data);

		return $this->db->affected_rows();
	}


	public function get_active_online_single_users_info($user_id) {
		$this->db->select("user_id, user_id_encrypted as user_hash, user_active_photo_thumb, user_access_name, user_city, DATEDIFF( NOW(), user_birthday) / 365.23 as user_age, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, user_gender");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function delete_user_info($user_id) {
		$this->db->where('user_id_ref', $user_id);
        $this->db->delete($this->table_user_info_k);

        return $this->db->affected_rows();
	}

	public function delete_user($user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->set('user_status', 'deleted');
		$this->db->set('user_deletion_date', 'UTC_TIMESTAMP()', false);
        $this->db->update($this->table_user_k);

        return $this->db->affected_rows();
	}

	public function get_already_chatted_users_list($user_id, $user_interested_in, $search_key, $per_page, $offset) {

		$this->db->select("user_id, user_id_encrypted as user_hash, user_active_photo_thumb, user_access_name, user_city, DATEDIFF( NOW(), user_birthday) / 365.23 as user_age, TIMEDIFF(UTC_TIMESTAMP(), user_last_activity_date) as last_online_time, user_gender");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('ui.user_gender', $user_interested_in);
		$this->db->where('u.user_type', 'user');
		$this->db->where('u.user_id !=', $user_id, FALSE);
		$this->db->where('u.user_id in (SELECT message_sender_id as user_id FROM tbl_user_chat_message WHERE message_receiver_id='.$user_id.' UNION SELECT message_receiver_id as user_id FROM tbl_user_chat_message WHERE message_sender_id='.$user_id.')');
		if($search_key != '') {
			$this->db->like('u.user_access_name', $search_key, 'both');
		}
		$this->db->limit($per_page, $offset);
		$this->db->order_by('u.user_last_activity_date', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function is_email_already_taken($user_id, $newemail) {
		$this->db->select("*");
		$this->db->from($this->table_user_k);
		$this->db->where('user_id !=', $user_id);
		$this->db->where('user_email', $newemail);
		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_user_email($user_id) {
		$this->db->select("user_email");
		$this->db->from($this->table_user_k);
		$this->db->where('user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('user_email');
		} else {
			$res = '';
		}		
		return $res;
	}

	public function is_user_online($user_id) {
		$this->db->from($this->table_user);
		$this->db->where('u.user_id', $user_id);
		$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), INTERVAL 3 MINUTE)");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_free_credits_users_list($per_page, $offset) {
		$this->db->select("user_id_encrypted, user_id, user_gender, user_email, user_access_name, user_active_photo_thumb, user_country, user_city, user_status, user_taken_free_credits, user_register_date");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_type', 'user');
		$this->db->where("u.user_taken_free_credits > 0");
		$this->db->order_by('u.user_id', 'desc');

		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_free_credits_users_list() {
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where("u.user_taken_free_credits > 0");
		$this->db->where('u.user_type', 'user');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_total_free_credits() {
		$this->db->select('sum(user_taken_free_credits) as total');
		$this->db->from($this->table_user);
		$this->db->where('u.user_type', 'user');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row('total');
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function clear_user_login_session() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_username');
        $this->session->unset_userdata('user_avatar');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('user_gender');
        $this->session->unset_userdata('user_is_vip');
        $this->session->unset_userdata('user_latitude');
        $this->session->unset_userdata('user_longitude');
        $this->session->unset_userdata('user_interested_in');
        $this->session->unset_userdata('user_is_online');
        $this->session->unset_userdata('user_offline_activity_start_date');
        $this->session->unset_userdata('user_credits');
        $this->session->unset_userdata('user_diamonds');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_last_login_date');
    }

    public function get_user_info_by_fb_id($user_fb_id) {
		$this->db->select("*");
		$this->db->from($this->table_user);
		$this->db->join($this->table_user_info, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_fb_id', $user_fb_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

}