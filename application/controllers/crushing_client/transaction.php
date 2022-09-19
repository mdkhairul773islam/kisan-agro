<?php
class Transaction extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="crushing_client_menu"';
        $this->data['subMenu']      = 'data-target="transaction"';
        $this->data['confirmation'] = null;

        if(isset($_POST['save'])) {
            $previous_balance = ($this->input->post('sign') == "Receivable") ? (0 + $this->input->post('balance')) : (0 - $this->input->post('balance'));

            $current_balance = ($this->input->post('csign') == "Receivable") ? (0 + $this->input->post('totalBalance')) : (0 - $this->input->post('totalBalance'));

            $status = ($current_balance >= 0) ? "receivable" : "payable";

            $data = array(
                'transaction_at'     => $this->input->post('created_at'),
                'party_code'         => $this->input->post('code'),
                'previous_balance'   => $previous_balance,
                'paid'               => $this->input->post('payment'),
                'current_balance'    => $current_balance,
                'transaction_via'    => $this->input->post('payment_type'),
                'relation'           => 'transaction',
                'comment'            => $this->input->post('remark'),
                'status'             => "receivable"//$status
            );

            $options = array(
                'title' => 'success',
                'emit'  => 'Crushing Client Transaction Successfully Saved!',
                'btn'   => true
            );

            $tid = $this->action->addAndGetId('crushing_partytransaction', $data);
            $this->partyTransactionMeta($tid);

            $this->calculateBalance($current_balance, $this->input->post('code'));

            $lastId = $this->action->read('crushing_partytransaction',array(),'DESC'); 

            $this->session->set_flashdata('confirmation', message('success', $options));
            redirect('crushing_client/all_transaction/view/' . $lastId[0]->id, 'refresh');
        }

        // get all client
        $this->data['allClient'] = $this->action->read('crushing_parties', array('type' => 'client','trash'=>0));
        $this->data['collect_by'] = $this->action->read('users', array('privilege !=' => 'user'));

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

  
    public function edit($id) {
        $this->data['meta_title']   = 'Transaction';
        $this->data['active']       = 'data-target="client_payment_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = null;

        $where = array('code' => $this->input->get("code"));
        $whereId = array('id' => $this->input->get('id'));

        if($this->input->post("update")){
            $total = 0;
            $csign = $this->input->post("csign");

            if($csign=="Payable"){
                $total= $this->input->post("totalBalance");
            } else if($csign=="Receivable") {
                $total= 0-$this->input->post("totalBalance");
            }
                
            $data = array(
                "paid"             => $this->input->post("payment"),
                "current_balance"  => $total
            );
            
            $data2 = array(
                "balance"  => $total
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Data Successfully Updated",
                "btn"   => true
            );

            $this->data["confirmation"] = message($this->action->update("crushing_partytransaction",$data, $whereId), $msg_array);
            $this->data["confirmation"] = message($this->action->update("crushing_partybalance", $data2, $where), $msg_array);
            
            $this->session->set_flashdata("confirmation",$this->data['confirmation']);
            redirect("crushing_client/all_transaction","refresh"); 
        }
        
        // get all company
        $this->data['allClient'] = $this->action->read('crushing_parties', array('type' => 'client','trash'=>"0"));
        $this->data['collect_by'] = $this->action->read('users', array('privilege !=' => 'user'));
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


	private function partyTransactionMeta($id) {
        if(isset($_POST['meta'])) {
    		foreach ($_POST['meta'] as $key => $value) {
    			$data = array(
                    'transaction_id' => $id,
                    'meta_key'       => $key,
                    'meta_value'     => $value
    			);

    			$this->action->add('crushing_partytransactionmeta', $data);
    		}
        }
        return true;
	}


    private function calculateBalance($balance, $who) {
        $data = array('balance' => $balance);
        $where = array('code' => $who);
        $this->action->update('crushing_partybalance', $data, $where);
    }

}
