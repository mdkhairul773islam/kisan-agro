<?php

class Edit_purchase extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->data['meta_title'] = 'Packaging';
        $this->data['active'] = 'data-target="packaging_menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="all-purchase"';
        $this->data['confirmation'] = null;

        if (!empty($_GET['vno'])) {
            $select                    = ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address'];
            $this->data['voucherInfo'] = get_row_join('saprecords', 'parties', 'saprecords.party_code=parties.code', ['saprecords.voucher_no' => $_GET['vno'], 'saprecords.trash' => 0], $select);
        }

        if(isset($_POST['save'])){
            $this->session->set_flashdata('confirmation', $this->edit());
            redirect("packaging/edit_purchase?vno=" . $this->input->get('vno'), "refresh");
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/packaging/nav', $this->data);
        $this->load->view('components/packaging/edit-purchase', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function edit()
    {
        // update bill record
        $party_balance = (!empty($_POST['previous_sign']) && $_POST['previous_sign'] == 'Payable' ? '-' : '') . $_POST['previous_balance'];

        $due = ($this->input->post('total') + $this->input->post('transport_cost')) - ($this->input->post('paid') + $this->input->post('total_discount'));

        $data = array(
            'sap_at'         => $this->input->post('date'),
            'change_at'      => date('Y-m-d'),
            'total_bill'     => $this->input->post('total'),
            'total_discount' => $this->input->post('total_discount'),
            'transport_cost' => $this->input->post('transport_cost'),
            'party_balance'  => $party_balance,
            'paid'           => $this->input->post('paid'),
            'comment'         => $this->input->post('comment'),
            'due'            => ($due > 0 ? $due : 0)
        );

        save_data('saprecords', $data, ['voucher_no' => $_POST['voucher_no']]);


        // update purchase items
        foreach ($_POST['item_id'] as $key => $value) {

            $where = ['id' => $value];

            $data = [
                'sap_at'         => $this->input->post('date'),
                'purchase_price' => $_POST['purchase_price'][$key],
                'quantity'       => $_POST['quantity'][$key],
            ];

            if ($_POST['purchase_price'][$key] == 0) {
                $data['remark'] = 'free';
            }

            if ($this->action->update('sapitems', $data, $where)) {
                $this->handelStock($key);
            }
        }

        $this->handelPartyTransaction();

        $options = array(
            'title' => 'Updated',
            'emit'  => 'Raw Material\'s Purchase successfully changed!',
            'btn'   => true
        );

        return message('success', $options);
    }

    private function handelStock($index)
    {

        $where = [
            'code' => $_POST['product_code'][$index],
            'type' => $_POST['sap_type'][$index],
        ];

        // updating raw material purchase price
        if ($_POST['purchase_price'][$index] > 0) {
            save_data("materials", ["price" => $_POST["purchase_price"][$index]], $where);
        }

        // get stock info
        $stockInfo = get_row('stock', $where, 'quantity');

        // set the quantity
        $quantity = $stockInfo->quantity - ($_POST['old_quantity'][$index] - $_POST['quantity'][$index]);

        $data = ['quantity' => $quantity];

        if ($_POST['purchase_price'][$index] > 0) {
            $data['purchase_price'] = $_POST['purchase_price'][$index];
        }

        save_data('stock', $data, $where);
    }


    private function handelPartyTransaction()
    {
        $previous_balance = (!empty($_POST['previous_sign']) && $_POST['previous_sign'] == 'Payable' ? '-' : '') . $_POST['previous_balance'];
        $current_balance  = (!empty($_POST['current_sign']) && $_POST['current_sign'] == 'Payable' ? '-' : '') . $_POST['current_balance'];

        $data = [
            'transaction_at'   => $this->input->post('date'),
            'change_at'        => date('Y-m-d'),
            'previous_balance' => $previous_balance,
            'paid'             => $this->input->post('paid'),
            'current_balance'  => $current_balance,
            'transaction_via'  => $this->input->post('method')
        ];

        $where = array('relation' => 'purchase:' . $this->input->post('voucher_no'));
        $this->action->update('partytransaction', $data, $where);

        return true;
    }
}
