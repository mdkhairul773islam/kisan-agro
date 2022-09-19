<?php

class Users extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->data['meta_title'] = 'Login';
    }

    public function login() {

        if($this->membership_m->loggedin() == TRUE){
            redirect($this->session->userdata('privilege') . '/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|xss_clean');

        if($this->form_validation->run() == TRUE) {
            if($this->membership_m->login() == TRUE) {
                redirect($this->session->userdata('privilege') . '/dashboard');
            } else {
                $messArr = array(
                    "title" => "login warning",
                    "icon" => "home",
                    "emit" => "Wrong Username or Password!",
                    "btn" => false
                );
                $this->session->set_flashdata('error', message('warning-login', $messArr));

                redirect('access/users/login', 'refresh');
            }
        }

        $this->load->view('access/login', $this->data);
    }

    public function directAccess($id) {
    	if($this->membership_m->directLogin($id) == TRUE) {
            redirect($this->session->userdata('privilege') . '/dashboard');
        }
    }

    public function logout(){
        $this->membership_m->logout();
        redirect('access/users/login');
    }


}
