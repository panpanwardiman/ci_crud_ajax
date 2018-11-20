<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_user');
        $this->load->model('m_role');

        $is_logged = $this->session->userdata('is_logged');
        if (isset($is_logged) && $is_logged === TRUE) {
            return TRUE;
        } else {
            redirect(site_url('auth'));
        }
    }

    public function index()
    {
        $data['content'] = 'user/index';
        $data['roles'] = $this->m_role->get_all();
        // $this->load->library('pagination');
        // $config['base_url'] = site_url('user/index');
        // $config['total_rows'] = $this->m_user->count_all();
        // $config['per_page'] = 2;
        // $config['uri_segment'] = 3;
        // $choice = $config["total_rows"] / $config["per_page"];
        // $config["num_links"] = floor($choice);

        // $this->pagination->initialize($config);
        // $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        // $data['users'] = $this->m_user->tandingan($config["per_page"], $data['page']);
        $this->load->view('index', $data);
    }

    public function pagination($page)
    {
        $this->load->library('pagination');
        
        $config['base_url'] = site_url('user/pagination');
        $config['total_rows'] = $this->m_user->count_all();
        $config['uri_segment'] = 3;
        $config['per_page'] = 5;
        $config['use_page_numbers'] = true;
        $config['display_pages'] = FALSE;
        $config['prev_link'] = 'Prev';
        $config['next_link'] = 'Next';

        $this->pagination->initialize($config);
        if ($page != 0):
            $page = ($page - 1) * $config["per_page"];
        endif;

        $output = array(
            'total_rows' => $config['total_rows'],
            'paging' => $this->pagination->create_links(),
            'user_table' => $this->m_user->get_all($config['per_page'], $page),
            'start' => $page
        );

        echo json_encode($output);
    }

    public function store()
    {
        $this->form_validation->set_rules($this->m_user->rules);
        $config = array(
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required',
                'errors'=> array(
                    'required' => '%s harus diisi.'
                )
            ),
            array(
                'field' => 'password_confirm',
                'label' => 'Password Confirmation',
                'rules' => 'required|matches[password]',
                'errors'=> array(
                    'required' => '%s harus diisi.',
                    'matches' => '%s tidak sama dengan password'
                )
            )
        );
        $this->form_validation->set_rules($config);
        
        if ($this->form_validation->run()) {
            $data['username'] = $this->input->post('username');
            $data['role_id'] = $this->input->post('role_id');
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data['created_at'] = time();

            $query = $this->m_user->save($data);
            // redirect('/');
            echo json_encode($query);
        } else {
            $this->create();
        }
    }

    public function edit($id)
    {
        $data['content'] = 'user/edit';
        $data['user'] = $this->m_user->user_by_id($id);
        $this->load->view('index', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules($this->m_user->rules);
        
        if ($this->form_validation->run()) {
            $data['username'] = $this->input->post('username');
            $data['role_id'] = $this->input->post('role_id');

            $this->m_user->update($id, $data);
            redirect('/');
        } else {
            $this->edit($id);
        }
    }

    public function destroy()
    {
        $id = $this->input->post('id');
        $data = $this->m_user->delete($id);
        echo json_encode($data);        
    }

    public function search() {
        $keyword = $this->input->post('keyword');
        $data = $this->m_user->search($keyword);
        echo json_encode($data);
    }
}