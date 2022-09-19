<?php

class Delete_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Delete Sale';
        $this->data['active']       = 'data-target="sale_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        // get sap record and item
        $sapRecord  = get_row('saprecords', ['voucher_no' => $_GET['vno'], 'trash' => 0], ['saprecords.party_code', 'saprecords.voucher_no', 'saprecords.sap_type', 'saprecords.paid', 'saprecords.total_bill']);
        $sap_type   = $sapRecord->sap_type;
        $partyCode  = $sapRecord->party_code;
        $voucher_no = $sapRecord->voucher_no;
        $totalBill  = $sapRecord->total_bill;
        $totalPaid  = $sapRecord->paid;

        $sapItems = get_result('sapitems', ['voucher_no' => $_GET['vno'], 'trash' => 0], ['sapitems.product_code', 'sapitems.godown_code', 'sapitems.quantity']);

        if (!empty($sapItems)) {

            foreach ($sapItems as $key => $value) {

                // set condition for every item
                $stockWhere = array(
                    "code"   => $value->product_code,
                    "type"   => 'finish_product',
                    "godown" => $value->godown_code
                );

                // get stock information
                $stockInfo = get_row('stock', $stockWhere);

                // caltulate new quantity
                if (!empty($stockInfo)) {
                    $quantity = $stockInfo->quantity + $value->quantity;

                    // update the stock
                    save_data('stock', ['quantity' => $quantity], $stockWhere);
                }

            }

            //update three tables
            save_data("sapitems", ["trash" => 1], ["voucher_no" => $voucher_no]);
        }

        // update party transactio and balance
        if ($sap_type == "credit") {
            $this->updatePartyTransaction($partyCode, $voucher_no, $totalPaid, $totalBill);
        }

        // update due list
        if ($sap_type == 'cash' && check_exists('due_collectio', ['voucher_no' => $voucher_no])) {
            save_data('due_collectio', ['trash' => 1], ['voucher_no' => $voucher_no]);
        }

        // update sap records
        save_data("saprecords", ["trash" => 1], ["voucher_no" => $voucher_no]);
        // update sap meta
        save_data("sapmeta", ["trash" => 1], ["voucher_no" => $voucher_no]);

        $options = array(
            'title' => 'delete',
            'emit'  => 'Sale Successfully  Deleted!',
            'btn'   => true
        );

        $this->session->set_flashdata('confirmation', message('success', $options));
        redirect('sale/sale/all', 'refresh');
    }

    //update party transaction table
    private function updatePartyTransaction($party_code = NULL, $vno = NULL, $totalPaid = NULL, $totalBill = null)
    {

        $where = [
            "party_code" => $party_code,
            "relation"   => $vno
        ];

        $data = array(
            "change_at" => date("Y-m-d"),
            "trash"     => 1
        );

        save_data("partytransaction", $data, $where);

        // get party balance
        $partyBalance = get_row('partybalance', ['code' => $party_code], 'balance');

        // calculate party balance and upadata balance
        if (!empty($partyBalance)) {
            if ($partyBalance->balance < 0){
                $balance['balance'] = $totalPaid - (abs($partyBalance->balance) +  $totalBill);
            }else{
                $balance['balance'] = ($partyBalance->balance + $totalPaid) - $totalBill;
            }

            save_data('partybalance', $balance, ['code' => $party_code]);
        }


        return true;
    }

}
