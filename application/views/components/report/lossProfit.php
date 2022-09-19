<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Profit/Loss Report</h1>
                </div>
            </div>
            
            <div class="panel-body" ng-cloak>
                <?php
                    $attribute = array('class' => 'row');
                    echo form_open('', $attribute);
                ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="search[product_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>Select Product</option>
                            <?php foreach ($allProducts as $key => $client) { ?>
                            <option value="<?php echo $client->code; ?>"><?php echo $client->name; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group date" id="datetimepickerSMSFrom">
                            <input type="text" name="date[from]" class="form-control"  placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group date" id="datetimepickerSMSTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php if (!empty($resultInfo)) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <?php $this->load->view('components/print'); ?>
                <h4 class="hide text-center" style="margin-top: 0px;">Profit Loss</h4>

                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Product Name</th>
                        <th>Voucher No</th>
                        <th>Quantity</th>
                        <th>Production Cost</th>
                        <th>Sales Price</th>
                        <th>Profit</th>
                        <th>Loss</th>
                    </tr>

                    <?php 
                    $loss = $profit = $totalLoss = $totalProfit =  $totalQuantity = $totalPurchase = $totalSale = 0;
                    foreach ($resultInfo as $key => $value) {

                        // read product name by code
                        $where = array('code' =>$value->product_code);
                        $nameInfo=$this->action->read('materials',$where);

                        // count profit loss
                        $pro_sum  =  $value->purchase_price * $value->quantity;
                        $sale_sum =  $value->sale_price * $value->quantity; 

                        // dectect profit or loss
                        if ($pro_sum > $sale_sum) {
                            $loss = $pro_sum - $sale_sum;
                        }else{
                            $profit = $sale_sum - $pro_sum;
                        }

                        // count total accounce
                        $totalLoss += $loss;
                        $totalProfit += $profit;
                        $totalPurchase += $value->purchase_price;
                        $totalSale += $value->sale_price;
                        $totalQuantity += $value->quantity;

                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $nameInfo[0]->name; ?></td>
                        <td><?php echo $value->voucher_no; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo $value->purchase_price; ?></td>
                        <td><?php echo $value->sale_price; ?></td>
                        <td><?php echo $profit; ?></td>
                        <td><?php echo $loss; ?></td>
                    </tr>
                    <?php } ?>

                    <tr class="bg-info" style="font-weight: bold;">
                        <td colspan="3">Total <small> (Profit & Loss)</small></td>
                        <td>
                            <?php echo  $totalQuantity; ?>
                        </td>
                        <td>
                            <?php echo $totalPurchase; ?>
                        </td>
                        <td>
                            <?php echo  $totalSale; ?>
                        </td>
                        <td >
                            <?php echo $totalProfit; ?>
                        </td>
                        <td>
                            <?php echo $totalLoss; ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>