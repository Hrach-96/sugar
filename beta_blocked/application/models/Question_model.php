<?php
class Question_model extends CI_Model
{
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';	
	private $table_questions = 'tbl_questions';
	private $table_user_questions = 'tbl_user_question';
	private $table_questions_k = 'tbl_questions q';
	private $table_user_questions_k = 'tbl_user_question uq';

	public function get_active_question_list($user_gender, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_questions);
		$this->db->where('question_status', 'active');
		$this->db->where('question_for', $user_gender);
		$this->db->limit($per_page, $offset);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function is_already_question_asked($question_id, $user_id, $member_id) {
		$this->db->from($this->table_user_questions);
		$this->db->where('user_question_ref_id', $question_id);
		$this->db->where('user_question_sender_id', $user_id);
		$this->db->where('user_question_receiver_id', $member_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = true;
		} else {
			$res = false;
		}		
		return $res;
	}

	public function is_already_question_deleted($question_id, $user_id) {
		$this->db->from($this->table_user_questions);
		$this->db->where('user_question_id', $question_id);
		$this->db->where("(user_question_sender_id=".$user_id." or user_question_receiver_id=".$user_id.")");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = false;
		} else {
			$res = true;
		}		
		return $res;
	}

	public function insert_user_question($data) {
        $return = $this->db->insert($this->table_user_questions, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function update_user_question($question_id, $data) {
		$this->db->where('user_question_id', $question_id);
        $return = $this->db->update($this->table_user_questions, $data);
        return $this->db->affected_rows();
	}

	public function delete_user_question($question_id, $user_id){
		$this->db->where('user_question_id', $question_id);
		$this->db->where("(user_question_sender_id=".$user_id." or user_question_receiver_id=".$user_id.")");
		$this->db->delete($this->table_user_questions);
		return $this->db->affected_rows();
	}

	public function delete_all_user_questions($user_id){
		$this->db->where("user_question_sender_id", $user_id);
		$this->db->or_where("user_question_receiver_id", $user_id);
		$this->db->delete($this->table_user_questions);
		return $this->db->affected_rows();
	}

	public function get_active_received_question_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_questions_k);
		$this->db->join($this->table_questions_k, 'q.question_id = uq.user_question_ref_id');
		$this->db->join($this->table_user, 'uq.user_question_sender_id = u.user_id');
		$this->db->join($this->table_user_info, 'uq.user_question_sender_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('uq.user_question_receiver_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uq.user_question_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}

	public function get_active_sent_question_list($user_id, $per_page, $offset) {
		$this->db->select("*");
		$this->db->from($this->table_user_questions_k);
		$this->db->join($this->table_questions_k, 'q.question_id = uq.user_question_ref_id');
		$this->db->join($this->table_user, 'uq.user_question_receiver_id = u.user_id');
		$this->db->join($this->table_user_info, 'uq.user_question_receiver_id = ui.user_id_ref', 'left');
		$this->db->where('u.user_status', 'active');
		$this->db->where('uq.user_question_sender_id', $user_id);
		$this->db->limit($per_page, $offset);
		$this->db->order_by('uq.user_question_id', 'desc');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}		
		return $res;
	}


	public function count_last_questions_to_users_afterdate($user_id, $date) {
		$this->db->select("*");
		$this->db->from($this->table_user_questions_k);
		$this->db->join($this->table_user, 'uq.user_question_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('uq.user_question_receiver_id', $user_id);
		$this->db->where("uq.user_question_added_date >= '".$date."'");
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}		
		return $res;
	}

	public function count_new_unseen_questions_to_users($user_id) {
		$this->db->from($this->table_user_questions_k);
		$this->db->join($this->table_user, 'uq.user_question_sender_id = u.user_id');
		$this->db->where('u.user_status', 'active');
		$this->db->where('uq.user_question_receiver_id', $user_id);
		$this->db->where('uq.user_question_viewed', 'no');

		return $this->db->count_all_results();
	}

	public function update_unseen_as_seen_to_user($user_id) {
		$this->db->where('user_question_viewed', 'no');
		$this->db->where('user_question_receiver_id', $user_id);
		$this->db->set('user_question_viewed', 'yes');
		$this->db->update($this->table_user_questions);
    
        return $this->db->affected_rows();
	}

}