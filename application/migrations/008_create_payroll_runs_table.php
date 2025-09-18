<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_payroll_runs_table extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'run_date' => array(
                'type' => 'DATE'
            ),
            'period_start' => array(
                'type' => 'DATE'
            ),
            'period_end' => array(
                'type' => 'DATE'
            ),
            'status' => array(
                'type' => 'ENUM',
                'constraint' => array('draft', 'processed', 'paid', 'archived'),
                'default' => 'draft'
            ),
            'total_gross' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0.00
            ),
            'total_deductions' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => 0.00
            ),
            'total_net' => array(
                'type' => 'DECIMAL',
                'constraint' => '12,2',
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
        $this->dbforge->add_key('run_date');
        $this->dbforge->create_table('payroll_runs');

        // Set timestamps
        $this->db->query("ALTER TABLE `payroll_runs` MODIFY `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $this->db->query("ALTER TABLE `payroll_runs` MODIFY `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
    }

    public function down()
    {
        $this->dbforge->drop_table('payroll_runs');
    }
}