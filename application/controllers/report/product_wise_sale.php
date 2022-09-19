<?php

class Product_wise_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();


        $this->data['meta_title'] = 'Cash book';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {
        $this->data['subMenu'] = 'data-target="product_wise_sale"';

        // all product
        $this->data['allProduct'] = get_result('materials', ['type' => 'finish_product', 'status' => 'available', 'trash' => 0], ['code', 'name']);

        // show result
        $this->data['result'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/product-wise-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all data
    private function search()
    {
        $result = [];

        if (!empty($_POST['show'])) {
            if (!empty($_POST['date'])) {
                $date = $_POST['date'];
            }
        } else {
            $date = date('Y-m-d');
        }


        if (!empty($_POST['product_code'])) {
            $productCode = $_POST['product_code'];
            $result      = custom_query("SELECT sa.sap_at, ma.code, ma.name, sa.unit,  sa.weight, SUM(sa.quantity) as totalQuantity, SUM(sa.total_weight) as totalWeight, SUM(sa.sale_price * sa.quantity) as totalAmount FROM sapitems as sa JOIN materials as ma ON sa.product_code=ma.code WHERE ma.type='finish_product' AND sa.product_code='$productCode' AND sa.trash=0 AND sa.status='sale' AND sa.sap_at='$date' GROUP BY sa.product_code");
        } else {
            $result = custom_query("SELECT sa.sap_at, ma.code, ma.name, sa.unit,  sa.weight, SUM(sa.quantity) as totalQuantity, SUM(sa.total_weight) as totalWeight, SUM(sa.sale_price * sa.quantity) as totalAmount FROM sapitems as sa JOIN materials as ma ON sa.product_code=ma.code WHERE ma.type='finish_product' AND sa.trash=0 AND sa.status='sale' AND sa.sap_at='$date' GROUP BY sa.product_code");
        }

        return $result;
    }
}