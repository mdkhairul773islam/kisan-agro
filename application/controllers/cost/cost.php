<?php
class Cost extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        
        $this->data['costCategoryList'] = get_result('cost_category', ['trash' => 0]);
        
        $this->data['meta_title'] = 'Cost';
        $this->data['active']  = 'data-target="cost_menu"';
    }
    
    public function index() {
        $this->data['subMenu'] = 'data-target="allCost"'; 
        
        $where = ['cost.trash' => 0];
        
        if(isset($_POST['show'])){
            
            if(!empty($_POST['search'])){
                foreach($_POST['search'] as $key => $value){
                    if(!empty($value)){
                        $where['cost.'.$key] = $value;
                    }
                }
                
                if(!empty($_POST['dateFrom'])){
                    $where['cost.date >='] = $_POST['dateFrom'];
                }
                
                if(!empty($_POST['dateTo'])){
                    $where['cost.date <='] = $_POST['dateTo'];
                }
            }
        }
        
        $tableTo  = ['cost_field', 'cost_category'];
        $joinCond = ['cost.cost_field_id=cost_field.id', 'cost.cost_category_id=cost_category.id'];
        $select   = ['cost.*', 'cost_field.cost_field', 'cost_category.cost_category'];
        
        $this->data['results'] = get_left_join('cost', $tableTo, $joinCond, $where, $select);
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/index', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function create() {
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="createCost"';
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/create', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function store()
    {
        if(isset($_POST['save'])){
        
            $data = [
                "date"               => $this->input->post('date'),
                "cost_category_id"   => $this->input->post('cost_category_id'),
                "cost_field_id"      => $this->input->post('cost_field_id'),
                "description"        => $this->input->post('description'),
                "amount"             => $this->input->post('amount'),
                "spend_by"           => $this->input->post('spend_by')
            ];  
            
            save_data('cost', $data);
    
            $msg = [
                'title' => "success",
                'emit'  => "Cost add successful.",
                'btn'   => true
            ];
                 
            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        redirect("cost/cost","refresh");
    }


    public function edit($id=NULL) 
    {
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="allCost"';
        
        $this->data['info'] = get_row('cost', ['id' => $id]);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    public function update($id = null)
    {
        if(isset($_POST['update']) && !empty($id)){
        
            $data = [
                "date"               => $this->input->post('date'),
                "cost_category_id"   => $this->input->post('cost_category_id'),
                "cost_field_id"      => $this->input->post('cost_field_id'),
                "description"        => $this->input->post('description'),
                "amount"             => $this->input->post('amount'),
                "spend_by"           => $this->input->post('spend_by')
            ];  
            
            save_data('cost', $data, ['id' => $id]);
    
            $msg = [
                'title' => "update",
                'emit'  => "Cost update successful.",
                'btn'   => true
            ];
                 
            $this->session->set_flashdata("confirmation", message('success', $msg));
        }
        redirect("cost/cost","refresh");
    }


    public function delete($id = NULL){
        
        if(!empty($id)){
            
            save_data('cost', ['trash' => 1], ['id' => $id]);
            
            $msg = [
                'title' => 'delete',
                'emit'  => 'Cost deleted successfully.',
                'btn'   => true
            ];
            
            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }
        
        redirect('cost/cost', 'refresh');
    }
}