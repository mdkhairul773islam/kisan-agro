<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                    $attr=array("class"=>"form-horizontal");
                    echo form_open_multipart('', $attr);
                ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Join Date <span class="req">*</span></label>
                        <div class="input-group date col-md-6" id="datetimepicker1">
                            <input type="text" name="joining_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" <?php if($privilege == 'user'){ echo 'disabled'; } ?> required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Name <span class="req">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Father's Name <span class="req">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="father_name" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Mother's Name <span class="req">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="mother_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Gender <span class="req">*</span></label>
                        <div class="col-md-6">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="Male" checked> Male
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="Female" > Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Mobile <span class="req">*</span></label>
                        <div class="col-md-6">
                            <input type="text" name="mobile_number" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">NID No.  <span class="req">&nbsp;</span></label>
                        <div class="col-md-6">
                            <input type="text" name="nid_no" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">E-mail <span class="req">&nbsp; </span></label>
                        <div class="col-md-6">
                            <input type="text" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Present Address <span class="req">*</span></label>
                        <div class="col-md-6">
                            <textarea name="present_address" id="pre_addr" class="form-control" cols="30" rows="5" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Permanent Address <span class="req">*</span></label>
                        <div class="col-md-6">
                            <input type="checkbox" id="permanent_address" value="0"> <label for="permanent_address">same as present address. </label>
                            <textarea name="permanent_address" id="per_addr" class="form-control" cols="30" rows="5" required></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Department</label>
                        <div class="col-md-6" >
                            <select name="department" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>Select Department</option>
                                <?php
                                if (!empty($departmentList)) {
                                    foreach ($departmentList as $key => $row) { ?>
                                        <option value="<?php echo $row->department; ?>">
                                            <?php echo $row->department; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div> 
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Designation</label>
                        <div class="col-md-6" >
                            <select name="designation" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>Select Designation</option>
                                <?php
                                if (!empty($designationList)) {
                                    foreach ($designationList as $key => $row) { ?>
                                        <option value="<?php echo $row->designation; ?>">
                                            <?php echo $row->designation; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>   
                    
                    <div class="form-group" >
                        <label class="col-md-3 control-label">Salary <span class="req">*</span></label>
                        <div class="col-md-6">
                            <input type="number" min="0" step="1" name="salary" value="0" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group teachers_option">
                        <label class="col-md-3 control-label">Status </label>
                        <div class="col-md-6">
                            <select name="status" class="form-control" required >
                                <option value="" > Select  Status  </option>
                                <option  value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Salary Type </label>
                        <div class="col-md-6">
                            <select name="type" class="form-control" required >
                                <option value="" selected disabled> Select Type  </option>
                                <option value="Monthly">Monthly</option>
                                <!--<option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>-->
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Photo <span class="req">&nbsp;</span></label>
                        <div class="col-md-6">
                            <input id="input-test" type="file" name="attachFile" class="form-control file" data-show-preview="true" data-show-upload="false" data-show-remove="false">
                        </div>
                    </div>


                    <div class="col-md-9">
                        <div class="btn-group pull-right" style="margin-right: -5px;">
                            <input type="submit" name="add_emp" value="Save" class="btn btn-primary">
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
        $("#permanent_address").on("click",function(){
            if ($(this).is(":checked")) {
                $("#per_addr").val($("#pre_addr").val());
            }
            else{
                $("#per_addr").val("");
            }
        });
    });
</script>
<script type="text/javascript">
        $(document).ready(function(){
    $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});
</script>
