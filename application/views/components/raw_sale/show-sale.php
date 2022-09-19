<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />

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
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Sale</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label">Voucher No </label>
                    <div class="col-md-4">
                        <input type="text" name="search[voucher_no]" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Client's Name</label>
                    <div class="col-md-4">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" selected disabled>&nbsp;</option>
                            <?php foreach ($allClients as $key => $client) { ?>
                            <option value="<?php echo $client->code; ?>" >
                                  <?php echo filter($client->name)." ( ".$client->address." ) "; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-md-2 control-label">From </label>
                    <div class="input-group date col-md-4" id="datetimepickerFrom">
                        <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">To </label>
                    <div class="input-group date col-md-4" id="datetimepickerTo">
                        <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>

        <!--pre><?php //print_r($result); ?></pre-->
        <?php if($result != null){ ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                 <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.jpg'); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">All Sale</h4>

                <table class="table table-bordered table2">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Client's Name</th>
                        <th>Vou No</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Commission</th>
                        <th> Paid </th>
                        <!--th>Grand Total</th-->
                        <th class="none">Action</th>
                    </tr>


                    <?php
                    $total_bill = 0.0;
                    $total_discount = 0.00;
                    $amount = $total_paid = 0.00;
                    $total_quantity = 0.00;
                    foreach($result as $key => $row){ ?>
                    <tr>
                        <td style="width: 50px;"> <?php echo ($key + 1); ?> </td>
                        <td> <?php echo $row->sap_at; ?> </td>

                        <td>
                          <?php
                            if($row->sap_type != "cash" ){
                              $where = array('trash'=>0, 'code' => $row->party_code);
                              $party_info = $this->action->read('crushing_parties', $where);
                             if ($party_info != null) {
                               echo filter($party_info[0]->name);}else{echo "N/A";
                            } } else {
                            echo filter($row->party_code);
                            }
                         ?>
                        </td>

                        <td> <?php echo $row->voucher_no; ?> </td>
                        <td><?php echo $row->total_quantity; ?></td>

                        <td>
                        <?php

                            $truckRent = 0;

                            $info = $this->action->read("sapmeta",array("meta_key"=> "truck_fare", "voucher_no" => $row->voucher_no));
                            if($info) { $truckRent = $info[0]->meta_value; }


                            //$total = $truckRent + ($row->total_bill);
                            $total = $row->total_bill;
                            $total_bill += $total;
                            echo  f_number($total);
                        ?>
                        </td>

                        <td><?php
                            $total_discount +=$row->total_discount;
                            echo $row->total_discount; 
                            ?>  
                        </td>
                        
                        <td>
                        	<?php
                        	$total_paid += $row->paid;
                        	echo $row->paid;
                        	
                        	?>
                        </td>

                        <!--td>
                            <?php
                                $grand_total = 0.00;

                                $grand_total = $total -  $row->total_discount;
                                $amount += $grand_total;
                                echo f_number($grand_total);

                             ?>
                        </td-->



                        <td class="none" style="width: 170px;">
                            <a title="View" class="btn btn-primary" href="<?php echo site_url('raw_sale/viewRawSale?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>

                            <a
                                title="Edit"
                                class="btn btn-warning"
                                href="<?php echo site_url('raw_sale/saleEditCtrl?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <!--<a
                                title="Return"
                                class="btn btn-info"
                                href="<?php echo site_url('sale/saleReturnCtrl?vno=' . $row->voucher_no); ?>">
                                <i class="fa fa-share" aria-hidden="true"></i>
                            </a>-->

                             <!--a onclick="return confirm('Are you sure want to delete this Sale?');" title="Delete" class="btn btn-danger" href="<?php echo site_url('sale/deleteSale?vno=' . $row->voucher_no); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a-->

                        </td>
                    </tr>
                    <?php
                        $total_quantity += $row->total_quantity;
                     } ?>

                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong> </td>
                        <th><?php echo $total_quantity; ?></th>
                        <th><?php echo $total_bill; ?></th>
                        <th><?php echo $total_discount; ?></th>
                        <th><?php echo $total_paid; ?> </th>
                        <!--th><?php echo f_number($amount); ?></th-->
                        <th colspan="1" class="none">&nbsp;</th>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
        <?php } ?>



    </div>
</div>




<script>
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerSMSFrom").on("dp.change", function (e) {
        $('#datetimepickerSMSTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerSMSTo").on("dp.change", function (e) {
        $('#datetimepickerSMSFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
