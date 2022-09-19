<?php

class Banner extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }
    
    public function index($emit = NULL) {
        $this->data['meta_title'] = 'banner';
        $this->data['active'] = 'data-target="header_menu"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;

        if ($this->input->post("banner_save")) {

            $config['upload_path'] = './public/banner';
            $config['allowed_types'] = 'png|jpg|gif';
            $config['max_size'] = '1024';
            $config['max_width'] = '3000'; /* max width of the image file */
            $config['max_height'] = '3000';
            $config['file_name'] ="banner"; 
            $config['overwrite']=true;      
            
            $this->upload->initialize($config);
            // allternative for  $this->load->library('upload', $config);
            if($this->upload->do_upload('banner_image')){
                $upload_data= $this->upload->data();

                $data = array(
                    'path'=>"public/banner/".$upload_data['file_name'],
                    'date' => date('Y-m-d')
                );    
            }
            //Uploading End here;
            $d_count=mysql_num_rows(mysql_query("select*from banner"));//Checking data exist;
            $msg=null;
            if ($d_count<1) { 
            //Selection update or add Database
                if($this->action->add("banner",$data)){
                    $msg=true;
                }
            }
            else if($d_count>0){
                $where=array(
                "id"=>$this->input->post("banner_id")
                    );
                if ($this->action->update("banner",$data,$where)) {
                    $msg=true;
                }
            }            

            $msg_array=array(
                "title"=>"success",
                "emit"=>"Banner updated successfully",
                "btn"=>true
            );
            if ($msg!=null) {
                $this->data['confirmation']=message("success",$msg_array);
                $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            }
            //redirect('banner/banner','refresh');
            redirect('theme/themeSetting/','refresh');
        }

        $this->data['banner_info']=$this->action->read("banner");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/banner/banner', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
