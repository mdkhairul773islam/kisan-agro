<?php

class Supplier extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'add';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="add"';
        $this->data['confirmation'] = null;

        //Generate Unqiue ID
        $this->data['party_code'] = supplierUniqueId('parties');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/add', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function store()
    {
        if (isset($_POST['save'])) {

            $initialBalance = ($_POST['status'] == 'payable' ? '-' : '') . $this->input->post('balance');

            $data = [
                'opening'         => date('Y-m-d'),
                'code'            => $this->input->post('code'),
                'name'            => $this->input->post('name'),
                'contact_person'  => $this->input->post('contact_person'),
                'mobile'          => $this->input->post('mobile'),
                'address'         => $this->input->post('address'),
                'initial_balance' => $initialBalance,
                'type'            => "supplier"
            ];

            save_data('parties', $data);

            $msg = [
                'title' => 'success',
                'emit'  => 'Supplier Successfully Saved.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('supplier/supplier', 'refresh');
    }

    public function view_all()
    {
        $this->data['meta_title'] = 'all';
        $this->data['active']     = 'data-target="supplier-menu"';
        $this->data['subMenu']    = 'data-target="all"';

        // get all vendors
        $this->data['allParty'] = $this->getAllparty();

        $where = ["type" => "supplier", "trash" => 0];

        if (isset($_POST['show'])) {
            $where["parties.code"] = $_POST['party_code'];
        }

        $this->data['results'] = get_result("parties", $where);


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/view-all', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function preview($id = null)
    {
        $this->data['meta_title'] = 'view';
        $this->data['active']     = 'data-target="supplier-menu"';
        $this->data['subMenu']    = 'data-target="all"';

        $this->data['info'] = get_row('parties', ['id' => $id]);
        if (empty($this->data['info'])) redirect('supplier/supplier/view_all', 'refresh');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/preview', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function edit($id = null)
    {
        $this->data['meta_title']   = 'edit';
        $this->data['active']       = 'data-target="supplier-menu"';
        $this->data['subMenu']      = 'data-target="all"';
        $this->data['confirmation'] = null;


        $this->data['info'] = get_row('parties', ['id' => $id]);

        if (empty($this->data['info'])) redirect('supplier/supplier/view_all', 'refresh');

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/supplier/nav', $this->data);
        $this->load->view('components/supplier/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    public function update($id = null)
    {
        if (isset($_POST['update']) && !empty($id)) {

            $initialBalance = ($_POST['balance_type'] == 'payable' ? '-' : '') . $this->input->post('balance');

            $data = [
                'name'            => $this->input->post('name'),
                'contact_person'  => $this->input->post('contact_person'),
                'mobile'          => $this->input->post('mobile'),
                'address'         => $this->input->post('address'),
                'status'          => $this->input->post('status'),
                'initial_balance' => $initialBalance,
            ];

            save_data('parties', $data, ['id' => $id]);

            $msg = [
                'title' => 'update',
                'emit'  => 'Supplier update successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('supplier/supplier/view_all', 'refresh');
    }


    /**
     * update table:
     */
    public function delete($code)
    {
        $data = array("trash" => 1);

        // update party-transaction-meta table using id from party-transaction table
        $where          = array("party_code" => $code);
        $transactionRec = $this->action->read('partytransaction', $where);

        if ($transactionRec != null) {
            foreach ($transactionRec as $key => $value) {
                $where = array('transaction_id' => $value->id);
                $this->action->update('partytransactionmeta', $data, $where);
            }
        }

        // update party-transaction table using party-code
        $where = array("party_code" => $code);
        $this->action->update('partytransaction', $data, $where);

        // update party-meta table using party-code
        $this->action->update('partymeta', $data, $where);

        // update sapitems and sapmeta table using voucher-number from saprecords
        $sapRec = $this->action->read("saprecords", $where);

        if ($sapRec != null) {
            foreach ($sapRec as $key => $row) {
                $where = array("voucher_no" => $row->voucher_no);

                // update sapmeta
                $this->action->update('sapmeta', $data, $where);

                // update sapitems
                $this->action->update('sapitems', $data, $where);
            }
        }

        // update sapitems table using party-code from patries
        $where = array("party_code" => $code);
        $this->action->update('saprecords', $data, $where);

        // update party-balance table using party-code
        $where = array("code" => $code);
        $this->action->update('partybalance', $data, $where);

        // update parties table using party-code
        $status = $this->action->update('parties', $data, $where);

        $msg_array = array(
            "title" => "delete",
            "emit"  => "Supplier Successfully Deleted",
            "btn"   => true
        );

        $this->session->set_flashdata("confirmation", message($status, $msg_array));

        redirect('supplier/supplier/view_all', 'refresh');
    }


    private function getAllparty()
    {
        $where = [
            "type"   => "supplier",
            "status" => "active",
            "trash"  => 0
        ];

        return get_result("parties", $where);
    }


}
