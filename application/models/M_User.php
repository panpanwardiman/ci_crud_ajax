<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_User extends CI_Model {

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
            'field' => 'role_id',
            'label' => 'Role',
            'rules' => 'required',
            'errors'=> array(
                'required' => '%s harus diisi.'
            )
        ),
    );

    function __construct() {
        parent::__construct();
    }

    public function get_all($limit, $start)
    {
        return $this->db->select('users.id, users.username as username, roles.role as role')
                        ->from('users')
                        ->join('roles', 'roles.id = users.role_id', 'left')
                        ->limit($limit, $start)
                        ->get()->result();
    }

    public function count_all() {
        return $this->db->get('users')->num_rows();
    }

    public function tandingan($limit, $start) {
        return $this->db->select('users.id, users.username as username, roles.role as role')
                        ->from('users')
                        ->join('roles', 'roles.id = users.role_id', 'left')
                        ->limit($limit, $start)
                        ->get()->result();
    }

    public function save($data)
    {
        $this->db->insert('users', $data);
    }

    public function user_by_id($id)
    {
        return $this->db->get_where('users', array('id' => $id))->row();
    }

    public function update($id, $data) 
    {
        $this->db->where('id', $id)
                 ->update('users', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)
                 ->delete('users');
    }

    public function search($keyword) {
        return $this->db->select('*')
                        ->from('users')
                        ->join('roles', 'roles.id = users.role_id', 'left')
                        ->like('users.username', $keyword)
                        ->or_like('roles.role', $keyword)
                        ->get()->result();
    }
}