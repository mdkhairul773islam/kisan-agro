<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

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

<div class="container-fluid" ng-controller="challanEntryCtrl" ng-cloak>
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1>Create Challan</h1>
                </div>
            </div>

            <div class="panel-body" ng-cloak>

                <!-- horizontal form -->
                <?php
                $attr = array('id' => 'form');
                echo form_open('sale/challan/store', $attr);
                ?>

                <input type="hidden" name="party_code" value="<?php echo $info->party_code; ?>">

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="created" value="<?php echo $info->sap_at; ?>"
                                       class="form-control" placeholder="YYYY-MM-DD" required>
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
                </div>
                <hr style="margin-top: 0px;">

                <table class="table table-bordered table2" ng-cloak>
                    <tr>
                        <th style="width: 40px;">SL</th>
                        <th>Product Name</th>
                        <th style="width: 60px;">Unit</th>
                        <th style="width: 80px;">Qty.</th>
                        <th style="width: 80px;">Price</th>
                        <th style="width: 80px;">Amount</th>
                        <th style="width: 50px;">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <input type="hidden" name="item_id[]" ng-value="item.item_id">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td class="td-input">
                            {{ item.product_name }}
                        </td>
                        <td class="td-input">{{ item.unit }}</td>
                        <td>
                            <input type="number" name="quantity[]" class="form-control" ng-model="item.quantity"
                                   max="{{ item.stock_qty }}" autocomplete="off" placeholder="0">
                        </td>
                        <td>
                            <input type="text" name="sale_price[]" class="form-control" min="0"
                                   ng-model="item.sale_price" step="any" readonly>
                        </td>
                        <td>
                            <input type="text" name="subtotal[]" class="form-control" ng-value="setSubtotalFn($index)"
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
                            <label class="col-md-3 control-label">Transport Name</label>
                            <div class="col-md-9">
                                <select name="transport_id" class="selectpicker form-control" data-show-subtext="true"
                                        data-live-search="true" ng-model="transportId"
                                        ng-change="getTransportInfo(transportId)" required>
                                    <option value="" selected>Select Transport</option>
                                    <?php
                                    if (!empty($transportList)) {
                                        foreach ($transportList as $key => $row) { ?>
                                            <option value="<?php echo $row->id; ?>">
                                                <?php echo $row->company_name; ?>
                                            </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Manager Name </label>
                            <div class="col-md-9">
                                <input type="text" ng-value="name" class="form-control"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile </label>
                            <div class="col-md-9">
                                <input type="text" ng-value="mobile" class="form-control"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="4" readonly>{{address}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Remarks </label>
                            <div class="col-md-9">
                                <textarea name="remarks" rows="4" class="form-control"></textarea>
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
                            <label class="col-md-4 control-label">Total Amount</label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getTotalFn() }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Driver Name</label>
                            <div class="col-md-8">
                                <input type="text" name="driver_name" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Driver Mobile</label>
                            <div class="col-md-8">
                                <input type="text" name="driver_mobile" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Driver Address</label>
                            <div class="col-md-8">
                                <textarea name="driver_address" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Vehicle No</label>
                            <div class="col-md-8">
                                <input type="text" name="vehicle_no" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Engine No</label>
                            <div class="col-md-8">
                                <input type="text" name="engine_no" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Chassis No</label>
                            <div class="col-md-8">
                                <input type="text" name="chassis_no" class="form-control" autocomplete="off">
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
