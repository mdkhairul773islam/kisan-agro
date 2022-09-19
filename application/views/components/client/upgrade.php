<style media="screen">
	table caption {
		font-size: 14px;
		font-weight: bold;
		color: #333;
	}
</style>

<div class="container-fluid" ng-controller="ClientUpgradeCtrl">
    <div class="row">
			<!--pre><?php //print_r($info); ?></pre-->
		<?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Upgrade Profile</h1>
                </div>
            </div>

            <div class="panel-body" ng-init="code='<?php echo $this->input->get("partyCode"); ?>'">
                <?php
                $attr = array("class"=>"form-horizontal");
                echo form_open('client/client/upgrade_pro?partyCode=' . $this->input->get("code"), $attr);
                ?>

               <input type="hidden" name="code" value="<?php echo $info[0]->code; ?>">

               <div class="form-group">
                    <label class="col-md-2 control-label">Father's Name <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[father_name]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'father_name'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Mother's Name <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[mother_name]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'mother_name'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date Of Birth <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerDOB">
                            <input type="text" name="meta[dob]" class="form-control" placeholder="YYYY-MM-DD" value="<?php echo getPartyMeta($info[0]->code, 'dob'); ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Wife's Name <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[wife_name]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'wife_name'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Wife's Phone <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[wife_phone]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'wife_phone'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Date Of Marriage <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerDOM">
                            <input type="text" name="meta[dom]" class="form-control" placeholder="YYYY-MM-DD" value="<?php echo getPartyMeta($info[0]->code, 'dom'); ?>">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">National ID <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[nid]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'nid'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Trade License No <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[trade_license_no]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'trade_license_no'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Tin No <span class="req">&nbsp;</span></label>
                    <div class="col-md-5">
                        <input type="text" name="meta[tin_no]" class="form-control" value="<?php echo getPartyMeta($info[0]->code, 'tin_no'); ?>">
                    </div>
                </div>

				<table class="table table-bordered">
					<caption>Security </caption>

					<tr>
						<th>Bank name</th>
						<th>Branch name</th>
                        <th>Cheque</th>
						<th>Amount</th>
						<th class="text-right">Action</th>
					</tr>

					<tr ng-repeat="row in securities">
						<td>
							<select class="form-control" ng-model="row.bank" name="bank[]" required>
								<option value="" disabled selected>&nbsp;</option>
								<?php foreach ($allBank as $key => $value) { ?>
								<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
								<?php } ?>
							</select>
						</td>

						<td>
							<input type="text" name="branch[]" ng-model="row.branch" class="form-control">
						</td>

						<td>
							<input type="text" name="cheque[]" ng-model="row.cheque" class="form-control">
						</td>

                        <td>
                            <input type="text" name="amount[]" ng-model="row.amount" class="form-control">
                        </td>

						<td class="text-right">
							<a ng-click="deleteRowFn($index)" class="btn btn-danger">
								<i class="fa fa-trash"></i>
							</a>
						</td>
					</tr>

					<tr>
						<td colspan="5" class="text-right">
							<a ng-click="newRowFn()" class="btn btn-info">
								<i class="fa fa-plus"></i>
							</a>
						</td>
					</tr>
				</table>

				<div class="form-group">
	                <div class="col-md-12">
	                    <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
	                </div>
				</div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    // linking between two date
    $('#datetimepickerDOM').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerDOB').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
