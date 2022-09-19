<?php class Purchase extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->data['productList'] = get_result('materials', ['type !=' => 'finish_product', 'status' => 'available', 'trash' => 0], ['code', 'name']);
    }

    public function index() {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        // get all party
        $this->data['allParty'] = $this->getAllParty();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store() {
        if (isset($_POST['save'])) {

            $due = $this->input->post('grand_total') - $this->input->post('paid');

            $data = [
                'sap_at'         => $this->input->post('date'),
                'party_code'     => $this->input->post('party_code'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_discount' => $this->input->post('total_discount'),
                'transport_cost' => $this->input->post('transport_cost'),
                'party_balance'  => $this->input->post('previous_balance'),
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'comment'        => $this->input->post('comment'),
                'status'         => 'purchase',
                'sap_type'       => 'raw'
            ];

            $id  = save_data('saprecords', $data, '', true);
            $vno = get_voucher($id, 6, 'P');
            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

            // insert purchase record
            foreach ($_POST['product_code'] as $key => $value) {

                $data = [];

                $data['sap_at']         = $this->input->post('date');
                $data['voucher_no']     = $vno;
                $data['product_code']   = $_POST['product_code'][$key];
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['unit']           = $_POST['unit'][$key];
                $data['discount']       = $_POST['discount'][$key];
                $data['quantity']       = $_POST['quantity'][$key];
                $data['status']         = 'purchase';
                $data['sap_type']       = 'raw';

                if ($_POST['purchase_price'][$key] == 0 && $_POST['quantity'][$key] > 0) {
                    $data['remark'] = 'free';
                }

                save_data('sapitems', $data);
                $this->handelStock($key);
            }

            $this->handelPartyTransaction($vno);
            $this->handelSapMeta($vno);

            $msg = [
                'title' => 'success',
                'emit'  => 'Raw Material\'s Purchase successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        redirect("purchase/purchase", "refresh");
    }

    /**
     * handel stock
     */
    private function handelStock($index) {
        $where = ['code' => $_POST['product_code'][$index], 'type' => 'raw'];

        $stockInfo = get_row('stock', $where, ['quantity', 'purchase_price']);

        if (!empty($stockInfo)) {
            
            $totalAmount   = ($stockInfo->purchase_price * $stockInfo->quantity) + $_POST['subtotal'][$index];
            $totalQty      = $stockInfo->quantity + $_POST['quantity'][$index];
            $purchasePrice = $totalAmount / $totalQty;

            $data = [
                'purchase_price' => $purchasePrice,
                'sell_price'     => $_POST['sale_price'][$index],
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
                'type'           => 'raw'
            ];
        }

        save_data('stock', $data, $where);
    }

    /**
     * handel party transaction
     */
    private function handelPartyTransaction($vno) {
        $data = [
            'transaction_at'   => $this->input->post('date'),
            'party_code'       => $this->input->post('party_code'),
            'previous_balance' => $this->input->post('previous_balance'),
            'debit'            => $this->input->post('paid'),
            'credit'           => $this->input->post('grand_total'),
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
            'relation'         => $vno,
            'remark'           => 'purchase',
            'status'           => 'purchase'
        ];

        save_data('partytransaction', $data);
    }

    // handel sap meta info
    private function handelSapMeta($vno) {
        $data['meta_key']   = 'purchase_by';
        $data['meta_value'] = $this->data['name'];
        $data['voucher_no'] = $vno;

        save_data('sapmeta', $data);
    }


    private function getAllParty() {
        $where = [
            "type"   => "supplier",
            "status" => "active",
            "trash"  => 0
        ];
        return get_result("parties", $where);
    }

    /**
     * show all purchase
     */
    public function show_purchase() {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;

        $where = [
            'saprecords.sale_type !=' => 'order_purchase',
            'saprecords.status'       => 'purchase',
            'saprecords.trash'        => 0,
            'sapitems.trash'          => 0
        ];

        if (isset($_POST['show'])) {
            foreach ($_POST['search'] as $key => $val) {
                if (!empty($val)) {
                    $where["saprecords." . $key] = $val;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if (!empty($val) && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if (!empty($val) && $key == 'to') {
                    $where['saprecords.sap_at <='] = $val;
                }
            }
        } else {
            $where['saprecords.sap_at'] = date('Y-m-d');
        }

        $tableTo              = ['parties', 'sapitems', 'materials'];
        $joinCond             = ["saprecords.party_code=parties.code", "saprecords.voucher_no=sapitems.voucher_no", "sapitems.product_code=materials.code"];
        $select               = ['saprecords.*', 'parties.name', 'parties.mobile'];
        $this->data['result'] = get_left_join("saprecords", $tableTo, $joinCond, $where, $select, 'saprecords.voucher_no', "saprecords.id", "desc");

        // get all vendors
        $this->data['allParty'] = $this->getAllParty();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * show voucher
     */
    public function view() {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all"';
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
        $this->load->view('components/purchase/view', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * Delete data
     */
    public function delete() {
        $vno = $this->input->get('vno');

        if (!empty($vno)) {

            $results = get_result('sapitems', ['voucher_no' => $vno, 'trash' => 0], ['product_code', 'quantity', 'sap_type']);

            if (!empty($results)) {
                foreach ($results as $key => $row) {

                    $where = [
                        'code' => $row->product_code,
                        'type' => $row->sap_type,
                    ];

                    $stockInfo = get_row('stock', $where, 'quantity');
                    $quantity  = $stockInfo->quantity - $row->quantity;

                    save_data('stock', ['quantity' => $quantity], $where);
                }
            }

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

        redirect('purchase/purchase/show_purchase', 'refresh');
    }

    public function item_wise() {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="wise"';
        $this->data['result']     = null;

        $this->data['rawMats'] = $this->getAllRawMaterials();

        $where = [
            'materials.type'    => 'raw',
            'sapitems.sap_type' => 'raw',
            'sapitems.status'   => 'purchase',
            'sapitems.trash'    => 0,
        ];

        if (isset($_POST['show'])) {

            if (!empty($_POST['product_code'])) {
                $where['sapitems.product_code'] = $_POST['product_code'];
            }

            if (!empty($_POST['dateFrom'])) {
                $where["sapitems.sap_at >="] = $_POST['dateFrom'];
            }
            if (!empty($_POST['dateTo'])) {
                $where["sapitems.sap_at <="] = $_POST['dateTo'];
            }
        } else {
            $where["sapitems.sap_at"] = date("Y-m-d");
        }

        $select                = ['sapitems.sap_at', 'sapitems.product_code', 'materials.name', 'sapitems.quantity', 'sapitems.purchase_price', 'sapitems.sale_price'];
        $this->data['results'] = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $where, $select, '', 'sapitems.id', 'desc');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/item-wise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function sendSMS() {
        $sign    = ($this->input->post("current_sign") == 'Receivable') ? 'Due' : 'Advanced';
        $total   = $this->input->post('grand_total');
        $balance = $this->input->post('current_balance');
        $paid    = $this->input->post('paid');

        $content = "Thanks,A purchase is completed. Total Amount: " . $total . " TK, Paid: " . $paid . " Tk, Current Balance: " . $balance . " Tk, ( " . $sign . " ) Regards, Arab Feed Mills Ltd";

        $num     = $this->input->post("mobile");
        $message = send_sms($num, $content);

        $insert = array(
            'delivery_date'    => date('Y-m-d'),
            'delivery_time'    => date('H:i:s'),
            'mobile'           => $num,
            'message'          => $content,
            'total_characters' => strlen($content),
            'total_messages'   => message_length(strlen($content), $message),
            'delivery_report'  => $message
        );

        if ($message) {
            $this->action->add('sms_record', $insert);
            $this->data['confirmation'] = message('success', array());
        } else {
            $this->data['confirmation'] = message('warning', array());
        }
    }
    
    public function order_invoice() {
        $this->data['meta_title'] = 'Purchase Order';
        $this->data['active']     = 'data-target="purchase_menu"';
        $this->data['subMenu']    = 'data-target="order_invoice"';
        $this->data['result']     = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/order_invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // get all production product
    private function getAllRawMaterials() {
        $where = [
            "type"   => "raw",
            "status" => "available",
            "trash"  => 0
        ];

        $materials = get_result("materials", $where);
        return $materials;
    }
}