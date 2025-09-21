<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration: Add department_id to employees table
 * Adds department_id column and foreign key to departments table
 */
class Migration_Add_department_id_to_employees extends CI_Migration {

    public function up()
    {
        // Check if department_id column exists
        $columns = $this->db->query("SHOW COLUMNS FROM employees LIKE 'department_id'")->row_array();
        if (!$columns) {
            // Add department_id column after phone
            $fields = array(
                'department_id' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'null' => FALSE,
                    'default' => 1  // Default to first department ID (adjust if needed)
                )
            );
            $this->dbforge->add_column('employees', $fields);

            // Add foreign key constraint
            $this->db->query('ALTER TABLE employees ADD CONSTRAINT fk_employee_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT');
        }

        // Ensure departments table exists
        $this->db->query("
            CREATE TABLE IF NOT EXISTS departments (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        // Insert default department if none exist
        $this->db->query("INSERT IGNORE INTO departments (id, name) VALUES (1, 'General')");
        
        // Update existing employees to have valid department_id
        $this->db->query("UPDATE employees SET department_id = 1 WHERE department_id IS NULL");
    }

    public function down()
    {
        // Drop foreign key if it exists
        $this->db->query('ALTER TABLE employees DROP FOREIGN KEY fk_employee_department');

        // Drop department_id column if it exists
        $columns = $this->db->query("SHOW COLUMNS FROM employees LIKE 'department_id'")->row_array();
        if ($columns) {
            $this->dbforge->drop_column('employees', 'department_id');
        }
    }
}