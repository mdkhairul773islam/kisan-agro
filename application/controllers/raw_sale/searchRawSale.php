<?php

class SearchRawSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Raw Sale';
        $this->data['active']     = 'data-target="raw_sale_menu"';
        $this->data['subMenu']    = 'data-target="all"';
        $this->data['result']     = null;

        $where = array();

        if(isset($_POST['show'])){
            $where = array();

            foreach($_POST['search'] as $key => $val) {
                if($val != null){
                    $where[$key] = $val;
                }
            }

            foreach($_POST['date'] as $key => $val) {
                if($val != null && $key == 'from') {
                    $where['sap_at >='] = $val;
                }

                if($val != null && $key == 'to') {
                    $where['sap_at <='] = $val;
                }
            }
        }

        $where['status'] = 'sale';
        $where['sale_type'] = 'raw';
        $where['trash']  = 0;
        $this->data['result'] = $this->action->readGroupBy('saprecords', 'voucher_no', $where);

        $where = array(
            'type'    => 'client',
            'status'  => 'active',
            'trash'   => 0
        );
        $this->data['allClients'] = $this->action->read('crushing_parties', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/raw_sale/nav', $this->data);
        $this->load->view('components/raw_sale/show-sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    private function searchRawSale() {
        $where = array();

        foreach($_POST['search'] as $key => $val) {
            if($val != null){
                $where[$key] = $val;
            }
        }

        foreach($_POST['date'] as $key => $val) {
            if($val != null && $key == 'from') {
                $where['sale_at >='] = $val;
            }

            if($val != null && $key == 'to') {
                $where['sale_at <='] = $val;
            }
        }

        $where['status'] = 'sale';
        $where['sale_type'] = 'raw';
        $where['trash'] = 0;
        return $this->action->readGroupBy('saprecords', 'voucher_no', $where);
    }

}
