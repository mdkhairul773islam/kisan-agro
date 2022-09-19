<?php class Cash_book extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->data['meta_title'] = 'Cash book';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="cash_book"';

        // show result
        $this->data['result'] = $this->search();


        // closing balance
        if (isset($_POST['closing'])) {

            $ClosingInfo['current_balance'] = $_POST['current_balance'];
            $ClosingInfo['balance']         = (!empty($_POST['balance']) ? $_POST['balance'] : 0);

            if (check_exists('opening_balance', ['created_at' => $_POST['created_at']])) {
                $msg    = array(
                    'title' => 'update',
                    'emit'  => 'Closed balance successfully update.',
                    'btn'   => true
                );
                $status = 'success';
                save_data('opening_balance', $ClosingInfo, ['created_at' => $_POST['created_at']]);
            } else {
                $msg                       = array(
                    'title' => 'success',
                    'emit'  => 'Today\'s balance is closed.',
                    'btn'   => true
                );
                $status                    = 'success';
                $ClosingInfo['created_at'] = $_POST['created_at'];
                save_data('opening_balance', $ClosingInfo);
            }

            $this->data['confirmation'] = message($status, $msg);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('report/cash_book', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/cash-book', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all data
    private function search()
    {
        $allData = [];

        // default where
        $purchaseWhere      = ['status' => 'purchase', 'paid >' => 0, 'trash' => 0];
        $supTranWhere       = ['parties.type' => 'supplier', 'parties.trash' => 0, 'partytransaction.relation' => 'transaction', 'partytransaction.trash' => 0];
        $clientTranWhere    = ['parties.type' => 'client', 'parties.trash' => 0, 'partytransaction.relation' => 'transaction', 'partytransaction.trash' => 0];
        $saleWhere          = ['status' => 'sale', 'paid >' => 0, 'trash' => 0];
        $costWhere          = ['cost.trash' => 0];
        $incomeWhere        = ['income.trash' => 0];
        $salaryWhere        = ['salary_records.amount >' => 0, 'salary_records.trash' => 0];
        $bankWhere          = [];
        $cashDueWhere       = ['trash' => 0];
        $advanceSalaryWhere = ['advanced_payment.amount >' => 0, 'advanced_payment.trash' => 0];
        $loanWhere          = ['trash' => 0];
        $loanTrxWhere       = ['trash' => 0];
        $bonusWhere         = ['bonus >' => 0];
        $extraBonusWhere    = ['extra_bonus >' => 0];
        $ccLoanWhere        = [];

        // show result
        if (isset($_POST['show'])) {
            if (!empty($_POST['date'])) {
                $purchaseWhere["sap_at"]                            = $_POST['date'];
                $supTranWhere["partytransaction.transaction_at"]    = $_POST['date'];
                $clientTranWhere["partytransaction.transaction_at"] = $_POST['date'];
                $saleWhere["sap_at"]                                = $_POST['date'];
                $costWhere["cost.date"]                             = $_POST['date'];
                $incomeWhere["income.date"]                         = $_POST['date'];
                $salaryWhere["salary_records.created"]              = $_POST['date'];
                $bankWhere["transaction_date"]                      = $_POST['date'];
                $cashDueWhere["date"]                               = $_POST['date'];
                $advanceSalaryWhere["advanced_payment.created"]     = $_POST['date'];
                $loanWhere["date"]                                  = $_POST['date'];
                $loanTrxWhere["date"]                               = $_POST['date'];
                $bonusWhere["insert_date"]                          = $_POST['date'];
                $extraBonusWhere["extra_bonus_insert_date"]         = $_POST['date'];
                $ccLoanWhere["trx_date"]                            = $_POST['date'];

            }
        } else {
            $purchaseWhere["sap_at"]                            = date('Y-m-d');
            $supTranWhere["partytransaction.transaction_at"]    = date('Y-m-d');
            $clientTranWhere["partytransaction.transaction_at"] = date('Y-m-d');
            $saleWhere["sap_at"]                                = date('Y-m-d');
            $costWhere["cost.date"]                             = date('Y-m-d');
            $incomeWhere["income.date"]                         = date('Y-m-d');
            $salaryWhere["salary_records.created"]              = date('Y-m-d');
            $bankWhere["transaction_date"]                      = date('Y-m-d');
            $cashDueWhere["date"]                               = date('Y-m-d');
            $advanceSalaryWhere["advanced_payment.created"]     = date('Y-m-d');
            $loanWhere["date"]                                  = date('Y-m-d');
            $loanTrxWhere["date"]                               = date('Y-m-d');
            $bonusWhere["insert_date"]                          = date('Y-m-d');
            $extraBonusWhere["extra_bonus_insert_date"]         = date('Y-m-d');
            $ccLoanWhere["trx_date"]                            = date('Y-m-d');
        }
        
        
        // cc loan received
        $ccLoanWhere['cc_loan_trx.loan_rcv >'] = 0;
        $select = ['cc_loan_trx.*', 'cc_loan.name', 'cc_loan.contact_info', 'cc_loan.address', 'cc_loan.bank_name'];
        $ccLoan = get_join('cc_loan_trx', 'cc_loan', 'cc_loan_trx.acc_no=cc_loan.acc_no', $ccLoanWhere, $select);
        if (!empty($ccLoan)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($ccLoan as $key => $value) {

                $data[$key]['date']        = $value->trx_date;
                $data[$key]['description'] = 'Name: ' . $value->name .', Mobile: '. $value->contact_info .', Address: '. $value->address .', Bank: '. $value->bank_name;
                $data[$key]['debit']       = 0;
                $data[$key]['credit']      = $value->loan_rcv;
                $debit                     += 0;
                $credit                    += $value->loan_rcv;
            }

            array_push($allData, ['title' => 'CC Loan Received', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        
        
        // cc loan Payment
        unset($ccLoanWhere['cc_loan_trx.loan_rcv >']);
        $ccLoanWhere['cc_loan_trx.loan_paid >'] = 0;
        $select = ['cc_loan_trx.*', 'cc_loan.name', 'cc_loan.contact_info', 'cc_loan.address', 'cc_loan.bank_name'];
        $ccLoan = get_join('cc_loan_trx', 'cc_loan', 'cc_loan_trx.acc_no=cc_loan.acc_no', $ccLoanWhere, $select);
        if (!empty($ccLoan)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($ccLoan as $key => $value) {

                $data[$key]['date']        = $value->trx_date;
                $data[$key]['description'] = 'Name: ' . $value->name .', Mobile: '. $value->contact_info .', Address: '. $value->address .', Bank: '. $value->bank_name;
                $data[$key]['debit']       = $value->loan_paid;
                $data[$key]['credit']      = 0;
                $debit                     += $value->loan_paid;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'CC Loan Payment', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        
        // cc loan charge
        unset($ccLoanWhere['cc_loan_trx.loan_paid >']);
        $ccLoanWhere['cc_loan_trx.loan_charge >'] = 0;
        $select = ['cc_loan_trx.*', 'cc_loan.name', 'cc_loan.contact_info', 'cc_loan.address', 'cc_loan.bank_name'];
        $ccLoan = get_join('cc_loan_trx', 'cc_loan', 'cc_loan_trx.acc_no=cc_loan.acc_no', $ccLoanWhere, $select);
        if (!empty($ccLoan)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($ccLoan as $key => $value) {

                $data[$key]['date']        = $value->trx_date;
                $data[$key]['description'] = 'Name: ' . $value->name .', Mobile: '. $value->contact_info .', Address: '. $value->address .', Bank: '. $value->bank_name;
                $data[$key]['debit']       = $value->loan_charge;
                $data[$key]['credit']      = 0;
                $debit                     += $value->loan_charge;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'CC Loan Charge', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        
        // cc loan charge
        unset($ccLoanWhere['cc_loan_trx.loan_charge >']);
        $ccLoanWhere['cc_loan_trx.interest_paid >'] = 0;
        $select = ['cc_loan_trx.*', 'cc_loan.name', 'cc_loan.contact_info', 'cc_loan.address', 'cc_loan.bank_name'];
        $ccLoan = get_join('cc_loan_trx', 'cc_loan', 'cc_loan_trx.acc_no=cc_loan.acc_no', $ccLoanWhere, $select);
        if (!empty($ccLoan)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($ccLoan as $key => $value) {

                $data[$key]['date']        = $value->trx_date;
                $data[$key]['description'] = 'Name: ' . $value->name .', Mobile: '. $value->contact_info .', Address: '. $value->address .', Bank: '. $value->bank_name;
                $data[$key]['debit']       = $value->interest_paid;
                $data[$key]['credit']      = 0;
                $debit                     += $value->interest_paid;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'CC Loan Interest Paid', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        

        // sale info
        $sale = get_result('saprecords', $saleWhere, ['sap_at', 'party_code', 'client_info', 'status', 'sap_type', 'sale_type', 'total_bill', 'paid']);
        if (!empty($sale)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($sale as $key => $value) {

                if ($value->sap_type != 'cash') {
                    $name = get_name('parties', 'name', ['code' => $value->party_code]);
                } else {
                    $name = json_decode($value->client_info, true)['name'];
                }

                $data[$key]['date']        = $value->sap_at;
                $data[$key]['description'] = check_null($name) . ', ' . '<strong> ' . filter($value->sap_type) . ' </strong>' . ' ' . filter($value->sale_type) . ' ' . filter($value->status);
                $data[$key]['debit']       = 0;
                $data[$key]['credit']      = $value->paid;
                $debit                     += 0;
                $credit                    += $value->paid;
            }

            array_push($allData, ['title' => 'Sale', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }

        // client received transaction info
        $clientTranWhere['partytransaction.credit > '] = 0;
        $clientTransaction = get_join('parties', 'partytransaction', 'parties.code=partytransaction.party_code', $clientTranWhere, ['partytransaction.transaction_at', 'parties.name', 'partytransaction.credit']);
        if (!empty($clientTransaction)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($clientTransaction as $key => $value) {
                $data[$key]['date']        = $value->transaction_at;
                $data[$key]['description'] = $value->name;
                $data[$key]['debit']       = 0;
                $data[$key]['credit']      = $value->credit;
                $debit                     += 0;
                $credit                    += $value->credit;
            }

            array_push($allData, ['title' => 'Client Received', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        
        
        // client payment transaction info
        unset($clientTranWhere['partytransaction.credit > ']);
        $clientTranWhere['partytransaction.debit > '] = 0;
        $clientTransaction = get_join('parties', 'partytransaction', 'parties.code=partytransaction.party_code', $clientTranWhere, ['partytransaction.transaction_at', 'parties.name', 'partytransaction.debit']);
        if (!empty($clientTransaction)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($clientTransaction as $key => $value) {
                $data[$key]['date']        = $value->transaction_at;
                $data[$key]['description'] = $value->name;
                $data[$key]['debit']       = $value->debit;
                $data[$key]['credit']      = 0;
                $debit                     += $value->debit;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'Client Payment', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }

        // cash due collection info
        $cashDueCollection = get_result('due_collectio', $cashDueWhere, ['date', 'voucher_no', 'paid', 'remission']);
        if (!empty($cashDueCollection)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($cashDueCollection as $key => $value) {
                $clientInfo = get_name('saprecords', 'client_info', ['voucher_no' => $value->voucher_no]);
                $clientInfo = json_decode($clientInfo, true);

                $data[$key]['date']        = $value->date;
                $data[$key]['description'] = filter(check_null($clientInfo['name']));
                $data[$key]['debit']       = 0;
                $data[$key]['credit']      = $value->paid + $value->remission;
                $debit                     += 0;
                $credit                    += $value->paid + $value->remission;
            }

            array_push($allData, ['title' => 'Cash Client Due Payment', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // purchase info
        $purchase = get_result('saprecords', $purchaseWhere, ['sap_at', 'status', 'total_bill', 'paid']);
        if (!empty($purchase)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($purchase as $key => $value) {
                $data[$key]['date']        = $value->sap_at;
                $data[$key]['description'] = $value->status;
                $data[$key]['debit']       = $value->paid;
                $data[$key]['credit']      = 0;
                $debit                     += $value->paid;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'Purchase', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }

        // supplier payment transaction info
        $supTranWhere['partytransaction.debit >'] = 0;
        $supplierTransaction = get_join('parties', 'partytransaction', 'parties.code=partytransaction.party_code', $supTranWhere, ['partytransaction.transaction_at', 'parties.name', 'partytransaction.debit']);
        if (!empty($supplierTransaction)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($supplierTransaction as $key => $value) {
                $data[$key]['date']        = $value->transaction_at;
                $data[$key]['description'] = $value->name;
                $data[$key]['debit']       = $value->debit;
                $data[$key]['credit']      = 0;
                $debit                     += $value->debit;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'Supplier Payment', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        
        // supplier received transaction info
        unset($supTranWhere['partytransaction.debit >']);
        $supTranWhere['partytransaction.credit >'] = 0;
        $supplierTransaction = get_join('parties', 'partytransaction', 'parties.code=partytransaction.party_code', $supTranWhere, ['partytransaction.transaction_at', 'parties.name', 'partytransaction.credit']);
        if (!empty($supplierTransaction)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($supplierTransaction as $key => $value) {
                $data[$key]['date']        = $value->transaction_at;
                $data[$key]['description'] = $value->name;
                $data[$key]['debit']       = 0;
                $data[$key]['credit']      = $value->credit;
                $debit                     += 0;
                $credit                    += $value->credit;
            }

            array_push($allData, ['title' => 'Supplier Received', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // cost info
        // cost info
        $tableTo  = ['cost_field', 'cost_category'];
        $joinCond = ['cost.cost_field_id=cost_field.id', 'cost.cost_category_id=cost_category.id'];
        $select   = ['cost.*', 'cost_field.cost_field', 'cost_category.cost_category'];
        
        $cost = get_left_join('cost', $tableTo, $joinCond, $costWhere, $select);
        if (!empty($cost)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($cost as $key => $value) {
                $data[$key]['date']        = $value->date;
                $data[$key]['description'] = '<strong>Cost Category:</strong> ' . filter($value->cost_category) . ', <strong>Cost Field:</strong> ' . filter($value->cost_field) . ', <strong>Description:</strong> ' . check_null($value->description) . ', <strong>Spend By:</strong> ' . check_null($value->spend_by);
                $data[$key]['debit']       = $value->amount;
                $data[$key]['credit']      = 0;
                $debit                     += $value->amount;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'expenditure', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // Income info
        $income = get_join('income', 'income_field', 'income.field=income_field.code', $incomeWhere, ['income.*', 'income_field.field']);
        if (!empty($income)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($income as $key => $value) {
                $data[$key]['date']        = $value->date;
                $data[$key]['description'] = '<strong>Income Field:</strong> ' . filter($value->field) . ', <strong>Description:</strong> ' . check_null($value->description) . ', <strong>Spend By:</strong> ' . check_null($value->income_by);
                $data[$key]['debit']       = 0;
                $data[$key]['credit']      = $value->amount;
                $debit                     += 0;
                $credit                    += $value->amount;
            }

            array_push($allData, ['title' => 'Income', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // salary info
        $salary = get_join('salary_records', 'employee', 'salary_records.emp_id=employee.emp_id', $salaryWhere, ['salary_records.created', 'salary_records.amount', 'employee.name', 'employee.emp_id']);
        if (!empty($salary)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($salary as $key => $value) {
                $data[$key]['date']        = $value->created;
                $data[$key]['description'] = $value->emp_id.' - '.filter($value->name);
                $data[$key]['debit']       = $value->amount;
                $data[$key]['credit']      = 0;
                $debit                     += $value->amount;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'Salary Payment', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }
        
        // advance salary info
        $advanceSalary = get_join('advanced_payment', 'employee', 'advanced_payment.emp_id=employee.emp_id', $advanceSalaryWhere, ['advanced_payment.created', 'advanced_payment.amount', 'employee.name', 'employee.emp_id']);
        if (!empty($advanceSalary)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($advanceSalary as $key => $value) {
                $data[$key]['date']        = $value->created;
                $data[$key]['description'] = $value->emp_id.' - '.filter($value->name);
                $data[$key]['debit']       = $value->amount;
                $data[$key]['credit']      = 0;
                $debit                     += $value->amount;
                $credit                    += 0;
            }

            array_push($allData, ['title' => 'Advance Salary Payment', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // bank transaction info
        $bankTransaction = get_result('transaction', $bankWhere);
        if (!empty($bankTransaction)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($bankTransaction as $key => $value) {

                $data[$key]['date']        = $value->transaction_date;
                $data[$key]['description'] = $value->bank;
                if ($value->transaction_type == 'Credit' || $value->transaction_type == 'bank_to_TT') {
                    $data[$key]['debit']  = $value->amount;
                    $data[$key]['credit'] = 0;
                    $debit                += $value->amount;
                } else {
                    $data[$key]['debit']  = 0;
                    $data[$key]['credit'] = $value->amount;
                    $credit               += $value->amount;
                }
            }

            array_push($allData, ['title' => 'Bank Transaction', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // loan info
        $loanAmount = get_result('loan', $loanWhere);
        if (!empty($loanAmount)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($loanAmount as $key => $value) {

                $data[$key]['date']        = $value->date;
                $data[$key]['description'] = 'Loan Holder: '.$value->name. ', Loan By: '.$value->loan_by.', Loan Type: '.$value->loan_type;
                if ($value->loan_type == 'Received') {
                    $data[$key]['debit']  = 0;
                    $data[$key]['credit'] = $value->amount;
                    $credit               += $value->amount;
                } else {
                    $data[$key]['debit']  = $value->amount;
                    $data[$key]['credit'] = 0;
                    $debit                += $value->amount;
                }
            }

            array_push($allData, ['title' => 'Loan', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }


        // loan transaction info
        $loanTransaction = get_result('loan_transaction', $loanTrxWhere);
        if (!empty($loanTransaction)) {
            $data  = [];
            $debit = $credit = 0;
            foreach ($loanTransaction as $key => $value) {

                $loanInfo = get_row('loan', ['id' => $value->loan_id], ['loan_type', 'name']);

                $data[$key]['date']        = $value->date;
                $data[$key]['description'] = 'Loan Holder: '.$loanInfo->name. ', Trx By: '.$value->transaction_by.', Trx Type: '.$value->trx_type;

                if($loanInfo->loan_type == 'Received'){
                    if ($value->trx_type == 'Received') {
                        $data[$key]['debit']  = 0;
                        $data[$key]['credit'] = $value->amount;
                        $credit               += $value->amount;
                    } else {
                        $data[$key]['debit']  = $value->amount;
                        $data[$key]['credit'] = 0;
                        $debit                += $value->amount;
                    }
                }else{
                    if ($value->trx_type == 'Paid') {
                        $data[$key]['debit']  = $value->amount;
                        $data[$key]['credit'] = 0;
                        $debit                += $value->amount;
                    } else {
                        $data[$key]['debit']  = 0;
                        $data[$key]['credit'] = $value->amount;
                        $credit               += $value->amount;
                    }
                }
            }

            array_push($allData, ['title' => 'Loan Transaction', 'debit' => $debit, 'credit' => $credit, 'info' => $data]);
        }

        return $allData;
    }
}