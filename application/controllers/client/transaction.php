<?php

class Transaction extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['clientList'] = get_result('parties', ['type' => 'client', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
    }

    /**
     * show create form
     */
    public function index()
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="transaction"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['save'])) {

            $data = [
                'transaction_at'   => $this->input->post('created_at'),
                'party_code'       => $this->input->post('code'),
                'previous_balance' => $this->input->post('previous_balance'),
                'remission'        => $this->input->post('remission'),
                'current_balance'  => $this->input->post('current_balance'),
                'transaction_via'  => $this->input->post('transaction_via'),
                'comment'          => $this->input->post('comment'),
                'relation'         => 'transaction',
                'remark'           => 'transaction',
                'status'           => 'transaction',
            ];
            
            $data['credit'] = $data['debit'] = 0;
            if($_POST['transaction_type'] == 'payment'){
                $data['debit']  = $_POST['payment'];
            }else{
                $data['credit'] = $_POST['payment'];
            }

            $id = save_data('partytransaction', $data, '', true);

            // add transaction meta info
            if ($this->input->post('payment_type') == 'cheque') {
                foreach ($_POST['meta'] as $key => $value) {

                    $data = [
                        'transaction_id' => $id,
                        'meta_key'       => $key,
                        'meta_value'     => $value
                    ];

                    save_data('partytransactionmeta', $data);
                }
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Client Transaction Successfully Saved!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect('client/all_transaction/view/' . $id, 'refresh');
        }
    }

    /**
     * show edit form
     */
    public function edit($id = null)
    {
        $this->data['meta_title']   = 'Transaction';
        $this->data['active']       = 'data-target="client_payment_menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = null;

        $this->data['info'] = $info = get_row_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', ['partytransaction.id' => $id, 'partytransaction.trash' => 0], ['partytransaction.*', 'parties.name', 'parties.mobile', 'parties.address']);
        
        if (empty($this->data['info'])) redirect('client/all_transaction/', 'refresh');
        
        if($info->credit > 0 || $info->remission > 0){
            $amount = $info->credit;
            $transactionType = 'received';
        }else{
            $amount = $info->debit;
            $transactionType = 'payment';
        }

        $this->data['amount'] = $amount;
        $this->data['transactionType'] = $transactionType;

        // get party balance info
        $this->data['balanceInfo'] = get_client_balance($info->party_code, $id);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/edit-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * update data
     */
    public function update($id = null)
    {
        if (isset($_POST['update']) && !empty($id)) {

            $data = [
                'transaction_at'   => $this->input->post('created_at'),
                'change_at'        => date('Y-m-d'),
                'previous_balance' => $this->input->post('previous_balance'),
                'remission'        => $this->input->post('remission'),
                'current_balance'  => $this->input->post('current_balance'),
                'transaction_via'  => $this->input->post('transaction_via'),
                'comment'          => $this->input->post('comment'),
                'relation'         => 'transaction',
                'remark'           => 'transaction',
                'status'           => 'transaction',
            ];
            
            $data['credit'] = $data['debit'] = 0;
            if($_POST['transaction_type'] == 'payment'){
                $data['debit']  = $_POST['payment'];
            }else{
                $data['credit'] = $_POST['payment'];
            }

            save_data('partytransaction', $data, ['id' => $id]);

            // add transaction meta info
            if ($this->input->post('payment_type') == 'cheque') {
                foreach ($_POST['meta'] as $key => $value) {

                    $data = [
                        'transaction_id' => $id,
                        'meta_key'       => $key,
                        'meta_value'     => $value
                    ];

                    save_data('partytransactionmeta', $data);
                }
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Client Transaction Successfully Saved!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }
        redirect('client/all_transaction/', 'refresh');
    }
}
