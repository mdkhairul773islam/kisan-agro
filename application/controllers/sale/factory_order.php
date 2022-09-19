<?php

class Factory_order extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        //date_default_timezone_set("Asia/Dhaka");

        $this->load->model('action');
        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="factory_menu"';
    }

    public function index()
    {
        $this->data['subMenu']      = 'data-target="order-process"';
        $this->data['confirmation'] = $this->data['voucher_number'] = null;

        // get last voucher
        $this->data['last_voucher'] = $this->action->readSingle('saprecords', 'voucher_no');

        $this->data['allProducts'] = $this->getAllProduct();
        $this->data['allClients']  = $this->getAllClient();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/add-stock-order', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store order data
    public function storeOrder()
    {
        if (isset($_POST['save'])) {
            
            // insert sale record
            $data = input_data(['sap_at', 'party_code', 'godown_code', 'total_quantity']);

            $data['total_bill']     = $this->input->post('total');
            $data['total_discount'] = $this->input->post('total_discount');
            $data['paid']           = !empty($_POST['paid']) ? $_POST['paid'] : 0;
            $data['remark']         = 'order';
            $data['sap_type']       = 'order';
            $data['sale_type']      = $_POST['client_type'];
            $data['status']         = 'order';

            $id  = save_data('saprecords', $data, '', true);
            $vno = get_voucher($id, 6, 'OR-');
            save_data('saprecords', ['voucher_no' => $vno], ['id' => $id]);

            // store sapitems
            if (!empty($_POST['product_code'])) {

                $data = input_data(['sap_at', 'godown_code']);

                foreach ($_POST['product_code'] as $_key => $p_value) {
                    $data['product_code']   = $p_value;
                    $data['voucher_no']     = $vno;
                    $data['purchase_price'] = $_POST['purchase_price'][$_key];
                    $data['sale_price']     = $_POST['sale_price'][$_key];
                    $data['stock_type']     = $_POST['stock_type'][$_key];
                    $data['quantity']       = $_POST['quantity'][$_key];
                    $data['order_time']     = $_POST['order_time'][$_key];
                    $data['weight']         = $_POST['weight'][$_key];
                    $data['total_weight']   = $_POST['total_weight'][$_key];
                    $data['unit']           = $_POST['unit'][$_key];
                    $data['sap_type']       = 'order';
                    $data['status']         = $_POST['status'][$_key];
                    $data['order_quantity'] = $_POST['quantity'][$_key];

                    save_data('sapitems', $data);
                }
            }

            // store sapmeta info
            $this->addSapmeta($vno);

            //Sending message
            $msg = [
                'title' => 'success',
                'emit'  => 'Order successfully Completed!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect('sale/factory_order/preview/' . $vno, 'refresh');
        }

        redirect('sale/factory_order', 'refresh');
    }

    //production
    public function production()
    {
        $this->data['subMenu']      = 'data-target="production"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;
        
        // get all department
        $this->data['allDepartment'] = get_result('department', ['trash' => 0]);

        // get all category
        $this->data['allCategory'] = get_result('category', ['trash' => 0], ['code', 'category']);


        $where = array(
            'sapitems.sap_type'   => 'order',
            'sapitems.stock_type' => 'order',
            'sapitems.trash'      => 0,
            'materials.type'      => 'finish_product',
            'materials.trash'     => 0
        );

        if (!empty($_POST['show'])) {
            
            if (!empty($_POST['order_time'])) {
                $where["sapitems.order_time"] = $_POST['order_time'];
            }
            
            if (!empty($_POST['department'])) {
                $where["materials.department"] = $_POST['department'];
            }

            $where["sapitems.status"] = $_POST['status'];

            if (!empty($_POST['category'])) {
                $where["materials.category"] = $_POST['category'];
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $s_value) {
                    if ($_key == 'from' && !empty($s_value)) {
                        $where['sapitems.sap_at >='] = $s_value;
                    }
                    if ($_key == 'to' && !empty($s_value)) {
                        $where['sapitems.sap_at <='] = $s_value;
                    }
                }
            }

            $joinCond             = 'sapitems.product_code=materials.code';
            $select               = ['sapitems.product_code', 'sapitems.purchase_price', 'sapitems.sale_price', 'materials.name', 'materials.weight', 'materials.unit'];
            $this->data['result'] = get_join("sapitems", 'materials', $joinCond, $where, $select, 'sapitems.product_code');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/stock-production', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // item wise search
    public function item_wise()
    {
        $this->data['subMenu']      = 'data-target="wise"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;

        $where                = array('type' => "finish_product");
        $this->data['finish'] = $this->getAllProduct();


        if (isset($_POST['show'])) {
            $where                 = array();
            $where["product_code"] = $_POST['product_code'];
            $where["sap_type"]     = "order";
            $where["status"]       = "sale";
            $where["trash"]        = 0;

            $this->data['result'] = $this->action->read("sapitems", $where);

            $cond                     = array('code' => $_POST['product_code']);
            $this->data['finishname'] = $this->action->read('materials', $cond);
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/order_item_wise', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // view all order
    public function all()
    {
        $this->data['subMenu']      = 'data-target="all-factory-order"';
        $this->data['confirmation'] = $this->data['allItems'] = $this->data['allOrder'] = $this->data['allItemsCat'] = $orderWhere = null;


        // get all category
        $this->data['allCategory'] = get_result('category', ['trash' => 0], ['code', 'category']);

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // search all data
        $where          = ['saprecords.sap_type' => 'order', 'saprecords.status' => 'order', 'saprecords.trash' => 0, 'sapitems.stock_type' => 'order'];
        $orderWhere     = ['saprecords.sap_type' => 'order', 'saprecords.status' => 'order', 'saprecords.trash' => 0, 'sapitems.status' => 'pending', 'sapitems.trash' => 0, 'materials.type' => 'finish_product'];
        $orderItemWhere = ['sapitems.sap_type' => 'order', 'sapitems.status' => 'pending', 'sapitems.trash' => 0, 'materials.type' => 'finish_product'];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $s_value) {
                    if (!empty($s_value)) {
                        $where["saprecords.$_key"] = $s_value;
                    }
                }
            }

            if (!empty($_POST['party_code'])) {
                $where["saprecords.party_code"] = $_POST['party_code'];
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $s_value) {
                    if ($_key == 'from' && !empty($s_value)) {
                        $where['saprecords.sap_at >='] = $s_value;
                    }
                    if ($_key == 'to' && !empty($s_value)) {
                        $where['saprecords.sap_at <='] = $s_value;
                    }
                }
            }

            // item wise search
            if (!empty($_POST['order_time']) || !empty($_POST['category'])) {

                $from      = $to = date('Y-m-d');
                $ordertime = '';

                if (!empty($_POST['order_time'])) {
                    $orderWhere['order_time'] = $_POST['order_time'];
                    $ordertime                = $_POST['order_time'];
                }

                if (!empty($_POST['category'])) {
                    $orderWhere["materials.category"] = $_POST['category'];
                }

                if (!empty($_POST['party_code'])) {
                    $orderWhere["saprecords.party_code"] = $_POST['party_code'];
                }

                if (!empty($_POST['search'])) {
                    foreach ($_POST['search'] as $_key => $s_value) {
                        if (!empty($s_value)) {
                            $orderWhere["sapitems.$_key"] = $s_value;
                        }
                    }
                }

                if (!empty($_POST['date'])) {
                    foreach ($_POST['date'] as $_key => $s_value) {
                        if ($_key == 'from' && !empty($s_value)) {
                            $orderWhere['sapitems.sap_at >=']     = $s_value;
                            $orderItemWhere['sapitems.sap_at >='] = $s_value;
                        }
                        if ($_key == 'to' && !empty($s_value)) {
                            $orderWhere['sapitems.sap_at <=']     = $s_value;
                            $orderItemWhere['sapitems.sap_at <='] = $s_value;
                        }
                    }
                }

                $joinTable   = ['sapitems', 'parties', 'materials', 'category'];
                $joinCond    = ['saprecords.voucher_no=sapitems.voucher_no', 'parties.code=saprecords.party_code', 'materials.code=sapitems.product_code', 'materials.category=category.code'];
                $orderSelect = ['sapitems.status', 'sapitems.sap_at', 'sapitems.order_time', 'parties.name', 'materials.category AS category_code', 'category.category AS category_name'];
                $allItems    = get_join('saprecords', $joinTable, $joinCond, $orderWhere, $orderSelect, 'materials.category', 'category.id');

                foreach ($allItems as $o_key => $o_item) {

                    $orderItemWhere['sapitems.status']     = $o_item->status;
                    $orderItemWhere['sapitems.order_time'] = $o_item->order_time;
                    $orderItemWhere['materials.category']  = $o_item->category_code;
                    $select                                = ['sapitems.*', 'materials.name'];
                    $orderItem                             = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $orderItemWhere, $select);


                    if (!empty($orderItem)) {

                        $this->data['allItems'][$o_key]['category']      = $o_item->category_name;
                        $this->data['allItems'][$o_key]['category_code'] = $o_item->category_code;
                        $this->data['allItems'][$o_key]['order_time']    = $o_item->order_time;

                        $result       = [];
                        $total_weight = $total_quantity = $total_amount = 0;
                        foreach ($orderItem as $_key => $item) {
                            $result[$_key]['id']           = $item->id;
                            $result[$_key]['sap_at']       = $item->sap_at;
                            $result[$_key]['voucher_no']   = $item->voucher_no;
                            $result[$_key]['party_name']   = $o_item->name;
                            $result[$_key]['product_name'] = $item->name;
                            $result[$_key]['total_weight'] = $item->total_weight;
                            $result[$_key]['stock_type']   = $item->stock_type;
                            $result[$_key]['quantity']     = $item->quantity;
                            $result[$_key]['sale_price']   = $item->sale_price;
                            $result[$_key]['amount']       = $item->sale_price * $item->quantity;
                            $result[$_key]['status']       = $item->status;

                            if ($item->stock_type == 'order') {
                                $total_weight += $item->total_weight;
                            }

                            $total_quantity += $item->quantity;
                            $total_amount   += $item->sale_price * $item->quantity;
                        }

                        $this->data['allItems'][$o_key]['orderItem']      = $result;
                        $this->data['allItems'][$o_key]['total_weight']   = $total_weight;
                        $this->data['allItems'][$o_key]['total_quantity'] = $total_quantity;
                        $this->data['allItems'][$o_key]['total_amount']   = $total_amount;
                    }
                }
            }

        } else {
            $where['saprecords.sap_at'] = date('Y-m-d');
        }


        if (empty($this->data['allItems'])) {
            $select                 = ['saprecords.*', 'parties.name'];
            $this->data['allOrder'] = get_join('saprecords', ['parties', 'sapitems'], ['saprecords.party_code=parties.code', 'saprecords.voucher_no=sapitems.voucher_no'], $where, $select, 'sapitems.voucher_no', 'id', 'desc', '', [['sapitems.status', ['pending', 'processing']]]);
        }


        // product processing
        if (isset($_POST['processing'])) {
            $this->order_processing();
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/all-factory-order', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // order procession
    public function order_processing()
    {

        if (!empty($_POST['category_code'])) {
            foreach ($_POST['category_code'] as $p_key => $p_item) {
                $pRecipe['category_code'] = $p_item;
                $pRecipe['order_time']    = $_POST['order_time'][$p_key];
                $pRecipe['total_weight']  = $_POST['total_weight'][$p_key];
                $pRecipe['created_at']    = date('Y-m-d');
                $pRecipe['date_time']     = date('Y-m-d H:i:s');

                if ($_POST['total_weight'][$p_key] > 0) {
                    save_data('pending_recipe', $pRecipe);
                }
            }
        }

        if (!empty($_POST['sap_id'])) {
            foreach ($_POST['sap_id'] as $_key => $item) {
                save_data('sapitems', ['status' => 'processing'], ['id' => $item, 'status' => 'pending']);
            }

            $categoryCode = !empty($_POST['categoryCode']) ? $_POST['categoryCode'] : '';
            $totalWeight  = !empty($_POST['totalWeight']) ? $_POST['totalWeight'] : '';

            redirect("sale/factory_order/all", "refresh");
        }
    }

    // view all stock order
    public function all_stock_order()
    {
        $this->data['subMenu']      = 'data-target="all-stock-order"';
        $this->data['confirmation'] = null;
        
        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // search all data
        $where = ['saprecords.sap_type' => 'order', 'saprecords.status' => 'stock', 'saprecords.trash' => 0];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $s_value) {
                    if (!empty($s_value)) {
                        $where["saprecords.$_key"] = $s_value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $s_value) {
                    if ($_key == 'from' && !empty($s_value)) {
                        $where['saprecords.sap_at >='] = $s_value;
                    }
                    if ($_key == 'to' && !empty($s_value)) {
                        $where['saprecords.sap_at <='] = $s_value;
                    }
                }
            }

        } else {
            $where['saprecords.sap_at'] = date('Y-m-d');
        }

        $select                 = ['saprecords.*', 'parties.name'];
        $this->data['allOrder'] = get_join('saprecords', 'parties', 'parties.code=saprecords.party_code', $where, $select, '', 'id', 'desc');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/all-stock-order', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // edit order
    public function edit($voucher_no = null)
    {
        $this->data['subMenu']      = 'data-target="all-factory-order"';
        $this->data['confirmation'] = null;

        // get all product
        $this->data['allProducts'] = $this->getAllProduct();

        // get voucher no
        $this->data['stockType'] = 'order';
        $this->data['voucherNo'] = $voucher_no;
        $this->data['form_action'] = 'sale/factory_order/updateOrder';

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/factory_order_edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // update order data
    public function updateOrder()
    {
        if (isset($_POST['update'])) {

            $vno = $_POST['voucher_no'];

            // insert sale record
            $data = input_data(['sap_at', 'party_code', 'godown_code', 'total_quantity']);

            $data['total_bill']     = $this->input->post('total');
            $data['total_discount'] = $this->input->post('total_discount');
            $data['paid']           = !empty($_POST['paid']) ? $_POST['paid'] : 0;
            $data['remark']         = 'order';
            $data['sap_type']       = 'order';
            $data['sale_type']      = $_POST['client_type'];
            $data['status']         = 'order';

            save_data('saprecords', $data, ['voucher_no' => $vno]);

            // store sapitems
            if (!empty($_POST['product_code'])) {

                $data = input_data(['sap_at', 'godown_code']);

                foreach ($_POST['product_code'] as $_key => $p_value) {
                    $data['product_code']   = $p_value;
                    $data['voucher_no']     = $vno;
                    $data['purchase_price'] = $_POST['purchase_price'][$_key];
                    $data['sale_price']     = $_POST['sale_price'][$_key];
                    $data['stock_type']     = $_POST['stock_type'][$_key];
                    $data['quantity']       = $_POST['quantity'][$_key];
                    $data['order_time']     = $_POST['order_time'][$_key];
                    $data['weight']         = $_POST['weight'][$_key];
                    $data['total_weight']   = $_POST['total_weight'][$_key];
                    $data['unit']           = $_POST['unit'][$_key];
                    $data['sap_type']       = 'order';
                    $data['status']         = $_POST['status'][$_key];
                    $data['order_quantity'] = $_POST['quantity'][$_key];

                    if (!empty($_POST['id'][$_key])) {
                        save_data('sapitems', $data, ['id' => $_POST['id'][$_key]]);
                    } else {
                        save_data('sapitems', $data);
                    }
                }
            }

            // store sapmeta info
            $this->addSapmeta($vno);

            //Sending message
            $msg = [
                'title' => 'update',
                'emit'  => 'Order successfully Updated!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect('sale/factory_order/preview/' . $vno, 'refresh');
        }

        redirect('sale/factory_order', 'refresh');
    }

    // save voucher
    public function sale($voucher_no = null)
    {
        $this->data['subMenu']      = 'data-target="all-factory-order"';
        $this->data['confirmation'] = null;

        // get all product
        $this->data['allProducts'] = get_result('stock', ['type' => 'finish_product'], ['code', 'name'], '', 'code');

        // get voucher no
        $this->data['voucherNo'] = $voucher_no;
        $this->data['form_action'] = 'sale/factory_order/saleOrder';

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/order-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // sale order data
    public function saleOrder()
    {
        if (isset($_POST['stock'])) {

            $vno = $_POST['voucher_no'];

            $partyBalance = ($_POST['previous_sign'] == 'Payable' ? '-' : '') . $_POST['previous_balance'];

            // insert sale record
            $data = input_data(['sap_at', 'party_code', 'godown_code', 'total_quantity']);

            $data['total_bill']     = $this->input->post('total');
            $data['total_discount'] = $this->input->post('total_discount');
            $data['paid']           = !empty($_POST['paid']) ? $_POST['paid'] : 0;
            $data['party_balance']  = $partyBalance;
            $data['remark']         = 'order';
            $data['sap_type']       = 'order';
            $data['sale_type']      = $_POST['client_type'];
            $data['status']         = 'stock';

            save_data('saprecords', $data, ['voucher_no' => $vno]);

            // store sapitems
            if (!empty($_POST['product_code'])) {

                $data = input_data(['sap_at', 'godown_code']);

                foreach ($_POST['product_code'] as $_key => $p_value) {
                    $data['product_code']   = $p_value;
                    $data['voucher_no']     = $vno;
                    $data['purchase_price'] = $_POST['purchase_price'][$_key];
                    $data['sale_price']     = $_POST['sale_price'][$_key];
                    $data['stock_type']     = $_POST['stock_type'][$_key];
                    $data['quantity']       = $_POST['quantity'][$_key];
                    $data['order_time']     = $_POST['order_time'][$_key];
                    $data['weight']         = $_POST['weight'][$_key];
                    $data['total_weight']   = $_POST['total_weight'][$_key];
                    $data['unit']           = $_POST['unit'][$_key];
                    $data['sap_type']       = 'order';
                    $data['status']         = 'stock';
                    $data['order_quantity'] = $_POST['old_qty'][$_key];

                    if (!empty($_POST['id'][$_key])) {
                        save_data('sapitems', $data, ['id' => $_POST['id'][$_key]]);
                    } else {
                        save_data('sapitems', $data);
                    }

                    $this->addStock($_key);
                }
            }

            // store sapmeta info
            $this->addSapmeta($vno);

            // store party balance and party transaction
            $this->addPartyBalance();
            $this->addPartyTransaction($vno);

            //Sending message
            $msg = [
                'title' => 'success',
                'emit'  => 'Stock successfully Updated!',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
            redirect('sale/factory_order/sale_voucher/' . $vno, 'refresh');
        }

        redirect('sale/factory_order', 'refresh');
    }

    // delete doucher
    public function delete($voucher_no = null)
    {
        if (!empty($voucher_no)) {

            $data['trash']       = 1;
            $where['voucher_no'] = $voucher_no;

            // update sap records
            save_data('saprecords', $data, $where);
            // update sap items
            save_data('sapitems', $data, $where);


            if (check_exists('partytransaction', ['relation' => $voucher_no])) {
                save_data('partytransaction', $data, ['relation' => $voucher_no]);
            }

            //Sending message
            $msg = array(
                'title' => 'delete',
                'emit'  => 'Order successfully deleted!',
                'btn'   => true
            );

            $this->data['confirmation'] = message('danger', $msg);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('sale/factory_order/all', 'refresh');
        } else {
            redirect('sale/factory_order/all', 'refresh');
        }
    }

    // preview order voucher
    public function preview($voucher_no = null)
    {
        $this->data['subMenu'] = 'data-target="all-factory-order"';

        if (!empty($voucher_no)) {
            $select             = ['saprecords.sap_at', 'saprecords.voucher_no', 'saprecords.party_code', 'saprecords.total_discount', 'saprecords.total_bill', 'saprecords.party_balance', 'parties.name', 'parties.mobile'];
            $this->data['info'] = get_row_join('saprecords', 'parties', 'parties.code=saprecords.party_code', ['voucher_no' => $voucher_no], $select);
        } else {
            redirect('sale/factory_order/all', 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/preview-order', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // show product rank
    public function product_rank()
    {

        $this->data['subMenu']      = 'data-target="order_product_rank"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;

        $where = array(
            'sapitems.sap_type' => 'order',
            'sapitems.status'   => 'sale',
            'sapitems.trash'    => 0,
            'materials.type'    => 'finish_product',
            'materials.trash'   => 0
        );

        if (!empty($_POST['show'])) {
            foreach ($_POST['date'] as $_key => $value) {
                if (!empty($value) && $_key == 'from') {
                    $where["sapitems.sap_at >="] = $value;
                }
                if (!empty($value) && $_key == 'to') {
                    $where["sapitems.sap_at <="] = $value;
                }
            }
        }

        $joinCond             = 'sapitems.product_code=materials.code';
        $select               = ['sapitems.product_code', 'materials.name', 'materials.unit'];
        $this->data['result'] = get_join("sapitems", 'materials', $joinCond, $where, $select, 'sapitems.product_code');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/order_product_rank', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // preview order voucher
    public function sale_voucher($voucher_no = null)
    {
        $this->data['subMenu'] = 'data-target="all-stock-order"';

        if (!empty($voucher_no)) {
            $select             = ['saprecords.sap_at', 'saprecords.paid', 'saprecords.voucher_no', 'saprecords.party_code', 'saprecords.total_discount', 'saprecords.total_bill', 'saprecords.party_balance', 'parties.name', 'parties.mobile'];
            $this->data['info'] = get_row_join('saprecords', 'parties', 'parties.code=saprecords.party_code', ['voucher_no' => $voucher_no], $select);
        } else {
            redirect('sale/factory_order/all', 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/factory_nav', $this->data);
        $this->load->view('components/sale/order-sale-voucher', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // all available finish products
    private function getAllProduct()
    {
        $where    = [
            'type'   => 'finish_product',
            'status' => 'available',
            'trash'  => 0
        ];
        $products = get_result("materials", $where, ['code', 'name']);
        return $products;
    }

    // all clients
    private function getAllClient()
    {
        $where = array(
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        );

        $result = get_result('parties', $where, ['code', 'name', 'address', 'client_type']);

        return $result;
    }

    // save sap records
    private function addSaprecord()
    {

        // insert sale record
        $data = input_data(['sap_at', 'party_code', 'godown_code', 'total_quantity']);

        // insert bill record
        if ($this->input->post("previous_sign") == "Receivable") {
            $balance = 0 + $this->input->post('previous_balance');
        } else {
            $balance = 0 - $this->input->post('previous_balance');
        }

        $data['total_bill']    = $this->input->post('total');
        $data['party_balance'] = $balance;
        $data['paid']          = !empty($_POST['paid']) ? $_POST['paid'] : 0;
        $data['remark']        = 'order';
        $data['sap_type']      = 'order';
        $data['sale_type']     = $_POST['client_type'];
        $data['status']        = 'order';

        if (!empty($_POST['voucher_no']) && check_exists('saprecords', ['voucher_no' => $_POST['voucher_no']])) {

            if (!empty($_POST['stock'])) {
                $data['status'] = 'stock';
            }

            if (!empty($_POST['sale'])) {
                $data['status'] = 'sale';
            }

            $where['voucher_no'] = $_POST['voucher_no'];

            save_data('saprecords', $data, $where);
        } else {
            $record_id = save_data('saprecords', $data, '', true);

            // update voucher no
            $voucher_no = get_voucher($record_id, 6, 'OR-');
            save_data('saprecords', ['voucher_no' => $voucher_no], ['id' => $record_id]);
            return $voucher_no;
        }
    }

    // save sap items
    private function addSapitems($voucher_no = null)
    {
        if (!empty($_POST['product_code'])) {
            $data = input_data(['sap_at', 'godown_code']);

            foreach ($_POST['product_code'] as $_key => $p_value) {
                $data['product_code']   = $p_value;
                $data['purchase_price'] = $_POST['purchase_price'][$_key];
                $data['sale_price']     = $_POST['sale_price'][$_key];
                $data['stock_type']     = $_POST['stock_type'][$_key];
                $data['quantity']       = $_POST['quantity'][$_key];
                $data['order_time']     = $_POST['order_time'][$_key];
                $data['weight']         = $_POST['weight'][$_key];
                $data['total_weight']   = $_POST['total_weight'][$_key];
                $data['unit']           = $_POST['unit'][$_key];
                $data['sap_type']       = 'order';
                $data['status']         = $_POST['status'][$_key];

                if (!empty($_POST['old_qty'])) {
                    $data['order_quantity'] = $_POST['old_qty'][$_key];
                } else {
                    $data['order_quantity'] = $_POST['quantity'][$_key];
                }


                if (!empty($_POST['id']) && !empty($_POST['id'][$_key])) {

                    if (!empty($_POST['stock'])) {
                        $data['status'] = 'stock';
                    }

                    if (!empty($_POST['sale'])) {
                        $data['status'] = 'sale';
                    }

                    $where = [
                        'product_code' => $p_value,
                        'id'           => $_POST['id'][$_key],
                        'voucher_no'   => $_POST['voucher_no'],
                    ];
                } else {

                    if (!empty($_POST['sale'])) {
                        $data['status'] = 'sale';
                    }

                    $data['voucher_no'] = !empty($_POST['voucher_no']) ? $_POST['voucher_no'] : $voucher_no;
                    $where              = [];
                }

                // insert data
                save_data('sapitems', $data, $where);

                // add stock
                if (isset($_POST['sale']) || isset($_POST['stock'])) {
                    $this->addStock($_key);
                }
            }
        }
    }

    // save party meta
    private function addSapmeta($voucher_no = null)
    {
        $data['meta_key']   = 'order_by';
        $data['meta_value'] = $this->data['name'];
        $data['voucher_no'] = $voucher_no;

        if (check_exists('sapmeta', ['voucher_no' => $voucher_no])) {
            $where = ['voucher_no' => $voucher_no];
        } else {
            $where = [];
        }

        save_data('sapmeta', $data, $where);
    }


    // save party transaction
    private function addPartyTransaction($voucher_no = null)
    {
        $previousBalance = ($_POST['previous_sign'] == 'Payable' ? '-' : '') . $_POST['previous_balance'];
        $currentBalance  = ($_POST['current_sign'] == 'Payable' ? '-' : '') . $_POST['current_balance'];

        $data = array(
            'transaction_at'   => $this->input->post('sap_at'),
            'party_code'       => $this->input->post('party_code'),
            'previous_balance' => $previousBalance,
            'paid'             => $this->input->post('paid'),
            'current_balance'  => $currentBalance,
            'transaction_via'  => $this->input->post('method'),
            'relation'         => $voucher_no,
            'remark'           => 'order',
            'status'           => $this->input->post('current_sign')
        );

        save_data('partytransaction', $data);
        return true;
    }

    // save party balance
    private function addPartyBalance()
    {
        $where = array('code' => $this->input->post('party_code'));

        if ($this->input->post('current_sign') == 'Receivable') {
            $balance = 0 + $this->input->post('current_balance');
        } else {
            $balance = 0 - $this->input->post('current_balance');
        }

        $data = array('balance' => $balance);
        save_data('partybalance', $data, $where);

        return true;
    }

    // save stock
    private function addStock($index = null)
    {
        $where = [
            'code'   => $_POST['product_code'][$index],
            'type'   => 'finish_product'
        ];

        // get all stock
        $stockQuantity = get_row('stock', $where, 'quantity');

        if ($_POST['stock_type'][$index] == 'order') {
            $quantity = (!empty($stockQuantity) ? $stockQuantity->quantity + $_POST['quantity'][$index] : $_POST['quantity'][$index]);
        } else {
            $quantity =(!empty($stockQuantity) ? $stockQuantity->quantity - $_POST['quantity'][$index] : $_POST['quantity'][$index]);
        }

        $data = [
            'code'     => $_POST['product_code'][$index],
            'name'     => $_POST['product_name'][$index],
            'quantity' => $quantity,
            'unit'     => $_POST['unit'][$index],
            'type'     => 'finish_product',
            'godown'   => 1,
        ];

        if (!empty($stockQuantity)){
            save_data('stock', $data, $where);
        }else{
            save_data('stock', $data);
        }
    }

    // send sms
    private function sendSms()
    {
        $productStr = '';
        //Sending SMS Start
        $sign    = ($this->input->post("current_sign") == 'Receivable') ? 'Payable' : 'Receivable';
        $content = "Thanks for purchasing, your have purchas " . $productStr . " and paid " . $this->input->post("paid") . "Tk in " . $this->input->post("method") . " and your current balance is " . $this->input->post("current_balance") . "Tk " . $sign . "Regards, Director Arab Feed Mills Ltd.";

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

}
