<?php

class Production extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        // product list
        $this->data['rawProductList']    = get_result('stock', ['type' => 'raw'], ['id', 'code', 'name', 'quantity'], '', 'name', 'asc');
        $this->data['finishProductList'] = get_result('materials', ['type' => 'finish_product', 'status' => 'available', 'trash' => 0], ['id', 'code', 'name'], '', 'name', 'asc');

        // set meta title
        $this->data['meta_title'] = 'Production';
        $this->data['active']     = 'data-target="production_menu"';
    }

    public function index()
    {
        $this->data['subMenu']      = 'data-target="allProduction"';
        $this->data['confirmation'] = null;

        $this->data['results'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    private function search()
    {
        $where = ['productions.trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['productions.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['code'])) {
                $where['production_items.product_code'] = $_POST['code'];
            }

            if (!empty($_POST['dateFrom'])) {
                $where['productions.created >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['productions.created <='] = $_POST['dateTo'];
            }

        } else {
            $where['productions.created'] = date('Y-m-d');
        }

        $tableTo  = ['production_items', 'stock'];
        $joinCond = ['productions.voucher_no=production_items.voucher_no', 'production_items.product_code=stock.code'];
        $select   = ['productions.*', 'stock.code', 'stock.name'];
        $results  = get_left_join('productions', $tableTo, $joinCond, $where, $select, 'productions.voucher_no');

        return $results;
    }

    public function create()
    {
        $this->data['subMenu']      = 'data-target="createProduction"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function show()
    {
        $this->data['subMenu']      = 'data-target="allProduction"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'production_items.voucher_no' => $vno,
            'production_items.status'     => 'from',
            'production_items.trash'      => 0,
        ];

        $select = ['production_items.*', 'materials.name', 'materials.unit'];

        $this->data['productFrom'] = get_left_join('production_items', 'materials', 'production_items.product_code=materials.code', $where, $select);

        if (empty($this->data['productFrom'])) redirect('production/production', 'refresh');

        $where['production_items.status'] = 'to';
        $this->data['productTo'] = get_left_join('production_items', 'materials', 'production_items.product_code=materials.code', $where, $select);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/production/nav', $this->data);
        $this->load->view('components/production/show', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {

        if (isset($_POST['save'])) {

            $vno = 'PRO' . date('ymd') . rand(1000, 9999);
            while (check_exists('productions', ['voucher_no' => $vno, 'trash' => 0])) {
                $vno = 'PRO' . date('ymd') . rand(1000, 9999);
            }

            $created = $this->input->post('created');
            $batchNo = $this->input->post('batch_no');

            $data = [
                'created'          => $created,
                'voucher_no'       => $vno,
                'batch_no'         => $batchNo,
                'total_quantity'   => $this->input->post('total_quantity'),
                'total_amount'     => $this->input->post('total_amount'),
                'total_waste'      => $this->input->post('total_waste'),
                'waste_amount'     => $this->input->post('waste_amount'),
                'total_production' => $this->input->post('total_production'),
                'remarks'          => $this->input->post('remarks'),
            ];

            save_data('productions', $data);

            // store from data
            if (!empty($_POST['from_code'])) {
                foreach ($_POST['from_code'] as $key => $code) {

                    $fromData = [
                        'created'          => $created,
                        'voucher_no'       => $vno,
                        'batch_no'         => $batchNo,
                        'product_code'     => $code,
                        'quantity'         => $_POST['from_quantity'][$key],
                        'waste_percentage' => $_POST['from_waste_percentage'][$key],
                        'waste_quantity'   => $_POST['from_waste_quantity'][$key],
                        'purchase_price'   => $_POST['from_purchase_price'][$key],
                        'sale_price'       => $_POST['from_sale_price'][$key],
                        'status'           => 'from',
                    ];

                    save_data('production_items', $fromData);

                    $stockWhere = ['code' => $code, 'type' => 'raw'];
                    $stockInfo  = get_row('stock', $stockWhere, 'quantity');
                    $quantity   = $stockInfo->quantity - $_POST['from_quantity'][$key];
                    save_data('stock', ['quantity' => $quantity], $stockWhere);
                }
            }


            // store to data
            if (!empty($_POST['to_code'])) {
                foreach ($_POST['to_code'] as $key => $code) {

                    $toData = [
                        'created'        => $created,
                        'voucher_no'     => $vno,
                        'batch_no'       => $batchNo,
                        'product_code'   => $code,
                        'quantity'       => $_POST['to_quantity'][$key],
                        'purchase_price' => $_POST['to_purchase_price'][$key],
                        'sale_price'     => $_POST['to_sale_price'][$key],
                        'status'         => 'to',
                    ];

                    save_data('production_items', $toData);
                }
            }

            $msg = [
                "title" => "success",
                "emit"  => "Production Successful.",
                "btn"   => true
            ];

            $this->session->set_flashdata("confirmation", message("success", $msg));
        }

        redirect("production/production/create", "refresh");
    }


    // delete data
    public function delete()
    {

        $vno = $this->input->get('vno');

        $where = [
            'voucher_no' => $vno,
            'trash'      => 0
        ];

        $itemList = get_result('production_items', $where);

        if (!empty($itemList)) {
            foreach ($itemList as $key => $row) {

                if ($row->status == 'from') {
                    $stockWhere = ['code' => $row->product_code, 'type' => 'raw'];
                    $stockInfo  = get_row('stock', $stockWhere, 'quantity');
                    $quantity   = $stockInfo->quantity + $row->quantity;
                    save_data('stock', ['quantity' => $quantity], $stockWhere);
                }
            }

            $data = ['trash' => 1];

            save_data('productions', $data, $where);
            save_data('production_items', $data, $where);

            $msg = [
                "title" => "delete",
                "emit"  => "Production Successfully Deleted",
                "btn"   => true
            ];

            $this->session->set_flashdata("confirmation", message('danger', $msg));
        }


        redirect("production/production", "refresh");
    }


    public function generateBatchNo()
    {
        $batchNo = custom_query("SELECT COUNT(*) AS batch_no FROM productions", true)->batch_no;
        $batchNo = $batchNo + 1;
        echo json_encode($batchNo);
    }
}
