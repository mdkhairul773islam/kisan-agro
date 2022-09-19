<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>CC Loan</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php
	            $attr=array('class'=>'form-horizontal');
	            echo form_open('cc_loan/cc_loan/add_cc_info',$attr); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="loan_rcv_date"   value="<?php echo date("Y-m-d"); ?>" class="form-control" >
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name"  id="name" class="form-control">
                    </div>
                </div>
         

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile No <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="contact_info"  id="contact_info" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="address"  id="address"  rows="3" class="form-control" required></textarea>
                    </div>
                </div>


                <div class="form-group" id="bank_col">
                    <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                    <div class="col-md-5">
                       <input type="text" name="bank_name" placeholder="Bank" class="form-control" >
                    </div>
                </div>


                <div class="form-group" id="loan_acc_num" >
                    <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="acc_no" id="acc_no" class="form-control">
                    </div>
                </div>


                <div class="form-group" id="loan_amount">
                    <label class="col-md-2 control-label">Loan Amount<span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="loan_amount" placeholder="BDT" class="form-control" >
                    </div>
                </div>

                <div class="form-group" >
                    <label class="col-md-2 control-label">Percentage <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="interest" placeholder="BDT" class="form-control">
                    </div>
                </div>
              
                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" name="save" id="submit_btn" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
  $("#acc_no").keyup(function(){
    var acc_no = $("#acc_no").val();
    $.post("<?php echo site_url('cc_loan/cc_loan/acc_validation');  ?>", 
    { acc_no:acc_no }, 
    function(data,success){
    //alert(data);
       if(data == 0){
           $('#submit_btn').show();
       }else{
           alert('Account Already Exists.Please Try Another Account..');
           $('#submit_btn').hide();
       }
    });
    });     
</script>
