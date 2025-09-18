<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->service('employee/employee_service');
        $this->load->service('employee/masters_service');
        $this->load->service('payroll/payroll_service');

        // Redirect if not logged in
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['total_employees'] = $this->employee_service->count_all_employees();
        $data['total_departments'] = $this->masters_service->count_all_departments();
        $data['total_designations'] = $this->masters_service->count_all_designations();
        // $data['active_payroll_runs'] = $this->payroll_service->count_active_payroll_runs();
        // $data['recent_payroll_runs'] = $this->payroll_service->get_recent_payroll_runs(5); // Limit to 5 recent runs
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard', $data);
        $this->load->view('layouts/footer');
    }
}