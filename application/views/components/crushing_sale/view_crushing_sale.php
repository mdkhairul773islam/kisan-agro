<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
        
    }
</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Voucher</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <!--pre><?php //print_r($result); ?></pre-->

            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.jpg'); ?>"> 

                <div class="row">
                	<div class="col-xs-4 print-font">
                        <?php
                        $address = "N/A";
                        if($result[0]->sap_type != "cash" ) {
                            $where = array('code' => $result[0]->party_code);
                            $party_info = $this->action->read('crushing_parties', $where);
                        ?>

                        <label>Name : <?php if ($party_info != null) { echo filter($party_info[0]->name);}else{echo "N/A";} ?></label> <br>
                        <!-- label>Mobile : <?php if ($party_info != null) { echo $party_info[0]->mobile;}else{echo "N/A";} ?></label><br -->
                        <!-- <label>Address : <?php //if ($party_info != null) { echo $party_info[0]->address;}else{echo "N/A";} ?></label> -->
                             <label style="width: 100%;"> Mobile : <?php if ($party_info != null) { echo $party_info[0]->mobile;}else{echo "N/A";} ?> </label>
                             <label style=" margin-bottom: 10px;">Address: </label>

                        <?php
                        } else {
                        $cdata = json_decode($result[0]->address, true);
                        $address = $cdata['address'];
                        ?>

                        <label>Name : <?php echo filter($result[0]->party_code); ?></label> <br>
                        <label>Mobile : <?php echo $cdata['mobile']; ?></label><br>

                        <?php } ?>
                	</div>

                	<div class="col-xs-4 print-font">
                			
                	<label style="margin-bottom: 10px;">
                            Voucher No : <?php echo $result[0]->voucher_no; ?>
                        </label> <br>
			                <?php
                      		 $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
                      		 //print_r($info);
                        ?>
                        <label style="margin-bottom: 10px;">
                             Sales Man : <?php echo isset($info[0]->meta_value) ? $info[0]->meta_value : ''; ?> 
                        </label> 

                        <!-- <label style="margin-bottom: 10px;">
                            Address : <?php //echo $address; ?>
                        </label> -->
                     </div>

                	<div class="col-xs-4 print-font">
                		<label>Date : <?php echo $result[0]->sap_at; ?></label> <br>
                		<label>Print Time : <?php echo date("h:i:s A"); ?></label>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 5%;">SL</th>
                        <th style="width: 37%;">Product</th>
                        <th style="width: 18%;">Quantity</th>
                        <th style="width: 18%;">Price</th>
                        <th style="width: 19%;">Total (TK)</th>
                    </tr>

                    <?php
                    $total_sub = 0.0;
                    $where = array('voucher_no' => $result[0]->voucher_no);
                    $saleInfo = $this->action->read('sapitems', $where);
                    foreach($saleInfo as $key => $row){
                    ?>
                    <tr>
                        <td style="width: 50px;"><?php echo ($key + 1); ?></td>

                        <td>
                        <?php
                          $where = array('type' => 'raw','code' => $row->product_code);
                          $productInfo = $this->action->read('materials', $where);
                          if($productInfo){ echo filter($productInfo[0]->name); }
                        ?>
                        </td>

                        <td class="text-right"><?php echo $row->quantity; ?></td>
                        <td class="text-right"><?php echo $row->sale_price; ?></td>
                        <td class="text-right">
                        <?php
                        $subtotal = $row->sale_price * $row->quantity;
                        $total_sub += $subtotal;
                        echo f_number($subtotal);
                        ?>
                        </td>
                    </tr>                    
                    <?php } ?>
                    
                    <?php
                    $truckRent = 0;
                    $info = $this->action->read("sapmeta",array("meta_key"=> "truck_fare", "voucher_no" => $result[0]->voucher_no));
                    ?>
                    <tr>
                        <th colspan="2" class="text-right">Total Quantity</th>
                        <td class="text-right"><?php echo $result[0]->total_quantity; ?> kg</td>
                        <th>Sub Total</th>
                        <td class="text-right"><?php echo f_number($total_sub); ?> TK</td>
                    </tr>

                    <tr>
                        <th rowspan="15" colspan="3">
                            
                            <?php 
                                $crushingInfo = $this->action->read('crushing_data', array('voucher_no' => $result[0]->voucher_no));
                            ?>
                            
                            <table class="table table-bordered table2">
                                <tr>
                                    <th> Crushing</th>
                                    <th class="text-center">Qty.</th>
                                    <th class="text-center">Rate</th>
                                    <th class="text-center">Amount</th>
                                </tr>
                                
                                <?php if($crushingInfo[0]->crushing_amount1 > 0.00){ ?>
                                <tr>
                                    <th><b>1.5 mm</b></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->qty1) ? $crushingInfo[0]->qty1 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->rate1) ? $crushingInfo[0]->rate1 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->crushing_amount1) ? $crushingInfo[0]->crushing_amount1 : ''; ?></th>
                                </tr>
                                <?php } ?>
                                
                                <?php if($crushingInfo[0]->crushing_amount2 > 0.00){ ?>
                                <tr>
                                    <th><b>2.0 mm</b></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->qty2) ? $crushingInfo[0]->qty2 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->rate2) ? $crushingInfo[0]->rate2 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->crushing_amount2) ? $crushingInfo[0]->crushing_amount2 : ''; ?></th>
                                </tr>
                                <?php } ?>
                                
                                <?php if($crushingInfo[0]->crushing_amount3 > 0.00){ ?>
                                <tr>
                                    <th><b>3.0 mm</b></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->qty3) ? $crushingInfo[0]->qty3 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->rate3) ? $crushingInfo[0]->rate3 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->crushing_amount3) ? $crushingInfo[0]->crushing_amount3 : ''; ?></th>
                                </tr>
                                <?php } ?>
                                
                                <?php if($crushingInfo[0]->crushing_amount4 > 0.00){ ?>
                                <tr>
                                    <th><b>4.0 mm</b></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->qty4) ? $crushingInfo[0]->qty4 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->rate4) ? $crushingInfo[0]->rate4 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->crushing_amount4) ? $crushingInfo[0]->crushing_amount4 : ''; ?></th>
                                </tr>
                                <?php } ?>
                                
                                <?php if($crushingInfo[0]->crushing_amount5 > 0.00){ ?>
                                <tr>
                                    <th><b>5.0 mm</b></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->qty5) ? $crushingInfo[0]->qty5 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->rate5) ? $crushingInfo[0]->rate5 : ''; ?></th>
                                    <th class="text-center"><?php echo isset($crushingInfo[0]->crushing_amount5) ? $crushingInfo[0]->crushing_amount5 : ''; ?></th>
                                </tr>
                                <?php } ?>
                                
                                <tr>
                                    <th colspan="4">In Word : <span id="inword"></span> Taka Only.</th>
                                    
                                    <!--<th colspan="3">In Word : <span id="inword"></span> Taka Only.</th>-->
                                </tr>
                            </table>
                        </th>
                    </tr>
                   
                    <?php
                    $truckRent = 0;
                    $info = $this->action->read("sapmeta",array("meta_key"=> "truck_fare", "voucher_no" => $result[0]->voucher_no));
                    ?>
                    
                    <tr>
                        <th>
                            Total Crushing Charge
                            <?php
                                $totalCrushingCharge = 0.00;
                                $totalCrushingCharge = $result[0]->crushing_charge;
                                
                            ?> 
                        </th>

                        <td class="text-right">
                        <?php
                            echo f_number($totalCrushingCharge);
                        ?> TK
                        </td>
                    </tr>
                    
                    <!-- <tr>
                        <th>
                            Discount
                        </th>

                        <td class="text-right">
                        <?php
                        $total_discount = $result[0]->total_discount;
                        echo f_number($result[0]->total_discount);
                        ?> TK
                        </td>
                    </tr>-->
                    
                     <?php
                    $info = $this->action->read("crushing_partytransaction",array("relation"=> "sales:".$result[0]->voucher_no));
                    ?>

                    <tr>
                        <th>Previous Balance</th>
                        <td width="250" class="text-right"><?php if($info !=null){

                            echo abs($info[0]->previous_balance)." TK";
                            if($info[0]->previous_balance >= 0) {
                            echo "<br> [ Receivable ]";
                        } else {
                            echo " <br> [ Payable ]";
                        }
                            }else{
                                echo 0;
                            } ?> 
                                
                        </td>
                    </tr>


                    <?php
                    $labourCost = 0;
                    $info = $this->action->read("sapmeta", array("meta_key" => "labour_cost", "voucher_no" => $result[0]->voucher_no));
                    ?>

                    <!-- <tr>
                        <td>Labour Cost</td>
                        <td>
                        <?php
                        $labourCost = $info[0]->meta_value;
                        echo f_number($info[0]->meta_value);
                        ?>
                        </td>
                    </tr> -->

                    <tr>
                        <th>Grand Total</th>
                        <td class="text-right">
                        <?php
                        //$gtotal = $total = $total_sub - $truckRent - $total_discount  + $labourCost + $totalCrushingCharge;
                        $gtotal = $total = $total_sub - $truckRent + $labourCost + $totalCrushingCharge;
                        echo f_number($total);
                        ?> TK
                        </td>
                    </tr>

                    <tr>
                        <th>Paid</th>
                        <td class="text-right"><?php echo f_number($result[0]->paid); ?> TK</td>
                    </tr>

                    <!-- tr><td colspan="2">&nbsp;</td></tr -->

                    <?php
                    $where = array('party_code' => $result[0]->party_code, 'relation' => "sales:" . $result[0]->voucher_no);
                    $party_info = $this->action->read('crushing_partytransaction', $where);

                    if($party_info != null) {
                    ?>
                    <tr>
                        <th>Current Balance</th>
                        <td width="320" class="text-right">
                        <?php
                        $total = $party_info[0]->current_balance;
                        echo f_number(abs($total)) . " TK";
                        if($total >= 0) {
                            echo "<br> [ Receivable ]";
                        } else {
                            echo "<br> [ Payable ]";
                        }
                        ?>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <th colspan="3"></th>
                        <th>Due</th>
                        <td><?php echo f_number($total - $result[0]->paid); ?></td>
                    </tr>
                    <?php } ?>
                    
                    
                    <tr>&nbsp;</tr>
                    <tr>&nbsp;</tr>
                    <tr>&nbsp;</tr>
                    <tr>&nbsp;</tr>
                    <tr>&nbsp;</tr>
                    <tr>&nbsp;</tr>
                    <tr>&nbsp;</tr>
                </table>
                
                <?php
                     $info = $this->action->read("sapmeta",array("meta_key"=> "sale_by", "voucher_no" => $result[0]->voucher_no));
                  ?>

               	<div class="pull-left">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                    --------------------------------- <br>
                   <?php echo isset($info[0]->meta_value) ? $info[0]->meta_value : ''; ?>
                    </h4>
                </div>

                <div class="pull-right ">
                    <h4 style="margin-top: 40px;" class="text-center print-font">
                    -------------------------------- <br>
                    Signature of authority
                    </h4>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $result[0]->paid; ?>));});
</script>
