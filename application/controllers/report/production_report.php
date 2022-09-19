<?php

class Production_report extends Admin_Controller
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
        $this->load->view('components/report/date-wise-production-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all data
    private function search()
    {
        $where = [
            'productions.status' => 'from',
            'productions.trash'  => 0,
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['productions.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['dateFrom'])) {
                $where['productions.created >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['productions.created <='] = $_POST['dateTo'];
            }

        } else {
            $where['productions.created'] = date('Y-m-d');
        }

        $select         = ['productions.created', 'productions.voucher_no', 'productions.quantity', 'stock.code', 'stock.name'];
        $productionList = get_left_join('productions', 'stock', 'productions.code=stock.code', $where, $select, 'productions.voucher_no');

        $results = [];
        if (!empty($productionList)) {
            foreach ($productionList as $key => $row) {
                $item = [];

                $fromQuantity = custom_query("SELECT IFNULL(SUM(quantity), 0) AS quantity FROM productions WHERE voucher_no='$row->voucher_no' AND status='from' AND trash=0", true)->quantity;
                $toQuantity = custom_query("SELECT IFNULL(SUM(quantity), 0) AS quantity FROM productions WHERE voucher_no='$row->voucher_no' AND status='to' AND trash=0", true)->quantity;

                $item['created']       = $row->created;
                $item['voucher_no']    = $row->voucher_no;
                $item['from_quantity'] = $fromQuantity;
                $item['to_quantity']   = $toQuantity;

                array_push($results, (object)$item);
            }
        }

        return $results;
    }
}