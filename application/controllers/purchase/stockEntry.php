<?php

class StockEntry extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['orderList'] = get_join('orders', 'parties', 'orders.party_code=parties.code', ['orders.status' => 'pending', 'orders.trash' => 0], ['orders.voucher_no', 'parties.name', 'parties.address']);
        $this->data['partyList']   = get_result('parties', ['type' => 'supplier', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);
        
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    /**
     * show all order
     */
    public function index()
    {
        $this->data['subMenu']      = 'data-target="allStockEntry"';
        $this->data['confirmation'] = null;

        $where = [
            'saprecords.status'    => 'purchase',
            'saprecords.sale_type' => 'order_purchase',
            'saprecords.trash'     => 0,
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['saprecords.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['dateFrom'])) {
                $where['saprecords.sap_at >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['saprecords.sap_at <='] = $_POST['dateTo'];
            }
        } else {
            $where['saprecords.sap_at'] = date('Y-m-d');
        }

        $tableTo  = ['parties'];
        $joinCond = ['saprecords.party_code=parties.code'];
        $select   = ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address'];

        $this->data['results'] = get_left_join('saprecords', $tableTo, $joinCond, $where, $select);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/stockEntry/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * show create form
     */
    public function create()
    {
        $this->data['subMenu']      = 'data-target="stockEntry"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/stockEntry/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['save'])) {

            $date = $this->input->post('sap_at');
            $due  = $this->input->post('total_bill') - $this->input->post('paid');

            $data = [
                'sap_at'         => $date,
                'pr_no'          => $this->input->post('pr_no'),
                'order_no'       => $this->input->post('order_no'),
                'party_code'     => $this->input->post('party_code'),
                'total_bill'     => $this->input->post('total_bill'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_discount' => $this->input->post('total_discount'),
                'transport_cost' => $this->input->post('transport_cost'),
                'party_balance'  => $this->input->post('previous_balance'),
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'comment'        => $this->input->post('comment'),
                'sale_type'      => 'order_purchase',
                'status'         => 'purchase',
                'sap_type'       => 'raw'
            ];

            $id  = save_data('saprecords', $data, '', true);
            $vno = get_voucher($id, 6, 'P');
            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

            // insert purchase record
            foreach ($_POST['product_code'] as $key => $value) {

                $data = [];
                
                if($_POST['quantity'][$key] > 0){

                    $data['sap_at']             = $date;
                    $data['voucher_no']         = $vno;
                    $data['product_code']       = $_POST['product_code'][$key];
                    $data['order_item_id']      = $_POST['order_item_id'][$key];
                    $data['purchase_price']     = $_POST['purchase_price'][$key];
                    $data['sale_price']         = $_POST['sale_price'][$key];
                    $data['unit']               = $_POST['unit'][$key];
                    $data['remaining_quantity'] = $_POST['remaining_quantity'][$key];
                    $data['quantity']           = $_POST['quantity'][$key];
                    $data['status']             = 'purchase';
                    $data['sap_type']           = 'raw';
    
                    if ($_POST['purchase_price'][$key] == 0 && $_POST['quantity'][$key] > 0) {
                        $data['remark'] = 'free';
                    }
    
                    save_data('sapitems', $data);
                    $this->handelStock($key);
                }
            }

            $this->handelPartyTransaction($vno);
            $this->handelSapMeta($vno);
            $this->handelOrderItem();

            $msg = [
                'title' => 'success',
                'emit'  => 'Raw Material\'s Purchase successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect("purchase/order_purchase/create", "refresh");
    }

    /**
     * handel order item
     */
    private function handelOrderItem()
    {
        if (!empty($_POST['order_item_id'])) {
            foreach ($_POST['order_item_id'] as $key => $id) {
                
                if($_POST['quantity'][$key] > 0){

                    $data = ['received_quantity' => $_POST['received_quantity'][$key]];
    
                    if ($_POST['remaining_quantity'][$key] == 0) {
                        $data['status'] = 'complete';
                    }
    
                    save_data('order_items', $data, ['id' => $id]);
                }
            }
        }

        $itemInfo = get_row('order_items', ['voucher_no' => $_POST['order_no'], 'status' => 'pending', 'trash' => 0]);
        if (empty($itemInfo)) {
            save_data('orders', ['status' => 'complete'], ['voucher_no' => $_POST['order_no']]);
        }
    }

    /**
     * handel stock
     */
    private function handelStock($index)
    {
        $where = ['code' => $_POST['product_code'][$index], 'type' => 'raw'];

        $stockInfo = get_row('stock', $where, ['quantity', 'purchase_price']);

        if (!empty($stockInfo)) {

            $totalAmount   = ($stockInfo->purchase_price * $stockInfo->quantity) + $_POST['subtotal'][$index];
            $totalQty      = $stockInfo->quantity + $_POST['quantity'][$index];
            $purchasePrice = $totalAmount / $totalQty;

            $data = [
                'purchase_price' => $purchasePrice,
                'sell_price'     => $_POST['sale_price'][$index],
                'dealer_price'   => $_POST['dealer_price'][$index],
                'quantity'       => $totalQty,
            ];

        } else {

            $where = [];

            $data = [
                'code'           => $_POST['product_code'][$index],
                'name'           => $_POST['product'][$index],
                'unit'           => $_POST['unit'][$index],
                'quantity'       => $_POST['quantity'][$index],
                'purchase_price' => $_POST['purchase_price'][$index],
                'sell_price'     => $_POST['sale_price'][$index],
                'dealer_price'   => $_POST['dealer_price'][$index],
                'type'           => 'raw'
            ];
        }

        save_data('stock', $data, $where);
    }

    /**
     * handel party transaction
     */
    private function handelPartyTransaction($vno)
    {
        $data = [
            'transaction_at'   => $this->input->post('date'),
            'party_code'       => $this->input->post('party_code'),
            'previous_balance' => $this->input->post('previous_balance'),
            'debit'            => $this->input->post('paid'),
            'credit'           => $this->input->post('total_bill'),
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
            'relation'         => $vno,
            'remark'           => 'purchase',
            'status'           => 'purchase'
        ];

        save_data('partytransaction', $data);
    }

    // handel sap meta info
    private function handelSapMeta($vno)
    {
        $data['meta_key']   = 'purchase_by';
        $data['meta_value'] = $this->data['name'];
        $data['voucher_no'] = $vno;

        save_data('sapmeta', $data);
    }


    /**
     * show voucher
     */
    public function show()
    {
        $this->data['subMenu']      = 'data-target="allStockEntry"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'saprecords.voucher_no' => $vno,
            'saprecords.status'     => 'purchase',
            'saprecords.trash'      => 0
        ];

        $this->data['voucherInfo'] = get_row_join('saprecords', 'parties', 'saprecords.party_code=parties.code', $where, ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address']);


        $where = [
            'sapitems.voucher_no' => $vno,
            'sapitems.status'     => 'purchase',
            'materials.type'      => 'raw',
            'sapitems.trash'      => 0,
        ];

        $this->data['itemList'] = get_left_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $where, ['sapitems.*', 'materials.name']);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/stockEntry/show', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Delete data
     */
    public function delete()
    {
        $vno = $this->input->get('vno');

        if (!empty($vno)) {

            $voucherInfo = get_row('saprecords', ['voucher_no' => $vno, 'trash' => 0], ['order_no']);
            $results     = get_result('sapitems', ['voucher_no' => $vno, 'trash' => 0], ['order_item_id', 'product_code', 'quantity', 'sap_type']);

            if (!empty($results)) {
                foreach ($results as $key => $row) {

                    $where = [
                        'code' => $row->product_code,
                        'type' => $row->sap_type,
                    ];

                    $stockInfo = get_row('stock', $where, 'quantity');
                    $quantity  = $stockInfo->quantity - $row->quantity;

                    save_data('stock', ['quantity' => $quantity], $where);

                    // update order item
                    $orderInfo = get_row('order_items', ['id' => $row->order_item_id], 'received_quantity');
                    if (!empty($orderInfo)) {
                        $receivedQty = $orderInfo->received_quantity - $row->quantity;
                        save_data('order_items', ['received_quantity' => $receivedQty, 'status' => 'pending'], ['id' => $row->order_item_id]);
                    }
                }
            }

            // update order table
            save_data('orders', ['status' => 'pending'], ['voucher_no' => $voucherInfo->order_no]);

            //update three tables
            save_data('sapitems', ['trash' => 1], ['voucher_no' => $vno, 'trash' => 0]);
            save_data('saprecords', ['trash' => 1], ['voucher_no' => $vno, 'trash' => 0]);
            save_data('partytransaction', ['trash' => 1], ['relation' => $vno, 'trash' => 0]);


            $msg = [
                'title' => 'delete',
                'emit'  => 'Purchase delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('deleted', message('success', $msg));
        }

        redirect('purchase/order_purchase', 'refresh');
    }

    /**
     * create cart product list
     */
    public function cartList()
    {
        $request = json_decode(file_get_contents("php://input"));

        $cart = [];
        if (!empty($request->voucher_no)) {

            $where       = ['order_items.voucher_no' => $request->voucher_no, 'order_items.trash' => 0];
            $select      = ['order_items.*', 'materials.name', 'materials.unit', 'materials.sale_price', 'materials.dealer_price', 'materials.type', 'materials.category_id'];
            $productList = get_join('order_items', 'materials', 'order_items.product_code=materials.code', $where, $select);

            if (!empty($productList)) {
                foreach ($productList as $row) {
                    $orderItem = [];

                    $quantity = $row->quantity - $row->received_quantity;

                    if ($quantity > 0) {
                        $orderItem['order_item_id']          = $row->id;
                        $orderItem['product']                = $row->name;
                        $orderItem['product_code']           = $row->product_code;
                        $orderItem['unit']                   = $row->unit;
                        $orderItem['type']                   = $row->type;
                        $orderItem['category_id']            = $row->category_id;
                        $orderItem['purchase_price']         = $row->purchase_price;
                        $orderItem['sale_price']             = $row->sale_price;
                        $orderItem['dealer_price']           = $row->dealer_price;
                        $orderItem['maxQty']                 = $quantity;
                        $orderItem['order_quantity']         = $row->quantity;
                        $orderItem['old_received_quantity']  = $row->received_quantity;
                        $orderItem['received_quantity']      = 0;
                        $orderItem['quantity']               = '';
                        $orderItem['old_remaining_quantity'] = $quantity;
                        $orderItem['remaining_quantity']     = 0;
                        $orderItem['discount']               = 0;
                        $orderItem['subtotal']               = 0;

                        array_push($cart, (object)$orderItem);
                    }
                }

                $partyInfo   = custom_query("SELECT * FROM parties WHERE code IN(SELECT party_code FROM orders WHERE voucher_no='$request->voucher_no')", true);
                $balanceInfo = get_supplier_balance($partyInfo->code);

                $results = [
                    'cart'             => $cart,
                    'party_code'       => $partyInfo->code,
                    'name'             => $partyInfo->name,
                    'mobile'           => $partyInfo->mobile,
                    'address'          => $partyInfo->address,
                    'previous_balance' => $balanceInfo->balance,
                    'previous_sign'    => $balanceInfo->status,
                ];

                echo json_encode($results);
            }
        }
    }
}