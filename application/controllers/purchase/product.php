<?php

class Product extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['meta_title'] = 'Purchase';
        $this->data['active']     = 'data-target="purchase_menu"';
    }

    /**
     * show all data
     */
    public function index()
    {
        $this->data['subMenu'] = 'data-target="product"';
        
        $where = ['materials.type !=' => 'finish_product', 'materials.trash' => 0];
        
        if(isset($_POST['show'])){
            if(!empty($_POST['product_type'])){
                $where['type'] = $_POST['product_type'];
            }
        }

        $this->data['results'] = get_left_join('materials', 'category', 'materials.category_id=category.id', $where, ['materials.*', 'category.category']);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/product', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * store data
     */
    public function store()
    {
        if (isset($_POST['save'])) {

            $data = [
                'name'           => $this->input->post('name'),
                'specification'  => $this->input->post('specification'),
                'category_id'    => $this->input->post('category_id'),
                'unit'           => $this->input->post('unit'),
                'purchase_price' => $this->input->post('purchase_price'),
                'stock_alert'    => $this->input->post('stock_alert'),
                //'lead_time'      => $this->input->post('lead_time'),
                'type'           => $this->input->post('product_type'),
                'status'         => 'available',
            ];

            $id   = save_data('materials', $data, '', true);
            $code = get_code($id, 4);
            save_data('materials', ['code' => $code], ['id' => $id]);

            $msg = [
                "title" => "success",
                "emit"  => "Material save successful.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('purchase/product', 'refresh');
    }

    /**
     * get ajax product info
     */
    public function edit()
    {
        if (!empty($_POST['id'])) {
            $data = get_row('materials', ['id' => $_POST['id']]);
            echo json_encode($data);
        }
    }


    /**
     * Update data
     */
    public function update()
    {
        if (isset($_POST['update'])) {

            $code = $this->input->post('code');

            $data = [
                'name'           => $this->input->post('name'),
                'specification'  => $this->input->post('specification'),
                'category_id'    => $this->input->post('category_id'),
                'unit'           => $this->input->post('unit'),
                'purchase_price' => $this->input->post('purchase_price'),
                'stock_alert'    => $this->input->post('stock_alert'),
                //'lead_time'      => $this->input->post('lead_time'),
                'type'    => $this->input->post('product_type'),
            ];

            save_data('materials', $data, ['code' => $code]);
            
            if(check_exists('stock', ['code' => $code])){
                
                $data = [
                    'name'           => $this->input->post('name'),
                    'specification'  => $this->input->post('specification'),
                    'category_id'    => $this->input->post('category_id'),
                    'purchase_price' => $this->input->post('purchase_price'),
                    'unit'           => $this->input->post('unit'),
                    'product_type'   => $this->input->post('product_type'),
                ];
                
                save_data('stock', $data, ['code' => $code]);
                
            }

            $msg = [
                "title" => "update",
                "emit"  => "Material update successfully.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('purchase/product', 'refresh');
    }

    /**
     * Delete data
     */
    public function delete($id = NULL)
    {
        if (!empty($id)) {

            // delete data
            save_data('materials', ['trash' => 1], ['id' => $id]);

            $msg = [
                "title" => "Delete",
                "emit"  => "Material delete successfully.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('purchase/product', 'refresh');
    }


    /**
     * get ajax product type list
     */
    public function ajaxProductTypeList()
    {
        $select   = (!empty($_POST['select']) ? $_POST['select'] : '');
        $unitList = config_item('product_type');
        $option   = '<option value="" selected>Select Type</option>';
        foreach ($unitList as $item) {
            $option .= '<option value="' . $item . '" ' . ($select == $item ? 'selected' : '') . '>' . filter($item) . '</option>';
        }
        echo $option;
    }
    
    /**
     * get ajax unit list
     */
    public function ajaxUnitList()
    {
        $select   = (!empty($_POST['select']) ? $_POST['select'] : '');
        $unitList = config_item('unit');
        $option   = '<option value="" selected>Select Unit</option>';
        foreach ($unitList as $item) {
            $option .= '<option value="' . $item . '" ' . ($select == $item ? 'selected' : '') . '>' . $item . '</option>';
        }
        echo $option;
    }
    
    /**
     * get ajax lead time list
     */
    public function ajaxLeadTimeList()
    {
        $select   = (!empty($_POST['select']) ? $_POST['select'] : '');
        $leadTimeList = config_item('lead_time');
        $option   = '<option value="" selected>Select Lead Time</option>';
        foreach ($leadTimeList as $item) {
            $option .= '<option value="' . $item . '" ' . ($select == $item ? 'selected' : '') . '>' . filter($item) . '</option>';
        }
        echo $option;
    }
}
