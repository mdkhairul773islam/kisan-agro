<?php class Dashboard extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'dashboard';
        $this->data['active']     = 'data-target="dashboard"';
        $this->data['subMenu']    = 'data-target=""';

        $today = date("Y-m-d");

        //today's Sale
        $total_sale               = custom_query("SELECT IFNULL(SUM(total_bill), 0) AS total_sale FROM `saprecords` WHERE sap_at='$today'AND status='sale' AND sap_type IN ('order', 'cash', 'credit') AND trash=0", true)->total_sale;
        $this->data['total_sale'] = (!empty($total_sale) ? f_number($total_sale) : 0);


        //today's Sale paid
        $sale_paid = get_sum("saprecords", "paid", ['sap_at' => $today, 'status' => 'sale', 'trash' => 0]);
        $sale_paid = (!empty($sale_paid) ? $sale_paid : 0); 
        
        //today's cash sale due paid
        $cash_sale_paid = get_sum("due_collectio", "paid", ['date' => $today, 'trash' => 0]);
        $cash_sale_paid = (!empty($cash_sale_paid) ? $cash_sale_paid : 0);


        //today's client payment
        $client_paid = custom_query("SELECT SUM(credit) as totalPaid FROM partytransaction as pt JOIN parties as p ON pt.party_code=p.code WHERE pt.transaction_at='$today' AND pt.relation='transaction' AND pt.trash=0 AND p.type='client'");
        $client_paid = (!empty($client_paid) ? $client_paid[0]->totalPaid : 0);


        // client total paid
        $total_client_paid               = $sale_paid + $client_paid + $cash_sale_paid;
        $this->data['total_client_paid'] = ($total_client_paid > 0 ? f_number($total_client_paid) : 0);


        // raw mates stock
        $raw_mates_stock               = custom_query("SELECT IFNULL(SUM(stock.quantity * stock.purchase_price), 0) AS stock_amount FROM `stock` JOIN materials ON stock.code=materials.code AND stock.type=materials.type WHERE materials.status='available' AND materials.trash=0 AND materials.type='raw'", true);
        $this->data['raw_mates_stock'] = (!empty($raw_mates_stock) ? f_number($raw_mates_stock->stock_amount) : 0);


        //Today's Purchase
        $total_purchase               = get_sum("saprecords", "total_bill", ['sap_at' => $today, 'status' => 'purchase', 'trash' => 0]);
        $this->data['total_purchase'] = (!empty($total_purchase) ? f_number($total_purchase) : 0);


        //today's purchase paid
        $purchase_paid = get_sum("saprecords", "paid", ['sap_at' => $today, 'status' => 'purchase', 'trash' => 0]);
        $purchase_paid = (!empty($purchase_paid) ? $purchase_paid : 0);


        //today's supplier payment
        $supplier_paid = custom_query("SELECT SUM(debit) as totalPaid FROM partytransaction as pt JOIN parties as p ON pt.party_code=p.code WHERE pt.transaction_at='$today' AND pt.relation='transaction' AND pt.trash=0 AND p.type='supplier'");
        $supplier_paid = (!empty($supplier_paid) ? $supplier_paid[0]->totalPaid : 0);


        // total supplier paid
        $total_supplier_paid               = $purchase_paid + $supplier_paid;
        $this->data['total_supplier_paid'] = ($total_supplier_paid > 0 ? f_number($total_supplier_paid) : 0);


        // total cost
        $total_cost               = get_sum('cost', 'amount', ['date' => $today, 'trash' => 0]);
        $total_cost               = (!empty($total_cost) ? $total_cost : 0);
        $this->data['total_cost'] = $total_cost;

        // total income
        $total_income               = get_sum('income', 'amount', ['date' => $today, 'trash' => 0]);
        $total_income               = (!empty($total_income) ? $total_income : 0);
        $this->data['total_income'] = $total_income;


        // total exp and cost
        $total_exp_pay = $total_supplier_paid + $total_cost;
        $this->data['total_exp_pay'] = (!empty($total_exp_pay) ? $total_exp_pay : 0);


        // total finish product stock
        $finish_product_stock               = custom_query("SELECT IFNULL(SUM(stock.quantity * materials.purchase_price), 0) AS stock_amount FROM `stock` JOIN materials ON stock.code=materials.code AND stock.type=materials.type WHERE materials.status='available' AND materials.trash=0 AND materials.type='finish_product'", true);
        $this->data['finish_product_stock'] = (!empty($finish_product_stock) ? f_number($finish_product_stock->stock_amount) : 0);


        //bank diposit
        $bank_diposit               = get_sum('transaction', "amount", ['transaction_date' => $today, 'transaction_type' => 'Credit']);
        $bank_diposit               = (!empty($bank_diposit) ? $bank_diposit : 0);
        $this->data['bank_diposit'] = $bank_diposit;


        //Bank withdraw
        $bank_withdraw               = get_sum('transaction', "amount", ['transaction_date' => $today, 'transaction_type' => 'Debit']);
        $bank_withdraw               = (!empty($bank_withdraw) ? $bank_withdraw : 0);
        $this->data['bank_withdraw'] = $bank_withdraw;

        // total supplier
        $total_supplier               = get_result('parties', ['type' => 'supplier', 'trash' => 0], 'code');
        $this->data['total_supplier'] = (!empty($total_supplier) ? count($total_supplier) : 0);

 
        // total client
        $total_client               = get_result('parties', ['type' => 'client', 'trash' => 0], 'code');
        $this->data['total_client'] = (!empty($total_client) ? count($total_client) : 0);

        //Total bank Balance 
        $get_initial_balance                = 0;
        $get_initial_balance                = get_sum('bank_account', 'init_balance', ['init_balance !='=>0]);
        $bank_credit                        = get_sum('transaction', 'amount', ['transaction_type'=>'Credit']);
        $bank_debit                         = get_sum('transaction', 'amount', ['transaction_type !='=>'Credit']);
        $this->data['total_bank_balance']   = f_number(((!empty($bank_credit) ? $bank_credit : 0) + (!empty($get_initial_balance) ? $get_initial_balance : 0)) -  ( !empty($bank_debit) ? $bank_debit : 0));

        
        // raw and finish materials stock alert
        $this->data['rawStockAlert']    = custom_query("SELECT st.*, mat.stock_alert FROM stock AS st JOIN materials as mat ON st.code=mat.code AND st.type=mat.type WHERE st.type='raw' AND st.quantity <= mat.stock_alert");
        $this->data['finishStockAlert'] = custom_query("SELECT st.*, mat.stock_alert FROM stock AS st JOIN materials as mat ON st.code=mat.code AND st.type=mat.type WHERE st.type='finish_product' AND st.quantity <= mat.stock_alert");


        // calculate hand cash ------------------------------------------------------------------
        $previousDAte    = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
        $previousBalance = get_row('opening_balance', ['created_at' => $previousDAte]);
        $previousBalance = (!empty($previousBalance->balance) ? $previousBalance->balance : 0);
        
        // get advance salary 
        $advanceSalary = get_sum('advanced_payment', 'amount', ['payment_date'=> date('Y-m-d'), 'trash' => 0]);
        $advanceSalary = (!empty($advanceSalary) ? $advanceSalary : 0);
        
        // get all salary
        $salary = get_row('salary_records', ['created'=> date('Y-m-d'), 'trash' => 0], 'SUM(amount) AS amount');
        $salary = (!empty($salary->amount) ? $salary->amount : 0);
        
         
        $credit = $total_client_paid + $bank_withdraw + $total_income;
        $debit  = $total_supplier_paid + $bank_diposit + $total_cost + $advanceSalary + $salary;
        
        $todays_cash               = $previousBalance + $credit - $debit;
        $this->data['todays_cash'] = (!empty($todays_cash) ? f_number($todays_cash) : 0);
        
        // get party due
        $this->data['party'] = $this->partyDue();
        
        $where = [];
        $where = ['commitments.date' => $today];
        $select = ['commitments.*', 'parties.name', 'parties.mobile', 'parties.address', 'parties.initial_balance'];
        $this->data["todaysCommitment"] = get_join('commitments', 'parties', 'parties.code=commitments.party_code', $where, $select);
        
        
        $this->load->view('super/includes/header', $this->data);
        $this->load->view('super/includes/aside', $this->data);
        $this->load->view('super/includes/headermenu', $this->data);
        $this->load->view('super/includes/dashboard_nav', $this->data);
        $this->load->view('super/dashboard', $this->data);
        $this->load->view('super/includes/footer');
    }
    
    private function partyDue() {
        $partyList = get_result('parties', ['trash' => 0], ['code', 'type']);
        $supplierDue = $clientDue = 0;
        if(!empty($partyList)){
            foreach($partyList as $item){
                $due = 0;
                if($item->type == 'supplier'){
                    $due = get_supplier_balance($item->code)->balance;
                    if($due < 0){
                        $supplierDue += abs($due);
                    }
                }elseif($item->type == 'client'){
                    $due = get_client_balance($item->code)->balance;
                    if($due > 0){
                        $clientDue += $due;
                    }
                }
            }
        }
        
        $result = ['supplier_due' => $supplierDue, 'client_due' => $clientDue];
        
        return (object)$result;
    }

    private function holder() {
        if ($this->uri->segment(1) != $this->session->userdata('holder')) {
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
