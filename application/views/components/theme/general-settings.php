<style>
    .form-horizontal .control-label {
        text-align: left;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <!-- site info -->
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>General Settings</h1>
                </div>
            </div>

            <div class="panel-body">
                <br>
                <?php echo form_open("theme/general_settings/save_site_info", ["class" => "form-horizontal"]); ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Site Name<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="site_info[site_name]" class="form-control" value="<?= (!empty(config_item('site_name')) ? config_item('site_name') : '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Address<span class="req">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="site_info[site_address]" class="form-control" value="<?= (!empty(config_item('site_address')) ? config_item('site_address') : '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Mobile<span class="req">&nbsp;</span></label>
                    <div class="col-md-4">
                        <input type="text" name="site_info[site_mobile]" class="form-control" value="<?= (!empty(config_item('site_mobile')) ? config_item('site_mobile') : '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Email<span class="req">&nbsp;</span></label>
                    <div class="col-md-4">
                        <input type="text" name="site_info[site_email]" class="form-control" value="<?= (!empty(config_item('site_email')) ? config_item('site_email') : '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" name="save_site_info" value="Save" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
                <hr>
                
                <?php echo form_open_multipart('theme/general_settings/save_site_logo', ["class" => "form-horizontal"]); ?>
                <br>
                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-4">
                        <figure>
                            <img src="<?= (!empty(config_item('site_logo')) ? base_url(config_item('site_logo')) : 'http://via.placeholder.com/360') ?>"
                                 alt="Image not found!"
                                 style="width: 65px; height: 65px; display: block; margin: 0 auto;">
                            <figcaption></figcaption>
                        </figure>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Site Logo</label>
                    <div class="col-md-4">
                        <input id="input-test" type="file" name="site_logo" class="form-control file" data-show-preview="false" data-show-upload="false" required data-show-remove="false">
                        <input type="hidden" name="old_site_logo" value="<?= (!empty(config_item('site_logo')) ? config_item('site_logo') : '') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" value="save" name="save_site_logo" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
                <hr>

                <?php echo form_open_multipart('theme/general_settings/save_fave_icon', ["class" => "form-horizontal"]); ?>
                <br>
                <div class="form-group">
                    <div class="col-md-2">&nbsp;</div>
                    <div class="col-md-4">
                        <figure>
                            <img src="<?= (!empty(config_item('fave_icon')) ? base_url(config_item('fave_icon')) : 'http://via.placeholder.com/36') ?>"
                                 alt="Image not found!" style="width: 65px; height: 65px; display: block; margin: 0 auto;">
                            <figcaption></figcaption>
                        </figure>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Fave Icon</label>
                    <div class="col-md-4">
                        <input id="input-test" type="file" name="fave_icon" class="form-control file"
                               data-show-preview="false" data-show-upload="false" required
                               data-show-remove="false">
                        <input type="hidden" name="old_fave_icon"
                               value="<?= (!empty(config_item('fave_icon')) ? config_item('fave_icon') : '') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="submit" value="save" name="faveicon" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
