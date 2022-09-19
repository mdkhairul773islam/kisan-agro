<?php

class Purchase_report extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');

        $this->data['meta_title'] = 'Report';
        $this->data['active']     = 'data-target="report_menu"';
    }

    public function index()
    {

        $this->data['subMenu'] = 'data-target="purchase_report"';

        // get all supplier
        $this->data['allSupplier'] = get_result('parties', ['type' => 'supplier', 'trash' => 0], ['code', 'name', 'mobile']);

        // show purchase report
        $this->data['result'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/purchase_nav', $this->data);
        $this->load->view('components/report/purchase-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }

    // search all data
    private function search()
    {

        $where = ['saprecords.status' => 'purchase', 'saprecords.trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $value) {
                    if (!empty($value)) {
                        $where["saprecords.$_key"] = $value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $value) {
                    if (!empty($value) && $_key == 'from') {
                        $where["saprecords.sap_at >="] = $value;
                    }

                    if (!empty($value) && $_key == 'to') {
                        $where["saprecords.sap_at <="] = $value;
                    }
                }
            }
        } else {
            $where["saprecords.sap_at"] = date('Y-m-d');
        }

        $result = get_join('saprecords', 'parties', 'parties.code=saprecords.party_code', $where, ['saprecords.*', 'parties.name', 'parties.mobile']);

        return $result;
    }
    
    
    public function date_wise_purchase_report()
    {

        $this->data['subMenu'] = 'data-target="date_wise_purchase_report"';

        $this->data['result'] = $this->search_date_wise_purchase_report();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/report/purchase_nav', $this->data);
        $this->load->view('components/report/date-wise-purchase-report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);

    }



    // search all data
    private function search_date_wise_purchase_report()
    {
        $where = ['status' => 'purchase', 'trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $value) {
                    if (!empty($value) && $_key == 'from') {
                        $where["sap_at >="] = $value;
                    }

                    if (!empty($value) && $_key == 'to') {
                        $where["sap_at <="] = $value;
                    }
                }
            }

        } else {
            $where["sap_at"] = date('Y-m-d');
        }
        
        $result = get_result('saprecords', $where, ['sap_at', 'total_bill', 'paid'], 'sap_at', 'sap_at');

        
        return $result;
    }

}