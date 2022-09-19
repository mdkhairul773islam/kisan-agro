<?php class Cc_Loan extends Admin_Controller {

     function __construct(){
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title'] = 'Bank';
        $this->data['active'] = 'data-target="cc_loan_menu"';
        $this->data['all_bank'] = $this->action->read('bank');
        $this->data['all_account'] =  $this->action->read('cc_loan');
    }

    public function index(){
        $this->data['confirmation'] = null;
        $this->data['subMenu'] = 'data-target="add-new"';

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function loan_trx() {
        $this->data['confirmation'] = null;
        $this->data['subMenu'] = 'data-target="loan_trx"';
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/add_trx', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    // view all data
    public function view_all() {
        $this->data['subMenu'] = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array();
        if ($this->input->post("show")) {
            $where = array();
            foreach ($_POST["search"] as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }

            foreach ($_POST["date"] as $key => $value) {
                if ($value != null && $key == "from") {
                    $where["date >="] = $value;
                }
                if ($value != null && $key == "to") {
                    $where["date <="] = $value;
                }
            }
        }

        $this->data["allInfo"] = $this->action->read("loan", $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/loan/nav', $this->data);
        $this->load->view('components/loan/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    // edit data
    public function edit($id = null){
        $this->data['subMenu'] = 'data-target="all-trnx"';
        $this->data['confirmation'] = null;

        $this->data["row"] = $this->action->read("cc_loan", array("id" => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


  

    // add data
    public function add_cc_info(){
            $data = array(
                "insert_date"     => date('Y-m-d'),
                "name"            => $this->input->post("name"),
                "contact_info"    => $this->input->post("contact_info"),
                "address"         => $this->input->post("address"),
                "loan_rcv_date"   => $this->input->post("loan_rcv_date"),
                "bank_name"       => $this->input->post("bank_name"),
                "acc_no"          => $this->input->post("acc_no"),
                "loan_amount"     => $this->input->post("loan_amount"),
                "percentage"        => $this->input->post("interest")
            );

            $data_trx = array(
                "created_date"     =>  date('Y-m-d'),
                "trx_date"         =>  $_POST['loan_rcv_date'],
                "acc_no"           =>  $_POST["acc_no"],
                "loan_rcv"         =>  $_POST['loan_amount'],
                "percentage"       =>  $_POST['interest'],
               
            );
            $this->action->add("cc_loan_trx", $data_trx);
           
            $msg = array(
                "title" => "success",
                "emit"  => "Data Successfully Saved",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->add("cc_loan", $data), $msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("cc_loan/cc_loan", "refresh");
        }
    

    public function add_trx(){

        $data = array(
            "created_date"     => date('Y-m-d'),
            "trx_date"         => $_POST['trx_date'],
            "acc_no"           => $_POST['acc_no'],
            "percentage"       => $_POST['percentage'],    
        );
              
       if($_POST['trx_type'] == 'Paid'){
             $data["loan_paid"]     = $_POST['loan_paid'];   
             $data["interest_paid"] = $_POST['interest_paid']; 
       }else if($_POST['trx_type'] == 'Charge'){
             $data["loan_charge"]     = $_POST['loan_charge'];   
             $data["interest_paid"] = $_POST['interest_paid']; 
       }else{
            $data["loan_rcv"]      = $_POST['loan_rcv'];
            $data["loan_rcv_type"] = $_POST['loan_rcv_type'];
            $charge_type = '';
           
           if(!empty($_POST['charge_type'])){
               $charge_type = $_POST['charge_type'];
           }
            $data["charge_type"]   = $charge_type; 
       }
        
        $msg = array(
            "title" => "success",
            "emit"  => "Data Successfully Saved",
            "btn"   => true
        );

        $this->data['confirmation'] = message($this->action->add("cc_loan_trx", $data), $msg);
        $this->session->set_flashdata("confirmation", $this->data['confirmation']);
        
        // loan closing part start
        if($_POST['trx_type'] == 'Paid'){
            if($_POST['current_loan_due'] == 0){
                $acc_info = get_result('cc_loan_trx',['acc_no' => $_POST['acc_no']],'','','id','asc');
                if(!empty($acc_info)){
                    foreach($acc_info as $value){
                        if(empty($value->loan_close_date)){
                            $this->action->update('cc_loan_trx',['loan_close_date' => $_POST['trx_date']],['id' =>$value->id]);
                        }
                    }    
                }
            }
        }   
       // loan closing part end 
        
        redirect("cc_loan/cc_loan/loan_trx", "refresh");
    }
    



    // edit data
    public function loan_edit($id = null){
        $this->data['subMenu'] = 'data-target="all-loan"';
        $this->data['confirmation'] =null;
        $this->data['row'] =  get_row('cc_loan',['id' => $id]);
       
        
        if(!empty($_POST['save'])){
              $data = array(
                "name"            => $this->input->post("name"),
                "contact_info"    => $this->input->post("contact_info"),
                "address"         => $this->input->post("address"),
                "bank_name"       => $this->input->post("bank_name"),
                "loan_rcv_date"   => $this->input->post("loan_rcv_date"),
                "loan_amount"     => $this->input->post("loan_amount"),
                "percentage"        => $this->input->post("interest")
            );
           
           if($_POST['trx_data_no']==1){
               $data_trx = array(
                    "trx_date"      => $this->input->post("loan_rcv_date"),
                    "loan_rcv"      => $this->input->post("loan_amount"),
                    "percentage"    => $this->input->post("interest"),
                    "charge_type"    => $this->input->post("charge_type"),
                );
                $this->action->update('cc_loan_trx',$data_trx,['acc_no' => $_POST['acc_no']]);
           }
           
             $msg = array(
                "title" => "success",
                "emit"  => "Data Successfully Changed",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->update('cc_loan',$data,['id' => $_POST['id']]),$msg);
            
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("cc_loan/cc_loan/allloan", "refresh");
        }
        
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function allloan() {
        $this->data['subMenu'] = 'data-target="all-loan"';
        $this->data['confirmation'] =null;
        if($this->input->post('show')){
            $acc_no = $this->input->post('acc_no');
            $this->data['rows'] = $this->action->readOrderBy('cc_loan','acc_no',array('acc_no' =>$acc_no));
        }else{
            $this->data['rows'] = $this->action->readOrderBy('cc_loan','acc_no',array());
        }
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/allloan', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    

    public function alltransaction() {
        $this->data['subMenu'] = 'data-target="all-trnx"';
        $this->data['confirmation'] =null;
        if($this->input->post('show')){
            $this->data['all_trx'] = get_result('cc_loan_trx',['acc_no' => $_POST['acc_no']],'','','id','asc');
           
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/all_transaction', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function all_cc_trx(){
        $this->data['subMenu'] = 'data-target="all_cc_trx"';
        $this->data['confirmation'] =null;
        $where = [];
        if($this->input->post('show')){
            if(!empty($_POST['acc_no'])){
                $where['acc_no'] = $_POST['acc_no'];
            }
            
            if(!empty($_POST['loan_rcv_type'])){
                $where['loan_rcv_type'] = $_POST['loan_rcv_type'];
            }
            
            if(!empty($_POST['charge_type'])){
                $where['charge_type'] = $_POST['charge_type'];
            }
            
            
            foreach($_POST['date'] as $key => $val) {
                if($val != null && $key == 'from') {
                    $where['trx_date >='] = $val;
                }

                if($val != null && $key == 'to') {
                    $where['trx_date <='] = $val;
                }
            }
            $this->data['all_trx'] = get_result('cc_loan_trx',$where,'','','id,trx_date,acc_no','asc');
        }else{
            $this->data['all_trx'] = get_result('cc_loan_trx',$where,'','','id,trx_date,acc_no','asc');
        }
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/all_cc_trx', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function edit_cc_trx($id = null)
    {
        $this->data['subMenu']      = 'data-target="all_cc_trx"';
        $this->data['confirmation'] =null;
        
        $this->data['row'] = $trx_data =  get_row('cc_loan_trx',['id' => $id]);
        
        if(!empty($id)){
            $this->data['row_acc_info'] =  get_row('cc_loan',['acc_no' => $trx_data->acc_no]);
        }
        
        if(!empty($_POST['save'])){
             
           $data_trx = [];
           if(!empty($_POST['trx_type']) && $_POST['trx_type'] =='loan_rcv'){
               
               $charge_type = '';
               
               if(!empty($_POST['charge_type'])){
                   $charge_type = $_POST['charge_type'];
               }
               $data_trx = array(
                    "loan_rcv"      => $this->input->post("loan_rcv"),
                    "percentage"    => $this->input->post("percentage"),
                    "loan_rcv_type" => $_POST['loan_rcv_type'],
                    "charge_type"    => $_POST["charge_type"],
                );
               
           }else if($_POST['trx_type']=='Charge'){
               $data_trx = array(
                    "loan_charge"    => $this->input->post("loan_charge"),
                    "interest_paid"  => $this->input->post("interest_paid"),
                    "percentage"     => $this->input->post("percentage")
                );
           }else{
               $data_trx = array(
                    "loan_paid"      => $this->input->post("loan_paid"),
                    "interest_paid"  => $this->input->post("interest_paid"),
                    "percentage"     => $this->input->post("percentage")
                );
           }
           
             $msg = array(
                "title" => "success",
                "emit"  => "Data Successfully Changed",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->update('cc_loan_trx',$data_trx,['id' => $_POST['id']]),$msg);
            
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("cc_loan/cc_loan/all_cc_trx", "refresh");
        }
        
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cc_loan/nav', $this->data);
        $this->load->view('components/cc_loan/edit_cc_trx', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }



    // delete cc trx data
    public function delete_cc_trx($id = null){
        $this->data['confirmation'] = null;     
    
       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Data Successfully Deleted!',
            'btn'=>true
         );

        
        if(!empty($id)){
             $this->data['confirmation'] = message($this->action->deleteData('cc_loan_trx',array('id'=> $id)),$msg_array);
        }
        
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect("cc_loan/cc_loan/all_cc_trx", "refresh");
    }
    

    public function acc_validation(){
          
        $acc_no = $this->input->post('acc_no');
        $info = $this->action->read('cc_loan',array('acc_no' => $acc_no));
        $row = count($info);
        echo $row;

    }


    // delete data
    public function delete($acc_no = null){
        $this->data['confirmation'] = null;     
    
       $msg_array=array(
            'title'=>'delete',
            'emit'=>'Data Successfully Deleted!',
            'btn'=>true
         );

        
        if(!empty($acc_no)){
             $this->action->deleteData('cc_loan',array('acc_no'=> $acc_no)); 
             $this->data['confirmation']=message($this->action->deleteData('cc_loan_trx',array('acc_no'=> $acc_no)),$msg_array);
        }
        
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('cc_loan/cc_loan/allloan','refresh');
    }
    
}
