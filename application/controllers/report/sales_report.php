<?php

class Sales_report extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Report';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {

        $this->data['subMenu'] = 'data-target="sales_report"';
        $this->data['result']  = null;

        // get all client
        $this->data['allClients'] = get_result('parties', ['type' => 'client', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);

        $this->data['result'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }

    // search all data
    private function search()
    {
        $where = ['status' => 'sale', 'trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $value) {
                    if (!empty($value)) {
                        $where[$_key] = $value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $value) {
                    if (!empty($value) && $_key == 'from') {
                        $where["sap_at >="] = $value;
                    }

                    if (!empty($value) && $_key == 'to') {
                        $where["sap_at <="] = $value;
                    }
                }
            }

        } else {
            $where["sap_at"] = date('Y-m-d');
        }
        $result = get_result('saprecords', $where, '', '', 'sap_at');
        return $result;
    }

    public function sales_report_item()
    {
        $this->data['subMenu'] = 'data-target="sales_report_item"';

        $where = array('status' => 'available', 'type' => 'finish_product', 'trash' => 0);

        $this->data['productionItems'] = get_result('materials', $where);


        $where = ['sapitems.status' => 'sale', 'sapitems.trash' => 0, 'materials.type' => 'finish_product'];

        if (isset($_POST['find'])) {

            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['sapitems.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['department'])) {
                $where['materials.department'] = $_POST['department'];
            }

            foreach ($_POST['date'] as $key => $value) {
                if (!empty($value) && $key == "from") {
                    $where['sapitems.sap_at >='] = $value;
                }

                if (!empty($value) && $key == "to") {
                    $where['sapitems.sap_at <='] = $value;
                }
            }
        } else {
            $where['sapitems.sap_at'] = date('Y-m-d');
        }


        // Fetch saprecords Info
        $this->data['results'] = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $where, ['sapitems.*', 'materials.name']);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_report_item', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }

    public function sales_return_report()
    {

        $this->data['subMenu'] = 'data-target="sales_return_report"';


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/sales_return_report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }

    public function date_wise_sales_report()
    {
        $this->data['subMenu'] = 'data-target="date_wise_sales_report"';

        $where = ['status' => 'sale', 'trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $value) {
                    if (!empty($value) && $_key == 'from') {
                        $where["sap_at >="] = $value;
                    }

                    if (!empty($value) && $_key == 'to') {
                        $where["sap_at <="] = $value;
                    }
                }
            }

        } else {
            $where["sap_at"] = date('Y-m-d');
        }

        $this->data['result'] = get_result('saprecords', $where, ['sap_at', 'total_bill', 'paid'], 'sap_at', 'sap_at');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/date-wise-sales-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    public function date_wise_item_sale_report()
    {
        $this->data['subMenu'] = 'data-target="date_wise_item_sale_report"';
        $this->data['results'] = [];

        $where                         = array('status' => 'available', 'type' => 'finish_product', 'trash' => 0);
        $this->data['productionItems'] = get_result('materials', $where);


        //$this->data['allDepartment'] = get_result('department', ['trash' => 0]);

        $where = ['sapitems.status' => 'sale', 'sapitems.trash' => 0, 'materials.type' => 'finish_product'];

        if (isset($_POST['show'])) {

            if (isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['sapitems.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['department'])) {
                $where['materials.department'] = $_POST['department'];
            }

            foreach ($_POST['date'] as $key => $value) {
                if (!empty($value) && $key == "from") {
                    $where['sapitems.sap_at >='] = $value;
                }

                if (!empty($value) && $key == "to") {
                    $where['sapitems.sap_at <='] = $value;
                }
            }

            // Fetch saprecords Info
            $select = ['sapitems.sap_at', 'SUM(sapitems.quantity) AS quantity', 'SUM(sapitems.quantity * sapitems.sale_price) AS sale_amount', 'materials.name'];

            $this->data['results'] = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $where, $select, 'sapitems.sap_at');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/sales_nav', $this->data);
        $this->load->view('components/report/date-wise-item-sale-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

}