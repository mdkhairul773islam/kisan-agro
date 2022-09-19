<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <?php echo $this->session->flashdata("confirmation"); ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>All CC Loan </h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                    $attr = array('class' => 'form-horizontal');
                    echo form_open('cc_loan/cc_loan/allloan');
                ?>
                <div class="form-group">
                    <div class="col-md-3">
                        <select name="acc_no" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>Select Account Number</option>
                            <?php $acc_no = $this->action->read('cc_loan');  ?>
                            <?php foreach($acc_no as $value){ ?>
                                <option value="<?php echo $value->acc_no;  ?>"> <?php echo $value->bank_name.'-'.$value->acc_no;  ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-1">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start -->
                <?php $this->load->view('components/print'); ?>
                
                <div class="col-md-12 text-center hide">
                    <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">CC Transaction</h3>
                </div>
                
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Bank Name</th>
                        <th>Accont No</th>
                        <th>Loan Date</th>
                        <th>Interest</th>
                        <th>Balance</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $total_blnc = 0;
                        foreach ($rows as $key => $row){
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td><?php echo $row->bank_name; ?></td>
                        <td><?php echo $account_no = $row->acc_no; ?></td>
                        <td><?php echo $loan_date = $row->loan_rcv_date; ?></td>
                        <td><?php echo $row->percentage.'%'; ?></td>
                        <td>
                            <?php 
                                $acc_trx = get_acc_info($row->acc_no,'');
                                echo number_format($acc_trx['current_balance'],2);
                            ?>
                        </td>
                        <td>
                            <a title="Edit" class="btn btn-warning" href="<?php echo site_url('cc_loan/cc_loan/loan_edit/'.$row->id); ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <a onclick="return confirm('Are you sure want to delete this Account Information?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('cc_loan/cc_loan/delete/'.$row->acc_no); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $total_blnc += $acc_trx['current_balance']; }?>
                    <tr>
                        <td colspan="7" class="text-right"> <b>Total</b> &nbsp;&nbsp;</td>
                        <td><b><?php echo number_format($total_blnc,2); ?></b></td>
                        <td>&nbsp;</td>
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