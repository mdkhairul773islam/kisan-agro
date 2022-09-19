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
                    <h1 class="pull-left"><?php echo ($type == 'cash') ? 'Retail' : 'Dealer'; ?> Due List</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;"><?php echo filter($type); ?> Due List</h4>

                <?php
                if ($type == 'cash') {
                    if (!empty($result)) {
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
                                <th>Amount</th>
                                <th class="none">Action</th>
                            </tr>
                            </thead>


                            <tbody>
                            <?php
                            $totalAmount = 0;
                            $count = 1;
                            foreach ($result as $key => $row) {
                                
                                $partyInfo = json_decode($row->client_info, true);
                                $name      = filter($row->party_code);
                                $mobile    = check_null($partyInfo['mobile']);
                                $address   = check_null($partyInfo['address']);

                                $duePaid = custom_query("SELECT IFNULL(SUM(paid + remission), 0) AS due_paid FROM due_collectio WHERE voucher_no='$row->voucher_no' AND trash=0", true)->due_paid;
                               
                                $due = $row->total_bill - ($row->paid + $duePaid);
                                
                                if ($due > 0) {
                                     $totalAmount += $due;
                                    ?>
                                    <tr>
                                        <td> <?php echo $count++; ?> </td>
                                        <td> <?php echo $row->sap_at; ?> </td>
                                        <td> <?php echo $row->voucher_no; ?> </td>
                                        <td> <?php echo $name; ?> </td>
                                        <td> <?php echo $mobile; ?> </td>
                                        <td> <?php echo $address; ?> </td>
                                        <td class="text-right"> <?php echo f_number(round($due)); ?> </td>
                                        <td class="none">
                                            <a title="Transaction" class="btn btn-primary"
                                               href="<?php echo site_url('due_list/due_list/due_collect?vno=' . $row->voucher_no); ?>">
                                                Due Collect
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>

                            <tfooter>
                                <tr>
                                    <th colspan="6" class="text-right"><strong>Total</strong></th>
                                    <th class="text-right"><?php echo $totalAmount; ?> Tk</th>
                                    <th class="none">&nbsp;</th>
                                </tr>
                            </tfooter>
                        </table>

                    <?php } else {
                        echo '<p class="text-center"> <strong> No data found....! </strong> </p>';
                    }
                } else {
                    if (!empty($result)) {
                        ?>

                        <table class="table table-bordered " id="DataTable">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Client's Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $totalAmount = 0;
                            $count = 1;
                            foreach ($result as $key => $row) {
                                $due = 0;
                                if ($row->type == 'supplier') {
                                    $due = get_supplier_balance($row->code)->balance;
                                    if ($due < 0) {
                                        $totalAmount += abs($due);
                                        ?>
                                        <tr>
                                            <td> <?php echo($count++); ?> </td>
                                            <td> <?php echo $row->name; ?> </td>
                                            <td> <?php echo $row->mobile; ?> </td>
                                            <td> <?php echo $row->address; ?> </td>
                                            <td class="text-right"><?php echo f_number(abs($due)); ?>  </td>
                                        </tr>
                                    <?php  }
                               } elseif($row->type == 'client'){
                                    $due = get_client_balance($row->code)->balance;
                                    if($due > 0){
                                     $totalAmount += $due; 
                                    ?>
                                    <tr>
                                        <td> <?php echo($count++); ?> </td>
                                        <td> <?php echo $row->name; ?> </td>
                                        <td> <?php echo $row->mobile; ?> </td>
                                        <td> <?php echo $row->address; ?> </td>
                                        <td class="text-right"><?php echo f_number($due); ?>  </td>
                                    </tr>
                                    <?php }
                                } ?>

                            <?php } ?>
                            </tbody>

                            <tfooter>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <th class="text-right"><?php echo f_number(abs($totalAmount)); ?> TK</th>
                                </tr>
                            </tfooter>
                        </table>
                    <?php } else {
                        echo '<p class="text-center"> <strong> No data found....! </strong> </p>';
                    }
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