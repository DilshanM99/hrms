<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Payroll_service
{

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('payroll/payroll_model');
    }

    public function create_allowance($data)
    {
        return $this->CI->payroll_model->create_allowance($data);
    }

    public function create_deduction($data)
    {
        return $this->CI->payroll_model->create_deduction($data);
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

    public function assign_or_update_allowance($emp_id, $allowance_id, $amount, $start, $expire)
    {
        $exists = $this->CI->db->get_where('employee_allowances', [
            'employee_id' => $emp_id,
            'allowance_id' => $allowance_id
        ])->row();

        if ($exists) {
            $this->CI->db->where('id', $exists->id)->update('employee_allowances', [
                'amount' => $amount,
                'start_date' => $start,
                'expire_date' => $expire
            ]);
        } else {
            $this->CI->db->insert('employee_allowances', [
                'employee_id' => $emp_id,
                'allowance_id' => $allowance_id,
                'amount' => $amount,
                'start_date' => $start,
                'expire_date' => $expire
            ]);
        }
    }

    public function assign_or_update_deduction($emp_id, $deduction_id, $amount, $start, $expire)
    {
        $exists = $this->CI->db->get_where('employee_deductions', [
            'employee_id' => $emp_id,
            'deduction_id' => $deduction_id
        ])->row();

        $data = [
            'amount' => $amount,
            'start_date' => $start,
            'expire_date' => $expire
        ];

        if ($exists) {
            $this->CI->db->where('id', $exists->id)->update('employee_deductions', $data);
        } else {
            $data['employee_id'] = $emp_id;
            $data['deduction_id'] = $deduction_id;
            $this->CI->db->insert('employee_deductions', $data);
        }
    }


    public function get_allowance_by_id($id)
    {
        return $this->CI->db->get_where('allowances', ['id' => $id])->row_array();
    }

    public function get_deduction_by_id($id)
    {
        return $this->CI->db->get_where('deductions', ['id' => $id])->row_array();
    }

    public function assign_months_to_allowance($allowance_id, $months, $year = null)
    {
        $this->CI->db->where('allowance_id', $allowance_id);
        $this->CI->db->delete('allowance_applicable_months');

        $data = [];
        foreach ($months as $month) {
            $data[] = [
                'allowance_id' => $allowance_id,
                'month' => $month,
                'year' => $year,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        $this->CI->db->insert_batch('allowance_applicable_months', $data);
        return true;
    }

    public function assign_months_to_deduction($deduction_id, $months, $year = null)
    {
        $this->CI->db->where('deduction_id', $deduction_id);
        $this->CI->db->delete('deduction_applicable_months');

        $data = [];
        foreach ($months as $month) {
            $data[] = [
                'deduction_id' => $deduction_id,
                'month' => $month,
                'year' => $year,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
        $this->CI->db->insert_batch('deduction_applicable_months', $data);
        return true;
    }

    public function get_applicable_months_for_allowance($allowance_id)
    {
        if (!is_numeric($allowance_id)) {
            log_message('error', 'Invalid allowance_id for get_applicable_months_for_allowance: ' . $allowance_id);
            return ['months' => [], 'year' => null];
        }

        $this->CI->db->select('month, year');
        $this->CI->db->from('allowance_applicable_months');
        $this->CI->db->where('allowance_id', $allowance_id);
        $query = $this->CI->db->get();
        $result = $query->result_array();

        $months = array_column($result, 'month');
        $year = !empty($result) ? $result[0]['year'] : null;

        return [
            'months' => array_map('intval', $months),
            'year' => $year ? (int)$year : null
        ];
    }

    public function get_applicable_months_for_deduction($deduction_id)
    {
        if (!is_numeric($deduction_id)) {
            log_message('error', 'Invalid deduction_id for get_applicable_months_for_deduction: ' . $deduction_id);
            return ['months' => [], 'year' => null];
        }

        $this->CI->db->select('month, year');
        $this->CI->db->from('deduction_applicable_months');
        $this->CI->db->where('deduction_id', $deduction_id);
        $query = $this->CI->db->get();
        $result = $query->result_array();

        $months = array_column($result, 'month');
        $year = !empty($result) ? $result[0]['year'] : null;

        return [
            'months' => array_map('intval', $months),
            'year' => $year ? (int)$year : null
        ];
    }

}