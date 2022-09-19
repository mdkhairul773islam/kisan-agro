<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Supplier Tarnsaction Details</h4>
                <div class="row">
                	<div class="col-xs-8 print-font">
                		<label style="margin-bottom: 10px;">
                            Voucher No : <?php echo get_code($info->id, 6); ?>
                            
                        </label> <br>

                        <label style="margin-bottom: 10px;">
                            Name: <?php  echo $info->name; ?>
                        </label>
                     </div>

                	<div class="col-xs-4 print-font">
                		<label>Date : <?php echo $info->transaction_at; ?></label> <br>
                		<label>Print Time : <?php echo date("h:i:s A"); ?></label>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th><?php echo filter($transactionType)?></th>
                        <th>Commission</th>
                        <th><?php echo ($balance < 0) ? 'Total Due' : 'Total Balance'; ?></th>
                        <th>Transaction Type</th>
                    </tr>
                    <tr>
                        <td class="text-right"><?php echo $amount; ?></td>
                        <td class="text-right"><?php echo $info->commission; ?></td>
                        <td class="text-right"><?php echo abs($balance); ?></td>
                        <td><?php echo ucfirst($info->transaction_via); ?></td>
                    </tr>

                    <tr>
                        <td colspan="4">Remark: <?php echo $info->comment; ?></td>
                    </tr>

                    <tr>
                        <td colspan="4" colspan="4">In Word : <strong id="inword"></strong> Taka Only.</td>
                    </tr>              
                </table>

                <div class="pull-right hide">
                    <h4 style="margin-top: 50px;" class="text-center print-font">
                    -------------------------------- <br>
                    Signature of authority
                    </h4>
                </div>
              </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#inword").html(inWorden(<?php echo ($amount); ?>));
    });
</script>
