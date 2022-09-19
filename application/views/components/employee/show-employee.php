<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">All Employee</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <div class="row none">
                <?php echo form_open(); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[department]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
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
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[designation]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
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
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                <?php echo form_close(); ?>
                </div>
                
                <hr style="margin-top: 0px;">
                
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide">All Employee</h4>
                <div class="table-responsive">
                <table class="table table-bordered"  id="DataTable">
                    <thead>
                    <tr>
                        <th width="45">SL</th>
                        <th>ID</th>
                        <th>Join Date</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Salary</th>
                        <th class="none">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $total_salary = 0;
                        foreach ($results as $key => $emp) { 
                    ?>

                    <tr <?php if($emp->status == 'inactive'){ ?> style="background-color:#ffe6e6";  <?php } ?> >
                        <td class="text-center"> <?php echo $key+1; ?> </td>
                        <td> <?php echo $emp->emp_id; ?> </td>
                        <td> <?php echo $emp->joining_date; ?> </td>
                        <td> <?php echo filter($emp->name); ?> </td>
                        <td> <?php echo filter($emp->mobile); ?> </td>
                        <td> <?php echo filter($emp->permanent_address); ?> </td>
                        <td>  <?php echo filter($emp->department); ?></td>
                        <td> <?php echo filter(str_replace("_"," ", $emp->designation)); ?></td>
                        <td> 
                            <?php 
                                echo number_format($emp->employee_salary,2);
                                $total_salary = $total_salary + $emp->employee_salary;
                            ?>
                        </td>
                        <td class="none text-center">
                            <a class="btn btn-primary" href="<?php echo site_url('employee/employee/profile?id='.$emp->id);?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            
                                <a class="btn btn-warning" href="<?php echo site_url('employee/employee/edit_employee?id='.$emp->id) ;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            
                                <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this data?');" href="<?php echo site_url('/employee/employee/delete/'.$emp->id) ;?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <?php } ?> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="8" style="text-align:right;"><b>Total &nbsp;&nbsp;</b></td>
                        <td colspan="3"><b><?php echo number_format($total_salary,2);  ?></b></td>
                    </tr>
                    </tfoot>
                </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


