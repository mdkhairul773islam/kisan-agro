<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Finish Product</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open('product/product/update', ['class' => 'form-horizontal']); ?>

                <input type="hidden" name="code" value="<?php echo $info->code; ?>">

                <div class="form-group">
                    <label class="col-md-3 control-label">Product Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" value="<?php echo $info->name; ?>" class="form-control" required>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label class="col-md-3 control-label">Weight <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="weight" value="<?php echo $info->weight; ?>" min="0" step="any"
                               class="form-control"
                               required>
                    </div>
                </div>
-->
                <div class="form-group">
                    <label class="col-md-3 control-label">Unit <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select class="selectpicker form-control" ng-model="unit" ng-init="unit='<?= $info->unit ?>'" name="unit" data-show-subtext="true"
                                data-live-search="true" required>
                            <option value="" selected disabled> Select Unit</option>
                            <?php
                            if (!empty(config_item('unit'))) {
                                foreach (config_item('unit') as $value) { ?>
                                    <option value="<?php echo $value; ?>" <?php echo($info->unit == $value ? 'selected' : '') ?>><?php echo filter($value); ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" ng-if="unit=='bag'">
                    <label class="col-md-3 control-label">Bag Size <span class="req">*</span></label>
                    <div class="col-md-5">
                         <input type="number" name="bag_size" min="0" value="<?= $info->bag_size ?>"
                        class="form-control"
                        required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Category <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select class="selectpicker form-control" name="category_id" data-show-subtext="true"
                                data-live-search="true" required>
                            <option value="" selected disabled> Select Category</option>
                            <?php
                            if (!empty($categoryList)) {
                                foreach ($categoryList as $row) { ?>
                                    <option value="<?php echo $row->id; ?>" <?php echo($info->category_id == $row->id ? 'selected' : '') ?>><?php echo $row->category; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Purchase Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="purchase_price" value="<?php echo $info->purchase_price; ?>" min="0"
                               class="form-control" step="any"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">MRP Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="sale_price" min="0" value="<?php echo $info->sale_price; ?>"
                               class="form-control" step="any"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">D.P Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="dealer_price" min="0" value="<?php echo $info->dealer_price; ?>"
                               class="form-control" step="any" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label">T.P Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="tp_price" min="0" value="<?php echo $info->tp_price; ?>"
                               class="form-control" step="any" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Stock Alert <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="stock_alert" min="0" value="<?php echo $info->stock_alert; ?>"
                               step="any" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Status <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="status" class="form-control">
                            <option value="available" <?php echo ($info->status == 'available' ? 'selected' : '')?>>Available</option>
                            <option value="unavailable" <?php echo ($info->status == 'unavailable' ? 'selected' : '')?>>Unavailable</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Update" name="update" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>