<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<!-- load Angular Controller -->
<div class="container-fluid" ng-controller="srComissionCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add  Comission</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array(
                    'class' =>'form-horizontal'
                    );
	            echo form_open('sr/sr/addcomission',$attr); ?>


                <div class="form-group">
                    <label class="col-md-3 control-label"> Date</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"> Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        
                        <select name="sr_id" ng-model="sr_id" ng-change="srInfoFn()" class="form-control" required>
                            <option value=""  selected disabled>-- Select Name --</option>
                            <?php foreach($sr as $value){ ?>
                                <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile</label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" ng-value="mobile" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea type="text" name="address" class="form-control" readonly>{{address}}</textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label"> Commission Balance </label>
                    <div class="col-md-5">
                        <input type="text" step="any" ng-model="balance"  class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Piad  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" step="any" name="amount" ng-model="amount" ng-change="dueBalanceFn()"  class="form-control" required>
                    </div>  
                </div>     
                  
                <div class="form-group">
                    <label class="col-md-3 control-label"> Due Commission </label>
                    <div class="col-md-5">  
                        <input type="text" ng-value="due" step="any"  class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8">
                        <input type="submit" value="Save" name="save" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>