<?php

class Category extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->data['meta_title']   = 'Product';
        $this->data['active']       = 'data-target="product_menu"';
        $this->data['subMenu']      = 'data-target="category"';
        $this->data['confirmation'] = null;

        $this->data['results'] = get_result('category');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/product/nav', $this->data);
        $this->load->view('components/product/category', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store()
    {
        if (isset($_POST['save'])) {

            $data = ['category' => input_data('category')];


            if (check_exists("category", $data)) {

                $msg    = [
                    "title" => "warning",
                    "emit"  => "This category already exists.",
                    "btn"   => true
                ];
                $status = 'warning';

            } else {

                $msg    = [
                    "title" => "Success",
                    "emit"  => "Category successfully added.",
                    "btn"   => true
                ];
                $status = 'success';

                save_data('category', $data);
            }

            $this->session->set_flashdata('confirmation', message($status, $msg));
        }

        redirect('product/category', 'refresh');
    }

    public function edit($id = null){
        $result = get_row('category', ['id' => $id]);
        echo json_encode($result);
    }

    public function update()
    {
        if (isset($_POST['update'])) {

            $category    = input_data('category');

            $data = ['category' => $category];

            if (check_exists("category", ['category' => $category, 'id !=' => $_POST['id']])) {

                $msg    = [
                    "title" => "warning",
                    "emit"  => "This category already exists.",
                    "btn"   => true
                ];
                $status = 'warning';

            } else {

                $msg    = [
                    "title" => "update",
                    "emit"  => "Category successfully updated.",
                    "btn"   => true
                ];
                $status = 'success';

                save_data('category', $data, ['id' => $_POST['id']]);
            }

            $this->session->set_flashdata('confirmation', message($status, $msg));
        }

        redirect('product/category', 'refresh');
    }


    public function delete($id = NULL)
    {

        if (!empty($id)) {

            delete_data('category', ['id' => $id]);

            $msg = [
                "title" => "delete",
                "emit"  => "Category successfully deleted.",
                "btn"   => true
            ];

            $this->session->set_flashdata("confirmation", message('danger', $msg));
        }

        redirect("product/category", "refresh");
    }
    
    public function ajaxCategoryList(){
        
        $select   = (!empty($_POST['category_id']) ? $_POST['category_id'] : '');
        $categoryList = get_result('category', ['trash' => 0]);
        $option   = '<option value="" selected>Select Category</option>';
        foreach ($categoryList as $row) {
            $selected = ($select == $row->id ? 'selected' : '');
            $option .= '<option value="' . $row->id . '" ' . $selected . '>' . $row->category . '</option>';
        }
        echo $option;
    }
}
