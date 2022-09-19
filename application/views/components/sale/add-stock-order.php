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

<div class="container-fluid" ng-controller="OrderEntryCtrl" ng-cloak>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Factory Order</h1>
                </div>
                <div class="panal-header-title pull-left">
                    <p style="color: red;font-weight:bold; margin-left: 25px;">
                        <?php if (!empty($last_voucher)) {
                            echo "Last voucher: " . $last_voucher[0]->voucher_no;
                        } ?>
                    </p>
                </div>
            </div>

            <div class="panel-body" ng-cloak>

                <!-- horizontal form -->
                <?php
                $attr = array('id' => 'form');
                echo form_open('sale/factory_order/storeOrder', $attr);
                ?>

                <input type="hidden" ng-init="stockType='order'" ng-model="stockType" ng-value="stockType">

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-5">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="sap_at" value="<?php echo date("Y-m-d"); ?>"
                                       class="form-control" placeholder="YYYY-MM-DD" required>
                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select ng-model="order_time" class="form-control" required>
                                <option value="" selected disabled>-- Production Time --</option>
                                <?php
                                $order_times = config_item('order_time');
                                if (!empty($order_times)) {
                                    foreach ($order_times as $value) {
                                        echo '<option value="' . $value . '">' . filter($value) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="party_code"
                                    ng-model="partyCode"
                                    ng-change="findPartyFn()"
                                    class="selectpicker form-control"
                                    data-show-subtext="true"
                                    data-live-search="true"
                                    ng-required="true">
                                <option value="" selected disabled>-- Select client --</option>

                                <?php
                                if (!empty($allClients)) {
                                    foreach ($allClients as $key => $row) {
                                        ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo $row->code . '-' . filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="selectpicker form-control" ng-init="showroom_id='<?php echo $branch; ?>'"
                                    ng-model="productCode" ng-change="addNewProductFn()" data-show-subtext="true"
                                    data-live-search="true" required>
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

                <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width:40px;">P.ID</th>
                        <th style="width:275px;">Product Name</th>
                        <th width="80">P.Type</th>
                        <th width="100">Order Time</th>
                        <th width="80">Unit</th>
                        <th width="80">S.Type</th>
                        <th width="80">Quantity</th>
                        <th width="120">Weight (Kg)</th>
                        <th width="100">Sale Price (Tk)</th>
                        <th width="100">Amount (Tk)</th>
                        <th width="50">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td class="td-input">
                            {{ item.product_code }}
                        </td>

                        <td class="td-input">
                            {{ item.product }}
                            <input type="hidden" name="product[]" class="form-control" ng-value="item.product" readonly>
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="product_type[]" ng-value="item.product_type">
                            <input type="hidden" name="order_time[]" ng-value="item.order_time">
                            <input type="hidden" name="stock_type[]" ng-value="item.stock_type">
                            <input type="hidden" name="unit[]" ng-value="item.unit">
                            <input type="hidden" name="status[]" ng-value="item.status">
                        </td>

                        <td class="td-input">
                            {{ item.product_type }}
                        </td>

                        <td class="td-input">
                            {{ item.order_time | textBeautify }}
                        </td>

                        <td class="td-input">
                            {{ item.unit }}
                        </td>

                        <td class="td-input">
                            {{ item.stock_type  }}
                        </td>

                        <td>
                            <input type="text" name="quantity[]" class="form-control" ng-model="item.quantity"
                                   ng-required="true" autocomplete="off">
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

                <div class="row form-horizontal">
                    <div class="col-md-6">
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
                                <p class="p-input"> {{ partyInfo.contact }} </p>
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
                                <div class="input-group">
                                    <p class="p-input"> {{ getTotalQtyFn() }} </p>
                                    <input type="hidden" name="total_quantity" ng-value="getTotalQtyFn()"
                                           class="form-control"
                                           step="any" readonly>
                                    <span class="input-group-addon">Pc</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Weight </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="number"  ng-value="totalWeight"
                                           class="form-control"
                                           step="any" readonly>
                                    <span class="input-group-addon">Kg</span>
                                </div>
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
                            <label class="col-md-4 control-label"> Total Amount </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <p class="p-input"> {{ getTotalFn() }} </p>
                                    <input type="hidden" name="total" ng-value="getTotalFn()" class="form-control"
                                           step="any" readonly>
                                    <input type="hidden" name="purchase_total" ng-value="getPurchaseTotalFn()"
                                           class="form-control" readonly>
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                        </div>

                        <!--<div class="form-group">
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
                        </div>-->
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input
                            type="submit"
                            name="save"
                            value="Save"
                            class="btn btn-primary"
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


    /*function formValidates(){
        let form_submit_btn = document.querySelector("#form_submit_btn");
        form_submit_btn.style.pointerEvent = "none";
        form_submit_btn.value = "Submitted...";
    }*/
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
