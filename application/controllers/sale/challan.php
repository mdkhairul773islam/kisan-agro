<?php class Challan extends Admin_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->data['clientList']    = $this->getAllClient();
        $this->data['transportList'] = $this->getAllTransport();

        $this->data['meta_title'] = 'Sale';
        $this->data['active']     = 'data-target="sale_menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="allChallan"';

        $where = ['challan.trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where['challan.' . $key] = $value;
                    }
                }
            }

            if (!empty($_POST['dateFrom'])) {
                $where['challan.created >='] = $_POST['dateFrom'];
            }

            if (!empty($_POST['dateTo'])) {
                $where['challan.created <='] = $_POST['dateTo'];
            }
        }


        $tableTo  = ['parties', 'transport'];
        $joinCond = ['challan.party_code=parties.code', 'challan.transport_id=transport.id'];
        $select   = ['challan.*', 'parties.name', 'parties.mobile', 'parties.address', 'transport.company_name', 'transport.name AS t_name', 'transport.mobile AS t_mobile', 'transport.address AS t_address'];

        $this->data['results'] = get_left_join('challan', $tableTo, $joinCond, $where, $select);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/challan/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function create() {
        $this->data['subMenu'] = 'data-target="allChallan"';

        $vno = $this->input->get('vno');

        $this->data['info'] = $info = get_row('saprecords', ['voucher_no' => $vno, 'trash' => 0]);

        if (empty($this->data['info'])) redirect('sale/sale/all', 'refresh');

        $partyInfo = [
            'code'    => '',
            'name'    => '',
            'mobile'  => '',
            'address' => ''
        ];

        if ($info->sap_type == 'cash') {

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
        $this->load->view('components/sale/challan/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function store() {
        if (isset($_POST['save'])) {
            
            $challanNo = date('ymd') . rand(1000, 9999);
            if (check_exists('challan', ['challan_no' => $challanNo])) {
                $challanNo = date('ymd') . rand(1000, 9999);
            }
            
            $created = $this->input->post('created');
            
            $data = [
                'created'        => $created,
                'challan_no'     => $challanNo,
                'voucher_no'     => $this->input->post('voucher_no'),
                'party_code'     => $this->input->post('party_code'),
                'transport_id'   => $this->input->post('transport_id'),
                'driver_name'    => $this->input->post('driver_name'),
                'driver_mobile'  => $this->input->post('driver_mobile'),
                'driver_address' => $this->input->post('driver_address'),
                'vehicle_no'     => $this->input->post('vehicle_no'),
                'engine_no'      => $this->input->post('engine_no'),
                'chassis_no'     => $this->input->post('chassis_no'),
                'total_quantity' => $this->input->post('total_quantity'),
                'remarks'        => $this->input->post('remarks'),
                'user_id'        => $this->data['user_id'],
            ];

            save_data('challan', $data);

            // store item data
            foreach ($_POST['product_code'] as $key => $product_code) {

                $data = [];

                $data['created']        = $created;
                $data['challan_no']     = $challanNo;
                $data['product_code']   = $product_code;
                $data['item_id']        = $_POST['item_id'][$key];
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['quantity']       = $_POST['quantity'][$key];

                save_data('challan_items', $data);
            }

            $msg = [
                'title' => 'success',
                'emit'  => 'Challan create successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));

            redirect('sale/challan/show?cNo=' . $challanNo, 'refresh');
        }

        redirect('sale/sale/all', 'refresh');
    }
    
    
    public function gate_pass() {
        $this->data['subMenu'] = 'data-target="Gate pass"';
        
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/challan/gate_pass', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function show() {
        $this->data['subMenu'] = 'data-target="allChallan"';

        $cNo = $this->input->get('cNo');

        $where = [
            'challan.challan_no' => $cNo,
            'challan.trash'      => 0,
        ];

        $tableTo  = ['transport'];
        $joinCond = ['challan.transport_id=transport.id'];
        $select   = ['challan.*', 'transport.company_name', 'transport.name AS t_name', 'transport.mobile AS t_mobile', 'transport.address AS t_address'];

        $this->data['info'] = $info = get_row_join('challan', $tableTo, $joinCond, $where, $select);

        $where = [
            'challan_items.challan_no' => $cNo,
            'challan_items.trash'      => 0,
        ];

        $tableTo  = ['materials'];
        $joinCond = ['challan_items.product_code=materials.code'];
        $select   = ['challan_items.*', 'materials.name'];

        $this->data['results'] = get_join('challan_items', $tableTo, $joinCond, $where, $select);
        
        $voucherInfo = get_row('saprecords', ['voucher_no' => $info->voucher_no]);

        $partyInfo   = [
            'code'    => '',
            'name'    => '',
            'mobile'  => '',
            'address' => ''
        ];

        if ($voucherInfo->sap_type == 'cash') {

            $cInfo = json_decode($voucherInfo->client_info);

            $partyInfo['name']    = $voucherInfo->party_code;
            $partyInfo['mobile']  = $cInfo->mobile;
            $partyInfo['address'] = $cInfo->address;
        } else {

            $pInfo = get_row('parties', ['code' => $voucherInfo->party_code], ['name', 'mobile', 'address']);

            $partyInfo['code']    = $voucherInfo->party_code;
            $partyInfo['name']    = $pInfo->name;
            $partyInfo['mobile']  = $pInfo->mobile;
            $partyInfo['address'] = $pInfo->address;
        }

        $this->data['partyInfo'] = (object)$partyInfo;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/challan/show', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function edit() {
        $this->data['subMenu'] = 'data-target="allChallan"';

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/challan/show', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    
    public function delete() {
        $cNo   = $this->input->get('cNo');
        $where = ['challan_no' => $cNo, 'trash' => 0];

        $data = ['trash' => 1];

        save_data('challan', $data, $where);
        save_data('challan_items', $data, $where);

        $msg = [
            'title' => 'delete',
            'emit'  => 'Challan delete successful.',
            'btn'   => true
        ];

        $this->session->set_flashdata("confirmation", message('danger', $msg));

        redirect('sale/challan', 'refresh');
    }
    
    
    private function getAllClient() {
        $where = [
            'type'   => 'client',
            'status' => 'active',
            'trash'  => 0
        ];

        return get_result('parties', $where, ['code', 'name', 'address']);
    }
    
    
    private function getAllTransport() {
        $where = ['trash' => 0];
        return get_result('transport', $where, ['id', 'company_name', 'name', 'mobile', 'address']);
    }
    
    
    public function ajaxVoucherItems() {
        $request = json_decode(file_get_contents("php://input"));

        $vno = !empty($request->voucher_no) ? $request->voucher_no : '';

        $results = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', ['sapitems.voucher_no' => $vno, 'sapitems.trash' => 0], ['sapitems.*', 'materials.name']);

        $productList = [];
        if (!empty($results)) {
            foreach ($results as $key => $row) {
                $item = [];

                $challanQty = custom_query("SELECT IFNULL(SUM(quantity), 0) AS quantity FROM challan_items WHERE item_id='$row->id' AND trash=0", true)->quantity;

                $quantity = $row->quantity - $challanQty;

                if ($quantity > 0) {

                    $item['item_id']        = $row->id;
                    $item['product_code']   = $row->product_code;
                    $item['product_name']   = $row->name;
                    $item['unit']           = $row->unit;
                    $item['purchase_price'] = $row->purchase_price;
                    $item['sale_price']     = $row->sale_price;
                    $item['stock_qty']      = $quantity;
                    $item['quantity']       = $quantity;
                    $item['subtotal']       = 0;

                    array_push($productList, (object)$item);
                }
            }
        }
        echo json_encode($productList);
    }
}
