<div class="container-fluid">
    <div class="row" ng-controller="CompanyEditTransactionCtrl" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('supplier/transaction/edit_transaction/' . $info->id, $attr);
                ?>

                <input type="hidden" name="id" ng-init="id=<?php echo $info->id; ?>" ng-value="id">
                <input type="hidden" name="code" value="<?php echo $info->party_code; ?>">

                <div class="form-group">
                    <label class="col-md-3 control-label">Date <span class="req">*</span></label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="created_at" class="form-control"
                                   value="<?php echo $info->transaction_at; ?>" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Name </label>
                    <div class="col-md-5">
                        <input type="text" value="<?php echo $info->name; ?>" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Previous Balance (TK) </label>

                    <div class="col-md-3">
                        <input type="text" value="<?php echo abs($balanceInfo->balance); ?>" class="form-control" readonly>
                        <input type="hidden" name="previous_balance" ng-init="previous_balance=<?= $balanceInfo->balance ?>" ng-value="previous_balance">
                    </div>

                    <div class="col-md-2">
                        <input type="text" value="<?php echo $balanceInfo->status; ?>" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Transaction Type <span class="req">*</span></label>

                    <div class="col-md-5">
                        <select name="transaction_type" ng-init="transactionType='<?php echo $transactionType; ?>'" ng-model="transactionType" class="form-control" required>
                            <option value="payment">Payment</option>
                            <option value="received">Received</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Payment Method <span class="req">*</span></label>

                    <div class="col-md-5">
                        <select
                                name="transaction_via"
                                class="form-control"
                                ng-init="transactionVia='<?php echo $info->transaction_via; ?>'"
                                ng-model="transactionVia"
                                required>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="bkash">bKash</option>
                        </select>
                    </div>
                </div>

                <!-- for selecting cheque -->
                <div ng-if="transactionVia == 'cheque'">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Bank name <span class="req">*</span></label>

                        <div class="col-md-5">
                            <input type="text" name="meta[bankname]" ng-model="bankname" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Branch name <span class="req">*</span>
                        </label>

                        <div class="col-md-5">
                            <input type="text" name="meta[branchname]" ng-model="branchname" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Account No. <span class="req">*</span>
                        </label>

                        <div class="col-md-5">
                            <input type="text" name="meta[account_no]" ng-model="accountno" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Cheque No. <span class="req">*</span>
                        </label>

                        <div class="col-md-5">
                            <input type="text" name="meta[chequeno]" ng-model="chequeno" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Pass Date <span class="req">*</span>
                        </label>

                        <div class="col-md-5">
                            <input type="text" name="meta[passdate]" class="form-control" value="{{ passdate }}">
                            <input type="hidden" name="meta[status]" value="pending">
                        </div>
                    </div>
                </div>
                <!-- cheque option end  -->

                <div class="form-group">
                    <label class="col-md-3 control-label">Amount (TK) <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="payment" ng-init="payment=<?php echo $amount; ?>"
                               ng-model="payment" class="form-control" step="any" min="0">
                    </div>
                </div>

                <div class="form-group" ng-show="transactionType=='payment'">
                    <label class="col-md-3 control-label">Commission (TK) <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="commission" ng-init="commission=<?php echo $info->commission; ?>"
                               ng-model="commission" class="form-control" step="any">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Current Balance (TK) </label>

                    <div class="col-md-3">
                        <input type="number"  ng-value="getTotalFn()" class="form-control" step="any"
                               readonly>
                        <input type="hidden" name="current_balance" ng-value="current_balance">
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="csign" ng-model="csign" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Remarks <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <textarea name="comment" cols="15" rows="5"
                                  class="form-control"><?php echo $info->comment; ?></textarea>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update" value="Update" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
