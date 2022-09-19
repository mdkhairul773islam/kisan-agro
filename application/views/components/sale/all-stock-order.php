<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate
        {
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
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>View All Stock Order</h1>
                </div>

                <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                   onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body none">
                <?php echo form_open(); ?>
                <div class="row none">
                    <div class="col-md-3">
                        <div class="form-group">
                           <select name="search[party_code]"
                                    class="selectpicker form-control"
                                    data-show-subtext="true"
                                    data-live-search="true"
                                    ng-required="true">
                                <option value="" selected>-- Select client --</option>

                                <?php
                                if (!empty($allClients)) {
                                    foreach ($allClients as $key => $row) {
                                        ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo $row->code . '-' . filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]"
                                   value="<?= (!empty($_POST['search']['voucher_no']) ? $_POST['search']['voucher_no'] : '') ?>"
                                   placeholder="Enter voucher no"
                                   class="form-control mb-5">
                        </div>
                    </div>

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

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <hr class="none" style="margin-top: 0">

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">All Stock Order</h4>
                <?php
                if (!empty($allOrder)) { ?>
                    <table class="table table-bordered" id="DataTable">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Vou No</th>
                            <th>Client's Name</th>
                            <th>Weight (Kg)</th>
                            <th>Quantity</th>
                            <th>Total Amount (Tk)</th>
                            <th class="none" width="50">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $total_bill = $total_quantity = $totalwhight = [];
                        foreach ($allOrder as $key => $row) {
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td> <?php echo $row->voucher_no; ?> </td>
                                <td> <?php echo filter($row->name); ?> </td>
                                <td>
                                    <?php
                                    $voucher_no = $row->voucher_no;
                                    $weight     = get_sum('sapitems', 'total_weight', ['voucher_no' => $voucher_no, 'trash' => 0]);

                                    $weight = !empty($weight) ? $weight : 0;
                                    echo $weight;
                                    $totalwhight[] += $weight;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo $row->total_quantity;
                                    $total_quantity[] += $row->total_quantity;
                                    ?>
                                </td>
                                <td>
                                    <?php echo $row->total_bill;
                                    $total_bill[] += $row->total_bill; ?>
                                </td>

                                <td class="none text-center">
                                    <?php
                                    $status = get_result('sapitems', ['voucher_no' => $row->voucher_no], 'status', 'status');

                                    if (!empty($status)) {

                                        if ($status[0]->status == 'processing' && count($status) == 1) { ?>
                                            <a title="Sale" class="btn btn-success"
                                               href="<?php echo site_url("sale/order/sale/$row->voucher_no"); ?>">
                                                <i class="fa fa-truck" aria-hidden="true"></i>
                                            </a>
                                        <?php }
                                    } ?>


                                    <a title="View" class="btn btn-primary"
                                       href="<?php echo site_url("sale/factory_order/sale_voucher/$row->voucher_no"); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    <!--<a title="Edit" class="btn btn-warning"
                                       href="<?php /*echo site_url("sale/order/edit/$row->voucher_no"); */?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>

                                    <a title="Delete"
                                       onclick="return confirm('Are you sure to delete this data?');"
                                       class="btn btn-danger"
                                       href="<?php /*echo site_url("sale/order/delete/$row->voucher_no"); */?>">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>-->
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                        <tfoot>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <th><?php echo f_number(array_sum($totalwhight), 3); ?> Kg</th>
                            <th><?php echo array_sum($total_quantity); ?> </th>
                            <th><?php echo f_number(array_sum($total_bill)); ?> Tk</th>
                            <!--<th></th>-->
                            <th class="none"></th>
                        </tr>
                        </tfoot>
                    </table>
                <?php } else {
                    echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
                } ?>
            </div>

            <div class="panel-footer"> &nbsp;</div>
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>


<!-- style for data table -->
<link rel="stylesheet" href="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.css') ?>">
<script src="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#DataTable').DataTable({
            "pageLength": 50,
            lengthMenu: [
                [25, 50, 100, 250, 500, -1],
                ['25', '50', '100', '250', '500', 'all']
            ],
        });
    } );
</script>
<style>
    .dataTables_wrapper .dataTables_filter input{
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
    }
    table.dataTable thead th,
    table.dataTable{
        border-bottom: transparent;
    }
    table.dataTable.no-footer {
        border-bottom: transparent;
    }
    table.dataTable tfoot th, table.dataTable tfoot td{
        border-top: transparent;
    }
    table.dataTable.display tbody td{
        border-top: transparent;
        border-right: transparent;
    }
</style>
