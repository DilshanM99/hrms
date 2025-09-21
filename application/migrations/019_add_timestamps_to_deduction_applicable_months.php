<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_timestamps_to_deduction_applicable_months extends CI_Migration
{
    public function up()
    {
        // Add created_at and updated_at columns
        $this->dbforge->add_column('deduction_applicable_months', [
            'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('deduction_applicable_months', 'created_at');
        $this->dbforge->drop_column('deduction_applicable_months', 'updated_at');
    }
}
