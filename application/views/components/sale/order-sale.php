<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

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
    .mb-5{
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid" ng-controller="OrderSaleCtrl" ng-cloak>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Order Sale</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                echo $this->session->flashdata('confirmation');

                $attr = array('id' => 'form');
                echo form_open($form_action, $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-5">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="sap_at" value="{{ createAt }}"
                                    class="form-control" placeholder="YYYY-MM-DD" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" class="form-control" name="voucher_no" ng-init='info.vno="<?= $voucherNo; ?>"' ng-model="info.vno" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="selectpicker form-control"
                                    ng-model="productCode" ng-change="addNewProductFn()" data-show-subtext="true"
                                    data-live-search="true">
                                <option value="" selected disabled>-- Select product --</option>
                                <?php
                                if (!empty($allProducts)) {
                                    foreach ($allProducts as $key => $value) { ?>
                                        <option value="<?php echo $value->code; ?> "><?php echo $value->code . '-' . filter($value->name); ?></option>
                                    <?php }
                                } ?>
                            </select>
                            <span ng-show="erroeMessage" style="color: red">This product already exists....!</span>
                        </div>
                    </div>

                </div>

                <hr style="margin-top: 5px">

                <table class="table table-bordered table2" ng-cloak>
                    <tr>
                        <th width="40px">SL</th>
                        <th width="275px">Product Name</th>
                        <th width="60px">P.Type</th>
                        <th width="60px">Unit</th>
                        <th width="60px">S.Type</th>
                        <th width="60px">Stock</th>
                        <th width="80px">Quantity</th>
                        <th width="100px">Weight (Kg)</th>
                        <th width="80px">Sale Price (Tk)</th>
                        <th width="120px">Amount (Tk)</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

                        <td class="td-input">
                            {{ item.product_name | textBeautify }}
                            <input type="hidden" name="id[]" ng-value="item.id" readonly>
                            <input type="hidden" name="product_name[]" ng-value="item.product_name">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="product_type[]" ng-value="item.product_type">
                            <input type="hidden" name="order_time[]" ng-value="item.order_time" readonly>
                            <input type="hidden" name="stock_type[]" ng-value="item.stock_type">
                            <input type="hidden" name="unit[]" ng-value="item.unit">
                            <input type="hidden" name="stock_qty[]" ng-value="item.stock_qty">
                            <input type="hidden" name="status[]" ng-value="item.status">
                        </td>
                        <td class="td-input">
                            {{ item.product_type }}
                        </td>

                        <td class="td-input">
                            {{ item.unit }}
                        </td>


                        <td class="td-input">
                            {{ item.stock_type }}
                        </td>

                        <td class="td-input">
                            {{ item.stock_qty }}
                        </td>

                        <td>
                            <input type="hidden" name="old_qty[]" ng-value="item.old_qty" readonly>
                            <input type="number" name="quantity[]" class="form-control" ng-model="item.quantity" autocomplete="off" step="any">
                        </td>

                        <td class="td-input">
                            {{ item.weight }}
                            <input type="hidden" class="form-control" name="weight[]" ng-value="item.weight" readonly>
                            <input type="hidden" name="total_weight[]" ng-value="calculateWeight($index)">
                        </td>

                        <td>
                            <input type="number" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price" step="any">
                            <input type="hidden" name="purchase_price[]" min="0" ng-value="item.purchase_price"
                                   step="any">
                        </td>

                        <td class="td-input">
                            {{ item.subtotal }}
                            <input type="hidden" class="form-control" ng-value="setSubtotalFn($index)" readonly>
                            <input type="hidden" ng-value="purchaseSubtotalFn($index)" step="any">
                        </td>

                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>

                <hr>

                <div class="row form-horizontal" ng-cloak>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Client Name</label>
                            <div class="col-md-9">
                                <p class="p-input">{{ partyInfo.name }}</p>
                                <input type="hidden" name="party_code" ng-value="party_code" readonly>
                                <input type="hidden" name="godown_code" ng-value="godown_code" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Client Type</label>
                            <div class="col-md-9">
                                <p class="p-input"> {{partyInfo.client_type | textBeautify}} </p>
                                <input type="hidden" name="client_type" ng-value="partyInfo.client_type">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile </label>
                            <div class="col-md-9">
                                <p class="p-input"> {{partyInfo.contact}} </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <p class="p-textarea"> {{ partyInfo.address }} </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getTotalQtyFn() }}</p>
                                <input type="hidden" name="total_quantity" ng-value="getTotalQtyFn()"
                                    class="form-control" step="any" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Discount </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" name="total_discount" ng-model="totalDiscount" class="form-control" step="any">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Sub Total</label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getTotalFn() }}</p>
                                <input type="hidden" name="total" ng-value="getTotalFn()" class="form-control"
                                    step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="p-input"> {{ partyInfo.balance }} </p>

                                        <input type="hidden" name="previous_balance" ng-value="partyInfo.balance"
                                               class="form-control" step="any" readonly>
                                    </div>

                                    <div class="col-md-5">
                                        <p class="p-input"> {{ partyInfo.sign }} </p>

                                        <input type="hidden" name="previous_sign" ng-value="partyInfo.sign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Paid Amount</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="amount.paid" placeholder="0" class="form-control" step="any">
                                    </div>

                                    <div class="col-md-5">
                                        <select name="method" class="form-control ng-valid ng-not-empty ng-valid-required ng-dirty ng-valid-parse ng-touched" ng-init="transactionBy='cash'" ng-model="transactionBy" required="">
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
                                        <p class="p-input"> {{partyInfo.csign}} </p>
                                        <input type="hidden" name="current_sign" ng-value="partyInfo.csign"
                                               class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 text-right">
                        <div class="btn-group">
                            <?php
                            $stock_status = get_result('sapitems', ['voucher_no' => $voucherNo], 'stock_type', 'stock_type');

                            if (count($stock_status) != 1){ ?>
                                <input type="submit" name="sale" value="Sale" class="btn btn-success">
                                <input type="submit" name="stock" value="Add Stock" class="btn btn-primary">
                            <?php }else{
                                if (!empty($stock_status) && $stock_status[0]->stock_type == 'stock'){
                                    echo '<input type="submit" name="sale" value="Sale" class="btn btn-success">';
                                }else{
                                    echo '<input type="submit" name="stock" value="Add Stock" class="btn btn-primary">';
                                }
                            } ?>
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

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>