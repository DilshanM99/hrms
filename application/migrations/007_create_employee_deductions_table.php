<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_employee_deductions_table extends CI_Migration {

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
            'deduction_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'amount' => array(
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
        $this->dbforge->add_key('employee_id');
        $this->dbforge->add_key('deduction_id');
        $this->dbforge->add_key(array('employee_id', 'deduction_id'), FALSE);
        $this->dbforge->create_table('employee_deductions');

        // Set timestamps
        $this->db->query("ALTER TABLE `employee_deductions` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE `employee_deductions` MODIFY `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        // Add foreign keys
        $this->db->query("ALTER TABLE `employee_deductions` ADD CONSTRAINT `fk_employee_deductions_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE `employee_deductions` ADD CONSTRAINT `fk_employee_deductions_deduction` FOREIGN KEY (`deduction_id`) REFERENCES `deductions`(`id`) ON DELETE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('employee_deductions');
    }
}