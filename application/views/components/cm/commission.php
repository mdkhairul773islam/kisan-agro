<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}

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

        .title{
            font-size: 25px;
        }
    }

</style>
<div class="container-fluid none">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

    <!-- horizontal form -->
    <?php
    $attribute = array(
        'name' => '',
        'class' => 'form-horizontal',
        'id' => ''
    );
    echo form_open_multipart('', $attribute);
    ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Monthly Commission</h1>
                </div>
            </div>

            <div class="panel-body no-padding">
                <div class="no-title">&nbsp;</div>

                <!-- left side -->
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Year <span class="req">*</span></label>
                        <div class="col-md-7">
                            <select name="search[year]" class="form-control" required>
                               <?php  for($start=2016;$start<=date('Y');$start++) { ?>
                                <option <?php if($start==date('Y')){echo"selected ";} ?>  value="<?php echo $start; ?>"><?php echo $start; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Client Name <span class="req">*</span></label>
                        <div class="col-md-7">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>&nbsp;</option>
                                <?php foreach ($clientInfo as $key => $value) { ?>
                                 <option value="<?php echo $value->code;?>"><?php echo $value->name;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <div class="btn-group pull-right">
                                <input class="btn btn-primary" type="submit" name="show" value="Show">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?php if($result){ ?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>Monthly Commission of <?php echo $name;?></h1>
                </div>

                <a href="#" class="pull-right none" style="margin-top: 0px; font-size: 14px;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body">
                <div class="text-center hide">
                    <h3 class="text-center">Yearly Expenditure <?php echo date('Y'); ?></h3>
                    <p><span class="print-time text-center" style="margin-bottom: 5px;"><?php echo filter($this->data['name']) . ' | ' . date('Y, F j  h:i a'); ?></span></p>
                </div>
		
                <table class="table table-bordered">
                    <tr>
                        <th width="40">SL</th>
                        <th>Month</th>
                        <th>Quantity (Kg)</th>
                        <th>Quantity (Ton)</th>
                        <!--<th>Total MRP</th>
                        <th>Bas Com(6%)</th>
                        <th>Fright</th>
                        <th>Total</th>
                        <th>Monthly</th>-->
                        <th>Com Rate (Tk/Ton)</th>
                        <th>Com Amount (Tk)</th>
                        <th width="80" class="none">Payment</th>                        
                    </tr>
                    <?php 
                        
                    	function commissionCal($x=NULL){
                    		if($x < 10){
                    			return 0;
                    		}
                    		if($x >=15 && $x <=25){
                    			return 200;
                    		}
                    		if($x >=26 && $x <=40){
                    			return 250; 
                    		}
                    		if($x >=41 && $x <=60){
                    			return 300; 
                    		}
                    		if($x >=61 && $x <=80){
                    			return 350; 
                    		}
                    		if($x >=81 && $x <=100){
                    			return 400; 
                    		}
                    		if($x >=101 && $x <=130){
                    			return 450; 
                    		}
                    		if($x >=131 && $x <=160){
                    			return 550; 
                    		}
                    		if($x >=161 && $x <=200){
                    			return 600; 
                    		}
                    		if($x >=200){
                    			return 700; 
                    		}          		          		
           
                    	}                    	
                      
                      $totalAmount = 0.0;
                    
                    ?>
                    <tr> 
                        <td>1</td>  
                        <td><strong>January</strong></td>
                        <td><?php echo $january = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"01",$_POST['search']['party_code']) : 0;  ?></td> 
                        <td><?php $january_ton = $january/1000; echo f_number($january_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td> </td>
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($january_ton)? commissionCal($january_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $january_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        
                        
                        <td class="none text-center">

                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "01"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($january/1000)*$january/1000)."&&year=".$_POST['search']['year']."&&month=01"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    
                    <tr> 
                        <td>2</td>  
                        <td><strong>February</strong></td>
                        <td><?php echo $February =(isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"02",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $February_ton = $February/1000; echo f_number($February_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($February_ton)? commissionCal($February_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $February_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>

                         <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "02"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($February/1000)*$February/1000)."&&year=".$_POST['search']['year']."&&month=02"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>3</td>  
                        <td><strong>March</strong></td>
                        <td><?php echo $March = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"03",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $March_ton = $March/1000; echo f_number($March_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($March_ton)? commissionCal($March_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $March_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "03"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($March /1000)*$March /1000)."&&year=".$_POST['search']['year']."&&month=03"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>4</td>  
                        <td><strong>April</strong></td>
                        <td><?php echo $April = (isset($_POST['search'])) ?  getSaleQuantity($_POST['search']['year'],"04",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $April_ton = $April/1000; echo f_number($April_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($April_ton)? commissionCal($April_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $April_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "04"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($April /1000)*$April /1000)."&&year=".$_POST['search']['year']."&&month=04"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>5</td>  
                        <td><strong>May</strong></td>
                        <td><?php echo $May = (isset($_POST['search'])) ?  getSaleQuantity($_POST['search']['year'],"05",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $May_ton = $May/1000; echo f_number($May_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($May_ton)? commissionCal($May_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $May_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "05"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($May /1000)*$May /1000)."&&year=".$_POST['search']['year']."&&month=05"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>6</td>  
                        <td><strong>June</strong></td>
                        <td><?php echo $June = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"06",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $June_ton = $June/1000; echo f_number($June_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($June_ton)? commissionCal($June_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $June_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "06"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($June /1000)*$June /1000)."&&year=".$_POST['search']['year']."&&month=06"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>7</td>  
                        <td><strong>July</strong></td>
                        <td><?php echo $July = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"07",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $July_ton = $July/1000; echo f_number($July_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($July_ton)? commissionCal($July_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $July_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "07"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($July /1000)*$July /1000)."&&year=".$_POST['search']['year']."&&month=07"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>8</td>  
                        <td><strong>August</strong></td>
                        <td><?php echo $August = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"08",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $August_ton = $August/1000; echo f_number($August_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($August_ton)? commissionCal($August_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $August_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "08"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($August /1000)*$August /1000)."&&year=".$_POST['search']['year']."&&month=08"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>9</td>  
                        <td><strong>September</strong></td>
                        <td><?php echo $September = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"09",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $September_ton = $September/1000; echo f_number($September_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($September_ton)? commissionCal($September_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $September_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "09"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($September /1000)*$September /1000)."&&year=".$_POST['search']['year']."&&month=09"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>10</td>  
                        <td><strong>October</strong></td>
                        <td><?php echo $October = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"10",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $October_ton = $October/1000; echo f_number($October_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($October_ton)? commissionCal($October_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $October_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "10"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($October /1000)*$October /1000)."&&year=".$_POST['search']['year']."&&month=10"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>11</td>  
                        <td><strong>November</strong></td>
                        <td><?php echo $November = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"11",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $November_ton = $November/1000; echo f_number($November_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($November_ton)? commissionCal($November_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $November_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "11"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($November /1000)*$November /1000)."&&year=".$_POST['search']['year']."&&month=11"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr> 
                        <td>12</td>  
                        <td><strong>December</strong></td>
                        <td><?php echo $December = (isset($_POST['search'])) ? getSaleQuantity($_POST['search']['year'],"12",$_POST['search']['party_code']) : 0; ?></td>
                        <td><?php $December_ton = $December/1000; echo f_number($December_ton); ?></td> 
                        <!--<td></td> 
                        <td></td>  
                        <td></td>  
                        <td></td> 
                        <td></td>-->
                        
                        <td><?php $com = commissionCal($December_ton)? commissionCal($December_ton):0; echo $com ;?></td>
                        <td><?php $amount = $com * $December_ton; $totalAmount+= $amount; echo f_number($amount); ?></td>
                        <td class="none text-center">
                        	<?php 
                        	   $where = array(
                        	     "party_code" => $_POST['search']['party_code'],
                        	     "year"       => $_POST['search']['year'],
                        	     "month"      => "12"
                        	   );
                        	   
                        	   $commissionInfo = $this->action->read('monthly_commission_paid', $where);                        	   
                        	?>
                        	<?php if($commissionInfo != null) {?>
                        	<a title="Commission Successfully Paid!" class="btn btn-success">
                        		<i class="fa fa-check" aria-hidden="true"></i>
                        	</a>
                        	<?php }else{ ?>
                        	<a title="Commission Payment" class="btn btn-info" 
                        	   onclick="return confirm('Are You Sure Want to Payment this Client?');" 
                        	   href="<?php echo site_url('cm/commission/monthlyPaid?party_code='.$_POST['search']['party_code']."&&amount=".(commissionCal($December /1000)*$December /1000)."&&year=".$_POST['search']['year']."&&month=12"); ?>">
                        	
                        	  Paid
                        	</a>
                        	<?php } ?>
                        </td>
                    </tr>
                    <?php
                        $totalQ = 0.00;
                        $totalT = 0.00;
                        
                        $totalQ = $january + $February + $March + $April + $May + $June + $July + $August + $September + $October + $November + $December ; 
                        $totalT = $january_ton + $February_ton + $March_ton + $April_ton + $May_ton + $June_ton + $July_ton + $August_ton + $September_ton + $October_ton + $November_ton + $December_ton ; 
                    
                    ?>
                   
                        
                    <tr>
                        <th colspan="2"><span class="pull-right">Total</span></th>
                        <th> <?php echo $totalQ; ?> Kg </th>
                        <th> <?php echo $totalT; ?> Ton </th>
                        <!--<th> </th>
                        <th> </th>
                        <th> </th>
                        <th> </th>
                        <th> </th>-->
                        <th> </th>
                        <th> <?php echo $totalAmount;?> TK </th>
                        <th class="none"></th>
                    </tr>
                    
                </table>
                
                <div class="pull-right">
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

<?php } ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js" ></script>
