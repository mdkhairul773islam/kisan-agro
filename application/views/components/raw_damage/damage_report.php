<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
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

<div class="container-fluid">
    
<div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search</h1>
                </div>
            </div>

            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>


                <div class="form-group">
                    <label class="col-md-2 control-label">Product Name</label>
                    <div class="col-md-4">
                        <select name="search[product_code]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>&nbsp;</option>
                            <?php
                            if (!empty($allProducts)){
                                foreach ($allProducts as $key => $val){ ?>
                                    <option value="<?php echo $val->code; ?>">
                                        <?php echo filter($val->name); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Client's Name</label>
                    <div class="col-md-4">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>&nbsp;</option>
                            <?php
                            if (!empty($allClients)) {
                                foreach ($allClients as $key => $client) { ?>
                                    <option value="<?php echo $client->code; ?>">
                                        <?php echo filter($client->name) . " ( " . $client->address . " ) "; ?>
                                    </option>
                                <?php }
                            } ?>
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
    
    
    <div class="row" ng-controller="showAllProductCtrl">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>





        <div class="panel panel-default loader-hide" id="data">

            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Damage Product</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>

                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="hide text-center" style="margin-top: 0px;">All Damages Product</h4>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 45px;"> SL </th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Product Name</th>
                        <th>Quantity (kg)</th>
                       <!--  <th class="none"> Action </th> -->
                    </tr>
                    <?php 
                    $total_qty = 0;
                    if(!empty($results)){
                        foreach ($results as $key => $value) {
                            $where = array("code" => $value->product_code);
                            $productInfo = $this->action->read('materials', $where);
                            $clientInfo = $this->action->read('parties', array('code' => $value->party_code));
    
                     ?>
                    <tr>
                        
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php if(!empty($clientInfo)){ echo $clientInfo[0]->name; } ?></td>
                        <td><?php echo (!empty($productInfo)) ? filter($productInfo[0]->name) : 'N/A'; ?> </td>
                        <td>
                            <?php 
                                echo $value->quantity; 
                                $total_qty += $value->quantity;
                            ?>
                        </td>
                    
                    </tr>
                    <?php } } ?>
                    
                    <tr>
                        <td colspan="4" style="text-align:right;" ><b> Total </b></td>
                        <td><b> <?php echo $total_qty; ?></b></td>
                    </tr>
                    
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
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
