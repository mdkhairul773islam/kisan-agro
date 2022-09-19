<?php

class SaleReturnCtrl extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        if(isset($_POST['change'])) {
            $this->session->set_flashdata('confirmation', $this->change());

            // Sending SMS Start
           /* $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Your balance has been updated, your current balance is ".$this->input->post("current_balance")."Tk ".$sign;
            $num = $this->input->post("party_mobile");
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'     => date('Y-m-d'),
                'delivery_time'     => date('H:i:s'),
                'mobile'            => $num,
                'message'           => $content,
                'total_characters'  => strlen($content),
                'total_messages'    => message_length(strlen($content)),
                'delivery_report'   => $message
            );

            if($message){
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }*/
            // Sending SMS End

            redirect("sale/viewSale?vno=". $_POST['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/return-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function change(){
        
        foreach ($_POST['id'] as $key => $value) {
        
            // insert into sale_return table
            $data = array();
            $data2 = array();
            
            $newQuantity = $_POST['old_quantity'][$key] - $_POST['new_quantity'][$key];
           
           if($newQuantity > 0 ){
            $data['voucher_no'] = $_POST['voucher_no'];
            $data['code']       = $_POST['product_code'][$key];
            $data['quantity']   = $newQuantity;
            $data['return_amount'] = $_POST['grand_total'];

            $this->action->add("sale_return",$data);
            }
            // End here
            
            
            // update sapitems table for each product
            //$where = array('voucher_no' => $this->input->post('voucher_no'));
            $where = array('id' => $_POST['id'][$key]);
            $data2['product_code'] = $_POST['product_code'][$key];
            $data2['quantity']     = $_POST['new_quantity'][$key];
          
            if($this->action->update('sapitems', $data2, $where)){
                $this->handelStock($key);
	    }
        }
        
        // update saprecords table
        $data = array(
            'change_at'         => date('Y-m-d'),
            'total_bill'        => $this->input->post('new_grand_total'),
            'total_quantity'    => $this->input->post('totalqty'),
            'method'   		=> $this->input->post('method')
        );

        $where = array('voucher_no' => $this->input->post('voucher_no'));
        $status = $this->action->update('saprecords', $data, $where);
	
        $this->handelPartyBalance();
        $this->handelPartyTransaction();
        //$this->sapmeta();

        $options = array(
            'title' => 'Updated',
            'emit'  => 'Product purchase successfully changed!',
            'btn'   => true
        );

        return message($status, $options);
        
        
    }

    private function handelStock($index) {
        // get stock info
        //foreach ($_POST['id'] as $key => $value) {
	        $where = array();
	        $where['code']    = $_POST['product_code'][$index];
	        $where['godown']  = 1;
	        $where['type']    = 'finish_product';
	
	        $record = $this->action->read('stock', $where);
	        
	        // set the quantity
	        //$newQuantity = $_POST['new_quantity'][$index];
	        $quantity = $record[0]->quantity + ($_POST['old_quantity'][$index] - $_POST['new_quantity'][$index]);
		
	
	        // update the stock
	        $data = array();
	        $data = array('quantity' => $quantity);
	        
	        $this->action->update('stock', $data, $where);
        //}
    }

    private function handelPartyBalance() {
        $where = array('code' => $this->input->post('party_code'));

        if($this->input->post("current_sign") == "Receivable"){
            $balance = $this->input->post('current_balance');
        } else {
            $balance = 0 - $this->input->post('current_balance');
        }

        $data = array('balance' => $balance);
        $this->action->update('partybalance', $data, $where);

        return true;
    }
    

    private function handelPartyTransaction() {
    
       
        if($this->input->post("current_sign") == "Receivable"){
            $balance = $this->input->post('current_balance');
        } else {
            $balance = 0 - $this->input->post('current_balance');
        }
	//$balance = $balance;
        $data = array(
            'current_balance'   => $balance,
            'transaction_via'   => $this->input->post('method')
        );

        $where = array('relation' => 'sales:'.$this->input->post('voucher_no'));
        $this->action->update('partytransaction', $data, $where);

        return true;
    }
    
   
/*
    private function sapmeta() {
        if (isset($_POST['meta'])) {
            $where = array();

            foreach ($_POST['meta'] as $key => $value) {
                $data = array('meta_value' => $value);

                $where['voucher_no'] = $this->input->post('voucher_no');
                $where['meta_key'] = $key;

                $this->action->update('sapmeta', $data, $where);
            }
        }
    }
    
    */

}
