<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payroll extends MX_Controller
{

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
    // public function allowances()
    // {
    //     $search = $this->input->get('search', TRUE);
    //     $sort = $this->input->get('sort', TRUE) ?: 'id';
    //     $order = $this->input->get('order', TRUE) ?: 'asc';

    //     $data['allowances'] = $this->payroll_service->get_all_allowances($search, $sort, $order);
    //     $data['title'] = 'Allowances Management';
    //     $data['sort'] = $sort;
    //     $data['order'] = $order;
    //     $data['search'] = $search;
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );

    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('payroll/allowances', $data);
    //     $this->load->view('layouts/footer');
    // }

    public function allowances()
    {
        $data['title'] = 'Allowances Management';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];
        $data['search'] = $this->input->get('search', TRUE) ?? '';
        $data['sort'] = $this->input->get('sort', TRUE) ?? 'name';
        $data['order'] = $this->input->get('order', TRUE) ?? 'asc';

        // Build query
        $this->db->select('id, name, type, amount, description');
        $this->db->from('allowances');
        if ($data['search']) {
            $this->db->group_start();
            $this->db->like('name', $data['search']);
            $this->db->or_like('description', $data['search']);
            $this->db->group_end();
        }
        $this->db->order_by($data['sort'], $data['order']);
        $query = $this->db->get();
        $allowances = $query->result_array();

        // Fetch months and year for each allowance
        foreach ($allowances as &$allowance) {
            // $this->db->select('month, year');
            // $this->db->from('allowance_applicable_months');
            // $this->db->where('allowance_id', $allowance['id']);
            // $months_query = $this->db->get();
            // $months_data = $months_query->result_array();
            // $allowance['months'] = array_column($months_data, 'month');
            // $allowance['year'] = !empty($months_data) ? $months_data[0]['year'] : null;

            $months_data = $this->payroll_service->get_applicable_months_for_allowance($allowance['id']);
            $allowance['months'] = $months_data['months'];
            $allowance['year'] = $months_data['year'];
        }

        $data['allowances'] = $allowances;
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

    // public function store_allowance()
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[allowances.name]');
    //     $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
    //     $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create_allowance();
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'type' => $this->input->post('type'),
    //             'amount' => $this->input->post('amount'),
    //             'description' => $this->input->post('description')
    //         );
    //         if ($this->payroll_service->create_allowance($data)) {
    //             $this->session->set_flashdata('success', 'Allowance created successfully');
    //             redirect('payroll/allowances');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to create allowance');
    //             $this->create_allowance();
    //         }
    //     }
    // }

    public function store_allowance()
    {
        $this->form_validation->set_rules('name', 'Allowance Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $this->create_allowance();
        } else {
            $data = [
                'name' => $this->input->post('name'),
                'type' => $this->input->post('type'),
                'amount' => $this->input->post('amount'),
                'description' => $this->input->post('description'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->db->trans_start();
            $this->payroll_service->create_allowance($data);
            $allowance_id = $this->db->insert_id();

            if ($data['type'] == 'variable') {
                $months = $this->input->post('months') ?: [];
                $year = $this->input->post('year') ?: null;
                $this->payroll_service->assign_months_to_allowance($allowance_id, $months, $year);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Allowance created successfully.');
                redirect('payroll/allowances');
            } else {
                $this->session->set_flashdata('error', 'Failed to create allowance.');
                $this->create_allowance();
            }
        }
    }

    // public function edit_allowance($id)
    // {
    //     $data['allowance'] = $this->payroll_service->get_allowance($id);
    //     if (!$data['allowance']) {
    //         show_404();
    //     }
    //     $data['title'] = 'Edit Allowance';
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );
    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('payroll/edit_allowance', $data);
    //     $this->load->view('layouts/footer');
    // }

    public function view_allowance($id)
    {
        $data['title'] = 'View Allowance';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];
        $this->db->select('id, name, type, amount, description');
        $this->db->from('allowances');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data['allowance'] = $query->row_array();

        if (!$data['allowance']) {
            $this->session->set_flashdata('error', 'Allowance not found.');
            redirect('payroll/allowances');
        }

        // $this->db->select('month, year');
        // $this->db->from('allowance_applicable_months');
        // $this->db->where('allowance_id', $id);
        // $months_query = $this->db->get();
        // $data['allowance']['months'] = array_column($months_query->result_array(), 'month');
        // $data['allowance']['year'] = $months_query->num_rows() > 0 ? $months_query->row()->year : null;


        $months_data = $this->payroll_service->get_applicable_months_for_allowance($id);
        $data['allowance']['months'] = $months_data['months'];
        $data['allowance']['year'] = $months_data['year'];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/view_allowance', $data);
        $this->load->view('layouts/footer');
    }

    // public function update_allowance($id)
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_allowance_name[' . $id . ']');
    //     $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
    //     $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->edit_allowance($id);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'type' => $this->input->post('type'),
    //             'amount' => $this->input->post('amount'),
    //             'description' => $this->input->post('description')
    //         );
    //         if ($this->payroll_service->update_allowance($id, $data)) {
    //             $this->session->set_flashdata('success', 'Allowance updated successfully');
    //             redirect('payroll/allowances');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update allowance');
    //             $this->edit_allowance($id);
    //         }
    //     }
    // }

    // public function update_allowance($id)
    // {
    //     $this->form_validation->set_rules('name', 'Allowance Name', 'required|trim|max_length[255]');
    //     $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
    //     $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     if ($this->form_validation->run() === FALSE) {
    //         $data['title'] = 'Edit Allowance';
    //         $data['allowance'] = $this->payroll_service->get_allowance_by_id($id);
    //         $data['csrf'] = [
    //             'name' => $this->security->get_csrf_token_name(),
    //             'hash' => $this->security->get_csrf_hash()
    //         ];
    //         $this->load->view('layouts/header', $data);
    //         $this->load->view('layouts/sidebar');
    //         $this->load->view('payroll/edit_allowance', $data);
    //         $this->load->view('layouts/footer');
    //     } else {
    //         $data = [
    //             'name' => $this->input->post('name'),
    //             'type' => $this->input->post('type'),
    //             'amount' => $this->input->post('amount'),
    //             'description' => $this->input->post('description'),
    //             'updated_at' => date('Y-m-d H:i:s')
    //         ];

    //         $this->db->trans_start();
    //         $this->payroll_service->update_allowance($id, $data);

    //         if ($data['type'] == 'variable') {
    //             $months = $this->input->post('months') ?: [];
    //             $year = $this->input->post('year') ?: null;
    //             $this->payroll_service->assign_months_to_allowance($id, $months, $year);
    //         } else {
    //             $this->db->where('allowance_id', $id);
    //             $this->db->delete('allowance_applicable_months');
    //         }

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status()) {
    //             $this->session->set_flashdata('success', 'Allowance updated successfully.');
    //             redirect('payroll/allowances');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update allowance.');
    //             $this->edit_allowance($id);
    //         }
    //     }
    // }

    public function update_allowance($id)
    {
        // Set validation rules
        $this->form_validation->set_rules('name', 'Allowance Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('year', 'Year', 'trim|numeric|greater_than_equal_to[2025]|less_than_equal_to[2035]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit_allowance($id);
            return;
        }

        // Prepare allowance data
        $data = [
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Start transaction
        $this->db->trans_start();

        // Update allowance
        $this->db->where('id', $id);
        $this->db->update('allowances', $data);

        // Handle variable allowance months
        if ($data['type'] == 'variable') {
            if ($this->input->post('select_all_months')) {
                $months = range(1, 12);
            } else {
                $months = $this->input->post('months') ? $this->input->post('months') : [];
            }
            $year = $this->input->post('year') ? $this->input->post('year') : null;

            if (!empty($months) && !$this->payroll_service->assign_months_to_allowance($id, $months, $year)) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to assign months to allowance.');
                $this->edit_allowance($id);
                return;
            }
        } else {
            // Clear months for fixed allowances
            $this->db->where('allowance_id', $id);
            $this->db->delete('allowance_applicable_months');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Allowance updated successfully.');
            redirect('payroll/allowances');
        } else {
            $this->session->set_flashdata('error', 'Failed to update allowance.');
            $this->edit_allowance($id);
        }
    }


    public function edit_allowance($id)
    {
        $data['title'] = 'Edit Allowance';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];
        $this->db->select('id, name, type, amount, description');
        $this->db->from('allowances');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data['allowance'] = $query->row_array();

        if (!$data['allowance']) {
            $this->session->set_flashdata('error', 'Allowance not found.');
            redirect('payroll/allowances');
        }

        // $this->db->select('month, year');
        // $this->db->from('allowance_applicable_months');
        // $this->db->where('allowance_id', $id);
        // $months_query = $this->db->get();
        // $data['allowance']['months'] = array_column($months_query->result_array(), 'month');
        // $data['allowance']['year'] = $months_query->num_rows() > 0 ? $months_query->row()->year : null;

        $months_data = $this->payroll_service->get_applicable_months_for_allowance($id);
        $data['allowance']['months'] = $months_data['months'];
        $data['allowance']['year'] = $months_data['year'];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/edit_allowance', $data);
        $this->load->view('layouts/footer');
    }

    // public function delete_allowance($id)
    // {
    //     if ($this->payroll_service->delete_allowance($id)) {
    //         $this->session->set_flashdata('success', 'Allowance deleted successfully');
    //     } else {
    //         $this->session->set_flashdata('error', 'Cannot delete allowance assigned to employees');
    //     }
    //     redirect('payroll/allowances');
    // }


    public function delete_allowance($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->delete('allowances'); // CASCADE deletes from allowance_applicable_months
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Allowance deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete allowance.');
        }
        redirect('payroll/allowances');
    }

    // Deduction management
    // public function deductions()
    // {
    //     $search = $this->input->get('search', TRUE);
    //     $sort = $this->input->get('sort', TRUE) ?: 'id';
    //     $order = $this->input->get('order', TRUE) ?: 'asc';

    //     $data['deductions'] = $this->payroll_service->get_all_deductions($search, $sort, $order);
    //     $data['title'] = 'Deductions Management';
    //     $data['sort'] = $sort;
    //     $data['order'] = $order;
    //     $data['search'] = $search;
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );

    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('payroll/deductions', $data);
    //     $this->load->view('layouts/footer');
    // }

    // public function create_deduction()
    // {
    //     $data['title'] = 'Create Deduction';
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );
    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('payroll/create_deduction', $data);
    //     $this->load->view('layouts/footer');
    // }

    // public function store_deduction()
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[deductions.name]');
    //     $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
    //     $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create_deduction();
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'type' => $this->input->post('type'),
    //             'amount' => $this->input->post('amount'),
    //             'description' => $this->input->post('description')
    //         );
    //         if ($this->payroll_service->create_deduction($data)) {
    //             $this->session->set_flashdata('success', 'Deduction created successfully');
    //             redirect('payroll/deductions');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to create deduction');
    //             $this->create_deduction();
    //         }
    //     }
    // }

    // public function edit_deduction($id)
    // {
    //     $data['deduction'] = $this->payroll_service->get_deduction($id);
    //     if (!$data['deduction']) {
    //         show_404();
    //     }
    //     $data['title'] = 'Edit Deduction';
    //     $data['csrf'] = array(
    //         'name' => $this->security->get_csrf_token_name(),
    //         'hash' => $this->security->get_csrf_hash()
    //     );
    //     $this->load->view('layouts/header', $data);
    //     $this->load->view('layouts/sidebar');
    //     $this->load->view('payroll/edit_deduction', $data);
    //     $this->load->view('layouts/footer');
    // }

    // public function update_deduction($id)
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_deduction_name[' . $id . ']');
    //     $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
    //     $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than_equal_to[0]');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->edit_deduction($id);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'type' => $this->input->post('type'),
    //             'amount' => $this->input->post('amount'),
    //             'description' => $this->input->post('description')
    //         );
    //         if ($this->payroll_service->update_deduction($id, $data)) {
    //             $this->session->set_flashdata('success', 'Deduction updated successfully');
    //             redirect('payroll/deductions');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update deduction');
    //             $this->edit_deduction($id);
    //         }
    //     }
    // }

    // public function delete_deduction($id)
    // {
    //     if ($this->payroll_service->delete_deduction($id)) {
    //         $this->session->set_flashdata('success', 'Deduction deleted successfully');
    //     } else {
    //         $this->session->set_flashdata('error', 'Cannot delete deduction assigned to employees');
    //     }
    //     redirect('payroll/deductions');
    // }

    public function deductions()
    {
        $data['title'] = 'Deductions Management';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];
        $data['search'] = $this->input->get('search', TRUE) ?? '';
        $data['sort'] = $this->input->get('sort', TRUE) ?? 'name';
        $data['order'] = $this->input->get('order', TRUE) ?? 'asc';

        // Build query
        $this->db->select('id, name, type, amount, description');
        $this->db->from('deductions');
        if ($data['search']) {
            $this->db->group_start();
            $this->db->like('name', $data['search']);
            $this->db->or_like('description', $data['search']);
            $this->db->group_end();
        }
        $this->db->order_by($data['sort'], $data['order']);
        $query = $this->db->get();
        $deductions = $query->result_array();

        // Fetch months and year for each deduction
        foreach ($deductions as &$deduction) {
            $months_data = $this->payroll_service->get_applicable_months_for_deduction($deduction['id']);
            $deduction['months'] = $months_data['months'];
            $deduction['year'] = $months_data['year'];
        }

        $data['deductions'] = $deductions;
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/deductions', $data);
        $this->load->view('layouts/footer');
    }


    public function create_deduction()
    {
        $data['title'] = 'Create Deduction';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/create_deduction', $data);
        $this->load->view('layouts/footer');
    }

    /**
     * Handles the creation of a new deduction.
     */
    public function store_deduction()
    {
        $this->form_validation->set_rules('name', 'Deduction Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('year', 'Year', 'trim|numeric|greater_than_equal_to[2025]|less_than_equal_to[2035]');

        if ($this->form_validation->run() === FALSE) {
            $this->create_deduction();
            return;
        }

        $data = [
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_start();
        $this->db->insert('deductions', $data);
        $deduction_id = $this->db->insert_id();

        if ($data['type'] == 'variable') {
            if ($this->input->post('select_all_months')) {
                $months = range(1, 12);
            } else {
                $months = $this->input->post('months') ? $this->input->post('months') : [];
            }
            $year = $this->input->post('year') ? $this->input->post('year') : null;

            if (!empty($months) && !$this->payroll_service->assign_months_to_deduction($deduction_id, $months, $year)) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to assign months to deduction.');
                $this->create_deduction();
                return;
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Deduction created successfully.');
            redirect('payroll/deductions');
        } else {
            $this->session->set_flashdata('error', 'Failed to create deduction.');
            $this->create_deduction();
        }
    }

    /**
     * Displays the view deduction page.
     */
    public function view_deduction($id)
    {
        $data['title'] = 'View Deduction';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        $this->db->select('id, name, type, amount, description');
        $this->db->from('deductions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data['deduction'] = $query->row_array();

        if (!$data['deduction']) {
            $this->session->set_flashdata('error', 'Deduction not found.');
            redirect('payroll/deductions');
        }

        $months_data = $this->payroll_service->get_applicable_months_for_deduction($id);
        $data['deduction']['months'] = $months_data['months'];
        $data['deduction']['year'] = $months_data['year'];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/view_deduction', $data);
        $this->load->view('layouts/footer');
    }

    /**
     * Displays the edit deduction form.
     */
    public function edit_deduction($id)
    {
        $data['title'] = 'Edit Deduction';
        $data['csrf'] = [
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        ];

        $this->db->select('id, name, type, amount, description');
        $this->db->from('deductions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $data['deduction'] = $query->row_array();

        if (!$data['deduction']) {
            $this->session->set_flashdata('error', 'Deduction not found.');
            redirect('payroll/deductions');
        }

        $months_data = $this->payroll_service->get_applicable_months_for_deduction($id);
        $data['deduction']['months'] = $months_data['months'];
        $data['deduction']['year'] = $months_data['year'];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('payroll/edit_deduction', $data);
        $this->load->view('layouts/footer');
    }

    /**
     * Handles the update of an existing deduction.
     */
    public function update_deduction($id)
    {
        $this->form_validation->set_rules('name', 'Deduction Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('type', 'Type', 'required|in_list[fixed,variable]');
        $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('year', 'Year', 'trim|numeric|greater_than_equal_to[2025]|less_than_equal_to[2035]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit_deduction($id);
            return;
        }

        $data = [
            'name' => $this->input->post('name'),
            'type' => $this->input->post('type'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_start();

        $this->db->where('id', $id);
        $this->db->update('deductions', $data);

        if ($data['type'] == 'variable') {
            if ($this->input->post('select_all_months')) {
                $months = range(1, 12);
            } else {
                $months = $this->input->post('months') ? $this->input->post('months') : [];
            }
            $year = $this->input->post('year') ? $this->input->post('year') : null;

            if (!empty($months) && !$this->payroll_service->assign_months_to_deduction($id, $months, $year)) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Failed to assign months to deduction.');
                $this->edit_deduction($id);
                return;
            }
        } else {
            $this->db->where('deduction_id', $id);
            $this->db->delete('deduction_applicable_months');
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Deduction updated successfully.');
            redirect('payroll/deductions');
        } else {
            $this->session->set_flashdata('error', 'Failed to update deduction.');
            $this->edit_deduction($id);
        }
    }

    /**
     * Deletes a deduction.
     */
    public function delete_deduction($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->delete('deductions'); // CASCADE deletes from deduction_applicable_months
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Deduction deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete deduction.');
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