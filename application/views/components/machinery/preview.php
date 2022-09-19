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
                    <h1 class="pull-left">Preview Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Used Machinery Voucher</h4>

                <div class="row">
                    <div class="col-xs-4 print-font">
                        <label>Date : <?= (!empty($info) ? $info[0]->created_at : 'N/A'); ?></label> <br>
                        <label>Voucher No : <?= (!empty($info) ? $info[0]->voucher_no : 'N/A'); ?></label> <br>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="30">SL</th>
                        <th width="350">Product Name</th>
                        <th width="150">Unit</th>
                        <th width="150">Quantity</th>
                        <th width="150">Purchase Price (Tk)</th>
                        <th width="150">Amount (TK)</th>
                    </tr>

                    <?php
                    $total_sub      = 0;
                    $total_quantity = [];
                    if (!empty($info)) {
                        foreach ($info as $key => $row) {
                            ?>
                            <tr>
                                <td> <?php echo ++$key; ?></td>
                                <td> <?php echo filter($row->name); ?> </td>
                                <td> <?php echo filter($row->unit); ?> </td>
                                <td class="text-right">
                                    <?php
                                    $total_quantity[] += $row->quantity;
                                    echo $row->quantity; ?>
                                </td>

                                <td class="text-right"><?php echo $row->purchase_price; ?></td>
                                <td class="text-right">
                                    <?php
                                    $subtotal  = $row->quantity * $row->purchase_price;
                                    $total_sub += $subtotal;
                                    echo f_number($subtotal);
                                    ?>
                                </td>
                            </tr>
                        <?php }
                    } ?>

                    <tr>
                        <th rowspan="2" colspan="4" style="vertical-align: middle">In Word : <span
                                    class="inword"></span> Taka Only.
                        </th>
                    </tr>

                    <tr>
                        <th> Total Amount</th>
                        <td class="text-right">
                            <?php
                            echo f_number($total_sub);
                            ?> TK
                        </td>
                    </tr>
                </table>

                <div class="pull-right ">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
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
    $(document).ready(function () {
        $(".inword").html(inWorden(<?php echo $total_sub; ?>));
    });
</script>
