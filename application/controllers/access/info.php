<?php

class Info extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->data['meta_title'] = 'Access Info';
        $this->data['active'] = 'data-target="access_info"';
    }

    public function index() 
    {
        $this->data['subMenu'] = 'data-target=""';
        
        $this->data['userList'] = get_result('users');
        
        $where = [];
        if(isset($_POST['show'])){
            
            if(!empty($_POST['user_id'])){
                $where['access_info.user_id'] = $_POST['user_id'];
            }
            
            if(!empty($_POST['dateFrom'])){
                $where['access_info.created >='] = $_POST['dateFrom'];
            }
            
            if(!empty($_POST['dateTo'])){
                $where['access_info.created <='] = $_POST['dateTo'];
            }  
        }else{
            $where['access_info.created'] = date('Y-m-d');
        }
        
        
        
        $select = ['access_info.*', 'users.name'];
        
        $this->data['results'] = get_left_join('access_info', 'users', 'access_info.user_id=users.id', $where, $select);

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('access/info', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }
}
