<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<div class="container-fluid" ><!--ng-controller="addSubcategoryCtrl"  -->
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Depriciation</h1>
                </div>
            </div>

            <div class="panel-body">
            <?php   $attr = array('class' =>'form-horizontal');
                    echo form_open('depriciation/depriciation/addDepriciation', $attr); ?>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Date <span class="req">*</span></label>
                    
                    <div class="input-group date col-md-5" id="datetimepicker1">
                        <input type="text" name="date" class="form-control" required>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Showroom <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="">Select Showroom</option>
                            <?php foreach($showroom as $key => $value){ ?>
                            <option value="<?php echo $value->code; ?>"> <?php echo $value->name; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Amount <span class="req">*</span></label>

                    <div class="col-md-5">
                        <input type="number" name="amount" step="any" placeholder="" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Particulars <span class="req">*</span></label>

                    <div class="col-md-5">
                        <textarea name="particulars" class="form-control" rows="5" required></textarea>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="submit" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
