<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    .table2 tr td {
        padding: 0 !important;
    }

    .table2 tr td input {
        border: 1px solid transparent;
    }

    .new-row-1 .col-md-4 {
        margin-bottom: 8px;
    }

    .table tr th.th-width {
        width: 110px !important;
    }

    .red, .red:focus {
        border-color: red;
    }

    .green, .green:focus {
        border-color: green;
    }
</style>

<div class="container-fluid" ng-controller="orderPurchaseEntryCtrl">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Stock Entry</h1>
                </div>
            </div>

            <div class="panel-body">

                <!-- horizontal form -->
                <?php
                $attr = array("id" => "form");
                echo form_open('purchase/order_purchase/store', $attr);
                ?>

                <input type="hidden" name="party_code" ng-value="party_code">

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="sap_at" class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>"
                                       placeholder="Date" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="order_no" ng-init="orderNo=''" ng-model="orderNo"
                                    class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select PO.No</option>
                                <?php /* if (!empty($orderList)) {
                                    foreach ($orderList as $key => $row) { ?>
                                        <option value="<?php echo $row->voucher_no; ?>">
                                            <?php echo $row->voucher_no . '-' . filter($row->name) . ' (' . filter($row->address) . ')'; ?>
                                        </option>
                                    <?php }
                                }*/ ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0px;">


                <table class="table table-bordered table2">
                    <tr>
                        <th rowspan="2" width="45px">SL</th>
                        <th rowspan="2">Description of Goods</th>
                        <th rowspan="2">Type of Bag/Drum/Others</th>
                        <th rowspan="2">Qth. in Bag Kg/Ltr</th>
                        <th colspan="2">Quantity</th>
                        <th rowspan="2">Rate</th>
                        <th rowspan="2">Discount(%)</th>
                        <th rowspan="2">Amount</th>
                        <th rowspan="2">Action</th>
                    </tr>
                    
                    <tr>
                        <th>No. Of Bag/Dram</th>
                        <th>Kg</th>
                    </tr>

                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="order_item_id[]" ng-value="item.order_item_id">
                        <input type="hidden" name="category_id[]" ng-value="item.category_id">
                        <input type="hidden" name="unit[]" ng-value="item.unit">
                        <input type="hidden" name="received_quantity[]" ng-value="getReceivedQtyFn($index)">
                        <input type="hidden" name="sale_price[]" ng-value="item.sale_price">
                        <input type="hidden" name="dealer_price[]" ng-value="item.dealer_price">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>

                        </td>
                        
                        <td>
                            <input type="text" name="order_quantity[]" class="form-control" ng-value="item.order_quantity" readonly>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="0" step="any"
                                   placeholder="0" ng-model="item.quantity" max="{{item.maxQty}}" autocomplete="off"
                                   required>
                        </td>

                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" min="0"
                                   ng-model="item.purchase_price" step="any">
                        </td>

                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-model="item.subtotal"
                                   ng-value="setSubtotalFn($index)" readonly>
                        </td>
                        
                        <td>
                            <input type="text" name="remaining_quantity[]" class="form-control" placeholder="0" ng-value="getRemainingQuantityFn($index)" readonly>
                        </td>

                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>

                <div class="row form-horizontal">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Supplier Name </label>
                            <div class="col-md-8">
                                <input type="text" ng-value="party_name" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile </label>
                            <div class="col-md-8">
                                <input type="text" ng-value="mobile" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Address </label> 
                            <div class="col-md-8">
                                <textarea ng-model="address" class="form-control" readonly></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks </label>
                            <div class="col-md-8">
                                <textarea name="comment" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Qty.</label>
                            <div class="col-md-8">
                                <input type="number" name="total_quantity" ng-value="totalQuantity" class="form-control" step="any" readonly>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Bill </label>
                            <div class="col-md-8">
                                <input type="number" name="total_bill" ng-value="getTotalFn()"
                                       class="form-control" step="any" min="0" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" ng-value="balance" class="form-control" readonly>
                                        <input type="hidden" name="previous_balance" ng-value="previous_balance">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="previous_sign" ng-value="previous_sign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
                                               placeholder="0"
                                               step="any">
                                    </div>

                                    <div class="col-md-6">
                                        <select name="method" class="form-control">
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" ng-value="getCurrentTotalFn()" class="form-control"
                                               step="any" readonly>
                                        <input type="hidden" name="current_balance" ng-value="current_balance">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="text" name="current_sign" ng-value="current_sign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group pull-right">
                            <input type="submit" name="save" value="Save" class="btn btn-primary"
                                   ng-disabled="isDisable">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<script>
    // linking between two date
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>