<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<style>
    .table2 tr td {padding: 0 !important;}
    .table2 tr td input{border: 1px solid transparent;}
    .new-row-1 .col-md-4{margin-bottom: 8px;}
    .table tr th.th-width{width: 110px !important;}
    .table .form-control:focus{border-color: transparent;}
    .table select {border: 1px solid transparent;}
</style>

<div class="container-fluid" ng-controller="chalanEditCtrl">
    <div class="row" ng-init="chalanNo=<?php echo $chalanno; ?>">
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Edit Chalan</h1>
                </div>
            </div>

            <div class="panel-body">
                <!-- horizontal form -->
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open('chalan/chalan/edit/' . $chalanno, $attr);
                ?>

                <div class="row new-row-1">
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepicker1">
                            <input type="text" name="date" class="form-control" value="<?php echo $info[0]->date; ?>" placeholder="Date" required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <input  type="text" name="chalan_no" value="<?php echo $info[0]->chalan_no; ?>" class="form-control" readonly>
                    </div>
                </div>
                <hr>

                <table class="table table-bordered table2">
                    <tr>
                        <th style="text-align:center;" width="40">SL</th>
                        <th style="width: 133px;">Name</th>
                        <th class="th-width">Quantity</th>
                        <th width="80px">Size</th>
                        <th width="80px">Bags</th>
                    </tr>

                    <tr ng-repeat="row in items">
                        <td style="text-align:center;">{{ $index + 1 }}</td>
                        <td style="padding-left: 10px !important;">
                            {{ row.product }}
                            <input type="hidden" name="code[]" class="form-control" ng-value="row.code">
                        </td>

                        <td style="padding-left: 10px !important;">
                            <input type="number" name="quantity[]" class="form-control" ng-model="row.quantity" ng-change="calculateBags($index);">
                        </td>

                        <td>
                            <select class="form-control" name="bagSize[]" ng-model="row.size" ng-change="calculateBags($index);">
                                <?php foreach (config_item('bag_size') as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </td>

                        <td>
                            <input type="text" name="bags_no[]" ng-value="row.bags" class="form-control" readonly>
                        </td>
                    </tr>
                </table>

                <hr>
                <div class="text-right col-md-12 no-padding">
                    <div class="btn-group">
                        <input class="btn btn-primary" type="submit" name="change" value="Change">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
