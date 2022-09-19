<?php

class Stock extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['meta_title'] = 'Machinery';
        $this->data['active']     = 'data-target="machinery_menu"';
    }

    public function index()
    {
        
        $this->data['subMenu']      = 'data-target="stock"';
        $this->data['confirmation'] = $this->data['rawStock'] = null;

        // get all product
        $this->data['all_product'] = get_result('materials', ['type' => 'raw', 'raw_type' => 'machinery', 'trash' => 0, 'status'=>'available'], ['code', 'name']);

        $where = ['stock.type' => 'raw', 'materials.trash' => 0, 'materials.raw_type' => 'machinery', 'materials.status'=>'available'];
        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $value) {
                    if (!empty($value)) {
                        $where["stock.$_key"] = $value;
                    }
                }
            }
        }

        $allRawStock = get_join('stock', 'materials', 'materials.code=stock.code AND materials.type=stock.type', $where, ['stock.*', 'materials.stock_alert'], '', 'stock.code');

        if (!empty($allRawStock)) {
            foreach ($allRawStock as $_key => $item) {
                if (empty($_POST['stock_alert'])) {
                    $this->data['rawStock'][$_key]['code']        = $item->code;
                    $this->data['rawStock'][$_key]['name']        = check_null(filter($item->name));
                    $this->data['rawStock'][$_key]['quantity']    = $item->quantity;
                    $this->data['rawStock'][$_key]['price']       = $item->purchase_price;
                    $this->data['rawStock'][$_key]['stock_alert'] = $item->stock_alert;
                    $this->data['rawStock'][$_key]['amount']      = ($item->quantity * $item->purchase_price);
                } elseif (!empty($_POST['stock_alert']) && $item->quantity <= $item->stock_alert) {
                    $this->data['rawStock'][$_key]['code']        = $item->code;
                    $this->data['rawStock'][$_key]['name']        = check_null(filter($item->name));
                    $this->data['rawStock'][$_key]['quantity']    = $item->quantity;
                    $this->data['rawStock'][$_key]['price']       = $item->purchase_price;
                    $this->data['rawStock'][$_key]['stock_alert'] = $item->stock_alert;
                    $this->data['rawStock'][$_key]['amount']      = ($item->quantity * $item->purchase_price);
                }
            }
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/machinery/nav', $this->data);
        $this->load->view('components/machinery/stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

}
