<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters_service {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('employee/masters_model');
    }

    // Department methods
    public function get_all_departments($search = '', $sort = 'id', $order = 'asc')
    {
        return $this->CI->masters_model->get_all_departments($search, $sort, $order);
    }

    public function get_department($id)
    {
        return $this->CI->masters_model->get_department_by_id($id);
    }

    public function create_department($data)
    {
        return $this->CI->masters_model->create_department($data);
    }

    public function update_department($id, $data)
    {
        return $this->CI->masters_model->update_department($id, $data);
    }

    public function delete_department($id)
    {
        return $this->CI->masters_model->delete_department($id);
    }

    public function count_all_departments()
    {
        return $this->CI->db->count_all('departments');
    }

    // Designation methods
    public function get_all_designations($search = '', $sort = 'id', $order = 'asc')
    {
        return $this->CI->masters_model->get_all_designations($search, $sort, $order);
    }

    public function get_designation($id)
    {
        return $this->CI->masters_model->get_designation_by_id($id);
    }

    public function create_designation($data)
    {
        return $this->CI->masters_model->create_designation($data);
    }

    public function update_designation($id, $data)
    {
        return $this->CI->masters_model->update_designation($id, $data);
    }

    public function delete_designation($id)
    {
        return $this->CI->masters_model->delete_designation($id);
    }

    public function count_all_designations()
    {
        return $this->CI->db->count_all('designations');
    }

    // Employee Department methods
    public function get_employee_departments($employee_id)
    {
        return $this->CI->masters_model->get_employee_departments($employee_id);
    }

    // public function assign_department($employee_id, $department_id, $assigned_date = NULL)
    // {
    //     return $this->CI->masters_model->assign_department($employee_id, $department_id, $assigned_date);
    // }

    public function update_employee_department($employee_id, $department_id, $assigned_date = NULL)
    {
        return $this->CI->masters_model->update_employee_department($employee_id, $department_id, $assigned_date);
    }

    // public function remove_employee_department($employee_id, $department_id)
    // {
    //     return $this->CI->masters_model->remove_employee_department($employee_id, $department_id);
    // }

    // Employee Designation methods
    public function get_employee_designations($employee_id)
    {
        return $this->CI->masters_model->get_employee_designations($employee_id);
    }

    // public function assign_designation($employee_id, $designation_id, $assigned_date = NULL)
    // {
    //     return $this->CI->masters_model->assign_designation($employee_id, $designation_id, $assigned_date);
    // }

    public function update_employee_designation($employee_id, $designation_id, $assigned_date = NULL)
    {
        return $this->CI->masters_model->update_employee_designation($employee_id, $designation_id, $assigned_date);
    }

    // public function remove_employee_designation($employee_id, $designation_id)
    // {
    //     return $this->CI->masters_model->remove_employee_designation($employee_id, $designation_id);
    // }

    public function remove_employee_designation($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_designations');
    }

    public function assign_department($employee_id, $department_id)
    {
        $data = [
            'employee_id' => $employee_id,
            'department_id' => $department_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->CI->db->insert('employee_departments', $data);
    }

    public function assign_designation($employee_id, $designation_id)
    {
        $data = [
            'employee_id' => $employee_id,
            'designation_id' => $designation_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->CI->db->insert('employee_designations', $data);
    }

    // public function update_employee_department($employee_id, $department_id)
    // {
    //     $this->CI->db->where('employee_id', $employee_id);
    //     $this->CI->db->delete('employee_departments');
    //     return $this->assign_department($employee_id, $department_id);
    // }

    // public function update_employee_designation($employee_id, $designation_id)
    // {
    //     $this->CI->db->where('employee_id', $employee_id);
    //     $this->CI->db->delete('employee_designations');
    //     return $this->assign_designation($employee_id, $designation_id);
    // }

    public function remove_employee_department($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_departments');
    }

    

    // public function remove_employee_designation($employee_id)
    // {
    //     $this->CI->db->where('employee_id', $employee_id);
    //     return $this->CI->db->delete('employee_designations');
    // }

    public function get_employee_department($employee_id)
    {
        $this->CI->db->select('department_id');
        $this->CI->db->where('employee_id', $employee_id);
        $query = $this->CI->db->get('employee_departments');
        $result = $query->row_array();
        return $result ? $result['department_id'] : null;
    }

    public function get_employee_designation($employee_id)
    {
        $this->CI->db->select('designation_id');
        $this->CI->db->where('employee_id', $employee_id);
        $query = $this->CI->db->get('employee_designations');
        $result = $query->row_array();
        return $result ? $result['designation_id'] : null;
    }
    

    
}