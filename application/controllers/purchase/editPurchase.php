<?php

class EditPurchase extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['productList'] = get_result('materials', ['type' => 'raw', 'status' => 'available', 'trash' => 0], ['code', 'name']);
    }

    public function index()
    {
        $this->data['meta_title']   = 'Purchase';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $vno = $this->input->get('vno');

        $where = [
            'saprecords.voucher_no' => $vno,
            'saprecords.status'     => 'purchase',
            'saprecords.trash'      => 0
        ];

        $this->data['info'] = get_row_join('saprecords', 'parties', 'saprecords.party_code=parties.code', $where, ['saprecords.*', 'parties.name', 'parties.mobile', 'parties.address']);

        if (empty($this->data['info'])) redirect('purchase/purchase/show_Purchase', 'refresh');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * update data
     */
    public function update()
    {
        if (isset($_POST['update'])) {

            $vno = $this->input->post('voucher_no');

            $due = $this->input->post('grand_total') - $this->input->post('paid');

            $data = [
                'sap_at'         => $this->input->post('date'),
                'change_at'      => date('Y-m-d'),
                'total_bill'     => $this->input->post('grand_total'),
                'total_quantity' => $this->input->post('total_quantity'),
                'total_discount' => $this->input->post('total_discount'),
                'transport_cost' => $this->input->post('transport_cost'),
                'party_balance'  => $this->input->post('previous_balance'),
                'paid'           => $this->input->post('paid'),
                'due'            => ($due > 0 ? $due : 0),
                'comment'        => $this->input->post('comment'),
            ];

            save_data('saprecords', $data, ['voucher_no' => $vno]);

            // insert purchase record
            foreach ($_POST['product_code'] as $key => $value) {

                $where = ['id' => $_POST['item_id'][$key]];
                $data  = [];

                $data['sap_at']         = $this->input->post('date');
                $data['purchase_price'] = $_POST['purchase_price'][$key];
                $data['sale_price']     = $_POST['sale_price'][$key];
                $data['discount']       = $_POST['discount'][$key];
                $data['quantity']       = $_POST['quantity'][$key];

                if (empty($_POST['item_id'][$key])) {
                    $where = [];

                    $data['voucher_no']   = $vno;
                    $data['product_code'] = $_POST['product_code'][$key];
                    $data['unit']         = $_POST['unit'][$key];
                    $data['status']       = 'purchase';
                    $data['sap_type']     = 'raw';
                }

                if ($_POST['purchase_price'][$key] == 0 && $_POST['quantity'][$key] > 0) {
                    $data['remark'] = 'free';
                }

                save_data('sapitems', $data, $where);
                $this->handelStock($key);
            }

            $this->handelPartyTransaction($vno);
            $this->handelSapMeta($vno);
            $this->deleteItem();

            $msg = [
                'title' => 'success',
                'emit'  => 'Raw Material\'s Purchase successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
            redirect("purchase/editPurchase?vno=" . $vno, "refresh");
        }
        redirect("purchase/purchase", "refresh");
        redirect("purchase/purchase", "refresh");
    }

    /**
     * Delete item
     */
    private function deleteItem()
    {
        if (!empty($_POST['delete_item_id'])) {
            foreach ($_POST['delete_item_id'] as $key => $value) {

                $where     = ['code' => $_POST['delete_code'][$key], 'type' => 'raw'];
                $stockInfo = get_row('stock', $where, 'quantity');
                $quantity  = $stockInfo->quantity - $_POST['delete_quantity'][$key];

                save_data('stock', ['quantity' => $quantity], $where);

                save_data('sapitems', ['trash' => 1], ['id' => $value]);
            }
        }
    }

    /**
     * handel party transaction
     */
    private function handelPartyTransaction($vno)
    {
        $data = [
            'transaction_at'   => $this->input->post('date'),
            'previous_balance' => $this->input->post('previous_balance'),
            'debit'            => $this->input->post('paid'),
            'credit'           => $this->input->post('grand_total'),
            'current_balance'  => $this->input->post('current_balance'),
            'transaction_via'  => $this->input->post('method'),
        ];

        save_data('partytransaction', $data, ['relation' => $vno]);
    }

    // handel sap meta info
    private function handelSapMeta($vno)
    {
        delete_data('sapmeta', ['voucher_no' => $vno]);

        $data['meta_key']   = 'purchase_by';
        $data['meta_value'] = $this->data['name'];
        $data['voucher_no'] = $vno;

        save_data('sapmeta', $data);
    }

    /**
     * handel stock
     */
    private function handelStock($index)
    {
        $where = ['code' => $_POST['product_code'][$index], 'type' => 'raw'];

        $stockInfo = get_row('stock', $where, 'quantity');

        $quantity = (!empty($stockInfo) ? $stockInfo->quantity : 0) + ($_POST['quantity'][$index] - $_POST['old_quantity'][$index]);

        if (!empty($stockInfo)) {

            $data = [
                'purchase_price' => $_POST['purchase_price'][$index],
                'sell_price'     => $_POST['sale_price'][$index],
                'quantity'       => $quantity,
            ];
        } else {

            $where = [];

            $data = [
                'code'           => $_POST['product_code'][$index],
                'name'           => $_POST['product'][$index],
                'unit'           => $_POST['unit'][$index],
                'quantity'       => $quantity,
                'purchase_price' => $_POST['purchase_price'][$index],
                'sell_price'     => $_POST['sale_price'][$index],
                'type'           => 'raw'
            ];
        }

        save_data('stock', $data, $where);
    }
}
