<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Auth extends CI_Model {
    public $rules = array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required',
            'errors'=> array(
                'required' => '%s harus diisi.'
            )
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
            'errors'=> array(
                'required' => '%s harus diisi.'
            )
        ),
    );

    function __construct()
    {
        parent::__construct();
    }

    public function pass_hash($username) 
    {
        return $this->db->select('id, username, password')
                        ->from('users')
                        ->where('username', $username)
                        ->get()->row();
    }
}