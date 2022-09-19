<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>CC Ledger</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                    $attr = array('class' => 'form-horizontal');
                    echo form_open('cc_loan/cc_loan/alltransaction');
                ?>
                <div class="form-group">
                    <div class="col-md-3">
                        <select name="acc_no" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>Select Account Number</option>
                            <?php $acc_no = $this->action->read('cc_loan');  ?>
                            <?php foreach($acc_no as $value){ ?>
                                <option value="<?php echo $value->acc_no; ?>"> <?php echo $value->bank_name.'-'.$value->acc_no;  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start -->
                <?php $this->load->view('components/print'); ?>
                
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">CC Transaction</h3>
                </div>
                
                <?php 
                    if(!empty($all_trx)){ 
                    $sl=1;
                    $loan_holder_info = get_row('cc_loan',['acc_no' => $_POST['acc_no']]);
                ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Bank Name</th>
                        <th>Accont No</th>
                    </tr>
                    <tr>
                        <td><?php echo $loan_holder_info->name; ?></td>
                        <td><?php echo $loan_holder_info->address; ?></td>
                        <td><?php echo $loan_holder_info->bank_name; ?></td>
                        <td><?php echo $loan_holder_info->acc_no; ?></td>
                    </tr>
                </table>
                
                
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Loan Receive</th>
                        <th>Loan Paid</th>
                        <th>Loan Charge</th>
                        <th>Loan Due</th>
                        <th>Interest Paid</th>
                        <th>Int/Day</th>
                        <th>Day</th>
                        <th>Interest</th>
                        <th>Balance</th>
                    </tr>                                     
                    <?php  
                    $total_payable_interest = 0;
                    $total_loan_rcv = $total_loan_paid = $total_loan_charge = $total_loan_due = $total_interest_paid = $total_payable_interest = $day_count = 0;
                    
                    foreach($all_trx as $key => $value){ 
                       
                        $single_day_interest = 0;
                        $percentage = $value->percentage;
                        $total_loan_rcv += $value->loan_rcv;
                        $total_loan_paid += $value->loan_paid;
                        $total_loan_charge += $value->loan_charge;
                        $total_interest_paid += $value->interest_paid;
                        $start_date = $value->trx_date;
                        
                        if(!empty($all_trx[$key+1])){
                           $end_date = $all_trx[$key+1]->trx_date;
                        }else{
                            if($value->loan_close_date == null){
                                 $end_date = date('Y-m-d');
                            }else{
                                 $end_date = $value->loan_close_date;
                            }
                        }
                       
                        $date_start =date_create($start_date);
                        $date_end =date_create($end_date);
                        $diff=date_diff($date_start,$date_end);
                        $day_count =$diff->format("%a");
                        
                        $loan_due = 0;
                        $loan_due = $total_loan_rcv - $total_loan_paid - $total_loan_charge;
                        $single_day_interest = ($loan_due > 0 ? ($percentage*$loan_due)/36500 : 0);
                        $payable_interest = $single_day_interest*$day_count;
                        $total_payable_interest += $single_day_interest*$day_count;
                       
                    ?>    
                        <tr>
                            <td><?php echo $sl;$sl++; ?></td>
                            <td><?php echo  $value->trx_date; ?></td>
                            <td>
                                <?php 
                                    echo  $value->loan_rcv;
                                    if($value->loan_rcv_type == 'bank_charge'){
                                        echo ' (Bank Charge-';
                                        echo '<br>';
                                        echo $value->charge_type.')';
                                    }
                                ?>
                            </td>
                            <td><?php echo $value->loan_paid; ?></td>
                            <td><?php echo $value->loan_charge; ?></td>
                            <td><?php echo $loan_due; ?></td>
                            <td><?php echo $value->interest_paid; ?></td>
                            <td><?php echo number_format($single_day_interest,2); ?></td>
                            <td><?php echo $day_count; ?></td>
                            <td><?php echo number_format($payable_interest,2);  ?></td>
                            <td><?php echo number_format($loan_due+$payable_interest,2); ?></td>
                        </tr>    
                    <?php } ?>
                    <tr>
                        <td colspan="2" class="text-right" ><b>Total&nbsp;&nbsp;</b></td>
                        <td><b><?php echo $total_loan_rcv; ?>  Tk</b></td>
                        <td><b><?php echo $total_loan_paid; ?> Tk</b></td>
                        <td><b><?php echo $total_loan_charge; ?> Tk</b></td>
                        <td><b><?php echo $loan_due; ?> Tk</b></td>
                        <td><b><?php echo $total_interest_paid; ?> Tk</b></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><b><?php echo number_format($total_payable_interest,2); ?> Tk</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7" class="text-right" ><b>Total Interest Due&nbsp;&nbsp;</b></td>
                        <td colspan="2"><b><?php echo number_format(($total_payable_interest - $total_interest_paid),2); ?></b></td>
                        <td colspan="2">&nbsp;</td>
                    </tr>    
                </table>
                <?php } ?>    
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>