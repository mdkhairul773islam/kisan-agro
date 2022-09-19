<div class="container-fluid"  ng-controller="addCommitmentCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Commitment</h1>
                </div>
            </div>
  
            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $privilege = $this->session->userdata('privilege');
                $branch = $this->session->userdata('branch');
                
                echo form_open('', ["class" => "form-horizontal"]); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Client Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select ui-select2="{ allowClear: true}" class="form-control" name="party_code" ng-model="party_code" ng-change="getUserInfoFn()" data-placeholder="Select Client" required>
                            <option value="" selected disable> </option>
                            <option ng-repeat="client in clientList" value="{{client.code}}">{{ client.name }} - {{ client.address }}</option>
                        </select>
                    </div>
                </div>
                

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" ng-model="partyInfo.mobile"  class="form-control"  readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address</label>
                    <div class="col-md-5">
                        <textarea ng-model="partyInfo.address"  cols="15" rows="3" class="form-control" readonly></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Commitment</label>
                    <div class="col-md-5">
                        <textarea name="commitment" cols="15" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Date</label>
                    <div class="col-md-5 input-group date" id="datetimepicker">
                        <input type="text" name="date" class="form-control">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" name="add" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>
