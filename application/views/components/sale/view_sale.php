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
    .signature_box {
        border: 1px solid transparent;
        margin-top: 65px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .signature_box h4 {
        border-top: 2px dashed #212121;
        color: #212121;
        padding: 6px 0;
        margin: 10px 0 0;
        font-size: 17px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start -->
                <?php $this->load->view('components/print'); ?>
                
                <?php
                    if (!empty($result) && $result->sap_type == 'cash') {
                        $party_info = json_decode($result->client_info, true);
                        $name       = $result->party_code;
                        $mobile     = $party_info['mobile'];
                        $address    = $party_info['address'];
                    } else {
                        $party_info = get_row('parties', ['code' => $result->party_code], ['name', 'mobile', 'address']);
                        if (!empty($party_info)) {
                            $name    = $party_info->name;
                            $mobile  = $party_info->mobile;
                            $address = $party_info->address;
                        }else{
                            $name    = '';
                            $mobile  = '';
                            $address = '';
                        }
                    }
                    $sale_by = get_row('sapmeta', ['voucher_no' => $result->voucher_no, 'meta_key' => 'sale_by']);
                ?>
                <ul class="header_info">
                    <li><strong>Name</strong> : <?= check_null($name) ?></li>
                    <li><strong>Voucher No</strong> : <?php echo $result->voucher_no; ?></li>
                    <li><strong>Date</strong> : <?php echo $result->sap_at; ?></li>
                    <li><strong>Mobile</strong> : <?= check_null($mobile) ?></li>
                    <li><strong>Sales Man</strong> : <?= (!empty($sale_by) ? filter($sale_by->meta_value) : 'N/A') ?></li>
                    <li><strong>Print Time</strong> : <?php echo date("h:i:s A"); ?></li>
                    <li style="width: 66.66%;"><strong>Address</strong> : <?= check_null($address) ?></li>
                </ul>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width: 60px;">P.I.D</th>
                        <th>Product Name</th>
                        <th style="width: 60px;">Unit</th>
                        <th class="text-right" style="width: 60px;">Qty</th>
                        <th class="text-right" style="width: 80px;">S.Price(Tk)</th>
                        <th class="text-right" style="width: 100px;">Total(TK)</th>
                    </tr>
                    
                    <?php
                        $total_sub = 0.0;
                        $where = ['sapitems.voucher_no' => $result->voucher_no, 'materials.type' => 'finish_product'];
                        $saleInfo = get_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $where, ['sapitems.*', 'materials.code', 'materials.name']);

                        foreach ($saleInfo as $key => $row) {
                    ?>
                        <tr>
                            <td><?php echo ($key + 1); ?></td>
                            <td> <?php echo $row->code; ?></td>
                            <td><?php echo filter($row->name); ?></td>
                            <td><?php echo filter($row->unit); ?></td>
                            <td class="text-right"><?php echo $row->quantity; ?></td>
                            <td class="text-right"><?php echo $row->sale_price; ?></td>
                            <td class="text-right">
                                <?php
                                    $subtotal = $row->sale_price * $row->quantity;
                                    $total_sub += $subtotal;
                                    echo f_number($subtotal);
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    
                    <tr>
                        <th rowspan="7" colspan="4" style="vertical-align: middle;">In Word : <span class="inword"></span> Taka Only.</th>
                    </tr>
                    
                    <tr>
                        <th colspan="2" class="text-right">Sub Total</th>
                        <th class="text-right"><?php echo f_number($total_sub); ?></th>
                    </tr>

                    <tr>
                        <th colspan="2" class="text-right">Total Discount</th>
                        <th class="text-right">
                            <?php
                                $total_discount = $result->total_discount;
                                echo f_number($result->total_discount);
                            ?>
                        </th>
                    </tr>
                    <?php $transactionInfo = get_row("partytransaction", array("relation" => $result->voucher_no)); ?>
                    <tr>
                        <th colspan="2" class="text-right">Grand Total</th>
                        <th class="text-right">
                            <?php
                                $total = $total_sub - $total_discount;
                                echo f_number($total);
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-right">Previous Balance</th>
                        <th class="text-right">
                            <?php if (!empty($transactionInfo)) {
                                echo abs($transactionInfo->previous_balance) ;
                                if ($transactionInfo->previous_balance < 0) {
                                    echo " <br> [Payable]";
                                } else {
                                    echo "<br> [Receivable]";
                                }
                            } else {echo 0;} ?>
                        </th>
                    </tr>

                    <tr>
                        <th colspan="2" class="text-right">Paid</th>
                        <th class="text-right"><?php echo f_number($result->paid); ?></th>
                    </tr>

                    <?php if ($transactionInfo != null) {?>
                        <tr>
                            <th colspan="2" class="text-right">Current Balance</th>
                            <th class="text-right">
                                <?php
                                    $total = $transactionInfo->current_balance;
                                    echo f_number(abs($total));
                                    if ($total >= 0) {
                                        echo "<br> [Receivable]";
                                    } else {
                                        echo "<br> [Payable]";
                                    }
                                ?>
                            </th>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <th colspan="2" class="text-right">Due</th>
                            <th class="text-right"><?php echo f_number($total - $result->paid); ?></th>
                        </tr>
                    <?php } ?>
                </table>

                <div class="signature_box">
                    <h4>Signature of Customer</h4>
                    <h4>Signature of Authority</h4>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".inword").html(inWorden(<?php echo $total; ?>));
    });
</script>
