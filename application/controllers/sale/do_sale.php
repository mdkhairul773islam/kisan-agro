<?php
class Do_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }
    /* Insert Do Sale Data Saprecords and SapItems Table */
    public function index()
    {
        $this->data['meta_title'] = 'DO Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="do"';
        $this->data['confirmation'] = null;

        if (isset($_POST['save']))
        {

            /* Auto Increment invoice create */
            $voucher_no = get_sum('saprecords', 'id', ['status' => 'do_sale']);
            $voucher_no = "DO" . date("Y") . date("m") . rand(1000, 9999);
            while (check_exists('saprecords', ['voucher_no' => $voucher_no]))
            {
                $voucher_no = "DO" . date("Y") . date("m") . rand(1000, 9999);
            }
            /* Insert Data To SapRecords  */
            $data = array(
                'sap_at'            => $this->input->post('date'),
                'voucher_no'        => $voucher_no,
                'party_code'        => $this->input->post('party_code'),
                'total_bill'        => $this->input->post('total'),
                'total_quantity'    => $this->input->post('totalqty'),
                'paid'              => $this->input->post('paid'),
                'method'            => $this->input->post('method'),
                'godown_code'       => $_POST['godown_code'],
                'status'            => 'do_sale',
                'sap_type'          => 'credit'
            );

            if (!empty($this->input->post('due_limit_reference')))
            {
                $data['due_limit_reference'] = $this->input->post('due_limit_reference');
            }
            $status = false;
            if ($this->action->add('saprecords', $data))
            {
                // insert data to sapitems
                if (!empty($_POST['product_code']))
                {
                    foreach ($_POST['product_code'] as $key => $value)
                    {
                        $data = array(
                            'sap_at'            => $this->input->post('date'),
                            'voucher_no'        => $voucher_no,
                            'product_code'      => $_POST['product_code'][$key],
                            'purchase_price'    => $_POST['purchase_price'][$key],
                            'sale_price'        => $_POST['sale_price'][$key],
                            'order_quantity'    => $_POST['order_quantity'][$key],
                            'remaining_quantity' => $_POST['order_quantity'][$key],
                            'unit'              => $_POST['unit'][$key],
                            'bag_size'          => $_POST['bag_size'][$key],
                            'no_of_bag'         => $_POST['no_of_bag'][$key],
                            'godown_code'       => $_POST['godown_code'],
                            'status'            => 'do_sale',
                            'sap_type'          => 'credit'
                        );
                        $status = $this->action->add('sapitems', $data);
                    }
                }
            }
            $options = array(
                'title' => 'success',
                'emit' => 'DO Sale successfully Completed!',
                'btn' => true
            );
            $this->data['confirmation'] = message($status, $options);
            redirect('sale/do_sale/doSaleInvoice?vno=' . $voucher_no, 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/do-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    /* Show Do Slae Invoice */
    public function doSaleInvoice(){
        $this->data['meta_title'] = 'DO Sale Invoice';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="all-do-sale"';
        $this->data['confirmation'] = null;

        $voucher_no = $_GET['vno'];
        if(!empty($voucher_no)){
            $tableFrom  = "saprecords";
            $tableTo    = ["sapitems", "parties"];
            $joinCond   = ["saprecords.voucher_no=sapitems.voucher_no", "saprecords.party_code=parties.code"];
            $where      = ["saprecords.voucher_no"=>$voucher_no, "saprecords.trash"=>0, "saprecords.status"=>"do_sale", "sapitems.trash"=>0,]; 
            $select     = ["sapitems.*", "parties.name", "parties.address", "parties.mobile", "saprecords.party_code", "saprecords.paid", "saprecords.total_bill"];
            
            $this->data['result'] = get_join($tableFrom, $tableTo, $joinCond, $where, $select);
            $info = $this->data['result'][0];
            $this->data['partyInfo'] = get_row('parties', ['code' => $info->party_code]);
            $balanceInfo = (object)get_client_balance($info->party_code, get_name('partytransaction', 'id', ['relation' => 'sales:' . $voucher_no]));
            $balance     = $balanceInfo->balance + $info->total_bill - $info->paid;
            
            $this->data['previous_balance'] = $balanceInfo->balance;
            $this->data['previous_status']  = $balanceInfo->status;
            $this->data['balance']          = $balance;
            $this->data['status']           = ($balance < 0 ? 'Payable' : 'Receivable');

        }else{
            $this->data['result'] = [];
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/do-sale-invoice', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    /* All DO Sale */
    public function all(){
        $this->data['meta_title'] = 'DO Sale Invoice';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="all-do-sale"';
        $this->data['confirmation'] = null;

        $this->data['allClients'] = $this->getAllClients();

        $where      = ["saprecords.trash"=>0, "saprecords.status"=>"do_sale"]; 
        if (isset($_POST['show'])) {

            foreach ($_POST['search'] as $key => $val) {
                if ($val != null) {
                    $where["saprecords.".$key] = $val;
                }
            }

            foreach ($_POST['date'] as $key => $val) {
                if ($val != null && $key == 'from') {
                    $where['saprecords.sap_at >='] = $val;
                }

                if ($val != null && $key == 'to') {
                    $where['saprecords.sap_at <='] = $val;
                }
            }
        } else {
            $where['saprecords.sap_at'] = date('Y-m-d');
        }

        $tableFrom  = "saprecords";
        $tableTo    = ["sapitems", "parties"];
        $joinCond   = ["saprecords.voucher_no=sapitems.voucher_no", "saprecords.party_code=parties.code"];
        $select     = [
            "sapitems.*", "parties.name", "parties.address",
            "parties.mobile", "saprecords.party_code",
            "saprecords.total_quantity", "saprecords.total_bill", 
            "saprecords.paid"
        ];
            
        $this->data['result'] = get_join($tableFrom, $tableTo, $joinCond, $where, $select, "sapitems.voucher_no");
       
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/all-do-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    /* Delete DO Sale */
    public function delete(){
        $voucher_no = $_GET['vno'];

        if(!empty($voucher_no)){
            if($this->action->update("saprecords", ["trash"=>1], ["voucher_no"=>$voucher_no, "status"=>"do_sale"])){
                $status = $this->action->update("sapitems", ["trash"=>1], ["voucher_no"=>$voucher_no, "status"=>"do_sale"]);
                $options = array(
                    'title' => 'success',
                    'emit' => 'DO Sale Successfully Delete!',
                    'btn' => true
                );
            }else{
                $options = array(
                    'title' => 'warning',
                    'emit' => 'Opps DO Sale Not successfully Delete!',
                    'btn' => true
                );
                $status = "warning";
            }

            $this->session->set_flashdata('confirmation', message($status, $options));
            redirect('sale/do_sale/all', 'refresh');
        }
    }

    // all clients
    private function getAllClients()
    {
        $where = array(
            'type' => 'client',
            'status' => 'active'
        );
        $result = get_result('parties', $where);
        return $result;
    }
}
