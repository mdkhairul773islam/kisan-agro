<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Finish Product</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php echo form_open('product/product/store', ['class' => 'form-horizontal']); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Product Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label class="col-md-3 control-label">Weight <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="weight" min="0" value="0" step="any" class="form-control"
                               required>
                    </div>
                </div>-->

                <div class="form-group">
                    <label class="col-md-3 control-label">Unit <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select class="selectpicker form-control" ng-model="unit" name="unit" data-show-subtext="true"
                                data-live-search="true" required>
                            <option value="" selected disabled> Select Unit</option>
                            <?php
                            if (!empty(config_item('unit'))) {
                                foreach (config_item('unit') as $u_value) { ?>
                                    <option value="<?php echo $u_value; ?>"><?php echo filter($u_value); ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group" ng-if="unit=='bag'">
                    <label class="col-md-3 control-label">Bag Size <span class="req">*</span></label>
                    <div class="col-md-5">
                         <input type="number" name="bag_size" min="0"
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
                                    <option value="<?php echo $row->id; ?>"><?php echo $row->category; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-3 control-label">Purchase Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="purchase_price" min="0" value="0" class="form-control" step="any"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">MRP Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="sale_price" min="0" value="0" class="form-control" step="any"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">D.P Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="dealer_price" min="0" value="0" class="form-control" step="any"
                               required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">T.P Price <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="tp_price" min="0" value="0" class="form-control" step="any"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Stock Alert <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="number" name="stock_alert" min="0" value="0" step="any" class="form-control"
                               required>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="save" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>