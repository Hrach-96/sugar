<?php
class Document_model extends CI_Model
{
	private $table_user_documents = 'tbl_user_documents';
	private $table_user_documents_k = 'tbl_user_documents ud';
	private $table_user = 'tbl_users u';
	private $table_user_info = 'tbl_user_info ui';		

	public function get_user_all_documents_list($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_documents);
		$this->db->where('document_user_id', $user_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function count_all_reality_documents_as_per_status() {
		$SQL = "SELECT count(*) as total, count(CASE WHEN `document_status` ='verified' THEN 1 END) as verified, count(CASE WHEN `document_status` ='pending' THEN 1 END) as pending, count(CASE WHEN `document_status` ='rejected' THEN 1 END) as rejected, count(CASE WHEN `document_status` ='deleted' THEN 1 END) as deleted FROM `tbl_user_documents` WHERE document_type = 'reality_check_file'";

		$Q = $this->db->query($SQL);

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function count_all_asset_documents_as_per_status() {
		$SQL = "SELECT count(*) as total, count(CASE WHEN `document_status` ='verified' THEN 1 END) as verified, count(CASE WHEN `document_status` ='pending' THEN 1 END) as pending, count(CASE WHEN `document_status` ='rejected' THEN 1 END) as rejected, count(CASE WHEN `document_status` ='deleted' THEN 1 END) as deleted FROM `tbl_user_documents` WHERE document_type = 'asset_check_file'";

		$Q = $this->db->query($SQL);

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}


	public function get_user_reality_documents($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_documents);
		$this->db->where('document_user_id', $user_id);
		$this->db->where('document_type', 'reality_check_file');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_user_asset_documents($user_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_documents);
		$this->db->where('document_user_id', $user_id);
		$this->db->where('document_type', 'asset_check_file');
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_document_info($document_id) {
		$this->db->select("*");
		$this->db->from($this->table_user_documents);
		$this->db->where('document_id', $document_id);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->row_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function get_all_reality_documents_list($per_page, $offset, $search_by_status = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_documents_k);
		$this->db->join($this->table_user, 'ud.document_user_id = u.user_id');
		$this->db->join($this->table_user_info, 'ud.document_user_id = ui.user_id_ref', 'left');
		$this->db->where('ud.document_type', 'reality_check_file');
		if($search_by_status != '')
			$this->db->where('ud.document_status', $search_by_status);
		$this->db->order_by('ud.document_id', 'desc');		

		$this->db->limit($per_page, $offset);

		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function count_all_reality_documents_list($search_by_status = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_documents);
		$this->db->where('document_type', 'reality_check_file');
		if($search_by_status != '')
			$this->db->where('document_status', $search_by_status);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

	public function get_all_asset_documents_list($per_page, $offset, $search_by_status = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_documents_k);
		$this->db->join($this->table_user, 'ud.document_user_id = u.user_id');
		$this->db->join($this->table_user_info, 'ud.document_user_id = ui.user_id_ref', 'left');
		$this->db->where('ud.document_type', 'asset_check_file');
		if($search_by_status != '')
			$this->db->where('ud.document_status', $search_by_status);
		$this->db->order_by('ud.document_id', 'desc');		

		$this->db->limit($per_page, $offset);

		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->result_array();
		} else {
			$res = false;
		}
		return $res;
	}

	public function count_all_asset_documents_list($search_by_status = '') {
		$this->db->select("*");
		$this->db->from($this->table_user_documents);
		$this->db->where('document_type', 'asset_check_file');
		if($search_by_status != '')
			$this->db->where('document_status', $search_by_status);
		$Q = $this->db->get();

		if($Q->num_rows() > 0) {
			$res = $Q->num_rows();
		} else {
			$res = 0;
		}
		return $res;
	}

	public function insert_user_document($data) {
        $return = $this->db->insert($this->table_user_documents, $data);
        if ((bool) $return === TRUE) {
            return $this->db->insert_id();
        } else {
            return $return;
        }
	}

	public function delete_all_user_documents($user_id) {
		$this->db->where("document_user_id", $user_id);
        $this->db->delete($this->table_user_documents);

        return $this->db->affected_rows();
	}	

	public function update_document($document_id, $data) {
		$this->db->where('document_id', $document_id);
		$this->db->update($this->table_user_documents, $data);

		return $this->db->affected_rows();
	}	
}