<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

<div class="container-fluid" ng-controller="clientLedgerCtrl">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Crushing Client Ledger</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>
                <?php if($privilege != "client"){ ?>
                    <div class="form-group">
                        <label class="col-md-2 control-label"> Client Name </label>
                        <div class="col-md-5">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>&nbsp;</option>
                                <?php
                                if ($info != null) {
                                    foreach ($info as $row) {
                                ?>
                                <option value="<?php echo $row->code; ?>">	<?php echo filter($row->name)." [ ".$row->address." ]"; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                <?php } else { ?>
                <input type="hidden" name="search[party_code]" value="<?php echo $code; ?>">
                <?php } ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" name="show" value="Show" class="btn btn-primary pull-right">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>




        <?php
        if (!$this->input->post("show")) {
            if($defaultData != NULL){
        ?>
        <!-- Get data before submit result start here -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Crushing Client Ledger</h4>
                <hr>
                <address class="text-center none" style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">
                    Arab Feed Mills Ltd. <br>
                    322 Khadda Gudam Road<br>
                    Nutun Bazar,Muktagacha,Mymensingh. <br>
                    Mobile: 01721086643 | 0902875227
                    <hr style="margin: 5px 0; border-top: 2px solid #ddd;">
                    Crushing Client Ledger
                </address>

                <!-- pre><?php // print_r($defaultData); ?></pre -->

                <table class="table table-bordered">
                    <tr>
                        <th>Client ID</th>
                        <th width="200">Client Name</th>
                        <th>Address</th>
                        <!--th>Supplier Name</th-->
                        <th>Initial Balance</th>
                        <th>Credit Limit</th>
                        <th>Quantity(Kg)</th>
                        <!--th>Security Money</th-->
                        <th>Credit(Tk)</th>
                        <th>Debit(Tk) </th>
                        <th>Balance(Tk)</th>
                        <th>Status</th>
                    </tr>

                    <?php
                    $totalDebit = $totalCredit = $total = $totalCreditLimit = $totalSecurityMoney = $totalQuantity = 0.00;
                    $payableBalance = $receivableBalance = 0.00;
                    $grand_total = array();
                    //print_r($defaultData );
                    foreach ($defaultData as $key => $row) {
                        $where = array('code' => $row['code']);
                        $rec = $this->retrieve->read('partybalance', $where);

                        $opening = 0.00;
                        foreach($rec as $recRow) {
                        	$opening += $recRow->initial_balance;
                        }

                        // $opening = getPartyMeta($row['code'], 'opening_balance');
                    ?>
                    <tr>
                        <td><?php echo $row['code']; ?></td>
                        <td><?php echo filter($row['name']); ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <!--td><?php //echo ucwords(str_replace("-"," ",$row['brand'])); ?></td-->
                        <td>
                        <?php
                        echo ($opening) ? f_number($opening) : 0.00;
                        ?>
                        </td>

                        <td>
                        <?php
                        $where = array('code' => $row['code']);
                        $balanceInfo = $this->action->read('partybalance', $where);


                        if ($balanceInfo != null) {
                            echo $balanceInfo[0]->credit_limit;
                            /*
                            if($row['ctype'] == "do") {
                                foreach ($balanceInfo as $part) {
                                    $totalCreditLimit += $part->credit_limit;
                                    echo ucwords(str_replace("-"," ",$part->brand)) . ": " . $part->credit_limit . " TK<br>";
                                }
                            } else {
                                $totalCreditLimit += $part->credit_limit;
                                echo ucwords(str_replace("-"," ",$part->brand)) . " TK";
                            }
                            */
                        }
                        ?>
                        </td>

                        <!--td>
                        <?php
                        $subtotalSecurityMoney = 0.00;
                        $securityDetails = json_decode(getPartyMeta($row['code'], 'security'), true);
                        if($securityDetails != null) {
                            foreach ($securityDetails as $security) {
                                $subtotalSecurityMoney += $security['amount'];
                                $totalSecurityMoney += $security['amount'];
                            }
                        }

                        echo $subtotalSecurityMoney . " TK";
                        ?>
                        </td-->
			            <td><?php echo f_number(abs($row['quantity']));$totalQuantity += $row['quantity']; ?></td>
                        <td><?php echo f_number(abs($row['debit']));$totalDebit += $row['debit']; ?></td>
                        <td><?php echo f_number(abs($row['credit']));$totalCredit += $row['credit']; ?></td>
                        <td>
                        <?php

                        // $subtotal = ($row['debit'] - $row['credit']) - $opening;
                        // $subtotal = ($opening + $row['debit']) - $row['credit'];

                        $subtotal = ($opening - $row['debit']) + $row['credit'];



                        if($subtotal > 0){
                           $payableBalance += $subtotal;
                        }else{
                           $receivableBalance += abs($subtotal);
                        }



                         $total += $subtotal;
                        //echo $total . "<br>";


                        //echo f_number(abs($subtotal));
                        $total += abs($rec[0]->balance);
                       echo f_number(abs($rec[0]->balance));


                        ?>
                        </td>
                        <td><?php echo $status = ($subtotal <= 0) ? 'Receivable' : 'Payable'; ?></td>
                    </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="5" class="text-right">Total</th>

                        <!-- <th><strong>&nbsp;<?php //echo f_number($totalCreditLimit); ?></strong></th> -->
                        <!--th><strong><?php echo f_number($totalSecurityMoney); ?></strong></th-->
                        <th><strong><?php echo f_number($totalQuantity); ?></strong></th>
                        <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th><strong><?php echo f_number($totalCredit); ?></strong></th>
                        <th>
                            <strong>
                            <?php
                            /*
                            if($total >= 0) {
                                // receivable
                                if($opening > 0) {
                                    // payable
                                    $total = $total - $opening;
                                } else {
                                    // receivable
                                    $total = $total - $opening;
                                }
                            } else {
                                // payable
                                if($opening <= 0) {
                                    // receivable
                                    $total = $total - $opening;
                                } else {
                                    // payable
                                    $total = $total - $opening;
                                }
                            }
                            */
                            //echo f_number(abs($total));

                            //echo $receivableBalance."<br/>";
                             //echo $payableBalance."<br/>";


                            //echo f_number($receivableBalance - $payableBalance);

                            echo f_number($total);

                            ?>
                            </strong>
                        </th>
                        <th><strong><?php echo $status = ($total <= 0) ? 'Receivable' : 'Payable'; ?></strong></th>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
      <?php } } else { ?>


        <!--Get data before submit result End here-->
        <?php if ($resultset != NULL) { ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- print banner -->
                 <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.jpg'); ?>">
                <h4 class="text-center hide" style="margin-top: 0px;">Crushing Client Ledger</h4>
                <hr>
                <address class="text-center none" style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">
                    Arab Feed Mills Ltd. <br>
                    322 Khadda Gudam Road<br>
                    Nutun Bazar,Muktagacha,Mymensingh. <br>
                    Mobile: 01721086643 | 0902875227
                    <hr style="margin: 5px 0; border-top: 2px solid #ddd;">
                      Crushing Client Ledger
                </address>


                <div class="row">
                    <div class="col-xs-5">
                        <!--pre><?php //print_r($partyInfo); ?></pre-->

                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Client ID:</th>
                                <td><?php echo $partyInfo[0]->code; ?></td>
                            </tr>

                            <tr>
                                <th>Client Name :</th>
                                <td><?php echo filter($partyInfo[0]->name); ?></td>
                            </tr>

                            <tr>
                                <th>Address:</th>
                                <td><?php echo $partyInfo[0]->address; ?></td>
                            </tr>
                            <tr>
                            	<th>Mobile: </th>
                            	<td><?php echo $partyInfo[0]->mobile; ?></td>
                            </tr>

                            <tr>
                                <th>Opening Balance :</th>
                                <td>
                                    <strong>
                                    <?php
                                // After Submit Date Start here
                                    if($fromDate != NULL || $toDate != NULL){
                                        $prevInfo = getPreviousInfo($fromDate,$partyCode,$partyBrand);
                                        $opening_balance = getPartyMeta($partyInfo[0]->code, 'opening_balance');
                                        //echo "<pre>";echo $fromDate;print_r($prevInfo);echo "</pre>";

                                        if(count($prevInfo)){
                                            $opening_balance+=$prevInfo[0]->previous_balance;
                                        }

                                        $status = ($opening_balance < 0) ? "Payable" : "Receivable";
                                        echo abs($opening_balance). "/- ".$status;
                                    }else{
                                       $openingBalance = getPartyMeta($partyInfo[0]->code, 'opening_balance');
                                       $status = ($openingBalance >= 0)? "Receivable" : "Payable";
                                       echo abs($openingBalance)."/-".$status;
                                    }
                                    ?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>


                    <div class="col-xs-offset-2 col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th width="50%">From Date :</th>
                                <td><?php echo $fromDate; ?> </td>
                            </tr>

                            <tr>
                                <th>From To :</th>
                                <td><?php echo $toDate; ?> </td>
                            </tr>

                            <tr>
                                <th>Current Balance :</th>
                                <td>
					    <strong>
		                            <?php
		                            // echo "<pre>"; print_r($partyBalance); echo "</pre>";

		                            $totalBalance = 0.00;
		                            foreach($partyBalance as $key => $row) {
		                            	$totalBalance += $row->balance;
		                            }

		                            $status = ($totalBalance < 0) ? "Payable" : "Receivable";
		                            echo abs($totalBalance) . "/- " . $status;

		                            // $status = ($partyBalance[0]->balance > 0) ? "Payable" : "Receivable";
		                            // echo abs($partyBalance[0]->balance) . "/- " . $status;
		                            ?>

                        </strong>
				</td>
                            </tr>

                            <!--<tr>
                                <th>Commission :</th>
                                <td><strong><?php echo $totalCommissionAmoint; ?>/-</strong></td>
                            </tr>-->
                        </table>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30px;">SL</th>
                        <th>Date</th>
                        <th>Voucher No</th>
                        <!--th>Details</th-->
                        <!--th>Trans. Det.</th-->
                        <th>Quantity (Kg)</th>
                        <!--<th>Com. Det. (Tk)</th> -->
                        <th>Debit (Tk)</th>
                        <th>Credit (Tk)</th>
                        <th>Balance (Tk)</th>
                        <!--th>Status</th-->
                        <th class="none" style="width: 55px;">Action</th>
                    </tr>



                    <!-- initial balance row start here -->
                    <tr>
                    	<td>1</td>
                    	<td colspan="5">Previous Balance</td>
                    	<td>
                    	<?php
                    	if($brandExists == "yes") {
                    		echo f_number(abs($resultset[0]->previous_balance));
                    	} else {
                    		$totalInitialBalance = 0.00;

		        	foreach($partyBalance as $key => $row) {
		        		$totalInitialBalance += $row->initial_balance;
		        	}

                    		echo f_number(abs($totalInitialBalance));
                    	}
                    	?>
                    	</td>

                    	<!--td>
                    	<?php
                    	if($brandExists == "yes") {
                    		echo ($resultset[0]->previous_balance < 0) ? "Payable" : "Receivable";
                    	} else {
                    		echo ($totalInitialBalance < 0) ? "Payable" : "Receivable";
                    	}
                    	?>
                    	</td-->
                    	<td class="none"> </td>


                    </tr>
                    <!-- initial balance row start here -->








		  <?php
		  $totalDebit = $total = $totalCommission = $TotalQuantity  = 0.00;
		  foreach ($resultset as $key => $row) {
		  	if($row->status == "zb") {
		  		if($brandExists == "no") {

		$total += $row->paid;

			// work with sale section
			$relationList = array();
			$debit = "-";

			if($row->remark == 'sale') {
				$relationList = explode(':', $row->relation);
				$where = array('voucher_no' => $relationList[1]);

				$saleInfo = $this->action->read('saprecords', $where);
				$debit = ($saleInfo) ? $saleInfo[0]->total_bill : 0.00;
			    	$totalDebit += $debit;
			}
		    ?>
                    <tr>
                        <td><?php echo ($key + 2); ?></td>
                        <td><?php echo $row->transaction_at; ?></td>
                        <td><?php echo $vno = ($row->remark == 'sale') ? $relationList[1] : ''; ?></td>


			<!--<td>
    			<?php
    			/*if($row->remark == 'sale') {
    				$where = array('voucher_no' => $relationList[1]);
    				$items = $this->action->read('sapitems', $where);
    				$records = $this->action->read('saprecords', $where);

    				if($records != NULL){
    					if($records[0]->sap_type == 'do') {
    						echo 'DO No ' . $records[0]->voucher_no;
    					} elseif($records[0]->sap_type == 'retail') {
    						echo 'Retail ' . $records[0]->voucher_no;
    					} else {
    						echo '';
    					}
    				}

     				$totalCommission = 0.00;

    				foreach ($records as $re) {

    					 $totalCommission += $re->total_discount ;
    				}

    				echo $totalCommission;
    			} else {
    				echo 'Cash Payment';
    			}*/
    			?>
			</td>-->

			<td>
			<?php
			if($row->remark == 'sale') {
				//echo "<strong>Truck  No " . metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'truck_no')) . "</strong>";
				$trackAmount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'truck_fare'));

				/* $where = array('voucher_no' => $relationList[1]);
				$items = $this->action->read('sapitems', $where);

 				$grandTotalTrackRant = 0.00;
				foreach ($items as $item) {
					$totalTrackRant = $trackAmount * $item->quantity;
					$totalCom = $item->sale_price * $item->quantity;

					$grandTotalTrackRant += $totalTrackRant;

					// "<p>Trk. Fr = " . $item->quantity . " " . $item->unit . "@" . $trackAmount . "/- =" . $totalTrackRant . "/-</p>";
					//echo "<strong>(" . $totalCom . " - " . $totalTrackRant . " = " . ($totalCom - $totalTrackRant) . "/-)</strong>";


				}*/

				echo $trackAmount;
			}
			?>
			</td>

            		<!--td>
    			<?php
    			// commisssion data
    			if($row->remark == 'sale') {
    				$amount = metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'commission_amount'));
    				$comm = ($amount != null) ? $amount : 0.00;

    				$where = array('voucher_no' => $relationList[1]);
    				$items = $this->action->read('sapitems', $where);

    				$records = $this->action->read('saprecords', $where);

    				/*foreach ($items as $item) {
    					$totalCom = $comm * $item->quantity;
    					$totalCommission += $totalCom;
    					// echo "<p>" . $item->quantity . " " . $item->unit . "@" . $comm . "/- = " . $totalCom . "/-</p>";
    				}*/




    				$totalCommission = 0.00;
				/* foreach ($items as $item) {
					$totalCom = $item->sale_price * $item->quantity;
					// echo "<p>" . $item->quantity . " " . $item->unit . "@" . $item->sale_price . "=" . $totalCom . "/-</p>";

					 $totalCommission += $totalCom ;
				}*/

				foreach ($records as $re) {

					 $totalCommission += $re->total_discount ;
				}

				echo $totalCommission;

    			}
    			?>
			</td-->



			<td>
				<?php
			      	//Quantity
			      	if($row->remark == 'sale') {
				$where = array('voucher_no' => $relationList[1]);
				$records = $this->action->read('saprecords', $where);

				echo $records[0]->total_quantity;

				$TotalQuantity += $records[0]->total_quantity;

				}

			      ?>
			</td>

			<td><?php echo $debit; ?></td>
			<td><?php echo $row->paid; ?></td>
            		<td><?php echo f_number(abs($row->current_balance)); ?></td>
            		<td class="none">
	                    	<?php if($row->remark == 'sale') { ?>
	                    	<a class="btn btn-info" title="Preview" target="_blank" href="<?php echo site_url('sale/viewSale?vno=' . $relationList[1]); ?>"> <i class="fa fa-eye" aria-hidden="true"> </i> </a>
	                    	<?php }else{ ?>
		                 	&nbsp;
		                 <?php } ?>
	                 </td>
            <!--td><?php echo ($row->current_balance >=0)? "Receivable" : "Payable"; ?></td-->
         </tr>
		 <?php } } else {
		    $total += $row->paid;

			// work with sale section
			$relationList = array();
			$debit = "-";

			if($row->remark == 'sale') {
				$relationList = explode(':', $row->relation);
				$where = array('voucher_no' => $relationList[1]);

				$saleInfo = $this->action->read('saprecords', $where);
				$debit = ($saleInfo) ? $saleInfo[0]->total_bill : 0.00;
			    $totalDebit += $debit;
			}

			if($row->remark == 'saleReturn') {
			    $relationList = explode(':', $row->relation);
				$where = array('voucher_no' => $relationList[1]);

				$saleReturnInfo = $this->action->read('sale_return', $where);
				$debit = ($saleReturnInfo) ? $saleReturnInfo[0]->total_return : 0.00;
			    $totalDebit -= $debit;
			}
			?>

            <tr>
                <td><?php echo ($key + 2); ?></td>
                <td><?php echo $row->transaction_at; ?></td>
                <td>
                <?php
                //echo $vno = ($row->remark == 'sale') ? $relationList[1] : '';
                echo $vno = ($relationList != null) ? $relationList[1] : '';
                ?>
                </td>


		    	<!--td>
            			<?php
            			if($row->remark == 'sale') {
            				$where = array('voucher_no' => $relationList[1]);
            				$items = $this->action->read('sapitems', $where);
            				$records = $this->action->read('saprecords', $where);

            				if($records != NULL){
            					if($records[0]->sap_type == 'do') {
            						echo 'DO No ' . $records[0]->voucher_no;
            					} elseif($records[0]->sap_type == 'retail') {
            						echo 'Retail ' . $records[0]->voucher_no;
            					} else {
            						echo '';
            					}
            				}

            				foreach ($items as $item) {
            					$totalCom = $item->sale_price * $item->quantity;
            					echo "<p>" . $item->quantity . " " . $item->unit . "@" . $item->sale_price . "=" . $totalCom . "/-</p>";
            				}

            				echo ($records) ?  'Paid = ' . $records[0]->paid . '/-' : 'Paid = ' ."0.00" . '/-';
            			} else {
            				echo 'Cash Payment';
            			}
            			?>
			     </td-->

			     <!--td>
        			<?php
        			if($row->remark == 'sale') {

        				//echo "<strong>Truck  No " . metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'truck_no')) . "</strong>";
        				$trackAmount = metadata('sapmeta', array('voucher_no' => $relationList[1], 'meta_key' => 'truck_fare'));

        				/*$where = array('voucher_no' => $relationList[1]);
        				$items = $this->action->read('sapitems', $where);

	                                $grandTotalTrackRant = 0.00;
        				foreach ($items as $item) {
        					$totalTrackRant = $trackAmount * $item->quantity;
        				        $totalCom = $item->sale_price * $item->quantity;

        					$grandTotalTrackRant += $totalTrackRant;

        					// echo "<p>Trk. Fr = " . $item->quantity . " " . $item->unit . "@" . $trackAmount . "/- =" . $totalTrackRant . "/-</p>";
        					//echo "<strong>(" . $totalCom . " - " . $totalTrackRant . " = " . ($totalCom - $totalTrackRant) . "/-)</strong>";


        				}*/


        				echo $trackAmount;
        			}
        			?>
			      </td-->




			      <td>

			      <?php
			      	//Quantity
			      	if($row->remark == 'sale') {
				$where = array('voucher_no' => $relationList[1]);
				$records = $this->action->read('saprecords', $where);

				echo $records[0]->total_quantity;

				$TotalQuantity += $records[0]->total_quantity;

				}

				// minus retrun Quantity
				if($row->remark == 'saleReturn') {
    				$where = array('voucher_no' => $relationList[1]);
    				$records = $this->action->read('sale_return', $where);

    				echo $records[0]->totalQty;

    				$TotalQuantity -= $records[0]->totalQty;

				}

			      ?>
			      </td>



                  <!--<td>
            			<?php
            			// commisssion data
            			if($row->remark == 'sale') {
            				$amount = metadata('sapmeta', array('voucher_no' => $vno, 'meta_key' => 'commission_amount'));
            				$comm = ($amount != null) ? $amount : 0.00;

            				$where = array('voucher_no' => $relationList[1]);
            				$items = $this->action->read('sapitems', $where);

            				$records = $this->action->read('saprecords', $where);

            				$totalCommission = 0.00;

        					foreach ($records as $re) {

        						 $totalCommission += $re->total_discount ;
        					}

        				   echo $totalCommission;
            			  }
            			?>
			        </td>-->

    		    <td><?php echo $debit; ?></td>
    		    <td><?php echo abs($row->paid); ?></td>
                    <td><?php echo f_number(abs($row->current_balance)); ?></td>
                    <td class="none">
	                    <?php if($row->remark == 'sale') { ?>
	                    	<a class="btn btn-info" title="Preview" target="_blank" href="<?php echo site_url('crushing_sale/viewCrushingSale?vno=' . $relationList[1]); ?>"> <i class="fa fa-eye" aria-hidden="true"> </i> </a>
	                    <?php }elseif($row->remark == 'saleReturn') { ?>
		                   <a class="btn btn-info" title="Preview" target="_blank" href="<?php echo site_url('sale/multiSaleReturn/view?vno=' . $relationList[1]); ?>"> <i class="fa fa-eye" aria-hidden="true"> </i> </a>
		             <?php }else{ ?>
		             <?php } ?>
		     </td>

                    <!--td><?php echo ($row->current_balance >=0) ? "Receivable" : "Payable"; ?></td-->
                  </tr>
		        <?php }} ?>


                    <tr>
                        <th colspan="3" class="text-right">Total</th>
                        <th><strong><?php echo f_number($TotalQuantity ); ?></strong></th>
                        <!--<th><strong><?php echo f_number($totalCommission); ?></strong></th>-->
                        <th><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th><strong><?php echo f_number(abs($total)); ?></strong></th>

                        <th>
                        	<strong>
                            	<?php
                                	$totalPartyBalance = 0.00;
                                	foreach($partyBalance as $key => $val) {
                                		$totalPartyBalance += $val->balance;

                                	}
                                	$status = ($totalPartyBalance >= 0) ? "Receivable" : "Payable";
                                	echo f_number(abs($totalPartyBalance))." [ ".$status." ] ";
                            	?>
                        	</strong>
                        </th>
                        <th class="none"></th>

                        <!--th><?php echo ($totalPartyBalance >= 0) ? "Receivable" : "Payable"; ?>
                        </th-->
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php }} ?>
    </div>
</div>

<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
