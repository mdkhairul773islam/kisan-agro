<?php
class Edit_do_sale extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }
    /* Insert Do Sale Data Saprecords and SapItems Table */
    public function index()
    {
        $this->data['meta_title'] = 'DO Sale';
        $this->data['active'] = 'data-target="sale_menu"';
        $this->data['subMenu'] = 'data-target="all-do-sale"';
        $this->data['confirmation'] = null;

        $voucher_no = $_GET['vno'];

        if(!empty($voucher_no)){
            $select = ['godown_code', 'voucher_no', 'party_code', 'due_limit_reference'];
            $this->data['result'] = get_row("saprecords", ["voucher_no"=>$voucher_no, "trash"=>0], $select);
        }else{
            $this->data['result'] = [];
        }

        if (isset($_POST['save']))
        {
            /* Update Data To SapRecords  */
            $data = array(
                'sap_at'            => $this->input->post('date'),
                'voucher_no'        => $voucher_no,
                'total_bill'        => $this->input->post('total'),
                'total_quantity'    => $this->input->post('totalqty'),
                'paid'              => $this->input->post('paid'),
                'method'            => $this->input->post('method'),
            );

            if (!empty($this->input->post('due_limit_reference')))
            {
                $data['due_limit_reference'] = $this->input->post('due_limit_reference');
            }
            $status = false;
            $where = ['voucher_no'=> $voucher_no, 'status'=> 'do_sale'];
            if ($this->action->update('saprecords', $data, $where))
            {
                // update data to sapitems
                if (!empty($_POST['product_code']))
                {
                    foreach ($_POST['product_code'] as $key => $value)
                    {
                        $data = array(
                            'sap_at'            => $this->input->post('date'),
                            'voucher_no'        => $voucher_no,
                            'product_code'      => $_POST['product_code'][$key],
                            'purchase_price'    => $_POST['purchase_price'][$key],
                            'sale_price'        => $_POST['sale_price'][$key],
                            'order_quantity'    => $_POST['order_quantity'][$key],
                            'remaining_quantity' => $_POST['order_quantity'][$key],
                            'unit'              => $_POST['unit'][$key],
                            'bag_size'          => $_POST['bag_size'][$key],
                            'no_of_bag'         => $_POST['no_of_bag'][$key],
                            'godown_code'       => $_POST['godown_code'],
                            'status'            => 'do_sale',
                            'sap_type'          => 'credit'
                        );
                        /* sapitem records update statement here */
                        $id = $this->input->post('id')[$key];
                        if(!empty($id)){
                            $where      = ['id'=>$id, 'voucher_no'=> $voucher_no, 'status'=> 'do_sale'];
                            $status     = $this->action->update('sapitems', $data, $where);
                        }else{
                            $this->action->add('sapitems', $data);
                        }
                    }
                }
            }

            //delete items
            if (!empty($_POST['delete_id'])) {
                foreach ($_POST['delete_id'] as $key => $value) {
                    // update sapitems
                    $where = ['id' => $value, 'product_code'=>$_POST['delete_code'][$key]];
                    save_data('sapitems', ['trash' => 1], $where);
                }
            }
            
            $options = array(
                'title' => 'success',
                'emit' => 'DO Sale successfully Completed!',
                'btn' => true
            );
            $this->data['confirmation'] = message($status, $options);
            redirect('sale/do_sale/doSaleInvoice?vno=' . $voucher_no, 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/sale/nav', $this->data);
        $this->load->view('components/sale/edit-do-sale', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
}
