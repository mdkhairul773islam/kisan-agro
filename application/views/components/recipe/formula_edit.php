<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    .table2 tr td{
        padding: 0 !important;
    }
    .table2 tr td input{
        border: 1px solid transparent;
    }
    .new-row-1 .col-md-4{
        margin-bottom: 8px;
    }
    .table tr th.th-width{
        width: 110px !important;
    }

    .red, .red:focus {border-color: red;}
    .green, .green:focus {border-color: green;}
</style>

<div class="container-fluid" ng-controller="editFormulaCtrl">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

       <input type="hidden" name="recipe" ng-model="category_code" ng-init="category_code='<?php echo $recipes[0]->category_code; ?>'" ng-value="category_code">
        
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
                echo form_open('', $attr);
                ?>

                <div class="row new-row-1">
                    <div class="col-md-2">
                        <div class="input-group date" id="datetimepicker">
                            <input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d');?>" placeholder="Date" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type="text" value="<?php echo get_name('category', 'category', ['code' => $recipes[0]->category_code]); ?>" class="form-control" readonly>
                        <input type="hidden" name="category_code"  value="<?php echo $recipes[0]->category_code; ?>">
                    </div>


                    <div class="col-md-4">
                        <select ng-model="product" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" ng-change="addNewProductFn()">
                            <option value="" selected disabled>-- Raw Material --</option>
                            <?php 
                            if(!empty($row_materials)){ 
                            foreach($row_materials as $row){ ?>
                                <option value="<?php echo $row->code; ?>">
                                    <?php echo filter($row->name); ?>
                                </option>
                            <?php }} ?>
                        </select>
                        <span ng-show="erroeMessage" style="color: red">This product already exists....!</span>
                    </div>
                </div>
                <hr>
                
                <table class="table table-bordered table2">
                    <tr>
                        <th width="45px">SL</th>
                        <th>Materials</th>
                        <th>Unit</th>
                        <th>Ration (%)</th>
                        <!--<th>Wastage (%)</th>-->
                        <th width="50px">Action</th>
                    </tr>

                    <tr ng-repeat="item in records">
                        <td style="padding: 6px 8px !important;">{{ $index + 1 }}</td>
                        <td style="padding: 6px 8px !important; background: #eee;">
                            {{item.name}}
                            <input type="hidden" name="product[]" class="form-control" ng-value="item.name" readonly>
                            <input type="hidden" name="product_code[]" ng-value="item.code">
                        </td>

                        <td style="padding: 6px 8px !important; background: #eee;">
                            {{item.unit}}
                            <input type="hidden" class="form-control"  ng-value="item.unit" readonly>
                        </td>

                        <td>
                            <input type="number" class="form-control" name="ration[]"  ng-model="item.ration" placeholder="0" min="0" step="any">
                        </td>
                    
                       <!-- <td>
                            <input type="number" class="form-control"  name="wastage[]" ng-model="item.wastage" min="0" step="any">
                        </td>-->
                        
                        <td class="text-center">
                            <a title="Delete" class="btn btn-danger" ng-click="deleteItemFn($index)">
                                <i class="fa fa-times fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                </table>

                <div class="btn-group pull-right">
                    <input type="submit" name="update" value="Update" class="btn btn-success">
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
</script>
