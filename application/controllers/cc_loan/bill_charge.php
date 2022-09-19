<?php

class Bill_charge extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
        $this->data['all_account'] =  $this->action->read('cc_loan');
    }

    public function index(){
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="cc_loan_menu"';
        $this->data['subMenu']      = 'data-target="bill-add-new"';
        $this->data['confirmation'] = null;
    
    	if(!empty($_POST['save'])){
    	
        		$data = array(
                    "created_at"        => $this->input->post('trx_date'),
                    "acc_no"            => $this->input->post('acc_no'),
                    "charge_type"       => $this->input->post('charge_type'),
                    "amount"            => $this->input->post('amount'),
        		);

        		$msg_array = array(
                    "title"=>"Success",
                    "emit"=>"Bank Charge Added Successfully",
                    "btn"=>true
                );

                $this->data['confirmation'] = message($this->action->add('bank_charge', $data), $msg_array);
                $this->session->set_flashdata('confirmation',$this->data['confirmation']);
                redirect('cc_loan/bill_charge/all','refresh');
    		
    	}

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/bill_charge', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    
    public function all(){
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="cc_loan_menu"';
        $this->data['subMenu']      = 'data-target="all-charge"';
        $this->data['confirmation'] = null;

        $where = [];
        if(!empty($_POST['show'])){
        
            if(!empty($_POST["search"])){
                foreach($_POST["search"] as $key => $value) {
                    if ($value != null) {
                        $where[$key] = $value;
                    }
                }
            }    

            if(!empty($_POST["date"])){
                foreach ($_POST["date"] as $key => $value) {
                    if ($value != null && $key == "from") {
                        $where["created_at >="] = $value;
                    }
                    if ($value != null && $key == "to") {
                        $where["created_at <="] = $value;
                    }
                }
            }     
        
        }
        $this->data['all_bank_charge'] = get_result('bank_charge',$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/all_bill_charge', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function delete_data($id = null) {
    
        $msg_array=array(
            'title'=>'delete',
            'emit'=>'Data Successfully Deleted!',
            'btn'=>true
         );

        if(!empty($id)){
             $this->data['confirmation'] = message($this->action->deleteData('bank_charge',array('id'=> $id)),$msg_array);
        }
        
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('cc_loan/bill_charge/all','refresh');
    }
    
}
