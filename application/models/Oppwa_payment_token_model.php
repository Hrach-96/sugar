<?php
class Oppwa_payment_token_model extends CI_Model
{
	private $table_oppwa_checkout_token = 'tbl_oppwa_checkout_token';

	public function get_token_info($token) {
		$this->db->select("*");
		$this->db->where('token', $token);
		$this->db->from($this->table_oppwa_checkout_token);		
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_token($data) {
        $return = $this->db->insert($this->table_oppwa_checkout_token, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function update_token_status($token, $status)  {
		$this->db->set('status', $status);
		$this->db->where('token', $token);
		$this->db->update($this->table_oppwa_checkout_token);
		
		return $this->db->affected_rows();
	}

}