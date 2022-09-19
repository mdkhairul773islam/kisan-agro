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
</style>

<div class="container-fluid" ng-controller="multiSaleReturn">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add Return Product</h1>
                </div>
            </div>


            <div class="panel-body" ng-cloak>
                <!-- horizontal form -->
                <?php
                $attr = array('class' => 'form-horizontal', 'id' => 'form');
                echo form_open('sale/multiSaleReturn/store', $attr);
                ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="created_at" value="<?php echo date("Y-m-d"); ?>"
                                   class="form-control" placeholder="YYYY-MM-DD" required>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select ng-model="product_code" class="selectpicker form-control"
                                ng-change="addNewProductFn(product_code)"
                                data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>-- Select Product --</option>
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
                        <th width="10%">Price</th>
                        <th width="12%">Amount</th>
                        <th width="3%">Action</th>
                    </tr>

                    <tr ng-repeat="item in cart">
                        <input type="hidden" name="product_code[]" ng-value="item.product_code">
                        <input type="hidden" name="purchase_price[]" ng-value="item.purchase_price">

                        <td class="td-input">{{ $index + 1 }}</td>

                        <td class="td-input">
                            {{ item.product_name | textBeautify }}

                        </td>

                        <td class="td-input">
                            {{ item.unit }}

                        </td>

                        <td class="td-input">
                            {{ item.stock_qty }}
                            <input type="hidden" name="stock_qty[]" class="form-control" min="1"
                                   ng-value="item.stock_qty" autocomplete="off">
                        </td>

                        <td>
                            <input type="text" name="quantity[]" class="form-control" ng-model="item.quantity" placeholder="0"
                                   max="{{ item.stock_qty }}" autocomplete="off" ng-required="true">
                        </td>

                        <td>
                            <input type="text" name="sale_price[]" class="form-control" min="0" ng-model="item.sale_price" step="any">
                        </td>

                        <td class="td-input">
                            {{ item.subtotal }}
                            <input type="hidden" name="subtotal[]" class="form-control" ng-value="setSubtotalFn($index)">
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
                            <div class="col-md-offset-3 col-md-9">
                                <span class="btn" ng-class="cashBtn" ng-click="setSaleType('cash')">Cash Sale</span>
                                <span class="btn" ng-class="creditBtn"
                                      ng-click="setSaleType('credit')">Credit Sale</span>
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
                                    <select name="party_code" class="selectpicker form-control" data-show-subtext="true"
                                            data-live-search="true" name="party_code" ng-model="party_code" ng-change="findPartyFn(party_code)">
                                        <option value="" selected>Select Client</option>
                                        <?php
                                        if (!empty($allClients)) {
                                            foreach ($allClients as $key => $client) { ?>
                                                <option value="<?php echo $client->code; ?>">
                                                    <?php echo $client->code . ' - ' . filter($client->name) . " ( " . $client->address . " ) "; ?>
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
                            <label class="col-md-4 control-label"> Total Quantity </label>
                            <div class="col-md-8">
                                <p class="p-input">{{ totalQuantity }}</p>
                                <input type="hidden" name="total_quantity" ng-value="totalQuantity"
                                       class="form-control"
                                       step="any" readonly>
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
                                        <input type="hidden" name="previous_sign" ng-value="partyInfo.sign">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--<div class="form-group" ng-show="sap_type=='cash'">
                            <label class="col-md-4 control-label">Paid</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <input type="number" name="paid" ng-model="payment" class="form-control" step="any" placeholder="0">
                                    </div>
                                    <div class="col-md-5">
                                        <select name="method" class="form-control" ng-init="paymentMetod='cash'" ng-model="paymentMetod" required>
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="bKash">bKash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <label class="col-md-4 control-label">Current Balance </label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="p-input">{{ getCurrentTotalFn() }}</p>
                                        <input type="hidden" name="current_balance" ng-value="partyInfo.current_balance">
                                    </div>

                                    <div class="col-md-5">
                                        <p class="p-input">{{ partyInfo.csign }}</p>
                                        <input type="hidden" name="current_sign" ng-value="partyInfo.csign">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <input type="submit" name="save" value="Save" ng-disabled="isDisable" class="btn btn-primary">
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
