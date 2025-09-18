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

    // public function create()
    // {
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );
    //     $data['title'] = 'Add Employee';


    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('employee/create', $data);
    //     $this->load->view('layouts/footer');
    // }

    public function create()
    {
        $data['title'] = 'Create Employee';
        $data['departments'] = $this->masters_service->get_all_departments();
        $data['designations'] = $this->masters_service->get_all_designations();
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


    // public function store()
    // {
    //     $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
    //     $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
    //     $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[employees.email]');
    //     $this->form_validation->set_rules('phone', 'Phone', 'trim');
    //     $this->form_validation->set_rules('salary', 'Salary', 'required|numeric|greater_than_equal_to[0]');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create();
    //     } else {
    //         $data = array(
    //             'first_name' => $this->input->post('first_name'),
    //             'last_name' => $this->input->post('last_name'),
    //             'email' => $this->input->post('email'),
    //             'phone' => $this->input->post('phone'),
    //             'salary' => $this->input->post('salary')
    //         );
    //         if ($this->employee_service->create_employee($data)) {
    //             $this->session->set_flashdata('success', 'Employee created successfully');
    //             redirect('employee');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to create employee');
    //             $this->create();
    //         }
    //     }
    // }


    // public function store()
    // {
    //     $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[50]');
    //     $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[50]');
    //     $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]|is_unique[employees.email]');
    //     $this->form_validation->set_rules('phone', 'Phone', 'required|trim|max_length[15]');
    //     $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
    //     $this->form_validation->set_rules('designation_id', 'Designation', 'required|integer');
    //     $this->form_validation->set_rules('salary', 'Basic Salary', 'required|numeric|greater_than[0]');

    //     $allowances = $this->input->post('allowances', TRUE);
    //     $deductions = $this->input->post('deductions', TRUE);

    //     if ($allowances) {
    //         foreach ($allowances as $index => $allowance) {
    //             if (empty($allowance['id'])) continue; // Skip empty rows
    //             $this->form_validation->set_rules("allowances[{$index}][id]", "Allowance ID #{$index}", 'required|integer');
    //             $this->form_validation->set_rules("allowances[{$index}][amount]", "Allowance Amount #{$index}", 'numeric|greater_than[0]');
    //             $this->form_validation->set_rules("allowances[{$index}][start_date]", "Allowance Start Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']); //
    //             $this->form_validation->set_rules("allowances[{$index}][expire_date]", "Allowance Expire Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]|callback_date_check[allowances,' . $index . ']', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
    //         }
    //     }

    //     if ($deductions) {
    //         foreach ($deductions as $index => $deduction) {
    //             if (empty($deduction['id'])) continue;
    //             $this->form_validation->set_rules("deductions[{$index}][id]", "Deduction ID #{$index}", 'required|integer');
    //             $this->form_validation->set_rules("deductions[{$index}][amount]", "Deduction Amount #{$index}", 'numeric|greater_than[0]');
    //             $this->form_validation->set_rules("deductions[{$index}][start_date]", "Deduction Start Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
    //             $this->form_validation->set_rules("deductions[{$index}][expire_date]", "Deduction Expire Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]|callback_date_check[deductions,' . $index . ']', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
    //         }
    //     }

    //     if ($this->form_validation->run() === FALSE) {
    //         $this->create();
    //     } else {
    //         $employee_data = [
    //             'first_name' => $this->input->post('first_name', TRUE),
    //             'last_name' => $this->input->post('last_name', TRUE),
    //             'email' => $this->input->post('email', TRUE),
    //             'phone' => $this->input->post('phone', TRUE),
    //             'salary' => $this->input->post('salary', TRUE),
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s')
    //         ];

    //         $this->db->trans_start();
    //         $employee_id = $this->employee_service->create_employee($employee_data);

    //         $department_id = $this->input->post('department_id', TRUE);
    //         $this->masters_service->assign_department($employee_id, $department_id);

    //         $designation_id = $this->input->post('designation_id', TRUE);
    //         $this->masters_service->assign_designation($employee_id, $designation_id);

    //         if ($allowances) {
    //             $allowances = array_filter($allowances, function($a) { return !empty($a['id']); });
    //             $this->employee_service->assign_employee_allowances($employee_id, $allowances);
    //         }

    //         if ($deductions) {
    //             $deductions = array_filter($deductions, function($a) { return !empty($a['id']); });
    //             $this->employee_service->assign_employee_deductions($employee_id, $deductions);
    //         }

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === FALSE) {
    //             $this->session->set_flashdata('error', 'Failed to create employee.');
    //             $this->create();
    //         } else {
    //             $this->session->set_flashdata('success', 'Employee created successfully.');
    //             redirect('employee');
    //         }
    //     }
    // }

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
                    return !empty($a['id']); });
                $this->employee_service->assign_employee_allowances($employee_id, $allowances);
            }

            if ($deductions) {
                $deductions = array_filter($deductions, function ($a) {
                    return !empty($a['id']); });
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

    // public function edit($id)
    // {
    //     $data['employee'] = $this->employee_service->get_employee($id);
    //     if (!$data['employee']) {
    //         show_404();
    //     }
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );
    //     $data['title'] = 'Edit Employee';

    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('employee/edit', $data);
    //     $this->load->view('layouts/footer');
    // }


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

    // public function update($id)
    // {
    //     $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
    //     $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
    //     $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    //     $this->form_validation->set_rules('phone', 'Phone', 'trim');
    //     $this->form_validation->set_rules('salary', 'Salary', 'required|numeric|greater_than_equal_to[0]');

    //     // Manual email uniqueness check
    //     $email = $this->input->post('email');
    //     $current_employee = $this->employee_service->get_employee($id);
    //     if (!$current_employee) {
    //         $this->session->set_flashdata('error', 'Employee not found');
    //         $this->edit($id);
    //         return;
    //     }

    //     $email_valid = true;
    //     if ($email !== $current_employee['email']) {
    //         // Check if email is already used by another employee
    //         $this->db->where('email', $email);
    //         $this->db->where('id !=', $id);
    //         $query = $this->db->get('employees');
    //         if ($query->num_rows() > 0) {
    //             $email_valid = false;
    //             $this->form_validation->set_message('email_unique_check', 'The Email is already in use by another employee.');
    //         }
    //     }

    //     // Add a dummy rule to trigger the custom error
    //     if (!$email_valid) {
    //         $this->form_validation->set_rules('email', 'Email', 'callback_email_unique_check');
    //     }

    //     if ($this->form_validation->run() == FALSE || !$email_valid) {
    //         log_message('debug', 'Validation failed: ' . validation_errors());
    //         $this->edit($id);
    //     } else {
    //         $data = array(
    //             'first_name' => $this->input->post('first_name'),
    //             'last_name' => $this->input->post('last_name'),
    //             'email' => $this->input->post('email'),
    //             'phone' => $this->input->post('phone'),
    //             'salary' => $this->input->post('salary')
    //         );
    //         if ($this->employee_service->update_employee($id, $data)) {
    //             $this->session->set_flashdata('success', 'Employee updated successfully');
    //             redirect('employee');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update employee');
    //             $this->edit($id);
    //         }
    //     }
    // }

    public function update($id)
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[100]');//what is done by this code line? 
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|max_length[15]');
        $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('designation_id', 'Designation', 'required|integer');
        $this->form_validation->set_rules('salary', 'Basic Salary', 'required|numeric|greater_than[0]');

        $allowances = $this->input->post('allowances', TRUE);
        $deductions = $this->input->post('deductions', TRUE);

        if ($allowances) {
            foreach ($allowances as $index => $allowance) {
                if (empty($allowance['id']))
                    continue;
                $this->form_validation->set_rules("allowances[{$index}][id]", "Allowance ID #{$index}", 'required|integer');
                $this->form_validation->set_rules("allowances[{$index}][amount]", "Allowance Amount #{$index}", 'numeric|greater_than[0]');
                // $this->form_validation->set_rules("allowances[{$index}][start_date]", "Allowance Start Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
                // $this->form_validation->set_rules("allowances[{$index}][expire_date]", "Allowance Expire Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]|callback_date_check[allowances,' . $index . ']', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
                
            }
        }

        if ($deductions) {
            foreach ($deductions as $index => $deduction) {
                if (empty($deduction['id']))
                    continue;
                $this->form_validation->set_rules("deductions[{$index}][id]", "Deduction ID #{$index}", 'required|integer');
                $this->form_validation->set_rules("deductions[{$index}][amount]", "Deduction Amount #{$index}", 'numeric|greater_than[0]');
                // $this->form_validation->set_rules("deductions[{$index}][start_date]", "Deduction Start Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
                // $this->form_validation->set_rules("deductions[{$index}][expire_date]", "Deduction Expire Date #{$index}", 'regex_match[/^\d{4}-\d{2}-\d{2}$/]|callback_date_check[deductions,' . $index . ']', ['regex_match' => 'The {field} must be a valid date (YYYY-MM-DD).']);
            }
        }

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $employee_data = [
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'salary' => $this->input->post('salary', TRUE),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->trans_start();
            $this->employee_service->update_employee($id, $employee_data);

            $department_id = $this->input->post('department_id', TRUE);
            $this->masters_service->update_employee_department($id, $department_id);

            $designation_id = $this->input->post('designation_id', TRUE);
            $this->masters_service->update_employee_designation($id, $designation_id);

            $existing_allowances = $this->payroll_service->get_employee_allowances($id);
            $existing_allowance_ids = array_column($existing_allowances, 'allowance_id');
            $submitted_allowance_ids = [];

            if ($allowances) {
                $allowances = array_filter($allowances, function ($a) {
                    return !empty($a['id']); });
                foreach ($allowances as $allowance) {
                    $submitted_allowance_ids[] = $allowance['id'];
                    if (in_array($allowance['id'], $existing_allowance_ids)) {
                        $this->payroll_service->update_employee_allowances($id, $allowance['id'], $allowance['amount'], $allowance['start_date'], $allowance['expire_date']);
                    } else {
                        $this->payroll_service->assign_allowance($id, $allowance['id'], $allowance['amount'], $allowance['start_date'], $allowance['expire_date']);
                    }
                }
            }

            $allowances_to_remove = array_diff($existing_allowance_ids, $submitted_allowance_ids);
            if ($allowances_to_remove) {
                $this->employee_service->remove_employee_allowances($id, $allowances_to_remove);
            }

            $existing_deductions = $this->payroll_service->get_employee_deductions($id);
            $existing_deduction_ids = array_column($existing_deductions, 'deduction_id');
            $submitted_deduction_ids = [];

            if ($deductions) {
                $deductions = array_filter($deductions, function ($a) {
                    return !empty($a['id']); });
                foreach ($deductions as $deduction) {
                    $submitted_deduction_ids[] = $deduction['id'];
                    if (in_array($deduction['id'], $existing_deduction_ids)) {
                        $this->payroll_service->update_employee_deductions($id, $deduction['id'], $deduction['amount'], $deduction['start_date'], $deduction['expire_date']);
                    } else {
                        $this->payroll_service->assign_deduction($id, $deduction['id'], $deduction['amount'], $deduction['start_date'], $deduction['expire_date']);
                    }
                }
            }

            $deductions_to_remove = array_diff($existing_deduction_ids, $submitted_deduction_ids);
            if ($deductions_to_remove) {
                $this->employee_service->remove_employee_deductions($id, $deductions_to_remove);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Failed to update employee.');
                $this->edit($id);
            } else {
                $this->session->set_flashdata('success', 'Employee updated successfully.');
                redirect('employee');
            }
        }
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

    // public function profile($id)
    // {
    //     $data['employee'] = $this->employee_service->get_employee($id);
    //     if (!$data['employee']) {
    //         show_404();
    //     }
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );
    //     $data['title'] = 'Employee Profile';

    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('employee/profile', $data);
    //     $this->load->view('layouts/footer');
    // }

    // public function date_check($expire_date, $params)
    // {
    //     list($field_type, $index) = explode(',', $params);
    //     $start_date = $this->input->post("{$field_type}[{$index}][start_date]", TRUE);

    //     if (!empty($expire_date) && !empty($start_date)) {
    //         if (strtotime($expire_date) <= strtotime($start_date)) {
    //             $this->form_validation->set_message("date_check", "The {$field_type}[{$index}][expire_date] must be after the start date.");
    //             return FALSE;
    //         }
    //     }
    //     return TRUE;
    // }

    // public function date_check($date)
    // {
    //     if (empty($date)) {
    //         return true; // allow empty (optional field)
    //     }

    //     // Example format check (Y-m-d)
    //     if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
    //         return true;
    //     }

    //     $this->form_validation->set_message('date_check', 'The {field} must be a valid date in YYYY-MM-DD format.');
    //     return false;
    // }

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


}