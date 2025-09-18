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
}