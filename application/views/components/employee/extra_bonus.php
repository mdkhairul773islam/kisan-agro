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
                $attr=array(
                    "class"=>"form-horizontal"
                    );
                echo form_open_multipart("employee/employee/extra_bonus",$attr);?>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Extra Amount </label>
                        <div class="col-md-6">
                            <input type="text" name="extra_bonus"  class="form-control">
                            <input type="hidden" name="id" value="<?php echo $this->uri->segment(4); ?>">
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="btn-group pull-right" style="margin-right: -5px;">
                            <input type="submit" name="update" value="Update" class="btn btn-success">
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
