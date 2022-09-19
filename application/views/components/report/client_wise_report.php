<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }
    }

    .table tr th, .table tr td {
        font-size: 13px;
        padding: 4px !important;
    }

    .table tr td p {
        margin: 0;
        padding: 0;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Client wise report</h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array('class' => 'form-horizontal');
                echo form_open('', $attr);
                ?>

                <div class="form-group">
                    <label class="col-md-2 control-label"> Client Name </label>
                    <div class="col-md-5">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true" required>
                            <option value="" selected disabled>&nbsp;</option>
                            <?php
                            if (!empty($info)) {
                                foreach ($info as $row) {
                                    echo '<option value="' . $row->code . '" ' . (!empty($_POST['search']['party_code']) && $_POST['search']['party_code'] == $row->code ? "selected" : "") . ' >' . $row->code . '-' . $row->name . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>

               <!-- <div class="form-group">
                    <label class="col-md-2 control-label">From</label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]"
                                   value="<?= !empty($_POST['date']['from']) ? $_POST['date']['from'] : ""; ?>"
                                   class="form-control" placeholder="YYYY-MM-DD">
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
                            <input type="text" name="date[to]"
                                   value="<?= !empty($_POST['date']['to']) ? $_POST['date']['to'] : ""; ?>"
                                   class="form-control" placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
-->
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
            if (!empty($defaultData)) {
                ?>
                <!--Get data before submit result start here-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panal-header-title">
                            <h1 class="pull-left">Show Result</h1>
                            <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                               onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <!-- Print banner -->
                        <?php $this->load->view('components/print'); ?>

                        <h4 class="text-center hide" style="margin-top: 0px;">Client Wise Report </h4>

                        <table class="table table-bordered">
                            <tr>
                                <th>S.ID</th>
                                <th>Client Name</th>
                               <!-- <th width="120" class="text-center">Opening Balance</th>-->
                                <th width="120" class="text-center">Total Sales (Tk)</th>
                                <th width="120" class="text-center">Damage amount (Tk)</th>
                                <th width="120" class="text-center">Total Payment (Tk)</th>
                               
                               
                            </tr>

                            <?php
                            $totalDebit = $totalCredit = $total = $totalQuantity = $grandTotal = $total_damage_amount = 0.00;

                            foreach ($defaultData as $key => $row) {
                                
                                $client_wise_damage_amount = 0;
                    
                                $where_damage_product = ['party_code'=> $row['code']];
                                $damage_product = $this->action->read('damage_product',$where_damage_product);        
                                foreach($damage_product as $value){
                                    $product_wise_damage_amount += $value->product_price*$value->quantity;
                                }
                                        
                                $total_damage_amount += $client_wise_damage_amount;
                                
                                
                                ?>
                                <tr>
                                    <td><?= $row['code'] ?></td>
                                    <td><?= filter($row['name']) ?></td>
                                    <!--<td class="text-center"><?= $row['initial_balance'] ?></td>-->
                                    <td class="text-center">
                                        <?php
                                        echo f_number($row['debit']);
                                        $totalDebit += $row['debit']; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php  echo $client_wise_damage_amount; ?>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php
                                        echo f_number($row['credit']);
                                        $totalCredit += $row['credit']; ?>
                                    </td>
                                    
                                </tr>
                            <?php } ?>

                            <tr>
                                <th colspan="2" class="text-right">Total</th>
                                <th class="text-center"><strong><?= f_number($totalDebit) ?></strong></th>
                                <th class="text-center"><?= f_number($total_damage_amount) ?> </th>
                                <th class="text-center"><strong><?= f_number($totalCredit) ?></strong></th>
                                
                               
                            </tr>
                        </table>
                    </div>

                    <div class="panel-footer">&nbsp;</div>
                </div>
                <!--Get data before submit result end here-->
            <?php 
                
            }
            } 
        ?>
        <!--Get data after submit result End here-->
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
