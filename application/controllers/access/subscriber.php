<?php

class Subscriber extends Subscriber_Controller {

    function __construct() {
        parent::__construct();        
        $this->data['meta_title'] = 'user login';        
       
    }

    
public function login() {  
    if($this->subscriber_m->loggedin() == TRUE){
            redirect('panel/dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|xss_clean');

        if($this->form_validation->run() == TRUE) {
            if($this->subscriber_m->login() == TRUE) {
                redirect('panel/dashboard');
            } else {
                $messArr = array(
                    "title" => "login warning",
                    "icon" => "home",
                    "emit" => "Wrong Username or Password!",
                    "btn" => false
                );
                $this->session->set_flashdata('error', message('warning-login', $messArr));

                redirect('access/subscriber/login', 'refresh');
            }
        }

      $this->load->view('access/user-login', $this->data);
    } 

public function logout(){
        $this->subscriber_m->logout();
        redirect('access/subscriber/login',"refresh");
    }

    
   
}

