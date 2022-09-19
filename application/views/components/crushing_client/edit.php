<style>
    .mrgb-15{margin-bottom: 15px;}
</style>
 
<div class="container-fluid" ng-controller="EditCrushingClientCtrl" ng-cloak>
    <div class="row">
		<?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Crushing Customer</h1>
                </div>
            </div>


            <div class="panel-body">
                <?php
                $attr = array("class"=>"form-horizontal");
                echo form_open_multipart('crushing_client/crushing_client/edit?partyCode=' . $this->input->get("partyCode"), $attr);
                if($branch=="godown"){
                ?>

                <div class="col-md-7">
                    <?php } ?>

                    <div class="form-group" ng-init="partyCode = '<?php echo $info[0]->code; ?>'" ng-model="partyCode">
                        <label class="col-md-3 control-label">Code <span class="req">&nbsp;</span></label>
                        <div class="col-md-6">
                            <input type="text" name="code" class="form-control" value="<?php echo $info[0]->code; ?>" readonly>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-3 control-label">Client/Company Name <span class="req">&nbsp;</span></label>
                        <div class="col-md-6">
                            <input type="text" name="name" value="<?php echo $info[0]->name; ?>" class="form-control">
                        </div>
                    </div>

                   <div class="form-group">
                        <label class="col-md-3 control-label">Contact Person</label>
                        <div class="col-md-6">
                            <input type="text" name="contact_person" value="<?php echo $info[0]->contact_person; ?>" class="form-control">
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-md-3 control-label">Mobile Number</label>
                        <div class="col-md-6">
                            <input type="text" name="contact" class="form-control" value="<?php echo $info[0]->mobile; ?>" >
                        </div>
                    </div>




                    <div class="form-group">
                        <label class="col-md-3 control-label">Address </label>
                        <div class="col-md-6">
                            <textarea name="address" cols="15" rows="5" class="form-control"><?php echo $info[0]->address; ?></textarea>
                        </div>
                    </div>



                     <?php if($info[0]->type == "client"){ ?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Initial Balance (TK)</label>
                            <div class="col-md-3">
                                <input type="number" name="balance" class="form-control" step="any" readonly value="<?php echo abs($info[0]->initial_balance); ?>" >
                            </div>

                            <div class="col-md-3">
                                <select name="status" readonly class="form-control">
                                    <option <?php if($info[0]->initial_balance <= 0){echo "selected";} ?> value="receivable">Receivable</option>
                                    <option <?php if($info[0]->initial_balance > 0){echo "selected";} ?> value="payable">Payable</option>
                                </select>
                            </div>
                        </div>
                      <?php } ?>

                <div class="form-group">
                    <label class="col-md-3 control-label">Credit Limit</label>
                    <div class="col-md-6">
                        <input type="number" name="credit_limit" class="form-control" step="any" value="<?php echo $info[0]->credit_limit; ?>" >
                    </div>
                </div>
                </div>


                  <div class="form-group">
                      <div class="col-md-9">
                          <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
                      </div>
                  </div>

                <?php echo form_close(); ?>
                <br>
            <div class="panel-footer">&nbsp;</div>
            </div>

        </div>
    </div>
</div>
