<div class="container-fluid">
    <div class="row">
        <?php //echo $confirmation; ?>
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Supplier</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal", "id" => "form");
                echo form_open('supplier/supplier/update/'.$info->id, $attr);
                ?>


                <div class="form-group">
                    <label class="col-md-3 control-label">Supplier/Person Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" value="<?php echo $info->name; ?>" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Contact Person</label>
                    <div class="col-md-5">
                        <input type="text" name="contact_person" value="<?php echo $info->contact_person; ?>"
                               class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile<span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="mobile" value="<?php echo $info->mobile; ?>" class="form-control"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address </label>
                    <div class="col-md-5">
                        <textarea name="address" cols="15" rows="5"
                                  class="form-control"><?php echo $info->address; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Initial Balance (TK) <span class="req">*</span></label>
                    <div class="col-md-3">
                        <input type="number" name="balance" value="<?php echo abs($info->initial_balance); ?>"
                               class="form-control" min="0" step="any"
                               required>
                    </div>

                    <div class="col-md-2">
                        <select name="balance_type" class="form-control">
                            <option value="payable" <?= ($info->initial_balance < 0 ? 'selected' : '') ?>>Payable</option>
                            <option value="receivable" <?= ($info->initial_balance >= 0 ? 'selected' : '') ?>>Receivable</option>
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

                <div class="col-md-8">
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
