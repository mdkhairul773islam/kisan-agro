<?php
class Field extends Admin_Controller {

    function __construct() {
        parent::__construct();
        
        $this->data['meta_title'] = 'Cost';
        $this->data['active']  = 'data-target="cost_menu"';
        $this->data['subMenu'] = 'data-target="field"';  
    }
    
    public function index() {
        
        $this->data['results'] = get_left_join('cost_field', 'cost_category', 'cost_field.cost_category_id=cost_category.id', ['cost_field.trash' => 0], ['cost_field.*', 'cost_category.cost_category']);
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/cost/nav', $this->data);
        $this->load->view('components/cost/field', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function store(){
        
        if(isset($_POST['save'])){
        
            $costField = $this->input->post('cost_field');
            
            $data = [
                'cost_category_id' => $this->input->post('cost_category_id'),
                'cost_field' => $costField,
            ];
            
            if(check_exists('cost_field', ['cost_field' => $costField, 'trash' => 0])){
                
                $msg = [
                    'title' => 'warning',
                    'emit'  => 'This cost field already exists.',
                    'btn'   => true
                ];
                $status = 'warning';
            }else{
                
                $msg = [
                    'title' => 'success',
                    'emit'  => 'Cost field add successful.',
                    'btn'   => true
                ];
                $status = 'success';
                
                save_data('cost_field', $data);
            }
    
            $this->session->set_flashdata('confirmation', message($status, $msg));
        }
        
        redirect("cost/field","refresh");
    }
    
    public function edit(){
        if(!empty($_POST['id'])){
            $info = get_row('cost_field', ['id' => $_POST['id']]);
            echo json_encode($info);
        }
    }
    
    
    public function update(){
        
        if(isset($_POST['update'])){
            
            $costFieldId  = $this->input->post('cost_field_id');
            $costField    = $this->input->post('cost_field');
            
            $data = [
                'cost_category_id' => $this->input->post('cost_category_id'),
                'cost_field' => $costField
            ];
            
            if(check_exists('cost_field', ['cost_field' => $costField, 'trash' => 0, 'id !=' => $costFieldId])){
                
                $msg = [
                    'title' => 'warning',
                    'emit'  => 'This cost field already exists.',
                    'btn'   => true
                ];
                $status = 'warning';
            }else{
                
                $msg = [
                    'title' => 'success',
                    'emit'  => 'Cost field add successful.',
                    'btn'   => true
                ];
                $status = 'success';
                
                save_data('cost_field', $data, ['id' => $costFieldId]);
            }
    
            $this->session->set_flashdata('confirmation', message($status, $msg));
        }
        redirect("cost/field","refresh");
    }

    public function delete($id = null){
        
        if(!empty($id)){
            
            save_data('cost_field', ['trash' => 1], ['id' => $id]);
        
            $msg = [
                'title' => 'delete',
                'emit'  => 'Cost category delete successful.',
                'btn'   => true
            ];
        
            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }
        
        redirect("cost/field","refresh");
    }
    
    public function ajaxFieldList(){
        
        $selectId       = $this->input->post('id');
        $costCategoryId = $this->input->post('cost_category_id');
        $option         = '<option value="" selected>Select Field</option>';
        
        $where = ['trash' => 0];
        
        if(!empty($costCategoryId)){
            $where['cost_category_id'] = $costCategoryId;
        }
        
        $results  = get_result('cost_field', $where);
        
        if(!empty($results)){
            foreach($results as $row){
                $selected = (!empty($selectId) && $selectId == $row->id ? 'selected' : '');
                $option  .= '<option value="'.$row->id.'" '. $selected .'>'. $row->cost_field .'</option>';
            }
        }
        
        echo $option;
    }
}