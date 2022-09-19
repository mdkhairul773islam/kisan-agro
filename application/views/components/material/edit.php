<div class="container-fluid">
    <div class="row">
        <?php //echo $this->session->flashdata('confirmation');
        echo $confirmation; ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Raw Material</h1>
                </div>
            </div>
            <div class="panel-body">
                <!-- horizontal form -->
                <?php echo form_open('material/material/store', ["class"=>"form-horizontal"]); ?>

                 <div class="form-group">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-5">
                        <input type="text" name="name" value="<?php echo $info->name; ?>" class="form-control" >
                    </div>
                </div>
			
                <input type="hidden" name="code" value="<?php echo $info->code; ?>" class="form-control" >

                <div class="form-group">
                    <label class="col-md-2 control-label">Price</label>
                    <div class="col-md-5 input-group">
                        <input type="number" name="price" min="0" value="<?php echo $info->price; ?>" class="form-control" step="any">
                        <div class="input-group-addon">TK / kg</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Stock Alert <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="stock_alert" min="0" value="<?php echo $info->stock_alert; ?>" step="any" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-5 input-group">
                        <select name="status" class="form-control">
                            <?php foreach (config_item('status') as $value) { ?>
                                <option <?php if($value==$info->status) echo "selected"; ?> value="<?php echo $value; ?>"><?php echo filter($value); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Status</label>
                    <div class="col-md-5 input-group">
                        <select name="raw_type" class="form-control">
                            <?php
                            if (!empty(config_item('raw_type'))) {
                                foreach (config_item('raw_type') as $value) {
                                    echo '<option value="' . $value . '" '.(!empty($info) && $info->raw_type == $value ? "selected" : '').'> ' . filter($value) . ' </option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="update_mats" value="Update" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
