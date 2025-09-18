<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_service {
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('auth/user_model');
    }

    public function login($username, $password)
    {
        $user = $this->CI->user_model->get_user_by_username($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return FALSE;
    }

    public function forgot_password($email)
    {
        $user = $this->CI->user_model->get_user_by_email($email);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->CI->user_model->update_reset_token($email, $token);
            return $token;
        }
        return FALSE;
    }

    public function reset_password($token, $password)
    {
        $user = $this->CI->user_model->get_user_by_token($token);
        if ($user) {
            return $this->CI->user_model->update_password($user['email'], $password);
        }
        return FALSE;
    }
}