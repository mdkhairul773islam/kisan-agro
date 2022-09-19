<?php

class Client extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');

    }

    public function index()
    {
        $this->data['meta_title']   = 'add';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store()
    {
        if (isset($_POST['save'])) {

            $initialBalance = ($_POST['status'] == 'payable' ? '-' : '') . $_POST['balance'];

            $data = [
                'opening'         => date('Y-m-d'),
                'godown_code'     => $this->input->post('godown_code'),
                'code'            => $this->input->post('code'),
                'sr_id'           => $this->input->post('sr_id'),
                'name'            => $this->input->post('name'),
                'contact_person'  => $this->input->post('contact_person'),
                'mobile'          => $this->input->post('mobile'),
                'address'         => $this->input->post('address'),
                'initial_balance' => $initialBalance,
                'credit_limit'    => $this->input->post('credit_limit'),
                'due_limit'       => $this->input->post('due_limit'),
                'type'            => 'client'
            ];
            
            $types = "JPEG|jpeg|jpg|JPG|png|PNG|gif|GIF|doc|docx|DOC|DOCX|PDF|pdf|webp"; 
            $path  = "upload/images";
            
            if(!empty($_FILES['loan']['name'])){
                $data['loan'] = file_upload("loan", "upload/images/loan", $types);
            }
            if(!empty($_FILES['agreement']['name'])){
                $data['agreement'] = file_upload("agreement", "upload/images/agreement", $types);
            }
            if(!empty($_FILES['nid']['name'])){
                $data['nid'] = file_upload("nid", "upload/images/nid", $types);
            }
            if(!empty($_FILES['trade_license']['name'])){
                $data['trade_license'] = file_upload("trade_license", "upload/images/trade_license", $types);
            }

            save_data('parties', $data);

            $msg = [
                'title' => 'success',
                'emit'  => 'Client add successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect("client/client", "refresh");
    }


    public function view_all()
    {
        $this->data['meta_title'] = 'all';
        $this->data['active']     = 'data-target="client_menu"';
        $this->data['subMenu']    = 'data-target="all"';


        $this->data['results'] = get_result('parties', ['type' => 'client', 'trash' => 0]);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function preview($id = null)
    {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="client_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $this->data['info'] = $info = get_row('parties', ['id' => $id]);

        if (empty($this->data['info'])) redirect('client/client/view_all', 'refresh');

        // get party balance info
        $this->data['balanceInfo'] = get_client_balance($info->code);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/preview', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function edit($id = null)
    {
        $this->data['meta_title']   = 'edit';
        $this->data['active']       = 'data-target="client_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $this->data['info'] = $info = get_row('parties', ['id' => $id]);

        if (empty($this->data['info'])) redirect('client/client/view_all', 'refresh');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function update($id = null)
    {
        if (isset($_POST['update']) && !empty($id)) {

            $initialBalance = ($_POST['balance_type'] == 'payable' ? '-' : '') . $_POST['balance'];

            $data = [
                'name'            => $this->input->post('name'),
                'sr_id'           => $this->input->post('sr_id'),
                'contact_person'  => $this->input->post('contact_person'),
                'mobile'          => $this->input->post('mobile'),
                'address'         => $this->input->post('address'),
                'status'          => $this->input->post('status'),
                'initial_balance' => $initialBalance,
                'credit_limit'    => $this->input->post('credit_limit'),
                'due_limit'       => $this->input->post('due_limit'),
                'type'            => 'client'
            ];
            
            $types = "JPEG|jpeg|jpg|JPG|png|PNG|gif|GIF|doc|docx|DOC|DOCX|PDF|pdf|webp"; 
            $path  = "upload/images";
            
            $client_records = get_row('parties', ['id'=>$id], ['loan', 'agreement', 'nid', 'trade_license']);
            
            if(!empty($_FILES['loan']['name'])){
                if(!empty($client_records->loan)){
                    unlink($client_records->loan);
                }
                $data['loan'] = file_upload("loan", "upload/images/loan", $types);
            }
            if(!empty($_FILES['agreement']['name'])){
                if(!empty($client_records->agreement)){
                    unlink($client_records->agreement);
                }
                $data['agreement'] = file_upload("agreement", "upload/images/agreement", $types);
            }
            if(!empty($_FILES['nid']['name'])){
                if(!empty($client_records->nid)){
                    unlink($client_records->nid);
                }
                $data['nid'] = file_upload("nid", "upload/images/nid", $types);
            }
            if(!empty($_FILES['trade_license']['name'])){
                if(!empty($client_records->trade_license)){
                    unlink($client_records->trade_license);
                }
                $data['trade_license'] = file_upload("trade_license", "upload/images/trade_license", $types);
            }

            save_data('parties', $data, ['id' => $id]);

            $msg = [
                'title' => 'update',
                'emit'  => 'Client update successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect("client/client/view_all", "refresh");
    }


    public function commission_paid()
    {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="client_menu"';
        $this->data['subMenu']    = 'data-target="paid"';
        $this->data['sapInfo']    = null;
        $where                    = array("trash" => 0);
        $this->data['info']       = $this->action->read('parties', $where);

        if (isset($_POST['show'])) {
            $where                 = array('saprecords.party_code' => $this->input->post('party_code'));
            $joincond              = "saprecords.voucher_no = sapmeta.voucher_no";
            $this->data['sapInfo'] = $this->action->joinAndRead("saprecords", "sapmeta", $joincond, $where);
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/client/nav', $this->data);
        $this->load->view('components/client/commission_paid', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    /**
     * update table
     *
     * update sapmeta table using voucher-number from saprecords
     * update sapitems table using voucher-number from saprecords
     * update saprecords table using party-code
     *
     * update partytransactionmeta table using transaction_id from partytransaction:id
     * update partytransaction table using party_code
     *
     * update partybalance table using code
     * update partymeta table using party_code
     * update parties table using code
     *
     */
    public function delete($code = null)
    {
        $data = ['trash' => 1];

        // update sapmeta, sapitems
        $where  = ['party_code' => $code, 'trash' => 0];
        $sapRec = get_result('saprecords', $where, 'voucher_no');

        if (!empty($sapRec)) {
            foreach ($sapRec as $key => $value) {

                // update sapmeta
                save_data('sapmeta', $data, ['voucher_no' => $value->voucher_no]);

                // update sapitems
                save_data('sapitems', $data, ['voucher_no' => $value->voucher_no]);
            }
        }

        // update sap records
        save_data('saprecords', $data, $where);

        // update table using transaction_id from
        $transactionRec = get_result('partytransaction', $where);
        if (!empty($transactionRec)) {
            foreach ($transactionRec as $key => $value) {
                $this->action->update('partytransactionmeta', $data, ['transaction_id' => $value->id]);
            }
        }

        // update partytransaction table using party_code
        $this->action->update('partytransaction', $data, $where);

        // update parties table using code 
        $this->action->update('parties', $data, ['code' => $code]);

        $msg = [
            "title" => "Deleted",
            "emit"  => "Client delete successful.",
            "btn"   => true
        ];

        $this->session->set_flashdata('confirmation', message("danger", $msg));

        redirect('client/client/view_all', 'refresh');
    }


}
