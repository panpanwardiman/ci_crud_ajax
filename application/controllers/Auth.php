<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    function __construct() 
    {
        parent::__construct();
        $this->load->model('m_auth');
    }

    public function index()
    {
        $this->load->view('auth/form_login');
    }

    public function login()
    {
        $this->form_validation->set_rules($this->m_auth->rules);

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->m_auth->pass_hash($username);

            if ($user > 0) {
                $hash = $user->password;
                if (password_verify($password, $hash)) {
                    $data = array(
                        'id' => $user->id,
                        'is_logged' => TRUE
                    );
                    $this->session->set_userdata($data);
                    redirect(site_url('user'));
                } else {
                    $this->session->set_flashdata('message', 'Gagal tolol');
                    redirect('auth');
                }
            }
        } else {
            $this->index();
        }
    }

    public function logout()
    {   
        $data = array('id', 'is_logged');
        $this->session->unset_userdata($data);
        redirect('auth');
    }
}