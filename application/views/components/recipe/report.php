<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
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
                    <h1 class="pull-left">Report</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body none">
                
                <?php echo form_open(); ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="department_id" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>Select Department (*)</option>
                                <?php
                                if (!empty($departmentList)) {
                                    foreach ($departmentList as $item) {
                                ?>
                                <option value="<?php echo $item->id; ?>">
                                    <?php echo filter($item->department_name); ?>
                                </option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" value="" class="form-control" placeholder="YYYY-MM-DD (Date From)">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" value="" class="form-control" placeholder="YYYY-MM-DD (Date To)">
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

            <hr class="none" style="margin-top: 0px;">
            
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Report</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        
                        <?php if(!empty($departmentID)){ ?>
                        <tr>
                            <th colspan="4"><?php echo get_name('department', 'department_name', ['id' => $departmentID]);?></th>
                        </tr>
                        <?php }?>
                        
                        <tr>
                            <th width="50">SL</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                        </tr>
                        <?php
                        $totalAmount = $totalQty = 0;
                        if(!empty($results)){
                            foreach ($results as $key => $row) {
                                $totalQty += $row->quantity;
                                $totalAmount += $row->amount;
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->quantity; ?></td>
                                    <td><?php echo $row->amount; ?></td>
                                </tr>
                            <?php }
                        } ?>
                        
                        <tr>
                            <th colspan="2" class="text-right">Total</th>
                            <th><?php echo $totalQty; ?> Kg</th>
                            <th><?php echo $totalAmount; ?> Tk</th>
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

    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
