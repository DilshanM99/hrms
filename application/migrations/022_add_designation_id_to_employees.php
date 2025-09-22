<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration: Add designation_id to employees table
 * Adds designation_id column and foreign key to designations table
 */
class Migration_Add_designation_id_to_employees extends CI_Migration {

    public function up()
    {
        // Check if designation_id column exists
        $columns = $this->db->query("SHOW COLUMNS FROM employees LIKE 'designation_id'")->row_array();
        if (!$columns) {
            // Add designation_id column after department_id
            $fields = array(
                'designation_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'null' => FALSE,
                    'default' => 1  // Default to first designation ID (adjust if needed)
                )
            );
            $this->dbforge->add_column('employees', $fields);

            // Add foreign key constraint
            $this->db->query('ALTER TABLE employees ADD CONSTRAINT fk_employee_designation FOREIGN KEY (designation_id) REFERENCES designations(id) ON DELETE RESTRICT');
        }

        // Ensure designations table exists
        $this->db->query("
            CREATE TABLE IF NOT EXISTS designations (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                department_id INT(11) UNSIGNED NOT NULL,
                FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        // Insert default designation if none exist
        $this->db->query("INSERT IGNORE INTO designations (id, name, department_id) VALUES (1, 'General', 1)");
        
        // Update existing employees to have valid designation_id
        $this->db->query("UPDATE employees SET designation_id = 1 WHERE designation_id IS NULL");
    }

    public function down()
    {
        // Drop foreign key if it exists
        $this->db->query('ALTER TABLE employees DROP FOREIGN KEY fk_employee_designation');

        // Drop designation_id column if it exists
        $columns = $this->db->query("SHOW COLUMNS FROM employees LIKE 'designation_id'")->row_array();
        if ($columns) {
            $this->dbforge->drop_column('employees', 'designation_id');
        }
    }
}