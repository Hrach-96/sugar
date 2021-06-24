<?php
class Auth_model extends CI_Model 
{
	private $table_user = "tbl_users";
	private $table_user_info = "tbl_user_info";
	private $table_user_k = "tbl_users u";
	private $table_user_info_k = "tbl_user_info ui";

	// Login
	public function login($username, $password) {
		$this->db->select('user_id, user_access_name, user_email, user_type, user_gender, user_active_photo,user_active_photo_thumb, user_is_vip, user_verified, user_last_login_date, user_latitude, user_longitude, user_status, user_interested_in, online_switcher_activated_date, user_credits, language_id_ref, user_diamonds, show_upload_profile_pic_count, user_city');
		$this->db->from($this->table_user_k);
		$this->db->join($this->table_user_info_k, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where("(u.user_email = '".$username."' or u.user_access_name = '".$username."')");
		$this->db->where('u.user_password', sha1($password));
		$this->db->where('u.user_status != ', 'deleted');
		$this->db->limit(1);
		$result = $this->db->get();
						
		if($result->num_rows() == 1) {
			return $result->row();
		} else {
			return false;
		}
	}

	public function getUserInfoByEmail($email) {
		$this->db->select('user_id, user_access_name, user_email, user_type, user_gender, user_active_photo,user_active_photo_thumb, user_is_vip, user_last_login_date, user_latitude, user_longitude, user_status, user_interested_in, user_credits, user_diamonds, show_upload_profile_pic_count, user_city');
		$this->db->from($this->table_user_k);
		$this->db->join($this->table_user_info_k, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_email', $email);
		$this->db->limit(1);
		$result = $this->db->get();
						
		if($result->num_rows() == 1) {
			return $result->row();
		} else {
			return false;
		}
	}

	public function isUserInactiveByEmail($email) {
		$this->db->select('*');
		$this->db->from($this->table_user_k);
		$this->db->where('u.user_email', $email);
		$this->db->where('u.user_status', 'inactive');
		$this->db->limit(1);
		$result = $this->db->get();
						
		if($result->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	public function isUserPendingByEmail($email) {
		$this->db->select('*');
		$this->db->from($this->table_user_k);
		$this->db->where('u.user_email', $email);
		$this->db->where('u.user_status', 'pending');
		$this->db->limit(1);
		$result = $this->db->get();
						
		if($result->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	// Update the last connection date
	public function update_login($user_id) {
		$this->db->where('user_id', $user_id);
		$this->db->set('user_last_login_date', 'UTC_TIMESTAMP()', false);
		$this->db->update($this->table_user);
	}

	// Update the last activity date
	public function update_last_activity($user_id) {
		if($this->session->userdata('user_is_online') == 'yes') {
			$this->db->where(array("user_id" => $user_id));
			$this->db->set('user_last_activity_date', 'UTC_TIMESTAMP()', false);
			$this->db->update($this->table_user);
		} else {
			if($this->session->userdata('user_offline_activity_start_date') != '') {
				$today = date_create(gmdate('Y-m-d H:i:s'));
				$switcher_activated = date_create($this->session->userdata('user_offline_activity_start_date'));
				$diff_d = date_diff($today, $switcher_activated);
				if($diff_d->h >= 24) {
	                $this->session->set_userdata('user_is_online', 'yes');
	                $this->session->set_userdata('user_offline_activity_start_date', '');
				}
			} else {
	            $this->session->set_userdata('user_is_online', 'yes');
	            $this->session->set_userdata('user_offline_activity_start_date', '');
			}
		}
	}	

	// set online switcher date to make user online status as offline
	public function set_online_switcher_date($user_id) {
		$this->db->where(array("user_id" => $user_id));
		$this->db->set('online_switcher_activated_date', 'UTC_TIMESTAMP()', false);
		$this->db->update($this->table_user);
	}			
	
	// Create a new user
	public function create_user($data) {
	    $return = $this->db->set('user_register_date', 'UTC_TIMESTAMP()', false)
                ->set('user_last_activity_date', 'UTC_TIMESTAMP()', false)
         		->insert($this->table_user, $data);

        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}	

	// Create anew user information
	public function create_user_info($data) {
	    $return = $this->db->insert($this->table_user_info, $data);

        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}	
	
	// Update user table
	public function update_user($user_id, $data) {		
		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_user, $data);
	}

	// Update user info table
	public function update_user_info($user_id, $data) {		
		$this->db->where('user_id_ref', $user_id);
		$this->db->update($this->table_user_info, $data);
	}

	// Update user table
	public function updateUserStatusAsActive($email) {
		$this->db->set('user_status', 'active');
		$this->db->where('user_email', $email);
		$this->db->update($this->table_user);

		return $this->db->affected_rows();
	}

	public function getUserInfo($userid) {
		$this->db->select('user_id, user_access_name, user_email, user_type, user_gender, user_active_photo,user_active_photo_thumb, user_is_vip, user_last_login_date, user_latitude, user_longitude, user_status, user_interested_in, online_switcher_activated_date, user_credits, user_diamonds, show_upload_profile_pic_count, user_city');
		$this->db->from($this->table_user_k);
		$this->db->join($this->table_user_info_k, 'u.user_id = ui.user_id_ref', 'left');
		$this->db->where("u.user_id = '".$userid."'");
		$this->db->limit(1);
		$result = $this->db->get();
						
		if($result->num_rows() == 1) {
			return $result->row();
		} else {
			return false;
		}
	}
	

}