<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .panel .hide{
            display: block !important;
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Advanced Salary</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array(
                    'class' =>'form-horizontal'
                    );
	            echo form_open('employee/employee/advanced_salary',$attr); ?>


                <div class="form-group">
                    <label class="col-md-3 control-label">Advanced Date <span class="req">*</span></label>
                    <div class="col-md-4">
                        <div class="input-group date datetimepickerTo" >
                            <input type="text" name="advanced_date"  value="<?php echo date('Y-m-d'); ?>"  id="advanced_date"  class="form-control"  placeholder="Advanced Date" required >
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>       


                <div class="form-group">
                    <label class="col-md-3 control-label">Employee<span class="req">*</span></label>
                    <div class="col-md-4">
                        <select name="employee_id"  id="employee_dropdown"    class="form-control selectpicker" data-show-subtext="true" data-live-search="true"   required>
                            <option value="">-- Select Employee --</option>
                             <?php 
                             $listing = $this->action->read('employee',array('trash' => 0));
                             foreach($listing as $rowc){  ?>
                                <option value="<?php echo $rowc->emp_id; ?>">
                                    <?php echo $rowc->emp_id.'-'.$rowc->name ?>
                                </option>
                             <?php } ?>
                        </select>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Salary<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" id="salary_amount" placeholder="" class="form-control" readonly>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Due Salary<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" id="dew_salary_amount" placeholder="" class="form-control" readonly>
                        <input type="hidden" name="const_dew_amount" id="const_dew_amount">
                    </div>
                </div>


                 <div class="form-group">
                    <label class="col-md-3 control-label"> Previous Advanced  Amount<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="previous_advance_amount" id="previous_advance_amount" placeholder="" class="form-control" readonly>
                    </div>
                </div>  


                 <div class="form-group">
                    <label class="col-md-3 control-label"> Advanced  Amount<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="amount" id="advance_salary_amount"   class="form-control" >
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
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    
        $('.datetimepickerTo').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false
        });

        
        // employee dropdown change data
        $("#employee_dropdown").change(function(){
                
                var employee_id = $("#employee_dropdown").val();
                var advanced_date = $("#advanced_date").val();
                
                    $.post("<?php echo site_url('employee/employee/advanced_salary_ajax_data');  ?>", 
                    { employee_id: employee_id , advanced_date: advanced_date}, 
                    function(data,success){
                        //alert(data);
                        var data_arr; 
                        data_arr = data.split("+");
                        $('#salary_amount').val(data_arr[0]);
                        $('#previous_advance_amount').val(data_arr[1]);
                        $('#const_dew_amount').val(data_arr[2]);
                        $('#dew_salary_amount').val(data_arr[2]);
                    });
        });

        
        // datepicker event  change data
        $(".datetimepickerTo").on("dp.change", function(e) {
       
                var employee_id = $("#employee_dropdown").val();
                var advanced_date = $("#advanced_date").val();
                
                    $.post("<?php echo site_url('employee/employee/advanced_salary_ajax_data');  ?>", 
                    { employee_id: employee_id , advanced_date: advanced_date}, 
                    function(data,success){
                        //alert(data);
                        var data_arr; 
                        data_arr = data.split("+");
                        $('#salary_amount').val(data_arr[0]);
                        $('#previous_advance_amount').val(data_arr[1]);
                        $('#const_dew_amount').val(data_arr[2]);
                        $('#dew_salary_amount').val(data_arr[2]);
                    });
    }); 


        $('#advance_salary_amount').keyup(function(){
            
            var dew = $('#const_dew_amount').val();
            dew = parseInt(dew);
            
            var advance_amount = $('#advance_salary_amount').val();
            advance_amount = parseInt(advance_amount);
            
            var current_amount= dew-advance_amount;
            current_amount = parseInt(current_amount);
            
            if(isNaN(current_amount)){
                $('#dew_salary_amount').val(dew);
            }else{
                $('#dew_salary_amount').val(current_amount);
            }
        
        });

    });    
</script>