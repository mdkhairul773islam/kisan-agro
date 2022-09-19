<?php
class Depriciation extends Admin_Controller {
    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
    }

    public function index() {
        $this->data['meta_title']   = 'Depriciation';
        $this->data['active']       = 'data-target="depriciation_menu"';
        $this->data['subMenu']      = 'data-target="add-new"';
        $this->data['confirmation'] = null;
        
        $this->data['showroom'] = $this->getGodowns();

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/depriciation/nav', $this->data);
        $this->load->view('components/depriciation/add', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

    public function addDepriciation(){
        $this->data['confirmation'] = null;
        $data = array(
            'date'          => $this->input->post('date'),
            'godown_code'      => $this->input->post('godown_code'),
            'amount'        => $this->input->post('amount'),
            'particulars'   => trim($this->input->post('particulars'))
        );
        $options = array(
            'title' => 'success',
            'emit'  => 'Depriciation Successfully Saved!',
            'btn'   => true
        );
        
        //chack depriciation table
        $this->data['confirmation'] = message($this->action->add('depriciation', $data), $options);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('depriciation/depriciation','refresh');
    }



    public function allDepriciation(){
        $this->data['meta_title']   = 'Depriciation';
        $this->data['active']       = 'data-target="depriciation_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;
        
        $where = array('trash' => 0);
        
        if($this->input->post('show')) {
            if($this->input->post('dateFrom'))      $where['date >='] = $this->input->post('dateFrom');
            if($this->input->post('dateTo'))        $where['date <='] = $this->input->post('dateTo');
            if($this->input->post('godown_code'))   $where['godown_code'] = $this->input->post('godown_code');
        }
        
        
        $this->data['result']   = $this->action->read("depriciation", $where);
        $this->data['showroom'] = $this->getGodowns();
        
        $this->data['godown_code'] = $this->input->post('godown_code') ? $this->input->post('godown_code'):'';

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/depriciation/nav', $this->data);
        $this->load->view('components/depriciation/all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }
    
    public function edit($id){
        $this->data['active']       = 'data-target="depriciation_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['depriciation'] = null;
        $this->data['confirmation'] = null;
        
        $where = array('trash' => 0, 'id' => $id);
        
        if($this->input->post('submit')) {
            
            $data = array(
                'date'          => $this->input->post('date'),
                'godown_code'   => $this->input->post('godown_code'),
                'amount'        => $this->input->post('amount'),
                'particulars'   => trim($this->input->post('particulars'))
            );
            $options = array(
                'title' => 'success',
                'emit'  => 'Depriciation Successfully Updated!',
                'btn'   => true
            );
            
            //chack depriciation table
            $this->data['confirmation'] = message($this->action->update('depriciation', $data, $where), $options);
            $this->session->set_flashdata('confirmation',$this->data['confirmation']);
            redirect('depriciation/depriciation','refresh');
        }
        
        
        $this->data['result']   = $this->action->read("depriciation", $where);
        
        $this->data['showroom'] = $this->getGodowns();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/depriciation/nav', $this->data);
        $this->load->view('components/depriciation/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    


    public function delete($id=NULL) {
        $this->data['confirmation'] = null;     

        $data  = array('trash' => 1);
        $where = array('id'=>$id);

        $msg_array = array(
            'title' => 'delete',
            'emit'  => 'Depriciation Successfully Deleted!',
            'btn'   => true
        );
        $this->data['confirmation'] = message($this->action->update('depriciation', $data, $where), $msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
        redirect('depriciation/depriciation/allDepriciation','refresh');
    }

    private function holder(){  
        if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }
     public function getGodowns(){
        $results = $this->action->read('godowns', ['trash' => 0]);
        $temp = [];
        
        foreach($results as $result) {
            $temp[$result->code] = $result;
        }
        
        return $temp;
    }
}
