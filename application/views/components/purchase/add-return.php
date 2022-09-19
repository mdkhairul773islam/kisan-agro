<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<style>
    .table2 tr td {padding: 0 !important;}
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

<div class="container-fluid" ng-controller="addPurchaseReturn">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Return Product</h1>
                </div>
            </div>
            
            <div class="panel-body" ng-cloak>
                <?php
                    $attr = array('class' => 'form-horizontal', 'id' => 'form');
                    echo form_open('purchase/purchase_return/store', $attr);
                ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="created_at" value="<?php echo date("Y-m-d"); ?>" class="form-control" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select name="party_code" ng-model="partyCode" ng-change="findPartyFn(partyCode)" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" ng-required="true">
                            <option value="" selected>Select client</option>
                            <?php
                            if (!empty($allClients)) {
                                foreach ($allClients as $row) {
                                    ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->code . '-' . filter($row->name) . " ( " . $row->address . " ) "; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select ng-model="productCode" class="selectpicker form-control" ng-change="addNewProductFn(productCode)" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>Select Product</option>
                            <?php if (!empty($allproducts)) {
                                foreach ($allproducts as $key => $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->code . '-' . filter($row->name); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                        <span ng-if="active" ng-model="active" style="color: red;">This product already exists.</span>
                    </div>
                </div>
                <hr>

                <table class="table table-bordered table2" ng-cloak>
                    <tr>
                        <th width="5%">SL</th>
                        <th width="35%">Product Name</th>
                        <th width="8%">Unit</th>
                        <th width="8%">Stock</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">P.Price (Tk)</th>
                        <th width="12%">Amount (Tk)</th>
                        <th width="3%">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td class="td-input">{{ $index + 1 }}</td>

                        <td class="td-input">
                            {{ item.product_name | textBeautify }}
                            <input type="hidden" name="id[]" ng-value="item.id">
                            <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        </td>

                        <td class="td-input">
                            {{ item.unit }}
                            <input type="hidden" name="unit[]" ng-value="item.unit" class="form-control" readonly>
                        </td>

                        <td class="td-input">
                            {{ item.stock_qty }}
                            <input type="hidden" name="stock_qty[]" class="form-control" min="1" ng-value="item.stock_qty" autocomplete="off">
                        </td>

                        <td>
                            <input type="text" name="quantity[]" class="form-control" ng-model="item.quantity" max="{{ item.stock_qty }}" placeholder="0" autocomplete="off" ng-required="true">
                        </td>

                        <td>
                            <input type="text" name="purchase_price[]" ng-model="item.purchase_price" class="form-control" >
                            <input type="hidden" name="sale_price[]" class="form-control" min="0"
                                   ng-value="item.sale_price" step="any">
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
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Mobile </label>
                            <div class="col-md-9">
                                <p class="p-input">{{partyInfo.mobile}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address </label>
                            <div class="col-md-9">
                                <p class="p-textarea">{{ partyInfo.address }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Remarks </label>
                            <div class="col-md-9">
                                <textarea name="remark" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Specification </label>
                            <div class="col-md-9">   
                                <textarea name="specification" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <p class="p-input">{{ totalQuantity }}</p>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Return Amount </label>
                            <div class="col-md-8">
                                <p class="p-input">{{ getTotalFn() }}</p>
                                <input type="hidden" name="total_bill" ng-value="getTotalFn()" class="form-control" step="any" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="p-input">{{ partyInfo.balance }}</p>
                                        <input type="hidden" name="previous_balance" ng-value="partyInfo.previous_balance">
                                    </div>
                                    <div class="col-md-5">
                                        <p class="p-input">{{ partyInfo.sign }}</p>
                                        <input type="hidden" name="previous_sign" ng-value="partyInfo.sign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="p-input">{{ getCurrentTotalFn() }}</p>
                                        <input type="hidden" name="current_balance" ng-value="getCurrentTotalFn()" class="form-control" step="any" readonly>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="p-input">{{ partyInfo.csign }}</p>
                                        <input type="hidden" name="current_sign" ng-value="partyInfo.csign" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <input type="submit" name="return" value="Save" class="btn btn-primary">
                        </div>
                    </div>
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
