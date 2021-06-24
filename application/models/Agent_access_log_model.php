<?php
class Agent_access_log_model extends CI_Model
{
	private $table_agent_access_log = 'tbl_agent_access_log';
	private $table_agent_access_log_k = 'tbl_agent_access_log aal';
	private $table_user = 'tbl_users u';

	public function get_online_agents_with_access_log($agent_id, $access_type) {
		$this->db->select("*");
		$this->db->from($this->table_agent_access_log_k);
		$this->db->join($this->table_user, 'aal.access_user_id=u.user_id');
		$this->db->where('aal.access_user_id !=', $agent_id);
		$this->db->where('aal.access_type', $access_type);
		$this->db->where('u.user_type', 'agent');
		$this->db->where("u.user_last_activity_date > date_sub(UTC_TIMESTAMP(), INTERVAL 3 MINUTE)");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_agent_access_log($data) {
        $return = $this->db->insert($this->table_agent_access_log, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_agent_access_log($agent_id, $access_type) {
		$this->db->where('access_user_id', $agent_id);
		$this->db->where('access_type', $access_type);
        $this->db->delete($this->table_agent_access_log);

        return $this->db->affected_rows();
	}

	// public function is_user_picture($user_id, $photo_id) {
	// 	$this->db->from($this->table_user_photos);
	// 	$this->db->where('photo_user_id_ref', $user_id);
	// 	$this->db->where('photo_id', $photo_id);
	// 	$Q = $this->db->get();

	// 	if($Q->num_rows() > 0) {
	// 		$res = true;
	// 	} else {
	// 		$res = false;
	// 	}		
	// 	return $res;
	// }


}