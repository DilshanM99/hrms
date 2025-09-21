<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->service('employee/employee_service');
        $this->load->service('employee/masters_service');
        $this->load->service('payroll/payroll_service');
        $this->load->library('session');
        $this->load->database(); // Ensure database is loaded

        // Role-based access
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
        $role = $this->session->userdata('role');
        if ($role !== 'Admin' && $role !== 'HR') {
            show_error('Access denied', 403);
        }
    }

    public function index()
    {
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'id';
        $order = $this->input->get('order', TRUE) ?: 'asc';

        $data['title'] = 'Employees';
        $data['employees'] = $this->employee_service->get_all_employees($search, $sort, $order);
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['search'] = $search;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data['title'] = 'Employee Dashboard';

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/index', $data);
        $this->load->view('layouts/footer');
    }

    public function create()
    {
        $data['title'] = 'Create Employee';
        $data['departments'] = $this->masters_service->get_all_departments();
        $data['designations'] = $this->masters_service->get_all_designations_for_dropdown();
        $data['allowances'] = $this->payroll_service->get_all_allowances('', 'name', 'asc');
        $data['deductions'] = $this->payroll_service->get_all_deductions('', 'name', 'asc');
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/create', $data);
        $this->load->view('layouts/footer');
    }

    
    public function store()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');//what is done by this code line? 
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|max_length[15]');
        $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('designation_id', 'Designation', 'required|integer');
        $this->form_validation->set_rules('salary', 'Salary', 'required|numeric|greater_than[0]');

        $allowances = $this->input->post('allowances', TRUE);
        $deductions = $this->input->post('deductions', TRUE);

        if ($allowances) {
            foreach ($allowances as $index => $allowance) {
                if (empty($allowance['id']))
                    continue; // Skip empty rows
                $this->form_validation->set_rules("allowances[{$index}][id]", "Allowance ID #{$index}", 'required|integer');
                $this->form_validation->set_rules("allowances[{$index}][amount]", "Allowance Amount #{$index}", 'numeric|greater_than[0]');
                // Only validate dates if provided
                if (!empty($allowance['start_date']) || !empty($allowance['expire_date'])) {
                    // $this->form_validation->set_rules("allowances[{$index}][start_date]", "Allowance Start Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]', ['regex_match' => 'The Allowance Start Date #{$index} must be a valid date (YYYY-MM-DD).']);
                    // $this->form_validation->set_rules("allowances[{$index}][expire_date]", "Allowance Expire Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]|callback_date_check[allowances,' . $index . ']', ['regex_match' => 'The Allowance Expire Date #{$index} must be a valid date (YYYY-MM-DD).']);
                }
            }
        }

        if ($deductions) {
            foreach ($deductions as $index => $deduction) {
                if (empty($deduction['id']))
                    continue;
                $this->form_validation->set_rules("deductions[{$index}][id]", "Deduction ID #{$index}", 'required|integer');
                $this->form_validation->set_rules("deductions[{$index}][amount]", "Deduction Amount #{$index}", 'numeric|greater_than[0]');
                if (!empty($deduction['start_date']) || !empty($deduction['expire_date'])) {
                    // $this->form_validation->set_rules("deductions[{$index}][start_date]", "Deduction Start Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]', ['regex_match' => 'The Deduction Start Date #{$index} must be a valid date (YYYY-MM-DD).']);
                    // $this->form_validation->set_rules("deductions[{$index}][expire_date]", "Deduction Expire Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]|callback_date_check[deductions,' . $index . ']', ['regex_match' => 'The Deduction Expire Date #{$index} must be a valid date (YYYY-MM-DD).']);
                }
            }
        }

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $employee_data = [
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'salary' => $this->input->post('salary', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->trans_start();
            $employee_id = $this->employee_service->create_employee($employee_data);

            $department_id = $this->input->post('department_id', TRUE);
            $this->masters_service->assign_department($employee_id, $department_id);

            $designation_id = $this->input->post('designation_id', TRUE);
            $this->masters_service->assign_designation($employee_id, $designation_id);

            if ($allowances) {
                $allowances = array_filter($allowances, function ($a) {
                    return !empty($a['id']);
                });
                $this->employee_service->assign_employee_allowances($employee_id, $allowances);
            }

            if ($deductions) {
                $deductions = array_filter($deductions, function ($a) {
                    return !empty($a['id']);
                });
                $this->employee_service->assign_employee_deductions($employee_id, $deductions);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to create employee.');
                $this->create();
            } else {
                $this->session->set_flashdata('success', 'Employee created successfully.');
                redirect('employee');
            }
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Employee';
        $data['employee'] = $this->employee_service->get_employee($id);
        $data['departments'] = $this->masters_service->get_all_departments();
        $data['designations'] = $this->masters_service->get_all_designations();
        $data['allowances'] = $this->payroll_service->get_all_allowances('', 'name', 'asc');
        $data['deductions'] = $this->payroll_service->get_all_deductions('', 'name', 'asc');
        $data['employee_allowances'] = $this->payroll_service->get_employee_allowances($id);
        $data['employee_deductions'] = $this->payroll_service->get_employee_deductions($id);
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        if (!$data['employee']) {
            $this->session->set_flashdata('error', 'Employee not found.');
            redirect('employee');
        }

        if ($this->input->post()) {
            $employee_data = [
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'salary' => $this->input->post('salary')
            ];
            $allowances_data = $this->input->post('allowances') ?: [];
            $deductions_data = $this->input->post('deductions') ?: [];
            $department_id = $this->input->post('department_id');
            $designation_id = $this->input->post('designation_id');

            $this->db->trans_start();
            // Update employee basic details
            $this->employee_service->update_employee($id, $employee_data);

            // Update department and designation
            if ($department_id) {
                $this->masters_service->update_employee_department($id, $department_id);
            }
            if ($designation_id) {
                $this->masters_service->update_employee_designation($id, $designation_id);
            }

            // Update allowances and deductions
            $this->payroll_service->update_employee_allowances($id, $allowances_data);
            $this->payroll_service->update_employee_deductions($id, $deductions_data);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Employee updated successfully.');
                redirect('employee');
            } else {
                $this->session->set_flashdata('error', 'Failed to update employee.');
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/edit', $data);
        $this->load->view('layouts/footer');
    }
    public function update($id)
    {
        // --- Basic Employee Validation ---
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|max_length[15]');
        $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('designation_id', 'Designation', 'required|integer');
        $this->form_validation->set_rules('salary', 'Basic Salary', 'required|numeric|greater_than[0]');

        $allowances = $this->input->post('allowances', TRUE) ?: [];
        $deductions = $this->input->post('deductions', TRUE) ?: [];

        // If validation fails, reload the edit form
        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }

        // --- Employee Basic Data ---
        $employee_data = [
            'first_name' => $this->input->post('first_name', TRUE),
            'last_name' => $this->input->post('last_name', TRUE),
            'email' => $this->input->post('email', TRUE),
            'phone' => $this->input->post('phone', TRUE),
            'salary' => $this->input->post('salary', TRUE),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $department_id = $this->input->post('department_id', TRUE);
        $designation_id = $this->input->post('designation_id', TRUE);

        $this->db->trans_start();

        // --- Update Employee Details ---
        $this->employee_service->update_employee($id, $employee_data);
        $this->masters_service->update_employee_department($id, $department_id);
        $this->masters_service->update_employee_designation($id, $designation_id);

        // --- Allowances ---
        // Remove all existing allowances first
        $this->payroll_service->remove_employee_allowances($id);

        // Insert submitted allowances
        foreach ($allowances as $a) {
            if (!empty($a['id'])) {
                // $this->payroll_service->assign_or_update_allowance(
                //     $id,
                //     $a['id'],
                //     $a['amount'],
                //     $a['start_date'] ?? null,
                //     $a['expire_date'] ?? null
                // );
                $amount = !empty($a['amount']) ? $a['amount'] : $this->payroll_service->get_allowance_default_amount($a['id']);
                $this->payroll_service->assign_or_update_allowance(
                    $id,
                    $a['id'],
                    $amount,
                    $a['start_date'] ?? null,
                    $a['expire_date'] ?? null
                );
            }
        }

        // --- Deductions ---
        // Remove all existing deductions first
        $this->payroll_service->remove_employee_deductions($id);

        // Insert submitted deductions
        foreach ($deductions as $d) {
            if (!empty($d['id'])) {
                // $this->payroll_service->assign_or_update_deduction(
                //     $id,
                //     $d['id'],
                //     $d['amount'],
                //     $d['start_date'] ?? null,
                //     $d['expire_date'] ?? null
                // );
                $amount = !empty($d['amount']) ? $d['amount'] : $this->payroll_service->get_deduction_default_amount($d['id']);
                $this->payroll_service->assign_or_update_deduction(
                    $id,
                    $d['id'],
                    $amount,
                    $d['start_date'] ?? null,
                    $d['expire_date'] ?? null
                );
            }
        }

        $this->db->trans_complete();

        // --- Transaction Result ---
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Failed to update employee.');
            return $this->edit($id);
        }

        // $this->session->set_flashdata('success', 'Employee updated successfully.');
        // return redirect('employee');
        $employee_name = $employee_data['first_name'] . ' ' . $employee_data['last_name'];
        $this->session->set_flashdata('success', "Employee {$employee_name} updated successfully.");
        return redirect('employee');
    }



    // Dummy callback for email uniqueness error
    public function email_unique_check()
    {
        return FALSE; // Always return FALSE to trigger the error message
    }

    public function delete($id)
    {
        if ($this->employee_service->delete_employee($id)) {
            $this->session->set_flashdata('success', 'Employee deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete employee');
        }
        redirect('employee');
    }

    public function profile($id)
    {
        $data['title'] = 'Employee Profile';
        $data['employee'] = $this->employee_service->get_employee($id);
        $data['departments'] = $this->masters_service->get_all_departments();
        $data['designations'] = $this->masters_service->get_all_designations();
        $data['allowances'] = $this->payroll_service->get_all_allowances('', 'name', 'asc');
        $data['deductions'] = $this->payroll_service->get_all_deductions('', 'name', 'asc');
        $data['employee_allowances'] = $this->payroll_service->get_employee_allowances($id);
        $data['employee_deductions'] = $this->payroll_service->get_employee_deductions($id);
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        if (!$data['employee']) {
            $this->session->set_flashdata('error', 'Employee not found.');
            redirect('employee');
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/profile', $data);
        $this->load->view('layouts/footer');
    }

    public function date_check($expire_date, $params)
    {
        list($field_type, $index) = explode(',', $params);
        $start_date = $this->input->post("{$field_type}[{$index}][start_date]", TRUE);

        if (!empty($expire_date) && !empty($start_date)) {
            if (strtotime($expire_date) <= strtotime($start_date)) {
                $this->form_validation->set_message("date_check", "The {$field_type} #{$index} expire date must be after the start date.");
                return FALSE;
            }
        }
        return TRUE;
    }

     public function bulk_assign_allowance()
    {
        // $data['title'] = 'Bulk Assign Allowance';
        // $data['allowances'] = $this->payroll_service->get_all_allowances();
        // $data['employees'] = $this->employee_service->get_all_employees();
        // $data['csrf'] = [
        //     'name' => $this->security->get_csrf_token_name(),
        //     'hash' => $this->security->get_csrf_hash()
        // ];

        // if ($this->input->post()) {
        //     $allowance_id = $this->input->post('allowance_id');
        //     $employee_ids = $this->input->post('employee_ids') ?: [];
        //     $months = $this->input->post('months') ?: [];
        //     $year = $this->input->post('year') ?: null;

        //     if (empty($employee_ids) || empty($allowance_id)) {
        //         $this->session->set_flashdata('error', 'Select at least one employee and allowance.');
        //         redirect('employee/bulk_assign_allowance');
        //     }

        //     $this->db->trans_start();
        //     $success = true;

        //     // Assign months to allowance master if variable
        //     $allowance = $this->payroll_service->get_allowance_by_id($allowance_id);
        //     if ($allowance['type'] == 'variable') {
        //         $this->payroll_service->assign_months_to_allowance($allowance_id, $months, $year);
        //     }

        //     // Assign to selected employees
        //     foreach ($employee_ids as $employee_id) {
        //         $this->payroll_service->assign_employee_allowance($employee_id, $allowance_id, $allowance['amount']);
        //     }

        //     $this->db->trans_complete();

        //     if ($this->db->trans_status()) {
        //         $this->session->set_flashdata('success', 'Allowance assigned to ' . count($employee_ids) . ' employees.');
        //         redirect('employee');
        //     } else {
        //         $this->session->set_flashdata('error', 'Failed to assign allowance.');
        //     }
        // }
        $data['title'] = 'Bulk Assign Allowances';
        $data['allowances'] = $this->payroll_service->get_all_allowances();
        $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
        $data['designations'] = $this->masters_service->get_all_designations_for_dropdown();
        $data['employees'] = $this->employee_service->get_all_employees();
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/bulk_assign_allowance', $data);
        $this->load->view('layouts/footer');
    }

    public function store_bulk_assign()
    {
        $this->form_validation->set_rules('allowance_ids[]', 'Allowances', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'numeric');
        $this->form_validation->set_rules('start_date', 'Start Date', 'valid_date');
        $this->form_validation->set_rules('expire_date', 'Expire Date', 'valid_date');
        $this->form_validation->set_message('valid_date', 'The {field} must be a valid date in YYYY-MM-DD format.');

        // Custom validation to ensure at least one target is selected
        $department_ids = $this->input->post('department_ids', TRUE) ?: array();
        $designation_ids = $this->input->post('designation_ids', TRUE) ?: array();
        $employee_ids = $this->input->post('employee_ids', TRUE) ?: array();
        if (empty($department_ids) && empty($designation_ids) && empty($employee_ids)) {
            $this->form_validation->set_rules('target', 'Target', 'required', array('required' => 'At least one Department, Designation, or Employee must be selected.'));
        }

        log_message('debug', 'Store bulk assign posted data: ' . print_r($this->input->post(), TRUE));
        if ($this->form_validation->run() === FALSE) {
            log_message('debug', 'Store bulk assign validation errors: ' . validation_errors());
            $data['title'] = 'Bulk Assign Allowances';
            $data['allowances'] = $this->employee_service->get_all_allowances();
            $data['departments'] = $this->employee_service->get_all_departments_for_dropdown();
            $data['designations'] = $this->employee_service->get_all_designations_for_dropdown();
            $data['employees'] = $this->employee_service->get_all_employees();
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $this->load->view('bulk_assign_allowance', $data);
        } else {
            $allowance_ids = $this->input->post('allowance_ids', TRUE);
            $amount = $this->input->post('amount', TRUE) ?: NULL;
            $start_date = $this->input->post('start_date', TRUE) ?: NULL;
            $expire_date = $this->input->post('expire_date', TRUE) ?: NULL;

            log_message('debug', 'Bulk assign data - Allowances: ' . print_r($allowance_ids, TRUE));
            log_message('debug', 'Bulk assign data - Departments: ' . print_r($department_ids, TRUE));
            log_message('debug', 'Bulk assign data - Designations: ' . print_r($designation_ids, TRUE));
            log_message('debug', 'Bulk assign data - Employees: ' . print_r($employee_ids, TRUE));
            $result = $this->employee_service->bulk_assign_allowances($allowance_ids, $department_ids, $designation_ids, $employee_ids, $amount, $start_date, $expire_date);
            if ($result === TRUE) {
                $this->session->set_flashdata('success', 'Allowances assigned successfully.');
                redirect('employee');
            } else {
                $this->session->set_flashdata('error', $result ?: 'Failed to assign allowances.');
                redirect('employee/bulk_assign');
            }
        }
    }

    public function bulk_assign_deduction()
    {
        $data['title'] = 'Bulk Assign Deduction';
        $data['deductions'] = $this->payroll_service->get_all_deductions();
        $data['employees'] = $this->employee_service->get_all_employees();
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        if ($this->input->post()) {
            $deduction_id = $this->input->post('deduction_id');
            $employee_ids = $this->input->post('employee_ids') ?: [];
            $months = $this->input->post('months') ?: [];
            $year = $this->input->post('year') ?: null;

            if (empty($employee_ids) || empty($deduction_id)) {
                $this->session->set_flashdata('error', 'Select at least one employee and deduction.');
                redirect('employee/bulk_assign_deduction');
            }

            $this->db->trans_start();
            $success = true;

            // Assign months to deduction master if variable
            $deduction = $this->payroll_service->get_deduction_by_id($deduction_id);
            if ($deduction['type'] == 'variable') {
                $this->payroll_service->assign_months_to_deduction($deduction_id, $months, $year);
            }

            // Assign to selected employees
            foreach ($employee_ids as $employee_id) {
                $this->payroll_service->assign_employee_deduction($employee_id, $deduction_id, $deduction['amount']);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Deduction assigned to ' . count($employee_ids) . ' employees.');
                redirect('employee');
            } else {
                $this->session->set_flashdata('error', 'Failed to assign deduction.');
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/bulk_assign_deduction', $data);
        $this->load->view('layouts/footer');
    }

    public function assign_allowance($id = null)
    {
        $data['title'] = 'Assign Allowance';
        $data['employee'] = $id ? $this->employee_service->get_employee($id) : null;
        $data['allowances'] = $this->payroll_service->get_all_allowances();
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        if ($this->input->post()) {
            $employee_id = $this->input->post('employee_id');
            $allowance_id = $this->input->post('allowance_id');
            $months = $this->input->post('months') ?: [];
            $year = $this->input->post('year') ?: null;

            if (empty($employee_id) || empty($allowance_id)) {
                $this->session->set_flashdata('error', 'Select employee and allowance.');
                redirect('employee/assign_allowance/' . $employee_id);
            }

            $this->db->trans_start();
            $success = true;

            // Assign months to allowance master if variable
            $allowance = $this->payroll_service->get_allowance_by_id($allowance_id);
            if ($allowance['type'] == 'variable') {
                $this->payroll_service->assign_months_to_allowance($allowance_id, $months, $year);
            }

            // Assign to employee
            $this->payroll_service->assign_employee_allowance($employee_id, $allowance_id, $allowance['amount']);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Allowance assigned successfully.');
                redirect('employee/profile/' . $employee_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to assign allowance.');
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/assign_allowance', $data);
        $this->load->view('layouts/footer');
    }

    public function assign_deduction($id = null)
    {
        $data['title'] = 'Assign Deduction';
        $data['employee'] = $id ? $this->employee_service->get_employee($id) : null;
        $data['deductions'] = $this->payroll_service->get_all_deductions();
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        if ($this->input->post()) {
            $employee_id = $this->input->post('employee_id');
            $deduction_id = $this->input->post('deduction_id');
            $months = $this->input->post('months') ?: [];
            $year = $this->input->post('year') ?: null;

            if (empty($employee_id) || empty($deduction_id)) {
                $this->session->set_flashdata('error', 'Select employee and deduction.');
                redirect('employee/assign_deduction/' . $employee_id);
            }

            $this->db->trans_start();
            $success = true;

            // Assign months to deduction master if variable
            $deduction = $this->payroll_service->get_deduction_by_id($deduction_id);
            if ($deduction['type'] == 'variable') {
                $this->payroll_service->assign_months_to_deduction($deduction_id, $months, $year);
            }

            // Assign to employee
            $this->payroll_service->assign_employee_deduction($employee_id, $deduction_id, $deduction['amount']);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Deduction assigned successfully.');
                redirect('employee/profile/' . $employee_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to assign deduction.');
            }
        }

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/assign_deduction', $data);
        $this->load->view('layouts/footer');
    }


}