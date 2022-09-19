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

<div class="container-fluid" ng-controller="editRecipeCtrl">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Recipe</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("recipe/recipe/edit/$recipeInfo->voucher_no", $attr);
                ?>

                <div class="row new-row-1">
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="created" class="form-control" value="<?php echo $recipeInfo->created; ?>"
                                   placeholder="Date" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type="text"  class="form-control" value="<?php echo filter($recipeInfo->category_name); ?>" readonly>
                        <input type="hidden" name="category_code" class="form-control" ng-init="category_code = '<?php echo $recipeInfo->category_code; ?>'" ng-model="category_code" value="<?= $recipeInfo->category_code ?>" required>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="flour" class="form-control"
                               ng-model="flower"
                               ng-init="flower = '<?php echo $recipeInfo->flour; ?>'"
                               ng-value="flower"
                               placeholder="Flour in kg"
                               required>
                        <input type="hidden" name="old_flour" value="<?php echo $recipeInfo->flour; ?>">
                    </div>
                </div>
                <hr>

                <input type="hidden" value="<?php echo $recipeInfo->voucher_no; ?>" name="voucher_no">

                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Material</th>
                        <!--<th>Price</th>-->
                        <th>Unit</th>
                        <th>Stock</th>
                        <th>Ration (%)</th>
                        <th>Required Raw Materials for 1 khamir (in kg)</th>
                        <!--<th>Total Costing (in Tk)</th>
                        <th>Wastage (%)</th>
                        <th>Total Wastage (in kg)</th>
                        <th>Total production (in kg)</th>-->
                    </tr>

                    <tr ng-repeat="item in cart">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td>
                            <input type="text" value="{{ item.product }}" class="form-control" readonly>
                            <input type="hidden" name="product_code[]" value="{{ item.product_code }}">
                        </td>

                        <input type="hidden" name="purchase_price[]" class="form-control" min="0"
                               ng-value="item.purchase_price" step="any" readonly>
                        <td>
                            <input type="text" class="form-control" name="unit[]" ng-model="item.unit" readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" ng-model="item.stock_qty" readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" name="material_ration[]" ng-model="item.ration" readonly>
                        </td>

                        <td>
                            <input type="text" class="form-control" name="item_total_material[]" ng-model="item.total_quantity" readonly>
                        </td>

                        <input type="hidden" class="form-control" name="item_total_cost[]" ng-value="item.total_costing" readonly>
                        <input type="hidden" class="form-control" name="wastage_ration[]" ng-value="item.wastage" readonly>
                        <input type="hidden" class="form-control" name="item_total_wastage[]" ng-value="item.total_wastage" readonly>
                        <input type="hidden" class="form-control" name="item_total_production[]" ng-value="item.total_production" readonly>

                    </tr>

                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th>
                            {{totalRawMaterials}} Kg
                            <input type="hidden" name="total_material" ng-value="totalRawMaterials">
                        </th>
                        <input type="hidden" name="total_cost" ng-value="totalCost">
                        <input type="hidden" name="total_wastage_ration" ng-value="totalWastageRation">
                        <input type="hidden" name="total_wastage" ng-value="totalWastage">
                        <input type="hidden" name="total_production" ng-value="totalProduction">
                    </tr>
                </table>

                <input type="submit" ng-disabled="action"  class="btn btn-primary pull-right" name="update" value="Update">
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
</script>