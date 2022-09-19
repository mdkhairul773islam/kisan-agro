<?php

class BankInfo extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->load->model('retrieve');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->data['allBank'] = $this->action->read('bank');
        $this->form_validation->set_rules('account_number', 'Account Number', 'trim|required|is_unique[bank_account.account_number]');

        if ($this->input->post('add_account')) {
            if ($this->form_validation->run() == false) {
                $msg_array = array(
                    "title" => "Error",
                    "emit"  => validation_errors(),
                    "btn"   => true
                );

                $this->data['confirmation'] = message("warning", $msg_array);
            } else {
                $data = array(
                    "datetime"       => $this->input->post('date'),
                    "bank_name"      => $this->input->post('bank_name'),
                    "branch_name"    => $this->input->post('branch_name'),
                    "routing_number" => $this->input->post('routing_number'),
                    "holder_name"    => $this->input->post('account_holder_name'),
                    "account_number" => $this->input->post('account_number'),
                    "init_balance"   => $this->input->post('previous_balance'),
                    "pre_balance"    => $this->input->post('previous_balance')
                    //"showroom_id"    => $this->data['branch']
                );

                $msg_array = array(
                    "title" => "Success",
                    "emit"  => "New Account Added Successfully",
                    "btn"   => true
                );

                $this->data['confirmation'] = message($this->action->add('bank_account', $data), $msg_array);
            }
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/add_account', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function add_bank()
    {

        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add-bank"';
        $this->data['confirmation'] = null;

        // get all bank
        $this->data['allBank'] = get_result('bank');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/add_bank', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store_bank()
    {
        $id = (!empty($_GET['id']) ? $_GET['id'] : '');

        $data = array(
            'date'      => date('Y-m-d'),
            'bank_name' => $this->input->post('bank_name')
        );


        if (!empty($id)) {
            $msg    = array(
                "title" => "Update",
                "emit"  => "Bank Update Successfully...!",
                "btn"   => true
            );
            $status = 'success';
            save_data('bank', $data, ['id' => $id]);

        } else {

            if (check_exists('bank', ['bank_name' => $_POST['bank_name']])) {
                $msg    = array(
                    "title" => "Warning",
                    "emit"  => "This Bank Name All Ready Exists...!",
                    "btn"   => true
                );
                $status = 'warning';
            } else {
                $msg    = array(
                    "title" => "Success",
                    "emit"  => "Bank Added Successfully",
                    "btn"   => true
                );
                $status = 'success';
                save_data('bank', $data);
            }
        }


        $this->data['confirmation'] = message($status, $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('bank/bankInfo/add_bank', 'refresh');
    }

    public function delete_back($id = null)
    {
        unset($msg);

        $info = get_row('bank', ['id' => $id]);

        if (!empty($info)) {
            // delete bank account
            if (check_exists('bank_account', ['bank_name' => $info->bank_name])) {
                delete_data('bank_account', ['bank_name' => $info->bank_name]);
            }

            // delete bank transaction
            if (check_exists('transaction', ['bank' => $info->bank_name])) {
                delete_data('transaction', ['bank' => $info->bank_name]);
            }

            // delete bank name
            delete_data('bank', ['id' => $id]);

            $msg = array(
                "title" => "Success",
                "emit"  => "Bank Delete Successfully",
                "btn"   => true
            );
        }

        $this->data['confirmation'] = message('success', $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('bank/bankInfo/add_bank', 'refresh');
    }

    public function all_account()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all-acc"';
        $this->data['confirmation'] = null;

        // get all account
        $this->data['all_account'] = get_result('bank_account');


        // delete bank account
        if (!empty($_GET['id'])) {

            // get account info
            $info = get_row('bank_account', ['id' => $_GET['id']]);

            // delete bank transaction
            if (!empty($info)){
                $where = ['bank' => $info->bank_name, 'account_number' => $info->account_number];
                if (check_exists('transaction', $where)) {
                    delete_data('transaction', $where);
                }
            }

            delete_data('bank_account', ['id' => $_GET['id']]);

            $msg = array(
                "title" => "Success",
                "emit"  => "Bank Delete Successfully",
                "btn"   => true
            );

            $this->data['confirmation'] = message('success', $msg);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('bank/bankInfo/all_account', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/all_account', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function editAccount()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all-acc"';
        $this->data['confirmation'] = null;

        $where = array('id' => $this->input->get('id'));

        if ($this->input->post('edit_account')) {

            $data = array(
                "datetime"       => $this->input->post('date'),
                "bank_name"      => $this->input->post('bank_name'),
                "holder_name"    => $this->input->post('account_holder_name'),
                "branch_name"    => $this->input->post('branch_name'),
                "routing_number" => $this->input->post('routing_number'),
                "account_number" => $this->input->post('account_number'),
                "pre_balance"    => $this->input->post('previous_balance')
                //"showroom_id"=>$this->data['branch']
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Account Updated Successfully",
                "btn"   => true
            );

            $this->data['confirmation'] = message($this->action->update('bank_account', $data, $where), $msg_array);
        }


        $this->data['all_account'] = $this->action->read('bank_account', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/editAccount', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function transaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        $this->data["bank_list"] = $this->action->read_distinct("bank_account", array(), "bank_name");

        if ($this->input->post('add_transaction')) {


            $data = array(
                'transaction_date' => $this->input->post('date'),
                'bank'             => $this->input->post('bank_name'),
                'account_number'   => $this->input->post('account_number'),
                'transaction_type' => $this->input->post('transaction_type'),
                'amount'           => $this->input->post('amount'),
                'transaction_by'   => $this->input->post('transaction_by'),
                'remarks'          => $this->input->post('remarks')
                //'showroom_id'        => $this->data['branch']
            );

            $msg_array                  = array(
                "title" => "Success",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add("transaction", $data), $msg_array);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/add_transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function searchViewTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="search"';
        $this->data['confirmation'] = $this->data['bank_record'] = null;

        if (isset($_POST['custom_show'])) {
            $where = array();
            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where[$key] = $val;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['transaction_date >'] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['transaction_date <'] = $val;
                }
            }

            $this->data['bank_record'] = $this->action->read('transaction', $where);
        }

        $where = array();

        $this->data["bank_list"] = $this->action->read_distinct("bank_account", $where, "bank_name");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/searchViewTransaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function allTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get all bank
        $this->data['allBank'] = $this->action->read_distinct("bank_account", array(), 'bank_name');

        // after submit
        $where = [];
        if (isset($_POST["show"])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where[$key] = $value;
                    }
                }
            }
        } else {
            $where['transaction_date'] = date('Y-m-d');
        }

        $this->data["resultset"] = get_result('transaction', $where);


        // Delete Data Start
        if ($this->input->get("id")) {    // Deleting Message
            $this->action->deletedata('transaction', array('id' => $this->input->get("id")));
            redirect('bank/bankInfo/allTransaction?d_success=1', 'refresh');
        }

        if ($this->input->get("d_success") == 1) {
            $msg_array                  = array(
                "title" => "Deleted",
                "emit"  => "Transaction Successfully Deleted",
                "btn"   => true
            );
            $this->data['confirmation'] = message("danger", $msg_array);
        }
        //---------------------Delete Data End--------------------------------

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/allTransaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function ledger()
    {
        $this->data['meta_title']   = 'Bank Ledger';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="ledger"';
        $this->data['confirmation'] = $this->data['from_date'] = null;

        // get all bank
        $this->data['allBank'] = $this->action->read_distinct("bank_account", array(), 'bank_name');


        // before submit
        $this->data['resultset'] = $this->getRecord();

        // after submit
        if (isset($_POST["show"])) {

            // get from db
            $this->data["resultset"] = $this->getAllTransaction();

            // Previous Balance
            $this->data['previous_transaction'] = $this->getAllRecords();

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where[$key] = $value;
                    }
                }

                foreach ($_POST['date'] as $key => $val) {
                    if (!empty($val) && $key == 'from') {
                        $where['transaction_date >='] = $val;
                        $this->data['from_date']      = $val;
                    }

                    if (!empty($val) && $key == 'to') {
                        $where['transaction_date <='] = $val;
                        $this->data['from_to']        = $val;
                    }
                }
            }
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/ledger', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function getRecord()
    {
        $data = [];

        $allAccount = $this->action->read("bank_account");
        if (!empty($allAccount)) {
            foreach ($allAccount as $key => $row) {
                $data[$key]["bank"]    = str_replace("_", " ", $row->bank_name);
                $data[$key]["holder"]  = $row->holder_name;
                $data[$key]["account"] = $row->account_number;
                $data[$key]["initial"] = $row->init_balance;
                $data[$key]["debit"]   = 0.00;
                $data[$key]["credit"]  = 0.00;

                $where        = array("account_number" => $row->account_number);
                $transactions = $this->action->read("transaction", $where);

                if ($transactions != null) {
                    foreach ($transactions as $transaction) {
                        if ($transaction->transaction_type == "Debit") {
                            $data[$key]["debit"] += $transaction->amount;
                        }

                        if ($transaction->transaction_type == "bank_to_TT") {
                            $data[$key]["debit"] += $transaction->amount;
                        }

                        if ($transaction->transaction_type == "Credit") {
                            $data[$key]["credit"] += $transaction->amount;
                        }
                    }
                }
            }
        }
        return $data;
    }

    private function getAllTransaction()
    {
        $where = array();

        if ($this->input->post("search") != null) {
            foreach ($this->input->post("search") as $key => $value) {
                if (!empty($value)) {
                    $where[$key] = $value;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if (!empty($val) && $key == 'from') {
                    $where['transaction_date >='] = $val;
                }

                if (!empty($val) && $key == 'to') {
                    $where['transaction_date <='] = $val;
                }
            }
        }


        return $this->action->read("transaction", $where);
    }


    private function getAllRecords()
    {
        $where = array();

        if ($this->input->post("search") != null) {
            foreach ($this->input->post("search") as $key => $value) {
                if ($value != null) {
                    $where[$key] = $value;
                }
            }
        }


        return $this->action->read("transaction", $where);
    }


    public function changeTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        $where                   = array("id" => $this->input->get('id'));
        $this->data["records"]   = $this->action->read("transaction", $where);
        $this->data["bank_list"] = $this->action->read_distinct("bank_account", array(), "bank_name");

        if (isset($_POST['edit'])) {
            $data = array(
                'transaction_date' => $this->input->post('date'),
                'bank'             => $this->input->post('bank_name'),
                'account_number'   => $this->input->post('account_number'),
                'transaction_type' => $this->input->post('transaction_type'),
                'amount'           => $this->input->post('amount'),
                'transaction_by'   => $this->input->post('transaction_by'),
                'remarks'          => $this->input->post('remarks')
                //'showroom_id'        => $this->data['branch']
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            );

            $this->session->set_flashdata('confirmation', message($this->action->update("transaction", $data, $where), $msg_array));

            redirect('bank/bankInfo/changeTransaction?id=' . $this->input->get('id'), 'refresh');

        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/change-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function editTransaction()
    {
        $this->data['meta_title']   = 'Bank';
        $this->data['active']       = 'data-target="bank_menu"';
        $this->data['subMenu']      = 'data-target=""';
        $this->data['confirmation'] = null;

        $this->data["bank_list"] = $this->action->read_distinct("bank_account", array(), "bank_name");

        $where = array("id" => $this->input->get("id"));

        if ($this->input->post('add_transaction')) {
            $data = array(
                'transaction_date' => $this->input->post('date'),
                'bank'             => $this->input->post('bank_name'),
                'account_number'   => $this->input->post('account_number'),
                'transaction_type' => $this->input->post('transaction_type'),
                'amount'           => $this->input->post('amount'),
                'transaction_by'   => $this->input->post('transaction_by')
                //'showroom_id'=>$this->data['branch']
            );

            $msg_array                  = array(
                "title" => "Success",
                "emit"  => "Transaction Added Successfully",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update("transaction", $data, $where), $msg_array);
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/bank/bank-nav', $this->data);
        $this->load->view('components/bank/edit-transaction', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function ajax_account_list()
    {
        $where    = array("bank_name" => $this->input->post('bankName'));
        $alldata  = $this->action->read('bank_account', $where);
        $alldatas = json_encode($alldata);
        echo $alldatas;
    }

    public function ajax_account_number()
    {
        $where    = array("account_number" => $this->input->post('account_number'));
        $alldata  = $this->action->read('bank_account', $where);
        $alldatas = json_encode($alldata);
        echo $alldatas;
    }


}
