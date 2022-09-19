<div class="container-fluid">
    <div class="row">
	<?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Bank</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
	                $attr=array('class'=>'form-horizontal');
	                echo form_open('bank/bankInfo/store_bank', $attr);
                ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Bank Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <input type="text" name="bank_name" class="form-control" required>
                        </div>

                        <div class="col-md-2">
                            <input type="submit" value="Save" name="add_bank" class="btn btn-primary">
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>


            <?php if (!empty($allBank)){ ?>
            <hr style="margin-top: 0">
            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30">SL</th>
                        <th>Bank Name</th>
                        <th width="40" class="none">Action</th>
                    </tr>
                    
                    <?php
                    foreach ($allBank as $_key => $item){
                    ?>
                    <tr>
                        <td><?= ++$_key ?></td>
                        <td><?= filter($item->bank_name) ?></td>
                        <td>
                            <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this data....?')" href="<?php echo site_url("bank/bankInfo/delete_back/$item->id"); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <?php } ?>
            
            

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
