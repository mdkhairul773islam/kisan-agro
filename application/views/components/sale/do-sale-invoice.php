<style>
    .invoice {
        text-align: center;
        margin-bottom: 0;
    }
    .invoice h4 {
        border: 1px solid #212121;
        border-radius: 25px;
        padding: 4px 25px;
        font-size: 14px;
        display: inline-block;
    }
    .header_info {
        margin-bottom: 15px;
        flex-wrap: wrap;
        display: flex;
        width: 100%;
    }
    .header_info li {
        min-width: 220px;
        width: 33.33%;
        font-size: 15px;
        margin: 5px 0;
    }
    .header_info li strong {
        display: inline-block;
        min-width: 50px;
    }
    .signature_box {
        border: 1px solid transparent;
        margin-top: 50px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .signature_box h4 {
        border-top: 2px dashed #212121;
        color: #212121;
        padding: 6px 0;
        margin: 0;
        font-size: 17px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Do Sale Invoice</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start Here -->
                <?php $this->load->view('components/print'); ?>
                <div class="invoice hide">
                    <h4 class="text-center">Do Sale Invoice</h4>
                </div>
                <ul class="header_info">
                    <li><strong>Customer Name</strong> : <?= v_check($result[0]->name) ?></li>
                    <li><strong>Phone No</strong> : <?= v_check($result[0]->mobile) ?></li>
                    <li><strong>DO No</strong> : <?= v_check($result[0]->voucher_no) ?></li>
                    <li><strong>DO Date</strong> : <?= v_check($result[0]->sap_at) ?></li>
                    <li style="width: 66.66%;"><strong>Address</strong> : <?= v_check($result[0]->address) ?></li>
                </ul>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Unit</th>
                        <th style="width: 76px; text-align: right">Bag Size</th>
                        <th style="width: 88px; text-align: right">No. of Bag</th>
                        <th style="width: 70px; text-align: right">Quantity</th>
                        <th style="width: 90px; text-align: right">Total(Tk)</th>
                    </tr>
                    <?php 
                        $total_no_of_bag = $total_order_quantity = $total_amount = 0;
                        if(!empty($result)){
                            foreach($result as $key => $row){
                                $total_no_of_bag += $row->no_of_bag;
                                $total_order_quantity += $row->order_quantity;
                                $total_amount += $row->order_quantity*$row->sale_price;
                        ?>
                    <tr>
                        <td><?= ++$key ?></td>
                        <td><?= $row->voucher_no ?></td>
                        <td>
                            <?php 
                                $product_details = get_row("stock", ['code'=>$row->product_code], ['name', 'batch_no', 'specification']); 
                                echo $description = filter($product_details->name)." Batch No: ".$product_details->batch_no.", Specification: ".$product_details->specification;
                            ?>
                        </td>
                        <td><?= filter($row->unit) ?></td>
                        <td class="text-right"><?= $row->bag_size ?></td>
                        <td class="text-right"><?= $row->no_of_bag ?></td>
                        <td class="text-right"><?= $row->order_quantity?></td>
                        <td class="text-right"><?= $row->order_quantity*$row->sale_price ?></td>
                    </tr>
                    <?php }} ?>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th class="text-right"><?= number_format($total_no_of_bag); ?></th>
                        <th class="text-right"><?= number_format($total_order_quantity); ?></th>
                        <th class="text-right"><?= number_format($total_amount); ?></th>
                    </tr>
                    <tr class="none">
                        <th rowspan="6" colspan="5" style="vertical-align: middle;"></th>
                    </tr>
                    <tr class="none">
                        <th colspan="2" class="text-right">Previous Balance</th>
                        <th class="text-right"><?= abs($previous_balance)?> <small><?= $previous_status ?></small></th>
                    </tr>
                    <tr class="none">
                        <th colspan="2" class="text-right">Paid</th>
                        <th class="text-right"><?= $result[0]->paid ?></th>
                    </tr>
                    <tr class="none">
                        <th colspan="2" class="text-right">Current Balance</th>
                        <th class="text-right"><?= abs($balance)?> <small><?= $status ?></small></th>
                    </tr>
                </table>
                <p><strong>In Word</strong> : <span style="text-decoration: underline;" id="inword"></span> Taka Only.</p>
                
                <div class="signature_box">
                    <h4>Received by</h4>
                    <h4>Prepared by</h4>
                    <h4>Checked by</h4>
                    <h4>Authorised by</h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function (){$("#inword").html(inWorden(<?php echo abs($result[0]->total_bill); ?>));});
</script>