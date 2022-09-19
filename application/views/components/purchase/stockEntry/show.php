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
        margin-top: 0;
        display: inline-block;
    }
    .table > tbody > tr > td {padding: 2px 6px}
    @media print {
        .table > tbody > tr > th,
        .table > tbody > tr > td {padding: 2px 6px;}
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
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $confirmation; ?>
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <div class="invoice hide">
                    <h4>Purchase Voucher</h4>
                </div>
                
                <ul class="header_info">
                    <li><strong>Supplier Name</strong> : <?php echo filter($voucherInfo->name); ?></li>
                    <li><strong>Voucher No</strong> : <?php echo $voucherInfo->voucher_no; ?></li>
                    <li><strong>Order No</strong> : <?php echo $voucherInfo->order_no; ?></li>
                    <li><strong>Date</strong> : <?php echo $voucherInfo->sap_at; ?></li>
                    <li><strong>Mobile</strong> : <?php echo filter($voucherInfo->mobile); ?></li>
                    <li><strong>PR NO</strong> : <?php echo $voucherInfo->pr_no; ?></li>
                    <li style="width: 66.66%;"><strong>Address</strong> : <?php echo filter($voucherInfo->address); ?></li>
                </ul>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 45px;">SL</th>
                        <th>Raw Materials</th>
                        <th>Unit</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right" style="width: 160px;">Remaining quantity</th>
                    </tr>
                    <?php
                    $totalAmount = 0;
                    foreach ($itemList as $key => $row) {
                        $amount = $row->quantity * $row->purchase_price;
                        $totalAmount += $amount;
                        ?>
                        <tr>
                            <td><?php echo($key + 1); ?></td>
                            <td><?php echo filter($row->name); ?></td>
                            <td><?php echo filter($row->unit); ?></td>
                            <td class="text-right"><?php echo $row->quantity; ?></td>
                            <td class="text-right"><?php echo $row->purchase_price; ?></td>
                            <td class="text-right"><?php echo $amount; ?></td>
                            <td class="text-right"><?php echo $row->remaining_quantity; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th rowspan="8" colspan="4"></th>
                        <th colspan="2" class="text-right">Total Amount</th>
                        <th class="text-right"><?php echo f_number($totalAmount); ?></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Transport Cost</th>
                        <th class="text-right"><?php echo f_number($voucherInfo->transport_cost); ?></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Grand Total</th>
                        <th class="text-right"><?php echo f_number($voucherInfo->total_bill); ?></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Paid</th>
                        <th class="text-right"><?php echo $voucherInfo->paid; ?></th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Due</th>
                        <th class="text-right"><?php echo f_number($voucherInfo->due); ?></th>
                    </tr>
                </table>
                
                <p><strong>Remark:</strong> <?php echo $voucherInfo->comment; ?></p>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
