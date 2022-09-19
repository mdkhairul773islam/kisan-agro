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

    .table tr td {
        vertical-align: middle !important;
    }

    .cap-border {
        border-top: 1px solid #ddd;
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        background: #eee;
    }
</style>
<div class="container-fluid">

    <?php echo $this->session->flashdata('confirmation'); ?>

    <div class="row">
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Daily Wages</h1>

                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Employee</label>
                            <div class="col-md-5">
                                <select name="search[emp_id]" class="selectpicker form-control" data-show-subtext="true"
                                        data-live-search="true">
                                    <option value="" disabled selected="">-- Select Employee --</option>
                                    <?php if (!empty($allEmployee)) {
                                        foreach ($allEmployee as $key => $value) {
                                            echo '<option value="' . $value->emp_id . '" ' . (!empty($emp_id) && $emp_id == $value->emp_id ? "selected" : "") . '>' . get_filter($value->name) . '</option>';
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Type </label>
                            <div class="col-md-5">
                                <select name="type" ng-model="type" class="form-control">
                                    <option value="" selected disabled>-- Select type --</option>
                                    <option value="Daily" <?php echo(!empty($_POST['type']) && $_POST['type'] == 'Daily' ? 'selected' : ''); ?>>
                                        Daily
                                    </option>
                                    <option value="Weekly" <?php echo(!empty($_POST['type']) && $_POST['type'] == 'Weekly' ? 'selected' : ''); ?>>
                                        Weekly
                                    </option>
                                    <!--<option value="Monthly" <?php /*echo (!empty($_POST['type']) && $_POST['type'] == 'Monthly' ? 'selected' : ''); */ ?>>Monthly</option>-->
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo 'From'; ?></label>
                            <div class="input-group date col-md-5" id="datetimepickerFrom">
                                <input type="text" name="date[from]" value="" class="form-control"
                                       placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label"><?php echo 'To'; ?></label>
                            <div class="input-group date col-md-5" id="datetimepickerTo">
                                <input type="text" name="date[to]" value="" class="form-control"
                                       placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 text-right">
                                <input type="submit" name="show" value="Show" class="btn btn-primary">
                            </div>
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
                    <h1 class="pull-left">All Payment</h1>

                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <!-- Print banner Start Here -->
                        <?php //$this->load->view('print_bn_voucher', $this->data); ?>
                    <!-- Print banner End Here -->
                    <table class="table table-bordered">
                        <tr>
                            <th width="60">SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Attendance</th>
                            <th>Salary <small>(Tk)</small></th>
                            <th>Bonus <small>(Tk)</small></th>
                            <th>Total Salary <small>(Tk)</small></th>
                            <th>Payemnt <small>(Tk)</small></th>
                            <th width="60" class="none">Action </th>
                        </tr>
                        <?php
                        $totalSalary = $totalPayment = $totalBonus = 0;
                        if (!empty($results)) {
                            foreach ($results as $key => $row) {
                                
                                $total        = ($row->salary * $row->attendance) + $row->bonus;
                                $totalSalary  += $total;
                                $totalPayment += $row->payment;
                                $totalBonus   += $row->bonus;
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->created_at; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td><?php echo $row->attendance; ?></td>
                                    <td><?php echo $row->salary; ?></td>
                                    <td><?php echo $row->bonus; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td><?php echo $row->payment; ?></td>
                                    <td class="none">
                                        
                                        <a class="btn btn-info" title="History" href="<?php echo site_url("salary/payment/view_wages_payment?id=".$row->id); ?>" >
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        
                                        <a title="Delete" onclick="return confirm('Do you want to delete this data?')" class="btn btn-danger"
                                           href="<?php echo site_url("salary/daily_payment/delete/$row->id"); ?>">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        
                                        
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <th colspan="10" class="text-center">No records found....!</th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="6" class="text-right">Total</th>
                            <th><?php echo $totalBonus; ?> <small>(Tk)</small></th>
                            <th><?php echo $totalSalary; ?> <small>(Tk)</small></th>
                            <th><?php echo $totalPayment ?> <small>(Tk)</small></th>
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
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>