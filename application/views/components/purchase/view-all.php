<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('deleted'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Purchase</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open(); ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]" placeholder="Voucher No" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Supplier</option>
                                <?php if (!empty($allParty)) {
                                    foreach ($allParty as $key => $row) { ?>
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
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
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
                <h4 class="text-center hide" style="margin-top: 0px;">All Purchase</h4>

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Supplier Name</th>
                        <th>Mobile</th>
                        <th>Total (TK)</th>
                        <th>Paid (TK)</th>
                        <th>Due (TK)</th>
                        <th class="none text-right">Action</th>
                    </tr>

                    <?php
                    $grandTotal = 0.00;
                    foreach ($result as $key => $val) {
                        $grandTotal = ($val->total_bill + $val->transport_cost) - $val->total_discount;
                        ?>
                        <tr>
                            <td style="width: 40px;"><?php echo $key + 1; ?></td>
                            <td><?php echo $val->sap_at; ?></td>
                            <td><?php echo $val->voucher_no; ?></td>
                            <td><?php echo filter($val->name); ?></td>
                            <td><?php echo $val->mobile; ?></td>
                            <td><?php echo f_number($grandTotal); ?></td>
                            <td><?php echo f_number($val->paid); ?></td>
                            <td><?php echo f_number($grandTotal - $val->paid); ?></td>

                            <td class="none text-right" style="width: 165px;">
                                <a title="View" class="btn btn-primary" href="<?php echo site_url('purchase/purchase/view?vno=' . $val->voucher_no); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <?php if ($val->sap_at == date('Y-m-d')) { ?>
                                    <a title="Edit/Return" class="btn btn-warning" href="<?php echo site_url('purchase/editPurchase?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <?php if ($this->session->userdata['privilege'] !== "user") { ?>
                                    <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Data?');" href="<?php echo site_url('purchase/purchase/delete?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                    <?php }
                                } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>