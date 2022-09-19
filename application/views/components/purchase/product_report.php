<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer, .dt-buttons, .dataTables_filter, .dataTables_info, .dataTables_paginate {
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
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Product Report</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body none">
                <?php echo form_open(); ?>
                <div class="col-md-2">
                    <div class="input-group date" id="datetimepickerFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="From (YYYY-MM-DD)"
                               value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '') ?>">
                        <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="input-group date" id="datetimepickerTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="To (YYYY-MM-DD)"
                               value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '') ?>">
                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>

                <div class="col-md-2">
                    <input type="submit" name="show" value="Show" class="btn btn-primary">
                </div>
                <?php echo form_close(); ?>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Raw Product Report</h4>

                <table class="table table-bordered " id="DataTable">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>P.Price</th>
                        <th>P.Amount</th>

                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $totalQuantity = $totalPurchaseAmount = 0;
                    if (!empty($results)) {
                        foreach ($results as $key => $row) {

                            $totalQuantity += round($row->quantity, 2);

                            $purchaseAmount = round(($row->purchase_price * $row->quantity), 2);

                            $totalQuantity       += round($row->quantity, 2);
                            $totalPurchaseAmount += $purchaseAmount;
                            ?>
                            <tr>
                                <td><?php echo($key + 1); ?></td>
                                <td><?php echo $row->product_code; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->unit; ?></td>
                                <td class="text-right"><?php echo round($row->quantity, 2); ?></td>
                                <td class="text-right"><?php echo round($row->purchase_price, 2); ?></td>
                                <td class="text-right"><?php echo $purchaseAmount; ?></td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>

                    <tfoot>
                    <th colspan="4" class="text-right">Total</th>
                    <th class="text-right"><?php echo $totalQuantity ?> </th>
                    <th></th>
                    <th class="text-right"><?php echo $totalPurchaseAmount; ?> TK</th>
                    </tfoot>
                </table>
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!-- style for data table -->
<link rel="stylesheet" href="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.css') ?>">
<script src="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#DataTable').DataTable({
            "paging": false,
            "info": false,
            /*"order": [[ 4, "desc" ]]*/
        });
    });
</script>
<style>
    .dataTables_wrapper .dataTables_filter input {
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
    table.dataTable {
        border-bottom: transparent;
    }

    table.dataTable.no-footer {
        border-bottom: transparent;
    }

    table.dataTable tfoot th, table.dataTable tfoot td {
        border-top: transparent;
    }

    table.dataTable.display tbody td {
        border-top: transparent;
        border-right: transparent;
    }
</style>
