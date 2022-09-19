<?php

class edit_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get all product
        $this->data['productList'] = $this->getAllProduct();

        // get voucher no
        $vno = $this->input->get('vno');

        // get voucher info
        $this->data['info'] = $info = get_row('saprecords', ['voucher_no' => $vno, 'trash' => 0]);

        if (empty($this->data['info'])) redirect('sale/sale/all', 'refresh');


        $partyInfo = [
            'code'    => '',
            'name'    => '',
            'mobile'  => '',
            'address' => '',
            'balance' => 0,
            'sign'    => 'Receivable',
        ];

        if ($info->sap_type == 'cash') {

            $cInfo = json_decode($info->client_info);

            $partyInfo['name']    = $info->party_code;
            $partyInfo['mobile']  = $cInfo->mobile;
            $partyInfo['address'] = $cInfo->address;

        } else {

            $pInfo       = get_row('parties', ['code' => $info->party_code], ['name', 'mobile', 'address']);
            $balanceInfo = get_client_balance($info->party_code, get_name('partytransaction', 'id', ['relation' => $info->voucher_no]));

            $partyInfo['code']    = $info->party_code;
            $partyInfo['name']    = $pInfo->name;
            $partyInfo['mobile']  = $pInfo->mobile;
            $partyInfo['address'] = $pInfo->address;
            $partyInfo['balance'] = $balanceInfo->balance;
            $partyInfo['sign']    = $balanceInfo->status;
        }

        $this->data['partyInfo'] = (object)$partyInfo;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/edit-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function update()
    {
        if (isset($_POST['update'])) {

            $vno = $this->input->post('voucher_no');

            $due = $_POST['total_bill'] - $_POST['paid'];

            $data = [
                'sap_at'         => $this->input->post('sap_at'),
                'total_bill'     => $this->input->post('total_bill'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_discount' => $this->input->post('total_discount'),
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'party_balance'  => $this->input->post('previous_balance'),
                'method'         => $this->input->post('method'),
                'sap_type'       => $this->input->post('sap_type'),
                'remark'         => 'sale',
                'status'         => 'sale',
            ];

            if ($_POST['sap_type'] == 'cash') {

                $cInfo = [
                    'mobile'  => $this->input->post('c_mobile'),
                    'address' => $this->input->post('c_address')
                ];

                $data['party_code']  = $this->input->post('c_name');
                $data['client_info'] = json_encode($cInfo);
            }

            save_data('saprecords', $data, ['voucher_no' => $vno]);


            // store item data
            foreach ($_POST['product_code'] as $key => $product_code) {

                $where = ['id' => $_POST['item_id'][$key]];
                $data  = [];

                $data['sap_at']         = $this->input->post('sap_at');
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['quantity']       = $_POST['quantity'][$key];


                if (empty($_POST['item_id'][$key])) {
                    $where = [];

                    $data['voucher_no']         = $vno;
                    $data['product_code']       = $product_code;
                    $data['production_item_id'] = $_POST['production_item_id'][$key];
                    $data['unit']               = $_POST['unit'][$key];
                    $data['sap_type']           = $_POST['sap_type'];
                    $data['status']             = 'sale';
                }

                save_data('sapitems', $data, $where);

                // add stock
                $this->handelStock($key);
            }

            $this->handelPartyTransaction($vno);
            $this->handelSapMeta($vno);
            $this->deleteItems();

            $msg = [
                'title' => 'update',
                'emit'  => 'Sale update successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));

            redirect('sale/edit_sale?vno=' . $vno, 'refresh');
        }

        redirect('sale/sale', 'refresh');
    }

    // delete items
    private function deleteItems()
    {
        if (!empty($_POST['delete_product_code'])) {
            foreach ($_POST['delete_product_code'] as $key => $code) {

                $stockWhere = ['id' => $_POST['delete_production_item_id'][$key]];
                $stockInfo  = get_row('production_items', $stockWhere, ['quantity', 'sale_quantity']);
                $quantity   = $stockInfo->sale_quantity - $_POST['delete_quantity'][$key];

                save_data('production_items', ['sale_quantity' => $quantity], $stockWhere);

                save_data('sapitems', ['trash' => 1], ['id' => $_POST['delete_item_id'][$key]]);
            }
        }
    }

    // save stock
    private function handelStock($index = null)
    {
        $stockWhere = ['id' => $_POST['production_item_id'][$index]];
        $stockInfo  = get_row('production_items', $stockWhere, ['quantity', 'sale_quantity']);
        $quantity   = $stockInfo->sale_quantity + ($_POST['quantity'][$index] - $_POST['old_quantity'][$index]);

        save_data('production_items', ['sale_quantity' => $quantity], $stockWhere);
    }


    /**
     * handel party transaction
     */
    private function handelPartyTransaction($vno)
    {
        $data = [
            'transaction_at'   => $this->input->post('sap_at'),
            'change_at'        => date('Y-m-d'),
            'previous_balance' => $this->input->post('previous_balance'),
            'debit'            => $this->input->post('total_bill'),
            'credit'           => $this->input->post('paid'),
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
        ];

        if ($_POST['sap_type'] == 'cash') {
            $data['party_code'] = $this->input->post('c_name');
        }

        save_data('partytransaction', $data, ['relation' => $vno]);
    }

    // handel sap meta info
    private function handelSapMeta($vno)
    {
        $data['voucher_no'] = $vno;
        $data['meta_key']   = 'sale_by';
        $data['meta_value'] = $this->data['name'];

        $where = ['voucher_no' => $vno, 'meta_key' => 'sale_by'];

        save_data('sapmeta', $data, $where);
    }

    // ajax get voucher items
    public function getVoucherItems()
    {
        $request = json_decode(file_get_contents("php://input"));
        if (!empty($request->voucher_no)) {

            $where = [
                'sapitems.voucher_no' => $request->voucher_no,
                'sapitems.trash'      => 0,
            ];

            $tableTo  = ['production_items', 'materials'];
            $joinCond = ['sapitems.production_item_id=production_items.id', 'sapitems.product_code=materials.code'];
            $select   = ['sapitems.*', 'SUM(production_items.quantity - production_items.sale_quantity) AS stock_qty', 'materials.name'];

            $itemList = get_left_join('sapitems', $tableTo, $joinCond, $where, $select, 'sapitems.id');
            if (!empty($itemList)) {
                $results = [];
                foreach ($itemList as $row) {
                    $item = [];

                    $item['item_id']            = $row->id;
                    $item['production_item_id'] = $row->production_item_id;
                    $item['product_code']       = $row->product_code;
                    $item['product_name']       = $row->name;
                    $item['unit']               = $row->unit;
                    $item['stock_qty']          = $row->stock_qty;
                    $item['purchase_price']     = $row->purchase_price;
                    $item['sale_price']         = $row->sale_price;
                    $item['old_quantity']       = $row->quantity;
                    $item['quantity']           = $row->quantity;
                    $item['subtotal']           = 0;

                    array_push($results, (object)$item);
                }

                echo json_encode($results);
            }
        }
    }

    // all available finish products
    private function getAllProduct()
    {
        $where = [
            'production_items.quantity >' => 'production_items.sale_quantity',
            'production_items.status'     => 'to',
            'production_items.trash'      => 0
        ];

        $select  = ['production_items.id', 'production_items.batch_no', 'SUM(production_items.quantity - production_items.sale_quantity) AS quantity', 'production_items.product_code', 'materials.name', 'materials.unit'];
        $results = get_left_join('production_items', 'materials', 'production_items.product_code=materials.code', $where, $select, 'production_items.id', 'production_items.batch_no', 'asc');

        return $results;
    }
}
