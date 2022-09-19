<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Client</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal", "id" => "form");
                echo form_open_multipart('client/client/update/' . $info->id, $attr); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Client Name <span class="req">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="name" value="<?php echo $info->name; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Contact Person &nbsp;</label>
                    <div class="col-md-6">
                        <input type="text" name="contact_person" value="<?php echo $info->contact_person; ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile<span class="req">*</span></label>
                    <div class="col-md-6">
                        <input type="text" name="mobile" value="<?php echo $info->mobile; ?>" class="form-control"
                               required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">SR<span class="req">*</span></label>
                    <div class="col-md-6">
                        <select name="sr_id" class="form-control" required>
                            <option value="" selected disabled>Select SR</option>
                            <option selected value="0">N/A</option>
                            <?php 
                                $sr = get_result('sr', ['trash'=>0], ['id', 'name'], '', 'name', 'ASC');
                                if(!empty($sr)){
                                    foreach($sr as $row){   
                            ?>
                            <option <?= $info->sr_id==$row->id ? "selected" : "" ?> value="<?= $row->id ?>"><?= filter($row->name) ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Road/Area &nbsp;</label>
                    <div class="col-md-6">
                        <textarea name="address" cols="15" rows="5"
                                  class="form-control"><?php echo $info->address; ?></textarea>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Initial Balance (TK) <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="number" name="balance" value="<?php echo abs($info->initial_balance); ?>"
                               class="form-control" step="any" required>
                    </div>

                    <div class="col-md-2">
                        <select name="balance_type" class="form-control">
                            <option value="receivable" <?php echo($info->initial_balance >= 0 ? 'selected' : '') ?>>
                                Receivable
                            </option>
                            <option value="payable" <?php echo($info->initial_balance < 0 ? 'selected' : '') ?>>
                                Payable
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Status <span class="req">*</span></label>
                    <div class="col-md-6">
                        <select name="status" class="form-control">
                            <option value="active" <?php echo($info->status == 'active' ? 'selected' : '') ?>>
                                Active
                            </option>
                            <option value="inactive" <?php echo($info->status == 'inactive' ? 'selected' : '') ?>>
                                Inactive
                            </option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Credit Limit<span class="req"> *</span></label>
                    <div class="col-md-6">
                        <input type="number" min="0" name="credit_limit" value="<?= $info->credit_limit ?>" class="form-control" placeholder="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Due Limit(%)<span class="req"> *</span></label>
                    <div class="col-md-6">
                        <input type="number" min="0" name="due_limit" value="<?= $info->due_limit ?>" class="form-control" placeholder="0">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">Loan </label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="loan" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Agreement</label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="agreement" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">NID</label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="nid" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Trade license </label>
                    <div class="col-md-6">
                        <input id="input-test" type="file" name="trade_license" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false">
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update" value="Update" class="btn btn-primary">
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