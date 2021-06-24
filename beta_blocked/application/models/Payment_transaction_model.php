<?php
class Payment_transaction_model extends CI_Model
{
	private $table_payment_transactions = 'tbl_payment_transactions';

	public function insert_transaction($data) {
        $return = $this->db->insert($this->table_payment_transactions, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}


}