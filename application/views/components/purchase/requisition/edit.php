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

<div class="container-fluid" ng-controller="requisitionEditCtrl">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Requisition</h1>
                </div>
            </div>

            <div class="panel-body">

                <!-- horizontal form -->
                <?php
                $attr = array("id" => "form");
                echo form_open('purchase/requisition/update', $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <label class="control-label">Date</label>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="created" class="form-control"
                                       value="<?php echo $info->created; ?>" placeholder="Date" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="control-label">Indent No</label>
                        <div class="form-group">
                            <input type="text" name="voucher_no" ng-init="voucherNo='<?= $info->voucher_no ?>'"
                                   ng-value="voucherNo" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="control-label">Product Type</label>
                        <div class="form-group">
                            <input type="text" name="" value="<?php echo filter($info->product_type); ?>"
                                   class="form-control" readonly>
                            <input type="hidden" name="product_type" ng-init="productType='<?= $info->product_type ?>'"
                                   value="<?php echo $info->product_type; ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="control-label">Product List</label>
                        <div class="form-group">
                            <select ui-select2="{ allowClear: true}" class="form-control" ng-model="productCode"
                                    data-placeholder="Select Product" ng-change="addNewProductFn(productCode)">
                                <option value="" selected disable></option>
                                <option ng-repeat="row in productList" value="{{row.code}}">{{ row.name }}</option>
                            </select>
                            <span ng-show="erroeMessage" style="color:red;">This product already exists....!</span>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0px;">


                <table class="table table-bordered table2">
                    <tr>
                        <th rowspan="2" width="45px">SL</th>
                        <th rowspan="2">Name of Item</th>
                        <th rowspan="2">Specification</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Current Stock</th>
                        <th rowspan="2">Request Qty.</th>
                        <th colspan="3" class="text-center">Last Purchase Info</th>
                        <th rowspan="2" width="50px">Action</th>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Vendor</th>
                    </tr>

                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="item_id[]" ng-value="item.item_id">
                        <input type="hidden" name="product_code[]" ng-value="item.code">
                        <input type="hidden" name="previous_item_id[]" ng-value="item.previous_item_id">
                        <input type="hidden" name="old_quantity[]" ng-value="item.old_quantity">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>
                        </td>
                        <td>
                            <input type="text" name="specification[]" class="form-control" ng-model="item.specification"
                                   readonly>
                        </td>
                        <td>
                            <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                        </td>

                        <td>
                            <input type="text" name="stock_qty[]" class="form-control" ng-model="item.stock_qty"
                                   readonly>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="0" step="any"
                                   placeholder="0" ng-model="item.quantity" autocomplete="off" required>
                        </td>

                        <td>
                            <input type="text" name="previous_date[]" class="form-control" min="0"
                                   ng-model="item.previous_date" readonly>
                        </td>

                        <td>
                            <input type="text" name="previous_price[]" class="form-control" min="0"
                                   ng-model="item.previous_price" readonly>
                        </td>

                        <td>
                            <input type="text" name="previous_vendor[]" class="form-control" min="0"
                                   ng-model="item.previous_vendor" readonly>
                        </td>

                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>

                <span ng-repeat="row in deleteItem">
                    <input type="hidden" name="delete_id[]" ng-value="row.id">
                    <input type="hidden" name="delete_code[]" ng-value="row.code">
                    <input type="hidden" name="delete_quantity[]" ng-value="row.quantity">
                </span>

                <input type="hidden" name="total_amount" ng-value="getTotalFn()">
                <input type="hidden" name="total_quantity" ng-value="totalQuantity">

                <div class="row form-horizontal">
                    <div class="col-md-8">
                        <textarea name="remarks" placeholder="Remarks" class="form-control"><?php echo $info->remarks; ?></textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="text-right">
                            <input type="submit" name="update" value="Update" class="btn btn-primary"
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