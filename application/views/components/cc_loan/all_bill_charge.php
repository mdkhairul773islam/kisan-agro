<?php 	if(isset($meta->header)){$header_info = json_decode($meta->header,true);}
    	if(isset($meta->footer)){$footer_info = json_decode($meta->footer,true);}
    	$logo_data  = json_decode($meta->logo,true); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        .print_banner_logo {width: 19%;float: left;}
        .print_banner_logo img {margin-top: 10px;}
		.print_banner_text {width: 80%; float: right;text-align: center;}
		.print_banner_text h2 {margin:0;line-height: 38px;text-transform: uppercase !important;}
		.print_banner_text p {margin-bottom: 5px !important;}
		.print_banner_text p:last-child {padding-bottom: 0 !important;margin-bottom: 0 !important;}
    }
    .table tr th, .table tr td{font-size: 13px; padding: 4px !important;}
    .table tr td p {margin: 0;padding: 0;}
</style>
<div class="container-fluid">
    <?php echo $this->session->flashdata("confirmation"); ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1>All Bank Charge </h1>
                </div>
            </div>
            <?php
            
                $attr = array('class' => 'form-horizontal');
                echo form_open('cc_loan/bill_charge/all');
            ?>
                <div class="panel-body none">
                    <div class="form-group">
                        <div class="col-md-2">
                            <select name="search[acc_no]" class="selectpicker form-control" data-show-subtext="true"
                            data-live-search="true" >
                                <option value="" selected disabled>-- Select Account Number  --</option>
                                <?php $acc_no = $this->action->read('cc_loan');  ?>
                                <?php foreach($acc_no as $value){ ?>
                                    <option value="<?php echo $value->acc_no; ?>"> <?php echo $value->bank_name.'-'.$value->acc_no;  ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="col-md-2"> 
                             <select name="search[charge_type]" class="form-control">
                                <option selected disabled>-- Select Type --</option>
                                <option value="Service Charge">Service Charge</option>
                                <option value="Insurance Bill">Insurance Bill</option>
                                <option value="Check Bill">Check Bill </option>
                                <option value="Sms Bill">Sms Bill</option>
                            </select>
                        </div>    
                    
                        <div class="col-md-2">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
    
                        <div class="col-md-2">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-1">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
              
                
                </div>
                    <div class="panel-footer">&nbsp;</div>
                </div>
                <?php echo form_close(); ?>
                
               
             

                <!--Get data before submit result start here-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panal-header-title">
                            <h1 class="pull-left">Show Result</h1>
                            <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!-- Print banner Start Here -->

                        <div class="col-xs-12 hide" style="border: 1px solid #ddd; padding:15px !important; margin-bottom: 15px;">
                            <div class="print_banner_logo">
                                <img class="img-responsive" src="<?php echo site_url($logo_data['faveicon']); ?>" alt="">
                            </div>
                            <div class="print_banner_text">
                            	<h2><?php echo strtoupper($header_info['site_name']); ?></h2>
                            	<p><?php echo $header_info['place_name'];?></p>
                            	<p><?php echo $footer_info['addr_moblile']; ?> || <?php echo $footer_info['addr_email']; ?></p>
                            </div>
                        </div>
        
                        <!-- Print banner End Here -->
                        <div class="col-md-12 text-center hide">
                            <h3 style="border: 1px solid #aaa; padding: 8px 10px; display: inline-block;">CC Transaction</h3>
                        </div>
                        
                        <?php 
                            if(!empty($all_bank_charge)){ 
                            $sl=1;
                        ?>
                           
                            <table class="table table-bordered">
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Bank</th>
                                    <th>Account No</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>                                     
                            <?php  
                                $total_charge = 0;
                                foreach($all_bank_charge as $value){ 
                                    $total_charge += $value->amount;
                            ?>    
                                    <tr>
                                        <td><?php echo $sl;$sl++; ?></td>
                                        <td><?php echo  $value->created_at; ?></td>
                                        <td><?php echo  get_name('cc_loan','name',['acc_no' => $value->acc_no]); ?></td>
                                        <td><?php echo  get_name('cc_loan','bank_name',['acc_no' => $value->acc_no]); ?></td>
                                        <td><?php echo  $value->acc_no; ?></td>
                                        <td><?php echo  $value->charge_type; ?></td>
                                        <td><?php echo  number_format($value->amount,2); ?></td>
                                        <td>
                                             
                                            <!-- <a title="Edit" class="btn btn-warning" href="<?php //echo site_url('cc_loan/cc_loan/edit_cc_trx/'.$value->id); ?>">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                             </a>-->
                     
                                             
                                             <a onclick="return confirm('Are you sure want to delete this Bank Charge?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('cc_loan/bill_charge/delete_data/'.$value->id); ?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                             </a>
                                             

                                        </td>
                                    </tr>    
                            <?php } ?>
                                <tr>
                                    <td colspan="6" class="text-right" ><b>Total</b></td>
                                    <td><b><?php echo $total_charge; ?>Tk</b></td>
                                    <td></td>
                                </tr>    
                            </div>
                        <?php } ?>    
                        <div class="panel-footer">&nbsp;</div>
                    </div>
                                                        
                          
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <script>
            $('#datetimepickerFrom').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: false
            });
            $('#datetimepickerTo').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: false
            });
        </script>