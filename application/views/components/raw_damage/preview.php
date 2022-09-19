<style>
    .table > tbody > tr > td {
        padding: 2px;
    }

    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }

        .panel-body {
            height: 96vh;
        }

        .table-bordered, .print-font {
            font-size: 14px !important;
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Return Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <div class="row">

                    <div class="col-xs-4 print-font">
                        <label style="margin-bottom: 10px;">
                            Voucher No : <?php echo $info->voucher_no; ?>
                        </label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Print Time : <?php echo $info->created_at; ?> - <?php echo date("h:i:s A"); ?></label>
                        <br>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th>P.I.D</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Price (TK)</th>
                        <th>Amount (TK)</th>
                    </tr>

                    <?php
                    $where    = ['sapreturn_items.voucher_no' => $info->voucher_no, 'sapreturn_items.trash' => 0, 'stock.type' => 'raw'];
                    $select   = ['sapreturn_items.*', 'stock.name', 'stock.unit'];
                    $saleInfo = get_join('sapreturn_items', 'stock', 'sapreturn_items.product_code=stock.code', $where, $select);
                    $totalQuantity = $totalAmount = 0;
                    if (!empty($saleInfo)) {
                        foreach ($saleInfo as $key => $row) {
                            $subTotal = 0;
                            $subTotal      += $row->purchase_price * $row->quantity;
                            $totalQuantity += $row->quantity;
                            $totalAmount   += $subTotal;
                            ?>
                            <tr>
                                <td width="30"><?= ($key + 1) ?></td>
                                <td> <?= $row->product_code ?> </td>
                                <td> <?= $row->name ?> </td>
                                <td> <?= $row->unit ?> </td>
                                <td class="text-right"> <?= $row->quantity ?> </td>
                                <td class="text-right"> <?= $row->purchase_price ?> </td>
                                <td class="text-right"> <?= $subTotal ?> </td>
                            </tr>
                        <?php }
                    } ?>

                    <tr>
                        <th rowspan="2" colspan="5" style="vertical-align: middle">
                            <span id="inword"></span> Taka.
                        </th>
                        <th class="text-right">Total Quantity</th>
                        <td class="text-right"> <?= get_number_format($totalQuantity) ?> </td>
                    </tr>

                    <tr>
                        <th class="text-right"> Total Amount</th>
                        <td class="text-right"><?= get_number_format($totalAmount) ?></td>
                    </tr>

                    <tr>
                        <th> Remark </th>
                        <td style="padding: 8px;" colspan="6"> <?= get_filter($info->remark) ?></td>
                    </tr>
                </table>

                <style>
                    .bi_border {
                        display: inline-block;
                        border: 1px solid #000;
                        border-radius: 10px;
                        padding: 3px 5px;
                        margin-bottom: -7px;
                    }
                </style>

                <div class="col-sm-9 col-xs-9">
                    <h4 style="margin-top: 40px; margin-left: 60px;" class="print-font">
                        ------------------------------ <br>
                        Signature of Customer
                    </h4>
                </div>
                <div class="col-sm-3 col-xs-3 text-right">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        ------------------------------ <br>
                        <?php //echo $info[0]->meta_value; ?>
                        Signature of Authorized
                    </h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#inword").html(inWorden(<?php echo $totalAmount; ?>));
    });
</script>