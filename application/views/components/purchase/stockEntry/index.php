<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Stock Entry</h1>
                </div>
            </div>
            
            <div class="panel-body">
                <?php echo form_open(); ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Supplier</option>
                                <?php if (!empty($partyList)) {
                                    foreach ($partyList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]" placeholder="Voucher No" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
        
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide" style="margin-top: 0px;">All Order</h4>
                
                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <th>Order No</th>
                        <th>PR NO</th>
                        <th>Supplier Name</th>
                        <th>Mobile</th>
                        <th>Total Bill (TK)</th>
                        <th>Paid (TK)</th>
                        <th>Due (TK)</th>
                        <th class="none text-right">Action</th>
                    </tr>
                    
                    <?php
                    $totalBill = $totalPaid = $totalDue = 0;
                    foreach ($results as $key => $row) {
                        
                        $due = $row->total_bill - $row->paid;
                        
                        $totalBill += $row->total_bill;
                        $totalPaid += $row->paid;
                        $totalDue  += $due;
                        ?>
                        <tr>
                            <td style="width: 40px;"><?php echo $key + 1; ?></td>
                            <td><?php echo $row->sap_at; ?></td>
                            <td><?php echo $row->voucher_no; ?></td>
                            <td><?php echo $row->order_no; ?></td>
                            <td><?php echo $row->pr_no; ?></td>
                            <td><?php echo filter($row->name); ?></td>
                            <td><?php echo $row->mobile; ?></td>
                            <td><?php echo f_number($row->total_bill); ?></td>
                            <td><?php echo f_number($row->paid); ?></td>
                            <td><?php echo f_number($due); ?></td>
                            <td class="none text-right" style="width: 125px;">
                                <a title="View" class="btn btn-primary" href="<?php echo site_url('purchase/order_purchase/show?vno=' . $row->voucher_no); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Data?');" href="<?php echo site_url('purchase/order_purchase/delete?vno=' . $row->voucher_no); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="7" class="text-right">Total</th>
                        <th><?php echo f_number($totalBill); ?> Tk</th>
                        <th><?php echo f_number($totalPaid); ?> Tk</th>
                        <th><?php echo f_number($totalDue); ?> Tk</th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>