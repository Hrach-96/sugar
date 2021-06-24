<?php
class Payment_transaction_model extends CI_Model
{
    private $table_stripe_buy_info = 'tbl_stripe_buy_info';
	private $table_payment_transactions = 'tbl_payment_transactions';
	private $table_payment_transactions_stripe = 'tbl_payment_transactions_stripe';

	public function insert_transaction($data) {
        $return = $this->db->insert($this->table_payment_transactions, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}
    public function add_buy_info_for_stripe($data) {
        $return = $this->db->insert($this->table_stripe_buy_info, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
    }
	public function insert_transaction_stripe($data) {
        $return = $this->db->insert($this->table_payment_transactions_stripe, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}


}