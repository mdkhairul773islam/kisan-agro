<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Account Information Edit</h1>
                </div>
            </div>
           
            <div class="panel-body">

                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open('cc_loan/cc_loan/loan_edit',$attr); ?>
                    
                <div class="form-group">
                     <?php 
                        $trx_data = get_result('cc_loan_trx',['acc_no' => $row->acc_no]);
                        $count_trx = count($trx_data);
                     ?>
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="loan_rcv_date"   value="<?php echo $row->loan_rcv_date; ?>" class="form-control"   <?php  if($count_trx >1){ echo 'readonly'; } ?>>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name"  value="<?php echo $row->name; ?>"  class="form-control">
                        <input type="hidden" name="id"  value="<?php echo $row->id; ?>"  class="form-control">
                        <input type="hidden" name="trx_data_no"  value="<?php echo $count_trx; ?>"  class="form-control">
                    </div>
                </div>
         

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile No <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="contact_info"  value="<?php echo $row->contact_info; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="address" rows="3" class="form-control" required > <?php echo $row->address; ?> </textarea>
                    </div>
                </div>


                <div class="form-group" id="bank_col">
                    <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                    <div class="col-md-5">
                       <input type="text" name="bank_name" value="<?php echo $row->bank_name; ?>" class="form-control" >
                    </div>
                </div>


                <div class="form-group" id="loan_acc_num" >
                    <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="acc_no"  value="<?php echo $row->acc_no; ?>"  class="form-control" readonly>
                    </div>
                </div>


                <div class="form-group" id="loan_amount">
                    <label class="col-md-2 control-label">Loan Amount<span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="loan_amount" value="<?php echo $row->loan_amount; ?>" class="form-control"  <?php  if($count_trx >1){ echo 'readonly'; } ?>>
                    </div>
                </div>

                <div class="form-group" >
                    <label class="col-md-2 control-label">Percentage <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="interest" value="<?php echo $row->percentage; ?>" class="form-control"  <?php  if($count_trx >1){ echo 'readonly'; } ?>>
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
