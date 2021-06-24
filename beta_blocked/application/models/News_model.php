<?php
class News_model extends CI_Model
{
	private $table_news_subscribers = 'tbl_news_subscribers';

	public function insert_news_subscription($data)  {
        $return = $this->db->insert($this->table_news_subscribers, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}	

	public function update_news_subscription($user_email, $data)  {
		$this->db->update($this->table_news_subscribers, $data);
		$this->db->where('news_subscriber_email', $user_email);

		return $this->db->affected_rows();
	}	

	public function get_news_subscribed_info($user_email) {
		$this->db->from($this->table_news_subscribers);
		$this->db->where('news_subscriber_email', $user_email);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_all_subscribers_list($per_page, $offset) {
		$this->db->from($this->table_news_subscribers);
		$this->db->order_by('news_subscriber_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function count_all_subscribers_list() {
		$this->db->from($this->table_news_subscribers);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}   

	public function get_all_active_subscribers_list() {
		$this->db->from($this->table_news_subscribers);
		$this->db->where('news_subscriber_status', 'subscribed');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

}