<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user_by_username($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('users')->row_array();
    }

    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('users')->row_array();
    }

    public function update_reset_token($email, $token)
    {
        $this->db->where('email', $email);
        return $this->db->update('users', ['reset_token' => $token]);
    }

    public function update_password($email, $password)
    {
        $this->db->where('email', $email);
        return $this->db->update('users', ['password' => password_hash($password, PASSWORD_DEFAULT), 'reset_token' => NULL]);
    }

    public function get_user_by_token($token)
    {
        $this->db->where('reset_token', $token);
        return $this->db->get('users')->row_array();
    }
}