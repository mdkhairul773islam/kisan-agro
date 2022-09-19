<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    .table2 tr td {
        padding: 0 !important;
    }

    .table2 tr td input {
        border: 1px solid transparent;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .mb-5 {
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid" ng-controller="editSaleEntryCtrl" ng-cloak>
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Sale</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php echo form_open('sale/edit_sale/update'); ?>

                <div class="row">
                    <div class="col-md-2">
                        <label for="" class="control-label">Date</label>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="sap_at" value="<?= $info->sap_at ?>"
                                       class="form-control" placeholder="YYYY-MM-DD" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label for="" class="control-label">Voucher No</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="voucher_no"
                                   ng-init='voucher_no="<?php echo $info->voucher_no; ?>"' ng-model="voucher_no"
                                   readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="control-label">Product List</label>
                        <div class="form-group">
                            <select class="selectpicker form-control" ng-model="productionId" data-show-subtext="true"
                                    data-live-search="true" ng-change="addNewProductFn(productionId)">
                                <option value="" selected>Select Product</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $row) { ?>
                                        <option value="<?php echo $row->id; ?> "><?php echo $row->batch_no . ' - ' . filter($row->name); ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <hr style="margin-top: 5px">

                <table class="table table-bordered table2" ng-cloak>
                    <tr>
                        <th width="40px">SL</th>
                        <th>Product Name</th>
                        <th width="60px">Unit</th>
                        <th style="width: 70px;">Stock</th>
                        <th style="width: 80px;">Quantity</th>
                        <th style="width: 80px;">Price</th>
                        <th style="width: 80px;">Amount</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="item_id[]" ng-value="item.item_id" readonly>
                        <input type="hidden" name="production_item_id[]" ng-value="item.production_item_id" readonly>
                        <input type="hidden" name="product_name[]" ng-value="item.product_name">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price">
                        <input type="hidden" name="old_quantity[]" ng-value="item.old_quantity">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

                        <td class="td-input">
                            {{ item.product_name | textBeautify }}
                        </td>

                        <td class="td-input">
                            {{ item.unit }}
                            <input type="hidden" name="unit[]" ng-value="item.unit" class="form-control" readonly>
                        </td>

                        <td class="td-input">
                            {{ item.stock_qty }}
                        </td>

                        <td>
                            <input type="number" name="quantity[]" class="form-control" ng-model="item.quantity"
                                   max="{{ item.stock_qty }}" min="0" step="any" placeholder="0">
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0" ng-model="item.sale_price" step="any">
                        </td>

                        <td class="td-input">
                            {{ item.subtotal }}
                            <input type="hidden" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                        </td>

                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <hr>

                <span ng-repeat="row in deleteCart">
                    <input type="hidden" name="delete_item_id[]" ng-value="row.item_id">
                    <input type="hidden" name="delete_production_item_id[]" ng-value="row.production_item_id">
                    <input type="hidden" name="delete_product_code[]" ng-value="row.product_code">
                    <input type="hidden" name="delete_quantity[]" ng-value="row.quantity">
                </span>

                <div class="row form-horizontal" ng-cloak>
                    <div class="col-md-6">

                        <input type="hidden" name="sap_type" ng-init="sap_type='<?= $info->sap_type ?>'" ng-value="sap_type">
                        <input type="hidden" name="party_code" ng-init="party_code='<?= $partyInfo->code ?>'" ng-value="party_code">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Name </label>
                            <div class="col-md-9">
                                <input type="text" name="c_name" value="<?php echo $partyInfo->name; ?>"
                                       placeholder="Name"
                                       class="form-control" <?php echo($info->sap_type == 'credit' ? 'readonly' : ''); ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile </label>
                            <div class="col-md-9">
                                <input type="text" name="c_mobile" value="<?php echo $partyInfo->mobile; ?>"
                                       placeholder="Mobile number"
                                       class="form-control" <?php echo($info->sap_type == 'credit' ? 'readonly' : ''); ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <textarea name="c_address" placeholder="Address"
                                          class="form-control" <?php echo($info->sap_type == 'credit' ? 'readonly' : ''); ?>><?php echo $partyInfo->address; ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <p class="p-input">{{ totalQuantity }}</p>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity"
                                       class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Sub Total</label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getTotalFn() }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Discount</label>
                            <div class="col-md-8">
                                <input type="text" name="total_discount" ng-init="totalDiscount=<?= $info->total_discount ?>" ng-model="totalDiscount" class="form-control"
                                       placeholder="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Grand Total</label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getGrandTotalFn() }}</p>
                                <input type="hidden" name="total_bill" ng-value="getGrandTotalFn()" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="p-input"><?php echo abs($partyInfo->balance); ?></p>
                                        <input type="hidden" name="previous_balance" ng-init="previous_balance=<?= $partyInfo->balance ?>" ng-value="previous_balance">
                                    </div>

                                    <div class="col-md-5">
                                        <p class="p-input"><?php echo $partyInfo->sign; ?></p>
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
                                               step="any">
                                    </div>

                                    <div class="col-md-5">
                                        <select name="method"
                                                class="form-control ng-valid ng-not-empty ng-valid-required ng-dirty ng-valid-parse ng-touched"
                                                ng-init="transactionBy='<?= $info->method ?>'" ng-model="transactionBy" required="">
                                            <option value="cash">Cash</option>
                                            <option value="bKash">bKash</option>
                                            <option value="rocket">Rocket</option>
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
                                        <p class="p-input"> {{ getCurrentTotalFn() }} </p>
                                        <input type="hidden" name="current_balance" ng-value="getCurrentTotalFn()"
                                               class="form-control" step="any" readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <p class="p-input"> {{csign}} </p>
                                        <input type="hidden" name="current_sign" ng-value="csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 text-right">
                        <div class="btn-group">
                            <input type="submit" name="update" value="Update" ng-disabled="isDisabled" class="btn btn-primary"
                                   style="margin-right: 15px">
                        </div>
                    </div>

                </div>

                <div class="btn-group pull-right">
                    <p ng-bind="message" style="font-weight:bold;color:red;font-size:18px;"></p>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>