<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class Masters_service {

//     protected $CI;

//     public function __construct()
//     {
//         $this->CI =& get_instance();
//         $this->CI->load->model('employee/masters_model');
//     }

//     // Department methods
//     public function get_all_departments($search = '', $sort = 'id', $order = 'asc')
//     {
//         return $this->CI->masters_model->get_all_departments($search, $sort, $order);
//     }

//     public function get_department($id)
//     {
//         return $this->CI->masters_model->get_department_by_id($id);
//     }

//     public function create_department($data)
//     {
//         return $this->CI->masters_model->create_department($data);
//     }

//     public function update_department($id, $data)
//     {
//         return $this->CI->masters_model->update_department($id, $data);
//     }

//     public function delete_department($id)
//     {
//         return $this->CI->masters_model->delete_department($id);
//     }

//     public function count_all_departments()
//     {
//         return $this->CI->db->count_all('departments');
//     }

//     // Designation methods
//     public function get_all_designations($search = '', $sort = 'id', $order = 'asc')
//     {
//         return $this->CI->masters_model->get_all_designations($search, $sort, $order);
//     }

//     public function get_designation($id)
//     {
//         return $this->CI->masters_model->get_designation_by_id($id);
//     }

//     public function create_designation($data)
//     {
//         return $this->CI->masters_model->create_designation($data);
//     }

//     public function update_designation($id, $data)
//     {
//         return $this->CI->masters_model->update_designation($id, $data);
//     }

//     public function delete_designation($id)
//     {
//         return $this->CI->masters_model->delete_designation($id);
//     }

//     public function count_all_designations()
//     {
//         return $this->CI->db->count_all('designations');
//     }

//     // Employee Department methods
//     public function get_employee_departments($employee_id)
//     {
//         return $this->CI->masters_model->get_employee_departments($employee_id);
//     }

//     // public function assign_department($employee_id, $department_id, $assigned_date = NULL)
//     // {
//     //     return $this->CI->masters_model->assign_department($employee_id, $department_id, $assigned_date);
//     // }

//     public function update_employee_department($employee_id, $department_id, $assigned_date = NULL)
//     {
//         return $this->CI->masters_model->update_employee_department($employee_id, $department_id, $assigned_date);
//     }

//     // public function remove_employee_department($employee_id, $department_id)
//     // {
//     //     return $this->CI->masters_model->remove_employee_department($employee_id, $department_id);
//     // }

//     // Employee Designation methods
//     public function get_employee_designations($employee_id)
//     {
//         return $this->CI->masters_model->get_employee_designations($employee_id);
//     }

//     // public function assign_designation($employee_id, $designation_id, $assigned_date = NULL)
//     // {
//     //     return $this->CI->masters_model->assign_designation($employee_id, $designation_id, $assigned_date);
//     // }

//     public function update_employee_designation($employee_id, $designation_id, $assigned_date = NULL)
//     {
//         return $this->CI->masters_model->update_employee_designation($employee_id, $designation_id, $assigned_date);
//     }

//     // public function remove_employee_designation($employee_id, $designation_id)
//     // {
//     //     return $this->CI->masters_model->remove_employee_designation($employee_id, $designation_id);
//     // }

//     public function remove_employee_designation($employee_id)
//     {
//         $this->CI->db->where('employee_id', $employee_id);
//         return $this->CI->db->delete('employee_designations');
//     }

//     public function assign_department($employee_id, $department_id)
//     {
//         $data = [
//             'employee_id' => $employee_id,
//             'department_id' => $department_id,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s')
//         ];
//         return $this->CI->db->insert('employee_departments', $data);
//     }

//     public function assign_designation($employee_id, $designation_id)
//     {
//         $data = [
//             'employee_id' => $employee_id,
//             'designation_id' => $designation_id,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s')
//         ];
//         return $this->CI->db->insert('employee_designations', $data);
//     }

//     // public function update_employee_department($employee_id, $department_id)
//     // {
//     //     $this->CI->db->where('employee_id', $employee_id);
//     //     $this->CI->db->delete('employee_departments');
//     //     return $this->assign_department($employee_id, $department_id);
//     // }

//     // public function update_employee_designation($employee_id, $designation_id)
//     // {
//     //     $this->CI->db->where('employee_id', $employee_id);
//     //     $this->CI->db->delete('employee_designations');
//     //     return $this->assign_designation($employee_id, $designation_id);
//     // }

//     public function remove_employee_department($employee_id)
//     {
//         $this->CI->db->where('employee_id', $employee_id);
//         return $this->CI->db->delete('employee_departments');
//     }

    

//     // public function remove_employee_designation($employee_id)
//     // {
//     //     $this->CI->db->where('employee_id', $employee_id);
//     //     return $this->CI->db->delete('employee_designations');
//     // }

//     public function get_employee_department($employee_id)
//     {
//         $this->CI->db->select('department_id');
//         $this->CI->db->where('employee_id', $employee_id);
//         $query = $this->CI->db->get('employee_departments');
//         $result = $query->row_array();
//         return $result ? $result['department_id'] : null;
//     }

//     public function get_employee_designation($employee_id)
//     {
//         $this->CI->db->select('designation_id');
//         $this->CI->db->where('employee_id', $employee_id);
//         $query = $this->CI->db->get('employee_designations');
//         $result = $query->row_array();
//         return $result ? $result['designation_id'] : null;
//     }
    

    
// }


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

    /**
     * Fetches all departments for dropdown.
     * @return array List of departments
     */
    public function get_all_departments_for_dropdown()
    {
        $this->CI->db->select('id, name');
        $this->CI->db->from('departments');
        $this->CI->db->order_by('name', 'ASC');
        return $this->CI->db->get()->result_array();
    }

    // Designation methods
    /**
     * Fetches all designations with department names.
     * @param string $search Search term
     * @param string $sort Column to sort by
     * @param string $order Sort order (asc/desc)
     * @return array List of designations
     */
    public function get_all_designations($search = '', $sort = 'id', $order = 'asc')
    {
        $this->CI->db->select('d.id, d.name, d.description, dept.name as department_name');
        $this->CI->db->from('designations d');
        $this->CI->db->join('departments dept', 'd.department_id = dept.id', 'left');
        
        if ($search) {
            $this->CI->db->group_start();
            $this->CI->db->like('d.name', $search);
            $this->CI->db->or_like('d.description', $search);
            $this->CI->db->or_like('dept.name', $search);
            $this->CI->db->group_end();
        }
        
        $this->CI->db->order_by($sort, $order);
        return $this->CI->db->get()->result_array();
    }

    public function get_all_designations_for_dropdown()
    {
        log_message('debug', 'Fetching all designations for dropdown');
        $query = $this->CI->db->select('id, name, department_id')->get('designations');
        $result = $query->result_array();
        log_message('debug', 'Designations for dropdown: ' . print_r($result, TRUE));
        return $result;
    }

    /**
     * Fetches a single designation by ID.
     * @param int $id Designation ID
     * @return array|null Designation data
     */
    public function get_designation($id)
    {
        $this->CI->db->select('d.id, d.name, d.description, d.department_id, dept.name as department_name');
        $this->CI->db->from('designations d');
        $this->CI->db->join('departments dept', 'd.department_id = dept.id', 'left');
        $this->CI->db->where('d.id', $id);
        return $this->CI->db->get()->row_array();
    }

    /**
     * Creates a new designation with department_id.
     * @param array $data Designation data
     * @return bool Success status
     */
    public function create_designation($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->CI->db->insert('designations', $data);
    }

    /**
     * Updates a designation.
     * @param int $id Designation ID
     * @param array $data Designation data
     * @return bool Success status
     */
    // public function update_designation($id, $data)
    // {
    //     $data['updated_at'] = date('Y-m-d H:i:s');
    //     $this->CI->db->where('id', $id);
    //     return $this->CI->db->update('designations', $data);
    // }

    public function update_designation($id, $data)
    {
        log_message('debug', 'Updating designation ID: ' . $id . ' with data: ' . print_r($data, TRUE));
        try {
            $this->CI->db->where('id', $id);
            $result = $this->CI->db->update('designations', $data);
            log_message('debug', 'Update designation result: ' . ($result ? 'Success' : 'Failed'));
            return $result ? TRUE : 'Failed to update designation due to database error.';
        } catch (Exception $e) {
            log_message('error', 'Update designation failed: ' . $e->getMessage());
            if ($e->getCode() == 1062) {
                return 'The designation name "' . $data['name'] . '" is already in use.';
            }
            return 'Failed to update designation: ' . $e->getMessage();
        }
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

    public function update_employee_department($employee_id, $department_id, $assigned_date = NULL)
    {
        return $this->CI->masters_model->update_employee_department($employee_id, $department_id, $assigned_date);
    }

    public function remove_employee_department($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_departments');
    }

    // Employee Designation methods
    public function get_employee_designations($employee_id)
    {
        return $this->CI->masters_model->get_employee_designations($employee_id);
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

    public function update_employee_designation($employee_id, $designation_id, $assigned_date = NULL)
    {
        return $this->CI->masters_model->update_employee_designation($employee_id, $designation_id, $assigned_date);
    }

    public function remove_employee_designation($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_designations');
    }

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

    public function is_designation_name_exists($name, $exclude_id = null)
{
    $this->CI->db->where('name', $name);
    if ($exclude_id) {
        $this->CI->db->where('id !=', $exclude_id);
    }
    $query = $this->CI->db->get('designations');
    return $query->num_rows() > 0;
}

}