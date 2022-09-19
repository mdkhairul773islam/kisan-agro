<?php

class Production_ledger extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // get all department
        $this->data['allDepartment'] = get_result('department', ['trash' => 0]);

        $this->data['meta_title'] = 'Production Ledger';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {
        $this->data['subMenu'] = 'data-target="production_ledger"';

        // show result
        $this->data['results'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/production-ledger', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all data
    private function search()
    {
        $dateFrom = $this->data['dateFrom'] = (!empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-01'));
        $dateTo   = $this->data['dateTo'] = (!empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d'));
        $dateFrom = ' AND sapitems.sap_at >= \'' . $dateFrom . '\'';
        $dateTo   = ' AND sapitems.sap_at <= \'' . $dateTo . '\'';


        $results = [];
        if (!empty($_POST['department'])) {

            $dataList = custom_query("SELECT sapitems.sap_at, materials.department, IFNULL(SUM(sapitems.weight * sapitems.quantity), 0) AS total_weight, IFNULL(SUM(sapitems.quantity * sapitems.purchase_price), 0) AS purchase_amount, IFNULL(SUM(sapitems.quantity * sapitems.sale_price), 0) AS sale_amount FROM sapitems JOIN materials ON sapitems.product_code=materials.code WHERE sapitems.sap_type='order' AND sapitems.stock_type='order' AND sapitems.status='stock' AND sapitems.trash=0 AND materials.type='finish_product' {$dateFrom} {$dateTo} GROUP BY sapitems.sap_at");

            $itemList = [];
            if (!empty($dataList)) {
                foreach ($dataList as $row) {
                    $item = [];

                    $item['date']            = $row->sap_at;
                    $item['total_weight']    = $row->total_weight;
                    $item['purchase_amount'] = $row->purchase_amount;
                    $item['sale_amount']     = $row->sale_amount;

                    array_push($itemList, (object)$item);
                }

                array_push($results, (object)['department' => $_POST['department'], 'data' => $itemList]);
            }
        } else {

            $departmentList = $this->data['allDepartment'];

            if (!empty($departmentList)) {
                foreach ($departmentList as $d_row) {

                    $department = ' AND materials.department = \'' . $d_row->department_name . '\'';
                    $dataList   = custom_query("SELECT sapitems.sap_at, materials.department, IFNULL(SUM(sapitems.weight * sapitems.quantity), 0) AS total_weight, IFNULL(SUM(sapitems.quantity * sapitems.purchase_price), 0) AS purchase_amount, IFNULL(SUM(sapitems.quantity * sapitems.sale_price), 0) AS sale_amount FROM sapitems JOIN materials ON sapitems.product_code=materials.code WHERE sapitems.sap_type='order' AND sapitems.stock_type='order' AND sapitems.status='stock' AND sapitems.trash=0 AND materials.type='finish_product' {$dateFrom} {$dateTo} {$department} GROUP BY sapitems.sap_at");

                    $itemList = [];
                    if (!empty($dataList)) {
                        foreach ($dataList as $row) {
                            $item = [];

                            $item['date']            = $row->sap_at;
                            $item['total_weight']    = $row->total_weight;
                            $item['purchase_amount'] = $row->purchase_amount;
                            $item['sale_amount']     = $row->sale_amount;

                            array_push($itemList, (object)$item);
                        }

                        array_push($results, (object)['department' => $d_row->department_name, 'data' => $itemList]);
                    }
                }
            }
        }

        return $results;
    }
}