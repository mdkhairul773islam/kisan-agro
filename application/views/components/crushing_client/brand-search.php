<style>
@media print{
    aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
    .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
    .hide{display: block !important;}
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Company Wise Search</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Company Name </label>
                    <div class="col-md-5">
                        <select name="search[brand]" class="form-control">
                            <?php
                            foreach ($allBrand as $key => $row) { ?>
                            <option value="<?php echo $row->brand; ?>"><?php echo ucwords(str_replace("-"," ",$row->brand)); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <?php if ($allInfo != null) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.png'); ?>">

                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Customer Name</th>
                        <th>Mobile Number</th>
                        <th>Quantity</th>
                        <th>Amount(৳)</th>
                    </tr>
                    <?php
                    $counter = $totalQuantity = $grandTotal = 0;
                    foreach ($allInfo as $key => $row) {
                    $brandQuantity =  $totalAmount = 0;
                    $partyInfo = $this->action->read("parties", array("code" => $row->party_code));
                    $where = array("brand" => $row->brand, "party_code" => $row->party_code);
                    $joinCond = "sapitems.voucher_no = saprecords.voucher_no";
                    $brandInfo = $this->action->joinAndRead("sapitems", "saprecords", $joinCond, $where);
                    foreach ($brandInfo as $key => $value) {
                        $brandQuantity += $value->quantity;
                        $totalAmount += $value->quantity * $value->sale_price;
                    }
                    $totalQuantity += $brandQuantity;
                    $grandTotal += $totalAmount;
                    $counter ++;
                    ?>
                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php if($partyInfo){echo filter($partyInfo[0]->name). " [". $partyInfo[0]->address."]";} ?></td>
                        <td><?php if($partyInfo){echo $partyInfo[0]->contact;} ?></td>
                        <td><?php echo $brandQuantity . " " . $row->unit ; ?></td>
                        <td><?php echo f_number($totalAmount); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="3" class="text-right">Grand Total</th>
                        <th><?php echo $totalQuantity; ?></th>
                        <th><?php echo $grandTotal; ?></th>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>
