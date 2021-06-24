<?php
class Voucher_model extends CI_Model
{
	private $table_vouchers = 'tbl_vouchers';
	private $table_voucher_used = 'tbl_voucher_used';

	public function get_vouchers($per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_vouchers);
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}
	public function addUsedTable($data) {
		$this->db->insert($this->table_voucher_used, $data);
		return true;
	}
	public function create_voucher($data) {
		$return = $this->db->insert($this->table_vouchers, $data);
		if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}
	public function update_voucher($voucher_id, $data)  {
		$this->db->where('id', $voucher_id);
		$this->db->update($this->table_vouchers, $data);
		return true;
	}
	public function removeVoucher($id)  {
		$this->db->where('id', $id);
		$this->db->delete($this->table_vouchers);
		return true;
	}
	public function getVoucherById($id)  {
		$this->db->select("*");
		$this->db->from($this->table_vouchers);
		$this->db->where('id',$id);
		return $this->db->get()->row();
	}
	public function getVoucherByCode($code)  {
		$this->db->select("*");
		$this->db->from($this->table_vouchers);
		$this->db->where('code',$code);
		return $this->db->get()->row();
	}
	public function checkVoucherExist($code) {
		$this->db->select("*");
		$this->db->from($this->table_vouchers);
		$this->db->where('code',$code);
		$Q = $this->db->get();
		return $Q->num_rows();
	}
	public function count_vouchers() {
		$this->db->select("*");
		$this->db->from($this->table_vouchers);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}
}