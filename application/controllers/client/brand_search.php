<?php

class Brand_search extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title'] = 'Brand Wise Search';
        $this->data['active']     = 'data-target="client_menu"';
    }

    public function index() {
        $this->data['subMenu']      = 'data-target="search"';
        $this->data['confirmation'] = $this->data["allInfo"] = null;
        
        $this->data["allBrand"]     = $this->action->readDistinct("sapitems", "brand");
        $where = array();

        if (isset($_POST["show"])) {
        	$where = array();
          if(isset($_POST['search'])){
          	foreach ($_POST["search"] as $key => $value) {
          		if ($value != null) {
          			$where[$key] = $value;
          		}
          	}
          }
        }
        
        $joinCond = "sapitems.voucher_no = saprecords.voucher_no";
        $this->data["allInfo"] = $this->action->joinAndReadGroupby("sapitems", "saprecords", $joinCond, $where, "saprecords.party_code");

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/brand-search', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }


}
