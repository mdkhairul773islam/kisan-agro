<?php 
class Crushing_client extends Admin_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');

    }

    public function index() {
        $this->data['meta_title']   = 'add';
        $this->data['active']       = 'data-target="crushing_client_menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        if(isset($_POST['add'])) {
            $data = array(
                'opening'        => date('Y-m-d'),
                'code'           => $this->input->post('code'),
                'name'           => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'mobile'         => $this->input->post('contact'),
                'address'        => $this->input->post('address'),
                'type'           => "client"
            );
            
            $options = array(
                'title' => 'success',
                'emit'  => 'Information Successfully Saved!',
                'btn'   => true
            );
            
            // insert data into parties table
            $this->data['confirmation'] = message($this->action->add('crushing_parties', $data), $options);

            // insert data into partibalance table
            $data  = array();
            $data['balance'] = 0;

            $data['code']  = $this->input->post('code');
            $data['credit_limit']    = $this->input->post('credit_limit');
            $data['initial_balance'] =  $data['balance'] = $opening_balance = ($_POST['status'] == 'payable') ? (0 - $this->input->post('balance')) : $this->input->post('balance');

            $this->action->add('crushing_partybalance', $data);

			// set meta information into partymeta table
            $data = array(
                "party_code"    => $this->input->post("code"),
                "meta_key"      => "opening_balance",
                "meta_value"    => $data['balance']
            );

            $this->action->add("crushing_partymeta", $data);
            $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
            redirect("crushing_client/crushing_client","refresh");
        }

        //Get party Unique Id
        $this->data['party_id']      = clientUniqueId('crushing_parties');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function view_all() {
        $this->data['meta_title'] = 'all';
        $this->data['active']     = 'data-target="crushing_client_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $where =  array("type" => "client","trash" => 0);
        $partyInfo = $this->action->read('crushing_parties',$where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/view-all', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function preview() {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="crushing_client_menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $where= array('crushing_parties.code' => $this->input->get('partyCode'));
        $joincond = "crushing_parties.code = crushing_partybalance.code";
        $this->data['partyInfo'] = $this->action->joinAndRead("crushing_parties", "crushing_partybalance", $joincond, $where);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/preview', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function edit() {
        $this->data['meta_title']   = 'edit';
        $this->data['active']       = 'data-target="crushing_client_menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;

        $where = array("code" => $this->input->get("partyCode"));

        if(isset($_POST['update'])) {
            $data = array(
                'name'           => $this->input->post('name'),
                'contact_person' => $this->input->post('contact_person'),
                'mobile'         => $this->input->post('contact'),
                'address'        => $this->input->post('address'),
            );
            
            $options = array(
                'title' => 'success',
                'emit'  => 'Information Successfully Update!',
                'btn'   => true
            );
            
            // insert data into parties table
            $this->data['confirmation'] = message($this->action->update('crushing_parties', $data, $where), $options);

            // insert data into partybalance table
            $data = array();
            $data['code']            = $this->input->post('code');
            $data['credit_limit']    = $this->input->post('credit_limit');
            //$data['initial_balance'] =  $data['balance'] = $opening_balance = ($_POST['status'] == 'payable') ? (0 - $this->input->post('balance')) : $this->input->post('balance');

            $this->action->update('crushing_partybalance', $data,$where);

            $this->session->set_flashdata("confirmation",$this->data["confirmation"]);
            redirect("crushing_client/crushing_client/view_all","refresh");
        }

        $joinWhere = array('crushing_parties.code'=>$this->input->get('partyCode'));
        $joincond = "crushing_parties.code = crushing_partybalance.code";
        $this->data['info'] = $this->action->joinAndRead("crushing_parties", "crushing_partybalance", $joincond, $joinWhere);

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/edit', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }


    /*public function commission_paid() {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="client_menu"';
        $this->data['subMenu']    = 'data-target="paid"';
        $this->data['sapInfo']    = null;
        $where = array("trash"=>0);
        $this->data['info'] = $this->action->read('crushing_parties', $where);

        if (isset($_POST['show'])) {
            $where= array('saprecords.party_code' => $this->input->post('party_code'));
            $joincond = "saprecords.voucher_no = sapmeta.voucher_no";
            $this->data['sapInfo'] = $this->action->joinAndRead("saprecords", "sapmeta", $joincond, $where);
        }

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/crushing_client/nav', $this->data);
        $this->load->view('components/crushing_client/commission_paid', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }*/

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
    public function delete($id) {
        $data = array('trash' => 1);

        // update sapmeta, sapitems and saprecords table using voucher-number from saprecords 
        $where = array('party_code' => $id);
        $sapRec = $this->action->read('saprecords', $where);

        if($sapRec != null) {
            foreach ($sapRec as $key => $value) {
                $where = array('voucher_no' => $value->voucher_no);

                // update sapmeta
                $this->action->update('sapmeta', $data, $where);

                // update sapitems
                $where = array('party_code' => $id);
                $this->action->update('saprecords', $data, $where);
            }

            // update sapitems
            $where = array('party_code' => $id);
            $this->action->update('sapmeta', $data, $where);
        }

        // update partytransactionmeta table using transaction_id from partytransaction:id 
        $transactionRec = $this->action->read('crushing_partytransaction', $where);
        if($transactionRec != null) {
            foreach ($transactionRec as $key => $value) {
                $where = array('transaction_id' => $value->id);
                $this->action->update('crushing_partytransactionmeta', $data, $where);
            }
        }

        // update partytransaction table using party_code 
        $where = array('party_code' => $id);
        $this->action->update('crushing_partytransaction', $data, $where);

        // update partymeta table using party_code
        $this->action->update('crushing_partymeta', $data, $where);

        // update partybalance table using code
        $where = array('code' => $id); 
        $this->action->update('crushing_partybalance', $data, $where);

        // update parties table using code 
        $this->action->update('crushing_parties', $data, $where);

        $option = array(
            "title" => "Deleted",
            "emit"  => "Client Successfully Deleted!",
            "btn"   => true
        );
        
        $this->session->set_flashdata('confirmation', message("danger", $option));

        redirect('crushing_client/crushing_client/view_all', 'refresh');
    }

}
