<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

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

<div class="container-fluid" ng-controller="PurchaseEntry">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Purchase</h1>
                </div>
            </div>

            <div class="panel-body">

                <!-- horizontal form -->
                <?php
                    $attr = array("id" => "form");
                    echo form_open('purchase/purchase/store', $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>"
                                       placeholder="Date" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="party_code" ng-change="setPartyfn(partyCode)" ng-model="partyCode"
                                    class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Supplier Name</option>
                                <?php if (!empty($allParty)) {
                                    foreach ($allParty as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="mobile" value="{{ partyInfo.mobile }}">

                    <div class="col-md-4">
                        <div class="form-group">
                            <select ng-model="productCode" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true" ng-required="true" ng-change="addNewProductFn(productCode)">
                                <option value="" selected>Select Product</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name); ?>
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

                        <input type="hidden" name="product_code[]" ng-value="item.code">
                        <input type="hidden" name="sale_price[]" ng-value="item.sale_price">
                        <input type="hidden" name="unit[]" ng-value="item.unit">

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

                <div class="row form-horizontal">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks </label>
                            <div class="col-md-8">
                                <textarea name="comment" rows="4" class="form-control"></textarea>
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
                                <input type="number" name="transport_cost" ng-model="transportCost" placeholder="0"
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
                                        <input type="number" name="paid" ng-model="payment" class="form-control"
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