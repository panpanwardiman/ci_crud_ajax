<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_permission');
    }

    public function index()
    {
        $data['permissions'] = $this->m_permission->get_all();
        $this->load->view('permission_list', $data);
    }

    public function create()
    {
        $this->load->view('permission_create');
    }

    public function store()
    {
        $this->form_validation->set_rules($this->m_permission->rules);
        
        if ($this->form_validation->run()) {
            $data['name'] = $this->input->post('name');
            $data['created_at'] = time();

            $this->m_permission->save($data);
            redirect('/');
        } else {
            $this->create();
        }
    }

    public function edit($id)
    {
        $data['permission'] = $this->m_permission->permission_by_id($id);
        $this->load->view('permission_edit', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules($this->m_permission->rules);
        
        if ($this->form_validation->run()) {
            $data['username'] = $this->input->post('username');
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

            $this->m_permission->update($id, $data);
            redirect('/');
        } else {
            $this->edit($id);
        }
    }

    public function destroy($id)
    {
        $this->m_permission->delete($id);
        redirect('/');
    }
}