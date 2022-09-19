<?php

class Transaction extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="transaction"';
        $this->data['confirmation'] = null;

        if (isset($_POST['save'])) {

            $data = [
                'transaction_at'   => $this->input->post('created_at'),
                'party_code'       => $this->input->post('code'),
                'previous_balance' => $this->input->post('previous_balance'),
                'commission'       => $this->input->post('commission'),
                'current_balance'  => $this->input->post('current_balance'),
                'transaction_via'  => $this->input->post('transaction_via'),
                'comment'          => $this->input->post('comment'),
                'relation'         => 'transaction',
                'remark'           => 'transaction',
                'status'           => 'transaction'
            ];
            
            if($_POST['transaction_type'] == 'payment'){
                $data['debit'] = $_POST['payment'];
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

            //Sending SMS Start
            $partyInfo = get_row('parties', ['code' => $_POST['code']]);
            $sign      = ($this->input->post("csign") == 'Receivable') ? 'Due' : 'Advanced';
            $balance   = $this->input->post('current_balance');
            $paid      = $this->input->post('payment');

            $content = "Thanks,A transaction is completed. Paid: " . $paid . " Tk, Current Balance: " . $balance . " Tk, ( " . $sign . " ) Regards, Arab Feed Mills Ltd";

            $num     = $partyInfo->mobile;
            $message = send_sms($num, $content);

            $insert = array(
                'delivery_date'    => date('Y-m-d'),
                'delivery_time'    => date('H:i:s'),
                'mobile'           => $num,
                'message'          => $content,
                'total_characters' => strlen($content),
                'total_messages'   => message_length(strlen($content), $message),
                'delivery_report'  => $message
            );

            if ($message) {
                $this->action->add('sms_record', $insert);
                $this->data['confirmation'] = message('success', array());
            } else {
                $this->data['confirmation'] = message('warning', array());
            }

            //Sending SMS End
            $msg = [
                'title' => 'success',
                'emit'  => 'Supplier Transaction Successfully Saved.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect('supplier/all_transaction/view/' . $id, 'refresh');
        }

        // Get all client parties name
        $where = array(
            "type"   => "supplier",
            "status" => "active",
            "trash"  => 0
        );

        $this->data['info'] = $this->action->readGroupBy('parties', 'name', $where, "id", "asc");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function edit_transaction($id = null)
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="all-transaction"';
        $this->data['confirmation'] = null;


        $this->data['info'] = $info = get_row_join('partytransaction', 'parties', 'partytransaction.party_code=parties.code', ['partytransaction.id' => $id], ['partytransaction.*', 'parties.name', 'parties.mobile', 'parties.address']);

        $this->data['balanceInfo'] = get_supplier_balance($info->party_code, $id);
        
        if($info->debit > 0 || $info->commission > 0){
            $amount = $info->debit;
            $transactionType = 'payment';
        }else{
            $amount = $info->credit;
            $transactionType = 'received';
        }

        $this->data['amount'] = $amount;
        $this->data['transactionType'] = $transactionType;


        if (isset($_POST['update']) && !empty($id)) {

            $data = [
                'transaction_at'   => $this->input->post('created_at'),
                'change_at'        => date('Y-m-d'),
                'previous_balance' => $this->input->post('previous_balance'),
                'debit'            => $this->input->post('payment'),
                'commission'       => $this->input->post('commission'),
                'current_balance'  => $this->input->post('current_balance'),
                'transaction_via'  => $this->input->post('transaction_via'),
                'comment'          => $this->input->post('comment'),
                'status'           => $this->input->post('csign')
            ];
            
            $data['credit'] = $data['debit'] = 0;
            if($_POST['transaction_type'] == 'payment'){
                $data['debit']  = $_POST['payment'];
            }else{
                $data['credit'] = $_POST['payment'];
            }

            save_data('partytransaction', $data, ['id' => $id]);


            // update transaction meta info
            if ($this->input->post('payment_type') == 'cheque') {
                foreach ($_POST['meta'] as $key => $value) {

                    $where = [
                        'transaction_id' => $id,
                        'meta_key'       => $key
                    ];

                    $data = [
                        'transaction_id' => $id,
                        'meta_key'       => $key,
                        'meta_value'     => $value,
                    ];

                    save_data('partytransactionmeta', $data, $where);
                }
            }

            $msg = [
                'title' => 'update',
                'emit'  => 'Supplier Transaction update successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));

            redirect('supplier/all_transaction/', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/edit_transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
