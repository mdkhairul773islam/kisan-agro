<?php

class Daily_payment extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
        $this->data['meta_title']   = 'Pay Roll';
        $this->data['confirmation'] = null;
        $this->data['active']       = 'data-target="salary_menu"';
    }

    // show create form
    public function index()
    {
        $this->data['subMenu'] = 'data-target="daily-payment"';
        $this->data['results'] = null;

        // Save Data
        if (isset($_POST['show'])) {

            $year         = (!empty($_POST['year']) ? $_POST['year'] : date('Y'));
            $month        = (!empty($_POST['month']) ? $_POST['month'] : date('m'));
            $type         = (!empty($_POST['type']) ? $_POST['type'] : '');
            $payment_date = (date('Y-m-t', strtotime(($year . '-' . $month))));

            $this->data['results'] = custom_query("SELECT employee.emp_id, employee.name, employee.mobile, employee.designation, employee.path, salary.adjust_amount, employee.basic_salary, bonus.bonus, overtime.overtime, salary_records.previous_paid, advanced_payment.advance_paid FROM( SELECT id, emp_id, name, mobile, type, path, designation, employee_salary as basic_salary FROM employee WHERE type='$type' AND status='active')employee LEFT JOIN ( SELECT emp_id, adjust_amount FROM salary WHERE MONTH(payment_date)=MONTH(DATE_ADD('$payment_date',INTERVAL -1 MONTH)) AND trash=0 )salary ON employee.emp_id=salary.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) as previous_paid FROM salary_records WHERE YEAR(payment_date)='$year' AND MONTH(payment_date)='$month' AND trash=0 GROUP BY emp_id )salary_records ON employee.emp_id=salary_records.emp_id LEFT JOIN ( SELECT emp_id, bonus FROM bonus WHERE YEAR(bonus_date)='$year' AND MONTH(bonus_date)='$month' AND trash=0 )bonus ON employee.emp_id=bonus.emp_id LEFT JOIN ( SELECT emp_id, SUM(ABS(TIMESTAMPDIFF(hour, start_time, end_time)) * hourly_rate) as overtime FROM overtime WHERE YEAR(date)='$year' AND MONTH(date)='$month' AND trash=0 GROUP BY emp_id ) overtime ON employee.emp_id=overtime.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) as advance_paid FROM advanced_payment WHERE YEAR(payment_date)='$year' AND MONTH(payment_date)='$month' AND trash=0 GROUP BY emp_id )advanced_payment ON employee.emp_id=advanced_payment.emp_id ORDER BY emp_id ASC");
        }


        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/daily-payment', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // store data
    public function store()
    {
        if (isset($_POST['save'])) {
            if (!empty($_POST['id'])) {
                foreach ($_POST['id'] as $key) {
                    $data = [
                        "created_at" => $_POST['created_at'],
                        "emp_id"     => $_POST['emp_id'][$key],
                        "attendance"     => $_POST['attendance'][$key],
                        "salary"     => $_POST['salary'][$key],
                        "bonus"      => $_POST['bonus'][$key],
                        "payment"    => $_POST['payment'][$key],
                    ];

                    $where = [
                        "created_at" => $_POST['created_at'],
                        "emp_id"     => $_POST['emp_id'][$key],
                        "trash"      => 0
                    ];

                    if (check_exists('daily_wages', $where)) {
                        save_data('daily_wages', $data, $where);
                    } else {
                        save_data('daily_wages', $data);
                    }
                }
            }

            $msg = [
                "title" => "Success",
                "emit"  => "Payment Successfully Paid",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('success', $msg));
        }

        redirect('salary/daily_payment', 'refresh');
    }

    // show all data
    public function show_all()
    {
        $this->data['subMenu'] = 'data-target="daily-payment-list"';
        $this->data['results'] = null;

        // get all employee
        $this->data['allEmployee'] = get_result('employee', '', ['emp_id', 'name', 'mobile'], '', '', '', '', '', [['type' , ['Daily', 'Weekly']]]);


        // get all data
        $this->data['results'] = $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/salary/salary-nav', $this->data);
        $this->load->view('components/salary/daily-payment-list', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer');
    }

    // search all data
    private function search()
    {

        $where = ['daily_wages.trash' => 0];

        if (isset($_POST['show'])) {

            if (!empty($_POST['search'])){
                foreach ($_POST['search'] as $key => $value) {
                    if (!empty($value)){
                        $where['daily_wages.'.$key] = $value;
                    }
                }
            }

            if (!empty($_POST['type'])){
                $where['employee.type'] = $_POST['type'];
            }

            if (!empty($_POST['date'])){
                foreach ($_POST['date'] as $key => $value) {
                    if (!empty($value) && $key == 'from'){
                        $where['daily_wages.created_at >='] = $value;
                    }
                    if (!empty($value) && $key == 'to'){
                        $where['daily_wages.created_at <='] = $value;
                    }
                }
            }

        }else{
            $where['daily_wages.created_at'] = date('Y-m-d');
        }

        $select = ['daily_wages.*', 'employee.name', 'employee.mobile', 'employee.present_address'];

        return get_join('daily_wages', 'employee', 'daily_wages.emp_id=employee.emp_id', $where, $select);
    }

    // delete data
    public function delete($id = null){

        if (!empty($id)){

            save_data('daily_wages', ['trash' => 1], ['id' => $id]);

            $msg = [
                "title" => "delete",
                "emit"  => "Payment successfully deleted",
                "btn"   => true
            ];

            $this->session->set_flashdata('confirmation', message('danger', $msg));
        }

        redirect('salary/daily_payment/show_all', 'refresh');
    }

}
