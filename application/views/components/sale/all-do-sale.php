<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Do Sale</h1>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="row">
                    <?php echo form_open(); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]" placeholder="DO No" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected disabled>Select Client</option>
                                <?php
                                if (!empty($allClients)) {
                                    foreach ($allClients as $key => $client) { ?>
                                        <option value="<?php echo $client->code; ?>">
                                            <?php echo filter($client->name) . " ( " . $client->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="To">
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
                    <?php echo form_close(); ?>
                </div>
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

                <h4 class="text-center hide" style="margin-top: 0px;">All Do Sale</h4>
                <?php 
                if(!empty($result)){ ?>
                <table class="table table-bordered " id="DataTable">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Do No</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Total Bill (Tk)</th>
                        <th>Paid (TK)</th>
                        <th class="none" style="width: 135px;">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                        $total_bill = $total_paid = 0.00;
                        foreach ($result as $key => $row) {
                    ?>
                        <tr>
                            <td><?= ($key + 1); ?> </td>
                            <td><?= $row->sap_at; ?> </td>
                            <td><?= $row->voucher_no; ?> </td>
                            <td><?= filter($row->name); ?></td>
                            <td><?php echo $row->total_quantity; ?></td>
                            <td>
                                <?php
                                    $total_bill += $row->total_bill;
                                    echo f_number($row->total_bill);
                                ?>
                            </td>
                            <td>
                                <?php
                                    $total_paid += $row->paid;
                                    echo $row->paid;
                                ?>
                            </td>
                            <td class="none">
                                <a title="View" class="btn btn-primary" href="<?php echo site_url('sale/do_sale/doSaleInvoice?vno=' . $row->voucher_no); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                
                                <a title="Edit" class="btn btn-warning" href="<?php echo site_url('sale/edit_do_sale?vno=' . $row->voucher_no); ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                
                                <a onclick="return confirm('Are you sure want to delete this Sale?');" title="Delete" class="btn btn-danger"
                                   href="<?php echo site_url('sale/do_sale/delete?vno=' . $row->voucher_no); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    } ?>
                    </tbody>
                    <tfooter>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Total</strong></td>
                            <th><?php echo $total_bill; ?></th>
                            <th><?php echo $total_paid; ?> </th>
                            <th colspan="2" class="none">&nbsp;</th>
                        </tr>
                    </tfooter>
                </table>
                <?php } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" href="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.css') ?>">
<script src="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.js') ?>"></script>

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

    $(document).ready(function () {
        $('#DataTable').DataTable({
            "pageLength": 50
        });
    });
</script>

