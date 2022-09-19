<?php

class Purchase extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="packaging_menu"';
    }

    public function index()
    {
        $this->data['subMenu']      = 'data-target="add-purchase"';
        $this->data['confirmation'] = null;

        $this->data['invoice'] = generate_invoice("saprecords", array("status" => "purchase"));

        // save purchase data
        if (isset($_POST['save'])) {
            $this->data['confirmation'] = $this->create();

            // send sms
            //$this->sendSMS();

            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("packaging/purchase", "refresh");
        }

        // get all vendors
        $this->data['allParty'] = $this->getAllparty();

        // get all Raw Materials
        $this->data['allRawMaterials'] = $this->getAllRawMaterials();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/packaging/nav', $this->data);
        $this->load->view('components/packaging/add-purchase', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function create()
    {
        // insert bill record
        $party_balance = (!empty($_POST['previous_sign']) && $_POST['previous_sign'] == 'Payable' ? '-' : '') . $_POST['previous_balance'];

        $due = ($this->input->post('total') + $this->input->post('transport_cost')) - ($this->input->post('paid') + $this->input->post('total_discount'));

        $data = array(
            'sap_at'         => $this->input->post('date'),
            'comment'        => $this->input->post('comment'),
            'party_code'     => $this->input->post('party_code'),
            'godown_code'    => 1,
            'total_quantity' => $this->input->post('total_quantity'),
            'total_bill'     => $this->input->post('total'),
            'total_discount' => $this->input->post('total_discount'),
            'transport_cost' => $this->input->post('transport_cost'),
            'party_balance'  => $party_balance,
            'paid'           => $this->input->post('paid'),
            'due'            => ($due > 0 ? $due : 0),
            'status'         => 'purchase',
            'sap_type'       => 'raw'
        );

        $id  = save_data('saprecords', $data, '', true);
        $vno = get_voucher($id);
        save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);
        
        // insert purchase record
        $total_quantity = 0;
        foreach ($_POST['product'] as $key => $value) {

            $total_quantity += $_POST['quantity'][$key];

            $data = array();

            $data['sap_at']         = $this->input->post('date');
            $data['voucher_no']     = $vno;
            $data['product_code']   = $_POST['product_code'][$key];
            $data['purchase_price'] = $_POST['purchase_price'][$key];
            $data['discount']       = $_POST['discount'][$key];
            $data['quantity']       = $_POST['quantity'][$key];
            $data['godown_code']    = 1;
            $data['status']         = 'purchase';
            $data['sap_type']       = 'raw';

            if ($_POST['purchase_price'][$key] == 0 && $_POST['quantity'][$key] > 0) {
                $data['remark'] = 'free';
            }

            if ($this->action->add('sapitems', $data)) {
                $this->handelStock($key);
            }
        }

        
        $this->handelPartyTransaction($vno);

        $options = array(
            'title' => 'success',
            'emit'  => 'Raw Material\'s Purchase successfully Completed!',
            'btn'   => true
        );

        return message('success', $options);
    }

    private function handelPartyTransaction($vno)
    {
        $previous_balance = (!empty($_POST['previous_sign']) && $_POST['previous_sign'] == 'Payable' ? '-' : '') . $_POST['previous_balance'];
        $current_balance  = (!empty($_POST['current_sign']) && $_POST['current_sign'] == 'Payable' ? '-' : '') . $_POST['current_balance'];

        $data = array(
            'transaction_at'   => $this->input->post('date'),
            'party_code'       => $this->input->post('party_code'),
            'previous_balance' => $previous_balance,
            'paid'             => $this->input->post('paid'),
            'current_balance'  => $current_balance,
            'transaction_via'  => $this->input->post('method'),
            'relation'         => 'purchase:' . $vno,
            'remark'           => 'purchase',
            'status'           => 'payable'
        );

        $this->action->add('partytransaction', $data);

        return true;
    }


    private function handelStock($index)
    {
        // updating raw material purchase price
        if ($_POST['purchase_price'][$index] > 0) {
            $changePrice = array(
                "price" => $_POST['purchase_price'][$index]
            );

            $where = array("code" => $_POST['product_code'][$index], 'type' => 'raw');
            $this->action->update("materials", $changePrice, $where);
        }

        // get stock info
        $where           = array();
        $where['code']   = $_POST['product_code'][$index];
        $where['godown'] = 1;
        $where['type']   = 'raw';

        $record = $this->action->read('stock', $where);

        // set the quantity
        $quantity = ($record != null) ? ($record[0]->quantity + $_POST['quantity'][$index]) : $_POST['quantity'][$index];

        // check the product update or insert
        if ($record != null) {
            $data = array('quantity' => $quantity);

            if ($_POST['purchase_price'][$index] > 0) {
                $data['purchase_price'] = $_POST['purchase_price'][$index];
            }

            $this->action->update('stock', $data, $where);
        } else {
            $data = array(
                'code'           => $_POST['product_code'][$index],
                'name'           => $_POST['product'][$index],
                'quantity'       => $quantity,
                'purchase_price' => $_POST['purchase_price'][$index],
                'godown'         => 1,
                'type'           => 'raw'
            );

            $this->action->add('stock', $data);
        }
    }

    public function show_purchase()
    {
        $this->data['subMenu']    = 'data-target="all-purchase"';
        $this->data['result']     = null;

        $where = ['saprecords.status' => 'purchase', 'saprecords.trash' => 0, 'sapitems.trash' => 0, 'materials.type' => 'raw', 'materials.raw_type' => 'packaging'];

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
        $select               = ['saprecords.*', 'parties.name', 'parties.mobile', 'materials.raw_type'];
        $groupBy              = ['saprecords.voucher_no'];
        $this->data['result'] = get_join("saprecords", $tableTo, $joinCond, $where, $select, $groupBy, "saprecords.id", "desc");

        // get all vendors
        $this->data['allParty'] = $this->getAllparty();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/packaging/nav', $this->data);
        $this->load->view('components/packaging/all-purchase', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function preview_voucher()
    {
        $this->data['subMenu']      = 'data-target="all-purchase"';
        $this->data['confirmation'] = null;

        $voucherInfo                   = array(
            'saprecords.voucher_no' => $this->input->get('vno'),
            'saprecords.status'     => 'purchase',
            'saprecords.trash'      => 0
        );
        $joinCond                      = "saprecords.party_code = parties.code";
        $this->data['purchase_record'] = $this->action->joinAndRead("saprecords", "parties", $joinCond, $voucherInfo);


        $where = array(
            "sapitems.voucher_no" => $this->input->get('vno'),
            'sapitems.status'     => 'purchase',
            'materials.type'      => 'raw',
            'sapitems.trash'      => 0,
        );

        $joinCond                    = "sapitems.product_code = materials.code";
        $this->data['purchase_info'] = $this->action->joinAndRead("materials", "sapitems", $joinCond, $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/packaging/nav', $this->data);
        $this->load->view('components/packaging/preview-voucher', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * update table
     *
     */
    public function delete_purchase()
    {
        $voucher_no = $_GET['vno'];
        $records    = get_row('saprecords', ['voucher_no' => $voucher_no]);
        $party_code = $records->party_code;
        $totalBill  = $records->total_bill - $records->total_discount;
        $totalPaid  = $records->paid;

        // get praty balance
        $partyBalance = get_row("partybalance", ["code" => $party_code]);

        // calculate party balance and upadata balance
        if (!empty($partyBalance)) {

            if ($partyBalance->balance < 0) {
                $balance['balance'] = $totalBill - (abs($partyBalance->balance) + $totalPaid);
            } else {
                $balance['balance'] = ($partyBalance->balance + $totalBill) - $totalPaid;
            }

            save_data('partybalance', $balance, ['code' => $party_code]);
        }


        // delete sap items
        $purchaseInfo = get_result('sapitems', ['voucher_no' => $voucher_no]);

        foreach ($purchaseInfo as $key => $value) {
            // set condition for every item
            $stockWhere = array(
                "code"   => $value->product_code,
                "type"   => 'raw',
                "godown" => $value->godown_code
            );

            // get stock information
            $stockInfo = get_row('stock', $stockWhere);

            // caltulate new quantity
            if (!empty($stockInfo)) {
                $quantity = $stockInfo->quantity - $value->quantity;

                // update the stock
                save_data('stock', ['quantity' => $quantity], $stockWhere);
            }
        }

        //update three tables
        save_data("sapitems", ["trash" => 1], ["voucher_no" => $voucher_no]);

        // delete row
        save_data('saprecords', ["trash" => 1], ["voucher_no" => $voucher_no]);
        save_data('partytransaction', ["trash" => 1], ["relation" => "purchase:$voucher_no"]);

        $options = array(
            'title' => 'delete',
            'emit'  => 'Purchase and Stock delete successfully!',
            'btn'   => true
        );

        $this->session->set_flashdata('deleted', message('success', $options));
        redirect('packaging/purchase/show_purchase', 'refresh');
    }

    public function item_wise()
    {
        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="packaging_menu"';
        $this->data['subMenu']    = 'data-target="item-wise"';
        $this->data['result']     = null;

        $where                 = array('type' => "raw", 'raw_type' => 'packaging');
        $this->data['rawMats'] = $this->action->read('materials', $where);
        
        
        $where = [
            'materials.type'    => 'raw',
            'materials.raw_type' => 'packaging',
            'sapitems.sap_type' => 'raw',
            'sapitems.status'   => 'purchase',
            'sapitems.trash'    => 0,
        ];


        if (isset($_POST['show'])) {
            

            if(!empty($_POST['product_code'])){
                $where['sapitems.product_code'] = $_POST['product_code'];
            }
           
            if (!empty($_POST['dateFrom'])){
                $where["sapitems.sap_at >="] = $_POST['dateFrom'];
            }
            if (!empty($_POST['dateTo'])){
                $where["sapitems.sap_at <="] = $_POST['dateTo'];
            }
        }else{
            $where["sapitems.sap_at"] = date("Y-m-d");
        }
        
        $select = ['sapitems.sap_at', 'sapitems.product_code', 'materials.name', 'sapitems.quantity', 'sapitems.purchase_price', 'sapitems.sale_price'];
        $this->data['results'] = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $where, $select, '', 'sapitems.id', 'desc');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/packaging/nav', $this->data);
        $this->load->view('components/packaging/item-wise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function sendSMS()
    {
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


    private function getAllparty()
    {
        $where = array(
            "type"   => "supplier",
            "status" => "active",
            "trash"  => 0
        );
        $party = $this->action->read("parties", $where);
        return $party;
    }


    private function getAllRawMaterials()
    {
        $where     = array(
            "type"     => "raw",
            "status"   => "available",
            "raw_type" => "packaging",
            "trash"    => 0
        );
        $materials = $this->action->read("materials", $where);
        return $materials;
    }
}
