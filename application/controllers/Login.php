<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	Easy Inventory
 *	http://www.codeslab.net
 *  version: 1.0
 */

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        if($this->Login_model->loggedin())
        {
            redirect('admin/dashboard');
        }
        $data['title'] = 'User Login';
        $data['subview'] = $this->load->view('login', $data, true);
        $this->load->view('login', $data);

        $dashboard = $this->session->userdata('url');

        $this->Login_model->loggedin() == false || redirect($dashboard);


    }

    public function signin()
    {
        $this->form_validation->set_rules('user_name', 'username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run()) {
            // We can login and redirect
            if ($this->Login_model->login() == true) {
                $dashboard = $this->session->userdata('url');

                redirect($dashboard);
            } else {
                $this->session->set_flashdata('error', 'That Username/password combination does not exist');
                redirect('login','refresh');
            }
        }
        else
        {
            echo 'rules salah';
        }
    }

    public function logout()
    {
        $this->Login_model->logout();
        redirect('login');
    }

}
