<?php
class Sr extends Admin_Controller {

     function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title']   = 'sr';
        $this->data['active']       = 'data-target="sr_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/sr/nav', $this->data);
        $this->load->view('components/sr/add', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }

    public function addsr() {  
        $this->data['confirmation'] = null;     

        $data = $_POST;

        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Sr Successfully Saved!',
            'btn'   => true
        );

        /*if(!$this->action->exists('sr', array('name' => $this->input->post('name')))){
            $this->data['confirmation'] = message($this->action->add('sr',$data),$msg_array);
        } else{
            $this->data['confirmation'] = message('warning',$options);
        }*/
        
         $this->data['confirmation'] = message($this->action->add('sr',$data),$msg_array);

        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('sr/sr','refresh');
    }


    public function allsr() {
        $this->data['meta_title']   = 'sr';
        $this->data['active']       = 'data-target="sr_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;  
      
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sr/nav', $this->data);
        $this->load->view('components/sr/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    
    public function editsr($id = NULL) {       
        $this->data['active'] = 'data-target="sr_menu"';
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['sr'] = null;

        $this->data['id'] = $id;
        $this->data['sr'] = $this->action->read("sr", array('id' => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sr/nav', $this->data);
        $this->load->view('components/sr/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function edit($id=NULL) {  
        $this->data['confirmation'] = null;
        
        $options = array(
            'title' => 'update',
            'emit'  => 'Sr Successfully Updated!',
            'btn'   => true
        );

        $status = $this->action->update('sr', $_POST, array('id' => $id));
        $this->data['confirmation'] = message($status, $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        
        redirect('sr/sr/allsr','refresh');
    }


   public function deletesr($id=NULL) {  
        $this->data['confirmation'] = null;     

        $msg_array=array(
            'title' => 'delete',
            'emit'  => 'Sr Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation']=message($this->action->update('sr', ['trash'=>1],array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('sr/sr/allsr','refresh');
    }
    
    public function deletecomission($id=NULL) {  
        $this->data['confirmation'] = null;     

        $msg_array=array(
            'title' => 'delete',
            'emit'  => 'Successfully Deleted!',
            'btn'   => true
        );

        $this->data['confirmation']=message($this->action->deleteData('sr_comission',array('id'=>$id)),$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('sr/sr/all_comission','refresh');
    }
    
    
    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
    
    
    public function add_comission() {       
        $this->data['active']  = 'data-target="sr_menu"';
        $this->data['subMenu'] = 'data-target="add_comission"';
        $this->data['sr']     = "";
        
        $this->data['sr'] = $this->action->read("sr", array('trash'=> 0));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sr/nav', $this->data);
        $this->load->view('components/sr/add_comission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    
    public function addComission() {  
        $this->data['confirmation'] = null;     

        $data = array(
            'date'          => $this->input->post('date'),
            'sr_id'         => $this->input->post('sr_id'),
            'amount'        => $this->input->post('amount')
        );
        
        $msg_array = array(
            'title' => 'success',
            'emit'  => 'sr Comission Successfully Saved!',
            'btn'   => true
        );
        
        $msg_warning = array(
            'title' => 'Warning',
            'emit'  => 'sr Comission Already Existed!',
            'btn'   => true
        );
        
        $this->data['confirmation'] = message($this->action->add('sr_comission', $data), $msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('sr/sr/add_comission','refresh');
    }
    
    
    public function edit_comission($id=NULL) {  
        $this->data['confirmation'] = null;     

        if(isset($_POST['update'])){
            
            $data = array(
                'date'              => $this->input->post('date'),
                'amount'            => $this->input->post('amount')
            );
            
            $msg_array = array(
                'title' => 'success',
                'emit'  => 'sr Comission Successfully Updated!',
                'btn'   => true
            );
    
            $status = $this->action->update('sr_comission', $data, array('id' => $id));
            
            $this->data['confirmation'] = message($status, $msg_array);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('sr/sr/all_comission','refresh');
            
        }

    }
    
    public function all_comission() {       
        $this->data['active']       = 'data-target="sr_menu"';
        $this->data['subMenu']      = 'data-target="all_comission"';
        $this->data['sr_comission'] = NULL;
        
        $where = array();
        if(isset($_POST['show'])){

            if(isset($_POST['date'])){
                foreach($_POST['date'] as $key => $val) {
                    if($val != null && $key == 'from') {
                        $where['sr_comission.date >='] = $val;
                    }
    
                    if($val != null && $key == 'to') {
                        $where['sr_comission.date <='] = $val;
                    }
                }
            }
        }
        
        $tbleFrom = "sr";
        $tbleTo   = "sr_comission";
        $joinCond = "sr.id=sr_comission.sr_id";
        
        
        
        $this->data['sr_comission'] = get_join($tbleFrom, $tbleTo, $joinCond, $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sr/nav', $this->data);
        $this->load->view('components/sr/all_comission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    public function edit_comission_show($id=null) {       
        $this->data['active'] = 'data-target="sr_menu"';
        $this->data['subMenu'] = 'data-target="all_comission"';
        
        $tbleFrom = "sr";
        $tbleTo   = "sr_comission";
        $joinCond = "sr.id=sr_comission.sr_id";
        $select = ['sr.name', 'sr.mobile', 'sr.adress', 'sr_comission.id', 'sr_comission.date', 'sr_comission.amount'];
        
        $this->data['sr_comission'] = get_row_join($tbleFrom, $tbleTo, $joinCond, ["sr_comission.id"=>$id]);
        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sr/nav', $this->data);
        $this->load->view('components/sr/edit_comission', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

}
