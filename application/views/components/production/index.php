<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Production </h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php echo form_open(); ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="code" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>Select Product</option>
                                <?php
                                if (!empty($productList)) {
                                    foreach ($productList as $key => $item) { ?>
                                        <option value="<?php echo $item->code; ?>">
                                            <?php echo $item->code . '-' . filter($item->name); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerSMSFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerSMSTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" value="Show" name="show" class="btn btn-primary pull-right">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left"> Show Result </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide" style="margin-top: 0px;">All Productions</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40">SL</th>
                            <th width="100">Date</th>
                            <th>Voucher No.</th>
                            <th>Batch No.</th>
                            <th>Total Qty.</th>
                            <th>Waste Qty.</th>
                            <th>Production Qty.</th>
                            <th>Waste Amount</th>
                            <th>Total Amount</th>
                            <th class="none" width="125">Action</th>
                        </tr>
                        <?php
                        $totalQty = $totalWastQty = $totalProductionQty = $totalWasteAmount = $totalAmount = 0;
                        if (!empty($results)) {
                            foreach ($results as $key => $row) {

                                $totalQty           += $row->total_quantity;
                                $totalWastQty       += $row->total_waste;
                                $totalProductionQty += $row->total_production;
                                $totalWasteAmount   += $row->waste_amount;
                                $totalAmount        += $row->total_amount;
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $row->created; ?></td>
                                    <td><?php echo $row->voucher_no; ?></td>
                                    <td><?php echo $row->batch_no; ?></td>
                                    <td><?php echo $row->total_quantity; ?></td>
                                    <td><?php echo $row->total_waste; ?></td>
                                    <td><?php echo $row->total_production; ?></td>
                                    <td><?php echo $row->waste_amount; ?></td>
                                    <td><?php echo $row->total_amount; ?></td>

                                    <td class="none">
                                        <a title="View" class="btn btn-primary"
                                           href="<?php echo site_url('production/production/show?vno=' . $row->voucher_no); ?>">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                        <?php if (!checkAuth('user')) { ?>
                                            <a class="btn btn-danger" title="Delete"
                                               href="<?php echo site_url('production/production/delete?vno=' . $row->voucher_no); ?>"
                                               onclick="return confirm('Are you sure want to delete this Data?');">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php }
                        } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th><?php echo $totalQty; ?></th>
                            <th><?php echo $totalWastQty; ?></th>
                            <th><?php echo $totalProductionQty; ?></th>
                            <th><?php echo $totalWasteAmount; ?></th>
                            <th><?php echo $totalAmount; ?></th>
                            <th class="none"></th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
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