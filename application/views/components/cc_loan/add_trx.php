<script src="<?php echo site_url('private/js/ngscript/CcLoanEntryCtrl.js')?>"></script>
<div class="container-fluid" ng-controller="CcLoanEntryCtrl">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>CC Loan Transaction</h1>
                </div>
            </div>
            <div class="panel-body" ng-controller="CcLoanEntryCtrl">
                <?php
                $attr=array('class'=>'form-horizontal');
                echo form_open('cc_loan/cc_loan/add_trx',$attr); ?>
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
                            <option selected  disabled >Select Account Number</option>
                            <?php foreach($all_account as $value){ ?>
                                <option value="<?php echo $value->acc_no;  ?>"> <?php echo $value->bank_name.'-'.$value->acc_no;  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" ng-model="bank_name"  class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" ng-model="name"  class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile No <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" ng-model="contact_info" class="form-control"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea   ng-model="address"  rows="3" class="form-control"  readonly></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Percentage <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="percentage" ng-model="percentage" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Type</label>
                    <div class="col-md-5">
                          <select  ng-model="trx_type"  name="trx_type" class="form-control">
                            <option selected disabled>Select Type</option>
                            <option value="Received"> Received </option>
                            <option value="Paid"> Paid </option>
                            <option value="Charge"> Charge </option>
                            <option value="Cash_To_TT"> Cash To TT </option>
                        </select>
                    </div>
                </div>
                <div ng-show="trx_type=='Paid'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Loan Due</label>
                        <div class="col-md-5">
                            <input type="text" name="name" ng-model="loan_due"  class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Paid</label>
                        <div class="col-md-5">
                            <input type="text" name="loan_paid" ng-model="loan_paid"  class="form-control" >
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-2 control-label">Current Loan Due</label>
                        <div class="col-md-5">
                            <input type="text" name="current_loan_due" ng-value="currentLoanDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Interest Due</label>
                        <div class="col-md-5">
                            <input type="text"  ng-model="interest_due"  class="form-control" readonly>
                        </div>
                    </div> 
                     
                    <div class="form-group">
                        <label class="col-md-2 control-label">Interest Paid</label>
                        <div class="col-md-5">
                            <input type="text" name="interest_paid" ng-model="interest_paid" class="form-control" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Current Interest Due</label>
                        <div class="col-md-5">
                            <input type="text"  ng-value="currentInterestDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Current Balance</label>
                        <div class="col-md-5">
                            <input type="text"  ng-value="currentBalanceDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div ng-show="trx_type=='Charge'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Loan Due</label>
                        <div class="col-md-5">
                            <input type="text" name="name" ng-model="loan_due"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Charge</label>
                        <div class="col-md-5">
                            <input type="text" name="loan_charge" ng-model="loan_charge"  class="form-control" >
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="col-md-2 control-label">Current Loan Due</label>
                        <div class="col-md-5">
                            <input type="text" name="current_loan_due" ng-value="currentLoanDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Interest Due</label>
                        <div class="col-md-5">
                            <input type="text" ng-model="interest_due"  class="form-control" readonly>
                        </div>
                    </div> 
                     
                    <div class="form-group">
                        <label class="col-md-2 control-label">Interest Paid</label>
                        <div class="col-md-5">
                            <input type="text" name="interest_paid" ng-model="interest_paid" class="form-control" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Current Interest Due</label>
                        <div class="col-md-5">
                            <input type="text"  ng-value="currentInterestDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Current Balance</label>
                        <div class="col-md-5">
                            <input type="text"  ng-value="currentBalanceDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group" ng-show="trx_type=='Received'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Previous Due</label>
                        <div class="col-md-5">
                            <input type="text" ng-model="due_balance"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">    
                        <label class="col-md-2 control-label">Loan Amount</label>
                        <div class="col-md-5">
                            <input type="text" name="loan_rcv" ng-model="loan_rcv"  class="form-control" >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Current Balance</label>
                        <div class="col-md-5">
                            <input type="text"  ng-value="currentBalanceDueFn()"  class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">    
                      <label class="col-md-2 control-label">Transaction Type</label>
                      <div class="col-md-5">
                          <input type="radio" id="male" name="loan_rcv_type" value="bank_loan" ng-click="setBankChargeFn('bank_loan')" checked>
                          <label for="male">Bank Loan</label>
                          <input type="radio" id="female" name="loan_rcv_type" value="bank_charge" ng-click="setBankChargeFn('bank_charge')">
                          <label for="female">Bank Charge</label>
                      </div>
                    </div> 
                    
                    <div ng-if="chargeType=='bank_charge'">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Charge Type </label>
                            <div class="col-md-5">
                                  <select name="charge_type" class="form-control">
                                    <option selected disabled>Select Type</option>
                                    <option value="Service Charge">Service Charge</option>
                                    <option value="Insurance Bill">Insurance Bill</option>
                                    <option value="Check Bill">Check Bill </option>
                                    <option value="Sms Bill">Sms Bill</option>
                                </select>
                            </div>
                        </div>
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