<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

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
                    <h1> Sales Report </h1>
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

            <?php if (!empty($result)) { ?>
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="hide text-center" style="margin-top: 0px;">All Sales Report</h4>


                    <table class="table table-bordered">
                        <tr>
                            <th width="40">SL</th>
                            <th>Date</th>
                            <th class="text-center">Total Sales</th>
                            <th class="text-center">Total Paid</th>
                            <th class="text-center">Total damage</th>
                            <th class="text-center">Total Due</th>
                        </tr>
                        <?php
                        $totalBill = $totalPaid = $totalDamage = $totalDue = 0;
                        foreach ($result as $key => $row) {

                            $where                = ['sap_at' => $row->sap_at, 'status' => 'sale', 'trash' => 0];
                            $where_damage_product = ['created_at' => $row->sap_at, 'status' => 'sale_damage', 'trash' => 0];

                            $saprecordsInfo = get_row('saprecords', $where, "SUM(total_bill) AS total_bill, SUM(paid) AS paid");

                            $get_total_bill   = $saprecordsInfo->total_bill;
                            $get_total_paid   = $saprecordsInfo->paid;
                            $due              = $get_total_bill - $get_total_paid;
                            $get_total_damage = get_sum('sapreturn_records', 'total_bill', $where_damage_product);
                            $get_total_damage = (!empty($get_total_damage) ? $get_total_damage : 0);

                            $totalPaid   += $get_total_paid;
                            $totalBill   += $get_total_bill;
                            $totalDamage += $get_total_damage;

                            $totalDue    += ($due > 0 ? $due : 0);

                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td class="text-center">
                                    <?php
                                    echo $get_total_bill;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $get_total_paid; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $get_total_damage; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo($due >= 0 ? $due : 0); ?>
                                </td>

                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalBill); ?> 0/-Tk</strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalPaid); ?>/-Tk</strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalDamage); ?>/-Tk</strong>
                            </td>
                            <td class="text-center"><strong><?php echo f_number($totalDue); ?>
                                    0/-Tk</strong></td>
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