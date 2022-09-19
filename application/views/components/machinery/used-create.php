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

<div class="container-fluid" ng-controller="machineryUsedEntryCtrl" ng-cloak>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Used</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array('id' => 'form');
                echo form_open('machinery/used/store', $attr);
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-5">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="created_at" value="<?php echo date("Y-m-d"); ?>"
                                       class="form-control" placeholder="YYYY-MM-DD" required>
                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="selectpicker form-control"
                                    ng-model="productCode"
                                    ng-change="addNewProductFn()"
                                    data-show-subtext="true"
                                    data-live-search="true" required>
                                <option value="" selected disabled>-- Select product --</option>
                                <?php
                                if (!empty($allProducts)) {
                                    foreach ($allProducts as $key => $value) { ?>
                                        <option value="<?php echo $value->code; ?> "><?php echo $value->code . '-' . filter($value->name); ?></option>
                                    <?php }
                                } ?>
                            </select>
                            <span ng-show="erroeMessage" style="color: red;">This product already exists....!</span>
                        </div>
                    </div>
                </div>

                <hr style="margin-top: 5px">

                <input type="hidden" name="godown_code" value="<?php echo $this->data['branch']; ?>">

                <table class="table table-bordered table2">
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th style="width:275px;">Product Name</th>
                        <th width="120px">Unit</th>
                        <th width="80px">Stock</th>
                        <th width="80px">Quantity</th>
                        <th width="100px">Purchase Price (Tk)</th>
                        <th width="100px">Amount (Tk)</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>

                        <td class="td-input">
                            {{ item.product }}
                            <input type="hidden" name="product[]" class="form-control" ng-value="item.product" readonly>
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        </td>

                        <td class="td-input">
                            {{ item.unit }}
                            <input type="hidden" name="unit[]" ng-value="item.unit" class="form-control" readonly>
                        </td>

                        <td class="td-input">
                            {{ item.stock }}
                            <input type="hidden" ng-value="item.stock" class="form-control" readonly>
                        </td>

                        <td>
                            <input type="text" name="quantity[]" class="form-control" ng-model="item.quantity"
                                   ng-required="true" autocomplete="off">
                        </td>

                        <td class="td-input">
                            {{ item.purchase_price }}
                            <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price">
                        </td>

                        <td class="td-input">
                            {{ item.purchase_subtotal }}
                            <input type="hidden" ng-value="purchaseSubtotalFn($index)">
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
                    <div class="col-md-offset-6 col-md-6">

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <p class="p-input"> {{ getTotalQtyFn() }} </p>
                                <input type="hidden" name="total_quantity" ng-value="getTotalQtyFn()"
                                       class="form-control"
                                       step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Amount </label>
                            <div class="col-md-8">
                                <p class="p-input"> {{ getPurchaseTotalFn() }} </p>
                                <input type="hidden" name="total_bill" ng-value="getPurchaseTotalFn()">
                            </div>
                        </div>
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
