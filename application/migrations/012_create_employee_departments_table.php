<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_employee_departments_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'employee_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'department_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'assigned_date' => array(
                'type' => 'DATE',
                'null' => TRUE
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
        $this->dbforge->add_key('employee_id');
        $this->dbforge->add_key('department_id');
        $this->dbforge->add_key(array('employee_id', 'department_id'), FALSE);
        $this->dbforge->create_table('employee_departments');

        // Set timestamps
        $this->db->query("ALTER TABLE `employee_departments` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE `employee_departments` MODIFY `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        // Add foreign keys
        $this->db->query("ALTER TABLE `employee_departments` ADD CONSTRAINT `fk_employee_departments_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE `employee_departments` ADD CONSTRAINT `fk_employee_departments_department` FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`) ON DELETE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('employee_departments');
    }
}