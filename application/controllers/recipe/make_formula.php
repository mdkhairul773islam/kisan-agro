<?php

class Make_formula extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }


    public function index()
    {
        $this->data['meta_title'] = 'make_recipe';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="make-formula"';

        // get all category
        $this->data['allCategory'] = get_result('category', ['trash' => 0], ['code', 'category']);

        // get row materials
        $where                       = ['status' => 'available', 'type' => 'raw', 'trash' => 0];
        $this->data['row_materials'] = get_result('materials', $where, ['code', 'name']);


        // save purchase data
        if (isset($_POST['save'])) {

            // add formula
            $this->data['confirmation'] = $this->create();

            // send message
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("recipe/make_formula", "refresh");
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/make-formula', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function all()
    {
        $this->data['meta_title'] = 'All Fromula';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="all-formula"';
        $this->data['recipes']    = NULL;

        // get all recipe
        $tableFrom             = 'tbl_formula';
        $tableTo               = 'category';
        $joinCond              = 'category.code = tbl_formula.category_code';
        $select                = ['tbl_formula.*', 'category.category as category_name'];
        $this->data['recipes'] = get_join($tableFrom, $tableTo, $joinCond, '', $select, 'tbl_formula.category_code');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/all-formula', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function show($category_code = null)
    {
        $this->data['meta_title'] = 'Show Fromula';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="all-formula"';
        $this->data['recipes']    = NULL;

        // get recipe details
        $tableFrom             = 'materials';
        $tableTo               = ['tbl_formula', 'category'];
        $where                 = ['tbl_formula.category_code' => $category_code, 'materials.type' => 'raw'];
        $select                = ['name', 'unit', 'category_code', 'ration', 'category.category as category_name'];
        $joinCond              = ['materials.code = tbl_formula.product_code', 'category.code = tbl_formula.category_code'];
        $this->data['recipes'] = get_join($tableFrom, $tableTo, $joinCond, $where, $select, 'tbl_formula.id');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/formula_show', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function edit($category_code = null)
    {
        $this->data['meta_title'] = 'Edit Fromula';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="all-formula"';
        $this->data['recipes']    = NULL;

        // get recipe details
        $tableFrom             = 'materials';
        $tableTo               = ['tbl_formula', 'category'];
        $where                 = ['category_code' => $category_code];
        $select                = ['name', 'unit', 'category_code', 'ration', 'category.category as category_name'];
        $joinCond              = ['materials.code = tbl_formula.product_code', 'category.code = tbl_formula.category_code'];
        $this->data['recipes'] = get_join($tableFrom, $tableTo, $joinCond, $where, $select);

        // get row materials
        $where                       = ['status' => 'available', 'type' => 'raw', 'trash' => 0];
        $this->data['row_materials'] = get_result('materials', $where, ['code', 'name']);


        //update data
        if (isset($_POST['update'])) {

            foreach ($_POST['product'] as $key => $value) {

                $data = array(
                    'date'         => $this->input->post('date'),
                    'category_code' => $this->input->post('category_code'),
                    'product_code' => $_POST['product_code'][$key],
                    'ration'       => $_POST['ration'][$key]
                );

                $where = [
                    'category_code' => $category_code,
                    'product_code'  => $_POST['product_code'][$key]
                ];

                if (check_exists('tbl_formula', $where)) {
                    save_data('tbl_formula', $data, $where);
                } else {
                    save_data('tbl_formula', $data);
                }
            }

            $options = array(
                'title' => 'success',
                'emit'  => ' Recipe Formula Make Successfully Update!',
                'btn'   => true
            );

            $this->session->set_flashdata('confirmation', message('success', $options));

            redirect('recipe/make_formula/edit/' . $category_code, 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/formula_edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // insert formula
    private function create()
    {
        // array unset
        $where = $data = [];

        //input data
        $data = input_data(['date', 'category_code']);

        foreach ($_POST['product_code'] as $key => $value) {

            //input data
            $data['product_code'] = $value;
            $data['ration']       = $_POST['ration'][$key];

            // update where
            $where = [
                'product_code' => $value,
                'category_code' => input_data('category_code'),
                'trash'         => 0
            ];

            // check exists data
            if (check_exists('tbl_formula', $where)) {
                // update message
                $msg = array(
                    'title' => 'warning',
                    'emit'  => 'This Formula Already Exists!',
                    'btn'   => true
                );
                $status= 'warning';
            } else {
                // insert message
                $where = [];
                $msg   = array(
                    'title' => 'success',
                    'emit'  => 'Formula Successfully Added!',
                    'btn'   => true
                );
                $status= 'success';
            }

            // save data
            save_data('tbl_formula', $data, $where);
        }

        return message($status, $msg);
    }

    // delete formula
    public function delete($category_code = null)
    {

        if (!empty($category_code)) {

            delete_data('tbl_formula', ['category_code' => $category_code]);

            $msg = array(
                'title' => 'success',
                'emit'  => ' Recipe Successfully Deleted!',
                'btn'   => true
            );
            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('recipe/make_formula/all', 'refresh');
    }
}
