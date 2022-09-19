<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata("confirmation"); ?>
        <div class="panel panel-default none">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Transaction</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php $attr = array ('class' => 'form-horizontal');
                echo form_open('', $attr); ?>

                <div class="form-group" ng-init="type='Person'">
                    <label class="col-md-2 control-label">Type <span class="req">*</span></label>
                    <div class="col-md-5">
                        <label class="radio-inline">
                            <input type="radio" name="type" ng-model="type" value="Bank" required>
                            <strong>Bank</strong>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="type" ng-model="type" value="Person"  required>
                            <strong>Person</strong>
                        </label>
                    </div>
                </div>

                <!-- Bank Info -->
                <div ng-if="type == 'Bank'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Account Number <span class="req">*</span></label>
                        <div class="col-md-5">
                           <select class="form-control" name="search[loan_id]">
                                <option value="" selected>Select</option>
                                <?php foreach ($banks as $bank) { ?>
                                <option value="<?php echo $bank->id; ?>"><?php echo $bank->account_no; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>

                <!-- Person -->
                <div ng-if="type == 'Person'">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Person Name <span class="req">*</span></label>
                        <div class="col-md-5">
                            <select class="form-control" name="search[loan_id]">
                                <option value="" selected>Select</option>
                                <?php foreach ($persons as $person) { ?>
                                <option value="<?php echo $person->id; ?>"><?php echo $person->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Show" name="show" class="btn btn-primary pull-right">
                    </div>
                </div>



                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if (!empty($transaction)) { ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <?php $this->load->view('components/print'); ?>
                
                <h3 class="text-center hide" style="margin-top: 0px;">All Loan Information</h3>

                <table class="table table-bordered">
                    <tr>
                        <th width="25%">Bank / Person Name</th>
                        <td><?php echo filter($info[0]->name); ?></td>
                        <th>Loan Type</th>
                        <td><?php echo $info[0]->loan_type; ?></td>
                    </tr>

                    <tr>
                        <th>Contact Info</th>
                        <td><?php echo $info[0]->contact_info; ?></td>
                        <th>Type</th>
                        <td><?php echo $info[0]->type; ?></td>
                    </tr>

                    <tr>
                        
                        <th>Loan By</th>
                        <td><?php echo $info[0]->loan_by; ?></td>
                        <th>Amount</th>
                        <td><?php echo $info[0]->amount; ?></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td></td>
                        <th>Status</th>
                        <td><?php echo $info[0]->status; ?></td>
                    </tr>
                </table>

                <table class="table table-bordered">
                    <tr>
                        <th> SL </th>
                        <th> Date </th>
                        <th> Amount </th>
                        <th> Trx Type </th>
                    </tr>
                   <?php
                   $total = array();
                   foreach($transaction as $key => $row){
                   ?>
                   <tr>
                       <td> <?php echo $key + 1; ?> </td>
                       <td> <?php echo $row->date; ?> </td>
                       <td> <?php echo $row->amount; ?> </td>
                       <td> <?php echo $row->trx_type; ?> </td>
                   </tr>
                   <?php } ?>

                    <tr>
                        <th class="text-right" colspan="2">Total</th>
                        <th><?php echo f_number($info[0]->current_balance); ?></th>
                        <th><?php echo $info[0]->current_status; ?></th>
                    </tr>
                </table>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    <?php } ?>
    </div>
</div>

<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>