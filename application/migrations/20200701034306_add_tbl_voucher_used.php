<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_tbl_voucher_used extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'id' => array(
                             'type' => 'INT',
                             'constraint' => 11,
                             'unsigned' => TRUE,
                             'auto_increment' => TRUE
                        ),
                        'voucher_id' => array(
                             'type' => 'INT',
                             'constraint' => 11,
                        ),
                        'user_id' => array(
                             'type' => 'INT',
                             'constraint' => 11,
                        ),
                        'package_id' => array(
                             'type' => 'INT',
                             'constraint' => 11,
                        ),
                        'package_type' => array(
                             'type' => 'VARCHAR',
                             'constraint' => 255,
                        ),
                        'used_datetime' => array(
                             'type' => 'datetime',
                        ),
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('tbl_voucher_used');
        }

        public function down()
        {
                $this->dbforge->drop_table('tbl_voucher_used');
        }
}