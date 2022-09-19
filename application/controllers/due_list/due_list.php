<?php

class Due_list extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title'] = 'All Client Dues';
        $this->data['active']     = 'data-target="due_list_menu"';
        $type                     = !empty($_GET['type']) ? $_GET['type'] : '';
        $this->data['subMenu']    = 'data-target="' . $type . '"';

        // get data for cash client
        if ($type == 'cash') {
            $where                = ['sap_type' => 'cash', 'status' => 'sale', 'payment_status !=' => 'paid', 'trash' => 0];
            $this->data['result'] = get_result('saprecords', $where, ['party_code', 'client_info', 'voucher_no', 'total_bill', 'paid', 'sap_at']);
        }

        // get data for credit or supplier
        $where  = ['parties.trash' => 0];

        if ($type == 'credit') {
            $where['type']           = 'client';
        } else if ($type == 'supplier') {
            $where['type']           = 'supplier';
        }

        if ($type == 'credit' || $type == 'supplier') {
            $this->data['result'] = get_result('parties', $where);
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/due-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function due_collect()
    {
        $this->data['meta_title'] = 'Due Collect';
        $this->data['active']     = 'data-target="due_list_menu"';
        $this->data['subMenu']    = 'data-target="cash"';
        $this->data['result']     = [];

        // get sap records
        $this->data['info'] = get_row('saprecords', ['voucher_no' => $_GET['vno']], ['voucher_no', 'sap_at', 'party_code', 'client_info', 'total_bill', 'paid', 'due', 'godown_code', 'promise_date']);

        // save data
        if ($this->input->post('save')) {

            $data = array(
                'date'          => date('Y-m-d'),
                'voucher_no'    => $this->input->post('voucher_no'),
                'godown_code'   => $this->input->post('godown_code'),
                'previous_paid' => $this->input->post('previous_paid'),
                'paid'          => $this->input->post('paid'),
                'due'           => $this->input->post('due'),
                'remission'     => $this->input->post('remission')
            );

            save_data('due_collectio', $data);

            // update sap records
            if ($_POST['due'] == 0){
                save_data('saprecords',  ['payment_status' => 'paid'], ['voucher_no' => $_GET['vno']]);
            }

            $options = array(
                "title" => "Success",
                "emit"  => "Due Successfully Collect!",
                "btn"   => true
            );
            
            $this->data['confirmation'] = message("success", $options);
            $this->session->set_flashdata('confirmation', $this->data['confirmation']);
            redirect('due_list/due_list?type=cash', 'refresh');
        }

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/due-collect', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');

    }
    
    public function collection_list()
    {
        $this->data['meta_title'] = 'Due Collect';
        $this->data['active']     = 'data-target="due_list_menu"';
        $this->data['subMenu']    = 'data-target="collection-list"';
        
        $where = ['due_collectio.trash' => 0];
        
        if(isset($_POST['show'])){
            
            if(!empty($_POST['dateFrom'])){
                $where['due_collectio.date >='] = $_POST['dateFrom'];
            }
            
            if(!empty($_POST['dateTo'])){
                $where['due_collectio.date <='] = $_POST['dateTo'];
            }

        }else{

            $where['due_collectio.date'] = date('Y-m-d');
        }
        
        $select = ['due_collectio.*', 'saprecords.party_code', 'saprecords.client_info'];
        
        $this->data['results'] = get_join('due_collectio', 'saprecords', 'due_collectio.voucher_no=saprecords.voucher_no', $where, $select);
        
        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/due_list/nav', $this->data);
        $this->load->view('components/due_list/due-collection-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }
    
    public function deleteCollection($id = null){
        
        $info = get_row('due_collectio', ['id' => $id]);
        
        if(!empty($info)){
            
            save_data('due_collectio', ['trash' => 1], ['id' => $id]);
            
            save_data('saprecords',  ['payment_status' => 'due'], ['voucher_no' => $info->voucher_no]);
            
            $msg = [
                "title" => "delete",
                "emit"  => "Data delete successful.",
                "btn"   => true
            ];
            
            $this->session->set_flashdata('confirmation', message("danger", $msg));
        }
        
        redirect('due_list/due_list/collection_list', 'refresh');
    }

    //Sending SMS Start here
    private function sendSMS()
    {
        if ($this->input->post("send")) {
            $content = $this->input->post('message');
            foreach ($this->input->post("mobile") as $key => $num) {
                $message = send_sms($num, $content);
                $insert  = array(
                    'delivery_date'    => date('Y-m-d'),
                    'delivery_time'    => date('H:i:s'),
                    'mobile'           => $num,
                    'message'          => $content,
                    'total_characters' => strlen($message),
                    'total_messages'   => message_length(strlen($message)),
                    'delivery_report'  => $message
                );
                if ($message) {
                    $this->action->add('sms_record', $insert);
                }
            }
        }
    }

}