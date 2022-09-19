<?php
class Pl_report extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');

		$this->data['meta_title'] = 'PL Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/pl_report', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }



 }
