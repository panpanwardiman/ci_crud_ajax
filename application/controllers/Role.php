<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_role');
    }

    public function index()
    {
        $data['roles'] = $this->m_role->get_all();
        $this->load->view('role_list', $data);
    }

    public function create()
    {
        $this->load->view('role_create');
    }

    public function store()
    {
        $this->form_validation->set_rules($this->m_role->rules);
        
        if ($this->form_validation->run()) {
            $data['role'] = $this->input->post('role');
            $data['created_at'] = time();

            $this->m_role->save($data);
            redirect('/');
        } else {
            $this->create();
        }
    }

    public function edit($id)
    {
        $data['role'] = $this->m_role->role_by_id($id);
        $this->load->view('role_edit', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules($this->m_role->rules);
        
        if ($this->form_validation->run()) {
            $data['role'] = $this->input->post('role');
            
            $this->m_role->update($id, $data);
            redirect('/');
        } else {
            $this->edit($id);
        }
    }

    public function destroy($id)
    {
        $this->m_role->delete($id);
        redirect('/');
    }
}