<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

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
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Used</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Voucher No </label>
                    <div class="col-md-4">
                        <input type="text" name="search[voucher_no]" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">From </label>
                    <div class="input-group date col-md-4" id="datetimepickerFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To </label>
                    <div class="input-group date col-md-4" id="datetimepickerTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if (!empty($result)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">All Used Packaging</h4>

                    <table class="table table-bordered " id="DataTable">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Quantity</th>
                            <th>Total Bill (Tk)</th>
                            <th width="120" class="none">Action</th>
                        </tr>
                        </thead>


                        <tbody>
                        <?php
                        $total_bill = $total_quantity = 0;
                        foreach ($result as $key => $row) { ?>
                            <tr>
                                <td> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->created_at; ?> </td>
                                <td> <?php echo $row->voucher_no; ?> </td>
                                <td class="text-center">
                                    <?php
                                    $total_quantity +=$row->total_quantity;
                                    echo $row->total_quantity;
                                    ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $total_bill += $row->total_bill;
                                    echo f_number($row->total_bill);
                                    ?>
                                </td>

                                <td class="none">
                                    <a title="View" class="btn btn-primary"
                                       href="<?php echo site_url('packaging/used/preview/' . $row->voucher_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                    <a onclick="return confirm('Are you sure want to delete this Sale?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('packaging/used/delete/' . $row->voucher_no); ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>

                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>

                        <tfooter>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th class="text-center"><?= $total_quantity ?></th>
                                <th class="text-center"><?= $total_bill ?></th>
                                <th class="none">&nbsp;</th>
                            </tr>
                        </tfooter>
                    </table>
                </div>

                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>


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

<script>
    $(document).ready(function() {
        $('#DataTable').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, 250, 500, -1],
                ['25', '50', '100', '250', '500', 'all']
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, 'colvis'
            ]
        });
    } );
</script>
<style>
    .btn-group, .btn-group-vertical, .dataTables_info {
        float: left;
    }
    .dataTables_paginate{
        float: right;
    }
    div.dt-button-collection ul.dropdown-menu {
        min-width: 120px;
    }
</style>
