<?php

class Product_rank extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="product_rank"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;


        // get all department
        $this->data['allDepartment'] = get_result('department', ['trash' => 0]);


        $where = [
            'sapitems.status' => 'sale',
            'materials.type'  => 'finish_product',
            'sapitems.trash'  => 0,
            'materials.trash' => 0
        ];


        if (!empty($_POST['show'])) {

            if (!empty($_POST['department'])) {
                $where['materials.department'] = $_POST['department'];
            }

            foreach ($_POST['date'] as $_key => $value) {
                if (!empty($value) && $_key == 'from') {
                    $where["sapitems.sap_at >="] = $value;
                }
                if (!empty($value) && $_key == 'to') {
                    $where["sapitems.sap_at <="] = $value;
                }
            }
        } else {
            $where["sapitems.sap_at"] = date('Y-m-d');
        }
        $joinCond              = 'sapitems.product_code=materials.code';
        $select                = ['sapitems.product_code', 'AVG(sapitems.purchase_price) AS purchase_price', 'AVG(sapitems.sale_price) AS sale_price', 'SUM(sapitems.quantity) AS quantity', 'materials.name', 'materials.department', 'materials.unit'];
        $this->data['results'] = get_join("sapitems", 'materials', $joinCond, $where, $select, 'sapitems.product_code', 'sapitems.product_code', 'asc');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/product_rank', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

}
