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

<div class="container-fluid" ng-controller="orderEditCtrl">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Order</h1>
                </div>
            </div>

            <div class="panel-body">

                <!-- horizontal form -->
                <?php
                $attr = array("id" => "form");
                echo form_open('purchase/order/update', $attr);
                ?>

                <div class="row">
                    <div class="col-md-2">
                        <label class="control-label">Date</label>
                        <div class="form-group">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="created" class="form-control"
                                       value="<?php echo $info->created; ?>"
                                       placeholder="Date" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label class="control-label">Voucher No</label>
                        <div class="form-group">
                            <input type="text" name="voucher_no" ng-init="voucherNo='<?= $info->voucher_no ?>'"
                                   ng-value="voucherNo" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="control-label">PR No</label>
                        <div class="form-group">
                            <input type="text" name="pr_no" value="<?= $info->pr_no ?>" class="form-control"  placeholder="PR NO">
                        </div>
                    </div>  

                    <div class="col-md-3">
                        <label class="control-label">Supplier Name</label>
                        <div class="form-group">
                            <input type="text"
                                   value="<?php echo $info->party_code . '-' . $info->name . ' (' . $info->address . ') '; ?>"
                                   class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="control-label">Product List</label>
                        <div class="form-group">
                            <select ng-model="productCode" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true" ng-change="addNewProductFn(productCode)">
                                <option value="" selected>Raw Material</option>
                                <?php if (!empty($productList)) {
                                    foreach ($productList as $key => $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo $row->code . '-' . filter($row->name); ?>
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
                        <th class="th-width">Qty.</th>
                        <th style="width: 133px;">P.Price</th>
                        <th class="th-width">Amount</th>
                        <th width="50px">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">

                        <input type="hidden" name="product_code[]" ng-value="item.code">
                        <input type="hidden" name="item_id[]" ng-value="item.item_id">

                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" name="product[]" class="form-control" ng-model="item.product" readonly>

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

                <span ng-repeat="row in deleteItem">
                    <input type="hidden" name="delete_id[]" ng-value="row.id">
                    <input type="hidden" name="delete_code[]" ng-value="row.code">
                    <input type="hidden" name="delete_quantity[]" ng-value="row.quantity">
                </span>

                <div class="row form-horizontal">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks </label>
                            <div class="col-md-8">
                                <textarea name="remarks" class="form-control"><?php echo $info->remarks; ?></textarea>
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
                            <label class="col-md-4 control-label">Total Bill </label>
                            <div class="col-md-8">
                                <input type="number" name="total_bill" ng-value="getTotalFn()"
                                       class="form-control" step="any" min="0" readonly>
                            </div>
                        </div>

                        <div class="btn-group pull-right">
                            <input type="submit" name="update" value="Update" class="btn btn-primary"
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