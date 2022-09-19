<?php class Daily_production extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('action');

		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){
        $this->data['subMenu'] = 'data-target="daily_production"';

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/daily_production', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
 } 