<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<div class="container-fluid">
    <div class="row">
    
    <?php echo $confirmation; ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Update</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr=array("class"=>"form-horizontal");
                echo form_open_multipart("employee/employee/edit_employee?id=".$this->input->get("id"),$attr); ?>
                
                    <div class="form-group">
                        <label class="col-md-3 control-label">&nbsp; </label>
                        <div class="col-md-6">
                            <img src="<?php echo base_url($emp_info[0]->path); ?>" width="80px" height="80px" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Join Date </label>
                        <div class="input-group date col-md-6" id="datetimepicker">
                            <input type="text" name="joining_date" placeholder="YYYY-MM-YY" class="form-control" value="<?php echo $emp_info[0]->joining_date; ?>" <?php if($this->data['privilege'] == 'user'){echo 'readonly';} ?> required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> ID No. </label>
                        <div class="col-md-6">
                            <input type="text" name="emp_id" value="<?php echo $emp_info[0]->emp_id; ?>" class="form-control" readonly required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Name </label>
                        <div class="col-md-6">
                            <input type="text" name="full_name" placeholder="Type Full Name" value="<?php echo $emp_info[0]->name; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Father's Name </label>
                        <div class="col-md-6">
                            <input type="text" name="father_name" value="<?php echo $emp_info[0]->father_name; ?>" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Mother's Name</label>
                        <div class="col-md-6">
                            <input type="text" name="mother_name" value="<?php echo $emp_info[0]->mother_name; ?>" class="form-control" >
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">Gender <span class="req">*</span></label>
                        <div class="col-md-6">
                            <label class="radio-inline">
                                <input <?php if($emp_info[0]->gender=="Male"){echo "checked";}?> type="radio" name="gender" value="Male"> Male
                            </label>
                            <label class="radio-inline">
                                <input <?php if($emp_info[0]->gender=="Female"){echo "checked";}?> type="radio" name="gender" value="Female"> Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Mobile </label>
                        <div class="col-md-6">
                            <input type="text" name="mobile_number" placeholder="without +88" value="<?php echo $emp_info[0]->mobile; ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">NID No. </label>
                        <div class="col-md-6">
                            <input type="text" name="nid_no" value="<?php echo $emp_info[0]->nid_no; ?>" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">E-mail </label>
                        <div class="col-md-6">
                            <input type="text" name="email" placeholder="Type your Email" value="<?php echo $emp_info[0]->email; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Present Address </label>
                        <div class="col-md-6">
                            <textarea name="present_address" id="pre_addr" class="form-control" cols="30" rows="5"><?php echo $emp_info[0]->present_address; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Permanent Address  </label>
                        <div class="col-md-6">
                            <textarea name="permanent_address" placeholder="Type Permanent Address" class="form-control" cols="30" rows="5" required><?php echo $emp_info[0]->permanent_address; ?></textarea>
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
                                        <option value="<?php echo $row->department; ?>" <?php echo ($emp_info[0]->department == $row->department ? 'selected' : ''); ?>>
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
                                        <option value="<?php echo $row->designation; ?>" <?php echo ($emp_info[0]->designation == $row->designation ? 'selected' : ''); ?>>
                                            <?php echo $row->designation; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Salary </label>
                        <div class="col-md-6">
                            <input type="number" name="salary" min="0" step="1" value="<?php echo $emp_info[0]->employee_salary; ?>" placeholder="Amount in Tk" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group teachers_option">
                        <label class="col-md-3 control-label">Status </label>
                        <div class="col-md-6">
                            <select name="status" class="form-control" >
                                <option value="" > &nbsp; </option>
                                <option <?php if($emp_info[0]->status == 'active'){echo "selected" ;} ?> value="active">Active</option>
                                <option <?php if($emp_info[0]->status == 'inactive'){echo "selected" ;} ?> value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Salary Type </label>
                        <div class="col-md-6">
                            <select name="type" class="form-control" required >
                                <option value="" selected disabled> Select Type  </option>
                                <option value="Monthly" <?php echo  $emp_info[0]->type == 'Monthly' ? 'selected' : ''; ?>>Monthly</option>
                                <option value="Daily" <?php echo  $emp_info[0]->type == 'Daily' ? 'selected' : ''; ?>>Daily</option>
                                <option value="Weekly" <?php echo  $emp_info[0]->type == 'Weekly' ? 'selected' : ''; ?>>Weekly</option>
                            </select>
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-3 control-label">Photo</label>
                        <div class="col-md-6">
                            <input id="input-test" type="file" name="attachFile" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="btn-group pull-right" style="margin-right: -5px;">
                            <input type="submit" name="update_emp" value="Update" class="btn btn-success">
                        </div>
                    </div>

                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function(){
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
});
</script>
