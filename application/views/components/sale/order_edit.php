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

<div class="container-fluid" ng-controller="OrderEditCtrl" ng-cloak>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Order</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                echo $this->session->flashdata('confirmation');
                echo form_open($form_action, ['id' => 'form']);
                ?>

                <input type="hidden" ng-init="stockType='<?php echo $stockType; ?>'" ng-model="stockType" ng-value="stockType" readonly>

                <div class="row">
                    <div class="col-md-3">
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

                    <?php /*
                        <div class="col-md-3">
                            <div class="form-group mb-5">
                                <select ng-model="order_time" class="form-control">
                                    <option value="" selected disabled>-- Production Time --</option>
                                    <?php
                                    $order_times = config_item('order_time');
                                    if (!empty($order_times)){
                                        foreach ($order_times as $value){
                                            echo '<option value="'. $value .'">'. filter($value) .'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    */?>

                    <div class="col-md-3">
                        <div class="form-group mb-5">
                            <input type="text" name="voucher_no" ng-init='info.vno="<?php echo $voucherNo; ?>"' ng-model="info.vno" ng-value="info.vno" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-5">
                            <p class="p-input">{{ partyInfo.name }}</p>
                            <input type="hidden" name="party_code" ng-value="party_code" readonly>
                            <input type="hidden" name="godown_code" ng-value="godown_code" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="selectpicker form-control" ng-init="showroom_id='<?php echo $branch; ?>'"
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
                        <th width="40px">P.ID</th>
                        <th width="275px">Product Name</th>
                        <th width="60">P.Type</th>
                        <!--<th width="100">Order Time</th>-->
                        <th width="60px">Unit</th>
                        <th width="60px">S.Type</th>
                        <th width="80px">Quantity</th>
                        <th width="100px">Weight (Kg)</th>
                        <th width="80px">Sale Price (Tk)</th>
                        <th width="120px">Amount (Tk)</th>
                        <th width="80px">Status</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        
                        <td class="td-input">
                            {{ item.product_code }}
                        </td>

                        <td class="td-input">
                            {{ item.product_name | textBeautify }}
                            <input type="hidden" name="id[]" ng-value="item.id" readonly>
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                            <input type="hidden" name="product_type[]" ng-value="item.product_type">
                            <!--<input type="hidden" name="order_time[]" ng-value="item.order_time">-->
                            <input type="hidden" name="unit[]" ng-value="item.unit">
                            <input type="hidden" name="stock_type[]" ng-value="item.stock_type">
                        </td>

                        <td class="td-input">
                            {{ item.product_type | textBeautify }}
                        </td>
                        <!--<td class="td-input">
                            {{ item.order_time | textBeautify }}
                        </td>-->

                        <td class="td-input">
                            {{ item.unit }}
                        </td>

                        <td class="td-input">
                            {{ item.stock_type }}
                        </td>

                        <td>
                            <input type="text" name="quantity[]" class="form-control" ng-model="item.quantity" autocomplete="off">
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

                        <td class="td-input">
                            {{ item.status | textBeautify }}
                            <input type="hidden" name="status[]" ng-value="item.status">
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
                                    <input type="text" name="total_discount"  ng-model="totalDiscount" class="form-control" step="any">
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
                    </div>
                </div>

                <div class="btn-group pull-right">
                    <input type="submit" name="update" value="Update" class="btn btn-success">
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