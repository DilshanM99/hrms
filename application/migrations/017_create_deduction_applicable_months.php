<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_deduction_applicable_months extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'deduction_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'month' => [
                'type' => 'TINYINT',
                'constraint' => 4,
                'comment' => '1-12 for Jan-Dec'
            ],
            'year' => [
                'type' => 'YEAR',
                'null' => TRUE
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('deduction_id');
        $this->dbforge->add_key('month');
        $this->dbforge->add_key('year');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (deduction_id) REFERENCES deductions(id) ON DELETE CASCADE');
        $this->dbforge->create_table('deduction_applicable_months');
    }

    public function down()
    {
        $this->dbforge->drop_table('deduction_applicable_months');
    }
}