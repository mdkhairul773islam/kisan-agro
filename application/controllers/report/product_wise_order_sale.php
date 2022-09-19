<?php

class Product_wise_order_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        
        // get all department
        $this->data['allDepartment'] = get_result('department', ['trash' => 0]);

        $this->data['meta_title'] = 'Cash book';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {
        $this->data['subMenu'] = 'data-target="product_wise_order_sale"';
        
        // all product
        $this->data['allProduct'] = get_result('materials', ['type' => 'finish_product', 'status' => 'available', 'trash' => 0], ['code', 'name']);

        // show result
        $this->data['result'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/product-wise-order-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all data
    private function search()
    {
        $data = [];

        if (!empty($_POST['show'])) {
            if (!empty($_POST['date'])) {
                $date = $_POST['date'];
            }
        } else {
            $date = date('Y-m-d');
        }
        
        if(!empty($_POST['department'])){
            $department = $_POST['department'];
            $result = custom_query("SELECT sa.sap_at, sa.sale_price, ma.code, ma.name, sa.unit,  sa.weight, SUM(sa.quantity) as totalQuantity, SUM(sa.total_weight) as totalWeight, SUM(sa.sale_price * sa.quantity) as totalAmount FROM sapitems as sa JOIN materials as ma ON sa.product_code=ma.code WHERE ma.type='finish_product' AND ma.department='$department' AND sa.trash=0 AND sa.sap_type='order' AND sa.stock_type='order' AND sa.sap_at='$date' GROUP BY sa.product_code");
        }elseif(!empty($_POST['product_code'])){
            $productCode = $_POST['product_code'];
            $result = custom_query("SELECT sa.sap_at, sa.sale_price, ma.code, ma.name, sa.unit,  sa.weight, SUM(sa.quantity) as totalQuantity, SUM(sa.total_weight) as totalWeight, SUM(sa.sale_price * sa.quantity) as totalAmount FROM sapitems as sa JOIN materials as ma ON sa.product_code=ma.code WHERE ma.type='finish_product' AND sa.product_code='$productCode' AND sa.trash=0 AND sa.sap_type='order' AND sa.stock_type='order' AND sa.sap_at='$date' GROUP BY sa.product_code");
        }else{
            $result = custom_query("SELECT sa.sap_at, sa.sale_price, ma.code, ma.name, sa.unit,  sa.weight, SUM(sa.quantity) as totalQuantity, SUM(sa.total_weight) as totalWeight, SUM(sa.sale_price * sa.quantity) as totalAmount FROM sapitems as sa JOIN materials as ma ON sa.product_code=ma.code WHERE ma.type='finish_product' AND sa.trash=0 AND sa.sap_type='order' AND sa.stock_type='order' AND sa.sap_at='$date' GROUP BY sa.product_code");
        }


        if (!empty($result)) {
            foreach ($result as $_key => $item) {
                $where        = [
                    'sapitems.sap_at' => $item->sap_at,
                    'materials.code'  => $item->code,
                    'materials.type'  => 'finish_product',
                    'sapitems.status' => 'sale',
                    'sapitems.trash'  => 0,
                ];
                $saleQuantity = get_join_sum('sapitems', 'materials', 'sapitems.product_code=materials.code', 'sapitems.quantity', $where);
                $saleQuantity = (!empty($saleQuantity) ? $saleQuantity : 0);

                $totalQuantity = ($item->totalQuantity - $saleQuantity);

                $data[$_key]['sap_at'] = $item->sap_at;
                $data[$_key]['code']   = $item->code;
                $data[$_key]['name']   = $item->name;
                $data[$_key]['unit']   = $item->unit;
                $data[$_key]['weight'] = $item->weight;
                $data[$_key]['totalQuantity'] = $totalQuantity;
                $data[$_key]['totalWeight']   = ($totalQuantity * $item->weight);
                $data[$_key]['totalAmount']   = $item->sale_price * $totalQuantity;

            }
        }
        return $data;
    }
}