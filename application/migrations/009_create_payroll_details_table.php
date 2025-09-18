<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_payroll_details_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'payroll_run_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'employee_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ),
            'gross_salary' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'total_allowance' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'total_deduction' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'net_salary' => array(
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00
            ),
            'status' => array(
                'type' => 'ENUM',
                'constraint' => array('pending', 'paid'),
                'default' => 'pending'
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
        $this->dbforge->add_key('payroll_run_id');
        $this->dbforge->add_key('employee_id');
        $this->dbforge->add_key(array('payroll_run_id', 'employee_id'), FALSE);
        $this->dbforge->create_table('payroll_details');

        // Set timestamps
        $this->db->query("ALTER TABLE `payroll_details` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE `payroll_details` MODIFY `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");

        // Add foreign keys
        $this->db->query("ALTER TABLE `payroll_details` ADD CONSTRAINT `fk_payroll_details_run` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs`(`id`) ON DELETE CASCADE");
        $this->db->query("ALTER TABLE `payroll_details` ADD CONSTRAINT `fk_payroll_details_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees`(`id`) ON DELETE CASCADE");
    }

    public function down()
    {
        $this->dbforge->drop_table('payroll_details');
    }
}