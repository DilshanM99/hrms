<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_department_id_to_designations extends CI_Migration {

    public function up()
    {
        // Check if department_id column exists
        $columns = $this->db->query("SHOW COLUMNS FROM designations LIKE 'department_id'")->row_array();
        if (!$columns) {
            // Add department_id column
            $fields = array(
                'department_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'null' => FALSE
                )
            );
            $this->dbforge->add_column('designations', $fields);
        } else {
            // Ensure department_id is INT(11) UNSIGNED NOT NULL
            $this->db->query("ALTER TABLE designations MODIFY department_id INT(11) UNSIGNED NOT NULL");
        }

        // Ensure at least one department exists
        $department_exists = $this->db->count_all('departments');
        if ($department_exists == 0) {
            $this->db->insert('departments', array(
                'name' => 'General',
                'description' => 'Default department for unassigned designations',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ));
        }

        // Set default department_id for existing designations
        $this->db->query('UPDATE designations SET department_id = (SELECT id FROM departments ORDER BY id LIMIT 1) WHERE department_id IS NULL OR department_id NOT IN (SELECT id FROM departments)');

        // Check if foreign key exists
        $fk_exists = $this->db->query("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_NAME = 'designations' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME = 'fk_designation_department'")->row_array();
        if (!$fk_exists) {
            // Add foreign key constraint
            $this->db->query('ALTER TABLE designations ADD CONSTRAINT fk_designation_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT');
        }
    }

    public function down()
    {
        // Remove foreign key if it exists
        $fk_exists = $this->db->query("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_NAME = 'designations' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME = 'fk_designation_department'")->row_array();
        if ($fk_exists) {
            $this->db->query('ALTER TABLE designations DROP FOREIGN KEY fk_designation_department');
        }

        // Remove department_id column if it exists
        $columns = $this->db->query("SHOW COLUMNS FROM designations LIKE 'department_id'")->row_array();
        if ($columns) {
            $this->dbforge->drop_column('designations', 'department_id');
        }
    }
}