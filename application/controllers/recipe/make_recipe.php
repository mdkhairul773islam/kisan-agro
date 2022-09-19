<?php
class Make_recipe extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }
    
    
    public function index() {
        $this->data['meta_title'] = 'Category';
        $this->data['active'] = 'data-target="recipe_menu"';
        $this->data['subMenu'] = 'data-target="make-recipe_item"';
        $this->data['confirmation'] = null;
        
        $this->data['make_recipe'] = $this->action->read('recipe_item', ['trash'=> 0]);

        $this->load->view($this->data['privilege']. '/includes/header', $this->data);
        $this->load->view($this->data['privilege']. '/includes/aside', $this->data);
        $this->load->view($this->data['privilege']. '/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/make_recipe', $this->data);
        $this->load->view($this->data['privilege']. '/includes/footer', $this->data);
    }
    

    public function addRecipe() {  
        $this->data['confirmation'] = null; 
        
        $slug = str_replace(' ', '_' , strtolower($this->input->post('name')));
        
        $data = array(
            'date'          => date('Y-m-d'),
            'code'          => categoryUniqueId('recipe_item'),
            'slug'          => $slug,
            'name'          => $this->input->post('name')
        );

        $msg_array = array(
            'title' => 'success',
            'emit'  => 'Data Successfully Saved!',
            'btn'   => true
        );

        if(! $this->action->exists('recipe_item', array('slug' => $slug))){
            $this->data['confirmation'] = message($this->action->add('recipe_item', $data), $msg_array);
        } else {
            $options = array(
                'title' => 'warning',
                'emit'  => '<p>This Data already exists!</p>',
                'btn'   => true
            );
            $this->data['confirmation'] = message('warning', $options); 
        }

        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('recipe/make_recipe/make_recipe','refresh');
    }


    public function editRecipe($id = NULL) {       
        $this->data['active'] = 'data-target="recipe_menu"';
        $this->data['subMenu'] = 'data-target="make-recipe_item"';
        $this->data['recipe'] = null;

        $this->data['id'] = $id;
        $this->data['recipe'] = $this->action->read("recipe_item", array('id' => $id));

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/recipe/nav', $this->data);
        $this->load->view('components/recipe/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    

    public function edit($id=NULL) {  
        $this->data['confirmation'] = null;   

        $slug = str_replace(' ', '_' , strtolower($this->input->post('name')));
        
        $data = array(
            'name' => $this->input->post('name'),
            'slug'     => $slug
        );

        $msg_array = array(
            'title' => 'update',
            'emit'  => 'Data Successfully Updated!',
            'btn'   => true
        );
        
        if(! $this->action->exists('recipe_item', array('slug' => $slug))){
            $status = $this->action->update('recipe_item', $data, array('id' => $id));
            $this->data['confirmation'] = message($status, $msg_array);
        } else {
            $options = array(
                'title' => 'warning',
                'emit'  => '<p>This data already exists!</p>',
                'btn'   => true
            );
            $this->data['confirmation'] = message('warning', $options); 
        }
        
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('recipe/make_recipe/make_recipe','refresh');
    }


    public function deleteRecipe($id=NULL) {  
        $this->data['confirmation'] = null;     

        $msg_array=array(
            'title' => 'delete',
            'emit'  => 'Data Successfully Deleted!',
            'btn'   => true
        );
        
        $data = array('trash' => 1);
        
        $status = $this->action->update('recipe_item', $data, array('id' => $id));
        $this->data['confirmation'] = message($status, $msg_array);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('recipe/make_recipe/make_recipe/', 'refresh');

    }
    
    
    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
