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

<div class="container-fluid" ng-controller="EditPurchaseEntry">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Purchase</h1>
                </div>
            </div>

            <div class="panel-body">

                <!-- horizontal form -->
                <?php
                $attr = array("id" => "form");
                echo form_open('purchase/editPurchase/update', $attr);
                ?>


                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="date" class="form-control" value="<?php echo $info->sap_at; ?>"
                                       placeholder="Date" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Voucher No</label>
                            <input type="text" name="voucher_no" ng-init="voucherNo='<?php echo $info->voucher_no; ?>'"
                                   ng-value="voucherNo" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Raw Product</label>
                            <select ng-model="productCode" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true" ng-change="addNewProductFn(productCode)">
                                <option value="" selected>Raw Material</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo $row->code . '-' . filter($row->name); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                            <span ng-show="erroeMessage" style="color:red;">This product already exists....!</span>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0px;">


                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Raw Material</th>
                        <th class="th-width">Quantity</th>
                        <th style="width: 133px;">Purchase Price</th>
                        <th class="th-width">Discount</th>
                        <th class="th-width">Total</th>
                        <th width="50px">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="item_id[]" ng-value="item.item_id">
                        <input type="hidden" name="product_code[]" ng-value="item.code">
                        <input type="hidden" name="unit[]" ng-value="item.unit">
                        <input type="hidden" name="sale_price[]" ng-value="item.sale_price">
                        <input type="hidden" name="old_quantity[]" ng-value="item.old_quantity">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>

                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="0" step="any"
                                   placeholder="0"
                                   ng-model="item.quantity" required>
                        </td>

                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" min="0"
                                   ng-model="item.purchase_price" step="any">
                        </td>

                        <td>
                            <input type="number" name="discount[]" class="form-control" min="0" ng-model="item.discount"
                                   step="any">
                        </td>

                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-model="item.subtotal"
                                   ng-value="setSubtotalFn($index)" readonly>
                        </td>

                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>
                
                <span ng-repeat="row in deleteItemCart">
                    <input type="hidden" name="delete_item_id[]" ng-value="row.item_id">
                    <input type="hidden" name="delete_code[]" ng-value="row.code">
                    <input type="hidden" name="delete_quantity[]" ng-value="row.quantity">
                </span>

                <div class="row form-horizontal">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Supplier Name </label>
                            <div class="col-md-8">
                                <input type="text" value="<?php echo $info->name; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Mobile </label>
                            <div class="col-md-8">
                                <input type="text" name="mobile" value="<?php echo $info->mobile; ?>"
                                       class="form-control" readonly>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Address </label>
                            <div class="col-md-8">
                                <textarea class="form-control" readonly><?php echo $info->address; ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks </label>
                            <div class="col-md-8">
                                <textarea name="comment" class="form-control"><?php echo $info->comment; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" name="total" class="form-control" ng-value="getTotalFn()"
                                       step="any" readonly>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-value="getTotalDiscountFn()"
                                       class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport Cost </label>
                            <div class="col-md-8">
                                <input type="number" name="transport_cost"
                                       ng-init="transportCost=<?= $info->transport_cost ?>" ng-model="transportCost"
                                       placeholder="0"
                                       class="form-control" step="any">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Grand Total </label>
                            <div class="col-md-8">
                                <input type="number" name="grand_total" ng-value="getGrandTotalFn()"
                                       class="form-control" step="any" min="0" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" ng-model="partyInfo.balance" class="form-control"
                                               step="any" readonly>
                                        <input type="hidden" name="previous_balance"
                                               ng-value="partyInfo.previous_balance">
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="previous_sign" ng-value="partyInfo.sign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-init="payment=<?= $info->paid ?>" ng-model="payment" class="form-control"
                                               placeholder="0"
                                               step="any">
                                    </div>

                                    <div class="col-md-5">
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
                                    <div class="col-md-7">
                                        <input type="number" ng-value="getCurrentTotalFn()" class="form-control"
                                               step="any" readonly>
                                        <input type="hidden" name="current_balance"
                                               ng-value="partyInfo.current_balance">
                                    </div>

                                    <div class="col-md-5">
                                        <input type="text" name="current_sign" ng-value="partyInfo.csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group pull-right">
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