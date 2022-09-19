<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<div class="container-fluid none">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
    <!-- horizontal form -->
    <?php
        $attribute = array(
            'id' => '',
            'name' => '',
            'class' => 'form-horizontal',
        );
        echo form_open('cost/cost/update/'.$info->id, $attribute);
    ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Edit Expenditure</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>
                <div class="col-md-9">                                
                    <div class="form-group">
                        <label class="col-md-3 control-label">Date<span class="req">*</span></label>
                        <div class="input-group date col-md-7" id="datetimepicker1">
                            <input type="text" name="date" class="form-control" value="<?php echo $info->date; ?>" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Category </label>
                        <div class="col-md-7">
                            <select name="cost_category_id" id="categoryList" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected>Select Category</option>
                                <?php foreach($costCategoryList as $row){ ?>
                                <option value="<?php echo $row->id;  ?>" <?php echo ($info->cost_category_id == $row->id ? 'selected' : ''); ?>><?php echo $row->cost_category;  ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Field of Expenditure </label>
                        <div class="col-md-7">
                            <select name="cost_field_id" id="costFieldList" class="form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected>Select Field</option>
                            </select>  
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Description </label>
                        <div class="col-md-7">
                           <textarea name="description" class="form-control" cols="30" rows="4" placeholder="Enter Description"><?php echo $info->description; ?></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Amount </label>
                        <div class="col-md-7">
                            <input type="number" name="amount" value="<?php echo $info->amount; ?>" class="form-control" placeholder="BDT">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Spend By </label>
                        <div class="col-md-7">
                            <input type="text" name="spend_by" value="<?php echo $info->spend_by; ?>" class="form-control" placeholder="Enter maximum 100 characters">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-primary" type="submit" name="update" value="Update">
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

<script>
    function getCostFieldList(){
        var costCategoryId = $('#categoryList').val();
        $('#costFieldList').empty();
        $.post("<?= site_url('cost/field/ajaxFieldList') ?>", {id: '<?= $info->cost_field_id ?>',cost_category_id: costCategoryId}).success(function(response){
            $('#costFieldList').append(response);
            $('#costFieldList').selectpicker('refresh'); 
        });
    }
    getCostFieldList();
    
    $('#categoryList').on('change', function(){
        getCostFieldList();
    });
</script>
