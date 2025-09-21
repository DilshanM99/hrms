<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Masters extends MX_Controller
{

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
        $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/create_designations', $data);
        $this->load->view('layouts/footer');
    }

    // public function store_designation()
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[designations.name]');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->create_designation();
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'description' => $this->input->post('description')
    //         );
    //         if ($this->masters_service->create_designation($data)) {
    //             $this->session->set_flashdata('success', 'Designation created successfully');
    //             redirect('employee/masters/designations');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to create designation');
    //             $this->create_designation();
    //         }
    //     }
    // }


    // public function store_designation()
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|is_unique[designations.name]');
    //     $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     if ($this->form_validation->run() == FALSE) {
    //         $data['title'] = 'Create Designation';
    //         $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
    //         $data['csrf'] = array(
    //             'name' => $this->security->get_csrf_token_name(),
    //             'hash' => $this->security->get_csrf_hash()
    //         );
    //         $this->load->view('create_designations', $data);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name', TRUE),
    //             'department_id' => $this->input->post('department_id', TRUE),
    //             'description' => $this->input->post('description', TRUE) ?: NULL,
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s')
    //         );

    //         // Verify department_id exists
    //         $this->db->where('id', $data['department_id']);
    //         $department_exists = $this->db->get('departments')->num_rows() > 0;

    //         if (!$department_exists) {
    //             $this->session->set_flashdata('error', 'Selected department does not exist.');
    //             redirect('employee/masters/create_designation');
    //         }

    //         if ($this->masters_service->create_designation($data)) {
    //             $this->session->set_flashdata('success', 'Designation created successfully.');
    //             redirect('employee/masters/designations');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to create designation.');
    //             redirect('employee/masters/create_designation');
    //         }
    //     }
    // }

    public function store_designation($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Create Designation';
            $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $this->load->view('create_designations', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'department_id' => $this->input->post('department_id', TRUE),
                'description' => $this->input->post('description', TRUE) ?: NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            if ($this->masters_service->create_designation($data)) {
                $this->session->set_flashdata('success', 'Designation created successfully.');
                redirect('employee/masters/designations');
            } else {
                $this->session->set_flashdata('error', 'Failed to create designation.');
                redirect('employee/masters/create_designation');
            }
        }
    }

    public function edit_designation($id)
    {
        $data['title'] = 'Edit Designation';
        $data['designation'] = $this->masters_service->get_designation($id);
        if (!$data['designation']) {
            $this->session->set_flashdata('error', 'Designation not found.');
            redirect('employee/masters/designations');
        }
        $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('employee/edit_designation', $data);
        $this->load->view('layouts/footer');
    }

    // public function update_designation($id)
    // {
    //     // $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_designation_name[' . $id . ']');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->edit_designation($id);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name'),
    //             'description' => $this->input->post('description')
    //         );
    //         if ($this->masters_service->update_designation($id, $data)) {
    //             $this->session->set_flashdata('success', 'Designation updated successfully');
    //             redirect('employee/masters/designations');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update designation');
    //             $this->edit_designation($id);
    //         }
    //     }
    // }


    // public function update_designation($id)
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_designation_name[' . $id . ']');
    //     $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     if ($this->form_validation->run() == FALSE) {
    //         $data['title'] = 'Edit Designation';
    //         $data['designation'] = $this->masters_service->get_designation($id);
    //         $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
    //         $data['csrf'] = array(
    //             'name' => $this->security->get_csrf_token_name(),
    //             'hash' => $this->security->get_csrf_hash()
    //         );
    //         $this->load->view('edit_designation', $data);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name', TRUE),
    //             'department_id' => $this->input->post('department_id', TRUE),
    //             'description' => $this->input->post('description', TRUE) ?: NULL,
    //             'updated_at' => date('Y-m-d H:i:s')
    //         );

    //         // Verify department_id exists
    //         $this->db->where('id', $data['department_id']);
    //         $department_exists = $this->db->get('departments')->num_rows() > 0;

    //         if (!$department_exists) {
    //             $this->session->set_flashdata('error', 'Selected department does not exist.');
    //             redirect('employee/masters/edit_designation/' . $id);
    //         }

    //         if ($this->masters_service->update_designation($id, $data)) {
    //             $this->session->set_flashdata('success', 'Designation updated successfully.');
    //             redirect('employee/masters/designations');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update designation.');
    //             redirect('employee/masters/edit_designation/' . $id);
    //         }
    //     }
    // }

    // public function update_designation($id)
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim|callback_check_designation_name[' . $id . ']');
    //     $this->form_validation->set_rules('department_id', 'Department', 'required|integer|callback_check_department_exists');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     if ($this->form_validation->run() === FALSE) {
    //         $data['title'] = 'Edit Designation';
    //         $data['designation'] = $this->masters_service->get_designation($id);
    //         if (!$data['designation']) {
    //             $this->session->set_flashdata('error', 'Designation not found.');
    //             redirect('employee/masters/designations');
    //         }
    //         $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
    //         $data['csrf'] = array(
    //             'name' => $this->security->get_csrf_token_name(),
    //             'hash' => $this->security->get_csrf_hash()
    //         );
    //         $this->load->view('edit_designation', $data);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name', TRUE),
    //             'department_id' => $this->input->post('department_id', TRUE),
    //             'description' => $this->input->post('description', TRUE) ?: NULL,
    //             'updated_at' => date('Y-m-d H:i:s')
    //         );

    //         if ($this->masters_service->update_designation($id, $data)) {
    //             $this->session->set_flashdata('success', 'Designation updated successfully.');
    //             redirect('employee/masters/designations');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update designation.');
    //             redirect('employee/masters/edit_designation/' . $id);
    //         }
    //     }
    // }

    // public function update_designation($id)
    // {
    //     $this->form_validation->set_rules('name', 'Name', 'required|trim');
    //     $this->form_validation->set_rules('department_id', 'Department', 'required');
    //     $this->form_validation->set_rules('description', 'Description', 'trim');

    //     log_message('debug', 'Posted data: ' . print_r($this->input->post(), TRUE));
    //     if ($this->form_validation->run() === FALSE) {
    //         log_message('debug', 'Validation errors: ' . validation_errors());
    //         $data['title'] = 'Edit Designation';
    //         $data['designation'] = $this->masters_service->get_designation($id);
    //         if (!$data['designation']) {
    //             $this->session->set_flashdata('error', 'Designation not found.');
    //             redirect('employee/masters/designations');
    //         }
    //         $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
    //         $data['csrf'] = array(
    //             'name' => $this->security->get_csrf_token_name(),
    //             'hash' => $this->security->get_csrf_hash()
    //         );
    //         $this->load->view('edit_designation', $data);
    //     } else {
    //         $data = array(
    //             'name' => $this->input->post('name', TRUE),
    //             'department_id' => $this->input->post('department_id', TRUE),
    //             'description' => $this->input->post('description', TRUE) ?: NULL,
    //             'updated_at' => date('Y-m-d H:i:s')
    //         );

    //         log_message('debug', 'Update designation data: ' . print_r($data, TRUE));
    //         if ($this->masters_service->update_designation($id, $data)) {
    //             $this->session->set_flashdata('success', 'Designation updated successfully.');
    //             redirect('employee/masters/designations');
    //         } else {
    //             $this->session->set_flashdata('error', 'Failed to update designation.');
    //             redirect('employee/masters/edit_designation/' . $id);
    //         }
    //     }
    // }

    public function update_designation($id)
    {

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('department_id', 'Department', 'required|integer');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        $this->form_validation->set_message(
        'check_designation_name',
        'The designation name already exists. Please choose another one.'
    );
        


        log_message('debug', 'Update designation posted data: ' . print_r($this->input->post(), TRUE));
        if ($this->form_validation->run() === FALSE) {
            log_message('debug', 'Update designation validation errors: ' . validation_errors());
            $data['title'] = 'Edit Designation';
            $data['designation'] = $this->masters_service->get_designation($id);
            if (!$data['designation']) {
                $this->session->set_flashdata('error', 'Designation not found.');
                redirect('employee/masters/designations');
            }
            $data['departments'] = $this->masters_service->get_all_departments_for_dropdown();
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $this->load->view('edit_designation', $data);
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'department_id' => $this->input->post('department_id', TRUE),
                'description' => $this->input->post('description', TRUE) ?: NULL,
                'updated_at' => date('Y-m-d H:i:s')
            );

            log_message('debug', 'Update designation data: ' . print_r($data, TRUE));
            $result = $this->masters_service->update_designation($id, $data);
            if ($result === TRUE) {
                $this->session->set_flashdata('success', 'Designation updated successfully.');
                redirect('employee/masters/designations');
            } else {
                $this->session->set_flashdata('error', $result ?: 'Failed to update designation.');
                redirect('employee/masters/edit_designation/' . $id);
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

    //    public function check_designation_name($name, $id)
//     {
//         $this->db->where('name', $name);
//         $this->db->where('id !=', $id);
//         $query = $this->db->get('designations');
//         if ($query->num_rows() > 0) {
//             $this->form_validation->set_message('check_designation_name', 'The {field} already exists.');
//             return FALSE;
//         }
//         return TRUE;
//     }

    // public function check_designation_name($name, $id)
    // {
    //     log_message('debug', "Checking designation name: {$name} for ID: {$id}");
    //     $this->db->where('name', $name);
    //     $this->db->where('id !=', $id);
    //     $query = $this->db->get('designations');
    //     if ($query->num_rows() > 0) {
    //         $this->form_validation->set_message('check_designation_name', 'The designation name "{field}" already exists.');
    //         return FALSE;
    //     }
    //     return TRUE;
    // }

    public function check_designation_name($name, $id)
    {
        // Call service to check if name exists, excluding current ID
        $exists = $this->masters_service->is_designation_name_exists($name, $id);

        if ($exists) {
            $this->form_validation->set_message(
                'check_designation_name',
                'The designation name "' . $name . '" already exists. Please choose another one.'
            );
            return FALSE;
        }
        return TRUE;
    }

    public function check_department_exists($department_id)
    {
        log_message('debug', "Checking department ID: {$department_id}");
        $this->db->where('id', $department_id);
        $query = $this->db->get('departments');
        if ($query->num_rows() == 0) {
            $this->form_validation->set_message('check_department_exists', 'The selected department does not exist.');
            return FALSE;
        }
        return TRUE;
    }
}