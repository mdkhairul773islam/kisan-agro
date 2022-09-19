<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Client</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal", "id" => "form");
                echo form_open_multipart('client/client/store', $attr); ?>


                <input type="hidden" name="code" class="form-control" value="<?php echo clientUniqueId('parties'); ?>" readonly>
                
               <?php if($this->data['privilege'] == 'super') { ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"> Godown <span class="req">*</span></label>
                    <div class="col-md-6">
                        <select class="form-control" name="godown_code" ng-model="godown_code" ng-change="getAllProductsFn()">
                            <option value="" selected disabled>Select Godown</option>
                            <?php if(!empty($allGodowns)){ foreach($allGodowns as $row){ ?>
                            <option value="<?php echo $row->code; ?>">
                                <?php echo filter($row->name)." ( ".$row->address." ) "; ?>
                            </option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
                <?php } else { ?>
                    <input type="hidden" name="godown_code" ng-init="godown_code = '<?php echo $this->data['branch']; ?>'" ng-model="godown_code" value="<?php echo $this->data['branch']; ?>">
               <?php } ?>
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
                        <input type="text" name="mobile" class="form-control" required>
                    </div>
                </div>
    
                <div class="form-group">
                    <label class="col-md-3 control-label">SR<span class="req"> *</span></label>
                    <div class="col-md-6">
                        <select name="sr_id" class="form-control" required>
                            <option value="" selected disabled></option>
                            <?php 
                                $sr = get_result('sr', ['trash'=>0], ['id', 'name'], '', 'name', 'ASC');
                                if(!empty($sr)){
                                    foreach($sr as $row){ 
                            ?>
                            <option value="<?= $row->id ?>"><?= filter($row->name) ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Road/Area &nbsp;</label>
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
                    <label class="col-md-3 control-label">Credit Limit<span class="req"> *</span></label>
                    <div class="col-md-6">
                        <input type="number" min="0" name="credit_limit" class="form-control" placeholder="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Due Limit (%)<span class="req"> *</span></label>
                    <div class="col-md-6">
                        <input type="number" min="0" name="due_limit" class="form-control" placeholder="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Loan <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="loan" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Agreement <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="agreement" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">NID <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="nid" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Trade license  <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="trade_license" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false" required>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="btn-group pull-right">
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
    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>