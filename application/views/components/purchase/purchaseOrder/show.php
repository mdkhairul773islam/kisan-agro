<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,900" rel="stylesheet">
<style>
    .wid-100 {width: 100px;}
    .custom-table > tbody > tr > th,
    .custom-table > tbody > tr > td {
        border: none;
        line-height: 18px;
        padding: 4px !important;
    }
    .custom-table > tbody > tr > th {
        width: 140px;
    }
    .view {
        font-family: 'Raleway', sans-serif;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $confirmation; ?>
        <div class="panel panel-default ">

            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Order Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Order Details</h4>
                <div class="row">
                    <div class="col-xs-6">
                        <table class="table custom-table view">
                            <tr>
                                <th>Supplier Name :</th>
                                <td><?php echo filter($voucherInfo->name); ?></td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td><?php echo filter($voucherInfo->address); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile :</th>
                                <td><?php echo filter($voucherInfo->mobile); ?></td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-xs-6">
                        <table class="table custom-table">
                            <tr>
                                <th width="200">Date :</th>
                                <td><?php echo $voucherInfo->created; ?></td>
                            </tr>
                            <tr>
                                <th>Order No :</th>
                                <td><?php echo $voucherInfo->voucher_no; ?></td>
                            </tr>
                            <tr>
                                <th>PR No :</th>
                                <td><?php echo $voucherInfo->pr_no; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="view">
                        <th>Sl</th>
                        <th>Raw Materials</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>

                    <?php
                    $totalAmount = 0;
                    foreach ($itemList as $key => $row) {
                        $amount = $row->quantity * $row->purchase_price;
                        $totalAmount += $amount;
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td class="view"><?php echo filter($row->name); ?></td>
                            <td class="wid-100 text-right"><?php echo $row->quantity; ?></td>
                            <td class="wid-100 text-right"><?php echo $row->purchase_price; ?></td>
                            <td class="wid-100 text-right"><?php echo $amount; ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <div class="col-xs-offset-8 col-xs-4">
                    <div class="row">
                        <table class="table custom-table text-right">
                            <tr>
                                <th class="view" width="200">Total Qty. :</th>
                                <td><b><?php echo f_number($voucherInfo->total_quantity); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view" width="200">Total Bill :</th>
                                <td><b><?php echo f_number($voucherInfo->total_bill); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p><strong>Remark:</strong> <?php echo $voucherInfo->remarks; ?></p>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>