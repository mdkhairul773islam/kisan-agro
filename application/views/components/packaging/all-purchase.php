<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style type="text/css">
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{display: block !important;}
    }
    .table-title{
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align:center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('deleted'); ?> 
        
        <div class="panel panel-default none">

            <div class="panel-heading"> 
                <div class="panal-header-title pull-left">
                    <h1>View All Purchase</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Voucher No </label>
                    <div class="col-md-4">
                        <input type="text" name="search[voucher_no]" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Supplier Name </label>
                    <div class="col-md-4">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>&nbsp;</option>
                            <?php if($allParty != null){ foreach($allParty as $key => $row){ ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                                </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">From </label>
                    <div class="input-group date col-md-4" id="datetimepickerFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To </label>
                    <div class="input-group date col-md-4" id="datetimepickerTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>



        <?php  if($result != null){ ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panal-header-title ">
                        <h1 class="pull-left">Show Result</h1>
                        <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                    </div>
                </div>

                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">All Purchase</h4>
                    <!--pre><?php  // print_r($result); ?></pre-->

                    <table class="table table-bordered table2">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Supplier Name</th>
                            <th>Mobile</th>
                            <th>Total (TK)</th>
                            <th>Paid (TK)</th>
                            <th>Due (TK)</th>
                            <th class="none">Action</th>
                        </tr>

                        <?php
                        $grandTotal = 0.00;
                        foreach($result as $key => $val){
                            $grandTotal = $val->total_bill + $val->transport_cost - $val->total_discount;
                            ?>
                            <tr>
                                <td style="width: 40px;"><?php echo $key+1; ?></td>
                                <td ><?php echo $val->sap_at; ?></td>
                                <td ><?php echo $val->voucher_no; ?></td>
                                <td ><?php echo filter($val->name); ?></td>
                                <td ><?php echo $val->mobile; ?></td>
                                <td><?php echo f_number($grandTotal); ?></td>
                                <td><?php echo f_number($val->paid); ?></td>
                                <td><?php echo f_number($grandTotal - $val->paid); ?></td>

                                <td class="none text-center" style="width: 162px;">
                                    <a title="View" class="btn btn-primary" href="<?php echo site_url('packaging/purchase/preview_voucher?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    
                                    <?php if ($val->sap_at == date('Y-m-d')){ ?>

                                    <a title="Edit/Return" class="btn btn-warning" href="<?php echo site_url('packaging/edit_purchase?vno=' . $val->voucher_no); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>

                                    <?php if($this->session->userdata['privilege'] !== "user"){ ?>
                                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Data?');" href="<?php echo site_url('packaging/purchase/delete_purchase?vno=' . $val->voucher_no); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                <div class="panel-footer">&nbsp;</div>
            </div>
        <?php } ?>
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