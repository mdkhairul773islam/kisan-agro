<?php

class MultiSaleReturn extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }

    public function index()
    {

        $this->data['meta_title']   = 'Sale Retun';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="multi-return"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // get all product
        $this->data['allproducts'] = $this->getAllProduct();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/multi-sale-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');

    }


    // store return product
    public function store()
    {
        if (isset($_POST['save'])) {

            // save sapreturn_records
            $data                   = input_data(['created_at', 'previous_balance', 'total_quantity', 'total_bill']);
            $data['party_type']     = $this->input->post('sap_type');
            $data['payment_method'] = 'cash';
            $data['status']         = 'sale_return';

            if ($_POST['sap_type'] == 'cash') {

                $cInfo = [
                    'mobile'  => $this->input->post('c_mobile'),
                    'address' => $this->input->post('c_address'),
                ];

                $data['party_code']  = $this->input->post('c_name');
                $data['client_info'] = json_encode($cInfo);
            } else {
                $data['party_code'] = $this->input->post('party_code');
            }


            // save data and return id into sapreturn_records table
            $id = save_data('sapreturn_records', $data, '', true);

            // generate voucher no
            $vno = get_voucher($id, 6, 'SR');

            // update voucher no
            save_data('sapreturn_records', ['voucher_no' => $vno], ['id' => $id]);


            // save sapreturn_item
            foreach ($_POST['product_code'] as $key => $code) {

                $data                   = [];
                $data['created_at']     = $this->input->post('created_at');
                $data['voucher_no']     = $vno;
                $data['product_code']   = $code;
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['quantity']       = $_POST['quantity'][$key];
                $data['status']         = 'sale_return';

                // save data
                save_data('sapreturn_items', $data);

                // add stock
                $this->addStock($key);
            }

            // add party transaction
            $this->addPartyTransaction($vno);


            $options = [
                'title' => 'success',
                'emit'  => 'Product successfully Return.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $options));
        }

        redirect('sale/multiSaleReturn', 'refresh');
    }


    // add party transaction
    private function addPartyTransaction($voucher_no = null)
    {
        if (!empty($voucher_no)) {

            $data = [
                'transaction_at'   => input_data('created_at'),
                'party_code'       => input_data('party_code'),
                'previous_balance' => $this->input->post('previous_balance'),
                'credit'           => $this->input->post('total_bill'),
                'current_balance'  => $this->input->post('current_balance'),
                'relation'         => $voucher_no,
                'remark'           => 'sale_return',
                'status'           => 'sale_return',
            ];

            if ($_POST['sap_type'] == 'cash') {
                $data['debit']      = $this->input->post('total_bill');
                $data['party_code'] = $this->input->post('c_name');
            } else {
                $data['party_code'] = $this->input->post('party_code');
            }

            save_data('partytransaction', $data);
        }
    }


    // add stock
    private function addStock($index = null)
    {
        $stockWhere = [
            'code' => $_POST['product_code'][$index],
            'type' => 'finish_product'
        ];

        // get all stock
        $stockQuantity = get_row('stock', $stockWhere, 'quantity');

        $quantity = $stockQuantity->quantity + $_POST['quantity'][$index];

        save_data('stock', ['quantity' => $quantity], $stockWhere);
    }

    // get all data
    public function all()
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="multi-return-all"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // search data
        $this->search();


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/all-sale-return', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // search all sale return
    private function search()
    {

        $where = ['sapreturn_records.status' => 'sale_return', 'sapreturn_records.trash' => 0];

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
            $where['materials.type']        = 'finish_product';

            $tableTo               = ['sapreturn_items', 'materials'];
            $joinCond              = ['sapreturn_records.voucher_no=sapreturn_items.voucher_no', 'sapreturn_items.product_code=materials.code'];
            $select                = ['sapreturn_records.party_type', 'sapreturn_items.*', 'materials.name', 'materials.unit'];
            $this->data['results'] = get_left_join('sapreturn_records', $tableTo, $joinCond, $where, $select, '', 'sapreturn_items.id', 'desc');

        } else {

            // voucher wise search
            $select                = ['sapreturn_records.*', 'parties.name'];
            $this->data['results'] = get_left_join('sapreturn_records', 'parties', 'sapreturn_records.party_code=parties.code', $where, $select, '', 'sapreturn_records.id', 'desc');
        }
    }


    // view voucher
    public function view()
    {
        $this->data['meta_title']   = 'transaction';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="multi-return-all"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $this->data['info'] = $info = get_row('sapreturn_records', ['voucher_no' => $vno, 'trash' => 0]);

        if (empty($info)) redirect('sale/multiSaleReturn/all', 'refresh');

        $partyInfo = [
            'code'    => '',
            'name'    => '',
            'mobile'  => '',
            'address' => '',
        ];

        if ($info->party_type == 'cash') {

            $cInfo = json_decode($info->client_info);

            $partyInfo['name']    = $info->party_code;
            $partyInfo['mobile']  = $cInfo->mobile;
            $partyInfo['address'] = $cInfo->address;
        } else {
            $pInfo = get_row('parties', ['code' => $info->party_code], ['name', 'mobile', 'address']);

            $partyInfo['code']    = $info->party_code;
            $partyInfo['name']    = $pInfo->name;
            $partyInfo['mobile']  = $pInfo->mobile;
            $partyInfo['address'] = $pInfo->address;
        }

        $this->data['partyInfo'] = (object)$partyInfo;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/view-return-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // get delete data
    public function delete()
    {
        $vno = $this->input->get('vno');
        if (!empty($vno)) {

            $where = [
                'voucher_no' => $vno,
                'trash'      => 0,
            ];

            // get return item info
            $returnItem = get_result('sapreturn_items', $where);

            if (!empty($returnItem)) {

                foreach ($returnItem as $item) {

                    $stockWhere = [
                        'code' => $item->product_code,
                        'type' => 'finish_product'
                    ];

                    // get all stock
                    $stockQuantity = get_row('stock', $stockWhere, 'quantity');
                    $quantity      = $stockQuantity->quantity - $item->quantity;

                    save_data('stock', ['quantity' => $quantity], $stockWhere);
                }
            }

            save_data('sapreturn_records', ['trash' => 1], $where);
            save_data('sapreturn_items', ['trash' => 1], $where);
            save_data('partytransaction', ['trash' => 1], ['relation' => $vno, 'trash' => 0]);

            $msg = [
                'title' => 'Success',
                'emit'  => 'Sale Return Successfully Deleted',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('sale/multiSaleReturn/all', 'refresh');
    }


    // all clients
    private function getAllClient()
    {
        $where = [
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        ];

        $result = get_result('parties', $where, ['code', 'name', 'mobile', 'address']);

        return $result;
    }


    // all product
    private function getAllProduct()
    {
        $result = get_result('stock', ['type' => 'finish_product'], ['code', 'name'], '', 'code');
        return $result;
    }
}
