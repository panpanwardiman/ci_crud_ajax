<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Role extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function get_all()
    {
        return $this->db->get('roles')->result();
    }

    public function save($data)
    {
        $this->db->insert('roles', $data);
    }

    public function role_by_id($id)
    {
        return $this->db->get_where('roles', array('id' => $id))->row();
    }

    public function update($id, $data) 
    {
        $this->db->where('id', $id)
                 ->update('roles', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)
                 ->delete('roles');
    }
}