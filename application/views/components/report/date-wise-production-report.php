<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
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

        .title {
            font-size: 25px;
        }
    }

</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Date Wise Production Report</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php echo form_open(); ?>

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

            <?php if (!empty($results)) { ?>
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="hide text-center" style="margin-top: 0px;">Date Wise Production Report</h4>


                    <table class="table table-bordered">
                        <tr>
                            <th width="40">SL</th>
                            <th>Date</th>
                            <th class="text-center">Total Qty.</th>
                            <th class="text-center">Total Qty.</th>
                            <th class="text-center">Total Amount</th>
                        </tr>
                        <?php
                        $totalBill = $totalQty = 0;
                        foreach ($results as $key => $row) {
                            $totalBill += $row->total_bill;
                            $totalQty += $row->total_quantity;
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td class="text-center"> <?php echo $row->total_quantity; ?> </td>
                                <td class="text-center"> <?php echo $row->total_bill; ?> </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalQty); ?></strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalBill); ?> /-Tk</strong></td>
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>