<?php

class Lab_Controller extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();

        $this->data['errors']      = array();
        $this->data['site_name']   = config_item('site_name');
        $this->data['description'] = NULL;
        $this->load->helper('email');
    }
}

// for fornend
class Frontend_Controller extends Lab_Controller {

    function __construct() {
        parent::__construct();

        // Set default meta title
        $this->data['meta_title'] = 'Frontend meta title';
        $this->load->helper("confirmation");
        //$this->load->helper("custom");
        $this->load->helper("custom_helper");
        $this->load->library('session');

    }

}

// for backend
class Admin_Controller extends Lab_Controller {

    function __construct() {
        parent::__construct();

        // Set default meta title
        $this->data['meta_title'] = 'Backend meta title';
        $this->data['width']      = 'width';

        // Load helpers
        $this->load->helper('form');
        $this->load->helper("file");
        $this->load->helper("admin");
        $this->load->helper("custom");
        $this->load->helper("sms");
        $this->load->helper("confirmation");

        // get all godowns
        $this->data['allGodowns'] = getGodown();

        //set site config file
        $config_data = get_result('tbl_config');
        if(!empty($config_data)){
            foreach($config_data as $c_value){
                $this->config->set_item($c_value->config_key, $c_value->config_value);
            }
        }

        // Load libraties
        $this->load->library('form_validation');
        $this->load->library('session');

        // Load models
        $this->load->model('membership_m');

        // Login check
        $exception_uris = array(
            'access/users/login',
            'access/users/logout'
        );

        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->membership_m->loggedin() == FALSE) {
                redirect('access/users/login');
            } else {
                // set profile image
                // $status = json_decode($this->session->userdata('status'));
                $this->data['image']    = $this->session->userdata('image');
                $this->data['user_id']  = $this->session->userdata('user_id');
                $this->data['username'] = $this->session->userdata('username');
                $this->data['name']     = $this->session->userdata('name');
                $this->data['email']    = $this->session->userdata('email');
                $this->data['mobile']   = $this->session->userdata('mobile');
                $this->data['branch']   = $this->session->userdata('branch');

                $list_of_privilege       = config_item('privilege');
                $this->data['privilege'] = $this->session->userdata('privilege');
            }
        }
    }

}

// for subscriber
class Subscriber_Controller extends Lab_Controller
{

    function __construct()
    {
        parent::__construct();

        // Set default meta title
        $this->data['meta_title'] = 'Subscriber meta title';
        // Load libraties
        $this->load->library('form_validation');
        $this->load->library('session');
        // Load models
        $this->load->model('subscriber_m');
        $this->load->model('retrieve');

        $this->load->helper("custom");
        $this->load->helper("confirmation");

        // Login check
        $exception_uris = array(
            'access/subscriber/login',
            'access/subscriber/logout'
        );

        if (in_array(uri_string(), $exception_uris) == FALSE) {
            if ($this->subscriber_m->loggedin() == FALSE) {
                redirect('access/subscriber/login');
            } else {
                $this->data['opening']   = $this->session->userdata('opening');
                $this->data['code']      = $this->session->userdata('code');
                $this->data['photo']     = $this->session->userdata('photo');
                $this->data['username']  = $this->session->userdata('username');
                $this->data['name']      = $this->session->userdata('name');
                $this->data['email']     = $this->session->userdata('email');
                $this->data['type']      = $this->session->userdata('type');
                $this->data['status']    = $this->session->userdata('status');
                $this->data['contact']   = $this->session->userdata('contact');
                $this->data['address']   = $this->session->userdata('present_address');
                $this->data['showroom']  = $this->session->userdata('showroom');
                $this->data['privilege'] = $this->session->userdata('privilege');
            }
        }
    }

}


// for api
class APIController extends Lab_Controller
{
    protected $dataset = array();

    function __construct()
    {
        parent::__construct();

        //load the action model
        $this->load->model("action");

        // Load libraties
        $this->load->library('form_validation');

    }

}




