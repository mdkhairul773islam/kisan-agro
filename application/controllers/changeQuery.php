<?php

class ChangeQuery extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('action');
    }
    
    public function index() {
        
        die();
        $productList = custom_query("SELECT * FROM `materials`");
    	
    
    	$count = 1;
    	foreach($productList as $key => $row) {
    	    
    	    $pCode = get_code($count, 4);
    		
    		save_data('materials', ['code' => $pCode], ['id' => $row->id]);
    		
    		$count++;
    	}
    	
    }

}
