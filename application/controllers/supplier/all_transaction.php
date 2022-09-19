<?php

class All_transaction extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'All Transaction';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;

        // Get all parties name
        $where              = array("type" => "supplier", "trash" => 0, "status" => "active");
        $this->data['info'] = get_result('parties', $where, ['code', 'name']);


        // search all transaction
        $where = ["partytransaction.relation" => "transaction", "partytransaction.trash" => 0, "parties.type" => "supplier"];

        if (isset($_POST['show'])) {

            if ($this->input->post('search') != NULL) {
                foreach ($this->input->post('search') as $key => $value) {
                    $where["partytransaction.$key"] = $value;
                }
            }

            if ($this->input->post('date') != NULL) {
                foreach ($_POST['date'] as $key => $value) {
                    if ($value != NULL) {
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
            $where["partytransaction.transaction_at"] = date('Y-m-d');
        }

        $this->data['transactionInfo'] = get_left_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', $where, ['partytransaction.*', 'parties.name']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/allTransaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view($id = null)
    {
        $this->data['meta_title']   = 'Voucher';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = $this->data['transactionInfo'] = null;

        $this->data['info'] = $info = get_row_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', ['partytransaction.id' => $id], ['partytransaction.*', 'parties.name', 'parties.mobile', 'parties.address']);

        $previousBalance = get_supplier_balance($info->party_code, $id);
        
        if($info->debit > 0 || $info->commission > 0){
            $amount = $info->debit;
            $transactionType = 'payment';
        }else{
            $amount = $info->credit;
            $transactionType = 'received';
        }

        $this->data['amount'] = $amount;
        $this->data['transactionType'] = $transactionType;
        
        $this->data['balance'] = $previousBalance->balance + ($info->debit + $info->commission) - $info->credit;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * update table
     *
     * update party-balance using prty-code from partytransaction
     *
     */
    public function delete_transaction($id)
    {

        if (!empty($id)) {

            $data = ['trash' => 1];

            save_data('partytransaction', $data, ["id" => $id]);
            save_data('partytransactionmeta', $data, ["transaction_id" => $id]);

            $msg = [
                "title" => "Deleted",
                "emit"  => "Transaction Successfully Deleted",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message("danger", $msg));
        }

        redirect('supplier/all_transaction', 'refresh');
    }


}
