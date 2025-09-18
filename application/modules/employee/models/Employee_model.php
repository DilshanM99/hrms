<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class Employee_model extends CI_Model {

//     public function __construct()
//     {
//         parent::__construct();
//         $this->load->database();
//     }

//     public function get_all($search = '', $sort = 'id', $order = 'asc')
//     {
//         $this->db->select('*');
//         $this->db->from('employees');
//         if ($search) {
//             $this->db->group_start();
//             $this->db->like('first_name', $search);
//             $this->db->or_like('last_name', $search);
//             $this->db->or_like('email', $search);
//             $this->db->group_end();
//         }
//         $this->db->order_by($sort, $order);
//         return $this->db->get()->result_array();
//     }

//     public function get_by_id($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->get('employees')->row_array();
//     }

//     public function create($data)
//     {
//         $data['created_at'] = date('Y-m-d H:i:s');
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         return $this->db->insert('employees', $data);
//     }

//     public function update($id, $data)
//     {
//         $data['updated_at'] = date('Y-m-d H:i:s');
//         $this->db->where('id', $id);
//         return $this->db->update('employees', $data);
//     }

//     public function delete($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->delete('employees');
//     }

//     public function get_all_employees($search = '', $sort = 'id', $order = 'asc')
//     {
//         if ($search) {
//             $this->db->like('first_name', $search);
//             $this->db->or_like('last_name', $search);
//             $this->db->or_like('email', $search);
//         }
//         $this->db->order_by($sort, $order);
//         return $this->db->get('employees')->result_array();
//     }

//     public function get_employee_by_id($id)
//     {
//         return $this->db->get_where('employees', ['id' => $id])->row_array();
//     }

//     public function create_employee($data)
//     {
//         return $this->db->insert('employees', $data);
//     }

//     public function update_employee($id, $data)
//     {
//         $this->db->where('id', $id);
//         return $this->db->update('employees', $data);
//     }

//     public function delete_employee($id)
//     {
//         $this->db->where('id', $id);
//         return $this->db->delete('employees');
//     }

//     public function count_all_employees()
//     {
//         return $this->db->count_all('employees');
//     }
// }



class Employee_model extends CI_Model {

    public function get_all_employees($search = '', $sort = 'id', $order = 'asc')
    {
        $this->db->select('e.*, d.name as department_name, des.name as designation_name');
        $this->db->from('employees e');
        $this->db->join('employee_departments ed', 'e.id = ed.employee_id', 'left');
        $this->db->join('departments d', 'ed.department_id = d.id', 'left');
        $this->db->join('employee_designations edes', 'e.id = edes.employee_id', 'left');
        $this->db->join('designations des', 'edes.designation_id = des.id', 'left');
        if ($search) {
            $this->db->group_start();
            $this->db->like('e.first_name', $search);
            $this->db->or_like('e.last_name', $search);
            $this->db->or_like('e.email', $search);
            $this->db->group_end();
        }
        $this->db->order_by($sort, $order);
        return $this->db->get()->result_array();
    }

    public function get_employee_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('employees')->row_array();
    }

    public function create_employee($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('employees', $data);
        return $this->db->insert_id();
    }

    public function update_employee($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('employees', $data);
    }

    public function delete_employee($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('employees');
    }

    public function count_all_employees()
    {
        return $this->db->count_all('employees');
    }

    // Employee Allowance/Deduction assignment methods
    public function assign_employee_allowance($employee_id, $allowance_data)
    {
        $data = array(
            'employee_id' => $employee_id,
            'allowance_id' => $allowance_data['id'],
            'amount' => $allowance_data['amount'],
            'start_date' => $allowance_data['start_date'],
            'expire_date' => $allowance_data['expire_date'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('employee_allowances', $data);
    }

    public function update_employee_allowance($employee_id, $allowance_id, $allowance_data)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('allowance_id', $allowance_id);
        $data = array(
            'amount' => $allowance_data['amount'],
            'start_date' => $allowance_data['start_date'],
            'expire_date' => $allowance_data['expire_date'],
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

    public function assign_employee_deduction($employee_id, $deduction_data)
    {
        $data = array(
            'employee_id' => $employee_id,
            'deduction_id' => $deduction_data['id'],
            'amount' => $deduction_data['amount'],
            'start_date' => $deduction_data['start_date'],
            'expire_date' => $deduction_data['expire_date'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('employee_deductions', $data);
    }

    public function update_employee_deduction($employee_id, $deduction_id, $deduction_data)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('deduction_id', $deduction_id);
        $data = array(
            'amount' => $deduction_data['amount'],
            'start_date' => $deduction_data['start_date'],
            'expire_date' => $deduction_data['expire_date'],
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
}