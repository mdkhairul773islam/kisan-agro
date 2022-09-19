<?php

class Purchase_return extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    public function index()
    {
        $this->data['subMenu']      = 'data-target="return"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // get all product
        $this->data['allproducts'] = $this->getAllProduct();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/add-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // store return product
    public function store()
    {
        // save sapreturn_records
        $data               = input_data(['created_at', 'party_code', 'total_quantity', 'previous_balance', 'total_bill', 'remark', 'specification']);
        $data['party_type'] = 'supplier';
        $data['status']     = 'purchase_return';

        // save data and return id into sapreturn_records table
        $id = save_data('sapreturn_records', $data, '', true);

        // generate voucher no
        $vno = get_voucher($id, 6, 'PR');

        // update voucher no
        save_data('sapreturn_records', ['voucher_no' => $vno], ['id' => $id]);


        // save sapreturn_item
        foreach ($_POST['product_code'] as $_key => $p_value) {
            $data                   = [];
            $data['created_at']     = $_POST['created_at'];
            $data['voucher_no']     = $vno;
            $data['product_code']   = $p_value;
            $data['purchase_price'] = $_POST['purchase_price'][$_key];
            $data['sale_price']     = $_POST['sale_price'][$_key];
            $data['quantity']       = $_POST['quantity'][$_key];
            $data['status']         = 'purchase_return';

            // save data
            save_data('sapreturn_items', $data);

            // add stock
            $this->addStock($_key);
        }

        // add party transaction
        $this->handelPartyTransaction($vno);

        $msg = [
            'title' => 'success',
            'emit'  => 'Product successfully return.',
            'btn'   => true
        ];

        $this->session->set_flashdata('confirmation', message('success', $msg));
        redirect('purchase/purchase_return', 'refresh');
    }

    /**
     * handel party transaction
     */
    private function handelPartyTransaction($vno)
    {
        $data = [
            'transaction_at'   => $this->input->post('created_at'),
            'party_code'       => $this->input->post('party_code'),
            'previous_balance' => $this->input->post('previous_balance'),
            'debit'            => $this->input->post('total_bill'),
            'credit'           => 0,
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
            'relation'         => $vno,
            'remark'           => 'purchase_return',
            'status'           => 'purchase_return'
        ];

        save_data('partytransaction', $data);
    }


    // add stock
    private function addStock($index = null)
    {
        $where = [
            'code' => $_POST['product_code'][$index],
            'type' => 'raw'
        ];

        // get all stock
        $stockQuantity = get_row('stock', $where, 'quantity');

        if (!empty($stockQuantity)) {

            $quantity = $stockQuantity->quantity - $_POST['quantity'][$index];

            save_data('stock', ['quantity' => $quantity], $where);
        }
    }


    // get all data
    public function all()
    {
        $this->data['subMenu']      = 'data-target="all_return"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // search data
        $this->search();


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/all-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // search all sale return
    private function search()
    {

        $where = ['sapreturn_records.party_type' => 'supplier', 'sapreturn_records.status' => 'purchase_return', 'sapreturn_records.trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where["sapreturn_records.$key"] = $value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == "from") {
                            $where["sapreturn_records.created_at >="] = $value;
                        }
                        if ($key == "to") {
                            $where["sapreturn_records.created_at <="] = $value;
                        }
                    }
                }
            }

        } else {

            $where['sapreturn_records.created_at'] = date('Y-m-d');
        }

        if (!empty($_POST['search']['party_code']) && !empty($_POST['search_type']) && $_POST['search_type'] !== 'voucher_wise') {

            // item wise search
            $where['sapreturn_items.trash'] = 0;
            $where['materials.type']        = 'raw';

            $tableTo               = ['sapreturn_items', 'materials'];
            $joinCond              = ['sapreturn_records.voucher_no=sapreturn_items.voucher_no', 'sapreturn_items.product_code=materials.code'];
            $select                = ['sapreturn_items.*', 'materials.name', 'materials.unit'];
            $this->data['results'] = get_join('sapreturn_records', $tableTo, $joinCond, $where, $select, '', 'sapreturn_items.id', 'desc');

        } else {

            // voucher wise search
            $select                = ['sapreturn_records.*', 'parties.name'];
            $this->data['results'] = get_join('sapreturn_records', 'parties', 'sapreturn_records.party_code=parties.code', $where, $select, '', 'sapreturn_records.id', 'desc');
        }
    }


    // view voucher
    public function view()
    {
        $this->data['subMenu']      = 'data-target="all_return"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where  = ['sapreturn_records.voucher_no' => $vno, 'sapreturn_records.trash' => 0];
        $select = ['sapreturn_records.*', 'parties.name', 'parties.mobile', 'parties.address'];

        $this->data['info'] = get_row_join('sapreturn_records', 'parties', 'sapreturn_records.party_code=parties.code', $where, $select);

        if (empty($this->data['info'])) redirect('purchase/purchase_return/all', 'refresh');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/view-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // get delete data
    public function delete()
    {
        $vno  = $this->input->get('vno');
        if (!empty($vno)) {

            // get return item info
            $returnItem = get_result('sapreturn_items', ['voucher_no' => $vno, 'trash' => 0]);

            if (!empty($returnItem)) {

                foreach ($returnItem as $item) {

                    $where = [
                        'code' => $item->product_code,
                        'type' => 'raw'
                    ];

                    // get all stock
                    $stockQuantity = get_row('stock', $where, 'quantity');
                    $quantity      = $stockQuantity->quantity + $item->quantity;

                    save_data('stock', ['quantity' => $quantity], $where);
                }
            }

            save_data('sapreturn_records', ['trash' => 1], ['voucher_no' => $vno]);
            save_data('sapreturn_items', ['trash' => 1], ['voucher_no' => $vno]);
            save_data('partytransaction', ['trash' => 1], ['relation' => $vno]);

            $msg = array(
                'title' => 'Success',
                'emit'  => 'Purchase Return Successfully Deleted',
                'btn'   => true
            );

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('purchase/purchase_return/all', 'refresh');
    }


    // all clients
    private function getAllClient()
    {
        $where = array(
            'type'   => 'supplier',
            'status' => 'active',
            'trash'  => 0
        );

        $result = get_result('parties', $where, ['code', 'name', 'mobile', 'address']);

        return $result;
    }


    // all product
    private function getAllProduct()
    {
        $result = get_result('stock', ['type' => 'raw'], ['code', 'name'], '', 'code');
        return $result;
    }
}
