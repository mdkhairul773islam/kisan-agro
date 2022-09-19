<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style type="text/css">
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
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

    .table-title {
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
</style>

<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Order</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open(); ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>Select Supplier</option>
                                <?php if (!empty($partyList)) {
                                    foreach ($partyList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]" placeholder="Voucher No" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


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

                <h4 class="text-center hide" style="margin-top: 0px;">All Order</h4>
                <!--pre><?php // print_r($result); ?></pre-->

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>PR No</th>
                        <th>Order No</th>
                        <th>Supplier Name</th>
                        <th>Mobile</th>
                        <th>Total Bill (TK)</th>
                        <th class="none">Action</th>
                    </tr>

                    <?php
                    $grandTotal = 0;
                    foreach ($results

                    as $key => $row) {
                    $grandTotal += $row->total_bill;
                    ?>
                    <tr>
                        <td style="width: 40px;"><?php echo $key + 1; ?></td>
                        <td><?php echo $row->created; ?></td>
                        <td><?php echo $row->pr_no; ?></td>
                        <td><?php echo $row->voucher_no; ?></td>
                        <td><?php echo filter($row->name); ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo f_number($row->total_bill); ?></td>

                        <td class="none text-center" style="width: 162px;">
                            <a title="View" class="btn btn-primary"
                               href="<?php echo site_url('purchase/order/show?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>

                            <?php //if ($row->created == date('Y-m-d')) { ?>

                            <a title="Edit/Return" class="btn btn-warning"
                               href="<?php echo site_url('purchase/order/edit?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <?php //if (!checkAuth('user')) { ?>
                            <a title="Delete" class="btn btn-danger"
                               onclick="return confirm('Are you sure want to delete this Data?');"
                               href="<?php echo site_url('purchase/order/delete?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                            <?php //} } ?>
                        </td>
                    </tr>
                <?php } ?>

                    <tr>
                        <th colspan="6" class="text-right">Total</th>
                        <th><?php echo f_number($grandTotal); ?> Tk</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
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