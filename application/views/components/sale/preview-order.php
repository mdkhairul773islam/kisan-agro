<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }

    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Order Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide">Order Voucher</h4>
                
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
                        $metaInfo = get_row("sapmeta", ["meta_key"=> "order_by", "voucher_no" => $info->voucher_no]);
                        ?>
                        <label style="margin-bottom: 10px;">
                            Sales Man : <?php echo (!empty($metaInfo))? $metaInfo->meta_value : ''; ?>
                        </label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Date : <?php echo $info->sap_at; ?></label> <br>
                        <label>Print Time : <?php echo date("h:i:s A"); ?></label>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="30">SL</th>
                        <th width="80" class="text-center">P.ID</th>
                        <th width="350">Product Name</th>
                        <th width="150">Type</th>
                        <!--<th width="150">Order Time</th>-->
                        <th width="150">Unit</th>
                        <th width="150">Quantity</th>
                        <th width="150">Delivery</th>
                        <th width="150">Weight</th>
                        <th width="150">Sale Price (Tk)</th>
                        <th width="150">Amount (TK)</th>
                    </tr>

                    <?php
                    $total_sub = $totalWeight = 0;
                    $total_quantity = [];
                    $where = ['voucher_no' => $info->voucher_no, 'materials.type' => 'finish_product', 'sapitems.trash' => 0];
                    $saleInfo = get_join('sapitems', 'materials', 'materials.code=sapitems.product_code', $where, ['sapitems.*', 'materials.code', 'materials.name', 'materials.product_type']);
                    foreach($saleInfo as $key => $row){
                        
                        $weight = ($row->weight * $row->quantity);
                        $totalWeight += $weight;
                        
                        $subtotal = $row->sale_price * $row->quantity;
                        $total_sub += $subtotal;
                        ?>
                        <tr>
                            <td style="width: 50px;"><?php echo ($key + 1); ?></td>
                            <td class="text-center"> <?php echo filter($row->code); ?> </td>
                            <td> <?php echo filter($row->name); ?> </td>
                            <td> <?php echo filter($row->product_type); ?> </td>
                            <!--<td> <?php //echo filter($row->order_time); ?> </td>-->
                            <td> <?php echo filter($row->unit); ?> </td>
                            <td class="text-center"><?php echo $row->quantity; $total_quantity[] += $row->quantity; ?></td>
                            <td> &nbsp;  </td>
                            <td class="text-right"><?php echo $weight; ?></td>
                            <td class="text-right"><?php echo $row->sale_price; ?></td>
                            <td class="text-right"><?php echo f_number($subtotal); ?> </td>
                        </tr> 
                    <?php } ?>

                    <tr>
                        <th rowspan="4" colspan="7" style="vertical-align: middle">In Word : <span class="inword"></span> Taka Only.</th>
                    </tr>

                    <tr>
                        <td class="text-right"> <?php echo f_number($totalWeight); ?> Kg </td>
                        <th> Total Amount </th>
                        <td class="text-right"> <?php echo f_number($total_sub); ?> TK </td>
                    </tr>
                    
                    <tr>
                        <td class="text-right"></td>
                        <th>Discount </th>
                        <td class="text-right">
                            <?php
                            echo f_number($info->total_discount);
                            ?> TK
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="text-right"></td>
                        <th>Grand Total </th>
                        <td class="text-right">
                            <?php
                            echo f_number($info->total_bill);
                            ?> TK
                        </td>
                    </tr>
                </table>

                <div class="pull-left">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                        --------------------------------- <br>
                        <?php echo (!empty($metaInfo))? $metaInfo->meta_value: ''; ?>
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
    $(document).ready(function(){$(".inword").html(inWorden(<?php echo $info->total_bill; ?>));});
</script>
