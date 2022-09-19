<?php

class Product extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        // get all category
        $this->data['categoryList'] = get_result('category', ['trash' => 0], ['id', 'category']);

        // get all product
        $this->data['productList'] = get_result('materials', ['type' => 'finish_product', 'status' => 'available', 'trash' => 0], ['code', 'name']);
    }

    public function index()
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // view all product
    public function all_product()
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = ['materials.type' => 'finish_product', 'materials.status' => 'available', 'materials.trash' => 0];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if ($val != null) {
                        $where["materials.$key"] = $val;
                    }
                }
            }
        }

        $select                = ['materials.*', 'category.category'];
        $this->data['results'] = get_left_join('materials', 'category', 'materials.category_id=category.id', $where, $select, '', 'materials.id', 'asc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    // view all product
    public function deactive_product()
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="deactive"';
        $this->data['confirmation'] = null;
        $this->load->library("pagination");


        $where = ['materials.type' => 'finish_product', 'materials.status' => 'unavailable', 'materials.trash' => 0];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $val) {
                    if ($val != null) {
                        $where["materials.$key"] = $val;
                    }
                }
            }
        }

        $select                = ['materials.*', 'category.category'];
        $this->data['results'] = get_left_join('materials', 'category', 'materials.category_id=category.id', $where, $select, '', 'materials.id', 'asc');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/deactive-product-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    // edit product
    public function edit($id = null)
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;


        $this->data['info'] = get_row('materials', ['id' => $id]);

        if (empty($this->data['info'])) redirect('product/product/all_product', 'refresh');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {
        if (isset($_POST['save'])) {

            $data = [
                'name'           => $this->input->post('name'),
                //'weight'         => $this->input->post('weight'),
                'category_id'    => $this->input->post('category_id'),
                'unit'           => $this->input->post('unit'),
                'bag_size'       => $this->input->post('bag_size'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sale_price'     => $this->input->post('sale_price'),
                'dealer_price'   => $this->input->post('dealer_price'),
                'tp_price'       => $this->input->post('tp_price'),
                'stock_alert'    => $this->input->post('stock_alert'),
                'type'           => 'finish_product',
            ];

            $id   = save_data('materials', $data, '', true);
            $code = get_code($id, 4);
            save_data('materials', ['code' => $code], ['id' => $id]);

            $msg = [
                "title" => "Success",
                "emit"  => "Product add successful.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }
        redirect('product/product', 'refresh');
    }

    // update data  
    public function update()
    {
        if (isset($_POST['update'])) {

            $code = $this->input->post('code');

            $data = [
                'name'           => $this->input->post('name'),
                //'weight'         => $this->input->post('weight'),
                'category_id'    => $this->input->post('category_id'),
                'unit'           => $this->input->post('unit'),
                'bag_size'       => $this->input->post('bag_size'),    
                'purchase_price' => $this->input->post('purchase_price'),
                'sale_price'     => $this->input->post('sale_price'),
                'dealer_price'   => $this->input->post('dealer_price'),
                'tp_price'       => $this->input->post('tp_price'),
                'stock_alert'    => $this->input->post('stock_alert'),
                'status'         => $this->input->post('status'),
            ];

            save_data('materials', $data, ['code' => $code]);

            // update stock data
            $stockData = [
                'name'           => $this->input->post('name'),
                //'weight'         => $this->input->post('weight'),
                'category_id'    => $this->input->post('category_id'),
                'unit'           => $this->input->post('unit'),
                'purchase_price' => $this->input->post('purchase_price'),
                'sell_price'     => $this->input->post('sale_price'),
                'dealer_price'   => $this->input->post('dealer_price'),
                'tp_price'       => $this->input->post('tp_price'),
            ];

            save_data('stock', $stockData, ['code' => $code]);

            $msg = [
                "title" => "update",
                "emit"  => "Product update successful.",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('product/product/all_product', 'refresh');
    }


    public function delete($code = NULL)
    { 
        if (!empty($code)) {

            $msg = [
                "title" => "delete",
                "emit"  => "Product delete successful.",
                "btn"   => true
            ];

            save_data('materials', ['trash' => 1], ['code' => $code, 'type' => 'finish_product']);

            $this->session->set_flashdata("confirmation", message('danger', $msg));
        }
        redirect('product/product/all_product', 'refresh');
    }
}
