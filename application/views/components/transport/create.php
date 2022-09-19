<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Transport</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <?php
                $attr = array('class' => 'form-horizontal', 'id' => 'form');
                echo form_open('transport/transport/store', $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Date <span class="req">*</span></label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="created" class="form-control"
                                   value="<?php echo date("Y-m-d"); ?>" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Company Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="company_name" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Manager Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="manager_name" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Email <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="email" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <textarea name="address" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Remarks <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <textarea name="remarks" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 text-right">
                        <input type="submit" name="save" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
