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
</style>

<?php $type = !empty($_GET['type']) ? $_GET['type'] : ''; ?>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title ">
                    <h1 class="pull-left"><?php echo filter($type); ?> Retail Collection List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <?php echo form_open();?>
                
                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="dateFrom" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="dateTo" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close();?>
                
                 <hr class="none">
                
                
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Cash Collection List</h4>

                <?php 
                $totalPaid = $totalRemission = 0;
                if (!empty($results)) {
                    ?>
                        <table class="table table-bordered " id="DataTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Vou No</th>
                                <th>Client's Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Paid</th>
                                <th>Remission</th>
                                <th class="none" width="60">Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            foreach ($results as $key => $row) {
                                
                                $partyInfo = json_decode($row->client_info, true);
                                $name      = filter($row->party_code);
                                $mobile    = check_null($partyInfo['mobile']);
                                $address   = check_null($partyInfo['address']);
                                
                                $totalPaid += $row->paid;
                                $totalRemission += $row->remission;
                                ?>
                                    <tr>
                                        <td> <?php echo ++$key; ?> </td>
                                        <td> <?php echo $row->date; ?> </td>
                                        <td> <?php echo $row->voucher_no; ?> </td>
                                        <td> <?php echo $name; ?> </td>
                                        <td> <?php echo $mobile; ?> </td>
                                        <td> <?php echo $address; ?> </td>
                                        <td class="text-right"> <?php echo $row->paid; ?> </td>
                                        <td class="text-right"> <?php echo $row->remission; ?> </td>
                                        <td class="none">
                                            <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete this data.')"
                                               href="<?php echo site_url('due_list/due_list/deleteCollection/' . $row->id); ?>">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            ?>
                            </tbody>

                            <tfooter>
                                <tr>
                                    <th colspan="6" class="text-right"><strong>Total</strong></th>
                                    <th class="text-right"><?php echo $totalPaid; ?> Tk</th>
                                    <th class="text-right"><?php echo $totalRemission; ?> Tk</th>
                                    <th class="none">&nbsp;</th>
                                </tr>
                            </tfooter>
                        </table>

                    <?php } else {
                        echo '<p class="text-center"> <strong> No data found....! </strong> </p>';
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!-- style for data table -->
<link rel="stylesheet" href="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.css') ?>">
<script src="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('#DataTable').DataTable({
            "paging": false
            "info": false,
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

    .dataTables_wrapper label {
        font-weight: initial;
    }

    table.dataTable thead th,
    table.dataTable {
        border-bottom: transparent;
    }

    table.dataTable.no-footer {
        border-bottom: transparent;
    }

    table.dataTable tfoot th,
    table.dataTable tfoot td {
        border-top: transparent;
    }

    table.dataTable.display tbody td {
        border-top: transparent;
        border-right: transparent;
    }
</style>