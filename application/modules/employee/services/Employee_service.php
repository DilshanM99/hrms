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





class Employee_service
{

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
            if (
                !$this->CI->payroll_service->assign_allowance(
                    $employee_id,
                    $allowance_data['id'],
                    $amount,
                    $allowance_data['start_date'] ?: null,
                    $allowance_data['expire_date'] ?: null
                )
            ) {
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
            if (
                !$this->CI->payroll_service->update_employee_allowance(
                    $employee_id,
                    $allowance_data['id'],
                    $amount,
                    $allowance_data['start_date'] ?: null,
                    $allowance_data['expire_date'] ?: null
                )
            ) {
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
            if (
                !$this->CI->payroll_service->assign_deduction(
                    $employee_id,
                    $deduction_data['id'],
                    $amount,
                    $deduction_data['start_date'] ?: null,
                    $deduction_data['expire_date'] ?: null
                )
            ) {
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
            if (
                !$this->CI->payroll_service->update_employee_deduction(
                    $employee_id,
                    $deduction_data['id'],
                    $amount,
                    $deduction_data['start_date'] ?: null,
                    $deduction_data['expire_date'] ?: null
                )
            ) {
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


    public function get_all_allowances()
    {
        log_message('debug', 'Fetching all allowances');
        $query = $this->CI->db->select('id, name, amount')->get('allowances');
        $result = $query->result_array();
        log_message('debug', 'Allowances fetched: ' . print_r($result, TRUE));
        return $result;
    }

    public function get_all_departments_for_dropdown()
    {
        log_message('debug', 'Fetching departments for dropdown');
        $query = $this->CI->db->select('id, name')->get('departments');
        $result = $query->result_array();
        log_message('debug', 'Departments fetched: ' . print_r($result, TRUE));
        return $result;
    }

    /**
     * Get all designations for dropdown
     * Fetches id, name, and department_id from designations table for use in select inputs
     * @return array List of designations with id, name, and department_id
     */
    public function get_all_designations_for_dropdown()
    {
        log_message('debug', 'Fetching designations for dropdown');
        $query = $this->CI->db->select('id, name, department_id')->get('designations');
        $result = $query->result_array();
        log_message('debug', 'Designations fetched: ' . print_r($result, TRUE));
        return $result;
    }

    /**
     * Bulk assign allowances to employees by department or employee IDs with update support
     * Creates new records or updates existing ones in employee_allowances
     * @param array $allowance_ids List of allowance IDs
     * @param array $department_ids List of department IDs
     * @param array $employee_ids List of employee IDs
     * @param float|null $amount Custom amount for allowances (optional)
     * @param string|null $start_date Start date for allowances (optional)
     * @param string|null $expire_date Expire date for allowances (optional)
     * @return bool|string True on success, error message on failure
     */

    // public function bulk_assign_allowances_with_update($allowance_ids, $department_ids, $designation_ids, $employee_ids, $amount, $start_date, $expire_date)
    // {
    //     log_message('debug', 'Bulk assigning allowances with update: ' . print_r($allowance_ids, TRUE));
    //     $this->CI->db->trans_start();
    //     try {
    //         // Fetch employees based on selections
    //         $this->CI->db->select('id');
    //         if (!empty($employee_ids)) {
    //             $this->CI->db->where_in('id', $employee_ids);
    //         }
    //         if (!empty($department_ids)) {
    //             $this->CI->db->where_in('department_id', $department_ids);
    //         }
    //         if (!empty($designation_ids)) {
    //             $this->CI->db->where_in('designation_id', $designation_ids);
    //         }
    //         // At least one filter should be applied
    //         if (empty($employee_ids) && empty($department_ids) && empty($designation_ids)) {
    //             $this->CI->db->trans_rollback();
    //             return 'At least one Department, Designation, or Employee must be selected.';
    //         }
    //         $query = $this->CI->db->get('employees');
    //         $employees = $query->result_array();
    //         log_message('debug', 'Employees to assign allowances: ' . print_r($employees, TRUE));

    //         if (empty($employees)) {
    //             $this->CI->db->trans_rollback();
    //             return 'No employees found for the selected criteria.';
    //         }

    //         // Process allowances: update existing records or insert new ones
    //         foreach ($employees as $employee) {
    //             foreach ($allowance_ids as $allowance_id) {
    //                 $this->CI->db->where('employee_id', $employee['id']);
    //                 $this->CI->db->where('allowance_id', $allowance_id);
    //                 $query = $this->CI->db->get('employee_allowances');

    //                 $allowance_data = array(
    //                     'employee_id' => $employee['id'],
    //                     'allowance_id' => $allowance_id,
    //                     'amount' => !empty($amount) ? $amount : 0.00,
    //                     'start_date' => !empty($start_date) ? $start_date : NULL,
    //                     'expire_date' => !empty($expire_date) ? $expire_date : NULL,
    //                     'updated_at' => date('Y-m-d H:i:s')
    //                 );

    //                 if ($query->num_rows() > 0) {
    //                     // Update existing record
    //                     $this->CI->db->where('employee_id', $employee['id']);
    //                     $this->CI->db->where('allowance_id', $allowance_id);
    //                     $this->CI->db->update('employee_allowances', array(
    //                         'amount' => $allowance_data['amount'],
    //                         'start_date' => $allowance_data['start_date'],
    //                         'expire_date' => $allowance_data['expire_date'],
    //                         'updated_at' => $allowance_data['updated_at']
    //                     ));
    //                     log_message('debug', 'Updated allowance for employee_id: ' . $employee['id'] . ', allowance_id: ' . $allowance_id);
    //                 } else {
    //                     // Insert new record
    //                     $allowance_data['created_at'] = date('Y-m-d H:i:s');
    //                     $this->CI->db->insert('employee_allowances', $allowance_data);
    //                     log_message('debug', 'Inserted allowance for employee_id: ' . $employee['id'] . ', allowance_id: ' . $allowance_id);
    //                 }
    //             }
    //         }

    //         $this->CI->db->trans_complete();
    //         if ($this->CI->db->trans_status() === FALSE) {
    //             log_message('error', 'Bulk assign allowances with update transaction failed');
    //             return 'Failed to assign or update allowances due to database error.';
    //         }
    //         log_message('debug', 'Bulk assign allowances with update result: Success');
    //         return TRUE;
    //     } catch (Exception $e) {
    //         $this->CI->db->trans_rollback();
    //         log_message('error', 'Bulk assign allowances with update failed: ' . $e->getMessage());
    //         return 'Failed to assign or update allowances: ' . $e->getMessage();
    //     }
    // }

    public function bulk_assign_allowances_with_update($allowance_ids, $department_ids, $designation_ids, $employee_ids, $amount, $start_date, $expire_date)
    {
        log_message('debug', 'Bulk assigning allowances with update: ' . print_r($allowance_ids, TRUE));
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
            // At least one filter should be applied
            if (empty($employee_ids) && empty($department_ids) && empty($designation_ids)) {
                $this->CI->db->trans_rollback();
                return 'At least one Department, Designation, or Employee must be selected.';
            }
            $query = $this->CI->db->get('employees');
            $employees = $query->result_array();
            log_message('debug', 'Employees to assign allowances: ' . print_r($employees, TRUE));

            if (empty($employees)) {
                $this->CI->db->trans_rollback();
                return 'No employees found for the selected criteria.';
            }

            // Fetch allowances to get default_amount for each allowance_id
            $this->CI->db->select('id, amount');
            $this->CI->db->where_in('id', $allowance_ids);
            $query = $this->CI->db->get('allowances');
            $allowances = array_column($query->result_array(), 'amount', 'id');
            log_message('debug', 'Allowances with default amounts: ' . print_r($allowances, TRUE));

            // Process allowances: update existing records or insert new ones
            foreach ($employees as $employee) {
                foreach ($allowance_ids as $allowance_id) {
                    // Determine amount to use: provided amount or default_amount
                    $effective_amount = !empty($amount) ? $amount : (isset($allowances[$allowance_id]) ? $allowances[$allowance_id] : 0.00);

                    $this->CI->db->where('employee_id', $employee['id']);
                    $this->CI->db->where('allowance_id', $allowance_id);
                    $query = $this->CI->db->get('employee_allowances');

                    $allowance_data = array(
                        'employee_id' => $employee['id'],
                        'allowance_id' => $allowance_id,
                        'amount' => $effective_amount,
                        'start_date' => !empty($start_date) ? $start_date : NULL,
                        'expire_date' => !empty($expire_date) ? $expire_date : NULL,
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    if ($query->num_rows() > 0) {
                        // Update existing record
                        $this->CI->db->where('employee_id', $employee['id']);
                        $this->CI->db->where('allowance_id', $allowance_id);
                        $this->CI->db->update('employee_allowances', array(
                            'amount' => $allowance_data['amount'],
                            'start_date' => $allowance_data['start_date'],
                            'expire_date' => $allowance_data['expire_date'],
                            'updated_at' => $allowance_data['updated_at']
                        ));
                        log_message('debug', 'Updated allowance for employee_id: ' . $employee['id'] . ', allowance_id: ' . $allowance_id . ', amount: ' . $allowance_data['amount']);
                    } else {
                        // Insert new record
                        $allowance_data['created_at'] = date('Y-m-d H:i:s');
                        $this->CI->db->insert('employee_allowances', $allowance_data);
                        log_message('debug', 'Inserted allowance for employee_id: ' . $employee['id'] . ', allowance_id: ' . $allowance_id . ', amount: ' . $allowance_data['amount']);
                    }
                }
            }

            $this->CI->db->trans_complete();
            if ($this->CI->db->trans_status() === FALSE) {
                log_message('error', 'Bulk assign allowances with update transaction failed');
                return 'Failed to assign or update allowances due to database error.';
            }
            log_message('debug', 'Bulk assign allowances with update result: Success');
            return TRUE;
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            log_message('error', 'Bulk assign allowances with update failed: ' . $e->getMessage());
            return 'Failed to assign or update allowances: ' . $e->getMessage();
        }
    }


    public function bulk_assign_deductions_with_update($deduction_ids, $department_ids, $designation_ids, $employee_ids, $amount, $start_date, $expire_date)
    {
        log_message('debug', 'Bulk assigning deductions with update: ' . print_r($deduction_ids, TRUE));
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
            // At least one filter should be applied
            if (empty($employee_ids) && empty($department_ids) && empty($designation_ids)) {
                $this->CI->db->trans_rollback();
                return 'At least one Department, Designation, or Employee must be selected.';
            }
            $query = $this->CI->db->get('employees');
            $employees = $query->result_array();
            log_message('debug', 'Employees to assign deductions: ' . print_r($employees, TRUE));

            if (empty($employees)) {
                $this->CI->db->trans_rollback();
                return 'No employees found for the selected criteria.';
            }

            // Fetch deductions to get default_amount for each deduction_id
            $this->CI->db->select('id, amount');
            $this->CI->db->where_in('id', $deduction_ids);
            $query = $this->CI->db->get('deductions');
            $deductions = array_column($query->result_array(), 'amount', 'id');
            log_message('debug', 'deductions with default amounts: ' . print_r($deductions, TRUE));

            // Process deductions: update existing records or insert new ones
            foreach ($employees as $employee) {
                foreach ($deduction_ids as $deduction_id) {
                    // Determine amount to use: provided amount or default_amount
                    $effective_amount = !empty($amount) ? $amount : (isset($deductions[$deduction_id]) ? $deductions[$deduction_id] : 0.00);

                    $this->CI->db->where('employee_id', $employee['id']);
                    $this->CI->db->where('deduction_id', $deduction_id);
                    $query = $this->CI->db->get('employee_deductions');

                    $deduction_data = array(
                        'employee_id' => $employee['id'],
                        'deduction_id' => $deduction_id,
                        'amount' => $effective_amount,
                        'start_date' => !empty($start_date) ? $start_date : NULL,
                        'expire_date' => !empty($expire_date) ? $expire_date : NULL,
                        'updated_at' => date('Y-m-d H:i:s')
                    );

                    if ($query->num_rows() > 0) {
                        // Update existing record
                        $this->CI->db->where('employee_id', $employee['id']);
                        $this->CI->db->where('deduction_id', $deduction_id);
                        $this->CI->db->update('employee_deductions', array(
                            'amount' => $deduction_data['amount'],
                            'start_date' => $deduction_data['start_date'],
                            'expire_date' => $deduction_data['expire_date'],
                            'updated_at' => $deduction_data['updated_at']
                        ));
                        log_message('debug', 'Updated deduction for employee_id: ' . $employee['id'] . ', deduction_id: ' . $deduction_id . ', amount: ' . $deduction_data['amount']);
                    } else {
                        // Insert new record
                        $deduction_data['created_at'] = date('Y-m-d H:i:s');
                        $this->CI->db->insert('employee_deductions', $deduction_data);
                        log_message('debug', 'Inserted deduction for employee_id: ' . $employee['id'] . ', deduction_id: ' . $deduction_id . ', amount: ' . $deduction_data['amount']);
                    }
                }
            }

            $this->CI->db->trans_complete();
            if ($this->CI->db->trans_status() === FALSE) {
                log_message('error', 'Bulk assign deductions with update transaction failed');
                return 'Failed to assign or update deductions due to database error.';
            }
            log_message('debug', 'Bulk assign deductions with update result: Success');
            return TRUE;
        } catch (Exception $e) {
            $this->CI->db->trans_rollback();
            log_message('error', 'Bulk assign deductions with update failed: ' . $e->getMessage());
            return 'Failed to assign or update deductions: ' . $e->getMessage();
        }
    }

    
}