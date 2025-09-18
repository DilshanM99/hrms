<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_employees_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'first_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'last_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => TRUE
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => TRUE
            ),
            'salary' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('employees');

        // Set timestamps
        $this->db->query("ALTER TABLE `employees` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE `employees` MODIFY `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }

    public function down()
    {
        $this->dbforge->drop_table('employees');
    }
}