<?php
class Category extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->data['meta_title'] = 'Cost';
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="category"';  
    }
    
    public function index() {
        
        $this->data['results'] = get_result('cost_category', ['trash' => 0]);
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/category', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function store(){
        
        if(isset($_POST['save'])){
        
            $costCategory = $this->input->post('cost_category');
            
            $data = ['cost_category' => $costCategory];
            
            if(check_exists('cost_category', ['cost_category' => $costCategory, 'trash' => 0])){
                
                $msg = [
                    'title' => 'warning',
                    'emit'  => 'This cost category already exists.',
                    'btn'   => true
                ];
                $status = 'warning';
            }else{
                
                $msg = [
                    'title' => 'success',
                    'emit'  => 'Cost category add successful.',
                    'btn'   => true
                ];
                $status = 'success';
                
                save_data('cost_category', $data);
            }
    
            $this->session->set_flashdata('confirmation', message($status, $msg));
        }
        
        redirect("cost/category","refresh");
    }
    
    public function edit(){
        if(!empty($_POST['id'])){
            $info = get_row('cost_category', ['id' => $_POST['id']]);
            echo json_encode($info);
        }
    }
    
    
    public function update(){
        
        if(isset($_POST['update'])){
            
            $costCategoryId  = $this->input->post('cost_category_id');
            $costCategory    = $this->input->post('cost_category');
            
            $data = ['cost_category' => $costCategory];
            
            if(check_exists('cost_category', ['cost_category' => $costCategory, 'trash' => 0, 'id !=' => $costCategoryId])){
                
                $msg = [
                    'title' => 'warning',
                    'emit'  => 'This cost category already exists.',
                    'btn'   => true
                ];
                $status = 'warning';
            }else{
                
                $msg = [
                    'title' => 'success',
                    'emit'  => 'Cost category add successful.',
                    'btn'   => true
                ];
                $status = 'success';
                
                save_data('cost_category', $data, ['id' => $costCategoryId]);
            }
    
            $this->session->set_flashdata('confirmation', message($status, $msg));
        }
        redirect("cost/category","refresh");
    }

    public function delete($id = null){
        
        if(!empty($id)){
            
            save_data('cost_category', ['trash' => 1], ['id' => $id]);
        
            $msg = [
                'title' => 'delete',
                'emit'  => 'Cost category delete successful.',
                'btn'   => true
            ];
        
            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }
        
        redirect("cost/category","refresh");
    }
    
    public function ajaxCategoryList(){
        
        $selectId = $this->input->post('id');
        $option   = '<option value="" selected>Select Category</option>';
        $results  = get_result('cost_category', ['trash' => 0]);
        
        if(!empty($results)){
            foreach($results as $row){
                $selected = (!empty($selectId) && $selectId == $row->id ? 'selected' : '');
                $option  .= '<option value="'.$row->id.'" '. $selected .'>'. $row->cost_category .'</option>';
            }
        }
        
        echo $option;
    }
}