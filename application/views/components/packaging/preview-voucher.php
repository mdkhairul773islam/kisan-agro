<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600,700,900" rel="stylesheet">
<style>
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
    }

    .wid-100 {
        width: 100px;
    }

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
                    <h1 class="pull-left">Voucher Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Packaging Voucher</h4>

                <div class="row">
                    <div class="col-xs-6">
                        <table class="table custom-table view">
                            <tr>
                                <th>Supplier Name :</th>
                                <td><?php echo filter($purchase_record[0]->name); ?></td>
                            </tr>
                            <tr>
                                <th>Address :</th>
                                <td><?php echo filter($purchase_record[0]->address); ?></td>
                            </tr>
                            <tr>
                                <th>Mobile :</th>
                                <td><?php echo filter($purchase_record[0]->mobile); ?></td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-xs-6">
                        <table class="table custom-table">
                            <tr>
                                <th width="200">Date :</th>
                                <td><?php echo $purchase_record[0]->sap_at; ?></td>
                            </tr>
                            <tr>
                                <th>Voucher No :</th>
                                <td><?php echo $purchase_record[0]->voucher_no; ?></td>
                            </tr>
                            <tr>

                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr class="view">
                        <th>Sl</th>
                        <th>Raw Materials</th>
                        <th>Quantity</th>
                        <th>Price (TK)</th>
                        <th width="120">Discount (TK)</th>
                        <th>Total (TK)</th>
                    </tr>

                    <?php
                    $total_discount = array();
                    foreach ($purchase_info as $key => $val) { ?>
                        <tr>
                            <td style="width: 50px;"><?php echo($key + 1); ?></td>
                            <td class="view"><?php echo filter($val->name); ?></td>
                            <td class="wid-100"><?php echo $val->quantity; ?></td>
                            <td class="wid-100"><?php echo $val->purchase_price; ?></td>
                            <td class="wid-100"><?php echo $total_discount[] = $val->discount; ?></td>
                            <td class="wid-100"><?php echo $val->purchase_price * $val->quantity; ?></td>
                        </tr>
                    <?php } ?>
                </table>

                <div class="col-xs-offset-8 col-xs-4">
                    <div class="row">
                        <table class="table custom-table text-right">
                            <tr>
                                <th class="view" width="200">Total Amount :</th>
                                <td><b><?php echo f_number($purchase_record[0]->total_bill); ?></b></td>
                            </tr>
                            <tr>
                                <th class="view">Total Discount :</th>
                                <td><b><?php echo f_number(array_sum($total_discount)); ?></b></td>
                            </tr>

                            <tr>
                                <th class="view">Transport Cost :</th>
                                <td><b><?php echo f_number($purchase_record[0]->transport_cost); ?></b></td>
                            </tr>

                            <tr>
                                <th class="view">Grand Total:</th>
                                <?php $grandTotal = $purchase_record[0]->total_bill + $purchase_record[0]->transport_cost - array_sum($total_discount); ?>
                                <td><b><?php echo f_number($grandTotal); ?></b></td>
                            </tr>

                            <tr>
                                <th class="view">Paid :</th>
                                <td><b><?php echo $purchase_record[0]->paid; ?></b></td>
                            </tr>

                            <tr>
                                <th class="view">Due :</th>
                                <td><b><?php echo f_number($grandTotal - $purchase_record[0]->paid); ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p><strong>Remark: </strong> <?php echo $purchase_record[0]->comment; ?></p>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
