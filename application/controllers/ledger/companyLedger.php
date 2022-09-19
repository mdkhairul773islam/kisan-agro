<?php

class CompanyLedger extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']            = 'Company Ledger';
        $this->data['active']                = 'data-target="ledger"';
        $this->data['subMenu']               = 'data-target="company-ledger"';
        $this->data['width']                 = 'width';


        $this->data['results']     = [];
        $this->data['defaultData'] = [];


        // Get all parties name
        $this->data['partyList'] = get_result('parties', ["type" => "supplier", "trash" => 0], ['code', 'name', 'mobile', 'address']);


        // Get data after submit query Start here
        if (isset($_POST['show']) && !empty($_POST['search']['party_code'])) {

            $partyCode = $_POST['search']['party_code'];

            // get party info
            $this->data['partyInfo'] = $partyInfo = get_row('parties', ['code' => $partyCode]);

            $this->data['balanceInfo'] = get_supplier_balance($partyCode);

            $where = [
                "party_code" => $partyCode,
                "trash"      => 0
            ];

            $this->data['dateFrom'] = $dataFrom = (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '');
            $this->data['dateTo']   = $dataTo = (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '');

            if (!empty($dataFrom)) {

                $previousTran    = custom_query("SELECT party_code, IFNULL(sum(debit + commission), 0) AS debit, IFNULL(SUM(credit), 0) AS credit FROM partytransaction WHERE party_code='$partyInfo->code' AND trash=0 AND transaction_at < '$dataFrom'", true);
                $previousBalance = $previousTran->debit - $previousTran->credit + $partyInfo->initial_balance;

                $where['transaction_at >='] = $dataFrom;
            } else {
                $previousBalance = $partyInfo->initial_balance;
            }

            $this->data['previous_balance'] = $previousBalance;

            if (!empty($dataTo)) {
                $where['transaction_at <='] = $dataTo;
            }

            // get all result
            $this->data['results'] = get_result('partytransaction', $where, ['transaction_at', 'party_code', 'debit', 'credit', 'commission', 'remark', 'relation', 'comment']);

        } else {
            // get default data
            $this->data['defaultData'] = $this->getDefaultData();
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/company-ledger', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // Get the default data
    public function getDefaultData()
    {
        // Get all parties name
        $select    = ['code', 'name', 'status', 'initial_balance'];
        $partyList = get_result('parties', ['type' => 'supplier', 'trash' => 0], $select);

        // get company transaction
        $results = [];
        foreach ($partyList as $row) {
            $item = [];

            // get supplier balance
            $balanceInfo = get_supplier_balance($row->code);

            $item['code']            = $row->code;
            $item['name']            = $row->name;
            $item['initial_balance'] = $row->initial_balance;
            $item['debit']           = $balanceInfo->debit;
            $item['commission']      = $balanceInfo->commission;
            $item['credit']          = $balanceInfo->credit;
            $item['balance']         = $balanceInfo->balance;
            $item['status']          = $balanceInfo->status;

            array_push($results, (object)$item);
        }

        return $results;
    }
}
