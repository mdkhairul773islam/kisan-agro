<div class="container-fluid">
    <div class="row">
	<?php echo $confirmation; ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Transaction</h1>
                </div>
            </div>
            
            <div class="panel-body">
                <?php
	                $attr=array('class'=>'form-horizontal');
	                echo form_open('',$attr);
                ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                        
                        <div class="input-group date col-md-5" id="datetimepicker1">
                            <input type="text" name="date" placeholder="YYYY-MM-YY" value="<?php echo date("Y-m-d"); ?>" class="form-control" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select name="bank_name" id="bank_name" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="">Select Bank</option>
                               <?php foreach ($bank_list as $key => $value) { ?>
                               <option value="<?php echo $value->bank_name; ?>"><?php echo str_replace("_"," ",$value->bank_name); ?></option>
                               <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select id="account_number" name="account_number" class="form-control" required>
                                <option value="">Select</option>                       
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-2 control-label">Holder  Name </label>
                        
                        <div class="col-md-5">
                            <input id="holder_name" type="text"  class="form-control" readonly/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Transaction Type <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <select name="transaction_type" class="form-control" required>
                                <option value="" selected disabled>Select Type</option>
                                <option value="Debit">Debit</option>
                                <option value="Credit">Credit</option>
                                <option value="bank_to_TT">Bank TT</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">TK <span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <input type="text" name="amount" placeholder="BDT" class="form-control" required>
                        </div>
                    </div>                    

                    <div class="form-group">
                        <label class="col-md-2 control-label">Transaction By<span class="req">*</span></label>
                        
                        <div class="col-md-5">
                            <input type="text" name="transaction_by"  class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Particulars </label>
                        <div class="col-md-5">
                            <textarea name="remarks" rows="3" class="form-control" ></textarea>
                        </div>
                    </div>

                    <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="add_transaction" class="btn btn-primary">
                    </div>
                    </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$("#bank_name").on("change",function(){
		var bank_name=$(this).val();
			 function view_data(){
				$.ajax({
					type:"POST",
					data:{bankName: bank_name},
					url:"<?php echo base_url('bank/bankInfo/ajax_account_list');?>"
				}).success(function(response){
				    
					var data=JSON.parse(response);
					var per_data=[];
					$.each(data,function(key,fieldName){
						per_data.push('<option value="'+fieldName.account_number+'">'+fieldName.account_number+'</option>');
						
					});
					//$("#account_number").append(per_data);
					document.getElementById("account_number").innerHTML='<option value="">Select</option>'+per_data;
				});
			 }
			 view_data();
		});
	});
</script>


<script>
	$(document).ready(function(){
		$("#account_number").on("change",function(){
		var account_number=$(this).val();
			 function view_data(){
				$.ajax({
					type:"POST",
					data:{account_number:account_number},
					url:"<?php echo base_url('bank/bankInfo/ajax_account_number');?>"
				}).success(function(response){
				    $('#holder_name').val(JSON.parse(response)[0]['holder_name']);
				});
			 }
			 view_data();
		});
	});
</script>