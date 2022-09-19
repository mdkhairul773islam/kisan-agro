<?php class Transport extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['meta_title'] = 'Transport Management';
        $this->data['active']     = 'data-target="transport_menu"';
    }

    public function index()
    {
        $this->data['subMenu']      = 'data-target="allTransport"';
        $this->data['confirmation'] = null;

        $where = ['trash' => 0];

        if (isset($_POST['show'])) {
            if (!empty($_POST['search'])) {
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)) {
                        $where[$key] = $value;
                    }
                }
            }
        }

        $this->data['results'] = get_result('transport', $where);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/transport/nav', $this->data);
        $this->load->view('components/transport/index', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }


    public function create()
    {
        $this->data['subMenu']      = 'data-target="createTransport"';
        $this->data['confirmation'] = null;

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/transport/nav', $this->data);
        $this->load->view('components/transport/create', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    public function store()
    {
        if (isset($_POST['save'])) {

            $data = [
                'created'      => $this->input->post('created'),
                'company_name' => $this->input->post('company_name'),
                'name'         => $this->input->post('manager_name'),
                'mobile'       => $this->input->post('mobile'),
                'email'        => $this->input->post('email'),
                'address'      => $this->input->post('address'),
                'remarks'      => $this->input->post('remarks'),
            ];

            save_data('transport', $data);

            $msg = [
                'title' => 'success',
                'emit'  => 'Transport add successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect('transport/transport/create', 'refresh');
    }

    public function edit($id = null)
    {
        $this->data['subMenu']      = 'data-target="allTransport"';
        $this->data['confirmation'] = null;

        $this->data['info'] = get_row('transport', ['id' => $id]);

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/transport/nav', $this->data);
        $this->load->view('components/transport/edit', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }

    public function update($id = null)
    {
        if (isset($_POST['update']) && !empty($id)) {

            $data = [
                'created'      => $this->input->post('created'),
                'company_name' => $this->input->post('company_name'),
                'name'         => $this->input->post('manager_name'),
                'mobile'       => $this->input->post('mobile'),
                'email'        => $this->input->post('email'),
                'address'      => $this->input->post('address'),
                'remarks'      => $this->input->post('remarks'),
            ];

            save_data('transport', $data, ['id' => $id]);

            $msg = [
                'title' => 'update',
                'emit'  => 'Transport update successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('success', $msg));
        }

        redirect('transport/transport', 'refresh');
    }

    public function delete($id = null)
    {
        if (!empty($id)) {

            save_data('transport', ['trash' => 1], ['id' => $id]);

            $msg = [
                'title' => 'delete',
                'emit'  => 'Transport delete successful.',
                'btn'   => true
            ];

            $this->session->set_flashdata("confirmation", message('danger', $msg));
        }

        redirect('transport/transport', 'refresh');
    }
}
