<div class="container-fluid" ng-controller="AllBankTransactionCtrl">
    <div class="row">
        <?php
            $total = 0;
            echo $confirmation;
        ?>
        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Transaction</h1>
                </div>
            </div>
            
            <div class="panel-body">
                <?php
                    $attr = array('class' => 'form-horizontal');
                    echo form_open('', $attr);
                ?>
                <div class="form-group">
                    <label class="col-md-2 control-label">Bank </label>
                    <div class="col-md-5">
                        <select name="search[bank]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true" ng-model="bank" ng-change="getAccountFn()">
                            <option value="" selected disabled>Select Bank</option>
                            <?php
                            if (!empty($allBank)) {
                                foreach ($allBank as $item) {
                                    echo '<option value="' . $item->bank_name . '"> ' . $item->bank_name . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Account No </label>
                    <div class="col-md-5">
                        <select name="search[account_number]" ng-model="account" class="form-control">
                            <option value="" selected disabled>Select Account</option>
                            <option ng-repeat="accountNo in allAccount" ng-value="accountNo.account_number">{{
                                accountNo.account_number }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7 text-right">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        
        <?php if (!empty($resultset)) { ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h3 class="text-center hide" style="margin-top: -10px;">All Bank Transaction</h3>
                <table class="table table-bordered">
                    <tr>
                        <th> SL</th>
                        <th> Date</th>
                        <th> Transaction By</th>
                        <th> Bank Name</th>
                        <th> Account Number</th>
                        <th> Transaction Type</th>
                        <th> Amount</th>
                        <th class="none"> Action</th>
                    </tr>
                    <?php
                    $accounts = array();
                    foreach ($resultset as $key => $transaction) {
                        ?>
                        <tr>
                            <td> <?php echo $key + 1; ?> </td>
                            <td> <?php echo $transaction->transaction_date; ?></td>
                            <td> <?php echo $transaction->transaction_by; ?></td>
                            <td> <?php echo filter($transaction->bank); ?></td>
                            <td> <?php echo $accounts[] = $transaction->account_number; ?></td>
                            <td> <?php echo $transaction->transaction_type; ?></td>
                            <td>
                                <?php
                                    $total += $transaction->amount;
                                    echo $transaction->amount;
                                ?>
                            </td>
                            <td class="none">
                                <a title="Edit/Change" class="btn btn-warning" href="<?php echo site_url('bank/bankInfo/changeTransaction?id=' . $transaction->id); ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-danger" href="?id=<?php echo $transaction->id; ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    
                    <tr>
                        <th class="text-right" colspan="6">Total</th>
                        <th><?php echo f_number($total); ?></th>
                        <th class="none">&nbsp;</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
