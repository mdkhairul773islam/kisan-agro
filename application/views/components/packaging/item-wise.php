<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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
                    <h1>View Item Wise Purchase</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                echo $this->session->flashdata('deleted');
                echo form_open("");
                ?>

                <div class="form-group">
                    <div class="col-md-4">
                        <select name="product_code" class="form-control js-example-basic-single" reaquired>
                            <option value="">--Select Product--</option>
                            <?php if (!empty($rawMats)) {
                                foreach ($rawMats as $key => $row) {
                                    echo '<option value="' . $row->code . '"> ' . $row->code . '-' . $row->name . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="dateFrom" class="form-control" value="<?php echo (!empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-d')); ?>">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="dateTo" class="form-control" value="<?php echo (!empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d')); ?>">
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>


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

                <h4 class="text-center hide" style="margin-top: 0px;">Itemwise All Purchase</h4>

                <?php if (!empty($results)) { ?>
                    <table class="table table-bordered table2">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Product Name</th>
                            <th>Purchase Price</th>
                            <th>Quantity (Kg)</th>
                            <th>Total Amount (Tk)</th>
                        </tr>

                        <?php
                        $total = $totalAmount = $purchasePrice = $count = 0;
                        foreach ($results as $key => $val) {
                            $total         += $val->quantity;
                            $amount        = ($val->quantity * $val->purchase_price);
                            $totalAmount   += $amount;
                            $purchasePrice += $val->purchase_price;

                            if ($val->purchase_price > 0) {
                                $count++;
                            }
                            ?>
                            <tr>
                                <td style="width: 40px;"><?php echo $key + 1; ?></td>
                                <td><?php echo $val->sap_at; ?></td>
                                <td><?php echo $val->name; ?></td>
                                <td><?php echo f_number($val->quantity, 3); ?></td>
                                <td><?php echo f_number($val->purchase_price); ?></td>
                                <td><?php echo f_number($amount); ?></td>
                            </tr>
                        <?php } ?>

                        <tr>
                            <th colspan="3" style="text-align: right; "> Total</th>
                            <th> <?php echo f_number(($purchasePrice / ($count > 0 ? $count : 1))); ?> </th>
                            <th> <?php echo f_number($total, 3); ?> </th>
                            <th> <?php echo f_number($amount); ?> </th>
                        </tr>
                    </table>
                <?php } else {
                    echo '<p class="text-center"> <strong>No date found....!</strong> </p>';
                }
                ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>

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