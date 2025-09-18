<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->service('payroll/payroll_service');
        $this->load->library('session');

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
        $sort = $this->input->get('sort', TRUE) ?: 'run_date';
        $order = $this->input->get('order', TRUE) ?: 'desc';

        $data['payroll_runs'] = $this->payroll_service->get_all_payroll_runs($search, $sort, $order);
        $data['title'] = 'Payroll Runs';
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['search'] = $search;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/index', $data);
        $this->load->view('layouts/footer');

    }

    public function create_run()
    {
        $data['title'] = 'Create Payroll Run';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/create_run', $data);
        $this->load->view('layouts/footer');
    }

    public function store_run()
    {
        $this->form_validation->set_rules('run_date', 'Run Date', 'required');
        $this->form_validation->set_rules('period_start', 'Period Start', 'required');
        $this->form_validation->set_rules('period_end', 'Period End', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->create_run();
        } else {
            $data = array(
                'run_date' => $this->input->post('run_date'),
                'period_start' => $this->input->post('period_start'),
                'period_end' => $this->input->post('period_end'),
                'status' => 'draft'
            );
            if ($this->payroll_service->create_payroll_run($data)) {
                $this->session->set_flashdata('success', 'Payroll run created successfully');
                redirect('payroll');
            } else {
                $this->session->set_flashdata('error', 'Failed to create payroll run');
                $this->create_run();
            }
        }
    }

    public function edit_run($id)
    {
        $data['payroll_run'] = $this->payroll_service->get_payroll_run($id);
        if (!$data['payroll_run']) {
            show_404();
        }
        $data['title'] = 'Edit Payroll Run';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/edit_run', $data);
        $this->load->view('layouts/footer');
    }

    public function update_run($id)
    {
        $this->form_validation->set_rules('run_date', 'Run Date', 'required');
        $this->form_validation->set_rules('period_start', 'Period Start', 'required');
        $this->form_validation->set_rules('period_end', 'Period End', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_run($id);
        } else {
            $data = array(
                'run_date' => $this->input->post('run_date'),
                'period_start' => $this->input->post('period_start'),
                'period_end' => $this->input->post('period_end')
            );
            if ($this->payroll_service->update_payroll_run($id, $data)) {
                $this->session->set_flashdata('success', 'Payroll run updated successfully');
                redirect('payroll');
            } else {
                $this->session->set_flashdata('error', 'Failed to update payroll run');
                $this->edit_run($id);
            }
        }
    }

    public function delete_run($id)
    {
        if ($this->payroll_service->delete_payroll_run($id)) {
            $this->session->set_flashdata('success', 'Payroll run deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete payroll run');
        }
        redirect('payroll');
    }

    public function view_run($id)
    {
        $data['payroll_run'] = $this->payroll_service->get_payroll_run($id);
        $data['payroll_details'] = $this->payroll_service->get_payroll_details($id);
        $data['title'] = 'Payroll Run Details';
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/view_run', $data);
        $this->load->view('layouts/footer');
    }

    public function generate_run($id)
    {
        if ($this->payroll_service->generate_payroll_run($id)) {
            $this->session->set_flashdata('success', 'Payroll run generated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to generate payroll run');
        }
        redirect('payroll/view_run/' . $id);
    }

    // Allowance management
    public function allowances()
    {
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'id';
        $order = $this->input->get('order', TRUE) ?: 'asc';

        $data['allowances'] = $this->payroll_service->get_all_allowances($search, $sort, $order);
        $data['title'] = 'Allowances Management';
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['search'] = $search;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/allowances', $data);
        $this->load->view('layouts/footer');
    }

    public function create_allowance()
    {
        $data['title'] = 'Create Allowance';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/create_allowance', $data);
        $this->load->view('layouts/footer');
    }

    public function store_allowance()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[allowances.name]');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->create_allowance();
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description')
            );
            if ($this->payroll_service->create_allowance($data)) {
                $this->session->set_flashdata('success', 'Allowance created successfully');
                redirect('payroll/allowances');
            } else {
                $this->session->set_flashdata('error', 'Failed to create allowance');
                $this->create_allowance();
            }
        }
    }

    public function edit_allowance($id)
    {
        $data['allowance'] = $this->payroll_service->get_allowance($id);
        if (!$data['allowance']) {
            show_404();
        }
        $data['title'] = 'Edit Allowance';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/edit_allowance', $data);
        $this->load->view('layouts/footer');
    }

    public function update_allowance($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_allowance_name[' . $id . ']');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_allowance($id);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description')
            );
            if ($this->payroll_service->update_allowance($id, $data)) {
                $this->session->set_flashdata('success', 'Allowance updated successfully');
                redirect('payroll/allowances');
            } else {
                $this->session->set_flashdata('error', 'Failed to update allowance');
                $this->edit_allowance($id);
            }
        }
    }

    public function delete_allowance($id)
    {
        if ($this->payroll_service->delete_allowance($id)) {
            $this->session->set_flashdata('success', 'Allowance deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Cannot delete allowance assigned to employees');
        }
        redirect('payroll/allowances');
    }

    // Deduction management
    public function deductions()
    {
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'id';
        $order = $this->input->get('order', TRUE) ?: 'asc';

        $data['deductions'] = $this->payroll_service->get_all_deductions($search, $sort, $order);
        $data['title'] = 'Deductions Management';
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['search'] = $search;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/deductions', $data);
        $this->load->view('layouts/footer');
    }

    public function create_deduction()
    {
        $data['title'] = 'Create Deduction';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/create_deduction', $data);
        $this->load->view('layouts/footer');
    }

    public function store_deduction()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[deductions.name]');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->create_deduction();
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description')
            );
            if ($this->payroll_service->create_deduction($data)) {
                $this->session->set_flashdata('success', 'Deduction created successfully');
                redirect('payroll/deductions');
            } else {
                $this->session->set_flashdata('error', 'Failed to create deduction');
                $this->create_deduction();
            }
        }
    }

    public function edit_deduction($id)
    {
        $data['deduction'] = $this->payroll_service->get_deduction($id);
        if (!$data['deduction']) {
            show_404();
        }
        $data['title'] = 'Edit Deduction';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/edit_deduction', $data);
        $this->load->view('layouts/footer');
    }

    public function update_deduction($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_deduction_name[' . $id . ']');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_deduction($id);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description')
            );
            if ($this->payroll_service->update_deduction($id, $data)) {
                $this->session->set_flashdata('success', 'Deduction updated successfully');
                redirect('payroll/deductions');
            } else {
                $this->session->set_flashdata('error', 'Failed to update deduction');
                $this->edit_deduction($id);
            }
        }
    }

    public function delete_deduction($id)
    {
        if ($this->payroll_service->delete_deduction($id)) {
            $this->session->set_flashdata('success', 'Deduction deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Cannot delete deduction assigned to employees');
        }
        redirect('payroll/deductions');
    }

    // Employee assignment methods
    public function assign_employee_allowances($employee_id)
    {
        $data['employee'] = $this->employee_service->get_employee($employee_id);
        $data['allowances'] = $this->payroll_service->get_all_allowances();
        $data['employee_allowances'] = $this->payroll_service->get_employee_allowances($employee_id);
        $data['title'] = 'Assign Allowances to ' . $data['employee']['first_name'] . ' ' . $data['employee']['last_name'];
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/assign_allowances', $data);
        $this->load->view('layouts/footer');
    }

    public function store_employee_allowance($employee_id)
    {
        $allowance_id = $this->input->post('allowance_id');
        $amount = $this->input->post('amount');

        if ($this->payroll_service->assign_allowance($employee_id, $allowance_id, $amount)) {
            $this->session->set_flashdata('success', 'Allowance assigned successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to assign allowance');
        }
        redirect('employee/edit/' . $employee_id);
    }

    // Callback methods
    public function check_allowance_name($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('allowances');
        return $query->num_rows() == 0;
    }

    public function check_deduction_name($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('deductions');
        return $query->num_rows() == 0;
    }
}