<?php

class All_transaction extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['clientList'] = get_result('parties', ['type' => 'client', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
    }

    public function index()
    {
        $this->data['meta_title']   = 'All Transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;


        $where = ['partytransaction.relation' => 'transaction', 'partytransaction.trash' => 0, 'parties.type' => 'client'];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($this->input->post('search') as $key => $value) {
                    $where['partytransaction.'.$key] = $value;
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == "from") {
                            $where["partytransaction.transaction_at >="] = $value;
                        }
                        if ($key == "to") {
                            $where["partytransaction.transaction_at <="] = $value;
                        }
                    }
                }
            }
        } else {
            $where['partytransaction.transaction_at'] = date('Y-m-d');
        }


        $this->data['results'] = get_left_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', $where, ['partytransaction.*', 'parties.name']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/allTransaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function view($id = null)
    {
        $this->data['meta_title']   = 'Voucher';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;

        $this->data['info'] = $info = get_row_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', ['partytransaction.id' => $id, 'partytransaction.trash' => 0], ['partytransaction.*', 'parties.name', 'parties.mobile', 'parties.address']);

        if (empty($this->data['info'])) redirect('client/all_transaction/', 'refresh');
        
        

        // get party balance info
        $previousTranInfo = get_client_balance($info->party_code, $id);
        
        if($info->credit > 0 || $info->remission > 0){
            $amount = $info->credit;
            $transactionType = 'received';
        }else{
            $amount = $info->debit;
            $transactionType = 'payment';
        }

        $this->data['amount'] = $amount;
        $this->data['transactionType'] = $transactionType;
        $this->data['balance'] = $previousTranInfo->balance + $info->debit - ($info->credit + $info->remission);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * delete data
     */
    public function delete($id)
    {
        // update partybalance using code from partytransaction
        $where          = array("id" => $id);
        $transactionRec = $this->action->read('partytransaction', $where);

        $data = array('trash' => 1);

        // update partytransactionmeta table using transaction_id from partytransaction:id
        $where = array('transaction_id' => $transactionRec[0]->id);
        $this->action->update("partytransactionmeta", $data, $where);

        // update partytransaction table using id
        $where = array('id' => $transactionRec[0]->id);
        $this->action->update("partytransaction", $data, $where);

        $msg = array(
            "title" => "Deleted",
            "emit"  => "Transaction Successfully Deleted",
            "btn"   => true
        );

        $this->session->set_flashdata('confirmation', message("danger", $msg));

        redirect('client/all_transaction', 'refresh');
    }


}
