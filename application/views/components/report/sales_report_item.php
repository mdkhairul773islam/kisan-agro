<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View Item Wise Sales Report </h1>
                </div>
            </div>
            

            <div class="panel-body">
                <?php echo form_open(); ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[product_code]" class="selectpicker form-control"
                                    data-show-subtext="true" data-live-search="true">
                                <option selected disabled>Select Product</option>
                                <?php foreach ($productionItems as $value) { ?>
                                    <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerSMSFrom">
                                <input type="text" name="date[from]" class="form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerSMSTo">
                                <input type="text" name="date[to]" class="form-control" value="<?php echo date('Y-m-d'); ?>" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" value="Show" name="find" class="btn btn-primary pull-right">
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

                <h4 class="hide text-center" style="margin-top: 0px;">All Sales Report</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Product Name</th>
                        <th>Sale Price</th>
                        <th>Quantity (kg)</th>
                        <th>Amount (TK)</th>

                    </tr>
                    <?php if ($results != null) {
                        $total_amount = 0;
                        $total_Qty    = 0;
                        foreach ($results as $key => $value) {
                            $amount = $value->quantity * $value->sale_price;

                            $where       = array('code' => $value->product_code);
                            $productInfo = $this->action->read("materials", $where);
                            ?>

                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->sap_at; ?></td>
                                <td><?php echo $value->voucher_no; ?></td>
                                <td><?php echo filter($value->name); ?></td>
                                <td><?php echo $value->sale_price; ?></td>
                                <td><?php echo $value->quantity; ?></td>
                                <td><?php echo $amount; ?></td>
                            </tr>
                            <?php
                            $total_amount += $amount;
                            $total_Qty    += $value->quantity;
                        } ?>
                        <tr>
                            <td colspan="5"><span class="pull-right"><strong>Total</strong></span></td>
                            <td><?php echo $total_Qty; ?> Kg</td>
                            <td><?php echo $total_amount; ?> Tk</td>
                        </tr>
                    <?php } ?>
                </table>

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

