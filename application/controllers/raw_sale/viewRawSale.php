<?php

class ViewRawSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Raw Sale';
        $this->data['active'] = 'data-target="raw_sale_menu"';
        $this->data['subMenu'] = 'data-target="all"';

        $where = array(
            'voucher_no'    => $this->input->get('vno'),
            'status'        => 'sale',
            'trash'         => 0
        );

        $this->data['result'] = $this->action->read('saprecords', $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/raw_sale/nav', $this->data);
        $this->load->view('components/raw_sale/view_sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
