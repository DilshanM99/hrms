<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masters extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->service('employee/masters_service');
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

    // Department methods
    public function departments()
    {
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'id';
        $order = $this->input->get('order', TRUE) ?: 'asc';

        $data['departments'] = $this->masters_service->get_all_departments($search, $sort, $order);
        $data['title'] = 'Departments Management';
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['search'] = $search;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/departments', $data);
        $this->load->view('layouts/footer');
    }

    public function create_department()
    {
        $data['title'] = 'Create Department';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/create_department', $data);
        $this->load->view('layouts/footer');
    }

    public function store_department()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[departments.name]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create_department();
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            if ($this->masters_service->create_department($data)) {
                $this->session->set_flashdata('success', 'Department created successfully');
                redirect('employee/masters/departments');
            } else {
                $this->session->set_flashdata('error', 'Failed to create department');
                $this->create_department();
            }
        }
    }

    public function edit_department($id)
    {
        $data['department'] = $this->masters_service->get_department($id);
        if (!$data['department']) {
            show_404();
        }
        $data['title'] = 'Edit Department';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/edit_department', $data);
        $this->load->view('layouts/footer');
    }

    public function update_department($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_department_name[' . $id . ']');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_department($id);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            if ($this->masters_service->update_department($id, $data)) {
                $this->session->set_flashdata('success', 'Department updated successfully');
                redirect('employee/masters/departments');
            } else {
                $this->session->set_flashdata('error', 'Failed to update department');
                $this->edit_department($id);
            }
        }
    }

    public function delete_department($id)
    {
        if ($this->masters_service->delete_department($id)) {
            $this->session->set_flashdata('success', 'Department deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Cannot delete department assigned to employees');
        }
        redirect('employee/masters/departments');
    }

    

    // Designation methods
    public function designations()
    {
        $search = $this->input->get('search', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'id';
        $order = $this->input->get('order', TRUE) ?: 'asc';

        $data['designations'] = $this->masters_service->get_all_designations($search, $sort, $order);
        $data['title'] = 'Designations Management';
        $data['sort'] = $sort;
        $data['order'] = $order;
        $data['search'] = $search;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/designations', $data);
        $this->load->view('layouts/footer');
    }
    

    public function create_designation()
    {
        $data['title'] = 'Create Designation';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/create_designation', $data);
        $this->load->view('layouts/footer');
    }

    public function store_designation()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[designations.name]');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create_designation();
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            if ($this->masters_service->create_designation($data)) {
                $this->session->set_flashdata('success', 'Designation created successfully');
                redirect('employee/masters/designations');
            } else {
                $this->session->set_flashdata('error', 'Failed to create designation');
                $this->create_designation();
            }
        }
    }

    public function edit_designation($id)
    {
        $data['designation'] = $this->masters_service->get_designation($id);
        if (!$data['designation']) {
            show_404();
        }
        $data['title'] = 'Edit Designation';
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/edit_designation', $data);
        $this->load->view('layouts/footer');
    }

    public function update_designation($id)
    {
        // $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_designation_name[' . $id . ']');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_designation($id);
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            if ($this->masters_service->update_designation($id, $data)) {
                $this->session->set_flashdata('success', 'Designation updated successfully');
                redirect('employee/masters/designations');
            } else {
                $this->session->set_flashdata('error', 'Failed to update designation');
                $this->edit_designation($id);
            }
        }
    }

    public function delete_designation($id)
    {
        if ($this->masters_service->delete_designation($id)) {
            $this->session->set_flashdata('success', 'Designation deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Cannot delete designation assigned to employees');
        }
        redirect('employee/masters/designations');
    }

    // Callback methods
    public function check_department_name($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('departments');
        return $query->num_rows() == 0;
    }

    public function check_designation_name($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('designations');
        return $query->num_rows() == 0;
    }
}