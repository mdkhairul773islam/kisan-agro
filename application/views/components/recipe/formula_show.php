<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{
            display: block !important;
        }
    }
    .table tr td{
        vertical-align: middle !important;
    }
   
</style>

<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Formula </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Show Formula</h4>
                <div class="table-responsive">
                    <?php 
                    if (!empty($recipes)) {
                        ?>
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="4">Recipe Name :
                                    <strong><?php echo filter($recipes[0]->category_name); ?></strong></td>
                            </tr>
                            <tr>
                                <th width="50">SL</th>
                                <th>Material Name</th>
                                <th>Unit</th>
                                <th>Ration (%)</th>
                                <!--<th>Wastage (%)</th>-->
                            </tr>
                            <?php
                            $price = [];
                            $ration = [];
                            /*$wastage = [];*/
                            foreach ($recipes as $key => $recipe) { ?>
                                <tr>
                                    <td><?php echo($key + 1); ?></td>
                                    <td><?php echo filter($recipe->name); ?></td>
                                    <td><?php echo filter($recipe->unit); ?></td>
                                    <td><?php echo $recipe->ration;
                                        $ration [] += $recipe->ration; ?></td>
                                    <!--<td><?php /*echo $recipe->wastage;
                                        $wastage [] += $recipe->wastage; */?></td>-->
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="3" class="text-right"> Total =</th>
                                <th><?php echo f_number(array_sum($ration), 3); ?></th>
                               <!-- <th><?php /*echo array_sum($wastage); */?></th>-->
                            </tr>
                        </table>
                        <?php
                    } else {
                        echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
                    }?>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
