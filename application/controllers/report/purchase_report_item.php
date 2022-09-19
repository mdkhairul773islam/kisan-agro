<?php
class Purchase_report_item extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
		$this->data['meta_title'] = 'Report';
		$this->data['active']     = 'data-target="report_menu"';
    }

    public function index(){
	    $this->data['subMenu'] = 'data-target="purchase_report_item"';
        $this->data['results'] = null;

        // Fetch Purchase Items Info
        $where = array('status' =>'available','type' =>'raw','trash' =>0);
        $this->data['purchaseItems'] = $this->action->read('materials',$where);

        $where = array('status' => 'purchase','trash' =>0);

        if (isset($_POST['find'])) {
            
            if(isset($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if($value != NULL) {
                        $where[$key] = $value;
                    }
                }
            }

            foreach ($_POST['date'] as $key => $value) {
                if($value != NULL && $key == "from"){
                    //$where['date >='] = $value;
                    $where['sap_at >='] = $value;
                }
                
                if($value != NULL && $key == "to"){
                    //$where['date <='] = $value;
                    $where['sap_at <='] = $value;
                }
            }
        }

        // Fetch saprecords Info
        $this->data['results'] = $this->action->read('sapitems', $where);

        

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/report/purchase_nav', $this->data);
        $this->load->view('components/report/purchase_report_item', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);

    }

		


 }

