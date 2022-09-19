<style>
    @media print {
       .emp-photo img:last-child {
            margin-top: 115px;
            width: 150px;
            margin-right: 0;
        }
    }
    .print-image {width: 30% !important;}
    .emp-photo {position: relative;}
    .emp-photo img:last-child {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 100px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Profile</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i>print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                
                <h4 class="text-center">
                    Employee Profile
                </h4>
                <div class="row">
                     
                    <!-- left side -->
                    <div class="col-xs-12 photo">
                        <figure class="profile-pic">
                            <div class="border-top none">&nbsp;</div>
                            <img class="print-image" style="margin-bottom: 0;" src="<?php echo site_url($emp_info[0]->path); ?>" alt="" class="img-responsive img-thumbnail">
                        </figure>
                        <br/>
                        <hr class="hide" style="border-bottom: 2px solid #ccc; margin-top: 5px;">
                    </div>


                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Join Date </label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->joining_date); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">ID No.</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->emp_id; ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Name</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->name); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Gender</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->gender); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Father's</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->father_name); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Mother's Name  </label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->mother_name); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">E-mail</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->email); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Mobile </label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->mobile); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">NID No.   </label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->nid_no); ?></p>
                        </div>
                    </div>

                    
                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Designation</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->designation); ?></p>
                        </div>
                    </div>


                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Department</label>
                        <div class="col-xs-6">
                            <p><?php echo $emp_info[0]->department; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Salary</label>
                        <div class="col-xs-6">
                            <p class="text-left"><?php echo v_check($emp_info[0]->employee_salary); ?> TK</p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Status</label>
                        <div class="col-xs-6">
                            <p class="text-left"><?php echo filter($emp_info[0]->status); ?></p>
                        </div>
                    </div>


                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Present Address</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->present_address); ?></p>
                        </div>
                    </div>

                    <div class="col-xs-6 no-padding">
                        <label class="control-label col-xs-6">Permanent Address</label>
                        <div class="col-xs-6">
                            <p><?php echo v_check($emp_info[0]->permanent_address); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
