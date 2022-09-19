<div class="container-fluid">
    <div class="row">
     <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                   <h1>Edit Sr</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php 
                $attr=array('class'=>"form-horizontal"); 
                echo form_open(site_url('sr/sr/edit/'.$id), $attr);?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Name <span class="req">&nbsp;*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="name"  required value="<?php echo filter($sr[0]->name); ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Mobile <span class="req">&nbsp;*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="mobile"  required value="<?php echo filter($sr[0]->mobile); ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Address <span class="req">&nbsp;*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="address"  required value="<?php echo filter($sr[0]->address); ?>" class="form-control">
                    </div>
                </div>

                <?/*
                <div class="form-group">
                    <label class="col-md-3 control-label">Zone</label>
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
                            <option <?= $sr[0]->area==$row->zone ? "selected" : "" ?> value="<?= $row->zone?>"><?= filter($row->zone)?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                */?>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Update" class="btn btn-primary pull-right">
                    </div>
                </div>
               <?php  echo form_close();?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

