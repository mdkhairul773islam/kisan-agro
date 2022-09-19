<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Sr</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array(
                    'class' =>'form-horizontal'
                );
	            echo form_open('sr/sr/addsr',$attr); ?>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Name <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="name" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Mobile <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="mobile" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Address <span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="address" placeholder="" class="form-control" required>
                    </div>
                </div>

                <?php /*
                <div class="form-group">
                    <label class="col-md-3 control-label"> Zone<span class="req">*</span></label>
                    <div class="col-md-4">
                        <?php 
                            $zone = get_result("zone", [], ['zone'], '', 'zone', 'ASC');
                        ?>
                        <select name="area" class="form-control" required>
                            <option value="" selected disabled>Select Zone</option>
                            <?php 
                                if(!empty($zone)){
                                    foreach($zone as $row){
                            ?>
                            <option value="<?= $row->zone?>"><?= filter($row->zone)?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                */?>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

