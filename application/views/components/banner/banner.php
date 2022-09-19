
<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Banner</h1>
                </div>
            </div>

            <div class="panel-body">

                <div class="col-md-12">
                   <?php if($banner_info!=null) {echo'<img width="100%" src="'.base_url($banner_info[0]->path).'" />';}?>
                </div>
                <h1>&nbsp;</h1>

               <?php
                   $attribute=array(
                        "name"=>"",
                        "class"=>"form-horizontal"
                    );
                    echo form_open_multipart("banner/banner",$attribute);
					
                ?>
                <div class="col-md-12 row">
				
                    <label class="col-md-3 control-label">Upload Banner<span class="req">*</span></label>

                    <div class="col-md-5">
                        <input id="input-test" type="file" name="banner_image" class="form-control file" data-show-preview="false" data-show-upload="false" data-show-remove="false" required>
                    </div>

                    <input type="hidden" name="banner_id" value="<?php if($banner_info!=null) { echo $banner_info[0]->id;}?>">

                    <div class="btn-group">
                        <input type="submit" name="banner_save" value="Save" class="btn btn-primary">
                    </div>
                </div> 
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
