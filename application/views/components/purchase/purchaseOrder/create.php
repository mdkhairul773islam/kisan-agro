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

<div class="container-fluid" ng-controller="purchaseOrderEntryCtrl">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Order</h1>
                </div>
            </div>

            <div class="panel-body">

                <!-- horizontal form -->
                <?php
                $attr = array("id" => "form");
                echo form_open('purchase/purchaseOrder/store', $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="created" class="form-control"
                                       value="<?php echo date('Y-m-d'); ?>"
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
                                <?php if (!empty($partyList)) {
                                    foreach ($partyList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="reference_no" ng-init="referenceNo=''" ng-model="referenceNo"
                                    ng-change="getProductList(referenceNo)" class="selectpicker form-control"
                                    data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Indent No</option>
                                <?php if (!empty($indentList)) {
                                    foreach ($indentList as $key => $row) { ?>
                                        <option value="<?php echo $row->voucher_no; ?>">
                                            <?php echo $row->voucher_no; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr style="margin-top: 0px;">


                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Description of Goods</th>
                        <th class="th-width">Due on</th>
                        <th class="th-width">Unit</th>
                        <th class="th-width">Quantity</th>
                        <th class="th-width">Rate</th>
                        <th class="th-width">Dis(%)</th>
                        <th class="th-width">Dis(Tk)</th>
                        <th class="th-width">Amount</th>
                        <th width="50px">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="product_code[]" ng-value="item.code">
                        <input type="hidden" name="previous_item_id[]" ng-value="item.previous_item_id">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>
                        </td>

                        <td>
                            <input type="text" name="due_on[]" class="form-control" ng-model="item.due_on">
                        </td>

                        <td>
                            <input type="text" name="unit[]" class="form-control" ng-model="item.unit" readonly>
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="0" step="any"
                                   placeholder="0" ng-model="item.quantity" autocomplete="off" required>
                        </td>

                        <td>
                            <input type="number" name="purchase_price[]" class="form-control" min="0"
                                   ng-model="item.purchase_price" step="any">
                        </td>

                        <td>
                            <input type="number" name="discount_per[]" class="form-control" min="0"
                                   ng-model="item.discount_per" step="any">
                        </td>

                        <td>
                            <input type="number" name="discount[]" class="form-control" min="0"
                                   ng-model="setDiscountFn($index)" step="any" readonly>
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
                            <label class="col-md-4 control-label">Suppliers Ref. </label>
                            <div class="col-md-8">
                                <textarea name="meta[supplier_reference]" rows="1" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Transport </label>
                            <div class="col-md-8">
                                <textarea name="meta[transport]" rows="1" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks </label>
                            <div class="col-md-8">
                                <textarea name="remarks" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Qty.</label>
                            <div class="col-md-8">
                                <input type="number" name="total_quantity" ng-value="totalQuantity" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Amount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_amount" ng-value="getTotalFn()" class="form-control"
                                       step="any" min="0" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" ng-value="totalDiscount" class="form-control"
                                       step="any" min="0" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Bill</label>
                            <div class="col-md-8">
                                <input type="number" name="total_bill" ng-value="getGrandTotalFn()" class="form-control"
                                       step="any" min="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Ship To/Destination</label>
                            <textarea name="meta[ship_destination]" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Terms of Delivery</label>
                            <textarea name="meta[terms_of_delivery]" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12 text-right">
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