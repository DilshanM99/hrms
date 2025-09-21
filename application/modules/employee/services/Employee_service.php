<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Employee_service {

//     protected $CI;

//     public function __construct()
//     {
//         $this->CI =& get_instance();
//         $this->CI->load->model('employee/employee_model');
//     }

//     public function get_all_employees($search = '', $sort = 'id', $order = 'asc')
//     {
//         return $this->CI->employee_model->get_all($search, $sort, $order);
//     }

//     public function get_employee($id)
//     {
//         return $this->CI->employee_model->get_by_id($id);
//     }

//     public function create_employee($data)
//     {
//         return $this->CI->employee_model->create($data);
//     }

//     public function update_employee($id, $data)
//     {
//         return $this->CI->employee_model->update($id, $data);
//     }

//     public function delete_employee($id)
//     {
//         return $this->CI->employee_model->delete($id);
//     }

//     public function count_all_employees()
//     {
//         return $this->CI->employee_model->count_all_employees();
//     }
// }





class Employee_service {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('employee/employee_model');
        $this->CI->load->service('payroll/payroll_service');
        $this->CI->load->service('employee/masters_service');
    }

    public function get_all_employees($search = '', $sort = 'id', $order = 'asc')
    {
        return $this->CI->employee_model->get_all_employees($search, $sort, $order);
    }

    public function get_employee($id)
    {
        $employee = $this->CI->employee_model->get_employee_by_id($id);
        if ($employee) {
            $employee['department_id'] = $this->CI->masters_service->get_employee_department($id);
            $employee['designation_id'] = $this->CI->masters_service->get_employee_designation($id);
        }
        return $employee;
    }

    public function create_employee($data)
    {
        return $this->CI->employee_model->create_employee($data);
    }

    public function update_employee($id, $data)
    {
        return $this->CI->employee_model->update_employee($id, $data);
    }

    public function delete_employee($id)
    {
        $this->CI->payroll_service->remove_employee_allowances($id, array_column($this->CI->payroll_service->get_employee_allowances($id), 'allowance_id'));
        $this->CI->payroll_service->remove_employee_deductions($id, array_column($this->CI->payroll_service->get_employee_deductions($id), 'deduction_id'));
        $this->CI->masters_service->remove_employee_department($id);
        $this->CI->masters_service->remove_employee_designation($id);
        return $this->CI->employee_model->delete_employee($id);
    }

    public function count_all_employees()
    {
        return $this->CI->employee_model->count_all_employees();
    }

    public function assign_employee_allowances($employee_id, $allowances_data)
    {
        $success = true;
        foreach ($allowances_data as $allowance_data) {
            // Fetch default amount if not provided
            $amount = !empty($allowance_data['amount']) ? $allowance_data['amount'] : $this->CI->payroll_service->get_allowance_default_amount($allowance_data['id']);
            if (!$this->CI->payroll_service->assign_allowance(
                $employee_id,
                $allowance_data['id'],
                $amount,
                $allowance_data['start_date'] ?: null,
                $allowance_data['expire_date'] ?: null
            )) {
                $success = false;
            }
        }
        return $success;
    }

    public function update_employee_allowances($employee_id, $allowances_data)
    {
        $success = true;
        foreach ($allowances_data as $allowance_data) {
            // Fetch default amount if not provided
            $amount = !empty($allowance_data['amount']) ? $allowance_data['amount'] : $this->CI->payroll_service->get_allowance_default_amount($allowance_data['id']);
            if (!$this->CI->payroll_service->update_employee_allowance(
                $employee_id,
                $allowance_data['id'],
                $amount,
                $allowance_data['start_date'] ?: null,
                $allowance_data['expire_date'] ?: null
            )) {
                $success = false;
            }
        }
        return $success;
    }

    public function remove_employee_allowances($employee_id, $allowance_ids)
    {
        $success = true;
        foreach ($allowance_ids as $allowance_id) {
            if (!$this->CI->payroll_service->remove_employee_allowances($employee_id, $allowance_id)) {
                $success = false;
            }
        }
        return $success;
    }

    public function assign_employee_deductions($employee_id, $deductions_data)
    {
        $success = true;
        foreach ($deductions_data as $deduction_data) {
            // Fetch default amount if not provided
            $amount = !empty($deduction_data['amount']) ? $deduction_data['amount'] : $this->CI->payroll_service->get_deduction_default_amount($deduction_data['id']);
            if (!$this->CI->payroll_service->assign_deduction(
                $employee_id,
                $deduction_data['id'],
                $amount,
                $deduction_data['start_date'] ?: null,
                $deduction_data['expire_date'] ?: null
            )) {
                $success = false;
            }
        }
        return $success;
    }

    public function update_employee_deductions($employee_id, $deductions_data)
    {
        $success = true;
        foreach ($deductions_data as $deduction_data) {
            // Fetch default amount if not provided
            $amount = !empty($deduction_data['amount']) ? $deduction_data['amount'] : $this->CI->payroll_service->get_deduction_default_amount($deduction_data['id']);
            if (!$this->CI->payroll_service->update_employee_deduction(
                $employee_id,
                $deduction_data['id'],
                $amount,
                $deduction_data['start_date'] ?: null,
                $deduction_data['expire_date'] ?: null
            )) {
                $success = false;
            }
        }
        return $success;
    }

    public function remove_employee_deductions($employee_id, $deduction_ids)
    {
        $success = true;
        foreach ($deduction_ids as $deduction_id) {
            if (!$this->CI->payroll_service->remove_employee_deduction($employee_id, $deduction_id)) {
                $success = false;
            }
        }
        return $success;
    }

    public function remove_employee_department($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_departments');
    }

    public function remove_employee_designation($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_designations');
    }

    public function bulk_assign_allowances($allowance_ids, $department_ids, $designation_ids, $employee_ids, $amount, $start_date, $expire_date)
    {
        log_message('debug', 'Bulk assigning allowances: ' . print_r($allowance_ids, TRUE));
        $this->CI->db->trans_start();
        try {
            // Fetch employees based on selections
            $this->CI->db->select('id');
            if (!empty($employee_ids)) {
                $this->CI->db->where_in('id', $employee_ids);
            }
            if (!empty($department_ids)) {
                $this->CI->db->where_in('department_id', $department_ids);
            }
            if (!empty($designation_ids)) {
                $this->CI->db->where_in('designation_id', $designation_ids);
            }
            $query = $this->CI->db->get('employees');
            $employees = $query->result_array();
            log_message('debug', 'Employees to assign allowances: ' . print_r($employees, TRUE));

            if (empty($employees)) {
                $this->CI->db->trans_rollback();
                return 'No employees found for the selected criteria.';
            }

            // Check existing allowances to prevent duplicates
            foreach ($employees as $employee) {
                foreach ($allowance_ids as $allowance_id) {
                    $this->CI->db->where('employee_id', $employee['id']);
                    $this->CI->db->where('allowance_id', $allowance_id);
                    $query = $this->CI->db->get('employee_allowances');
                    if ($query->num_rows() == 0) {
                        $allowance_data = array(
                            'employee_id' => $employee['id'],
                            'allowance_id' => $allowance_id,
                            'amount' => $amount,
                            'start_date' => $start_date,
                            'expire_date' => $expire_date
                        );
                        $this->CI->db->insert('employee_allowances', $allowance_data);
                    }
                }
            }

            $this->CI->db->trans_complete();
            if ($this->CI->db->trans_status() === FALSE) {
                log_message('error', 'Bulk assign allowances transaction failed');
                return 'Failed to assign allowances due to database error.';
            }
            log_message('debug', 'Bulk assign allowances result: Success');
            return TRUE;
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            log_message('error', 'Bulk assign allowances failed: ' . $e->getMessage());
            return 'Failed to assign allowances: ' . $e->getMessage();
        }
    }
}