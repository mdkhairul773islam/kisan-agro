<div class="container-fluid" ng-controller="loanTransactionCtrl" >
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Loan Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
    	            $attr=array('class'=>'form-horizontal');
    	            echo form_open('',$attr);
                ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group" ng-init="type='Person'">
                    <label class="col-md-2 control-label">Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="type" ng-model="type" value="Bank" required>
                            <strong>Bank</strong>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" ng-model="type" value="Person"  required>
                            <strong>Person</strong>
                        </label>
                    </div>
                </div>

                <!-- Bank Info -->
                <div ng-if="type == 'Bank'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                        <div class="col-md-5">
                           <select class="form-control" ng-model="loan_id" ng-change="getTotal(loan_id)" name="loan_id">
                                <option value="" selected>Select</option>
                                <?php foreach ($banks as $bank) { ?>
                                <option value="<?php echo $bank->id; ?>"><?php echo $bank->account_no; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Person -->
                <div ng-if="type == 'Person'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Person Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <select class="form-control" ng-model="loan_id" ng-change="getLoanInfoFn(loan_id)" name="loan_id">
                                <option value="" selected>Select</option>
                                <?php
                                if (!empty($persons)){
                                    foreach ($persons as $item) {
                                        echo '<option value="'.$item->id.'">' . $item->name .'</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Loan Amount <span class="req">*</span></label>
                    <div class="col-md-3">
                        <input type="number" ng-value="totalAmount" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <input type="text" ng-value="loanStatus" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Balance <span class="req">*</span></label>
                    <div class="col-md-3">
                        <input type="text" ng-model="balance" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <input type="text" ng-value="balanceStatus" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Amount <span class="req">*</span></label>
                    <div class="col-md-3">
                        <input type="number" ng-model="amount" name="amount" placeholder="0" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <select class="form-control" name="trx_type" ng-model="trxType" ng-required="true">
                            <option value="" selected disabled="">Transaction Type</option>
                            <option value="Received">Received</option>
                            <option value="Paid">Paid</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">CurrentBalance <span class="req">*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="due" ng-value="getCurrentBalanceFn()" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="current_status" ng-value="currentStatus" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Transaction By <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="transaction_by" placeholder="Maximum 100 Digit" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input value="Save" name="save" class="btn btn-primary pull-right" type="submit">
                    </div>
                </div>

               <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
