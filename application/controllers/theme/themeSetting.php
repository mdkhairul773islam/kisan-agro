<?php

class ThemeSetting extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Theme';
        $this->data['active']       = 'data-target="theme_menu"';
        $this->data['subMenu']      = 'data-target="logo"';
        $this->data['confirmation'] = null;


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/theme/nav', $this->data);
        $this->load->view('components/theme/general-settings', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // save site info
    public function save_site_info()
    {
        if (!empty($_POST['site_info'])){
            foreach ($_POST['site_info'] as $_key => $value) {
                $data = [
                    'config_key' => $_key,
                    'config_value' => $value
                ];

                // save or update data
                if (check_exists('tbl_config', ['config_key' => $_key])) {
                    save_data('tbl_config', $data, ['config_key' => $_key]);
                } else {
                    save_data('tbl_config', $data);
                }
            }
        }

        $msg = array(
            "title" => "success",
            "emit"  => "Site info save successfully",
            "btn"   => true
        );

        $this->data['confirmation'] = message("success", $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('theme/themeSetting', 'refresh');
    }

    // save print baner
    public function save_print_baner()
    {
        if (!empty($_FILES["print_baner"]["name"]) && $_FILES["print_baner"]["name"] != "") {

            // delete file
            if (!empty($_POST['old_print_baner'])) {
                if (file_exists($_POST['old_print_baner'])) {
                    unlink($_POST['old_print_baner']);
                }
            }

            // upload file
            $path = file_upload('print_baner', 'upload/config');

            // input data
            $data = [
                'config_key'   => 'print_baner',
                'config_value' => $path
            ];

            // save or update data
            if (check_exists('tbl_config', ['config_key' => 'print_baner'])) {
                $msg = array(
                    "title" => "success",
                    "emit"  => "Print banner updated successfully",
                    "btn"   => true
                );
                save_data('tbl_config', $data, ['config_key' => 'print_baner']);
            } else {

                $msg = array(
                    "title" => "success",
                    "emit"  => "Print banner save successfully",
                    "btn"   => true
                );
                save_data('tbl_config', $data);
            }
        }

        $this->data['confirmation'] = message("success", $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('theme/themeSetting', 'refresh');
    }

    // save site logo
    public function save_site_logo()
    {
        if (!empty($_FILES["site_logo"]["name"]) && $_FILES["site_logo"]["name"] != "") {

            // delete file
            if (!empty($_POST['old_site_logo'])) {
                if (file_exists($_POST['old_site_logo'])) {
                    unlink($_POST['old_site_logo']);
                }
            }

            // upload file
            $path = file_upload('site_logo', 'upload/config');

            // input data
            $data = [
                'config_key'   => 'site_logo',
                'config_value' => $path
            ];

            // save or update data
            if (check_exists('tbl_config', ['config_key' => 'site_logo'])) {

                $msg = array(
                    "title" => "success",
                    "emit"  => "Site logo updated successfully",
                    "btn"   => true
                );
                save_data('tbl_config', $data, ['config_key' => 'site_logo']);
            } else {

                $msg = array(
                    "title" => "success",
                    "emit"  => "Site logo save successfully",
                    "btn"   => true
                );
                save_data('tbl_config', $data);
            }
        }

        $this->data['confirmation'] = message("success", $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('theme/themeSetting', 'refresh');
    }

    // save fave baner
    public function save_fave_icon()
    {
        if (!empty($_FILES["fave_icon"]["name"]) && $_FILES["fave_icon"]["name"] != "") {

            // delete file
            if (!empty($_POST['old_fave_icon'])) {
                if (file_exists($_POST['old_fave_icon'])) {
                    unlink($_POST['old_fave_icon']);
                }
            }

            // upload file
            $path = file_upload('fave_icon', 'upload/config');

            // input data
            $data = [
                'config_key'   => 'fave_icon',
                'config_value' => $path
            ];

            // save or update data
            if (check_exists('tbl_config', ['config_key' => 'fave_icon'])) {

                $msg = array(
                    "title" => "success",
                    "emit"  => "Fave icon updated successfully",
                    "btn"   => true
                );
                save_data('tbl_config', $data, ['config_key' => 'fave_icon']);
            } else {

                $msg = array(
                    "title" => "success",
                    "emit"  => "Fave icon save successfully",
                    "btn"   => true
                );
                save_data('tbl_config', $data);
            }
        }

        $this->data['confirmation'] = message("success", $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('theme/themeSetting', 'refresh');
    }
}
       