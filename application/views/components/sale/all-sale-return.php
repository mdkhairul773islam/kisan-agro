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
</style>
<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1> All Sale Return</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="row">
                    <div class="col-md-3 mb-1">
                        <input type="text" name="search[voucher_no]"
                               value="<?= (!empty($_POST['search']['voucher_no']) ? $_POST['search']['voucher_no'] : '') ?>"
                               class="form-control" placeholder="Voucher No">
                    </div>

                    <div class="col-md-3">
                        <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>-- Select Client's Name --</option>
                            <?php
                            if (!empty($allClients)) {
                                foreach ($allClients as $row) {
                                    ?>
                                    <option value="<?php echo $row->code; ?>" <?= (!empty($_POST['search']['party_code']) && $_POST['search']['party_code'] == $row->code ? 'selected' : '') ?>>
                                        <?php echo $row->code . '-' . filter($row->name) . " ( " . $row->address . " ) "; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="search_type" class="form-control">
                            <option value="voucher_wise" <?= (!empty($_POST['search_type']) && $_POST['search_type'] == 'voucher_wise' ? 'selected' : '') ?>>
                                Voucher Wise
                            </option>
                            <option value="item_wise" <?= (!empty($_POST['search_type']) && $_POST['search_type'] == 'item_wise' ? 'selected' : '') ?>>
                                Item Wise
                            </option>
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control"
                                   value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : '') ?>"
                                   placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control"
                                   value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : '') ?>"
                                   placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                            <a href="<?= site_url('sale/multiSaleReturn/all') ?>" class="btn btn-success"><i
                                        class="fa fa-refresh" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">All Sale Return</h4>
                <?php if (!empty($results)) {
                    if (!empty($_POST['search']['party_code']) && !empty($_POST['search_type']) && $_POST['search_type'] !== 'voucher_wise') { ?>

                        <table class="table table-bordered table2">
                            <tr>
                                <th width="30">SL</th>
                                <th width="90">Date</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Total Weight (Kg)</th>
                                <th>Total Amount (Tk)</th>
                            </tr>
                            <?php
                            $totalBill = $totalQuantity = $totalWeight = 0;
                            foreach ($results as $key => $row) {
                                $subtotal      = 0;
                                $totalQuantity += $row->quantity;
                                $totalWeight   += $row->total_weight;
                                $subtotal      = $row->quantity * $row->sale_price;
                                $totalBill     += $subtotal;
                                ?>

                                <tr>
                                    <td> <?= ($key + 1) ?> </td>
                                    <td> <?= $row->created_at ?> </td>
                                    <td> <?= $row->product_code ?> </td>
                                    <td> <?= get_filter($row->name) ?> </td>
                                    <td> <?= get_filter($row->unit) ?> </td>
                                    <td> <?= $row->quantity ?> </td>
                                    <td> <?= $row->total_weight ?> </td>
                                    <td> <?= get_number_format($subtotal) ?> </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total</strong></td>
                                <th> <?= get_number_format($totalQuantity) ?> </th>
                                <th> <?= get_number_format($totalWeight) ?> (Kg)</th>
                                <th> <?= get_number_format($totalBill) ?> (Tk)</th>
                            </tr>
                        </table>
                    <?php } else {
                        ?>
                        <table class="table table-bordered table2">
                            <tr>
                                <th width="30">SL</th>
                                <th width="90">Date</th>
                                <th width="100">Voucher No</th>
                                <th>Client's Name</th>
                                <th>Remark</th>
                                <th>Quantity</th>
                                <th>Total Amount (Tk)</th>
                                <th width="110px" class="none">Action</th>
                            </tr>
                            <?php
                            $totalBill = $totalQuantity = 0;
                            foreach ($results as $key => $row) {
                                $totalQuantity += $row->total_quantity;
                                $totalBill     += $row->total_bill;
                                if ($row->party_type == 'cash') {
                                    $name = $row->party_code;
                                } else {
                                    $name = $row->name;
                                }
                                ?>

                                <tr>
                                    <td> <?= ($key + 1) ?> </td>
                                    <td> <?= $row->created_at ?> </td>
                                    <td> <?= $row->voucher_no ?> </td>
                                    <td> <?= get_filter($name) ?> </td>
                                    <td> <?= get_filter(check_null($row->remark)) ?> </td>
                                    <td> <?= $row->total_quantity ?> </td>
                                    <td> <?= get_number_format($row->total_bill) ?> </td>

                                    <td class="none">
                                        <a title="View" class="btn btn-primary"
                                           href="<?php echo site_url('sale/multiSaleReturn/view?vno=' . $row->voucher_no); ?>">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                        <a onclick="return confirm('Are you sure want to delete this Sale Return?');"
                                           title="Delete" class="btn btn-danger"
                                           href="<?php echo site_url('sale/multiSaleReturn/delete?vno=' . $row->voucher_no); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total</strong></td>
                                <th> <?php echo get_number_format($totalQuantity); ?> </th>
                                <th><?php echo get_number_format($totalBill); ?> TK</th>

                                <th class="none">&nbsp;</th>
                            </tr>
                        </table>
                    <?php }
                } else {
                    echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
                } ?>
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