<?php class ClientLedger extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->data['meta_title'] = 'Client Ledger';
        $this->data['active']     = 'data-target="ledger"';
        $this->data['subMenu']    = 'data-target="client-ledger"';


        $this->data['results']     = [];
        $this->data['defaultData'] = [];


        // Get all parties name
        $this->data['partyList'] = get_result('parties', ["type" => "client", "trash" => 0], ['code', 'name', 'mobile', 'address']);


        // Get data after submit query Start here
        if (isset($_POST['show']) && !empty($_POST['search']['party_code'])) {

            $partyCode = $_POST['search']['party_code'];

            // get party info
            $this->data['partyInfo'] = $partyInfo = get_row('parties', ['code' => $partyCode]);

            $this->data['balanceInfo'] = get_client_balance($partyCode);

            $where = [
                "party_code" => $partyCode,
                "trash"      => 0
            ];

            $this->data['dateFrom'] = $dataFrom = (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '');
            $this->data['dateTo']   = $dataTo = (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '');

            if (!empty($dataFrom)) {

                $previousTran    = custom_query("SELECT party_code, IFNULL(sum(debit), 0) AS debit, IFNULL(SUM(credit + remission), 0) AS credit FROM partytransaction WHERE party_code='$partyInfo->code' AND trash=0 AND transaction_at < '$dataFrom'", true);
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
            $this->data['results'] = get_result('partytransaction', $where, ['transaction_at', 'party_code', 'debit', 'credit', 'remission', 'remark', 'relation', 'comment']);

        } else {
            // get default data
            $this->data['defaultData'] = $this->getDefaultData();
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/client-ledger', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // Get the default data
    public function getDefaultData()
    {
        // Get all parties name
        $data      = [];
        $select    = ['code', 'name', 'status', 'initial_balance'];
        $partyList = get_result('parties', ['type' => 'client', 'trash' => 0], $select);

        $dataFrom = (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '');
        $dataTo   = (!empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d'));

        // get company transaction
        foreach ($partyList as $key => $value) {
            $item = [];

            // get previous balance
            $previousTranDate = (!empty($dataFrom) ? ' AND transaction_at < \'' . $dataFrom . '\'' : '');
            if (!empty($previousTranDate)) {
                $previousTran    = custom_query("SELECT party_code, IFNULL(sum(debit), 0) AS debit, IFNULL(SUM(credit + remission), 0) AS credit FROM partytransaction WHERE party_code='$value->code' AND trash=0 {$previousTranDate}", true);
                $previousBalance = $previousTran->debit - $previousTran->credit + $value->initial_balance;
            } else {
                $previousBalance = $value->initial_balance;
            }

            $tranDateFrom = (!empty($dataFrom) ? ' AND transaction_at >= \'' . $dataFrom . '\'' : '');
            $tranDateTo   = (!empty($dataTo) ? ' AND transaction_at <= \'' . $dataTo . '\'' : '');
            $tranInfo     = custom_query("SELECT party_code, IFNULL(sum(debit), 0) AS debit, IFNULL(SUM(credit), 0) AS credit, IFNULL(SUM(remission), 0) AS remission FROM partytransaction WHERE party_code='$value->code' AND trash=0 {$tranDateFrom} {$tranDateTo}", true);

            $balance = $tranInfo->debit - ($tranInfo->credit + $tranInfo->remission) + $previousBalance;

            $item['code']            = $value->code;
            $item['name']            = $value->name;
            $item['initial_balance'] = $previousBalance;
            $item['debit']           = $tranInfo->debit;
            $item['credit']          = $tranInfo->credit;
            $item['remission']       = $tranInfo->remission;
            $item['balance']         = $balance;
            $item['status']          = ($balance < 0 ? 'Payable' : 'Receivable');

            array_push($data, (object)$item);
        }

        return $data;
    }
}