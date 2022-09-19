<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Transaction</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php echo form_open(); ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>Select Supplier</option>
                                <?php
                                if (!empty($info)) {
                                    foreach ($info as $row) { ?>
                                        <option value="<?php echo $row->code; ?>"><?php echo $row->name; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
 
    
        <?php if (!empty($transactionInfo)) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                        onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
    
    
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
    
                <h4 class="text-center hide" style="margin-top: 0px;">All Supplier Transaction</h4>
    
    
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Date</th>
                        <th>S.ID</th>
                        <th>Name</th>
                        <th>Transaction By</th>
                        <th>Payment</th>
                        <th>Commission</th>
                        <th>Received</th>
                        <th>Comment</th>
                        <th class="none" width="160px">Action</th>
                    </tr>
    
    
                    <?php
                    $totalPaid = $totalCommission = $totalReceived = 0;
                    foreach ($transactionInfo as $key => $row) {
    
                        $totalPaid += $row->debit;
                        $totalCommission += $row->commission;
                        $totalReceived += $row->credit;
                        ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $row->transaction_at; ?></td>
                            <td><?php echo $row->party_code; ?></td>
                            <td><?php echo filter($row->name); ?></td>
                            <td><?php echo filter($row->transaction_via); ?></td>
                            <td class="text-right"><?php echo f_number($row->debit); ?></td>
                            <td class="text-right"><?php echo f_number($row->commission); ?></td>
                            <td class="text-right"><?php echo f_number($row->credit); ?></td>
                            <td><?php echo $row->comment; ?></td>
                            <td class="none">
                                <a class="btn btn-primary" href="<?php echo site_url('supplier/all_transaction/view/' . $row->id); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
    
                                <a class="btn btn-warning" title="Edit"
                                    href="<?php echo site_url('supplier/transaction/edit_transaction/' . $row->id); ?>"><i
                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    
                                <?php if ($row->transaction_at != config_item("menual_date") && $this->session->userdata['privilege'] !== "user") { ?>
                                    <a href="<?php echo site_url('supplier/all_transaction/delete_transaction/' . $row->id); ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Are you sure to delete this ?')"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th class="text-right"><?php echo f_number($totalPaid); ?> Tk</th>
                        <th class="text-right"><?php echo f_number($totalCommission); ?> Tk</th>
                        <th class="text-right"><?php echo f_number($totalReceived); ?> Tk</th>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>