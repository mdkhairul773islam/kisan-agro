<?php

class Damages extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="damages_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // get all product
        $this->data['allproducts'] = $this->getAllProduct();


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/damages/nav', $this->data);
        $this->load->view('components/damages/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // store return product
    public function store()
    {
        // save sapreturn_records
        $data               = input_data(['created_at', 'party_code', 'previous_balance', 'total_quantity', 'total_bill', 'remark']);
        $data['party_type'] = 'credit';
        $data['status']     = 'sale_damage';

        if ($_POST['previous_sign'] == 'Receivable') {
            $previous_balance = input_data('previous_balance');
        } else {
            $previous_balance = '-' . input_data('previous_balance');
        }

        $data['previous_balance'] = $previous_balance;

        // save data and return id into sapreturn_records table
        $ID = save_data('sapreturn_records', $data, '', true);

        // generate voucher no
        $voucher_no = get_voucher($ID, 6, 'SD-');

        // update voucher no
        save_data('sapreturn_records', ['voucher_no' => $voucher_no], ['id' => $ID]);

        // add party transaction
        $this->addPartyTransaction($voucher_no, $previous_balance);

        // save sapreturn_item
        foreach ($_POST['product_code'] as $_key => $p_value) {
            $data                   = [];
            $data['created_at']     = $_POST['created_at'];
            $data['voucher_no']     = $voucher_no;
            $data['product_code']   = $p_value;
            $data['purchase_price'] = $_POST['purchase_price'][$_key];
            $data['sale_price']     = $_POST['sale_price'][$_key];
            $data['quantity']       = $_POST['quantity'][$_key];
            $data['total_weight']   = $_POST['total_weight'][$_key];
            $data['status']         = 'sale_damage';

            // save data
            save_data('sapreturn_items', $data);
        }


        $options = array(
            'title' => 'success',
            'emit'  => 'Damage Product successfully Return!',
            'btn'   => true
        );

        $this->session->set_flashdata('confirmation', message('success', $options));
        redirect('damages/damages', 'refresh');

    }


    // add party transaction
    private function addPartyTransaction($voucher_no = null, $previous_balance = 0)
    {
        if (!empty($voucher_no)) {

            if ($_POST['previous_sign'] == 'Receivable') {
                $current_balance = input_data('current_balance');
            } else {
                $current_balance = '-' . input_data('current_balance');
            }

            $tData = [
                'transaction_at'   => input_data('created_at'),
                'party_code'       => input_data('party_code'),
                'previous_balance' => $previous_balance,
                'paid'             => 0,
                'current_balance'  => $current_balance,
                'relation'         => $voucher_no,
                'remark'           => 'sale_damage',
                'comment'          => ''
            ];

            save_data('partytransaction', $tData);
        }
    }


    // get all data
    public function view_all()
    {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="damages_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get all client
        $this->data['allClients'] = $this->getAllClient();

        // search data
        $this->search();


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/damages/nav', $this->data);
        $this->load->view('components/damages/all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // search all damage product
    private function search()
    {

        $where = ['sapreturn_records.party_type' => 'credit', 'sapreturn_records.status' => 'sale_damage', 'sapreturn_records.trash' => 0];

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
            $select                = ['sapreturn_items.*', 'materials.name', 'materials.unit'];
            $this->data['results'] = get_join('sapreturn_records', $tableTo, $joinCond, $where, $select, '', 'sapreturn_items.id', 'desc');

        } else {

            // voucher wise search
            $select                = ['sapreturn_records.*', 'parties.name'];
            $this->data['results'] = get_join('sapreturn_records', 'parties', 'sapreturn_records.party_code=parties.code', $where, $select, '', 'sapreturn_records.id', 'desc');
        }
    }


    // view voucher
    public function preview()
    {
        $this->data['meta_title']   = 'Damages';
        $this->data['active']       = 'data-target="damages_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get voucher info
        if (!empty($_GET['vno'])) {

            $where  = ['sapreturn_records.voucher_no' => $_GET['vno'], 'sapreturn_records.trash' => 0];
            $select = ['sapreturn_records.*', 'parties.name', 'parties.mobile', 'parties.address'];

            $this->data['info'] = get_row_join('sapreturn_records', 'parties', 'sapreturn_records.party_code=parties.code', $where, $select);

        } else {

            redirect('sale/multiSaleReturn/all', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/damages/nav', $this->data);
        $this->load->view('components/damages/preview', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


    // get delete data
    public function delete()
    {
        if (!empty($_GET['vno'])) {

            save_data('sapreturn_records', ['trash' => 1], ['voucher_no' => $_GET['vno']]);
            save_data('sapreturn_items', ['trash' => 1], ['voucher_no' => $_GET['vno']]);
            save_data('partytransaction', ['trash' => 1], ['relation' => $_GET['vno']]);

            $msg = array(
                'title' => 'Success',
                'emit'  => 'Sale Return Successfully Deleted',
                'btn'   => true
            );

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('damages/damages/view_all', 'refresh');
    }


    // all clients
    private function getAllClient()
    {
        $where = array(
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        );

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
