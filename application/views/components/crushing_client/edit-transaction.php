<div class="container-fluid">
    <div class="row" ng-controller="CrushingClientTransactionEditCtrl" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Change Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('crushing_client/edit/change/' . $this->uri->segment(4), $attr);
                ?>

                <span ng-init="id=<?php echo $transactionRec[0]->id; ?>"></span>

                <div class="form-group">
                    <label class="col-md-3 control-label">Date <span class="req">*</span></label>

                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="created_at" class="form-control" value="<?php echo $transactionRec[0]->transaction_at; ?>" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Name </label>
                    <div class="col-md-5">
                        <input type="text" value="<?php echo $partyinfo[0]->name; ?>" class="form-control" readonly>
                        <input type="hidden" name="code" value="<?php echo $partyinfo[0]->code; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Current Balance (TK) </label>

                    <div class="col-md-3" ng-init="balance=<?php echo $partyinfo[0]->balance; ?>">
                        <input type="text" name="balance" value="<?php echo abs($partyinfo[0]->balance); ?>" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <?php $sign = ($partyinfo[0]->balance >= 0) ? 'Receivable' : 'Payable'; ?>
                        <input type="text" name="sign" ng-init="sign='<?php echo $sign; ?>'" ng-model="sign" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Transaction Type <span class="req">*</span></label>

                    <div class="col-md-5">
                        <select 
                            name="payment_type" 
                            class="form-control" 
                            ng-init="transactionBy='<?php echo $transactionRec[0]->transaction_via; ?>'"
                            ng-model="transactionBy"
                            required>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="bkash">bKash</option>
                        </select>
                    </div>
                </div>

                <!-- for selecting cheque -->
                <div ng-if="transactionBy == 'cheque'">
                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Bank name <span class="req">*</span>
                        </label>

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
                            <input type="text" name="meta[account_no]" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">
                            Cheque No. <span class="req">*</span>
                        </label>

                        <div class="col-md-5">
                            <input type="text" name="meta[chequeno]" class="form-control">
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
                    <label class="col-md-3 control-label">Previous Payment (TK) </label>
                    <div class="col-md-5">
                        <input type="number" ng-init="prevPayment=<?php echo $transactionRec[0]->paid; ?>" ng-model="prevPayment" class="form-control" step="any" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Current Payment (TK) <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" ng-init="payment=<?php echo $transactionRec[0]->paid; ?>" name="payment" ng-model="payment" class="form-control" step="any" min="0" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Total Balance (TK) </label>

                    <div class="col-md-3">
                        <input type="number" name="totalBalance" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                    </div>

                    <div class="col-md-2">
                        <input type="text" name="csign" ng-model="csign" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Remarks <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <textarea name="remark" cols="15" rows="5" class="form-control"><?php echo $transactionRec[0]->remark; ?></textarea>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update" value="Change" class="btn btn-primary">
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