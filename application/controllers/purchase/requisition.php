<?php

class Requisition extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['productList'] = get_result('materials', ['type !=' => 'finish_product', 'status' => 'available', 'trash' => 0], ['code', 'name']);

        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    /**
     * show all order
     */
    public function index()
    {
        $this->data['subMenu']      = 'data-target="allRequisition"';
        $this->data['confirmation'] = null;

        $where = [
            'orders.order_type' => 'requisition',
            'orders.trash'      => 0
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['orders.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['dateFrom'])) {
                $where['orders.created >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['orders.created <='] = $_POST['dateTo'];
            }
        } else {
            $where['orders.created'] = date('Y-m-d');
        }

        $tableTo  = ['parties'];
        $joinCond = ['orders.party_code=parties.code'];
        $select   = ['orders.*', 'parties.name', 'parties.mobile', 'parties.address'];

        $this->data['results'] = get_left_join('orders', $tableTo, $joinCond, $where, $select);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/requisition/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * show create form
     */
    public function create()
    {
        $this->data['subMenu']      = 'data-target="requisition"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/requisition/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['save'])) {

            $prefix      = '';
            $productType = $this->input->post('product_type');

            if ($productType == 'raw_materials') {
                $prefix = 'RM/';
            } elseif ($productType == 'electrical') {
                $prefix = 'Elect/';
            } elseif ($productType == 'mechanical') {
                $prefix = 'Mech/';
            } elseif ($productType == 'general') {
                $prefix = 'Gen/';
            }

            $vno = 'Indent/' . $prefix . rand(100000, 999999);
            while (check_exists('orders', ['voucher_no' => $vno, 'trash' => 0])) {
                $vno = 'Indent/' . $prefix . rand(1000, 9999);
            }

            $created = $this->input->post('created');

            $data = [
                'created'        => $created,
                'voucher_no'     => $vno,
                'product_type'   => $this->input->post('product_type'),
                'total_quantity' => $this->input->post('total_quantity'),
                'remarks'        => $this->input->post('remarks'),
                'order_type'     => 'requisition',
                'prepared_by'    => $this->data['user_id'],
            ];

            save_data('orders', $data);

            // store order items
            foreach ($_POST['product_code'] as $key => $product_code) {

                $data = [];

                $data['voucher_no']       = $vno;
                $data['product_code']     = $product_code;
                $data['previous_item_id'] = $_POST['previous_item_id'][$key];
                $data['current_stock']    = $_POST['stock_qty'][$key];
                $data['quantity']         = $_POST['quantity'][$key];
                $data['purchase_price']   = $_POST['previous_price'][$key];
                $data['order_type']       = 'requisition';

                save_data('order_items', $data);
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Requisition add Successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        redirect("purchase/requisition/create", "refresh");
    }

    /**
     * show voucher
     */
    public function edit()
    {
        $this->data['subMenu']      = 'data-target="allRequisition"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'voucher_no' => $vno,
            'trash'      => 0
        ];

        $this->data['info'] = get_row('orders', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/requisition/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * update data
     */
    public function update()
    {
        if (isset($_POST['update'])) {

            $created = $this->input->post('created');
            $vno     = $this->input->post('voucher_no');

            $data = [
                'created'        => $created,
                'voucher_no'     => $vno,
                'total_quantity' => $this->input->post('total_quantity'),
                'remarks'        => $this->input->post('remarks'),
            ];

            save_data('orders', $data, ['voucher_no' => $vno]);

            // store order items
            foreach ($_POST['product_code'] as $key => $product_code) {

                $data = $itemWhere = [];

                $data['quantity']       = $_POST['quantity'][$key];
                $data['purchase_price'] = $_POST['previous_price'][$key];

                if (empty($_POST['item_id'][$key])) {

                    $data['voucher_no']       = $vno;
                    $data['product_code']     = $product_code;
                    $data['previous_item_id'] = $_POST['previous_item_id'][$key];
                    $data['current_stock']    = $_POST['stock_qty'][$key];
                    $data['order_type']       = 'requisition';
                } else {
                    $itemWhere['id'] = $_POST['item_id'][$key];
                }

                save_data('order_items', $data, $itemWhere);
            }

            // delete item
            if (!empty($_POST['delete_id'])) {
                foreach ($_POST['delete_id'] as $key => $id) {
                    save_data('order_items', ['trash' => 1], ['id' => $id]);
                }
            }

            $msg = [
                'title' => 'update',
                'emit'  => 'Requisition update Successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));

            redirect("purchase/requisition/edit?vno=" . $vno, "refresh");
        }

        redirect("purchase/requisition", "refresh");
    }

    /**
     * show voucher
     */
    public function show()
    {
        $this->data['subMenu']      = 'data-target="allRequisition"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'voucher_no' => $vno,
            'trash'      => 0
        ];

        $this->data['voucherInfo'] = get_row('orders', $where);

        $where = [
            'order_items.voucher_no' => $vno,
            'order_items.trash'      => 0,
        ];

        $select = ['order_items.*', 'materials.name', 'materials.specification', 'materials.unit'];

        $this->data['itemList'] = get_left_join('order_items', 'materials', 'order_items.product_code=materials.code', $where, $select);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/requisition/show', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Delete data
     */
    public function delete()
    {
        $vno = $this->input->get('vno');

        if (!empty($vno)) {

            $where = ['voucher_no' => $vno, 'trash' => 0];
            $data  = ['trash' => 1];

            //update three tables
            save_data('orders', $data, $where);
            save_data('order_items', $data, $where);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Requisition delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('purchase/requisition', 'refresh');
    }

    /**
     * add new cart item
     */
    public function cartItem()
    {
        $request = json_decode(file_get_contents("php://input"));

        if (!empty($request->product_code)) {

            $productInfo = get_row('materials', ['code' => $request->product_code]);

            if (!empty($productInfo)) {

                $lastPurchaseInfo = custom_query("SELECT id, sap_at, voucher_no, purchase_price FROM `sapitems` WHERE product_code='$request->product_code' AND status='purchase' AND trash=0 ORDER BY sap_at DESC", true);

                $previousDate = $previousPrice = $previousVendor = $previousItemId = '';
                if (!empty($lastPurchaseInfo)) {
                    $previousDate   = $lastPurchaseInfo->sap_at;
                    $previousPrice  = $lastPurchaseInfo->purchase_price;
                    $previousItemId = $lastPurchaseInfo->id;
                    $previousVendor = custom_query("SELECT name FROM `parties` WHERE code IN (SELECT party_code FROM `saprecords` WHERE voucher_no='$lastPurchaseInfo->voucher_no' AND trash=0)", true)->name;
                } else {
                    $previousPrice = $productInfo->purchase_price;
                }

                $stockQty = get_name('stock', 'quantity', ['code' => $productInfo->code]);

                $data = [
                    'item_id'          => '',
                    'previous_item_id' => $previousItemId,
                    'code'             => $productInfo->code,
                    'product'          => $productInfo->name,
                    'specification'    => $productInfo->specification,
                    'category_id'      => $productInfo->category_id,
                    'category_name'    => get_name('category', 'category', ['id' => $productInfo->category_id]),
                    'unit'             => $productInfo->unit,
                    'purchase_price'   => $productInfo->purchase_price,
                    'sale_price'       => $productInfo->sale_price,
                    'stock_qty'        => round($stockQty, 2),
                    'old_quantity'     => '',
                    'quantity'         => '',
                    'previous_date'    => $previousDate,
                    'previous_price'   => round($previousPrice, 2),
                    'previous_vendor'  => $previousVendor,
                ];

                echo json_encode($data);
            }
        }
    }

    /**
     * edit cart item list
     */
    public function editCartItem()
    {

        $request = json_decode(file_get_contents("php://input"));

        if (!empty($request->voucher_no)) {

            $data = [];

            $where    = ['order_items.voucher_no' => $request->voucher_no, 'order_items.trash' => 0];
            $select   = ['order_items.*', 'materials.name', 'materials.specification', 'materials.category_id', 'materials.unit', 'materials.sale_price'];
            $itemList = get_left_join('order_items', 'materials', 'order_items.product_code=materials.code', $where, $select);

            if (!empty($itemList)) {
                foreach ($itemList as $row) {

                    $lastPurchaseInfo = custom_query("SELECT id, sap_at, voucher_no, purchase_price FROM `sapitems` WHERE id='$row->previous_item_id' AND status='purchase' AND trash=0 ORDER BY sap_at DESC", true);

                    $previousDate = $previousPrice = $previousVendor = $previousItemId = '';
                    if (!empty($lastPurchaseInfo)) {
                        $previousDate   = $lastPurchaseInfo->sap_at;
                        $previousPrice  = $lastPurchaseInfo->purchase_price;
                        $previousItemId = $lastPurchaseInfo->id;
                        $previousVendor = custom_query("SELECT name FROM `parties` WHERE code IN (SELECT party_code FROM `saprecords` WHERE voucher_no='$lastPurchaseInfo->voucher_no' AND trash=0)", true)->name;
                    } else {
                        $previousPrice = $row->purchase_price;
                    }

                    $item = [
                        'item_id'          => $row->id,
                        'previous_item_id' => $previousItemId,
                        'code'             => $row->product_code,
                        'product'          => $row->name,
                        'specification'    => $row->specification,
                        'category_id'      => $row->category_id,
                        'category_name'    => get_name('category', 'category', ['id' => $row->category_id]),
                        'unit'             => $row->unit,
                        'purchase_price'   => $row->purchase_price,
                        'sale_price'       => $row->sale_price,
                        'stock_qty'        => $row->current_stock,
                        'old_quantity'     => $row->quantity,
                        'quantity'         => $row->quantity,
                        'previous_date'    => $previousDate,
                        'previous_price'   => round($previousPrice, 2),
                        'previous_vendor'  => $previousVendor,
                    ];

                    array_push($data, (object)$item);
                }
            }

            echo json_encode($data);
        }
    }
}