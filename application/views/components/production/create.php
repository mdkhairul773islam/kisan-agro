<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    .col-md-4 {
        margin-bottom: 15px;
    }

    .btn-group button {
        padding: 5px 13px;
    }

    .p-0 {
        padding: 0px;
    }
</style>

<div class="container-fluid" ng-controller="productionCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Production</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php echo form_open('production/production/store', ['id' => 'formSubmit']); ?>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="created" value="<?php echo date('Y-m-d'); ?>"
                                       class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Batch No</label>
                            <input type="text" name="batch_no" ng-init="batch=''" ng-model="batchNo" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Raw Product</label>
                            <select class="selectpicker form-control" data-show-subtext="true" ng-model="productFrom"
                                    ng-change="getFromProductInfoFn(productFrom)" data-live-search="true">
                                <option value="" selected>Select Product</option>
                                <?php
                                if (!empty($rawProductList)) {
                                    foreach ($rawProductList as $key => $item) { ?>
                                        <option value="<?php echo $item->id; ?>">
                                            <?php echo $item->code . '-' . filter($item->name); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Waste(%)</th>
                        <th width="10%">Waste Qty.</th>
                        <th width="10%">Waste Amount</th>
                        <th width="10%">Total Amount</th>
                        <th width="5%">Action</th>
                    </tr>

                    <tr ng-repeat="row in fromCart">
                        <input type="hidden" name="from_code[]" ng-value="row.code">
                        <input type="hidden" name="from_sale_price[]" ng-value="row.sale_price">

                        <td ng-bind="row.code"></td>
                        <td ng-bind="row.name"></td>
                        <td ng-bind="row.unit"></td>
                        <td ng-bind="row.stock_qty"></td>
                        <td style="padding: 0px;">
                            <input type="text" name="from_purchase_price[]" ng-value="row.purchase_price"
                                   class="form-control" step="any" readonly>
                        </td>
                        <td style="padding: 0px;">
                            <input type="number" class="form-control" name="from_quantity[]" ng-model="row.quantity"
                                   min="0" max="{{row.stock_qty}}" step="any" placeholder="0" required>
                        </td>
                        <td style="padding: 0px;">
                            <input type="number" class="form-control" name="from_waste_percentage[]"
                                   ng-model="row.waste_percentage" step="any"
                                   placeholder="0">
                        </td>
                        <td style="padding: 0px;">
                            <input type="text" class="form-control" name="from_waste_quantity[]"
                                   ng-value="getWastQtyFn($index)" step="any" placeholder="0" readonly>
                        </td>
                        <td style="padding: 0px;">
                            <input type="text" class="form-control" name="from_waste_quantity[]"
                                   ng-value="row.waste_subtotal" step="any" placeholder="0" readonly>
                        </td>
                        <td style="padding: 0px;">
                            <input type="text" class="form-control" name="from_subtotal"
                                   ng-value="fromSubtotalFn($index)" step="any" placeholder="0" readonly>
                        </td>
                        <td class="text-center p-0" style="vertical-align: middle;">
                            <span class="btn btn-sm btn-danger" ng-click="removeFromItemFn($index)">
                                <i class="fa fa-trash"></i></span>
                        </td>
                    </tr>

                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th style="padding: 0px;"><input type="text" name="total_quantity" ng-value="getFromTotalQty()" class="form-control" readonly></th>
                        <th></th>
                        <th style="padding: 0px;"><input type="text" name="total_waste" ng-value="fromTotalWasteQty" class="form-control" readonly></th>
                        <th style="padding: 0px;"><input type="text" name="waste_amount" ng-value="fromTotalWasteAmount" class="form-control" readonly></th>
                        <th style="padding: 0px;"><input type="text" name="total_amount" ng-value="fromTotalAmount" class="form-control" readonly></th>
                    </tr>
                </table>


                <div ng-show="toSection">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Finish Product</label>
                                <select class="selectpicker form-control" data-show-subtext="true" ng-model="productTo"
                                        ng-change="getToProductInfoFn(productTo)" data-live-search="true">
                                    <option value="" selected>Select Product</option>
                                    <?php
                                    if (!empty($finishProductList)) {
                                        foreach ($finishProductList as $key => $item) { ?>
                                            <option value="<?php echo $item->id; ?>">
                                                <?php echo $item->code . '-' . filter($item->name); ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Amount</th>
                            <th width="5%">Action</th>
                        </tr>

                        <tr ng-repeat="row in toCart">
                            <input type="hidden" name="to_code[]" ng-value="row.code">
                            <input type="hidden" name="to_sale_price[]" ng-value="row.sale_price">
                            <td ng-bind="row.code"></td>
                            <td ng-bind="row.name"></td>
                            <td ng-bind="row.unit"></td>
                            <td style="padding: 0px;">
                                <input type="text" name="to_purchase_price[]" ng-value="toPurchasePriceFn($index)"
                                       class="form-control" step="any" readonly>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control" name="to_quantity[]" min="0"
                                       ng-model="row.quantity" autocomplete="off" placeholder="0" required>
                            </td>
                            <td ng-bind="toTotalAmount"></td>
                            <td class="text-center p-0" style="vertical-align: middle;">
                                <span class="btn btn-sm btn-danger" ng-click="removeToItemFn($index)"><i
                                            class="fa fa-trash"></i></span>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="4" class="text-right">Total</th>
                            <th style="padding: 0px;"><input type="text" name="total_production" ng-value="getToTotalQty()" class="form-control" readonly></th>
                            <th style="padding: 0px;"><input type="text" name="production_amount" ng-value="toTotalAmount" class="form-control" readonly></th>
                        </tr>
                    </table>

                    <div class="text-right">
                        <input type="submit" name="save" value="Save" ng-disabled="isDisabled" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
    // linking between two date
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
