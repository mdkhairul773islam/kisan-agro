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
        .block-hide{
            display: none;
        }
        .h100vh {
            height: 99vh;
        }
    }
    .table tr th, .table tr td{border-top: none !important;}
    .signature{margin-top: 80px;}
    .info {margin-bottom: 15px;}
</style>

<div class="container-fluid" >
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Chalan Details</h1>
                </div>
                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body h100vh">
                <!-- Print banner -->
                <div class="col-md-12" style="max-height:150px;height:100%;"></div>
                 <!--img class="img-responsive print-banner hide" src="<?php //echo site_url('public/img/banner.jpg'); ?>"-->
                 
                <?php
                
                    $where = array('code' => $info[0]->party_code);
                    $partyInfo = $this->action->read('parties',$where);
                ?>
                
                <div class="row info">
                    <div class="col-xs-5">
                        <label>Chalan No.  : <?php echo $info[0]->chalan_no; ?></label> <br>
                         <label>Client Name : <?php echo filter($partyInfo[0]->name); ?></label> <br>
                    </div>
                   
                    <div class="col-xs-5">
                        <label>Mobile : <?php echo $partyInfo[0]->mobile; ?></label> <br>
                        <label>Address : <?php echo $partyInfo[0]->address; ?></label> <br>
                    </div>
                    
                    <div class="col-xs-2">
                        <label>Date : <?php echo $info[0]->date; ?></label> <br>
                    </div>
                    
                </div>
                
                
                
                
                
                <table class="table table-bordered">
                    <!--caption>
                        <p class="pull-left">Chalan No. <?php echo $info[0]->chalan_no; ?></p>
                        <p class="pull-left">Client Name <?php echo filter($partyInfo[0]->name); ?></p>
                        <p class="pull-right hide"><span class="print-time"><?php echo $info[0]->date; ?></span></p>
                    </caption-->

                    <tr>
                        <th width="55">SL </th>
                        <th>Product Name</th>
                        <th width="160">Quantity</th>
                        <th width="160">Bag Size</th>
                        <th width="160">Bags</th>
                    </tr>

                    <?php
                    $total_quantity = 0.0;
                    $total_bag = 0.0;
                    foreach ($info as $key => $value) {
                        $where = array('code' => $value->code);
                        $product = $this->action->read('materials', $where);
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $product[0]->name; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo $value->size; ?> Kg</td>
                        <td><?php echo $value->bags; ?></td>
                    </tr>
                    <?php

                        $total_quantity += $value->quantity;
                        $total_bag += $value->bags;

                        }
                     ?>


                     <tr>
                         <th colspan="2"><span class="pull-right">Total</span> </th>
                         <th><?php echo $total_quantity; ?> Kg</th>
                         <th>&nbsp;</th>
                         <th><?php echo $total_bag; ?> Bags</th>
                     </tr>
                </table>

                <div class="cpl-md-2 col-xs-4 hide">
                    <div class="signature text-center">
                        <hr style="margin-bottom: 4px;">
                        <p>Delivary Man</p>
                    </div>
                </div>

                <div class="cpl-md-2 col-xs-4 pull-right hide">
                    <div class="signature text-center">
                        <hr style="margin-bottom: 4px;">
                        <p>Accountant</p>
                    </div>
                </div>
            </div>

            <!--div class="panel-body h100vh hide">
               
                <div class="col-md-12" style="max-height:150px;height:100%;"></div>
               

                <table class="table table-bordered">
                    <caption>
                        <p class="pull-left">Chalan No. <?php echo $info[0]->chalan_no; ?></p>
                        <p class="pull-right hide"><span class="print-time"><?php echo $info[0]->date; ?></span></p>
                    </caption>

                    <tr>
                        <th width="55">SL </th>
                        <th>Product Name</th>
                        <th width="160">Quantity</th>
                        <th width="160">Bag Size</th>
                        <th width="160">Bags No</th>
                    </tr>

                    <?php
                    foreach ($info as $key => $value) {
                        $where = array('code' => $value->code);
                        $product = $this->action->read('materials', $where);
                    ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $product[0]->name; ?></td>
                        <td><?php echo $value->quantity; ?></td>
                        <td><?php echo $value->size; ?> Kg</td>
                        <td><?php echo $value->bags; ?></td>
                    </tr>
                    <?php } ?>
                </table>

                <div class="cpl-md-2 col-xs-4 hide">
                    <div class="signature text-center">
                        <hr style="margin-bottom: 4px;">
                        <p>Delivary Man</p>
                    </div>
                </div>

                <div class="cpl-md-2 col-xs-4 pull-right hide">
                    <div class="signature text-center">
                        <hr style="margin-bottom: 4px;">
                        <p>Accountant</p>
                    </div>
                </div>
            </div-->

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
