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

        .title {
            font-size: 25px;
        }
    }

</style>

<div class="container-fluid">
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1> Date Wise Item Report </h1>
                </div>
            </div>

            <div class="panel-body none">
                <?php echo form_open(); ?>
 
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[product_code]" class="selectpicker form-control"  data-show-subtext="true" data-live-search="true" required>
                                <option value="" selected disabled>Select Product</option>
                                <?php foreach ($productionItems as $value) { ?>
                                <option value="<?php echo $value->code; ?>"><?php echo filter($value->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" placeholder="From ( YYYY-MM-DD )" class="form-control" required>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" placeholder="To ( YYYY-MM-DD )" class="form-control">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" value="Show" name="show" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
                <hr class="none" style="margin-top: 0px;">
            </div>

            

                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="hide text-center" style="margin-top: 0px;">All Sales Report</h4>


                    <table class="table table-bordered">
                        <tr>
                            <th width="40">SL</th>
                            <th>Date</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Sale Amount</th>
                        </tr>
                        <?php
                        $totalAmount = $totalQuantity = 0;
                        if (!empty($results)) {
                        foreach ($results as $key => $row) {
                            $totalAmount   += $row->sale_amount;
                            $totalQuantity += $row->quantity;
                            ?>
                            <tr>
                                <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->sap_at; ?> </td>
                                <td> <?php echo $row->name; ?> </td>
                                <td class="text-center"> <?php echo $row->quantity; ?> </td>
                                <td class="text-center"> <?php echo f_number(round($row->sale_amount)); ?> </td>
                                
                            </tr>
                        <?php }} ?>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong><?php echo f_number($totalQuantity); ?> kg</strong></td>
                            <td class="text-center"><strong><?php echo f_number(round($totalAmount)); ?>/-Tk</strong></td>
                        </tr>
                    </table>
                </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>