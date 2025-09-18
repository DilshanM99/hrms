<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class Payroll_model extends CI_Model {

//     public function __construct()
//     {
//         parent::__construct();
//         $this->load->database();
//     }

//     // Allowance methods
//     public function get_all_allowances($search = '', $sort = 'id', $order = 'asc')
//     {
//         $this->db->select('*');
//         $this->db->from('allowances');
//         if ($search) {
//             $this->db->group_start();
//             $this->db->like('name', $search);
//             $this->db->or_like('description', $search);
//             $this->db->group_end();
//         }
//         $this->db->order_by($sort, $order);
//         return $this->db->get()->result_array();
//     }

//     public function get_allowance_by_id($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->get('allowances')->row_array();
//     }

//     public function create_allowance($data)
//     {
//         $data['created_at'] = date('Y-m-d H:i:s');
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         return $this->db->insert('allowances', $data);
//     }

//     public function update_allowance($id, $data)
//     {
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         $this->db->where('id', $id);
//         return $this->db->update('allowances', $data);
//     }

//     public function delete_allowance($id)
//     {
//         // Check if allowance is assigned to any employee
//         $this->db->where('allowance_id', $id);
//         $assigned = $this->db->get('employee_allowances')->num_rows();
//         if ($assigned > 0) {
//             return FALSE;
//         }
//         $this->db->where('id', $id);
//         return $this->db->delete('allowances');
//     }

//     // Deduction methods
//     public function get_all_deductions($search = '', $sort = 'id', $order = 'asc')
//     {
//         $this->db->select('*');
//         $this->db->from('deductions');
//         if ($search) {
//             $this->db->group_start();
//             $this->db->like('name', $search);
//             $this->db->or_like('description', $search);
//             $this->db->group_end();
//         }
//         $this->db->order_by($sort, $order);
//         return $this->db->get()->result_array();
//     }

//     public function get_deduction_by_id($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->get('deductions')->row_array();
//     }

//     public function create_deduction($data)
//     {
//         $data['created_at'] = date('Y-m-d H:i:s');
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         return $this->db->insert('deductions', $data);
//     }

//     public function update_deduction($id, $data)
//     {
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         $this->db->where('id', $id);
//         return $this->db->update('deductions', $data);
//     }

//     public function delete_deduction($id)
//     {
//         // Check if deduction is assigned to any employee
//         $this->db->where('deduction_id', $id);
//         $assigned = $this->db->get('employee_deductions')->num_rows();
//         if ($assigned > 0) {
//             return FALSE;
//         }
//         $this->db->where('id', $id);
//         return $this->db->delete('deductions');
//     }

//     // Employee Allowance methods
//     public function get_employee_allowances($employee_id)
//     {
//         $this->db->select('ea.*, a.name, a.type, a.description');
//         $this->db->from('employee_allowances ea');
//         $this->db->join('allowances a', 'ea.allowance_id = a.id');
//         $this->db->where('ea.employee_id', $employee_id);
//         return $this->db->get()->result_array();
//     }

//     public function assign_allowance($employee_id, $allowance_id, $amount)
//     {
//         $data = array(
//             'employee_id' => $employee_id,
//             'allowance_id' => $allowance_id,
//             'amount' => $amount,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s')
//         );
//         return $this->db->insert('employee_allowances', $data);
//     }

//     public function update_employee_allowance($employee_id, $allowance_id, $amount)
//     {
//         $this->db->where('employee_id', $employee_id);
//         $this->db->where('allowance_id', $allowance_id);
//         $data = array(
//             'amount' => $amount,
//             'updated_at' => date('Y-m-d H:i:s')
//         );
//         return $this->db->update('employee_allowances', $data);
//     }

//     public function remove_employee_allowance($employee_id, $allowance_id)
//     {
//         $this->db->where('employee_id', $employee_id);
//         $this->db->where('allowance_id', $allowance_id);
//         return $this->db->delete('employee_allowances');
//     }

//     // Employee Deduction methods
//     public function get_employee_deductions($employee_id)
//     {
//         $this->db->select('ed.*, d.name, d.type, d.description');
//         $this->db->from('employee_deductions ed');
//         $this->db->join('deductions d', 'ed.deduction_id = d.id');
//         $this->db->where('ed.employee_id', $employee_id);
//         return $this->db->get()->result_array();
//     }

//     public function assign_deduction($employee_id, $deduction_id, $amount)
//     {
//         $data = array(
//             'employee_id' => $employee_id,
//             'deduction_id' => $deduction_id,
//             'amount' => $amount,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s')
//         );
//         return $this->db->insert('employee_deductions', $data);
//     }

//     public function update_employee_deduction($employee_id, $deduction_id, $amount)
//     {
//         $this->db->where('employee_id', $employee_id);
//         $this->db->where('deduction_id', $deduction_id);
//         $data = array(
//             'amount' => $amount,
//             'updated_at' => date('Y-m-d H:i:s')
//         );
//         return $this->db->update('employee_deductions', $data);
//     }

//     public function remove_employee_deduction($employee_id, $deduction_id)
//     {
//         $this->db->where('employee_id', $employee_id);
//         $this->db->where('deduction_id', $deduction_id);
//         return $this->db->delete('employee_deductions');
//     }

//     // Payroll Run methods
//     public function get_all_payroll_runs($search = '', $sort = 'run_date', $order = 'desc')
//     {
//         $this->db->select('*');
//         $this->db->from('payroll_runs');
//         if ($search) {
//             $this->db->group_start();
//             $this->db->like('run_date', $search);
//             $this->db->or_like('status', $search);
//             $this->db->group_end();
//         }
//         $this->db->order_by($sort, $order);
//         return $this->db->get()->result_array();
//     }

//     public function get_payroll_run_by_id($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->get('payroll_runs')->row_array();
//     }

//     public function create_payroll_run($data)
//     {
//         $data['created_at'] = date('Y-m-d H:i:s');
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         return $this->db->insert('payroll_runs', $data);
//     }

//     public function update_payroll_run($id, $data)
//     {
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         $this->db->where('id', $id);
//         return $this->db->update('payroll_runs', $data);
//     }

//     public function delete_payroll_run($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->delete('payroll_runs');
//     }

//     public function get_payroll_details($run_id)
//     {
//         $this->db->select('pd.*, e.first_name, e.last_name, e.email');
//         $this->db->from('payroll_details pd');
//         $this->db->join('employees e', 'pd.employee_id = e.id');
//         $this->db->where('pd.payroll_run_id', $run_id);
//         return $this->db->get()->result_array();
//     }

//     public function generate_payroll_run($run_id)
//     {
//         // Get all active employees
//         $employees = $this->db->get_where('employees', array('status' => 'active'))->result_array();
//         $total_gross = 0;
//         $total_deductions = 0;
//         $total_net = 0;

//         foreach ($employees as $employee) {
//             $gross_salary = $employee['salary'];
//             $total_allowance = $this->get_employee_total_allowance($employee['id']);
//             $total_deduction = $this->get_employee_total_deduction($employee['id']);
//             $net_salary = $gross_salary + $total_allowance - $total_deduction;

//             $detail_data = array(
//                 'payroll_run_id' => $run_id,
//                 'employee_id' => $employee['id'],
//                 'gross_salary' => $gross_salary,
//                 'total_allowance' => $total_allowance,
//                 'total_deduction' => $total_deduction,
//                 'net_salary' => $net_salary,
//                 'status' => 'pending',
//                 'created_at' => date('Y-m-d H:i:s'),
//                 'updated_at' => date('Y-m-d H:i:s')
//             );

//             $this->db->insert('payroll_details', $detail_data);
//             $total_gross += $gross_salary;
//             $total_deductions += $total_deduction;
//             $total_net += $net_salary;
//         }

//         // Update payroll run totals
//         $this->db->where('id', $run_id);
//         $this->db->update('payroll_runs', array(
//             'total_gross' => $total_gross,
//             'total_deductions' => $total_deductions,
//             'total_net' => $total_net,
//             'status' => 'processed'
//         ));
//     }

//     private function get_employee_total_allowance($employee_id)
//     {
//         $this->db->select_sum('amount');
//         $this->db->from('employee_allowances');
//         $this->db->where('employee_id', $employee_id);
//         $query = $this->db->get();
//         return $query->row()->amount ?: 0;
//     }

//     private function get_employee_total_deduction($employee_id)
//     {
//         $this->db->select_sum('amount');
//         $this->db->from('employee_deductions');
//         $this->db->where('employee_id', $employee_id);
//         $query = $this->db->get();
//         return $query->row()->amount ?: 0;
//     }
// }





class Payroll_model extends CI_Model {

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
        return $this->db->insert('allowances', $data);
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

    public function get_employee_allowances($employee_id)
    {
        $this->db->select('a.id as allowance_id, a.name, a.type, ea.amount, ea.start_date, ea.expire_date');
        $this->db->from('employee_allowances ea');
        $this->db->join('allowances a', 'ea.allowance_id = a.id');
        $this->db->where('ea.employee_id', $employee_id);
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

    public function get_employee_deductions($employee_id)
    {
        $this->db->select('d.id as deduction_id, d.name, d.type, ed.amount, ed.start_date, ed.expire_date');
        $this->db->from('employee_deductions ed');
        $this->db->join('deductions d', 'ed.deduction_id = d.id');
        $this->db->where('ed.employee_id', $employee_id);
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
}