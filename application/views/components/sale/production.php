<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }

    }

    .mb-5 {
        margin-bottom: 10px;
    }
</style>


<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Production List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body none">
                <?php echo form_open('', ['id' => 'form']); ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="department" class="form-control">
                                <option value="" selected>-- Select Department --</option>
                                <?php
                                if (!empty($allDepartment)) {
                                    foreach ($allDepartment as $d_value) {
                                        echo '<option value="' . $d_value->department_name . '"' . (!empty($_POST['department']) && $_POST['department'] == $d_value->department_name ? 'selected' : '') . '>' . filter($d_value->department_name) . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="category" class="form-control">
                                <option value="" selected>-- Select Recipe --</option>
                                <?php
                                if (!empty($allCategory)) {
                                    foreach ($allCategory as $c_value) {
                                        echo '<option value="' . $c_value->code . '"' . (!empty($_POST['category']) && $_POST['category'] == $c_value->code ? 'selected' : '') . '>' . filter($c_value->category) . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>


                    <?php /*
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="order_time" class="form-control">
                                    <option value="" selected>-- Production Time --</option>
                                    <?php
                                    $order_times = config_item('order_time');
                                    if (!empty($order_times)) {
                                        foreach ($order_times as $value) {
                                            echo '<option value="' . $value . '" ' . (!empty($_POST['order_time']) && $_POST['order_time'] == $value ? "selected" : "") . '>' . filter($value) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    */?>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="From (YYYY-MM-DD)"
                                       value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')) ?>">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="To (YYYY-MM-DD)"
                                       value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')) ?>">
                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <hr class="none" style="margin-top: 0px;">


            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide"
                    style="margin: 0px 0px 5px; "> <?php echo(!empty($_POST['order_time']) ? filter($_POST['order_time']) : '') ?>
                    Production List</h4>
                <small class="text-center hide"
                       style="margin-bottom: 20px;">Date: <?php echo date('Y-m-d - h:m:s:A') ?></small>


                <?php if (!empty($result)) { ?>

                    <table class="table table-bordered " id="DataTable">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Weight</th>
                            <th>Total Weight (Kg)</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $totalWeight = $totalQuantity = 0;
                        foreach ($result as $key => $row) { ?>
                            <tr>
                                <td><?php echo($key + 1); ?></td>
                                <td><?php echo $row->product_code; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->unit; ?></td>
                                <td>
                                    <?php
                                    $sumWhere = [
                                        'product_code' => $row->product_code,
                                        'sap_type'     => 'order',
                                        'stock_type'   => 'stock',
                                        'status'       => 'processing',
                                        'trash'        => 0,
                                    ];

                                    if (!empty($_POST['date'])) {
                                        foreach ($_POST['date'] as $_key => $value) {
                                            if (!empty($value) && $_key == 'from') {
                                                $sumWhere["sap_at >="] = $value;
                                            }
                                            if (!empty($value) && $_key == 'to') {
                                                $sumWhere["sap_at <="] = $value;
                                            }
                                        }
                                    }

                                    if (!empty($_POST['order_time'])) {
                                        $sumWhere['order_time'] = $_POST['order_time'];
                                    }

                                    $saleQty       = get_sum('sapitems', 'quantity', $sumWhere);
                                    $totalQuantity += !empty($saleQty) ? $saleQty : 0;
                                    echo !empty($saleQty) ? $saleQty : 0;
                                    ?>
                                </td>
                                <td><?php echo $row->weight; ?></td>
                                <td><?php $totalWeight += $saleQty * $row->weight;
                                    echo f_number($saleQty * $row->weight, 3); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-center"> Total</th>
                            <th> <?php echo f_number($totalQuantity, 3); ?> </th>
                            <th></th>
                            <th> <?php echo f_number($totalWeight, 3); ?> </th>
                        </tr>

                        </tbody>
                    </table>
                <?php } else {
                    echo '<p class="text-center"> <scrong> No data found....! </scrong> </p>';
                } ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>