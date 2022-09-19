<?php
class Commitment extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
        $this->load->library('upload');
    }
    public function index() {
        $this->data['meta_title']   = 'add';
        $this->data['active']       = 'data-target="commitment_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;
        
        $this->data['allGodowns'] = '';
        
        if(isset($_POST['add'])) {
          
            // input data
            $data = input_data(['party_code', 'commitment', 'date']);
            
            // message
            $msg_array=array(
                'title' => 'success',
                'emit'  => 'Commitment Successfully Saved.',
                'btn'   => true
            );
            
            // add commitments
            $this->data['confirmation'] = message($this->action->add("commitments", $data), $msg_array);
            $this->session->set_flashdata("confirmation", $this->data["confirmation"]);
            redirect("client/commitment","refresh");
        }
        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/commitment_nav', $this->data);
        $this->load->view('components/client/add_commitment', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view_all() {
        $this->data['meta_title'] = 'all';
        $this->data['active']     = 'data-target="commitment_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data["commitments"] = null;
        
        // get all godownl
        $this->data['allGodowns'] = '';

        // search commit
        $where = [];
        if(isset($_POST['show'])){
            
            if(!empty($_POST['search'])){
                foreach($_POST['search'] as $_key => $value){
                    if(!empty($value)){
                        $where["commitments.$_key"] = $value;
                    }
                }
            }
       
            foreach($_POST['date'] as $key => $val){
                if($val != null && $key == 'from'){
                    $where['commitments.date >='] = $val;
                }

                if($val != null && $key == 'to'){
                    $where['commitments.date <='] = $val;
                }
            }

            
        }else{
            $where['commitments.date'] = date('Y-m-d');
        }
        
        $select = ['commitments.*', 'parties.name', 'parties.mobile', 'parties.address', 'parties.initial_balance'];
        $this->data["commitments"] = get_join('commitments', 'parties', 'parties.code=commitments.party_code', $where, $select);
        
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/commitment_nav', $this->data);
        $this->load->view('components/client/commitment', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function view($id)
    {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="commitment_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        
        $where['commitments.id'] = $id;
        $tableFrom = 'commitments';
        $tableTo   = 'parties';
        $joinCond  = 'parties.code=commitments.party_code';
        $select = ['commitments.*', 'parties.name', 'parties.mobile', 'parties.address'];
        
        $this->data['partyInfo'] = get_row_join($tableFrom, $tableTo, $joinCond, $where, $select);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/client/commitment_nav', $this->data);
        $this->load->view('components/client/view_commitment', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function edit($id)
    {
        $this->data['meta_title']   = 'edit';
        $this->data['active']       = 'data-target="commitment_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        // get all godownl
        $this->data['allGodowns'] = '';
        
        // get commitment info
        $this->data['info'] = get_row('commitments', ['id' => $id]);
        
    
       // update data
        if(isset($_POST['edit'])) {
                            
            // input data
            $data = input_data(['party_code', 'commitment', 'date']);
            
            // set message
            $msg_array=array(
                'title' => 'success',
                'emit'  => 'Commitment Successfully Updated.',
                'btn'   => true
            );
            
            // update data
            $this->data['confirmation'] = message($this->action->update("commitments", $data, ['id' => $_POST['id']]), $msg_array);
            $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
            redirect("client/commitment/edit/".$id,"refresh");
        }
        

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/commitment_nav', $this->data);
        $this->load->view('components/client/commitment_edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    public function delete($id)
    {
        $where['id'] = $id;
        $this->action->deleteData('commitments', $where);
        
        $msg_array=array(
            'title' => 'success',
            'emit'  => 'Commitment Successfully deleted.',
            'btn'   => true
        );
        $this->data['confirmation'] = message('success', $msg_array);
        
        $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
        redirect("client/commitment/view_all","refresh");
    }
    
    
     public function hide_commitment()
    {
        $where['id'] = $_GET['id'];
        $this->action->update('commitments',array('commitment_status' => 1),$where);
         redirect($this->data['privilege'].'/dashboard'); 
    }
    
    
    
}
