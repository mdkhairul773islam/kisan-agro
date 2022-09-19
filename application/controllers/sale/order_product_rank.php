<?php
class Order_product_rank extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        
        $this->data['meta_title']   = 'Sale';
        $this->data['active']       = 'data-target="order_menu"';
    }

    public function index() {

        
        $this->data['subMenu']      = 'data-target="order_product_rank"';
        $this->data['confirmation'] = null;
        $this->data['result']       = null;

        $where = array(
            'sapitems.sap_type'    => 'order',
            'sapitems.status'      => 'sale',
            'sapitems.trash'       => 0,
            'materials.type'       => 'finish_product',
            'materials.trash'      => 0
        );

        if(!empty($_POST['show'])){
            foreach($_POST['date'] as $_key => $value){
                if(!empty($value) && $_key == 'from'){
                    $where["sapitems.sap_at >="] = $value;
                }
                if(!empty($value) && $_key == 'to'){
                    $where["sapitems.sap_at <="] = $value;
                }
            }
        }

        $joinCond = 'sapitems.product_code=materials.code';
        $select   = ['sapitems.product_code', 'materials.name', 'materials.unit'];
        $this->data['result'] = get_join("sapitems", 'materials', $joinCond, $where, $select, 'sapitems.product_code');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/order_nav', $this->data);
        $this->load->view('components/sale/order_product_rank', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

}
