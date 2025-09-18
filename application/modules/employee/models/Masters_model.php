<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Department methods
    // public function get_all_departments($search = '', $sort = 'id', $order = 'asc')
    // {
    //     $this->db->select('*');
    //     $this->db->from('departments');
    //     if ($search) {
    //         $this->db->like('name', $search);
    //     }
    //     $this->db->order_by($sort, $order);
    //     return $this->db->get()->result_array();
    // }

    public function get_department_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('departments')->row_array();
    }

    public function create_department($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('departments', $data);
    }

    public function update_department($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('departments', $data);
    }

    public function delete_department($id)
    {
        // Check if department is assigned to any employee
        $this->db->where('department_id', $id);
        $assigned = $this->db->get('employee_departments')->num_rows();
        if ($assigned > 0) {
            return FALSE;
        }
        $this->db->where('id', $id);
        return $this->db->delete('departments');
    }

    // Designation methods
    // public function get_all_designations($search = '', $sort = 'id', $order = 'asc')
    // {
    //     $this->db->select('*');
    //     $this->db->from('designations');
    //     if ($search) {
    //         $this->db->like('name', $search);
    //     }
    //     $this->db->order_by($sort, $order);
    //     return $this->db->get()->result_array();
    // }

    public function get_designation_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('designations')->row_array();
    }

    public function create_designation($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('designations', $data);
    }

    public function update_designation($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('designations', $data);
    }

    public function delete_designation($id)
    {
        // Check if designation is assigned to any employee
        $this->db->where('designation_id', $id);
        $assigned = $this->db->get('employee_designations')->num_rows();
        if ($assigned > 0) {
            return FALSE;
        }
        $this->db->where('id', $id);
        return $this->db->delete('designations');
    }

    // Employee Department methods
    public function get_employee_departments($employee_id)
    {
        $this->db->select('ed.*, d.name as department_name');
        $this->db->from('employee_departments ed');
        $this->db->join('departments d', 'ed.department_id = d.id');
        $this->db->where('ed.employee_id', $employee_id);
        return $this->db->get()->result_array();
    }

    public function assign_department($employee_id, $department_id, $assigned_date = NULL)
    {
        $data = array(
            'employee_id' => $employee_id,
            'department_id' => $department_id,
            'assigned_date' => $assigned_date ?: date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('employee_departments', $data);
    }

    public function update_employee_department($employee_id, $department_id, $assigned_date = NULL)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('department_id', $department_id);
        $data = array(
            'assigned_date' => $assigned_date ?: date('Y-m-d'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->update('employee_departments', $data);
    }

    public function remove_employee_department($employee_id, $department_id)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('department_id', $department_id);
        return $this->db->delete('employee_departments');
    }

    // Employee Designation methods
    public function get_employee_designations($employee_id)
    {
        $this->db->select('ed.*, des.name as designation_name');
        $this->db->from('employee_designations ed');
        $this->db->join('designations des', 'ed.designation_id = des.id');
        $this->db->where('ed.employee_id', $employee_id);
        return $this->db->get()->result_array();
    }

    public function assign_designation($employee_id, $designation_id, $assigned_date = NULL)
    {
        $data = array(
            'employee_id' => $employee_id,
            'designation_id' => $designation_id,
            'assigned_date' => $assigned_date ?: date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('employee_designations', $data);
    }

    public function update_employee_designation($employee_id, $designation_id, $assigned_date = NULL)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('designation_id', $designation_id);
        $data = array(
            'assigned_date' => $assigned_date ?: date('Y-m-d'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        return $this->db->update('employee_designations', $data);
    }

    public function remove_employee_designation($employee_id, $designation_id)
    {
        $this->db->where('employee_id', $employee_id);
        $this->db->where('designation_id', $designation_id);
        return $this->db->delete('employee_designations');
    }

    public function get_all_departments($search = '', $sort = 'name', $order = 'asc')
         {
             if ($search) {
                 $this->db->like('name', $search);
             }
             $this->db->order_by($sort, $order);
             return $this->db->get('departments')->result_array();
         }

         public function get_all_designations($search = '', $sort = 'name', $order = 'asc')
         {
             if ($search) {
                 $this->db->like('name', $search);
             }
             $this->db->order_by($sort, $order);
             return $this->db->get('designations')->result_array();
         }
}