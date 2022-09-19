<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit CC Loan Transaction</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open('cc_loan/cc_loan/edit_cc_trx',$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="trx_date"  value="<?php echo $row->trx_date; ?>" class="form-control" readonly>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="hidden" name="id" class="form-control" value="<?php echo $row->id; ?>" readonly>
                        <input type="text" class="form-control" value="<?php echo $row_acc_info->acc_no; ?>" readonly>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" value="<?php echo $row_acc_info->bank_name; ?>" readonly>
                    </div>
                </div>



                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" value="<?php echo $row_acc_info->name; ?>" readonly>
                    </div>
                </div>
         

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile No <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" class="form-control" value="<?php echo $row_acc_info->contact_info; ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea  rows="3" class="form-control"  readonly><?php echo $row_acc_info->address; ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Percentage</label>
                    <div class="col-md-5">
                        <input type="text" name="percentage" class="form-control" value="<?php echo $row->percentage; ?>" >
                    </div>
                </div>

                <?php if($row->loan_rcv > 0){ ?>
                    
                    <div class="form-group" >
                        <label class="col-md-2 control-label">Loan Amount</label>
                        <div class="col-md-5">
                             <input type="hidden" name="trx_type" value="Received"  class="form-control" >
                             <input type="text" name="loan_rcv" value="<?php echo $row->loan_rcv; ?>"  class="form-control" >
                        </div>
                    </div>
                    
                    <div class="form-group">    
                      <label class="col-md-2 control-label">Transaction Type</label>
                      <div class="col-md-5">
                          <input type="radio" id="male" name="loan_rcv_type" value="bank_loan" <?php if($row->loan_rcv_type == 'bank'){ echo 'checked'; } ?>  >
                          <label for="male">Bank Loan</label>
                          <input type="radio" id="female" name="loan_rcv_type" value="bank_charge" <?php if($row->loan_rcv_type == 'bank_charge'){ echo 'checked'; } ?>>
                          <label for="female">Bank Charge</label>
                      </div>
                    </div> 
                    
                    
                    <div class="form-group">
                    <label class="col-md-2 control-label">Charge Type </label>
                    <div class="col-md-5">
                          <select name="charge_type" class="form-control">
                            <option selected >-- Select Type --</option>
                            <option value="Service Charge" <?php if($row->charge_type == 'Service Charge'){ echo 'Selected'; } ?>  >Service Charge</option>
                            <option value="Insurance Bill" <?php if($row->charge_type == 'Insurance Bill'){ echo 'Selected'; } ?> >Insurance Bill</option>
                            <option value="Check Bill" <?php if($row->charge_type == 'Check Bill'){ echo 'Selected'; } ?> >Check Bill </option>
                            <option value="Sms Bill" <?php if($row->charge_type == 'Sms Bill'){ echo 'Selected'; } ?> >Sms Bill</option>
                        </select>
                    </div>
                </div>
                    
                    
                    
                <?php }else if($row->loan_paid > 0){ ?>
                   
                    <div class="form-group">
                        <label class="col-md-2 control-label">Loan Paid</label>
                        <div class="col-md-5">
                            <input type="hidden" name="trx_type" value="Paid"  class="form-control" >
                            <input type="text" name="loan_paid"  value="<?php echo $row->loan_paid; ?>" class="form-control" >
                        </div>
                    </div>
    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Interest Paid</label>
                        <div class="col-md-5">
                            <input type="text" name="interest_paid"  value="<?php echo $row->interest_paid; ?>" class="form-control" >
                        </div>
                    </div>
                <?php  }else{ ?>
                    <input type="hidden" name="trx_type" value=""  class="form-control" >
                <?php  } ?>
                
                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Change" name="save" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

