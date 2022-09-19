<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

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
</style>

<div class="container-fluid" ng-controller="saleEntryCtrl" ng-cloak>
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1>Add New Sale</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>

                <!-- horizontal form -->
                <?php
                $attr = array('id' => 'form');
                echo form_open('sale/sale/store', $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="sap_at" value="<?php echo date("Y-m-d"); ?>"
                                       class="form-control" placeholder="YYYY-MM-DD" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
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
                <hr style="margin-top: 0px;">

                <table class="table table-bordered table2" ng-cloak>
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Product Name</th>
                        <th style="width: 60px;">Unit</th>
                        <th style="width: 70px;">Stock</th>
                        <th style="width: 80px;">Quantity</th>
                        <th style="width: 80px;">Price</th>
                        <th style="width: 80px;">Amount</th>
                        <th style="width: 50px;">Action</th>
                    </tr>
                    <tr ng-repeat="item in cart">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="production_item_id[]" ng-value="item.production_item_id">
                        <input type="hidden" name="unit[]" ng-value="item.unit">
                        <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td class="td-input">
                            {{ item.product_name | textBeautify }}
                        </td>
                        <td class="td-input">{{ item.unit }}</td>
                        <td class="td-input">{{ item.stock_qty }}</td>
                        <td>
                            <input type="text" name="quantity[]" class="form-control" ng-model="item.quantity"
                                   max="{{ item.stock_qty }}" autocomplete="off" placeholder="0">
                        </td>
                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price" step="any">
                        </td>
                        <td class="td-input">
                            {{ item.subtotal }}
                            <input type="hidden" name="subtotal[]" class="form-control" ng-value="setSubtotalFn($index)"
                                   readonly>
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
                            <div class="col-md-offset-3 col-md-9">
                                <span class="btn" ng-class="cashBtn" ng-click="setSaleType('cash')">Retail Sale</span>
                                <span class="btn" ng-class="creditBtn" ng-click="setSaleType('credit')">Dealer Sale</span>
                                <input type="hidden" name="sap_type" ng-value="sap_type">
                            </div>
                        </div>

                        <!-- cash Client -->
                        <div ng-show="sap_type=='cash'">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name </label>
                                <div class="col-md-9">
                                    <input type="text" name="c_name" placeholder="Name" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile </label>
                                <div class="col-md-9">
                                    <input type="text" name="c_mobile" placeholder="Mobile number" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Address </label>
                                <div class="col-md-9">
                                    <textarea name="c_address" placeholder="Address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>


                        <!-- Client List -->
                        <div ng-show="sap_type=='credit'">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Client</label>
                                <div class="col-md-9">
                                    <select name="party_code" ng-model="party_code" ng-change="findPartyFn(party_code)"
                                            class="selectpicker form-control" data-show-subtext="true"
                                            data-live-search="true">
                                        <option value="" selected>Select client</option>
                                        <?php
                                        if (!empty($clientList)) {
                                            foreach ($clientList as $key => $row) {
                                                ?>
                                                <option value="<?php echo $row->code; ?>">
                                                    <?php echo $row->code . '-' . filter($row->name) . " ( " . $row->address . " ) "; ?>
                                                </option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Mobile </label>
                                <div class="col-md-9">
                                    <input type="text" name="mobile" ng-value="partyInfo.mobile" class="form-control"
                                           readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Address </label>
                                <div class="col-md-9">
                                    <p class="p-textarea">{{ partyInfo.address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Total Quantity </label>
                            <div class="col-md-8">
                                <p class="p-input">{{ totalQuantity }}</p>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity" class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Sub Total</label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getTotalFn() }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Discount </label>
                            <div class="col-md-8">
                                <input type="number" name="total_discount" min="0" ng-model="totalDiscount"
                                       class="form-control" step="any" placeholder="0">
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
                                        <p class="p-input">{{ partyInfo.balance }}</p>
                                        <input type="hidden" name="previous_balance"
                                               ng-value="partyInfo.previous_balance" class="form-control" step="any"
                                               readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <p class="p-input">{{ partyInfo.sign }}</p>
                                        <input type="hidden" name="previous_sign" ng-value="partyInfo.sign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid <span class="req">*</span></label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="payment" placeholder="0"
                                               class="form-control" step="any">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control" ng-init="transactionBy='cash'"
                                                ng-model="transactionBy" required>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- for selecting cheque -->
                        <div ng-if="transactionBy == 'cheque'">
                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Bank Name <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <select name="meta[bankname]" class="form-control">
                                        <option value="" selected disabled>&nbsp;</option>
                                        <?php foreach (config_item("banks") as $key => $value) { ?>
                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Branch Name <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" name="meta[branchname]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Cheque No <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" name="meta[chequeno]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">
                                    Pass Date <span class="req">*</span>
                                </label>

                                <div class="col-md-8">
                                    <input type="text" name="meta[passdate]" placeholder="YYYY-MM-DD"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="p-input"> {{ getCurrentTotalFn() }} </p>
                                        <input type="hidden" name="current_balance"
                                               ng-value="partyInfo.current_balance">
                                    </div>

                                    <div class="col-md-5">
                                        <p class="p-input"> {{partyInfo.csign}} </p>
                                        <input type="hidden" name="current_sign" ng-value="partyInfo.csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="save" value="Save" class="btn btn-primary" ng-init="isDisabled=false;"
                           ng-hide="isDisabled">
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

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
