<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1> Daily Sales Report </h1>
                </div>
            </div>
            
            <div class="panel-body none">
                <?php echo form_open(); ?>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="form-group">
                        <div class="col-md-3">
                            <input type="text" name="search[voucher_no]" class="form-control" placeholder="Voucher No">
                        </div>
                        
                        <div class="col-md-3">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Client</option>
                                <?php
                                if (!empty($allClients)) {
                                    foreach ($allClients as $item) {
                                        echo '<option value="' . $item->code . '" ' . (!empty($_POST["party_code"]) && $_POST["party_code"] == $item->code ? "selected" : '') . '> ' . $item->code . '-' . $item->name .' ( '. $item->address .' ) </option>';
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '') ?>" placeholder="From ( YYYY-MM-DD )" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '') ?>" placeholder="To ( YYYY-MM-DD )" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <hr class="none">

            <?php if (!empty($result)) { ?>
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>
                    
                    <h4 class="hide text-center" style="margin-top: 0px;">All Sales Report</h4>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th width="40">SL</th>
                            <th>Date</th>
                            <th>Voucher No</th>
                            <th>Client Name</th>
                            <th class="text-center">Quantity (KG)</th>
                            <th class="text-center">Sale</th>
                            <th class="text-center">Payment</th>
                            <th>View</th>

                        </tr>
                        <?php
                        $totalDebit = $totalCredit = $totalQuantity = 0;
                        foreach ($result as $key => $row) {
                            if ($row->sap_type == 'cash'){
                                $clintInfo = json_decode($row->client_info, true);
                                $name = $row->party_code;
                            }else{
                                $name = get_name('parties', 'name', ['code' => $row->party_code, 'trash' => 0]);
                            }
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td> <?php echo $row->voucher_no; ?> </td>
                                <td> <?php echo check_null($name); ?> </td>
                                <td class="text-center"><?php echo $row->total_quantity;
                                    $totalQuantity += $row->total_quantity; ?></td>
                                <td class="text-center"><?php echo $row->total_bill;
                                    $totalDebit += $row->total_bill; ?></td>
                                <td class="text-center"><?php echo $row->paid;
                                    $totalCredit += $row->paid; ?>
                                </td>
                                <td>
                                    <a href="<?php echo site_url('sale/sale/preview').'?vno='.$row->voucher_no; ?>" class="btn btn-info">
                                        <i class="fa fa-eye"></i>    
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong><?php echo $totalQuantity; ?></strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalDebit); ?>/-Tk</strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalCredit); ?>/-Tk</strong></td>
                            <td>
                                
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } else {
                echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
            } ?>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script type="text/javascript">
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