<?php

class Order extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['productList'] = get_result('materials', ['type' => 'raw', 'status' => 'available', 'trash' => 0], ['code', 'name']);
        $this->data['partyList']   = get_result('parties', ['type' => 'supplier', 'status' => 'active', 'trash' => 0], ['code', 'name', 'mobile', 'address']);

        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    /**
     * show all order
     */
    public function index()
    {
        $this->data['subMenu']      = 'data-target="allOrder"';
        $this->data['confirmation'] = null;

        $where = ['orders.trash' => 0];

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
        $this->load->view('components/purchase/order/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * show create form
     */
    public function create()
    {
        $this->data['subMenu']      = 'data-target="createOrder"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/order/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['save'])) {

            $vno = 'OR' . date('ymd') . rand(1000, 9999);
            while (check_exists('orders', ['voucher_no' => $vno, 'trash' => 0])) {
                $vno = date('ymd') . rand(1000, 9999);
            }

            $created = $this->input->post('created');

            $data = [
                'created'        => $created,
                'voucher_no'     => $vno,
                'pr_no'          => $this->input->post('pr_no'),  
                'party_code'     => $this->input->post('party_code'),
                'total_bill'     => $this->input->post('total_bill'),
                'total_quantity' => $this->input->post('total_quantity'),
                'remarks'        => $this->input->post('remarks'),
            ];

            save_data('orders', $data);

            // store order items
            foreach ($_POST['product_code'] as $key => $product_code) {

                $data = [];

                $data['voucher_no']     = $vno;
                $data['product_code']   = $_POST['product_code'][$key];
                $data['quantity']       = $_POST['quantity'][$key];
                $data['purchase_price'] = $_POST['purchase_price'][$key];

                save_data('order_items', $data);
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Raw Material\'s Order Successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        redirect("purchase/order/create", "refresh");
    }

    /**
     * show voucher
     */
    public function edit()
    {
        $this->data['subMenu']      = 'data-target="allOrderallOrder
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
        $this->load->view('components/purchase/order/edit', $this->data);
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

            redirect("purchase/order/edit?vno=" . $vno, "refresh");
        }
        redirect("purchase/order", "refresh");
    }

    /**
     * show voucher
     */
    public function show()
    {
        $this->data['subMenu']      = 'data-target="allOrder"';
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
        $this->load->view('components/purchase/order/show', $this->data);
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
}