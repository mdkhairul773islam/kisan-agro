<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }

        .block-hide {
            display: none;
        }
    }
</style>


<div class="container-fluid block-hide">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <!-- horizontal form -->
        <?php
        $attribute = array(
            'name'  => '',
            'class' => 'form-horizontal',
            'id'    => ''
        );
        echo form_open('fixed_assate/fixed_assate/update_fixed_assate/' . $fixed_assate[0]->id, $attribute);
        ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Fixed Assate</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <!-- Print banner -->
                <!-- <img class="img-responsive print-banner hide" src="<?php //echo site_url($banner_info[0]->path); ?>"> -->

                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">

                    <div class="form-group">
                        <label class="col-md-3 control-label">Date</label>
                        <div class="input-group date col-md-7" id="datetimepicker1">
                            <input type="text" name="date" class="form-control"
                                   value="<?php echo $fixed_assate[0]->date; ?>">
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Fixed Assate </label>
                        <div class="col-md-7">
                            <select name="field_fixed_assate" class="form-control">
                                <?php
                                if (!empty($fixed_assate_fields)) {
                                    foreach ($fixed_assate_fields as $key => $value) { ?>
                                        <option <?php if ($fixed_assate[0]->field_fixed_assate == $value->field_fixed_assate) {
                                            echo "selected";
                                        } ?> value="<?php echo $value->field_fixed_assate; ?>"><?php echo filter($value->field_fixed_assate); ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Description </label>
                        <div class="col-md-7">
                            <textarea name="description" class="form-control" cols="30" rows="4"
                                      placeholder="Enter Description"><?php echo $fixed_assate[0]->description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Quantity </label>
                        <div class="col-md-7">
                            <input type="number" min="0" step="1" name="quantity"
                                   value="<?php echo $fixed_assate[0]->quantity; ?>" class="form-control"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Amount </label>
                        <div class="col-md-7">
                            <input type="number" name="amount" class="form-control"
                                   value="<?php echo $fixed_assate[0]->amount; ?>" placeholder="BDT">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Spend By </label>
                        <div class="col-md-7">
                            <input type="text" name="spend_by" class="form-control"
                                   value="<?php echo $fixed_assate[0]->spend_by; ?>"
                                   placeholder="Enter maximum 100 characters">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-primary" type="submit" name="" value="Update">
                                <input class="btn btn-danger" type="reset" value="Clear">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>




