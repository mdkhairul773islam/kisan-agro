<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// get dd
if (!function_exists('dd')) {
    function dd($value = null)
    {
        if (!empty($value)) {
            echo '<pre style="color: #fff; background: #000; padding: 10px; border-radius: 4px;">';
            print_r($value);
            die();
            echo '</pre>';
        }
        return false;
    }
}


// get hour deferance
if (!function_exists('hour_difference')) {
    function hour_difference($date_1, $date_2)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($date_1) && !empty($date_2)) {

            $interval = $ci->db->query("SELECT ABS(TIMESTAMPDIFF(hour, '$date_1', '$date_2')) AS hour")->row();
            return $interval->hour;
        }
        return false;
    }
}

// get date format
if (!function_exists('get_date_format')) {
    function get_date_format($date, $format = 'Y-m-d')
    {

        if (!empty($date)) {
            return date($format, strtotime($date));
        }
        return false;
    }
}

// get encode
if (!function_exists('get_encode')) {
    function get_encode($value = null, $formate = '')
    {
        if (!empty($value)) {
            if (!empty($formate)) {
                return $formate(base64_encode($value));
            } else {
                return $encode = base64_encode($value);
            }
        }
        return false;
    }
}

// get decode
if (!function_exists('get_decode')) {
    function get_decode($value = null, $formate = '')
    {
        if (!empty($value)) {
            if (!empty($formate)) {
                return base64_decode($formate($value));
            } else {
                return $encode = base64_decode($value);
            }
        }
        return false;
    }
}

// save data
if (!function_exists('get_voucher')) {
    function get_voucher($id, $digite = 6, $prefix = null)
    {
        if (!empty($id)) {
            if (!empty($prefix)) {
                $counter = $prefix . date('ym') . str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            } else {
                $counter = date('ym') . str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            }
        }
        return false;
    }
}

// code generate
if (!function_exists('get_code')) {
    function get_code($id, $digite = 3, $prefix = null)
    {
        if (!empty($id)) {
            if (!empty($prefix)) {
                $counter = $prefix . str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            } else {
                $counter = str_pad($id, $digite, 0, STR_PAD_LEFT);
                return $counter;
            }
        }
        return false;
    }
}

// save data
if (!function_exists('get_table_code')) {
    function get_table_code($table, $digite = 3, $where = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        //get data from databasea
        if (!empty($table)) {

            if (!empty($where)) {
                $CI->db->where($where);
            }

            $total_row = $CI->db->count_all_results($table);

            $counter = str_pad(++$total_row, $digite, 0, STR_PAD_LEFT);
            return $counter;
        }
        return false;
    }
}

// get number formate
if (!function_exists('get_number_format')) {
    function get_number_format($number = null, $decimal = 2)
    {
        if (!empty($number)) {
            return number_format($number, $decimal);
        }
        return 0;
    }
}


// get filter
if (!function_exists('get_filter')) {
    function get_filter($input_string = null)
    {
        if (!empty($input_string)) {
            $input_string = str_replace("_", " ", $input_string);
            if (mb_detect_encoding($input_string) != 'UTF-8') {
                $result = ucwords($input_string);
            } else {
                $result = $input_string;
            }

            return $result;
        }
        return false;
    }
}

// get date deferance
if (!function_exists('date_difference')) {
    function date_difference($date_1, $date_2, $format = '%h')
    {
        if (!empty($date_1) && !empty($date_2)) {
            $datetime1 = date_create($date_1);
            $datetime2 = date_create($date_2);

            $interval = date_diff($datetime1, $datetime2);

            return $interval->format($format);
        }
        return false;
    }
}

// save data
if (!function_exists('save_data')) {
    function save_data($table, $data = [], $where = [], $action = false)
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        //get data from databasea
        if (!empty($table) && !empty($data)) {
            if (!empty($where)) {
                $CI->db->where($where);
                $CI->db->update($table, $data);
                return true;
            } else {
                if ($action) {
                    $CI->db->insert($table, $data);
                    return $CI->db->insert_id();
                } else {
                    $CI->db->insert($table, $data);
                    return true;
                }
            }
        }
        return false;
    }
}


// delete data
if (!function_exists('delete_data')) {
    function delete_data($table, $where = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();
        if (!empty($table) && !empty($where)) {
            $CI->db->where($where);
            $CI->db->delete($table);
            return true;
        }
        return false;
    }
}


// convert number
if (!function_exists('convert_number')) {
    function convert_number($input_number, $convert_language = 'en')
    {
        $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
        $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

        if ($convert_language == 'bn') {
            return str_replace($en, $bn, $input_number);
        } else {
            return str_replace($bn, $en, $input_number);
        }
        return false;
    }
}

// custom query
if (!function_exists('custom_query')) {
    function custom_query($query = null, $return_type = false, $action = true)
    {
        //get main CodeIgniter object
        $ci =& get_instance();
        //get data from databasea
        if (!empty($query) && $action == true) {

            if ($return_type) {
                return $ci->db->query($query)->row();
            } else {
                return $ci->db->query($query)->result();
            }
        } else if (!empty($query) && $action == false) {

            return $ci->db->query($query);
        }
        return false;
    }
}

// get supplier client
if (!function_exists('get_supplier_balance')) {
    function get_supplier_balance($party_code = null, $tran_id = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        $data = [
            'code'            => '',
            'name'            => '',
            'initial_balance' => 0,
            'debit'           => 0,
            'commission'      => 0,
            'credit'          => 0,
            'balance'         => 0,
            'status'          => 'Receivable',
        ];

        if (!empty($party_code)) {

            // get party info
            $tranId   = (!empty($tran_id) ? ' AND id < ' . $tran_id : '');
            $tranInfo = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.commission, partytransaction.credit FROM ( SELECT code, name, initial_balance FROM parties WHERE code='$party_code' AND type ='supplier' AND trash=0 )parties LEFT JOIN ( SELECT party_code, sum(debit) AS debit, sum(commission) AS commission, SUM(credit) AS credit FROM partytransaction WHERE trash=0 {$tranId} GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code")->row();

            if (!empty($tranInfo)) {
                $initialBalance = (!empty($tranInfo->initial_balance) ? $tranInfo->initial_balance : 0);
                $debit          = (!empty($tranInfo->debit) ? $tranInfo->debit : 0);
                $commission     = (!empty($tranInfo->commission) ? $tranInfo->commission : 0);
                $credit         = (!empty($tranInfo->credit) ? $tranInfo->credit : 0);

                $balance = ($debit + $commission) - $credit + $initialBalance;

                $data['code']            = $tranInfo->code;
                $data['name']            = $tranInfo->name;
                $data['initial_balance'] = $initialBalance;
                $data['debit']           = $debit;
                $data['commission']      = $commission;
                $data['credit']          = $credit;
                $data['balance']         = round($balance, 2);
                $data['status']          = ($balance < 0 ? "Payable" : "Receivable");
            }
        }

        return (object)$data;
    }
}

// get supplier client
if (!function_exists('get_client_balance')) {
    function get_client_balance($party_code = null, $tran_id = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        $data = [
            'code'            => '',
            'name'            => '',
            'initial_balance' => 0,
            'debit'           => 0,
            'credit'          => 0,
            'remission'       => 0,
            'balance'         => 0,
            'status'          => 'Receivable',
        ];

        if (!empty($party_code)) {

            // get party info
            $tranId   = (!empty($tran_id) ? ' AND id < ' . $tran_id : '');
            $tranInfo = $ci->db->query("SELECT parties.code, parties.name, parties.initial_balance, partytransaction.debit, partytransaction.credit , partytransaction.remission FROM ( SELECT code, name, initial_balance FROM parties WHERE code='$party_code' AND type ='client' AND trash=0 )parties LEFT JOIN ( SELECT party_code, sum(debit) AS debit, SUM(credit) AS credit, SUM(remission) AS remission FROM partytransaction WHERE trash=0 {$tranId} GROUP BY party_code )partytransaction ON parties.code=partytransaction.party_code")->row();

            if (!empty($tranInfo)) {

                $initialBalance = (!empty($tranInfo->initial_balance) ? $tranInfo->initial_balance : 0);
                $remission      = (!empty($tranInfo->remission) ? $tranInfo->remission : 0);
                $debit          = (!empty($tranInfo->debit) ? $tranInfo->debit : 0);
                $credit         = (!empty($tranInfo->credit) ? $tranInfo->credit : 0);

                $balance = $debit - ($credit + $remission) + $initialBalance;

                $data['code']            = $tranInfo->code;
                $data['name']            = $tranInfo->name;
                $data['initial_balance'] = $initialBalance;
                $data['debit']           = $debit;
                $data['credit']          = $credit;
                $data['remission']       = $remission;
                $data['balance']         = $balance;
                $data['status']          = ($balance < 0 ? "Payable" : "Receivable");
            }
        }

        return (object)$data;
    }
}


// get employee salary
if (!function_exists('get_employee_salary')) {
    function get_employee_salary($empID = '', $date = '')
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        if (!empty($empID)) {

            $createDate = (!empty($date) ? $date : date('Y-m-d'));

            $previousMonth = date('Y-m-t', strtotime(date('Y-m', strtotime($createDate)) . " -1 month"));

            $paymentMonth = date('Y-m-t', strtotime($createDate));

            $data = [
                'emp_id'           => '',
                'name'             => '',
                'employee_salary'  => 0,
                'deduction_amount' => 0,
                'advance_paid'     => 0,
                'paid_amount'      => 0,
                'due_salary'       => 0,
            ];
            
            // get salary info
            $previousSalaryInfo = $CI->db->query("SELECT employee.emp_id, employee.name, employee.employee_salary, IFNULL(salary.total_salary, 0) AS total_salary, IFNULL(salary_records.paid, 0) AS paid_amount, IFNULL(advanced_payment.advance_paid, 0) AS advance_paid FROM ( SELECT emp_id, name, employee_salary FROM `employee` WHERE emp_id='$empID' AND trash=0 ) employee LEFT JOIN ( SELECT emp_id, total_salary FROM `salary` WHERE emp_id='$empID' AND payment_date='$previousMonth' AND trash=0 )salary ON employee.emp_id=salary.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) AS paid FROM `salary_records` WHERE emp_id='$empID' AND payment_date='$previousMonth' AND trash=0 )salary_records ON employee.emp_id=salary_records.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) AS advance_paid FROM `advanced_payment` WHERE emp_id='$empID' AND payment_date='$previousMonth' AND trash=0 )advanced_payment ON employee.emp_id=advanced_payment.emp_id")->row();
            $salaryInfo = $CI->db->query("SELECT employee.emp_id, employee.name, employee.employee_salary, IFNULL(salary.total_salary, 0) AS total_salary, IFNULL(salary_records.paid, 0) AS paid_amount, IFNULL(advanced_payment.advance_paid, 0) AS advance_paid FROM ( SELECT emp_id, name, employee_salary FROM `employee` WHERE emp_id='$empID' AND trash=0 ) employee LEFT JOIN ( SELECT emp_id, total_salary FROM `salary` WHERE emp_id='$empID' AND payment_date='$paymentMonth' AND trash=0 )salary ON employee.emp_id=salary.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) AS paid FROM `salary_records` WHERE emp_id='$empID' AND payment_date='$paymentMonth' AND trash=0 )salary_records ON employee.emp_id=salary_records.emp_id LEFT JOIN ( SELECT emp_id, SUM(amount) AS advance_paid FROM `advanced_payment` WHERE emp_id='$empID' AND payment_date='$paymentMonth' AND trash=0 )advanced_payment ON employee.emp_id=advanced_payment.emp_id")->row();
            
            if (!empty($salaryInfo)) {
                
                $preSalary    = (!empty($previousSalaryInfo->total_salary) ? $previousSalaryInfo->total_salary : 0);
                $preDueSalary = $preSalary - ($previousSalaryInfo->advance_paid + $previousSalaryInfo->paid_amount);
                
                $salary    = (!empty($salaryInfo->total_salary > 0) ? $salaryInfo->total_salary : $salaryInfo->employee_salary);
                $dueSalary = $salary - ($salaryInfo->advance_paid + $salaryInfo->paid_amount) + $preDueSalary;

                $data['emp_id']           = $salaryInfo->emp_id;
                $data['name']             = $salaryInfo->name;
                $data['employee_salary']  = $salaryInfo->employee_salary;
                $data['adjust_amount']    = $preDueSalary;
                $data['advance_paid']     = $salaryInfo->advance_paid;
                $data['paid_amount']      = $salaryInfo->paid_amount;
                $data['due_salary']       = $dueSalary;
            }

            return (object)$data;
        }
    }
}


// get row
if (!function_exists('get_row')) {
    function get_row($table, $where = [], $select = null)
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        //get data from databasea
        if (!empty($where)) {

            // get select column
            if (!empty($select)) {
                $CI->db->select($select);
            }

            $query = $CI->db->where($where)->get($table);

            return $query->row();
        }
        return false;
    }
}


// get name
if (!function_exists('get_name')) {
    function get_name($table, $select_column = null, $where = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        //get data from databasea
        if (!empty($table) && !empty($select_column) && !empty($where)) {

            // get select column
            $CI->db->select($select_column);
            $CI->db->where($where);

            $query = $CI->db->get($table);

            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result->$select_column;
            }

            return false;
        }

        return false;
    }
}


// get all data
if (!function_exists('get_result')) {
    function get_result($table, $where = null, $select = null, $groupBy = null, $order_col = null, $order_by = 'ASC', $limit = null, $limit_offset = null, $where_in = null, $like = null, $not_like = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($table)) {
            // select column
            if (!empty($select)) {
                $ci->db->select($select);
            }

            //get where
            if (!empty($where)) {
                $ci->db->where($where);
            }

            //get where in
            if (!empty($where_in)) {
                if (is_array($where_in)) {
                    foreach ($where_in as $value) {
                        $ci->db->where_in($value[0], $value[1]);
                    }
                }
            }

            // get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }

            // order by
            if (!empty($order_col) && !empty($order_by)) {
                $ci->db->order_by($order_col, $order_by);
            }

            // get limit
            if (!empty($limit) && !empty($limit_offset)) {
                $ci->db->limit($limit, $limit_offset);
            } elseif (!empty($limit)) {
                $ci->db->limit($limit);
            }

            // get like
            if (!empty($like)) {
                $ci->db->like($like);
            }

            // get not like
            if (!empty($not_like)) {
                $ci->db->not_like($not_like);
            }

            // get query
            $query = $ci->db->get($table);
            return $query->result();
        }
        return false;
    }
}


// get join all data
if (!function_exists('get_join')) {
    function get_join($tableFrom, $tableTo, $joinCond, $where = [], $select = null, $groupBy = null, $order_col = null, $order_by = 'ASC', $limit = null, $limit_offset = null, $where_in = null, $like = null, $not_like = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond)) {

            // get all query
            if (!empty($select)) {
                $ci->db->select($select);
            }

            $ci->db->from($tableFrom);

            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $ci->db->join($to_value, $joinCond[$_key]);
                    }
                } else {
                    $ci->db->join($tableTo, $joinCond);
                }
            }

            // get where
            if (!empty($where)) {
                $ci->db->where($where);
            }

            //get where in
            if (!empty($where_in)) {
                if (is_array($where_in)) {
                    foreach ($where_in as $value) {
                        $ci->db->where_in($value[0], $value[1]);
                    }
                }
            }

            // get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }

            // order by
            if (!empty($order_col) && !empty($order_by)) {
                $ci->db->order_by($order_col, $order_by);
            }

            // get limit
            if (!empty($limit) && !empty($limit_offset)) {
                $ci->db->limit($limit, $limit_offset);
            } elseif (!empty($limit)) {
                $ci->db->limit($limit);
            }

            // get like
            if (!empty($like)) {
                $ci->db->like($like);
            }

            // get not like
            if (!empty($not_like)) {
                $ci->db->not_like($not_like);
            }

            // get query
            $query = $ci->db->get();
            return $query->result();

        } else {
            return false;
        }
    }
}

// get left join all data
if (!function_exists('get_left_join')) {
    function get_left_join($tableFrom, $tableTo, $joinCond, $where = [], $select = null, $groupBy = null, $order_col = null, $order_by = 'ASC', $limit = null, $limit_offset = null, $where_in = null, $like = null)
    {
        //get main CodeIgniter object
        $ci =& get_instance();

        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond)) {

            // get all query
            if (!empty($select)) {
                $ci->db->select($select);
            }

            // get table form
            $ci->db->from($tableFrom);

            // get join
            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $ci->db->join($to_value, $joinCond[$_key], 'left');
                    }
                } else {
                    $ci->db->join($tableTo, $joinCond, 'left');
                }
            }

            // get where
            if (!empty($where)) {
                $ci->db->where($where);
            }

            // get like
            if (!empty($like)) {
                $ci->db->like($like);
            }

            //get where in
            if (!empty($where_in)) {
                if (is_array($where_in)) {
                    foreach ($where_in as $value) {
                        $ci->db->where_in($value[0], $value[1]);
                    }
                }
            }

            // get group by
            if (!empty($groupBy)) {
                $ci->db->group_by($groupBy);
            }

            // order by
            if (!empty($order_col) && !empty($order_by)) {
                $ci->db->order_by($order_col, $order_by);
            }

            // get limit
            if (!empty($limit) && !empty($limit_offset)) {
                $ci->db->limit($limit, $limit_offset);
            } elseif (!empty($limit)) {
                $ci->db->limit($limit);
            }

            // get query
            $query = $ci->db->get();
            return $query->result();

        } else {
            return false;
        }
    }
}


// get row join
if (!function_exists('get_row_join')) {
    function get_row_join($tableFrom, $tableTo, $joinCond, $where = [], $select = [])
    {
        //get main CodeIgniter object
        $ci =& get_instance();


        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond) && !empty($where)) {

            // get all query
            if (!empty($select)) {
                $ci->db->select($select);
            }

            $ci->db->from($tableFrom);

            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $ci->db->join($to_value, $joinCond[$_key], 'left');
                    }
                } else {
                    $ci->db->join($tableTo, $joinCond, 'left');
                }
            }

            $ci->db->where($where);

            // get query
            $query = $ci->db->get();
            return $query->row();
        }
        return false;
    }
}


// get pagination
if (!function_exists('get_pagination')) {
    function get_pagination($pag_query = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        if (array_key_exists('select', $pag_query)) {
            $CI->db->select($pag_query['select']);
        }

        if (array_key_exists('where', $pag_query)) {
            $CI->db->where($pag_query['where']);
        }

        $search = '';
        if (!empty($_GET)) {
            $CI->db->where($_GET);

            $search .= '?';

            $i     = 1;
            $count = count($_GET);
            foreach ($_GET as $_key => $s_value) {
                if ($count == 1) {
                    $search .= $_key . '=' . $s_value;
                } else {
                    if ($i != $count) {
                        $search .= $_key . '=' . $s_value . '&';
                    } else {
                        $search .= $_key . '=' . $s_value;
                    }
                    $i++;
                }
            }
        }

        $total_row = $CI->db->count_all_results($pag_query['table']);

        if (array_key_exists('per_page', $pag_query)) {
            $per_page = $pag_query['per_page'];
        } else {
            $per_page = 10;
        }

        // pagination config
        $config               = [];
        $config["base_url"]   = base_url() . $pag_query['url'] . '/';
        $config["total_rows"] = $total_row;
        $config["per_page"]   = $per_page;
        $config['suffix']     = $search;

        // initialize pagination
        $CI->pagination->initialize($config);

        $page = ($CI->uri->segment($pag_query['segment'])) ? $CI->uri->segment($pag_query['segment']) : 0;

        $return_data["links"] = $CI->pagination->create_links();


        if (array_key_exists('where', $pag_query)) {
            $CI->db->where($pag_query['where']);
        }

        if (!empty($_GET)) {
            $CI->db->where($_GET);
        }

        $CI->db->limit($per_page, $page);

        $query = $CI->db->get($pag_query['table']);

        if ($query->num_rows() > 0) {
            $return_data['results'] = $query->result();
            return $return_data;
        }
        return false;
    }
}


// get sum
if (!function_exists('get_sum')) {
    function get_sum($table, $column, $where = [], $groupBy = null)
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        //get data from databasea
        if (!empty($where) && $CI->db->field_exists($column, $table)) {
            //get data from databasea
            $CI->db->select_sum($column);
            $CI->db->where($where);
            //get group by
            if (!empty($groupBy)) {
                $CI->db->group_by($groupBy);
            }
            $query = $CI->db->get($table);

            if ($query->num_rows > 0) {
                $result = $query->row();
                return $result->$column;
            } else {
                return 0;
            }
        } else {
            return false;
        }
    }
}


// get join sum
if (!function_exists('get_join_sum')) {
    function get_join_sum($tableFrom, $tableTo, $joinCond, $column, $where = [], $groupBy = null)
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        if (!empty($tableFrom) && !empty($tableTo) && !empty($joinCond) && !empty($column) && !empty($where)) {

            // get all query
            if (!empty($column)) {
                $CI->db->select_sum($column);
            }

            $CI->db->from($tableFrom);

            if (!empty($tableTo) && !empty($joinCond)) {
                if (is_array($tableTo) && is_array($tableTo)) {
                    foreach ($tableTo as $_key => $to_value) {
                        $CI->db->join($to_value, $joinCond[$_key]);
                    }
                } else {
                    $CI->db->join($tableTo, $joinCond);
                }
            }

            $CI->db->where($where);

            //get group by
            if (!empty($groupBy)) {
                $CI->db->group_by($groupBy);
            }

            // get column name
            $column = explode('.', $column);
            if (count($column) > 1) {
                $column = $column[1];
            } else {
                $column = $column;
            }

            // get query
            $query = $CI->db->get();
            if ($query->num_rows > 0) {
                $result = $query->row();
                return $result->$column;
            } else {
                return 0;
            }

        }
        return false;
    }
}


// get max value
if (!function_exists('get_max')) {
    function get_max($table, $column, $where = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        //get data from databasea
        if (!empty($where) && $CI->db->field_exists($column, $table)) {
            //get data from databasea
            $CI->db->select_max($column);
            $CI->db->where($where);
            $query = $CI->db->get($table);

            if ($query->num_rows() > 0) {
                $result = $query->row();
                return $result->$column;
            } else {
                return 0.00;
            }
        } else {
            return false;
        }
    }
}


// file upload
if (!function_exists('file_upload')) {
    function file_upload($fileName, $dir_path = "upload", $file_type = null, $prefix = "img")
    {
        if ($_FILES[$fileName]["name"] != null or $_FILES[$fileName]["name"] != "") {

            if (!empty($file_type)) {
                $f_type = $file_type;
            } else {
                $f_type = 'png|jpeg|jpg|gif';
            }
            $config                  = [];
            $config['upload_path']   = './public/' . $dir_path;
            $config['allowed_types'] = $f_type;
            $config['max_size']      = '5120';
            $config['max_width']     = '2560';
            $config['max_height']    = '2045';
            $config['file_name']     = $prefix . '-' . time() . rand();
            $config['overwrite']     = true;

            $CI = &get_instance();
            $CI->upload->initialize($config);

            if ($CI->upload->do_upload($fileName)) {
                $upload_data = $CI->upload->data();

                $filePath = 'public/' . $dir_path . '/' . $upload_data['file_name'];

                return $filePath;
            } else {
                return false;
            }
        }
    }
}


// get input data
if (!function_exists('input_data')) {
    function input_data($input_name = null)
    {
        if (!empty($input_name)) {
            if (is_array($input_name)) {
                $new_data = [];
                foreach ($input_name as $val) {
                    $new_data[$val] = htmlspecialchars(trim($_POST[$val]));
                }
                return $new_data;
            } else {
                return htmlspecialchars(trim($_POST[$input_name]));
            }
        } else {
            return false;
        }
    }
}

// create slug
if (!function_exists('slug')) {
    function slug($input_data = null, $replace = '-')
    {
        if (!empty($input_data)) {
            return str_replace(' ', $replace, strtolower($input_data));
        } else {
            return false;
        }
    }
}


// check exists
if (!function_exists('check_exists')) {
    function check_exists($table, $where = [])
    {
        //get main CodeIgniter object
        $CI =& get_instance();

        if (!empty($table) && !empty($where)) {

            $CI->db->where($where);
            $query = $CI->db->get($table);
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


// check null
if (!function_exists('check_null')) {
    function check_null($input_data = null, $return_value = 'N/A')
    {
        if (!empty($input_data) && $input_data != "") {
            return $input_data;
        } else {
            return $return_value;
        }
    }

    // check auth
    if (!function_exists('checkAuth')) {
        function checkAuth($privilege = null)
        {
            //get main CodeIgniter object
            $ci =& get_instance();

            if (!empty($privilege)) {
                if ($ci->data['privilege'] == $privilege) {
                    return true;
                }
                return false;
            }
            return false;
        }
    }
}

// cc loan
if (!function_exists('get_acc_info')){
    function get_acc_info($acc_no = null,$trx_date)
    {
        //get main CodeIgniter object
        $ci =& get_instance();
        
        $data = [];
        
        //get data from databasea
       
       
            $data['acc_no']          = $acc_no;
            $total_payable_interest = 0;
            $total_loan_rcv = $total_loan_paid = $total_loan_charge = $total_loan_due = $total_interest_paid = $total_payable_interest = $day_count = $single_day_interest = 0;
            
            $acc_info = get_result('cc_loan_trx',['acc_no' => $acc_no],'','','id','asc');
            $count_acc_info = count($acc_info);
            if(!empty($acc_info)){
              
                foreach($acc_info as  $key => $value){
                    $percentage = $value->percentage;
                    $total_loan_rcv += $value->loan_rcv;
                    $total_loan_paid += $value->loan_paid;
                    $total_loan_charge += $value->loan_charge;
                    $total_interest_paid += $value->interest_paid;
                    $start_date = $value->trx_date;
                    
                  
                
                    if(!empty($acc_info[$key+1])){
                       $end_date = $acc_info[$key+1]->trx_date;
                    }else{
                         if($value->loan_close_date == null){
                            $end_date = $trx_date;
                         }else{
                              $end_date = $value->loan_close_date;
                         }
                    }
                        
                   
                    $date_start =date_create($start_date);
                    $date_end =date_create($end_date);
                    $diff=date_diff($date_start,$date_end);
                    $day_count =$diff->format("%a");
                    
                   
                    $loan_due = $total_loan_rcv - $total_loan_paid - $total_loan_charge;
                    //$single_day_interest = ($percentage*$loan_due)/36500;
                    $single_day_interest = ($loan_due > 0 ? ($percentage*$loan_due)/36500 : 0);
                    $total_payable_interest += $single_day_interest*$day_count;
                }
                 
            }
            $data['total_loan_rcv']         = $total_loan_rcv;
            $data['total_loan_paid']        = $total_loan_paid;
            $data['total_loan_due']         = $total_loan_rcv - $total_loan_paid;
            $data['total_interest_paid']    = $total_interest_paid;
            $data['total_payable_interest'] = $total_payable_interest;
            //$data['total_interest_due']     = abs($total_payable_interest - $total_interest_paid);
            $data['total_interest_due']     = ($data['total_loan_due'] > 0) ? abs($total_payable_interest - $total_interest_paid) : 0;
            $data['day_count']              = $day_count;
            $data['current_balance']         = ($total_loan_rcv - $total_loan_paid) + ($total_payable_interest - $total_interest_paid);

    
        return $data;
    }
}

/* Get Godwown List */
if (!function_exists('getGodown')) {
    function getGodown($select = null)
    {
        $ci =& get_instance();
        if (!empty($select)) {
            $ci->db->select($select);
        }
        $query = $ci->db->get('godowns');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}


// set site config file
//$config_data = get_result('tbl_config');
//if(!empty($config_data)){
//    foreach($config_data as $c_value){
//        $this->config->set_item($c_value->config_key, $c_value->config_value);
//    }
//}