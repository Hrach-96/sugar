<?php
class Payment_gateway_model extends CI_Model
{
	private $table_payment_gateway = 'tbl_payment_gateway';

	public function get_oppwa_credentials() {
		$this->db->select("*");
		$this->db->from($this->table_payment_gateway);
		$this->db->where('gateway_id', OPPWA_PAYMENT_GATEWAY);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_gateway_info($gateway_id) {
		$this->db->select("*");
		$this->db->from($this->table_payment_gateway);
		$this->db->where('gateway_id', $gateway_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_all_gateway_list() {
		$this->db->select("*");
		$this->db->from($this->table_payment_gateway);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function update_gateway_info($gateway_id, $data) {
		$this->db->where('gateway_id', $gateway_id);
		$this->db->update($this->table_payment_gateway, $data);

		return $this->db->affected_rows();
	}

}