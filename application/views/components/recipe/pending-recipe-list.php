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

<div class="container-fluid">
    <div class="row" ng-cloak>
        <?php echo $this->session->flashdata("confirmation"); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Pending Recipe List</h1>
                </div>
                <a onclick="window.print()" style="cursor:pointer;font-size:14px;float:right"><i class="fa fa-print"></i>&nbsp;Print</a>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                
                <h4 class="text-center hide" style="margin-top: 0px;">Pending Recipe List</h4>
                <?php
                if (!empty($allRecipe)) {
                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <th width="45px">SL</th>
                            <th>Date</th>
                            <th>Recipe</th>
                            <th>Order Time</th>
                            <th class="text-center">Total Weight (Kg)</th>
                            <th>Status</th>
                            <th width="60" class="none">Action</th>
                        </tr>
                        <?php foreach ($allRecipe as $_key => $row) { ?>
                            <tr>
                                <td><?= ($_key + 1) ?></td>
                                <td><?= date('Y-m-d h:i:s:A', strtotime($row->date_time)) ?></td>
                                <td><?= filter($row->category_name) ?></td>
                                <td><?= filter($row->order_time) ?></td>
                                <td class="text-center"><?= $row->total_weight ?></td>
                                <td><?= filter($row->status) ?></td>
                                <td class="none">
                                    <a class="btn btn-danger" title="Delete"
                                       onclick="return confirm('Are you sure to delete this data?');"
                                       href="<?php echo site_url("recipe/recipe/pending_recipe_list?id=$row->id"); ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php
                } else {
                    echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
                } ?>
            </div>
            <?php echo form_close(); ?>
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