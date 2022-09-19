<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Raw Material Ledger</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div class="panel-body none">
                <?php
                    echo $this->session->flashdata('deleted');
                    echo form_open("");
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="product_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>Select Product</option>
                                <?php
                                if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo $row->code . '-' . filter($row->name); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <hr class="none" style="margin: 0px;">


            <?php if (!empty($results)) { ?>
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                
                <h4 class="hide text-center" style="margin-top: 0px;">Raw Material Ledger</h4>
                
                <table class="table table-bordered">
                    <tr class="bg-info">
                        <th colspan="4">Product Info</th>
                    </tr>
                    <tr>
                        <td><strong>Code:</strong> <?php echo $productInfo->code; ?></td>
                        <td><strong>Name:</strong> <?php echo $productInfo->name; ?></td>
                        <td><strong>Unit:</strong> <?php echo $productInfo->unit; ?></td>
                        <td><strong>Price:</strong> <?php echo $productInfo->purchase_price; ?></td>
                    </tr>
                </table>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="DataTable">
                        <?php
                        $calculateQty = 0;
                        foreach ($results as $item) { ?>
                        
                            <tr class="bg-info">
                                <th colspan="6"><?php echo $item->title; ?></th>
                            </tr>
                        
                            <tr>
                                <th style="width: 40px;">SL</th>
                                <th>Date</th>
                                <th>Voucher No</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Amount</th>
                            </tr>
                            
                            <?php 
                            $quantity = $amount = 0;
                            foreach($item->data AS $key => $row ) { 
                            $quantity += $row->quantity;
                            $amount += $row->purchase_amount;
                            ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $row->date; ?></td>
                                <td><?php echo $row->voucher_no; ?></td>
                                <td><?php echo $row->quantity; ?></td>
                                <td><?php echo $row->purchase_price; ?></td>
                                <td><?php echo $row->purchase_amount; ?></td>
                            </tr>
                            <?php
                                if($item->type == 'purchase'){
                                    $calculateQty += $row->quantity;
                                }elseif($item->type == 'purchase_return' || $item->type == 'production'){
                                    $calculateQty += - $row->quantity;
                                }
                            } ?>
                            
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th><?php echo $quantity; ?></th>
                                <th></th>
                                <th><?php echo $amount; ?></th>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
                
                <div class="row">
                    <div class="col-md-offset-6 col-md-6">
                        <table class="table table-bordered">
                            <!--<tr class="bg-info">
                                <th colspan="4"></th>
                            </tr>-->
                            <tr>
                                <th width="50%">Previous Stock</th>
                                <td><?php echo $previousQty; ?></td>
                            </tr>
                            
                            <tr>
                                <th>Calculate Stock</th>
                                <td>
                                    <?php $calculateQty = $calculateQty + $previousQty;
                                    echo $calculateQty; ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Current Stock</th>
                                <td><?php  echo round($productInfo->quantity, 2); ?></td>
                            </tr>
                            
                            <tr>
                                <th>Stock Difference</th>
                                <td>
                                    <?php $deference = $productInfo->quantity - $calculateQty;
                                    echo $deference; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php } else {
                echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
            } ?>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script>

    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
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
