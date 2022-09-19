<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>All CC Transaction </h1>
                </div>
            </div>
            <?php
            
                $attr = array('class' => 'form-horizontal');
                echo form_open('cc_loan/cc_loan/all_cc_trx');
            ?>
            <div class="panel-body none">
                <div class="form-group">
                    <div class="col-md-2">
                        <select name="acc_no" class="selectpicker form-control" data-show-subtext="true"
                        data-live-search="true" >
                            <option value="" selected disabled>Select Account Number</option>
                            <?php $acc_no = $this->action->read('cc_loan');  ?>
                            <?php foreach($acc_no as $value){ ?>
                                <option value="<?php echo $value->acc_no; ?>"> <?php echo $value->bank_name.'-'.$value->acc_no;  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <select name="loan_rcv_type" class="selectpicker form-control" data-show-subtext="true"
                        data-live-search="true" >
                            <option value="" selected disabled>loan Rcv Type</option>
                            <option value="bank">Bank</option>
                            <option value="bank_charge">Bank Charge</option>
                            
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <select name="charge_type" class="form-control">
                            <option selected disabled>-- Select Type --</option>
                            <option value="Service Charge">Service Charge</option>
                            <option value="Insurance Bill">Insurance Bill</option>
                            <option value="Check Bill">Check Bill </option>
                            <option value="Sms Bill">Sms Bill</option>
                        </select>
                    </div>    
                    
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
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
                ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Bank</th>
                            <th>Account No</th>
                            <th>Loan Receive</th>
                            <th>Loan Paid</th>
                            <th>Loan Charge</th>
                            <th>Interest Paid</th>
                            <th>Percentage</th>
                            <th class="none" >Action</th>
                        </tr>                                     
                        <?php  
                            $total_payable_interest = 0;
                            $total_loan_rcv = $total_loan_paid = $total_loan_charge = $total_loan_due = $total_interest_paid = $total_payable_interest = $day_count = 0;
                            foreach($all_trx as $value){
                                
                            $single_day_interest = 0;
                            $percentage = $value->percentage;
                            $total_loan_rcv += $value->loan_rcv;
                            $total_loan_paid += $value->loan_paid;
                            $total_loan_charge += $value->loan_charge;
                            $total_interest_paid += $value->interest_paid;
                        ?>    
                            <tr>
                                <td><?php echo $sl;$sl++; ?></td>
                                <td><?php echo  $value->trx_date; ?></td>
                                <td><?php echo  get_name('cc_loan','name',['acc_no' => $value->acc_no]); ?></td>
                                <td><?php echo  get_name('cc_loan','bank_name',['acc_no' => $value->acc_no]); ?></td>
                                <td><?php echo  $value->acc_no; ?></td>
                                <td>
                                    <?php 
                                        echo  $value->loan_rcv;
                                        if($value->loan_rcv_type == 'bank_charge'){
                                            echo '<br>';
                                            echo ' (Bank Charge-';
                                            echo '<br>';
                                            echo $value->charge_type.')';
                                        }
                                    ?>
                                </td>
                                <td><?php echo  $value->loan_paid; ?></td>
                                <td><?php echo  $value->loan_charge; ?></td>
                                <td><?php echo  $value->interest_paid; ?></td>
                                <td><?php echo  number_format($value->percentage,2); ?></td>
                                <td>
                                     
                                     <a title="Edit" class="btn btn-warning" href="<?php echo site_url('cc_loan/cc_loan/edit_cc_trx/'.$value->id); ?>">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                     </a>
             
                                     
                                     <a onclick="return confirm('Are you sure want to delete this Transaction?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('cc_loan/cc_loan/delete_cc_trx/'.$value->id); ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                     </a>
                                     
                                </td>
                            </tr>    
                        <?php } ?>
                        <tr>
                            <td colspan="5" class="text-right" ><b>Total</b></td>
                            <td><b><?php echo $total_loan_rcv; ?>  Tk</b></td>
                            <td><b><?php echo $total_loan_paid; ?> Tk</b></td>
                            <td><b><?php echo $total_loan_charge; ?> Tk</b></td>
                            <td><b><?php echo $total_interest_paid; ?> Tk</b></td>
                            <td class="none">&nbsp;</td>
                            <td class="none">&nbsp;</td>
                        </tr>    
                    </table>
                <?php } ?>    
            </div>
            <div class="panel-footer">&nbsp;</div>     
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>