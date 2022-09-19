<?php

class ViewCrushingSale extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title'] = 'Crushing Sale';
        $this->data['active'] = 'data-target="crushing_sale_menu"';
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
        $this->load->view('components/crushing_sale/nav', $this->data);
        $this->load->view('components/crushing_sale/view_crushing_sale', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
