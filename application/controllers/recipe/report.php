<?php


class Report extends Admin_Controller
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
        $this->data['subMenu']    = 'data-target="report"';

        // get department list
        $this->data['departmentList'] = get_result('department', ['trash' => 0]);

        // show data
        $this->data['results'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/report', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    private function search(){
        
        $results = [];
        $this->data['departmentID'] = '';
        
        if(!empty($_POST['department_id'])){
            
            $this->data['departmentID'] = $_POST['department_id'];
        
            $departmentID   = (!empty($_POST['department_id']) ? 'AND category.department_id = \'' . $_POST['department_id'] . '\'' : '');
            $dateFrom       = (!empty($_POST['dateFrom']) ? 'AND tbl_recipe.created >= \'' . $_POST['dateFrom'] . '\'' : '');
            $dateTo   = '';
            if(isset($_POST['show'])){
                $dateTo   = (!empty($_POST['dateTo']) ? 'AND tbl_recipe.created <= \'' . $_POST['dateTo'] . '\'' : 'AND tbl_recipe.created = \'' . date('Y-m-d') . '\'');
            }else{
                $dateTo   = 'AND tbl_recipe.created = \'' . date('Y-m-d') . '\'';
            }
            
            $results = custom_query("SELECT tbl_recipe_item.product_code, stock.name, IFNULL(SUM(tbl_recipe_item.item_total_material), 0) AS quantity, IFNULL(SUM(tbl_recipe_item.item_total_cost), 0) AS amount FROM `tbl_recipe_item` JOIN stock ON tbl_recipe_item.product_code=stock.code WHERE tbl_recipe_item.voucher_no IN (SELECT tbl_recipe.voucher_no FROM `tbl_recipe` JOIN category ON tbl_recipe.category_code=category.code WHERE tbl_recipe.trash=0 {$dateFrom} {$dateTo} {$departmentID}) AND tbl_recipe_item.trash=0 AND stock.type='raw' GROUP BY tbl_recipe_item.product_code");
        }
        
        return $results;
    }
}
