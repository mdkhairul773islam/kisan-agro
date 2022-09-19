<?php
class Short_balance extends Admin_Controller {

    function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->data['meta_title']   = 'Crushing Client Ledger';
        $this->data['active']       = 'data-target="ledger"';
        $this->data['subMenu']      = 'data-target="shortBalance"';
        
        $this->data['results'] = $this->search();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/ledger/nav', $this->data);
        $this->load->view('components/ledger/short-balance', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    // Get the default data
    public function search() {
        
        $type = 'client';
        $dateFrom = (!empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-d'));
        $dateTo   = (!empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d'));
        
        $startTime = strtotime($dateFrom);
        $endTime = strtotime($dateTo);
        
        $results = [];
        for ($i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $item = [];
            
            $date =  date( 'Y-m-d', $i );
            
            $initialBalance = custom_query("SELECT IFNULL(SUM(initial_balance), 0) AS amount FROM `partybalance` WHERE code IN(SELECT code FROM `parties` WHERE type='$type' AND trash=0)", true)->amount;
            $saleAmount     = custom_query("SELECT IFNULL(SUM(total_bill), 0) AS amount FROM `saprecords` WHERE sap_at <= '$date' AND party_code IN (SELECT code FROM `parties` WHERE type='$type' AND trash=0) AND status='sale' AND trash=0", true)->amount;
            $paidAmount     = custom_query("SELECT IFNULL(SUM(paid + remission), 0) AS amount FROM `partytransaction` WHERE transaction_at <= '$date' AND party_code IN (SELECT code FROM `parties` WHERE type='$type' AND trash=0) AND trash=0", true)->amount;
            $returnAmount   = custom_query("SELECT IFNULL(SUM(total_bill), 0) AS amount FROM `sapreturn_records` WHERE created_at <= '$date' AND party_code IN (SELECT code FROM `parties` WHERE type='$type' AND trash=0) AND trash=0 AND status IN ('sale_return', 'sale_damage')", true)->amount;
            
            $balance = ($saleAmount + $initialBalance) - ($paidAmount + $returnAmount);
            
            $item['date'] = $date;
            $item['balance'] = $balance;
         
            array_push($results, (object)$item);
        }
        
        return $results;
    }
}
