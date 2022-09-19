<div class="container-fluid" ng-controller="AddClientCtrl">
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Crushing Client</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open_multipart('', $attr); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Code <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="code" class="form-control" value="<?php echo $party_id; ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Client Name <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

				<div class="form-group">
                    <label class="col-md-3 control-label">Contact Person &nbsp;</label>
                    <div class="col-md-6">
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile<span class="req">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="contact" class="form-control"  required>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Address &nbsp;</label>
                    <div class="col-md-6">
                        <textarea name="address" cols="15" rows="5" class="form-control"></textarea>
                    </div>
                </div>


				<div class="form-group">
                    <label class="col-md-3 control-label">Initial Balance (TK) <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="number" name="balance" class="form-control" step="any" value="0.00" required>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-control">
                            <option value="receivable" selected>Receivable</option>
                            <option value="payable">Payable</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Credit Limit <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input type="number" name="credit_limit" class="form-control" step="any" value="0.00" required>
                    </div>
                </div>

                <div class="col-md-9">
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
