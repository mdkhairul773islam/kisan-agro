<?php

class Used extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    /**
     * Packaging add form
     */
    public function index()
    {
        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="add-packaging"';
        $this->data['confirmation'] = null;

        //get all Product
        $this->data['allProducts'] = get_join('stock', 'materials', 'stock.code=materials.code AND stock.type=materials.type', ['stock.type' => 'raw'], ['stock.code', 'stock.name'], '', 'materials.code', 'asc');

        // load view files
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * Show all data
     */
    public function show()
    {
        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all-packaging"';
        $this->data['confirmation'] = null;

        // get all result
        $this->data['result'] = $this->search();

        // load view files
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/show-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * item wise used
     */
    public function item_wise_used()
    {
        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="item_wise_used"';
        $this->data['confirmation'] = null;

        $this->data['result'] = $this->item_wise_used_search();

        // load view files
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/item-wise-used', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * item wise used search
     */
    public function item_wise_used_search()
    {

        $date_from = (!empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d'));
        $date_to   = (!empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d'));

        // get all product info
        $allInfo = custom_query("SELECT materials.code, materials.name, materials.type, materials.unit, tbl_recipe_item.ri_purchase_price, tbl_recipe_item.ri_total_quantity, tbl_packaging_items.pi_purchase_price, tbl_packaging_items.pi_total_quantity FROM( SELECT code, name, type, unit FROM materials WHERE type='raw' AND trash=0)materials LEFT JOIN ( SELECT product_code, AVG(purchase_price) AS ri_purchase_price, SUM(item_total_material) AS ri_total_quantity FROM tbl_recipe_item WHERE trash=0 AND created >= '$date_from' AND created <= '$date_to' GROUP BY product_code )tbl_recipe_item ON materials.code=tbl_recipe_item.product_code LEFT JOIN ( SELECT product_code, AVG(purchase_price) AS pi_purchase_price, SUM(quantity) AS pi_total_quantity FROM tbl_packaging_items WHERE trash=0 AND created_at >= '$date_from' AND created_at <= '$date_to' GROUP BY product_code )tbl_packaging_items ON materials.code=tbl_packaging_items.product_code");

        $data = [];
        $key  = 0;

        if (!empty($allInfo)) {
            foreach ($allInfo as $item) {

                $purchase_price = $total_amount = $total_quantity = 0;

                if (!empty($item->ri_purchase_price) && !empty($item->pi_purchase_price)) {

                    $purchase_price = ($item->ri_purchase_price + $item->pi_purchase_price) / 2;
                    $total_quantity = (check_null($item->ri_total_quantity, 0) + check_null($item->pi_total_quantity, 0));
                    $total_amount   = $total_quantity * $purchase_price;

                    $data[$key]['code']           = $item->code;
                    $data[$key]['name']           = $item->name;
                    $data[$key]['unit']           = $item->unit;
                    $data[$key]['purchase_price'] = $purchase_price;
                    $data[$key]['quantity']       = $total_quantity;
                    $data[$key]['amount']         = $total_amount;

                    $key++;
                } elseif (!empty($item->ri_purchase_price) || !empty($item->pi_purchase_price)) {

                    $purchase_price = (check_null($item->ri_purchase_price, 0) + check_null($item->pi_purchase_price, 0));
                    $total_quantity = (check_null($item->ri_total_quantity, 0) + check_null($item->pi_total_quantity, 0));
                    $total_amount   = $total_quantity * $purchase_price;

                    $data[$key]['code']           = $item->code;
                    $data[$key]['name']           = $item->name;
                    $data[$key]['unit']           = $item->unit;
                    $data[$key]['purchase_price'] = $purchase_price;
                    $data[$key]['quantity']       = $total_quantity;
                    $data[$key]['amount']         = $total_amount;

                    $key++;
                }
            }
        }

        return $data;
    }

    /**
     * Search all data
     */
    public function search()
    {
        // get all result
        $where = ['tbl_packaging.trash' => 0];
        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $value) {
                    if (!empty($value)) {
                        $where["tbl_packaging.$_key"] = $value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $value) {
                    if (!empty($value) && $_key == 'from') {
                        $where["tbl_packaging.created_at >="] = $value;
                    }

                    if (!empty($value) && $_key == 'to') {
                        $where["tbl_packaging.created_at <="] = $value;
                    }
                }
            }
        } else {
            $where["tbl_packaging.created_at"] = date('Y-m-d');
        }

        $tableTo  = ['tbl_packaging_items', 'materials'];
        $joinCond = ['tbl_packaging.voucher_no=tbl_packaging_items.voucher_no', 'tbl_packaging_items.product_code=materials.code'];
        $select   = ['tbl_packaging.*'];
        $data     = get_join('tbl_packaging', $tableTo, $joinCond, $where, $select, ['tbl_packaging_items.voucher_no'], 'id', 'desc');

        return $data;
    }


    /**
     * Preview single voucher
     */
    public function preview($voucher_no = null)
    {
        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all-packaging"';
        $this->data['confirmation'] = null;

        if (!empty($voucher_no)) {
            // get voucher info
            $this->data['info'] = get_join('tbl_packaging_items', 'stock', 'tbl_packaging_items.product_code=stock.code', ['tbl_packaging_items.voucher_no' => $voucher_no, 'tbl_packaging_items.trash' => 0, 'stock.type' => 'raw'], ['tbl_packaging_items.*', 'stock.name']);
        } else {
            redirect('purchase/used/show', 'refresh');
        }

        // load view files
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/preview', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * Packaging Edit Form
     */
    public function edit()
    {
        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="edit"';
        $this->data['confirmation'] = null;


        // load view files
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    /**
     * Store packaging data
     */
    public function store()
    {
        // add packaging
        $data = input_data(['created_at', 'total_quantity', 'total_bill']);

        $id         = save_data('tbl_packaging', $data, '', true);
        $voucher_no = get_voucher($id, 6, 'PKG-');
        save_data('tbl_packaging', ['voucher_no' => $voucher_no], ['id' => $id]);


        // add packaging items
        $data = [];
        if (!empty($_POST['product_code'])) {
            foreach ($_POST['product_code'] as $_key => $value) {
                $data = [
                    'created_at'     => $_POST['created_at'],
                    'product_code'   => $value,
                    'voucher_no'     => $voucher_no,
                    'quantity'       => $_POST['quantity'][$_key],
                    'unit'           => $_POST['unit'][$_key],
                    'purchase_price' => $_POST['purchase_price'][$_key]
                ];
                save_data('tbl_packaging_items', $data);

                $this->stock($_key, 'add');
            }
        }

        // send message
        $options = [
            'title' => 'Success',
            'emit'  => 'Packaging Add Successfully...!',
            'btn'   => true
        ];

        $this->data['confirmation'] = message('success', $options);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('purchase/used/preview/' . $voucher_no, 'refresh');
    }


    /**
     * Update Packaging data
     */
    public function update($voucher_no = null)
    {

        // add packaging
        $data = input_data(['created_at', 'total_quantity', 'total_bill']);
        save_data('tbl_packaging', $data, ['voucher_no' => $voucher_no]);


        // add packaging items
        $data = [];
        if (!empty($_POST['id'])) {
            foreach ($_POST['id'] as $_key => $value) {
                $data = [
                    'created_at'     => $_POST['created_at'],
                    'product_code'   => $_POST['product_code'][$_key],
                    'voucher_no'     => $voucher_no,
                    'quantity'       => $_POST['quantity'][$_key],
                    'unit'           => $_POST['unit'][$_key],
                    'purchase_price' => $_POST['purchase_price'][$_key]
                ];
                save_data('tbl_packaging_items', $data, ['id' => $value]);

                $this->stock($_key, 'edit');
            }
        }
    }


    /**
     * Update Stock
     */
    private function stock($index = null, $action = null)
    {
        if (!empty($action)) {

            // get stock info
            $where     = ['code' => $_POST['product_code'][$index], 'type' => 'raw'];
            $stockInfo = get_row('stock', $where, ['quantity']);
            if (!empty($stockInfo)) {
                if ($action == 'add') {
                    $quantity = $stockInfo->quantity - $_POST['quantity'][$index];
                    save_data('stock', ['quantity' => $quantity], $where);
                } else {
                    $qty      = $_POST['old_quantity'][$index] - $_POST['quantity'][$index];
                    $quantity = $stockInfo->quantity + $qty;
                    save_data('stock', ['quantity' => $quantity], $where);
                }
            }
        }
    }


    /**
     * Delete Data
     */
    public function delete($voucher_no = null)
    {

        if (!empty($voucher_no)) {
            // get recipe items
            $itemsInfo = get_result('tbl_packaging_items', ['voucher_no' => $voucher_no], ['product_code', 'quantity']);

            if (!empty($itemsInfo)) {
                foreach ($itemsInfo as $item) {

                    // get stock info
                    $stockInfo = get_row('stock', ['code' => $item->product_code, 'type' => 'raw'], ['quantity']);
                    if (!empty($stockInfo)) {
                        $quantity = $stockInfo->quantity + $item->quantity;
                    }

                    // update stock
                    save_data('stock', ['quantity' => $quantity], ['code' => $item->product_code, 'type' => 'raw']);
                }

                // update recipe item
                save_data('tbl_packaging_items', ['trash' => 1], ['voucher_no' => $voucher_no]);
            }

            // update packaging
            save_data('tbl_packaging', ['trash' => 1], ['voucher_no' => $voucher_no]);

            // send message
            $options = [
                'title' => 'Delete',
                'emit'  => 'Recipe Successfully Deleted!',
                'btn'   => true
            ];

            $this->data['confirmation'] = message('success', $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('purchase/used/show', 'refresh');
        } else {
            redirect('purchase/used/show', 'refresh');
        }
    }
}