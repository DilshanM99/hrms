<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_dates_to_employee_allowances extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('employee_allowances', array(
            'start_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            ),
            'expire_date' => array(
                'type' => 'DATE',
                'null' => TRUE
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('employee_allowances', 'start_date');
        $this->dbforge->drop_column('employee_allowances', 'expire_date');
    }
}