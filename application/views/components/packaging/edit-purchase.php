
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

<div class="container-fluid" ng-controller="PackagingEditPurchaseEntry" ng-cloak>
    <div class="row">
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
                $attr = array("class" => "form-horizontal" , "id" => "form");
                echo form_open('packaging/edit_purchase?vno='. $voucherInfo->voucher_no , $attr);
                ?>

                <div class="row new-row-1">
                    <div class="col-md-4">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" value="<?php echo $voucherInfo->sap_at; ?>"
                                   placeholder="Date" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="voucher_no" ng-init="voucher_no='<?php echo $voucherInfo->voucher_no; ?>'" ng-value="voucher_no" ng-model="voucher_no"
                               class="form-control" required readonly>
                    </div>
                </div>
                <hr>


                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Raw Material</th>
                        <th class="th-width">Quantity</th>
                        <th style="width: 133px;">Purchase Price</th>
                        <th class="th-width">Discount</th>
                        <th class="th-width">Total</th>
                    </tr>

                    <tr ng-repeat="item in records">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>
                            <input type="hidden" name="item_id[]" ng-value="item.item_id">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="sap_type[]" ng-value="item.sap_type">
                            <input type="hidden" name="old_quantity[]" ng-value="item.old_quantity">

                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" min="0" step="any"
                                   ng-model="item.quantity">
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
                    </tr>
                </table>
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Name </label>
                            <div class="col-md-7">
                                <input type="text" value="<?php echo filter($voucherInfo->name); ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile </label>
                            <div class="col-md-7">
                                <input type="text" value="<?php echo $voucherInfo->mobile; ?>" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-7">
                                <textarea class="form-control" rows="3" readonly><?php echo $voucherInfo->address; ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Remark </label>
                            <div class="col-md-7">
                                <textarea name="comment" class="form-control" rows="3"><?php echo $voucherInfo->comment; ?></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total </label>
                            <div class="col-md-8">
                                <input type="number" name="total" class="form-control" ng-value="getTotalFn()"
                                       step="any" readonly>
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
                                <input type="number" name="transport_cost" ng-model="transport_cost" placeholder="0" class="form-control" step="any">
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
                                        <input type="number" name="previous_balance" ng-model="partyInfo.balance"
                                               class="form-control" step="any" readonly>
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
                                        <input type="number" name="paid" ng-model="paid" class="form-control" placeholder="0"
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
                                        <input type="number" name="current_balance" ng-value="getCurrentTotalFn()"
                                               class="form-control" step="any" readonly>
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
                                   ng-disabled="validation">
                        </div>
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

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>