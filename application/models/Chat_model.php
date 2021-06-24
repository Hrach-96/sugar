<?php
class Chat_model extends CI_Model
{
	private $table_user_chat_message = 'tbl_user_chat_message';
	private $table_user_chat_message_info = 'tbl_user_chat_message_info';
	private $table_user_chat_message_k = 'tbl_user_chat_message cm';

	public function count_unseen_message_count($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_chat_message);
		$this->db->where('message_receiver_id', $user_id);
		$this->db->where('message_sender_id', $member_id);
		$this->db->where('message_status', 'unseen');

		return $this->db->count_all_results();
	}

	public function get_last_message_text($user_id, $member_id) {
		$this->db->select("message_text, message_sent_date");
		$this->db->from($this->table_user_chat_message);
		$this->db->where("(message_receiver_id = ".$user_id." and message_sender_id = ".$member_id.")");
		$this->db->or_where("(message_receiver_id = ".$member_id." and message_sender_id = ".$user_id.")");
		$this->db->order_by('message_id', 'desc');
		$this->db->limit(1);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = '';
		}
		return $res;
	}

	public function get_user_recent_chat_messages($user_id, $member_id,  $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_chat_message);
		$this->db->where("((message_receiver_id = ".$user_id." and message_sender_id = ".$member_id.")");
		$this->db->or_where("(message_receiver_id = ".$member_id." and message_sender_id = ".$user_id."))");
		$this->db->where("message_text != ' '");
		$this->db->order_by('message_id', 'desc');
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function insert_user_chat_message($data) {
        $return = $this->db->insert($this->table_user_chat_message, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function add_chat_user_info($data) {
		$return = $this->db->insert($this->table_user_chat_message_info, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}
	public function update_chat_user_info($message_sender_id,$message_receiver_id,$data) {
		$this->db->where('message_receiver_id', $message_receiver_id);
		$this->db->where('message_sender_id', $message_sender_id);
		$this->db->update($this->table_user_chat_message_info, $data);
		return true;
	}
	public function get_user_chats_info($message_sender_id,$message_receiver_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_chat_message_info);
		$this->db->where("message_sender_id",$message_sender_id);
		$this->db->where("message_receiver_id",$message_receiver_id);
		$Q = $this->db->get();
		if($Q->num_rows() > 0) {
			$res = $Q->row();
		} else {
			$res = false;
		}
		return $res;
	}
	public function save_user_chat_message($data) {
		$this->db->set('message_sent_date', 'UTC_TIMESTAMP()', false);
        $return = $this->db->insert($this->table_user_chat_message, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	// Mark message as readed by receiver
	public function mark_messages_as_seen_by_user($user_id, $member_id) {
		$this->db->where('message_receiver_id', $user_id);
		$this->db->where('message_sender_id', $member_id);
		$this->db->where('message_status', 'unseen');
		$data = array('message_status' => 'seen');
		$this->db->update($this->table_user_chat_message, $data);

		return $this->db->affected_rows();
	}


	public function get_user_recent_unseen_received_chat_messages($user_id, $member_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_chat_message);
		$this->db->where("message_receiver_id", $user_id);
		$this->db->where("message_sender_id", $member_id);
		$this->db->where('message_status', 'unseen');
		$this->db->order_by('message_id', 'asc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function delete_all_user_chat_messages($user_id) {
		$this->db->where("message_sender_id", $user_id);
		$this->db->or_where("message_receiver_id", $user_id);
        $this->db->delete($this->table_user_chat_message);

        return $this->db->affected_rows();
	}	

	public function count_last_chats_to_users_afterdate($user_id, $date) {
		$this->db->select("*");
		$this->db->from($this->table_user_chat_message);
		$this->db->where('message_receiver_id', $user_id);
		$this->db->where('message_status', 'unseen');
		$this->db->where("message_sent_date >= '".$date."'");
		$this->db->group_by('message_receiver_id');

		return $this->db->count_all_results();
	}

		
}