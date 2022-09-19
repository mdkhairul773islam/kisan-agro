<?php

class PurchaseOrder extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['partyList'] = get_result('parties', ['type' => 'supplier', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
        //$this->data['indentList'] = custom_query("SELECT created, voucher_no FROM `orders` WHERE prepared_by IS NOT NULL AND checked_by IS NOT NULL AND authorised_by IS NOT NULL AND trash=0 AND order_type='requisition' AND status='pending'");
        $this->data['indentList'] = custom_query("SELECT created, voucher_no FROM `orders` WHERE prepared_by IS NOT NULL AND trash=0 AND order_type='requisition' AND status='pending'");

        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    /**
     * show all order
     */
    public function index()
    {
        $this->data['subMenu']      = 'data-target="allPurchaseOrder"';
        $this->data['confirmation'] = null;

        $where = [
            'orders.order_type' => 'purchase_order',
            'orders.trash'      => 0,
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
        $this->load->view('components/purchase/purchaseOrder/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * show create form
     */
    public function create()
    {
        $this->data['subMenu']      = 'data-target="purchaseOrder"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/purchaseOrder/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['save'])) {

            $referenceNo = $this->input->post('reference_no');

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

            $vno = 'PO/' . $prefix . rand(100000, 999999);
            while (check_exists('orders', ['voucher_no' => $vno, 'trash' => 0])){
                $vno = 'PO/' . $prefix . rand(1000, 9999);
            }

            $created     = $this->input->post('created');


            $data = [
                'created'        => $created,
                'voucher_no'     => $vno,
                'reference_no'   => $referenceNo,
                'product_type'   => get_name('orders', 'product_type', ['voucher_no' => $referenceNo, 'trash' => 0]),
                'total_quantity' => $this->input->post('total_quantity'),
                'remarks'        => $this->input->post('remarks'),
                'order_type'     => 'purchase_order',
                'prepared_by'    => $this->data['user_id'],
            ];

            save_data('orders', $data);

            // store order items
            foreach ($_POST['product_code'] as $key => $product_code) {

                $data = [];

                $data['voucher_no']       = $vno;
                $data['reference_no']     = $referenceNo;
                $data['product_code']     = $product_code;
                $data['previous_item_id'] = $_POST['previous_item_id'][$key];
                $data['due_on']           = $_POST['due_on'][$key];
                $data['quantity']         = $_POST['quantity'][$key];
                $data['purchase_price']   = $_POST['purchase_price'][$key];
                $data['discount_per']     = $_POST['discount_per'][$key];
                $data['discount']         = $_POST['discount'][$key];
                $data['order_type']       = 'purchase_order';

                save_data('order_items', $data);
            }

            // store meta info
            if (!empty($_POST['meta'])) {
                foreach ($_POST['meta'] as $key => $value) {
                    if (!empty($value)) {

                        $data = [
                            'voucher_no' => $vno,
                            'meta_key'   => $key,
                            'meta_value' => $value
                        ];

                        save_data('order_meta', $data);
                    }
                }
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Requisition add Successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect("purchase/purchaseOrder/create", "refresh");
    }

    /**
     * show voucher
     */
    public function edit()
    {
        $this->data['subMenu']      = 'data-target="allPurchaseOrder"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'orders.voucher_no' => $vno,
            'orders.trash'      => 0
        ];

        $this->data['info'] = get_row_join('orders', 'parties', 'orders.party_code=parties.code', $where, ['orders.*', 'parties.name', 'parties.mobile', 'parties.address']);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/purchaseOrder/edit', $this->data);
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
                'pr_no'          => $this->input->post('pr_no'),
                'total_bill'     => $this->input->post('total_bill'),
                'total_quantity' => $this->input->post('total_quantity'),
                'remarks'        => $this->input->post('remarks'),
            ];

            save_data('orders', $data, ['voucher_no' => $vno]);

            // store order items
            foreach ($_POST['product_code'] as $key => $product_code) {

                $where = ['id' => $_POST['item_id'][$key]];
                $data  = [];

                $data['product_code']   = $_POST['product_code'][$key];
                $data['quantity']       = $_POST['quantity'][$key];
                $data['purchase_price'] = $_POST['purchase_price'][$key];

                if (empty($_POST['item_id'][$key])) {
                    $where              = [];
                    $data['voucher_no'] = $vno;
                }

                save_data('order_items', $data, $where);
            }

            // delete item
            if (!empty($_POST['delete_id'])) {
                foreach ($_POST['delete_id'] as $key => $id) {
                    save_data('order_items', ['trash' => 1], ['id' => $id]);
                }
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Raw Material\'s Order Successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));

            redirect("purchase/purchaseOrder/edit?vno=" . $vno, "refresh");
        }
        redirect("purchase/order", "refresh");
    }

    /**
     * show voucher
     */
    public function show()
    {
        $this->data['subMenu']      = 'data-target="allPurchaseOrder"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'orders.voucher_no' => $vno,
            'orders.trash'      => 0
        ];

        $this->data['voucherInfo'] = get_row_join('orders', 'parties', 'orders.party_code=parties.code', $where, ['orders.*', 'parties.name', 'parties.mobile', 'parties.address']);


        $where = [
            'order_items.voucher_no' => $vno,
            'order_items.trash'      => 0,
            'materials.type'         => 'raw',
        ];

        $this->data['itemList'] = get_left_join('order_items', 'materials', 'order_items.product_code=materials.code', $where, ['order_items.*', 'materials.name', 'materials.sale_price']);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/purchaseOrder/show', $this->data);
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
                'emit'  => 'Order delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('purchase/order', 'refresh');
    }


    /**
     * add cart item
     */
    public function cartItem()
    {
        $request = json_decode(file_get_contents("php://input"));

        if (!empty($request->reference_no)) {

            $data = [];

            $where    = ['order_items.voucher_no' => $request->reference_no, 'order_items.trash' => 0];
            $select   = ['order_items.*', 'materials.name', 'materials.specification', 'materials.category_id', 'materials.unit', 'materials.sale_price'];
            $itemList = get_left_join('order_items', 'materials', 'order_items.product_code=materials.code', $where, $select);

            if (!empty($itemList)) {
                foreach ($itemList as $row) {

                    $item = [
                        'item_id'               => '',
                        'reference_no'          => $row->voucher_no,
                        'previous_item_id'      => $row->id,
                        'due_on'                => '',
                        'code'                  => $row->product_code,
                        'product'               => $row->name,
                        'specification'         => $row->specification,
                        'category_id'           => $row->category_id,
                        'category_name'         => get_name('category', 'category', ['id' => $row->category_id]),
                        'unit'                  => $row->unit,
                        'purchase_price'        => $row->purchase_price,
                        'sale_price'            => $row->sale_price,
                        'old_quantity'          => 0,
                        'quantity'              => $row->quantity,
                        'old_received_quantity' => 0,
                        'received_quantity'     => $row->received_quantity,
                        'discount_per'          => 0,
                        'discount'              => 0,
                        'subtotal'              => 0,
                    ];

                    array_push($data, (object)$item);
                }
            }

            echo json_encode($data);
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

                    $quantity = $row->quantity - $row->received_quantity;

                    if ($quantity > 0) {

                        $item = [
                            'item_id'               => $row->id,
                            'reference_no'          => $row->reference_no,
                            'previous_item_id'      => $row->previous_item_id,
                            'due_on'                => $row->due_on,
                            'code'                  => $row->product_code,
                            'product'               => $row->name,
                            'specification'         => $row->specification,
                            'category_id'           => $row->category_id,
                            'category_name'         => get_name('category', 'category', ['id' => $row->category_id]),
                            'unit'                  => $row->unit,
                            'purchase_price'        => $row->purchase_price,
                            'sale_price'            => $row->sale_price,
                            'old_quantity'          => $quantity,
                            'quantity'              => $quantity,
                            'old_received_quantity' => $row->received_quantity,
                            'received_quantity'     => $row->received_quantity,
                            'discount_per'          => 0,
                            'discount'              => 0,
                            'subtotal'              => 0,
                        ];

                        array_push($data, (object)$item);
                    }
                }
            }

            echo json_encode($data);
        }
    }
}