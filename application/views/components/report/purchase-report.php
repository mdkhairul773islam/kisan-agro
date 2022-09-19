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
        <div class="panel panel-default">

            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Daily Purchase Report</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php echo form_open(); ?>

                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group">
                        <div class="col-md-3">
                            <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                        </div>

                        <div class="col-md-3">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected>-- Select Supplier --</option>
                                <?php
                                if (!empty($allSupplier)) {
                                    foreach ($allSupplier as $item) {
                                        echo '<option value="' . $item->code . '" ' . (!empty($_POST["party_code"]) && $_POST["party_code"] == $item->code ? "selected" : '') . '> ' . $item->code . '-' . $item->name . ' </option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]"
                                       value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '') ?>"
                                       placeholder="From ( YYYY-MM-DD )" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]"
                                       value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '') ?>"
                                       placeholder="To ( YYYY-MM-DD )" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <input type="submit" value="Show" name="show" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <hr class="none">


            <?php if (!empty($result)) { ?>
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
                            <th class="text-center">Quantity (KG)</th>
                            <th class="text-center">Debit (TK)</th>
                            <th class="text-center">Credit (TK)</th>
                        </tr>

                        <?php
                        $totalDebit = $totalCredit = $totalQuantity = 0;
                        foreach ($result as $key => $val) {
                            
                            $totalBill = $val->total_bill + $val->transport_cost - $val->total_discount;
                            
                            $totalCredit   += $totalBill;
                            $totalQuantity += $val->total_quantity;
                            $totalDebit    += $val->paid; 
                            
                            ?>
                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $val->sap_at; ?></td>
                                <td><?php echo $val->voucher_no; ?></td>
                                <td><?php echo filter($val->name); ?></td>
                                <td class="text-center"><?php echo $val->total_quantity; ?></td>
                                <td class="text-center"><?php echo f_number($val->paid); ?></td>
                                <td class="text-center"><?php echo f_number($totalBill); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th class="text-center"><?php echo $totalQuantity; ?></th>
                            <th class="text-center"><?php echo f_number($totalDebit); ?>/-Tk</th>
                            <th class="text-center"><?php echo f_number($totalCredit); ?>/-Tk</th>

                        </tr>
                    </table>
                </div>
            <?php } else {
                echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
            } ?>

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