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
                    <h1>Edit Advanced Salary</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array(
                    'class' =>'form-horizontal'
                    );
	            echo form_open('employee/employee/advanced_salary_history_edit',$attr); ?>


                <div class="form-group">
                    <label class="col-md-3 control-label">Advanced Date <span class="req">*</span></label>
                    <div class="col-md-4">
                        <div class="input-group date datetimepickerTo" >
                            <input type="text" name="advanced_date"  id="advanced_date"  class="form-control"  value="<?php echo $row[0]->advance_date;  ?>"   required readonly>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>       


                <div class="form-group">
                    <label class="col-md-3 control-label">Employee<span class="req">*</span></label>
                    <div class="col-md-4">
                         <input type="hidden" name="id"  value="<?php echo $row[0]->id;  ?>" class="form-control">
                        <select name="employee_id"  id="employee_dropdown"    class="form-control selectpicker" data-show-subtext="true" data-live-search="true" disabled  required>
                            <option value="">-- Select Employee --</option>
                             <?php 
                             $listing = $this->action->read('employee',array('trash' => 0));
                             foreach($listing as $rowc){  ?>
                                <option value="<?php echo $rowc->emp_id; ?>" <?php if($rowc->emp_id == $row[0]->emp_id){ echo 'selected'; } ?>  >
                                    <?php echo $rowc->emp_id.'-'.$rowc->name ?>
                                </option>
                             <?php } ?>
                        </select>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Salary<span class="req">*</span></label>
                    <div class="col-md-4">
                        <?php
                            $id = $row[0]->emp_id;
                            $emp_info = $this->action->read('employee',array('emp_id' => $id));
                            if(!empty($emp_info)){
                                 $salary = $emp_info[0]->employee_salary;
                            }else{
                                $salary = 0;
                            }
                        ?>
                        <input type="text" value="<?php echo $salary;  ?>" class="form-control" readonly>
                    </div>
                </div>

                 <div class="form-group">
                    <label class="col-md-3 control-label"> Dew  Amount<span class="req">*</span></label>
                    <div class="col-md-4">
                        <?php
                            
                            
                             $advanced_day = (explode("-",$row[0]->advance_date));
                             $advanced_day_month = $advanced_day[1];
                             $advanced_day_year = $advanced_day[0];
                             
                             
                             $where['emp_id'] = $row[0]->emp_id;
                             $where['advance_date >='] =   $advanced_day_year.'-'.$advanced_day_month.'-01';
                             $where['advance_date <='] =   $advanced_day_year.'-'.$advanced_day_month.'-31';
                             
                             $advance_salary = $this->action->read_sum('advanced_salary','amount',$where);
                             $advance_salary = $advance_salary[0]->amount;
                             
                             $dew_amount = $salary - $advance_salary;
                        
                        ?>
                        <input type="text"  value="<?php echo $dew_amount; ?>"    readonly  class="form-control" >
                    </div>
                </div>               

                <div class="form-group">
                    <label class="col-md-3 control-label"> Advanced  Amount<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="amount"  value="<?php echo $row[0]->amount; ?>"   class="form-control" >
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