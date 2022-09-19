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
    }

    .table tr td {
        vertical-align: middle !important;
    }

</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">View All Recipe </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <div class="col-md-3">
                        <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" value="<?= (date('Y-m-d')) ?>" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" value="<?= (date('Y-m-d')) ?>" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <hr class="none" style="margin-top: 0px;">

            <?php if (!empty($allInfo)) { ?>

                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">All Recipe</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="50">SL</th>
                                <th>Date</th>
                                <th>Voucher No</th>
                                <th>Recipe Name</th>
                                <th>Flour (in Kg)</th>
                                <th>Required Raw Materials for 1 khamir (in kg)</th>
                                <th>Total Cost (Tk)</th>
                                <!--<th>Wastage (in %)</th>
                                <th>Total Wastage (in Kg)</th>
                                <th>Total Production (in Kg)</th>-->
                                <th class="none" width="160">Action</th>
                            </tr>
                            <?php
                            $totalMaterials = $totalCost = [];
                            foreach ($allInfo as $_key => $r_value) {
                                ?>
                                <tr>
                                    <td><?php echo ++$_key; ?></td>
                                    <td><?php echo $r_value->created; ?></td>
                                    <td><?php echo $r_value->voucher_no; ?></td>
                                    <td><?php echo filter($r_value->category_name); ?></td>
                                    <td><?php echo $r_value->flour; ?></td>
                                    <td><?php echo $r_value->total_material;
                                        $totalMaterials[] = +$r_value->total_material; ?></td>
                                    <td><?php echo $r_value->total_cost;
                                        $totalCost[] = +$r_value->total_cost; ?></td>
                                    <!--<td><?php /*echo $r_value->total_wastage_ration; */ ?></td>
                                    <td><?php /*echo $r_value->total_wastage; */ ?></td>
                                    <td><?php /*echo $r_value->total_production; */ ?></td>-->
                                    <td class="none">
                                        <a class="btn btn-primary" title="Show"
                                           href="<?php echo site_url("recipe/recipe/preview/$r_value->voucher_no"); ?>"><i
                                                    class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a class="btn btn-warning" title="Edit"
                                           href="<?php echo site_url("recipe/recipe/edit/$r_value->voucher_no"); ?>"><i
                                                    class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                        <?php if ($this->session->userdata['privilege'] !== "user") { ?>
                                            <a class="btn btn-danger" title="Delete"
                                               onclick="return confirm('Are you sure to delete this data?');"
                                               href="<?php echo site_url("recipe/recipe/delete/$r_value->voucher_no"); ?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="5" class="text-right">Total</th>
                                <td>
                                    <?php
                                    echo f_number(array_sum($totalMaterials), 2) . ' Kg';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo f_number(array_sum($totalCost), 2) . ' Tk';
                                    ?>
                                </td>
                                <td class="none"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php } else {
                echo "<p class='text-center'> <strong>No data found!</strong> </p>";
            } ?>

            <div class="panel-footer">&nbsp;</div>
        </div>
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

    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
