<?php

class Employee extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->data['departmentList'] = get_result('department', ['trash' => 0]);
        $this->data['designationList'] = get_result('designations', ['type' => 'employee', 'trash' => 0]);

        $this->load->library('upload');
    }
   
    public function index() {
        $this->data['meta_title'] = 'Employee';
        $this->data['active'] = 'data-target="employee_menu"';
        $this->data['subMenu'] = 'data-target="add-new"';
        $this->data['confirmation'] = null;
    
       $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|min_length[11]|is_unique[employee.mobile]');

        if ($this->input->post("add_emp")) {         

            if($this->form_validation->run() == FALSE){
                $msg_array=array(
                    "title"=>"Error",
                    "emit"=>validation_errors(),
                    "btn"=>true
                );
                $this->data['confirmation']=message("warning",$msg_array);
            } else{
                
                //Image Upload Start here
                $photo = '';
                if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                    $config['upload_path'] = './public/employee';
                    $config['allowed_types'] = 'png|jpeg|jpg|gif';
                    $config['max_size'] = '4096';
                    $config['max_width'] = '3000';
                    $config['max_height'] = '3000';
                    $config['file_name'] ="employee_".rand(1111,99999)."_".strtotime('now');
                    $config['overwrite']=true;   
                    
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload("attachFile")){
                        $upload_data=$this->upload->data();
                        $photo="public/employee/".$upload_data['file_name'];
                    }
                }

                $data=array(
                    "date"             =>date("Y-m-d"),
                    "name"             =>$this->input->post("full_name"),
                    "joining_date"     =>$this->input->post('joining_date'),                    
                    "father_name"      =>$this->input->post('father_name'),                    
                    "mother_name"      =>$this->input->post('mother_name'),                    
                    "nid_no"           =>$this->input->post('nid_no'),                    
                    "gender"           =>$this->input->post("gender"),
                    "mobile"           =>$this->input->post("mobile_number"),
                    "email"            =>$this->input->post("email"),
                    "present_address"  =>$this->input->post("present_address"),
                    "permanent_address"=>$this->input->post("permanent_address"),
                    "status"           =>$this->input->post("status"),
                    "department"       =>$this->input->post("department"),
                    "designation"      =>$this->input->post("designation"),
                    "type"             =>$this->input->post("type"),
                    "employee_salary"  =>$this->input->post("salary"),
                    "path"             =>$photo
                );
                
                $id = $this->action->addAndGetID("employee",$data);
                $emp_id = date('y').str_pad($id,3,0,STR_PAD_LEFT);
                $this->action->update("employee",array("emp_id" => $emp_id),array("id" => $id));

                $msg_array=array(
                    "title"=>"Success",
                    "emit"=>"Employee Successfully Saved and ID is  ".$emp_id,
                    "btn"=>true
                );

                $this->data['confirmation']=message('success', $msg_array);   

            }
            
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("employee/employee","refresh");
        }
       

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/add-employee', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
   
    public function show_employee() {
        $this->data['meta_title'] = 'All Employee';
        $this->data['active'] = 'data-target="employee_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        $where = ['trash' => 0];
        
        if(isset($_POST['show'])){
            
            if(!empty($_POST['search'])){
                foreach($_POST['search'] as $key => $value){
                    if(!empty($value)){
                        $where[$key] = $value;
                    }
                }
            }
        }

       $this->data['results']= get_result('employee', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/show-employee', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function active_employee() {
        $this->data['meta_title'] = 'All Employee';
        $this->data['active'] = 'data-target="employee_menu"';
        $this->data['subMenu'] = 'data-target="activeAll"';
        $this->data['confirmation'] = null;
        
        
        $where = ['status' => 'active', 'trash'=> 0];
        
        if(isset($_POST['show'])){
            
            if(!empty($_POST['search'])){
                foreach($_POST['search'] as $key => $value){
                    if(!empty($value)){
                        $where[$key] = $value;
                    }
                }
            }
        }

       $this->data['results']= get_result('employee', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/show-employee', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    //----------------------------------------------------------------------------------------------
    //------------------------------------------View Employee end here------------------------------
    //----------------------------------------------------------------------------------------------

    //----------------------------------------------------------------------------------------------
    //------------------------------------------View profile start here-----------------------------
    //----------------------------------------------------------------------------------------------

    public function profile() {
        $this->data['meta_title'] = 'View Employee';
        $this->data['active'] = 'data-target="employee_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;
       
        $this->data['emp_info']= $this->action->read('employee', array('id'=> $this->input->get("id")));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/profile', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    //----------------------------------------------------------------------------------------------
    //------------------------------------------View profile end here-------------------------------
    //----------------------------------------------------------------------------------------------

    public function edit_employee() {
        $this->data['meta_title'] = 'Change Information';
        $this->data['active'] = 'data-target="employee_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

            //-------------------------------------------------------------------------------------------
            //-----------------------------------update employee Start here-------------------------------------
         $where = array("id"=> $this->input->get('id'));
         $this->data['emp_info']= $this->action->read('employee', $where);

         $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|min_length[11]');


        if ($this->input->post("update_emp")) {         

            if($this->form_validation->run() == FALSE){
                $msg_array=array(
                    "title"=>"Error",
                    "emit"=>validation_errors(),
                    "btn"=>true
                );
                $this->data['confirmation']=message("warning",$msg_array);
            } else{
                  $photo=NULL;
                //Image Upload Start here
                if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                    $config['upload_path'] = './public/employee';
                    $config['allowed_types'] = 'png|jpeg|jpg|gif';
                    $config['max_size'] = '4096';
                    $config['max_width'] = '3000'; /* max width of the image file */
                    $config['max_height'] = '3000';
                    $config['file_name'] ="employee_".rand(1111,99999)."_".$this->input->post("emp_id");
                    $config['overwrite']=true;   
                    
                    $this->upload->initialize($config);
                   
                    
                    if ($this->upload->do_upload("attachFile")){
                        $upload_data=$this->upload->data();
                        $photo="public/employee/".$upload_data['file_name'];
                    }

                }
            //Image Upload End here
            
            if($photo != NULL){
                $data=array(
                    "emp_id"            => $this->input->post('emp_id'),
                    "name"              => $this->input->post("full_name"),
                    "joining_date"      => $this->input->post('joining_date'),
                    "father_name"       => $this->input->post('father_name'),                    
                    "mother_name"       => $this->input->post('mother_name'),                    
                    "nid_no"            => $this->input->post('nid_no'),                    
                    "gender"            => $this->input->post("gender"),
                    "mobile"            => $this->input->post("mobile_number"),
                    "email"             => $this->input->post("email"),
                    "present_address"   => $this->input->post("present_address"),
                    "permanent_address" => $this->input->post("permanent_address"),
                    "department"        => $this->input->post("department"),
                    "designation"       => $this->input->post("designation"),
                    "employee_salary"   => $this->input->post("salary"),
                    "status"            => $this->input->post("status"),
                    "type"              => $this->input->post("type"),
                    "path"              => $photo                    
                );

              }else{
                $data=array(
                    "emp_id"            => $this->input->post('emp_id'),
                    "name"              => $this->input->post("full_name"),
                    "joining_date"      => $this->input->post('joining_date'), 
                    "father_name"       => $this->input->post('father_name'),                    
                    "mother_name"       => $this->input->post('mother_name'),                    
                    "nid_no"            => $this->input->post('nid_no'),                   
                    "gender"            => $this->input->post("gender"),
                    "mobile"            => $this->input->post("mobile_number"),
                    "email"             => $this->input->post("email"),
                    "present_address"   => $this->input->post("present_address"),
                    "permanent_address" => $this->input->post("permanent_address"),
                    "department"        => $this->input->post("department"),
                    "designation"       => $this->input->post("designation"),
                    "status"            => $this->input->post("status"),
                    "type"              => $this->input->post("type"),
                    "employee_salary"   => $this->input->post("salary")                    
                      
                  );
             }
              $msg_array=array(
                "title"=>"Success",
                "emit"=>"Employee Successfully Updated!",
                "btn"=>true
                );

                $this->data['confirmation']=message($this->action->update("employee",$data, $where), $msg_array);  
                $this->session->set_flashdata("confirmation", $this->data['confirmation']);
                redirect("employee/employee/show_employee","refresh"); 

            }
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/employee/employee-nav', $this->data);
        $this->load->view('components/employee/edit-employee', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

     public function delete($id=NULL){ 

        $info=$this->action->read('employee',array('id'=>$id));
        /*if($info != NULL){
            unlink($info[0]->path);           
        }  */

        $options= array(
            'title' => 'delete',
            'emit'  => 'Employee Successfully Deleted!',
            'btn'   => true
        );

       //$this->data['confirmation']=message($this->action->deletedata('employee', array('id' => $id)), $options);
       $this->data['confirmation']=message($this->action->update('employee',array('trash'=>'1'),array('id' => $id)), $options);
       $this->session->set_flashdata("confirmation",$this->data['confirmation']);
       redirect("employee/employee/show_employee","refresh");
    }
   
}