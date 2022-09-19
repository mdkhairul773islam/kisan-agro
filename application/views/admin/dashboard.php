<style>
    .header {padding: 0 15px;}
    .hr {
        border: 0.5px solid rgba(0, 168, 255, 1);
        margin: 10px -15px;
    }
    .md15 {margin: 0;}
</style>
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('error'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="dashboard-title text-center">Welcome To Dashboard...</h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php if (ck_action("dashboard", "todays_sale")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-1">
                            <span> Sale</span>
                            <h1><?= $total_sale ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "todays_client_pay")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-2">
                            <span> Client Pay</span>
                            <h1><?= $total_client_paid ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "total_client_due")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-3">
                            <span>Total Client Due</span>
                            <h1><?= $total_client_due ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "raw_mat_stock")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-4">
                            <span>Raw Mates Stock</span>
                            <h1><?= $raw_mates_stock ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "todays_purchase")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-5">
                            <span> Purchase</span>
                            <h1><?= $total_purchase ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "supplier_pay")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-6">
                            <span> Supplier Pay</span>
                            <h1><?= $total_supplier_paid ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "todays_expenses")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-7">
                            <span> Expenses</span>
                            <h1><?= $total_cost ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "todays_income")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-8">
                            <span> Income</span>
                            <h1><?= f_number($total_income) ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "total_exp_pay")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-8">
                            <span>Total Exp/Pay</span>
                            <h1><?= $total_exp_pay ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "supplier_due")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-1">
                            <span>Total Supplier Due</span>
                            <h1><?= $total_supplier_due ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "finish_stock")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-2">
                            <span>Finish Product Stock</span>
                            <h1><?= $finish_product_stock ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "bank_deposit")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-3">
                            <span>Bank Deposit</span>
                            <h1><?= f_number($bank_diposit) ?> </h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "bank_withdraw")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-4">
                            <span>Bank Withdraw</span>
                            <h1><?= f_number($bank_withdraw) ?> </h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "total_bank_balance")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-5">
                            <span>Total Bank Balance</span>
                            <h1><?= $total_bank_balance ?> </h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php /* if (ck_action("dashboard", "total_supplier")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-6">
                            <span>Total Supplier</span>
                            <h1><?= $total_supplier ?></h1>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if (ck_action("dashboard", "total_client")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-7">
                            <span>Total Client</span>
                            <h1><?= $total_client ?></h1>
                        </div>
                    </div>
                    <?php } */ ?>
                    
                    <?php if (ck_action("dashboard", "cash_in_hand")) { ?>
                    <div class="col-md-3">
                        <div class="dash-box dash-box-8">
                            <span> Cash In Hand</span>
                            <h1><?= $todays_cash ?> </h1>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                
                <hr>
                
                <div class="row">
                    <?php if (ck_action("dashboard", "raw_stock_alert")) { ?>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <caption class="text-center table-bordered">Raw Materials Stock Alert</caption>
                            <tr>
                                <th>SL</th>
                                <th>Code</th>
                                <th>Produt Name</th>
                                <th>Unit</th>
                                <th>Quantity (Kg)</th>
                            </tr>
                            <?php
                            foreach ($rawStockAlert as $_key => $item) {
                                ?>
                                <tr>
                                    <td><?= ++$_key ?></td>
                                    <td><?= $item->code ?></td>
                                    <td><?= filter($item->name) ?></td>
                                    <td><?= $item->unit ?></td>
                                    <td><?= $item->quantity ?></td>
                                </tr>
                                <?php
                            } ?>

                        </table>
                    </div>
                    <?php } ?>

                    <?php if (ck_action("dashboard", "finish_stock_alert")) { ?>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <caption class="text-center table-bordered">Finish Product Stock Alert</caption>
                            <tr>
                                <th>SL</th>
                                <th>Code</th>
                                <th>Produt Name</th>
                                <th>Unit</th>
                                <th>Quantity (Kg)</th>
                            </tr>
                            <?php
                            foreach ($finishStockAlert as $_key => $item) {
                                ?>
                                <tr>
                                    <td><?= ++$_key ?></td>
                                    <td><?= $item->code ?></td>
                                    <td><?= filter($item->name) ?></td>
                                    <td><?= $item->unit ?></td>
                                    <td><?= $item->quantity ?></td>
                                </tr>
                                <?php
                            } ?>
                        </table>
                    </div>
                    <?php } ?>
                </div>
                
                <div id='printMe2'>
                    <div class="col-md-offset-2 col-md-8">
                    	<table class="table table-bordered table-hover">
                    	    <tr>
                    	        <th colspan="7" class="text-center text-primary">Today Commitment's List
                    	        <a class="btn btn-primery pull-right none" style="font-size: 14px; margin-top: -10px;" id="printBtn2" onclick="printDiv2('printMe2')"><i class="fa fa-print"></i> Print</a></th>
                    	    </tr>
                    	    <tr>
                    	        <th width="45px">SL</th>
                    	        <th>Name</th>
                    	        <th>Customer Id</th>
                    	        <th>Mobile</th>
                    	        <th>Commitment</th>
                    	        <th>Address</th>
                    	        <th>Due</th>            	        
                    	    </tr>
                    	    
                    	    <?php foreach($todaysCommitment as $key => $comm_value){ ?>
                    	    <tr>
                    	        <td><?php echo $key+1;?></td>
                    	        <td><?php echo  filter($comm_value->name); ?></td>
                    	        <td><?php echo $comm_value->party_code;?></td>
                    	        <td><a href="tel:<?php echo $comm_value->mobile;?>"><?php echo $comm_value->mobile;?></a></td>
                    	        <td><?php echo $comm_value->commitment;?></td>
                    	        <td><?php echo $comm_value->address;?></td>
                                <td>
                                    <?php 
                                    $debit = $credit = $remission = $currentBalance = 0;
                                    $where = ['party_code' => $comm_value->party_code, 'trash' => 0];
                                    $tranInfo = get_result('partytransaction', $where, ['debit', 'credit', 'remission']);
                                    
                                    if(!empty($tranInfo)){
                                        
                                        foreach($tranInfo as $value){
                                            $debit += $value->debit;
                                            $credit += $value->credit;
                                            $remission += $value->remission;
                                        }
                                      
                                        if($comm_value->initial_balance < 0){
                                            $currentBalance = $debit - (abs($comm_value->initial_balance) + $credit + $remission);
                                        }else{
                                            $currentBalance = ($comm_value->initial_balance + $debit) - ($credit + $remission);
                                        }
                                        
                                        //$status = ($currentBalance < 0) ? " Payable" : " Receivable";   
                                        $status = ($currentBalance < 0) ? " - " : " ";   
                                        
                                    }else{
                                        
                                        $currentBalance = abs($comm_value->initial_balance);
                                        //$status = ($currentBalance->initial_balance < 0) ? " Payable" : " Receivable";
                                        $status = ($comm_value->initial_balance < 0) ? " - " : " ";
                                    }
                                   
                                    echo number_format($currentBalance, 2);
                                    ?>
                                </td>             	        
                    	    </tr>
                    	    <?php } ?>
                    	</table>
                    </div>
                </div>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    function printDiv2(divName2){
        var printBtn2 = document.getElementById('printBtn2').style.display = 'none';
    	var printContents2 = document.getElementById(divName2).innerHTML;
    	var originalContents2 = document.body.innerHTML;
    	document.body.innerHTML = printContents2;
    	window.print();
    	window.location.reload(true);
    	document.body.innerHTML = originalContents2;
    }
</script>