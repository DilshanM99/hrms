<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->service('auth/auth_service');
        $this->load->library('session');
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('auth/login', $data);
    }

    public function login_post()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->auth_service->login($username, $password);

            if ($user) {
                $this->session->set_userdata(array(
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ));
                $this->session->sess_regenerate(TRUE);
                $this->session->set_flashdata('success', 'Login successful');
                redirect('auth');
            } else {
                $this->session->set_flashdata('error', 'Invalid credentials');
                $this->index();
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function forgot_password()
    {
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('auth/forgot_password', $data);
    }

    public function forgot_password_post()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->forgot_password();
        } else {
            $email = $this->input->post('email');
            $token = $this->auth_service->forgot_password($email);

            if ($token) {
                $this->session->set_flashdata('success', 'Password reset token generated: ' . $token);
                redirect('auth/forgot_password');
            } else {
                $this->session->set_flashdata('error', 'Email not found');
                $this->forgot_password();
            }
        }
    }

    public function reset($token = NULL)
    {
        if (!$token) {
            $this->session->set_flashdata('error', 'Invalid reset token');
            redirect('auth/forgot_password');
        }
        $data['token'] = $token;
        $data['csrf'] = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('auth/reset_password', $data);
    }

    public function reset_post()
    {
        $this->form_validation->set_rules('token', 'Token', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->reset($this->input->post('token'));
        } else {
            $token = $this->input->post('token');
            $password = $this->input->post('password');

            if ($this->auth_service->reset_password($token, $password)) {
                $this->session->set_flashdata('success', 'Password reset successful');
                redirect('auth');
            } else {
                $this->session->set_flashdata('error', 'Invalid or expired token');
                $this->reset($token);
            }
        }
    }
}