<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

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

    .mb_1 {
        margin-bottom: 15px;
    }

    ;
    .select2-product_code-ji-container {
        height: 35px !important;
    }

    .select2-selection__arrow, .select2-selection--single {
        height: 36px !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default none">

            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View Item Wise Sale </h1>
                </div>
            </div>

            <div class="panel-body">

                <?php echo form_open(); ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="party_code" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                <option value="">Select Client</option>
                                <?php
                                if (!empty($clientList)) {
                                    foreach ($clientList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>"> <?php echo filter($row->name); ?> </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="product_code" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                <option value="">Select Product</option>
                                <?php
                                if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>"> <?php echo $row->code . ' - ' . filter($row->name); ?> </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="sap_type" class="form-control">
                                <option value="">Sale Type</option>
                                <option value="cash">Cash</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>"
                                       placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>"
                                       placeholder="YYYY-MM-DD">
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
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if (!empty($results)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result </h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">View Item Wise Sale</h4>

                    <table class="table table-bordered table2">
                        <tr>
                            <th width="50">SL</th>
                            <th width="100">Date</th>
                            <th width="100">Voucher No</th>
                            <th>Client Name</th>
                            <th>Product Name</th>
                            <th width="100">Quantity</th>
                            <th width="100">P.Price</th>
                            <th width="100">S.Price</th>
                            <th width="100">P.Total Tk</th>
                            <th width="100">S.Total TK</th>
                            <th width="60" class="none">Action</th>
                        </tr>

                        <?php $total = $totalPurchase = $totalSale = 0;
                        foreach ($results as $key => $row) {

                            if ($row->sap_type == 'cash') {
                                $name = filter($row->party_code);
                            } else {
                                $name = filter(get_name('parties', 'name', ['code' => $row->party_code]));
                            }

                            $purchase = $row->purchase_price * $row->quantity;
                            $sale     = $row->sale_price * $row->quantity;

                            $totalPurchase += $purchase;
                            $totalSale     += $sale;

                            $total += $row->quantity;
                            ?>

                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $row->sap_at; ?></td>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td><?php echo check_null($name); ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->quantity; ?></td>
                                <td><?php echo $row->purchase_price; ?></td>
                                <td><?php echo $row->sale_price; ?></td>
                                <td><?php echo $purchase; ?></td>
                                <td><?php echo $sale; ?></td>

                                <td class="none">
                                    <a title="View" class="btn btn-primary"
                                       href="<?php echo site_url('sale/sale/preview?vno=' . $row->voucher_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>


                        <tr>
                            <th colspan="5" style="text-align: right; "> Total</th>
                            <td> <?php echo $total; ?> </td>
                            <td></td>
                            <td></td>
                            <td> <?php echo $totalPurchase; ?> Tk</td>
                            <td> <?php echo $totalSale; ?> Tk</td>
                            <td></td>
                        </tr>


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

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>