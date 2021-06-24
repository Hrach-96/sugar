<?php
class Report_user_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_r = 'tbl_users ur';
	private $table_user_info = 'tbl_user_info ui';
	private $table_user_info_r = 'tbl_user_info uir';
	private $table_report_user = 'tbl_report_user';
	private $table_report_user_k = 'tbl_report_user ru';

	public function is_member_reported($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_report_user);
		$this->db->where('report_from_user_id', $user_id);
		$this->db->where('report_to_user_id', $member_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_report($data) {
        $return = $this->db->insert($this->table_report_user, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function get_all_reported_users_list($per_page, $offset, $search_key = '') {
		$this->db->select("u.user_id_encrypted, u.user_id, ui.user_gender, u.user_access_name, ui.user_active_photo_thumb, ui.user_city, ui.user_country, DATEDIFF( NOW(), ui.user_birthday) / 365.23 as user_age, TIMEDIFF(UTC_TIMESTAMP(), u.user_last_activity_date) as last_online_time, u.user_status, ru.report_reason_text, ru.report_user_comment, ru.report_added_date, u.user_deletion_date, ur.user_access_name as reported_by");
		$this->db->from($this->table_report_user_k);
		$this->db->join($this->table_user_info, 'ru.report_to_user_id = ui.user_id_ref', 'left');
		$this->db->join($this->table_user, 'ru.report_to_user_id = u.user_id');
		$this->db->join($this->table_user_r, 'ru.report_from_user_id = ur.user_id');
		$this->db->order_by('ru.report_id', 'desc');
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

	public function count_all_reported_users($search_key = '') {
		$this->db->from($this->table_report_user_k);
		$this->db->join($this->table_user, 'ru.report_to_user_id = u.user_id');
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

	public function delete_user_reported($user_id) {
		$this->db->where('report_to_user_id', $user_id);
		$this->db->or_where('report_from_user_id', $user_id);		
        $this->db->delete($this->table_report_user);

        return $this->db->affected_rows();
	}

}