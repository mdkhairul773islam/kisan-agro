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
                    <h1 class="pull-left">Show Recipe</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Recipe</h4>



                <div class="row">
                    <div class="col-xs-3"> <p><strong>Recipe Name</strong> : <?php echo filter(get_name('category', 'category', ['code' => $info->category_code])); ?></p></div>
                    <div class="col-xs-3"> <p><strong>Invoice</strong> : <?php echo filter($info->voucher_no); ?></p></div>
                    <div class="col-xs-3"> <p><strong>Date</strong> : <?php echo filter($info->created); ?></p></div>
                    <div class="col-xs-3"> <p><strong>Print Time</strong> : <?php echo date('Y-m-d h:i:s A'); ?></p></div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="50" >SL</th>
                            <th>Materials Name</th>
                           <!-- <th>Code</th>-->
                            <th>Purchase Price</th>
                            <th>Unit</th>
                            <th>Ration (%)</th>
                            <th>Total materials (in Kg)</th>
                            <th>Total Cost (in Tk)</th>
                            <!--<th>Wastage (%)</th>
                            <th>Total Wastage (in Kg)</th>
                            <th>Total Production (in Kg)</th>-->
                        </tr>
                        <?php
                        $price = [];
                        $ration = [];
                        $wastage = [];

                        if (!empty($info)) {
                            $where = ['tbl_recipe_item.voucher_no' => $info->voucher_no, 'materials.type' => 'raw'];
                            $itemInfo = get_join('tbl_recipe_item', ['materials'], ['materials.code=tbl_recipe_item.product_code'], $where, ['tbl_recipe_item.*', 'materials.name']);
                            foreach($itemInfo as $_key => $item_value){
                        ?>
                            <tr>
                                <td><?php echo ++$_key; ?></td>
                                <td> <?php echo $item_value->name; ?> </td>
                                <!--<td><?php /* echo $item_value->product_code;*/?></td>-->
                                <td><?php  echo $item_value->purchase_price;?></td>
                                <td><?php  echo $item_value->unit;?></td>
                                <td><?php  echo $item_value->material_ration;?></td>
                                <td><?php  echo $item_value->item_total_material;?></td>
                                <td><?php  echo $item_value->item_total_cost;?></td>
                                <!--<td><?php /* echo $item_value->wastage_ration;*/?></td>
                                <td><?php /* echo $item_value->item_total_wastage;*/?></td>
                                <td><?php /* echo $item_value->item_total_production;*/?></td>-->
                            </tr>
                        <?php } } ?>
                        <tr>
                            <th colspan="5" class="text-right"> Total</th>
                            <th><?php echo $info->total_material; ?> Kg</th>
                            <th><?php echo $info->total_cost; ?> Tk</th>
                            <!--<th><?php /*echo $info->total_wastage_ration; */?> %</th>
                            <th><?php /*echo $info->total_wastage; */?> Kg</th>
                            <th><?php /*echo $info->total_production; */?> Kg</th>
                        </tr>-->
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
