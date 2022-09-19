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

        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Item Wise Used</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>




            <div class="panel-body none">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="row">
                    <label for="" class="col-md-1 control-label">From</label>
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')) ?>" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <label for="" class="col-md-1 control-label">To</label>
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')) ?>" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>

                    <div class="col-md-2 mb-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>




            <hr style="margin-top: 0px;" class="none">





            <?php if (!empty($result)) { ?>
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">All Raw Used</h4>

                    <table class="table table-bordered " id="DataTable">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>P.ID</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Amount (Tk)</th>
                        </tr>
                        </thead>


                        <tbody>
                        <?php
                        $totalAmount = 0;
                        foreach ($result as $key => $row) {
                            $totalAmount += $row['amount'];
                            ?>
                            <tr>
                                <td> <?php echo ++$key; ?> </td>
                                <td> <?php echo $row['code']; ?> </td>
                                <td> <?php echo $row['name']; ?> </td>
                                <td> <?php echo $row['unit']; ?> </td>
                                <td> <?php echo get_number_format($row['purchase_price']); ?> </td>
                                <td> <?php echo $row['quantity']; ?> </td>
                                <td class="text-center">
                                    <?php
                                    echo get_number_format($row['amount']);
                                    ?>
                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>

                        <tfooter>
                            <tr>
                                <th colspan="6" class="text-right">Total Amount</th>
                                <th class="text-center"><?= get_number_format($totalAmount) ?></th>
                            </tr>
                        </tfooter>
                    </table>
                </div>
            <?php }else{
                echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
            } ?>


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

<script>
    $(document).ready(function () {
        $('#DataTable').DataTable({
            "pageLength": 200,
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
    });
</script>
<style>
    .btn-group, .btn-group-vertical, .dataTables_info {
        float: left;
    }

    .dataTables_paginate {
        float: right;
    }

    div.dt-button-collection ul.dropdown-menu {
        min-width: 120px;
    }
</style>
