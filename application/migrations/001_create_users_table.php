<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'unique' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'role' => array(
                'type' => 'ENUM',
                'constraint' => array('Admin', 'HR', 'Employee')
            ),
            'reset_token' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE // Allow NULL to avoid 1067 error
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE // Allow NULL to avoid 1067 error
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');

        // Set CURRENT_TIMESTAMP behavior
        $this->db->query("ALTER TABLE `users` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE `users` MODIFY `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}