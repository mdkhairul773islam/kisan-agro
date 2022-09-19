<?php

class Designation extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->data['meta_title'] = 'Employee';
        $this->data['active'] = 'data-target="employee_menu"';
    }
   
  public function index() {
        
        $this->data['subMenu'] = 'data-target="designation"';
        $this->data['confirmation'] = null;
        
        $this->data['results'] = get_result('designations', ['type' => 'employee', 'trash' => 0]);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/designation', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function store(){
        
        if(isset($_POST['save'])){
            
            $data = [
                'type' => 'employee',
                'designation' => $this->input->post('designation'),
            ];
            
            save_data('designations', $data);
                
            $msg = [
                "title"=>"Success",
                "emit"=>"Designation add successful",
                "btn"=>true    
            ];
            
            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        
        redirect("employee/designation","refresh");
    }
    
    
    public function update(){
        if(isset($_POST['update'])){
            
            $id = $this->input->post('id');
            $oldDesignation = $this->input->post('old_designation');
            $designation = $this->input->post('designation');
            
            $data = [
                'designation' => $designation
            ];
            
            save_data('designations', $data, ['id' => $id]);
            save_data('employee', $data, ['designation' => $oldDesignation]);
                
            $msg = [
                "title"=>"Success",
                "emit"=>"Designation update successful",
                "btn"=>true    
            ];
            
            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        
        redirect("employee/designation","refresh");
    }
   
    
     public function delete($id=NULL){ 
        
        if(!empty($id)){
            
            save_data('designations', ['trash' => 1], ['id' => $id]);
       
            $msg = [
                'title' => 'delete',
                'emit'  => 'Designation delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('danger', $msg));
        }
        
        redirect("employee/designation","refresh");
    }
   
}