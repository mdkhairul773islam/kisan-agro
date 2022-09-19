<?php

class Department extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->data['meta_title'] = 'Employee';
        $this->data['active'] = 'data-target="employee_menu"';
    }
   
  public function index() {
        
        $this->data['subMenu'] = 'data-target="department"';
        $this->data['confirmation'] = null;
        
        $this->data['results'] = get_result('department', ['trash' => 0]);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/department', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function store(){
        
        if(isset($_POST['save'])){
            
            $data = [
                'department' => $this->input->post('department'),
            ];
            
            save_data('department', $data);
                
            $msg = [
                "title"=>"Success",
                "emit"=>"Department add successful",
                "btn"=>true    
            ];

            
            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        
        redirect("employee/department","refresh");
    }
    
    
    public function update(){
        if(isset($_POST['update'])){
            
            $id = $this->input->post('id');
            $oldDepartment = $this->input->post('old_department');
            $department = $this->input->post('department');
            
            $data = [
                'department' => $department
            ];
            
            save_data('department', $data, ['id' => $id]);
            save_data('employee', $data, ['department' => $oldDepartment]);
                
            $msg = [
                "title"=>"Success",
                "emit"=>"Department update successful",
                "btn"=>true    
            ];

            
            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        
        redirect("employee/department","refresh");
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
        
       redirect("employee/department","refresh");
    }
   
}