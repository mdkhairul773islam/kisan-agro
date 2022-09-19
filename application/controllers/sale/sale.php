<?php

class Sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // get all product
        $this->data['productList'] = $this->getAllProduct();

        // get all client
        $this->data['clientList'] = $this->getAllClient();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/add-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store()
    {
        if (isset($_POST['save'])) {

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

                $data['payment_status'] = ($due > 0 ? 'due' : 'paid');
                $data['party_code']     = $this->input->post('c_name');
                $data['client_info']    = json_encode($cInfo);
            } else {

                $data['party_code'] = $this->input->post('party_code');
            }

            $id  = save_data('saprecords', $data, '', true);
            $vno = get_voucher($id, 6, 'S');
            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

            // store item data
            foreach ($_POST['product_code'] as $key => $product_code) {

                $data = [];

                $data['sap_at']             = $this->input->post('sap_at');
                $data['voucher_no']         = $vno;
                $data['product_code']       = $product_code;
                $data['production_item_id'] = $_POST['production_item_id'][$key];
                $data['purchase_price']     = $_POST['purchase_price'][$key];
                $data['sale_price']         = $_POST['sale_price'][$key];
                $data['quantity']           = $_POST['quantity'][$key];
                $data['unit']               = $_POST['unit'][$key];
                $data['sap_type']           = $_POST['sap_type'];
                $data['status']             = 'sale';

                save_data('sapitems', $data);

                // add stock
                $this->handelStock($key);
            }

            $this->handelPartyTransaction($vno);
            $this->handelSapMeta($vno);

            $msg = [
                'title' => 'success',
                'emit'  => 'Sale add successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));

            //redirect('sale/sale/preview?vno=' . $vno, 'refresh');
            redirect('sale/sale', 'refresh');
        }

        redirect('sale/sale', 'refresh');
    }

    // save stock
    private function handelStock($index = null)
    {
        $stockWhere = ['id' => $_POST['production_item_id'][$index]];
        $stockInfo  = get_row('production_items', $stockWhere, ['quantity', 'sale_quantity']);
        $quantity   = $stockInfo->sale_quantity + $_POST['quantity'][$index];

        save_data('production_items', ['sale_quantity' => $quantity], $stockWhere);
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
            'debit'            => $this->input->post('total_bill'),
            'credit'           => $this->input->post('paid'),
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
            'relation'         => $vno,
            'remark'           => 'sale',
            'status'           => 'sale'
        ];

        if ($_POST['sap_type'] == 'cash') {
            $data['party_code'] = $this->input->post('c_name');
        } else {
            $data['party_code'] = $this->input->post('party_code');
        }

        save_data('partytransaction', $data);
    }

    // handel sap meta info
    private function handelSapMeta($vno)
    {
        $data['meta_key']   = 'sale_by';
        $data['meta_value'] = $this->data['name'];
        $data['voucher_no'] = $vno;

        save_data('sapmeta', $data);
    }


    // all sale
    public function all()
    {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;

        $where = [
            'status' => 'sale',
            'trash'  => 0,
        ];

        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where[$key] = $val;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['sap_at >='] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['sap_at <='] = $val;
                }
            }
        } else {
            $where['sap_at'] = date('Y-m-d');
        }

        $this->data['result'] = get_result('saprecords', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/all-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // preview voucher
    public function preview()
    {
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $where = [
            'voucher_no' => $_GET['vno'],
            'status'     => 'sale',
            'trash'      => 0
        ];

        $this->data['result'] = get_row('saprecords', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/view_sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // item wise search
    public function item_wise()
    {

        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
        $this->data['subMenu']    = 'data-target="itemWise"';

        // get all product
        $this->data['productList'] = get_result('materials', ['status' => 'available', 'trash' => 0], ['code', 'name']);

        // get all client
        $this->data['clientList'] = $this->getAllClient();


        $where = [
            "materials.type"  => "finish_product",
            "sapitems.status" => "sale",
            "sapitems.trash"  => 0,
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['party_code'])) {
                $where["saprecords.party_code"] = $_POST['party_code'];
            }

            if (!empty($_POST['product_code'])) {
                $where["sapitems.product_code"] = $_POST['product_code'];
            }

            if (!empty($_POST['sap_type'])) {
                $where["sapitems.sap_type"] = $_POST['sap_type'];
            }

            $where["sapitems.sap_at >="] = (!empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-d'));
            $where["sapitems.sap_at <="] = (!empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d'));

        } else {
            $where["sapitems.sap_at"] = date('Y-m-d');
        }


        $tableTo  = ['materials', 'saprecords'];
        $joinCond = ['sapitems.product_code=materials.code', 'sapitems.voucher_no=saprecords.voucher_no'];
        $select   = ['sapitems.sap_at', 'sapitems.voucher_no', 'sapitems.product_code', 'sapitems.quantity', 'sapitems.purchase_price', 'sapitems.sale_price', 'materials.name', 'saprecords.party_code', 'saprecords.sap_type'];

        $this->data["results"] = get_join('sapitems', $tableTo, $joinCond, $where, $select);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/itemWise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // delete data
    public function delete()
    {
        $vno   = $this->input->get('vno');
        $where = ['voucher_no' => $vno, 'trash' => 0];

        $items = get_result('sapitems', $where);

        if (!empty($items)) {
            foreach ($items as $key => $row) {

                $stockWhere = ['id' => $row->production_item_id];
                $stockInfo  = get_row('production_items', $stockWhere, ['quantity', 'sale_quantity']);
                $quantity   = $stockInfo->sale_quantity - $row->quantity;

                save_data('production_items', ['sale_quantity' => $quantity], $stockWhere);
            }
        }

        $data = ['trash' => 1];

        save_data('sapitems', $data, $where);
        save_data('saprecords', $data, $where);
        save_data('sapmeta', $data, $where);
        save_data('partytransaction', $data, ['relation' => $vno, 'trash' => 0]);

        $msg = [
            'title' => 'success',
            'emit'  => 'Client add successful.',
            'btn'   => true
        ];

        $this->session->set_flashdata("confirmation", message('success', $msg));

        redirect('sale/sale/all', 'refresh');
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

    // all clients
    private function getAllClient()
    {
        $where = [
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        ];

        $results = get_result('parties', $where, ['code', 'name', 'address']);

        return $results;
    }
}
