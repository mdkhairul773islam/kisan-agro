<?php

class Material extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;



        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view_all()
    {
        $this->data['meta_title']   = '';
        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = ['type' => 'raw', 'trash' => 0];
        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $_key => $value) {
                    if (!empty($value)) {
                        $where["$_key"] = $value;
                    }
                }
            }
        }

        $this->data['allRawMaterial'] = get_result('materials',  $where, ['id', 'code', 'name',  'raw_type', 'price', 'status']);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/view_all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function edit($id = null)
    {

        $this->data['active']       = 'data-target="row_material_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        // get result
        if (!empty($id)) {
            $this->data['info'] = get_row('materials', ['id' => $id]);
        } else {
            redirect('material/material/view_all', 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/material/nav', $this->data);
        $this->load->view('components/material/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    // save data update
    public function store()
    {
        // input data
        $data             = input_data(['name', 'code', 'price', 'stock_alert']);
        $data['raw_type'] = $this->input->post('raw_type');
        $data['date']     = date('Y-m-d');
        $data['type']     = 'raw';

        if (!empty($_POST['status'])){
            $data['status'] = $_POST['status'];
        }
        // check exists
        $existsWhere = ['code' => $_POST['code'], 'type' => 'raw'];
        if (check_exists('materials', $existsWhere)) {

            // update data
            $msg = [
                'title' => 'success',
                'emit'  => 'Material Successfully Updated.',
                'btn'   => true
            ];
            
            save_data('materials', $data, $existsWhere);
            
            // update product name in stock
            if(check_exists('stock', $existsWhere)){
                
                $sData = [
                    'name' => $_POST['name'],
                    'purchase_price' => $_POST['price'],
                ];
                
                save_data('stock', $sData, $existsWhere);
            }
            
        } else {

            // save data
            $msg = [
                'title' => 'success',
                'emit'  => 'Material Successfully Saved.',
                'btn'   => true
            ];
            
            save_data('materials', $data);
        }

        $this->data['confirmation'] = message('success', $msg);
        $this->session->set_flashdata('confirmation', $this->data['confirmation']);
        redirect('material/material/view_all', 'refresh');
    }


    public function delete($id = NULL)
    {
        if (!empty($id)) {
            $msg = array(
                "title" => "delete",
                "emit"  => "Material Successfully Deleted....!",
                "btn"   => true
            );
            save_data('materials', ['trash' => 1], ['id' => $id]);

            $this->data['confirmation'] = message('success', $msg);
            $this->session->set_flashdata("confirmation", $this->data['confirmation']);
            redirect("material/material/view_all", "refresh");
        } else {
            redirect('material/material/view_all', 'refresh');
        }
    }

}
