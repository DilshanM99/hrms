<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function get_all_allowances($search = '', $sort = 'id', $order = 'asc')
    {
        if ($search) {
            $this->db->like('name', $search);
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('allowances')->result_array();
    }

    public function get_allowance_by_id($id)
    {
        return $this->db->get_where('allowances', ['id' => $id])->row_array();
    }

    public function create_allowance($data)
    {
        $this->db->insert('allowances', $data);
        return $this->db->insert_id();
    }

    public function update_allowance($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('allowances', $data);
    }

    public function delete_allowance($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('allowances');
    }

    public function get_all_deductions($search = '', $sort = 'id', $order = 'asc')
    {
        if ($search) {
            $this->db->like('name', $search);
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('deductions')->result_array();
    }

    public function get_deduction_by_id($id)
    {
        return $this->db->get_where('deductions', ['id' => $id])->row_array();
    }

    public function create_deduction($data)
    {
        return $this->db->insert('deductions', $data);
    }

    public function update_deduction($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('deductions', $data);
    }

    public function delete_deduction($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('deductions');
    }

    // public function get_employee_allowances($employee_id)
    // {
    //     $this->db->select('a.id as allowance_id, a.name, a.type, ea.amount, ea.start_date, ea.expire_date');
    //     $this->db->from('employee_allowances ea');
    //     $this->db->join('allowances a', 'ea.allowance_id = a.id');
    //     $this->db->where('ea.employee_id', $employee_id);
    //     return $this->db->get()->result_array();
    // }

    
    public function get_employee_allowances($employee_id, $month = null, $year = null)
    {
        $this->db->select('ea.*, a.name, a.type, a.amount as default_amount');
        $this->db->from('employee_allowances ea');
        $this->db->join('allowances a', 'a.id = ea.allowance_id');
        $this->db->where('ea.employee_id', $employee_id);

        if ($month) {
            // For fixed, always include
            $this->db->join('allowances aam', 'aam.id = a.id', 'left');
            $this->db->group_start();
            $this->db->where('a.type', 'fixed');
            $this->db->or_group_start()
                ->where('a.type', 'variable')
                ->where('a.id IN (SELECT allowance_id FROM allowance_applicable_months WHERE month = ' . $month . ' AND (year IS NULL OR year = ' . $year . '))')
                ->group_end()
                ->group_end();
        }

        return $this->db->get()->result_array();
    }
    public function assign_allowance($employee_id, $allowance_id, $amount, $start_date = NULL, $expire_date = NULL)
    {
        $data = array(
            'employee_id' => $employee_id,
            'allowance_id' => $allowance_id,
            'amount' => $amount,
            'start_date' => $start_date ?: date('Y-m-d'),
            'expire_date' => $expire_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('employee_allowances', $data);
    }

    public function update_employee_allowance($employee_id, $allowance_id, $amount, $start_date = NULL, $expire_date = NULL)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('allowance_id', $allowance_id);
        $data = array(
            'amount' => $amount,
            'start_date' => $start_date ?: date('Y-m-d'),
            'expire_date' => $expire_date,
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->update('employee_allowances', $data);
    }

    public function remove_employee_allowance($employee_id, $allowance_id)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('allowance_id', $allowance_id);
        return $this->db->delete('employee_allowances');
    }

    // public function get_employee_deductions($employee_id)
    // {
    //     $this->db->select('d.id as deduction_id, d.name, d.type, ed.amount, ed.start_date, ed.expire_date');
    //     $this->db->from('employee_deductions ed');
    //     $this->db->join('deductions d', 'ed.deduction_id = d.id');
    //     $this->db->where('ed.employee_id', $employee_id);
    //     return $this->db->get()->result_array();
    // }

    
    public function get_employee_deductions($employee_id, $month = null, $year = null)
    {
        $this->db->select('ed.*, d.name, d.type, d.amount as default_amount');
        $this->db->from('employee_deductions ed');
        $this->db->join('deductions d', 'd.id = ed.deduction_id');
        $this->db->where('ed.employee_id', $employee_id);

        if ($month) {
            // For fixed, always include
            $this->db->join('deductions dam', 'dam.id = d.id', 'left');
            $this->db->group_start();
            $this->db->where('d.type', 'fixed');
            $this->db->or_group_start()
                ->where('d.type', 'variable')
                ->where('d.id IN (SELECT deduction_id FROM deduction_applicable_months WHERE month = ' . $month . ' AND (year IS NULL OR year = ' . $year . '))')
                ->group_end()
                ->group_end();
        }

        return $this->db->get()->result_array();
    }
    
    public function assign_deduction($employee_id, $deduction_id, $amount, $start_date = NULL, $expire_date = NULL)
    {
        $data = array(
            'employee_id' => $employee_id,
            'deduction_id' => $deduction_id,
            'amount' => $amount,
            'start_date' => $start_date ?: date('Y-m-d'),
            'expire_date' => $expire_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('employee_deductions', $data);
    }

    public function update_employee_deduction($employee_id, $deduction_id, $amount, $start_date = NULL, $expire_date = NULL)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('deduction_id', $deduction_id);
        $data = array(
            'amount' => $amount,
            'start_date' => $start_date ?: date('Y-m-d'),
            'expire_date' => $expire_date,
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->update('employee_deductions', $data);
    }

    public function remove_employee_deduction($employee_id, $deduction_id)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('deduction_id', $deduction_id);
        return $this->db->delete('employee_deductions');
    }

    public function get_all_payroll_runs($search = '', $sort = 'run_date', $order = 'desc', $limit = NULL)
    {
        if ($search) {
            $this->db->like('run_date', $search);
        }
        $this->db->order_by($sort, $order);
        if ($limit) {
            $this->db->limit($limit);
        }
        return $this->db->get('payroll_runs')->result_array();
    }

    public function get_payroll_run_by_id($id)
    {
        return $this->db->get_where('payroll_runs', ['id' => $id])->row_array();
    }

    public function create_payroll_run($data)
    {
        return $this->db->insert('payroll_runs', $data);
    }

    public function update_payroll_run($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('payroll_runs', $data);
    }

    public function delete_payroll_run($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('payroll_runs');
    }

    public function get_payroll_details($run_id)
    {
        $this->db->select('pd.*, e.first_name, e.last_name');
        $this->db->from('payroll_details pd');
        $this->db->join('employees e', 'pd.employee_id = e.id');
        $this->db->where('pd.run_id', $run_id);
        return $this->db->get()->result_array();
    }

    public function generate_payroll_run($run_id)
    {
        // Placeholder for payroll generation logic
        // Should calculate salaries, allowances, deductions, and insert into payroll_details
        return TRUE;
    }

    public function count_active_payroll_runs()
    {
        $this->db->where('status', 'active');
        return $this->db->count_all_results('payroll_runs');
    }

    // variable allowance allocation

    public function get_applicable_months_for_allowance($allowance_id, $year = null)
    {
        $this->db->where('allowance_id', $allowance_id);
        if ($year) {
            $this->db->where('year', $year);
        }
        return $this->db->get('allowance_applicable_months')->result_array();
    }

    public function assign_months_to_allowance($allowance_id, $months, $year = null)
    {
        $this->db->where('allowance_id', $allowance_id);
        $this->db->delete('allowance_applicable_months');

        $data = [];
        foreach ($months as $month) {
            $data[] = [
                'allowance_id' => $allowance_id,
                'month' => $month,
                'year' => $year,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        $this->db->insert_batch('allowance_applicable_months', $data);
        return true;
    }

    public function assign_employee_allowance($employee_id, $allowance_id, $amount, $start_date = null, $expire_date = null)
    {
        $data = [
            'employee_id' => $employee_id,
            'allowance_id' => $allowance_id,
            'amount' => $amount,
            'start_date' => $start_date,
            'expire_date' => $expire_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('employee_allowances', $data);
    }

    public function assign_employee_deduction($employee_id, $deduction_id, $amount, $start_date = null, $expire_date = null)
    {
        $data = [
            'employee_id' => $employee_id,
            'deduction_id' => $deduction_id,
            'amount' => $amount,
            'start_date' => $start_date,
            'expire_date' => $expire_date,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('employee_deductions', $data);
    }
}