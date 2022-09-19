<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Comission</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php 
                    $attr = array('class' =>'form-horizontal');
    	            echo form_open(site_url('sr/sr/edit_comission/'.$sr_comission->id),$attr);
	            ?>
	            
                <div class="form-group">
                    <label class="col-md-3 control-label"> Date</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" name="date" class="form-control" value="<?php echo $sr_comission->date; ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"> Name </label>
                    <div class="col-md-5">
                        <input name="name" value="<?php echo $sr_comission->name; ?>" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile</label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" value="<?php echo $sr_comission->mobile; ?>" class="form-control">
                    </div>
                </div>
                
                

                <div class="form-group">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea type="text" name="address" class="form-control" readonly><?php echo $sr_comission->mobile; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Amount </label>
                    <div class="col-md-5">
                        <input type="number" step="any" name="amount" value="<?php echo $sr_comission->amount; ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8">
                        <input type="submit" value="Update" name="update" class="btn btn-success pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>