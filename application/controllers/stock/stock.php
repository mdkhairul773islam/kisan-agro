<?php

class Stock extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Raw Mat Stock';
        $this->data['active']       = 'data-target="raw_stock_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = $this->data['rawStock'] = null;

        // get all product
        $this->data['all_product'] = get_result('materials', ['status' => 'available', 'type' => 'raw', 'trash' => 0], ['code', 'name']);

        $where = ['stock.type' => 'raw', 'materials.status' => 'available', 'materials.trash' => 0];
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
                    $this->data['rawStock'][$_key]['unit']        = $item->unit;
                    $this->data['rawStock'][$_key]['price']       = $item->purchase_price;
                    $this->data['rawStock'][$_key]['stock_alert'] = $item->stock_alert;
                    $this->data['rawStock'][$_key]['amount']      = ($item->quantity * $item->purchase_price);
                } elseif (!empty($_POST['stock_alert']) && $item->quantity <= $item->stock_alert) {
                    $this->data['rawStock'][$_key]['code']        = $item->code;
                    $this->data['rawStock'][$_key]['name']        = check_null(filter($item->name));
                    $this->data['rawStock'][$_key]['unit']        = $item->unit;
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
        $this->load->view('components/stock/raw_stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    public function finish_product_stock()
    {
        $this->data['meta_title']   = 'Finish Product Stock';
        $this->data['active']       = 'data-target="product_stock_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get all product
        $this->data['productList']  = get_result('materials', ['status' => 'available', 'type' => 'finish_product', 'trash' => 0], ['code', 'name']);
        $this->data['categoryList'] = get_result('category', ['trash' => 0], ['id', 'category']);

        $where = [
            'production_items.quantity >' => 'production_items.sale_quantity',
            'production_items.status'     => 'to',
            'production_items.trash'      => 0
        ];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $value) {
                    if (!empty($value)) {
                        $where["materials.$_key"] = $value;
                    }
                }
            }

            if (!empty($_POST['product_code'])) {
                $where["materials.code"] = $_POST['product_code'];
            }
            if (!empty($_POST['category_id'])) {
                $where["materials.category_id"] = $_POST['category_id'];
            }

            if (!empty($_POST['dateFrom'])) {
                $where["production_items.created >="] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where["production_items.created <="] = $_POST['dateTo'];
            }
        }

        $tableTo  = ['materials', 'category'];
        $joinCond = ['production_items.product_code=materials.code', 'materials.category_id=category.id'];
        $select   = ['production_items.*', 'SUM(production_items.quantity - production_items.sale_quantity) AS quantity', 'materials.name', 'materials.unit', 'category.category'];

        $this->data['results'] = get_left_join('production_items', $tableTo, $joinCond, $where, $select, 'production_items.id', 'production_items.batch_no', 'asc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/stock/finish_product_stock', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

}
