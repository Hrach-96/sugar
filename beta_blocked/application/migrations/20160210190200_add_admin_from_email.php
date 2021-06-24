<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Admin_From_Email extends CI_Migration {

	public function up() {
		$fields = array(
			'from_email' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE, 'default' => 'noreply@example.com')
		);
		$this->dbforge->add_column('admin', $fields);
	}

	public function down() {
		$this->dbforge->drop_column('admin', 'from_email');
	}

}
