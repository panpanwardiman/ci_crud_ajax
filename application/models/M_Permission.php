<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Permission extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function get_all()
    {
        return $this->db->get('permissions')->result();
    }

    public function save($data)
    {
        $this->db->insert('permissions', $data);
    }

    public function permission_by_id($id)
    {
        return $this->db->get_where('permissions', array('id' => $id))->row();
    }

    public function update($id, $data) 
    {
        $this->db->where('id', $id)
                 ->update('permissions', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)
                 ->delete('permissions');
    }
}