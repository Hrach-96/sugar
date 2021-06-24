<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Admin_App_Links extends CI_Migration {

	public function up() {
		$fields = array(
			'app_ios' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
			'app_android' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE)
		);
		$this->dbforge->add_column('admin', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('admin', 'app_ios');
		$this->dbforge->drop_column('admin', 'app_android');
	}

}
