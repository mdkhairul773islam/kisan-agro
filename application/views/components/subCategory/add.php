<div class="container-fluid" ><!--ng-controller="addSubcategoryCtrl"  -->
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Species</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
				$attr = array('class' =>'form-horizontal');
	            echo form_open('subCategory/subCategory/addsubCategory', $attr);
				?>
                
                <div class="form-group">
                    <label class="col-md-2 control-label">Category Name  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <select name="category" class="form-control">
                            <option value="" selected disabled>-- Select --</option>
                            <?php
                            if($product_cats != null){
                            foreach ($product_cats as $key => $value) { ?>
                            <option value="<?php echo $value->slug; ?>">
                                <?php echo str_replace('_', ' ', $value->category); ?>
                            </option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Species Name <span class="req">*</span></label>

                    <div class="col-md-5">
                        <input type="text" name="subcategory" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" value="Save" name="catetory_submit" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
