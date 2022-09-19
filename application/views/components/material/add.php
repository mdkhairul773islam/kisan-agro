<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Material</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php echo form_open('material/material/store', ["class" => "form-horizontal"]); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

                <input type="hidden" name="code" value="<?php echo get_code('materials', 3, ['type' => 'raw']); ?>">

                <div class="form-group">
                    <label class="col-md-2 control-label">Price <span class="req">*</span></label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="price" class="form-control" placeholder="0"
                               step="any" required>
                        <div class="input-group-addon">TK / Kg</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Stock Alert <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="stock_alert" placeholder="0" step="any" class="form-control"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="raw_type" class="form-control" required>
                            <option value="" selected>-- Select type --</option>
                            <?php
                            if (!empty(config_item('raw_type'))) {
                                foreach (config_item('raw_type') as $value) {
                                    echo '<option value="' . $value . '"> ' . filter($value) . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="add_mats" value="Save" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
