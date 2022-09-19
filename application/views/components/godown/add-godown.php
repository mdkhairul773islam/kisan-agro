<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>শো-রুম যোগ করুন</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('', $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">স্থান <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="place" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">সুপারভাইজার <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="supervisor" class="form-control" repuired>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">যোগাযোগ নম্বর <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="contact_number" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">ঠিকানা  <span class="req">*</span></label>
                    <div class="col-md-5">
                        <textarea name="address" rows="4" class="form-control" required></textarea>
                    </div>
                </div> 

                <div class="col-md-7">
                    <div class="btn-group pull-right">
                        <input type="submit" name="save" value="সেইভ" class="btn btn-primary">
                    </div>
                </div>
                    
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>

        </div>
    </div>
</div>
 