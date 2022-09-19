<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);} ?>

<div class="container-fluid">
    <div class="row">
	<?php echo $confirmation; ?>
        <?php if($branch == "godown") { ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Account</h1>
                </div>
            </div>
            
            <div class="panel-body none">
                <?php $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); ?>
                <div class="form-group row">
                    <label class="col-md-2 control-label">Showroom <span class="req">&nbsp;</span></label>
                    <div class="col-md-5" style="margin-bottom: 15px;">
                        <select name="showroom" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="">--Select Showroom--</option>
                            <option value="godown">Head Office</option>
                            <?php
                            foreach ($showrooms as $key => $row) { ?>
                            <option value="<?php echo $row->showroom_id; ?>"> <?php echo filter($row->name); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>


        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Account</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>

                </div>
            </div>
            
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <div class="col-md-12 text-center hide">
                    <h3>All Account</h3>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th> Date </th>
                        <th> Bank Name </th>
                        <th> Branch Name </th>
                        <th> Routing Number </th>
                        <th> Holder Name </th>
                        <th> Account Number</th>
                        <th> Initial Balance</th>
                        <th> Current Balance</th>
                        <th width="40" class="none"> Action </th>
                    </tr>
                    <?php
                    $totalBalance = 0.00;
                    foreach($all_account as $key=>$account){

                        $where = array(
                        "bank"              =>  $account->bank_name,
                        "account_number"    =>  $account->account_number
                        );

                        $transaction = $this->retrieve->read("transaction",$where);

                        $credits = $debits = $balance = 0;

                        foreach ($transaction as $val) {
                        if ($val->transaction_type=="Credit") {
                            $credits += $val->amount;
                        }else{
                            $debits += $val->amount;
                        }
                        $balance = $credits - $debits;
                    }
                    ?>
                    <tr>
                        <td> <?php echo $key+1; ?> </td>
                        <td> <?php echo $account->datetime; ?> </td>
                        <td> <?php echo str_replace("_"," ",$account->bank_name); ?>  </td>
                        <td> <?php echo $account->branch_name; ?></td>
                        <td> <?php echo $account->routing_number; ?></td>
                        <td> <?php echo $account->holder_name; ?></td>
                        <td> <?php echo $account->account_number; ?> </td>
                        <td> <?php echo f_number($account->init_balance); ?> </td>
                        <td> <?php echo f_number($account->pre_balance + $balance); $totalBalance += ($account->pre_balance + $balance); ?></td>
                        <td class="none">
                            <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this data....?')" href="?id=<?php echo $account->id; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                   <?php } ?>
                   <tr>
                       <th colspan="8" class="text-right">Total</th>
                       <th><?php echo f_number($totalBalance); ?></th>
                       <th class="none"></th>
                   </tr>
                </table>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
