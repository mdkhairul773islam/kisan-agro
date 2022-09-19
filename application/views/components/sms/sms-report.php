<div class="container-fluid">
    <div class="row">
        
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1>SMS Report</h1>
                </div>
            </div>

            <div class="panel-body">

                <blockquote class="form-head">
                <?php
                	$sent_sms=0;
                	foreach($all_sms as $sms){
                		$sent_sms+=$sms->total_messages;
                	}

                ?>
                    <p style="font-size: 16px;"> Total SMS: <strong><?php echo $total_sms; ?></strong> &nbsp; Total Send SMS: <strong><?php echo $sent_sms; ?></strong> &nbsp; Remaining SMS: <strong><?php echo $total_sms-$sent_sms; ?></strong></p>
                </blockquote>

                <?php
                $attr=array('class'=>'form-horizontal');
                echo form_open('',$attr); ?>

                    <div class="form-group">
                        <label class="col-md-2 control-label">From</label>
                        <div class="input-group date col-md-5" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">To</label>
                        <div class="input-group date col-md-5" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>


                   <div class="form-group">
                        <div class="col-md-7">
                            <input type="submit" value="Show" name="show_between" class="btn btn-primary pull-right">
                        </div>
                   </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>




        <?php if(!empty($results)){?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>All Records</h1>
                </div>
            </div>

            <div class="panek-body" style="padding: 10px;">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Date</th>
                        <th>Mobile Number</th>
                        <th>Message</th>
                        <th style="width: 40px;">Action</th>
                    </tr>
		            <?php foreach($results as $key=> $row){?>
                    <tr class="<?= ($row->delivery_report == 0 ? 'bg-danger' : '') ?>">
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $row->delivery_date; ?></td>
                        <td><?php echo $row->mobile; ?></td>
                        <td><?php echo $row->message; ?></td>
                        <td>
                            <?php if($row->delivery_report == 0){ ?>
                                <a class="btn btn-success" title="Send SMS" href="<?php echo site_url('sms/sendSms/resendSMS/' . $row->id); ?>">
                                    Send SMS
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                 <?php } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>

<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
