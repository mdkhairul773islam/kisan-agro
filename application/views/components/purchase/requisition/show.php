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
        margin-top: 10px;
        font-weight: bold;
        display: inline-block;
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
        <?php echo $confirmation; ?>
        <div class="panel panel-default ">

            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Requisition Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Indent/Requisition</h4>
                <div class="row">
                    <div class="col-xs-6">
                        <p><strong>Indent No:</strong> <?php echo $voucherInfo->voucher_no; ?></p>
                    </div>
                    <div class="col-xs-6">
                        <p class="text-right"><strong>Date:</strong> <?php echo $voucherInfo->created; ?></p>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="view">
                        <th rowspan="2" width="45px">SL</th>
                        <th rowspan="2" >Name of Item</th>
                        <th rowspan="2" >Specification</th>
                        <th rowspan="2" >Unit</th>
                        <th rowspan="2" >Current Stock</th>
                        <th rowspan="2" >Request Qty.</th>
                        <th colspan="3" class="text-center">Last Purchase Info</th>
                    </tr>
                    <tr class="view">
                        <th>Date</th>
                        <th>Price</th>
                        <th>Vendor</th>
                    </tr>

                    <?php
                    $totalAmount = 0;
                    foreach ($itemList as $key => $row) {
                        $amount = $row->quantity * $row->purchase_price;
                        $totalAmount += $amount;
                        
                        $lastPurchaseInfo = custom_query("SELECT id, sap_at, voucher_no, purchase_price FROM `sapitems` WHERE id='$row->previous_item_id'", true);
                
                        $previousDate = $previousPrice = $previousVendor = '';
                        if(!empty($lastPurchaseInfo)){
                            $previousDate   = $lastPurchaseInfo->sap_at;
                            $previousPrice  = $lastPurchaseInfo->purchase_price;
                            $previousVendor = custom_query("SELECT name FROM `parties` WHERE code IN (SELECT party_code FROM `saprecords` WHERE voucher_no='$lastPurchaseInfo->voucher_no' AND trash=0)", true)->name;
                        }else{
                            $previousPrice = $row->purchase_price;
                        }
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td class="view"><?php echo $row->name; ?></td>
                            <td class="view"><?php echo $row->specification; ?></td>
                            <td class="view"><?php echo $row->unit; ?></td>
                            <td class="view"><?php echo round($row->current_stock, 2); ?></td>
                            <td class="view"><?php echo round($row->quantity, 2); ?></td>
                            <td class="view"><?php echo $previousDate; ?></td>
                            <td class="view"><?php echo $previousPrice; ?></td>
                            <td class="view"><?php echo $previousVendor; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                
                <?php if(!empty($voucherInfo->remarks)) { ?>
                <p><strong>Remark:</strong> <?php echo $voucherInfo->remarks; ?></p>
                <?php } ?>
                
                <div class="signature_box">
                    <div class="text-center">
                        <span><?php echo get_name('users', 'name', ['id' => $voucherInfo->prepared_by]); ?></span>
                        <h4>Prepared By</h4>
                    </div>
                    
                    <div class="text-center">
                        <span><?php echo get_name('users', 'name', ['id' => $voucherInfo->checked_by]); ?></span>
                        <h4>Verified By</h4>
                    </div>
                    
                    <div class="text-center">
                        <span><?php echo get_name('users', 'name', ['id' => $voucherInfo->authorised_by]); ?></span>
                        <h4>Authorised By</h4>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>