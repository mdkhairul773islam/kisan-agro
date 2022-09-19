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

        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Print Sale Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Order Sale Voucher</h4>
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <label>Name : <?php echo filter($info->name); ?></label> <br>
                        <label>Mobile : <?php echo $info->mobile; ?></label><br>
                    </div>

                    <div class="col-xs-4 print-font">

                        <label style="margin-bottom: 10px;">
                            Voucher No : <?php echo $info->voucher_no; ?>
                        </label> <br>
                        <?php
                        $metaInfo = get_row("sapmeta", ["meta_key" => "order_by", "voucher_no" => $info->voucher_no]);
                        ?>
                        <label style="margin-bottom: 10px;">
                            Sales Man : <?php echo (!empty($metaInfo)) ? $metaInfo->meta_value : ''; ?>
                        </label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Date : <?php echo $info->sap_at; ?></label> <br>
                        <label>Print Time : <?php echo date("h:i:s A"); ?></label>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                    <tr>
                        <th style="width: 2%;">SL</th>
                        <th style="width: 5%;">P.ID</th>
                        <th style="width: 34%;">Product Name</th>
                        <th style="width: 7%;">Unit</th>
                        <th style="width: 10%;">Weight</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 18%;">Sale Price (Tk)</th>
                        <th style="width: 18%;">Amount (TK)</th>
                    </tr>
                    </tr>

                    <?php
                    $total_sub      = 0.0;
                    $total_quantity = [];
                    $where          = ['voucher_no' => $info->voucher_no, 'materials.type' => 'finish_product', 'sapitems.trash' => 0];
                    $saleInfo       = get_join('sapitems', 'materials', 'materials.code=sapitems.product_code', $where, ['sapitems.*', 'materials.name'], '', 'sapitems.product_code', 'asc');
                    foreach ($saleInfo as $key => $row) {
                        ?>
                        <tr>
                            <td><?php echo($key + 1); ?></td>
                            <td> <?php echo $row->product_code; ?> </td>
                            <td> <?php echo filter($row->name); ?> </td>
                            <td> <?php echo filter($row->unit); ?> </td>
                            <td class="text-right"><?php echo $row->weight; ?></td>
                            <td class="text-right"><?php echo $row->quantity; ?></td>
                            <td class="text-right"><?php echo $row->sale_price; ?></td>
                            <td class="text-right">
                                <?php
                                $subtotal  = $row->sale_price * $row->quantity;
                                $total_sub += $subtotal;
                                echo f_number($subtotal);
                                ?>
                            </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th rowspan="7" colspan="6" style="vertical-align: middle">In Word : <span
                                    class="inword"></span> Taka Only.
                        </th>
                    </tr>
                    
                    <tr>
                        <th>Discount</th>

                        <td class="text-right">
                            <?php  echo f_number($info->total_discount) . ' TK'; ?>
                        </td>
                    </tr>

                    <tr>
                        <th> Sub Total</th>

                        <td class="text-right">
                            <?php
                            echo f_number($info->total_bill);
                            ?> TK
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <th> Previous Balance</th>

                        <td class="text-right">
                            <?php
                            if ($info->party_balance >= 0) {
                                $status = "<br> [ Receivable ]";
                            } else {
                                $status = "<br> [ Payable ]";
                            }
                            echo f_number($info->party_balance) . ' TK ' . $status;
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Paid</th>
                        <td class="text-right">
                            <?php
                            echo f_number(($info->paid));
                            ?> TK
                        </td>
                    </tr>

                    <tr>
                        <th> Current Balance</th>
                        <td class="text-right">
                            <?php
                            $currentBalance = ($info->party_balance + $info->total_bill) - $info->paid;
                            if ($currentBalance >= 0) {
                                $status = "<br> [ Receivable ]";
                            } else {
                                $status = "<br> [ Payable ]";
                            }
                            echo f_number($currentBalance) . ' TK ' . $status;
                            ?>
                        </td>
                    </tr>
                </table>

                <div class="pull-left">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        --------------------------------- <br>
                        <?php echo (!empty($metaInfo)) ? $metaInfo->meta_value : ''; ?>
                    </h4>
                </div>

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
        $(".inword").html(inWorden(<?php echo $info->total_bill; ?>));
    });
</script>
