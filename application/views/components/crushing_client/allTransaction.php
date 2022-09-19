<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
@media print{
    aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
    .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .hide{display: block !important;}
    .table-print tr th:last-child,
    .table-print tr td:last-child{
        display: none;
    }
}
</style>

<div class="container-fluid" ng-controller="clientAllTransactionCtrl">
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Transaction</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>


             <div class="form-group">
               <label class="col-md-2 control-label"> Client Name </label>
               <div class="col-md-5">
                   <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" ng-model="party_code" ng-change="getPartyInfo();">
                       <option value="" selected disabled>-- Select Client --</option>
                       <?php
                       if ($info != null) {
                           foreach ($info as $row) {
                       ?>
                       <option value="<?php echo $row->code; ?>"><?php echo filter($row->name)." ( ".$row->address." ) "; ?></option>
                       <?php }} ?>
                   </select>
               </div>
             </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" name="show" value="Show" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <!--pre><?php // print_r($transactionInfo);?></pre-->

        <?php if ($transactionInfo != NULL) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                 <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.jpg'); ?>"> 
                <h4 class="text-center hide" style="margin-top: 0px;">All Transaction</h4>

                <table class="table table-bordered table-print">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Date</th>
                        <th>C.ID</th>
                        <th>Name</th>
                        <th>Transaction By</th>
                        <th>Paid</th>
                        <th class="none">Action</th>
                    </tr>

                    <?php
                    $total = 0.00;
                    foreach ($transactionInfo as $key => $row) { if($row->paid >= 0){
                        $where = array("code" => $row->party_code);
                        $info = $this->action->read("crushing_parties", $where);

                        if($info != null){
                            if($info[0]->type == 'client') {
                                $total += $row->paid;
                    ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $row->transaction_at; ?></td>
                        <td><?php echo $row->party_code; ?></td>
                        <td><?php echo $info[0]->name; ?></td>
                        <td><?php echo filter($row->transaction_via); ?></td>
                        <td><?php echo f_number($row->paid); ?></td>
                        <td class="none" width="110px">
                        	<a
                        	class="btn btn-warning"
                        	href="<?php echo site_url("crushing_client/edit/index/".$row->id);?>">
                        	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        	</a>

                        	<a
                        	class="btn btn-danger"
                        	href="<?php echo site_url("crushing_client/all_transaction/delete/" . $row->id);?>">
                        	<i class="fa fa-trash" aria-hidden="true"></i>
                        	</a>
                        </td>
                    </tr>
                    <?php }}}} ?>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Total</strong></td>
                        <td ><strong><?php echo f_number($total); ?> TK</strong></td>
                        <td ></td>
                    </tr>
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

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
