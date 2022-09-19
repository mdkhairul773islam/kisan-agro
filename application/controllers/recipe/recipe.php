<?php


class Recipe extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }


    public function index()
    {
        $this->data['meta_title'] = 'Toast Recipe';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="make-recipe"';

        // get voucher
        $this->data['voucher_no'] = generate_voucher('tbl_recipe');

        // get all category
        $this->data['allCategory'] = get_result('category', ['trash' => 0], ['code', 'category']);

        // save data
        if (isset($_POST['save'])) {
            // add recipe
            $this->addRecipe();

            // add recipe items
            $this->addRecipeItem();

            // send message
            $options = [
                'title' => 'success',
                'emit'  => 'Recipe Successfully Added!',
                'btn'   => true
            ];

            $this->data['confirmation'] = message('success', $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('/recipe/recipe/preview/' . $this->data['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/make-recipe', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function pending_recipe()
    {
        $this->data['meta_title'] = 'Create Recipe';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="pending-recipe"';

        // get voucher
        $this->data['voucher_no'] = generate_voucher('tbl_recipe');

        // get all category
        $where                     = ['pending_recipe.status' => 'pending', 'pending_recipe.trash' => 0];
        $select                    = ['pending_recipe.*', 'category.category AS category_name'];
        $this->data['allCategory'] = get_join('pending_recipe', 'category', 'pending_recipe.category_code=category.code', $where, $select, '', 'pending_recipe.id', 'desc');

        // save data
        if (isset($_POST['save'])) {
            // add recipe
            $this->addRecipe();

            // add recipe items
            $this->addRecipeItem();

            // send message
            $options = [
                'title' => 'success',
                'emit'  => 'Recipe Successfully Added!',
                'btn'   => true
            ];

            $this->data['confirmation'] = message('success', $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('/recipe/recipe/preview/' . $this->data['voucher_no'], 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/pending-recipe', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function pending_recipe_list()
    {
        $this->data['meta_title'] = 'Create Recipe';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="pending-recipe-list"';

        // get all pending recipe
        $where                   = ['pending_recipe.status' => 'pending', 'pending_recipe.trash' => 0];
        $select                  = ['pending_recipe.*', 'category.category AS category_name'];
        $this->data['allRecipe'] = get_join('pending_recipe', 'category', 'pending_recipe.category_code=category.code', $where, $select, '', 'pending_recipe.id', 'desc');


        // delete pending recipe
        if (!empty($_GET['id'])) {

            $options = [
                'title' => 'success',
                'emit'  => 'Recipe Successfully Deleted....!',
                'btn'   => true
            ];

            save_data('pending_recipe', ['trash' => 1], ['id' => $_GET['id']]);

            $this->data['confirmation'] = message('success', $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('/recipe/recipe/pending_recipe_list', 'refresh');
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/pending-recipe-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // get all data
    public function all()
    {
        $this->data['meta_title'] = 'All Fromula';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="all-recipe"';

        // search function
        $where = ['tbl_recipe.trash' => 0];
        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $s_value) {
                    if (!empty($s_value)) {
                        $where["tbl_recipe.$_key"] = $s_value;
                    }
                }
            }

            if (!empty($_POST['date'])) {
                foreach ($_POST['date'] as $_key => $d_value) {
                    if (!empty($d_value) && $_key == 'from') {
                        $where["tbl_recipe.created >="] = $d_value;
                    }

                    if (!empty($d_value) && $_key == 'to') {
                        $where["tbl_recipe.created <="] = $d_value;
                    }
                }
            }
        } else {
            $where['tbl_recipe.created'] = date('Y-m-d');
        }

        $this->data['allInfo'] = get_join('tbl_recipe', 'category', 'category.code=tbl_recipe.category_code', $where, ['tbl_recipe.*', 'category.category as category_name'], '', 'id', 'desc');


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/all-recipe', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // preview voucher
    public function preview($voucher_no = null)
    {
        $this->data['meta_title'] = 'Preview Voucher';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="all-recipe"';

        $this->data['info'] = get_row('tbl_recipe', ['voucher_no' => $voucher_no]);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/voucher', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function edit($voucher_no = null)
    {
        $this->data['meta_title'] = 'Edit Recipe';
        $this->data['active']     = 'data-target="recipe_menu"';
        $this->data['subMenu']    = 'data-target="all-recipe"';

        if (!empty($voucher_no)) {
            $where                    = ['tbl_recipe.voucher_no' => $voucher_no, 'tbl_recipe.trash' => 0];
            $this->data['recipeInfo'] = get_row_join('tbl_recipe', 'category', 'category.code=tbl_recipe.category_code', $where, ['tbl_recipe.*', 'category.category as category_name']);

            if (isset($_POST['update'])) {
                // update recipe
                $this->addRecipe($voucher_no);

                // update recipe item
                $this->addRecipeItem($voucher_no);

                // send message
                $options = [
                    'title' => 'success',
                    'emit'  => 'Recipe Successfully Updated!',
                    'btn'   => true
                ];

                $this->data['confirmation'] = message('success', $options);
                $this->session->set_flashdata('confirmation', $this->data['confirmation']);
                redirect('recipe/recipe/all', 'refresh');
            }
        } else {
            redirect('recipe/recipe/all', 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/edit-recipe', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // delete voucher
    public function delete($voucher_no = null)
    {

        if (!empty($voucher_no)) {
            // get recipe items
            $recipeItems = get_result('tbl_recipe_item', ['voucher_no' => $voucher_no], ['product_code', 'item_total_material']);

            if (!empty($recipeItems)) {
                foreach ($recipeItems as $_key => $ri_value) {

                    // get stock info
                    $stockInfo = get_row('stock', ['code' => $ri_value->product_code, 'type' => 'raw'], ['quantity']);
                    if (!empty($stockInfo)) {
                        $quantity = $stockInfo->quantity + $ri_value->item_total_material;
                    } else {
                        $quantity = $ri_value->quantity;
                    }

                    // update stock
                    save_data('stock', ['quantity' => $quantity], ['code' => $ri_value->product_code, 'type' => 'raw']);
                    // update recipe item
                    save_data('tbl_recipe_item', ['trash' => 1], ['voucher_no' => $voucher_no]);
                }
            }

            // update recipe
            save_data('tbl_recipe', ['trash' => 1], ['voucher_no' => $voucher_no]);

            // send message
            $options = [
                'title' => 'Delete',
                'emit'  => 'Recipe Successfully Deleted!',
                'btn'   => true
            ];

            $this->data['confirmation'] = message('success', $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('recipe/recipe/all', 'refresh');
        } else {
            redirect('recipe/recipe/all', 'refresh');
        }
    }


    // add recipe
    function addRecipe($voucher_no = null)
    {
        $data = input_data(['category_code', 'flour', 'total_material', 'total_cost', 'total_wastage_ration', 'total_wastage', 'total_production', 'created']);

        if (!empty($_POST['id'])) {
            if (check_exists('pending_recipe', ['id' => $_POST['id']])) {
                save_data('pending_recipe', ['status' => 'success'], ['id' => $_POST['id']]);
            }
        }

        if (!empty($voucher_no)) {
            $where = ['voucher_no' => $voucher_no];
            if (check_exists('tbl_recipe', $where)) {
                $this->action->update('tbl_recipe', $data, $where);
            }
        } else {
            $data['voucher_no'] = $_POST['voucher_no'];
            $this->action->add('tbl_recipe', $data);
        }
    }

    // add recipe items
    function addRecipeItem($voucher_no = null)
    {
        foreach ($_POST['product_code'] as $_key => $p_value) {
            
            $data = [
                'purchase_price'        => $_POST['purchase_price'][$_key],
                'unit'                  => $_POST['unit'][$_key],
                'material_ration'       => $_POST['material_ration'][$_key],
                'item_total_material'   => $_POST['item_total_material'][$_key], 
                'item_total_cost'       => $_POST['item_total_cost'][$_key],
                'wastage_ration'        => $_POST['wastage_ration'][$_key],
                'item_total_wastage'    => $_POST['item_total_wastage'][$_key],
                'item_total_production' => $_POST['item_total_production'][$_key]
            ];


            if (!empty($voucher_no)) {
                $where = ['voucher_no' => $voucher_no, 'product_code' => $p_value];

                // get stock and recipe item
                $sockInfo = get_row('stock', ['code' => $p_value, 'type' => 'raw'], ['quantity']);
                $itemInfo = get_row('tbl_recipe_item', $where, ['item_total_material']);

                if (!empty($sockInfo)) {
                    if ($_POST['flour'] >= $_POST['old_flour']) {
                        $dataStock['quantity'] = $sockInfo->quantity - ($_POST['item_total_material'][$_key] - $itemInfo->item_total_material);
                    } else {
                        $dataStock['quantity'] = $sockInfo->quantity + ($itemInfo->item_total_material - $_POST['item_total_material'][$_key]);
                    }

                    // stock update
                    save_data('stock', $dataStock, ['code' => $p_value, 'type' => 'raw']);
                }

                // update recipe item
                $data['created'] = date("Y-m-d");
                save_data('tbl_recipe_item', $data, $where);
            } else {
                $data['product_code'] = $p_value;
                $data['created']      = $_POST['created'];
                $data['voucher_no']   = $_POST['voucher_no'];

                // add data in recipe item
                save_data('tbl_recipe_item', $data);

                // update stock info
                $sockInfo = get_row('stock', ['code' => $p_value, 'type' => 'raw'], ['quantity']);
                if (!empty($sockInfo)) {
                    $dataStock['quantity'] = $sockInfo->quantity - $_POST['item_total_material'][$_key];
                    save_data('stock', $dataStock, ['code' => $p_value, 'type' => 'raw']);
                }
            }
        }
    }

}
