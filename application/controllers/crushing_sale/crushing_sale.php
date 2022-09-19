<?php

class Crushing_sale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Raw Sale';
        $this->data['active']       = 'data-target="crushing_sale_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // generate voucher number
        $where = array(
            //'sap_at'    => date('Y-m-d'),
            'status'    => 'sale'
        );
        
        $this->data['voucher_number'] = generate_voucher('saprecords', $where);
        $this->data['last_voucher'] = $this->action->readSingle('saprecords','voucher_no');

        if(isset($_POST['save'])) {
        	$this->data['confirmation'] = $this->create();

			// make a product and quantity string
			$productArray = array();
			foreach ($_POST['product'] as $key => $value) {
				$productArray[] = $value . "(" . $_POST['quantity'][$key] . " Kg)";
			}

			$productStr = implode(', ', $productArray);

            //Sending SMS Start
            $sign = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
            $content = "Thanks for purchasing, your have purchas " . $productStr . " and paid " . $this->input->post("paid") . "Tk in " . $this->input->post("method") . " and your current balance is " . $this->input->post("current_balance") . "Tk " . $sign . "Regards, Director Arab Feed Mills Ltd.";

            $num = $this->input->post("mobile");
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'     => date('Y-m-d'),
                'delivery_time'     => date('H:i:s'),
                'mobile'            => $num,
                'message'           => $content,
                'total_characters'  => strlen($content),
                'total_messages'    => message_length(strlen($content),$message),
                'delivery_report'   => $message
            );

            if($message){
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }
            //Sending SMS End

        	redirect('crushing_sale/viewCrushingSale?vno=' . $this->input->post('voucher_number'), 'refresh');
        }

        $this->data['allProducts'] = $this->getAllProducts();
        $this->data['allClients']  = $this->getAllClients();
        $this->data['allUnit']     = config_item('unit');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/crushing_sale/nav', $this->data);
        $this->load->view('components/crushing_sale/crushing_sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function itemWise() {
        $this->data['meta_title']   = 'Raw Sale';
        $this->data['active']       = 'data-target="crushing_sale_menu"';
        $this->data['subMenu']      = 'data-target="wise"';
        $this->data['confirmation'] = null;
        $this->data['result'] = null;
        
        $where = array( 'type' => "raw" );
        $this->data['raw'] = $this->action->read('materials', $where);
        
        
       if(isset($_POST['show'])){ 
             $where = array();
             $where["product_code"] = $_POST['product_code'];
             $where["status"] ="sale";
             $where["trash"] = 0;
        
             $this->data['result'] = $this->action->read("sapitems", $where);
             
             $cond = array('code'=>$_POST['product_code']); 
             $this->data['finishname'] = $this->action->read('materials', $cond);           
        }
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/crushing_sale/nav', $this->data);
        $this->load->view('components/crushing_sale/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    // all available finish products
    private function getAllProducts(){
        $where = array(
            'type'        => 'raw',
            'quantity >'  => 0
        );

        $products = $this->action->read("stock", $where);

        return $products;
    }
    

    // all clients
    private function getAllClients() {
        $where = array(
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        );

        $result = $this->action->read('crushing_parties', $where);

        return $result;
    }


    private function create() {
        // insert sale record
        foreach ($_POST['product'] as $key => $value) {
            $data = array(
                'sap_at'            => $this->input->post('date'),
                'voucher_no'        => $this->input->post('voucher_number'),
                'product_code'      => $_POST['product_code'][$key],
                'purchase_price'    => $_POST['purchase_price'][$key],
                'sale_price'        => $_POST['sale_price'][$key],
                'quantity'          => $_POST['quantity'][$key],
		        'unit'      	    => "Kg",
                'bag_size'          => $_POST['bagSize'][$key],
                'bags_no'           => $_POST['bags_no'][$key],
                'godown_code'       => $this->data['branch'],
                'status'            => 'sale',
                'sap_type'          => $this->input->post('stype')
            );

            // check the product free or not
            if($_POST['sale_price'][$key] <= 0) {
                $data['remark'] = 'free';
            }else{
                $data['remark'] = 'sale';

            }

            if($this->action->add('sapitems', $data)){
                $this->handelStock($key);
            }
        }

        // insert bill record
        if($this->input->post("previous_sign") == "Receivable") {
            $balance = 0 + $this->input->post('previous_balance');
        } else {
            $balance = 0 - $this->input->post('previous_balance');
        }

        $data = array(
            'sap_at'            => $this->input->post('date'),
            'voucher_no'        => $this->input->post('voucher_number'),
            'party_code'        => $this->input->post('code'),
            'godown_code'       => $this->data['branch'],
            'total_quantity'    => $this->input->post('totalqty'),
            'total_bill'        => $this->input->post('grand_total'),
            'total_discount'    => $this->input->post('discount'),
            'party_balance'     => $balance,
            'paid'              => $this->input->post('paid'),
            'method'            => $this->input->post('method'),
            'remark'            => 'sale',
            'status'            => 'sale',
            'sap_type'          => $this->input->post('stype'),
            'crushing_charge'   => $this->input->post('crushing_charge'),
            'sale_type'         => 'crushing'
        );
        
        $crushing_data = array(
            'date'                  => $this->input->post('date'),
            'voucher_no'            => $this->input->post('voucher_number'),
            'qty1'                  => $this->input->post('qty1'),
            'qty2'                  => $this->input->post('qty2'),
            'qty3'                  => $this->input->post('qty3'),
            'qty4'                  => $this->input->post('qty4'),
            'qty5'                  => $this->input->post('qty5'),
            'rate1'                 => $this->input->post('rate1'),
            'rate1'                 => $this->input->post('rate1'),
            'rate2'                 => $this->input->post('rate2'),
            'rate3'                 => $this->input->post('rate3'),
            'rate4'                 => $this->input->post('rate4'),
            'rate5'                 => $this->input->post('rate5'),
            'crushing_amount1'      => $this->input->post('crushing_amount1'),
            'crushing_amount2'      => $this->input->post('crushing_amount2'),
            'crushing_amount3'      => $this->input->post('crushing_amount3'),
            'crushing_amount4'      => $this->input->post('crushing_amount4'),
            'crushing_amount5'      => $this->input->post('crushing_amount5'),
            'total_crushing_charge' => $this->input->post('crushing_charge'),
        );
        $crushing_status = $this->action->add('crushing_data', $crushing_data);

        if($this->input->post('stype') == "cash"){
            $address = json_encode(array("mobile" => $_POST['mobile_number'], "address" => $_POST['details_address']));
            $data['address'] = $address;
            $data['party_code'] = str_replace(" ","_",$_POST['name']);
        }

        $status = $this->action->add('saprecords', $data);
        $this->handelPartyBalance();
        $this->handelPartyTransaction();
        $this->sapmeta();

        $options = array(
            'title' => 'success',
            'emit'  => 'Product Crushing Sale successfully Completed!',
            'btn'   => true
        );

        return message($status, $options);
    }

    private function handelStock($index) {
        $where = array();

        $where['code']          = $_POST['product_code'][$index];
        $where['unit']  		= "Kg";
        $where['godown']        = $this->data['branch'];
        $where['type']          = 'raw';

        // get the product stock
        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = ($record) ? $record[0]->quantity - $_POST['quantity'][$index] : 0.00;

        $data = array('quantity' => $quantity);
        $this->action->update('stock', $data, $where);
    }

    private function handelPartyTransaction() {
        if($this->input->post('previous_sign') == 'Receivable') {
            $previous_balance = 0 + $this->input->post('previous_balance');
        } else {
            $previous_balance = 0 - $this->input->post('previous_balance');
        }

        if($this->input->post('current_sign') == 'Receivable') {
            $current_balance = 0 + $this->input->post('current_balance');
        } else {
            $current_balance = 0 - $this->input->post('current_balance');
        }

        $data = array(
            'transaction_at'    => $this->input->post('date'),
            'party_code'        => $this->input->post('code'),
            'previous_balance'  => $previous_balance,
            'paid'              => $this->input->post('paid'),
            'current_balance'   => $current_balance,
            'transaction_via'   => $this->input->post('method'),
            'relation'          => 'sales:' . $this->input->post('voucher_number'),
            'remark'            => 'sale',
            'status'             => "receivable"
        );


		$lastInsertedId = $this->action->addAndGetId('crushing_partytransaction', $data);
		$this->partyTransactionMeta($lastInsertedId);

        return true;
    }

    private function handelPartyBalance() {
        $where = array('code' => $this->input->post('code'));

        if($this->input->post('current_sign') == 'Receivable') {
            $balance = 0 + $this->input->post('current_balance');
        } else {
            $balance = 0 - $this->input->post('current_balance');
        }

        $data = array('balance' => $balance);
        $this->action->update('crushing_partybalance', $data, $where);

        return true;
    }

    private function sapmeta() {
    
        if (isset($_POST['meta'])) {
            foreach ($_POST['meta'] as $key => $value) {
                $data = array(
                    'voucher_no'    => $_POST['voucher_number'],
                    'meta_key'      => $key,
                    'meta_value'    => $value
                );
                 $this->action->add('sapmeta', $data);
            }
        }else{}
        $data['meta_key']   = 'sale_by';
        $data['voucher_no'] = $_POST['voucher_number'];
        $data['meta_value'] = $this->data['name'];
        $this->action->add('sapmeta', $data);
    }

	private function partyTransactionMeta($id) {
		foreach ($_POST['meta'] as $key => $value) {
			$data = array(
				'transaction_id' 	=> $id,
				'meta_key' 			=> $key,
				'meta_value' 		=> $value
			);

			$this->action->add('crushing_partytransactionmeta', $data);
		}
	}

}
