<?php

class Damage extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="rawdamage_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // get all product
        $this->data['allproducts'] = $this->getAllProduct();


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/raw_damage/nav', $this->data);
        $this->load->view('components/raw_damage/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // store return product
    public function store()
    {
        // save sapreturn_records
        $data               = input_data(['created_at', 'total_quantity', 'total_bill', 'remark']);
        $data['party_type'] = '';
        $data['status']     = 'purchase_damage';

        // save data and return id into sapreturn_records table
        $ID = save_data('sapreturn_records', $data, '', true);

        // generate voucher no
        $voucher_no = get_voucher($ID, 6, 'PD-');

        // update voucher no
        save_data('sapreturn_records', ['voucher_no' => $voucher_no], ['id' => $ID]);

        // save sapreturn_item
        foreach ($_POST['product_code'] as $_key => $p_value) {
            $data                   = [];
            $data['created_at']     = $_POST['created_at'];
            $data['voucher_no']     = $voucher_no;
            $data['product_code']   = $p_value;
            $data['purchase_price'] = $_POST['purchase_price'][$_key];
            $data['sale_price']     = $_POST['sale_price'][$_key];
            $data['quantity']       = $_POST['quantity'][$_key];
            $data['status']         = 'purchase_damage';

            // save data
            save_data('sapreturn_items', $data);

            // add stock
            $this->addStock($_key);
        }


        $options = array(
            'title' => 'success',
            'emit'  => 'Damage Product successfully added!',
            'btn'   => true
        );

        $this->session->set_flashdata('confirmation', message('success', $options));
        redirect('raw_damage/damage', 'refresh');

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
    public function view_all()
    {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="rawdamage_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get all product
        $this->data['allproducts'] = $this->getAllProduct();

        // search data
        $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/raw_damage/nav', $this->data);
        $this->load->view('components/raw_damage/all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all damage product
    private function search()
    {

        $where = ['sapreturn_records.status' => 'purchase_damage', 'sapreturn_records.trash' => 0];

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

        if (!empty($_POST['product_code']) && !empty($_POST['search_type']) && $_POST['search_type'] !== 'voucher_wise') {

            // item wise search
            $where['sapreturn_items.trash']        = 0;
            $where['sapreturn_items.product_code'] = $_POST['product_code'];
            $where['materials.type']               = 'raw';

            $tableTo               = ['sapreturn_items', 'materials'];
            $joinCond              = ['sapreturn_records.voucher_no=sapreturn_items.voucher_no', 'sapreturn_items.product_code=materials.code'];
            $select                = ['sapreturn_items.*', 'materials.name', 'materials.unit'];
            $this->data['results'] = get_join('sapreturn_records', $tableTo, $joinCond, $where, $select, '', 'sapreturn_items.id', 'desc');

        } else {

            // voucher wise search
            $this->data['results'] = get_result('sapreturn_records', $where, '', '', 'id', 'desc');

        }
    }


    // view voucher
    public function preview()
    {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="rawdamage_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get voucher info
        if (!empty($_GET['vno'])) {
            $this->data['info'] = get_row('sapreturn_records', ['voucher_no' => $_GET['vno'], 'trash' => 0]);

        } else {

            redirect('raw_damage/damage/all', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/raw_damage/nav', $this->data);
        $this->load->view('components/raw_damage/preview', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // get delete data
    public function delete()
    {
        if (!empty($_GET['vno'])) {

            // get return item info
            $returnItem = get_result('sapreturn_items', ['voucher_no' => $_GET['vno'], 'trash' => 0]);

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

            save_data('sapreturn_records', ['trash' => 1], ['voucher_no' => $_GET['vno']]);
            save_data('sapreturn_items', ['trash' => 1], ['voucher_no' => $_GET['vno']]);

            $msg = array(
                'title' => 'Success',
                'emit'  => 'Sale Return Successfully Deleted',
                'btn'   => true
            );

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('raw_damage/damage/view_all', 'refresh');
    }


    // all clients
    private function getAllClient()
    {
        $where = [
            'type'   => 'supplier',
            'status' => 'active',
            'trash'  => 0
        ];

        $result = get_result('parties', $where, ['code', 'name', 'mobile', 'address']);

        return $result;
    }


    // all product
    private function getAllProduct()
    {
        $where = ['type' => 'raw'];

        return get_result('stock', $where, ['code', 'name'], '', 'code');
    }
}
