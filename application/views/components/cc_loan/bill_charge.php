<div class="container-fluid">
    <div class="row">
	 <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Add Bank Charge </h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open('cc_loan/bill_charge',$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5 datetimepickerTo" id="datetimepicker1">
                        <input type="text" name="trx_date" id="trx_date" value="<?php echo date("Y-m-d"); ?>" class="form-control" >
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select id="acc_no" name="acc_no" class="form-control"  ng-model="acc_no"  ng-change="getAccInfoFn(acc_no,trx_date)">
                            <option selected  disabled >-- Select Account Number  --</option>
                            <?php foreach($all_account as $value){ ?>
                                <option value="<?php echo $value->acc_no;  ?>"> <?php echo $value->bank_name.'-'.$value->acc_no;  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="col-md-2 control-label">Charge Type </label>
                    <div class="col-md-5">
                          <select name="charge_type" class="form-control">
                            <option selected disabled>-- Select Type --</option>
                            <option value="Service Charge">Service Charge</option>
                            <option value="Insurance Bill">Insurance Bill</option>
                            <option value="Check Bill">Check Bill </option>
                            <option value="Sms Bill">Sms Bill</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Amount</label>
                    <div class="col-md-5">
                        <input type="text" name="amount"  class="form-control" >
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" name="save" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    
        $('.datetimepickerTo').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false
        });

    });    
</script>