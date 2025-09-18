<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Payroll_service {

//     protected $CI;

//     public function __construct()
//     {
//         $this->CI =& get_instance();
//         $this->CI->load->model('payroll/payroll_model');
//     }

//     // Allowance methods
//     public function get_all_allowances($search = '', $sort = 'id', $order = 'asc')
//     {
//         return $this->CI->payroll_model->get_all_allowances($search, $sort, $order);
//     }

//     public function get_allowance($id)
//     {
//         return $this->CI->payroll_model->get_allowance_by_id($id);
//     }

//     public function create_allowance($data)
//     {
//         return $this->CI->payroll_model->create_allowance($data);
//     }

//     public function update_allowance($id, $data)
//     {
//         return $this->CI->payroll_model->update_allowance($id, $data);
//     }

//     public function delete_allowance($id)
//     {
//         return $this->CI->payroll_model->delete_allowance($id);
//     }

//     // Deduction methods
//     public function get_all_deductions($search = '', $sort = 'id', $order = 'asc')
//     {
//         return $this->CI->payroll_model->get_all_deductions($search, $sort, $order);
//     }

//     public function get_deduction($id)
//     {
//         return $this->CI->payroll_model->get_deduction_by_id($id);
//     }

//     public function create_deduction($data)
//     {
//         return $this->CI->payroll_model->create_deduction($data);
//     }

//     public function update_deduction($id, $data)
//     {
//         return $this->CI->payroll_model->update_deduction($id, $data);
//     }

//     public function delete_deduction($id)
//     {
//         return $this->CI->payroll_model->delete_deduction($id);
//     }

//     // Employee Allowance methods
//     public function get_employee_allowances($employee_id)
//     {
//         return $this->CI->payroll_model->get_employee_allowances($employee_id);
//     }

//     public function assign_allowance($employee_id, $allowance_id, $amount)
//     {
//         return $this->CI->payroll_model->assign_allowance($employee_id, $allowance_id, $amount);
//     }

//     public function update_employee_allowance($employee_id, $allowance_id, $amount)
//     {
//         return $this->CI->payroll_model->update_employee_allowance($employee_id, $allowance_id, $amount);
//     }

//     public function remove_employee_allowance($employee_id, $allowance_id)
//     {
//         return $this->CI->payroll_model->remove_employee_allowance($employee_id, $allowance_id);
//     }

//     // Employee Deduction methods
//     public function get_employee_deductions($employee_id)
//     {
//         return $this->CI->payroll_model->get_employee_deductions($employee_id);
//     }

//     public function assign_deduction($employee_id, $deduction_id, $amount)
//     {
//         return $this->CI->payroll_model->assign_deduction($employee_id, $deduction_id, $amount);
//     }

//     public function update_employee_deduction($employee_id, $deduction_id, $amount)
//     {
//         return $this->CI->payroll_model->update_employee_deduction($employee_id, $deduction_id, $amount);
//     }

//     public function remove_employee_deduction($employee_id, $deduction_id)
//     {
//         return $this->CI->payroll_model->remove_employee_deduction($employee_id, $deduction_id);
//     }

//     // Payroll Run methods
//     public function get_all_payroll_runs($search = '', $sort = 'run_date', $order = 'desc')
//     {
//         return $this->CI->payroll_model->get_all_payroll_runs($search, $sort, $order);
//     }

//     public function get_payroll_run($id)
//     {
//         return $this->CI->payroll_model->get_payroll_run_by_id($id);
//     }

//     public function create_payroll_run($data)
//     {
//         return $this->CI->payroll_model->create_payroll_run($data);
//     }

//     public function update_payroll_run($id, $data)
//     {
//         return $this->CI->payroll_model->update_payroll_run($id, $data);
//     }

//     public function delete_payroll_run($id)
//     {
//         return $this->CI->payroll_model->delete_payroll_run($id);
//     }

//     public function get_payroll_details($run_id)
//     {
//         return $this->CI->payroll_model->get_payroll_details($run_id);
//     }

//     public function generate_payroll_run($run_id)
//     {
//         return $this->CI->payroll_model->generate_payroll_run($run_id);
//     }
// }



//     class Payroll_service{

//     protected $CI;

//     public function __construct()
//     {
//         $this->CI =& get_instance();
//         $this->CI->load->model('payroll/payroll_model');
//     }

//     public function get_all_allowances($search = '', $sort = 'name', $order = 'asc', $type = null)
//     {
//         return $this->CI->payroll_model->get_all_allowances($search, $sort, $order, $type);
//     }

//     public function get_all_deductions($search = '', $sort = 'name', $order = 'asc', $type = null)
//     {
//         return $this->CI->payroll_model->get_all_deductions($search, $sort, $order, $type);
//     }

//     public function get_allowance_default_amount($allowance_id)
//     {
//         $this->CI->db->select('default_amount');
//         $this->CI->db->where('id', $allowance_id);
//         $query = $this->CI->db->get('allowances');
//         $result = $query->row_array();
//         return $result ? $result['default_amount'] : 0;
//     }

//     public function get_deduction_default_amount($deduction_id)
//     {
//         $this->CI->db->select('default_amount');
//         $this->CI->db->where('id', $deduction_id);
//         $query = $this->CI->db->get('deductions');
//         $result = $query->row_array();
//         return $result ? $result['default_amount'] : 0;
//     }

//     public function assign_allowance($employee_id, $allowance_id, $amount, $start_date = null, $expire_date = null)
//     {
//         $data = [
//             'employee_id' => $employee_id,
//             'allowance_id' => $allowance_id,
//             'amount' => $amount,
//             'start_date' => $start_date,
//             'expire_date' => $expire_date,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s')
//         ];
//         return $this->CI->db->insert('employee_allowances', $data);
//     }

//     public function update_employee_allowance($employee_id, $allowance_id, $amount, $start_date = null, $expire_date = null)
//     {
//         $data = [
//             'amount' => $amount,
//             'start_date' => $start_date,
//             'expire_date' => $expire_date,
//             'updated_at' => date('Y-m-d H:i:s')
//         ];
//         $this->CI->db->where('employee_id', $employee_id);
//         $this->CI->db->where('allowance_id', $allowance_id);
//         return $this->CI->db->update('employee_allowances', $data);
//     }

//     public function remove_employee_allowance($employee_id, $allowance_id)
//     {
//         $this->CI->db->where('employee_id', $employee_id);
//         $this->CI->db->where('allowance_id', $allowance_id);
//         return $this->CI->db->delete('employee_allowances');
//     }

//     public function assign_deduction($employee_id, $deduction_id, $amount, $start_date = null, $expire_date = null)
//     {
//         $data = [
//             'employee_id' => $employee_id,
//             'deduction_id' => $deduction_id,
//             'amount' => $amount,
//             'start_date' => $start_date,
//             'expire_date' => $expire_date,
//             'created_at' => date('Y-m-d H:i:s'),
//             'updated_at' => date('Y-m-d H:i:s')
//         ];
//         return $this->CI->db->insert('employee_deductions', $data);
//     }

//     public function update_employee_deduction($employee_id, $deduction_id, $amount, $start_date = null, $expire_date = null)
//     {
//         $data = [
//             'amount' => $amount,
//             'start_date' => $start_date,
//             'expire_date' => $expire_date,
//             'updated_at' => date('Y-m-d H:i:s')
//         ];
//         $this->CI->db->where('employee_id', $employee_id);
//         $this->CI->db->where('deduction_id', $deduction_id);
//         return $this->CI->db->update('employee_deductions', $data);
//     }

//     public function remove_employee_deduction($employee_id, $deduction_id)
//     {
//         $this->CI->db->where('employee_id', $employee_id);
//         $this->CI->db->where('deduction_id', $deduction_id);
//         return $this->CI->db->delete('employee_deductions');
//     }

//     public function get_employee_allowances($employee_id)
//     {
//         $this->CI->db->select('ea.allowance_id, ea.amount, ea.start_date, ea.expire_date, a.name, a.type');
//         $this->CI->db->from('employee_allowances ea');
//         $this->CI->db->join('allowances a', 'a.id = ea.allowance_id');
//         $this->CI->db->where('ea.employee_id', $employee_id);
//         $query = $this->CI->db->get();
//         return $query->result_array();
//     }

//     public function get_employee_deductions($employee_id)
//     {
//         $this->CI->db->select('ed.deduction_id, ed.amount, ed.start_date, ed.expire_date, d.name, d.type');
//         $this->CI->db->from('employee_deductions ed');
//         $this->CI->db->join('deductions d', 'd.id = ed.deduction_id');
//         $this->CI->db->where('ed.employee_id', $employee_id);
//         $query = $this->CI->db->get();
//         return $query->result_array();
//     }
// }




class Payroll_service {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function get_all_allowances($search = '', $sort = 'name', $order = 'asc')
    {
        if ($search) {
            $this->CI->db->like('name', $search);
        }
        $this->CI->db->order_by($sort, $order);
        return $this->CI->db->get('allowances')->result_array();
    }

    public function get_all_deductions($search = '', $sort = 'name', $order = 'asc')
    {
        if ($search) {
            $this->CI->db->like('name', $search);
        }
        $this->CI->db->order_by($sort, $order);
        return $this->CI->db->get('deductions')->result_array();
    }

    public function get_allowance_default_amount($allowance_id)
    {
        $this->CI->db->select('amount');
        $this->CI->db->where('id', $allowance_id);
        $query = $this->CI->db->get('allowances');
        $result = $query->row_array();
        return $result && isset($result['amount']) ? $result['amount'] : 0;
    }

    public function get_deduction_default_amount($deduction_id)
    {
        $this->CI->db->select('amount');
        $this->CI->db->where('id', $deduction_id);
        $query = $this->CI->db->get('deductions');
        $result = $query->row_array();
        return $result && isset($result['amount']) ? $result['amount'] : 0;
    }

    public function get_existing_allowance($employee_id, $allowance_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        $this->CI->db->where('allowance_id', $allowance_id);
        $query = $this->CI->db->get('employee_allowances');
        return $query->row_array();
    }

    public function get_existing_deduction($employee_id, $deduction_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        $this->CI->db->where('deduction_id', $deduction_id);
        $query = $this->CI->db->get('employee_deductions');
        return $query->row_array();
    }

    public function assign_allowance($employee_id, $allowance_id, $amount, $start_date = null, $expire_date = null)
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
        return $this->CI->db->insert('employee_allowances', $data);
    }

    public function assign_deduction($employee_id, $deduction_id, $amount, $start_date = null, $expire_date = null)
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
        return $this->CI->db->insert('employee_deductions', $data);
    }

    public function get_employee_allowances($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->get('employee_allowances')->result_array();
    }

    public function get_employee_deductions($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->get('employee_deductions')->result_array();
    }

    // public function update_employee_allowances($employee_id, $allowances_data)
    // {
    //     // Remove existing allowances
    //     $this->CI->db->where('employee_id', $employee_id);
    //     $this->CI->db->delete('employee_allowances');

    //     // Assign new allowances
    //     $success = true;
    //     foreach ($allowances_data as $allowance_data) {
    //         if (empty($allowance_data['id'])) {
    //             continue;
    //         }
    //         $amount = !empty($allowance_data['amount']) ? $allowance_data['amount'] : $this->get_allowance_default_amount($allowance_data['id']);
    //         if (!$this->assign_allowance(
    //             $employee_id,
    //             $allowance_data['id'],
    //             $amount,
    //             $allowance_data['start_date'] ?: null,
    //             $allowance_data['expire_date'] ?: null
    //         )) {
    //             $success = false;
    //         }
    //     }
    //     return $success;
    // }

    
    public function update_employee_allowances($employee_id, $allowances_data)
    {
        $success = true;
        $submitted_ids = [];

        // Process submitted allowances
        foreach ($allowances_data as $key => $allowance_data) {
            if (empty($allowance_data['id'])) {
                continue;
            }
            $allowance_id = $allowance_data['id'];
            $submitted_ids[] = $allowance_id;

            $existing = $this->get_existing_allowance($employee_id, $allowance_id);
            $amount = !empty($allowance_data['amount']) ? $allowance_data['amount'] : 
                     ($existing ? $existing['amount'] : $this->get_allowance_default_amount($allowance_id));
            $start_date = !empty($allowance_data['start_date']) ? $allowance_data['start_date'] : ($existing ? $existing['start_date'] : null);
            $expire_date = !empty($allowance_data['expire_date']) ? $allowance_data['expire_date'] : ($existing ? $existing['expire_date'] : null);

            if ($existing) {
                // Update existing allowance
                $data = [
                    'amount' => $amount,
                    'start_date' => $start_date,
                    'expire_date' => $expire_date,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->CI->db->where('employee_id', $employee_id);
                $this->CI->db->where('allowance_id', $allowance_id);
                if (!$this->CI->db->update('employee_allowances', $data)) {
                    $success = false;
                }
            } else {
                // Insert new allowance
                if (!$this->assign_allowance($employee_id, $allowance_id, $amount, $start_date, $expire_date)) {
                    $success = false;
                }
            }
        }

        // Remove allowances not in submitted data
        $this->CI->db->where('employee_id', $employee_id);
        if (!empty($submitted_ids)) {
            $this->CI->db->where_not_in('allowance_id', $submitted_ids);
        }
        if (!$this->CI->db->delete('employee_allowances')) {
            $success = false;
        }

        return $success;
    }
    // public function update_employee_deductions($employee_id, $deductions_data)
    // {
    //     // Remove existing deductions
    //     $this->CI->db->where('employee_id', $employee_id);
    //     $this->CI->db->delete('employee_deductions');

    //     // Assign new deductions
    //     $success = true;
    //     foreach ($deductions_data as $deduction_data) {
    //         if (empty($deduction_data['id'])) {
    //             continue;
    //         }
    //         $amount = !empty($deduction_data['amount']) ? $deduction_data['amount'] : $this->get_deduction_default_amount($deduction_data['id']);
    //         if (!$this->assign_deduction(
    //             $employee_id,
    //             $deduction_data['id'],
    //             $amount,
    //             $deduction_data['start_date'] ?: null,
    //             $deduction_data['expire_date'] ?: null
    //         )) {
    //             $success = false;
    //         }
    //     }
    //     return $success;
    // }

    
    public function update_employee_deductions($employee_id, $deductions_data)
    {
        $success = true;
        $submitted_ids = [];

        // Process submitted deductions
        foreach ($deductions_data as $key => $deduction_data) {
            if (empty($deduction_data['id'])) {
                continue;
            }
            $deduction_id = $deduction_data['id'];
            $submitted_ids[] = $deduction_id;

            $existing = $this->get_existing_deduction($employee_id, $deduction_id);
            $amount = !empty($deduction_data['amount']) ? $deduction_data['amount'] : 
                     ($existing ? $existing['amount'] : $this->get_deduction_default_amount($deduction_id));
            $start_date = !empty($deduction_data['start_date']) ? $deduction_data['start_date'] : ($existing ? $existing['start_date'] : null);
            $expire_date = !empty($deduction_data['expire_date']) ? $deduction_data['expire_date'] : ($existing ? $existing['expire_date'] : null);

            if ($existing) {
                // Update existing deduction
                $data = [
                    'amount' => $amount,
                    'start_date' => $start_date,
                    'expire_date' => $expire_date,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->CI->db->where('employee_id', $employee_id);
                $this->CI->db->where('deduction_id', $deduction_id);
                if (!$this->CI->db->update('employee_deductions', $data)) {
                    $success = false;
                }
            } else {
                // Insert new deduction
                if (!$this->assign_deduction($employee_id, $deduction_id, $amount, $start_date, $expire_date)) {
                    $success = false;
                }
            }
        }

        // Remove deductions not in submitted data
        $this->CI->db->where('employee_id', $employee_id);
        if (!empty($submitted_ids)) {
            $this->CI->db->where_not_in('deduction_id', $submitted_ids);
        }
        if (!$this->CI->db->delete('employee_deductions')) {
            $success = false;
        }

        return $success;
    }

    
    
    public function remove_employee_allowances($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_allowances');
    }

    public function remove_employee_deductions($employee_id)
    {
        $this->CI->db->where('employee_id', $employee_id);
        return $this->CI->db->delete('employee_deductions');
    }

    
}