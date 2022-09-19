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

    .mb-5 {
        margin-bottom: 15px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>View All Order</h1>
                </div>

                <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                   onclick="window.print()"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="panel-body none">
                <?php
                $attr = array("class" => "form-horizontal");
                echo form_open("", $attr);
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="search[voucher_no]"
                               value="<?= (!empty($_POST['search']['voucher_no']) ? $_POST['search']['voucher_no'] : '') ?>"
                               placeholder="Enter voucher no"
                               class="form-control mb-5">
                    </div>

                    <div class="col-md-3">
                        <select name="category" class="form-control mb-5">
                            <option value="" selected disabled>-- Select Recipe --</option>
                            <?php
                            if (!empty($allCategory)) {
                                foreach ($allCategory as $c_value) {
                                    echo '<option value="' . $c_value->code . '"' . (!empty($_POST['category']) && $_POST['category'] == $c_value->code ? 'selected' : '') . '>' . filter($c_value->category) . '</option>';
                                }
                            } ?>
                        </select>
                    </div>


                    <?php /*
                        <div class="col-md-3">
                            <select name="order_time" class="form-control mb-5">
                                <option value="" selected disabled>-- Production Time --</option>
                                <?php
                                $order_times = config_item('order_time');
                                if (!empty($order_times)) {
                                    foreach ($order_times as $value) {
                                        echo '<option value="' . $value . '"' . (!empty($_POST['order_time']) && $_POST['order_time'] == $value ? 'selected' : '') . '>' . filter($value) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    */?>

                    <div class="col-md-3">
                        <select name="search[status]" class="form-control mb-5">
                            <option value="" selected disabled>-- Select Status --</option>
                            <?php
                            if (!empty(config_item('order_status'))) {
                                foreach (config_item('order_status') as $s_value) {
                                    if ($s_value != 'pending'){
                                    ?>

                                    <option value="<?php echo $s_value; ?>" <?= (!empty($_POST['search']['status']) && $_POST['search']['status'] == $s_value ? 'selected' : '') ?>>
                                        <?php echo filter($s_value); ?>
                                    </option>
                                <?php } }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <select name="party_code" class="selectpicker mb-5 form-control"
                                data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>-- Select Client --</option>
                            <?php
                            if (!empty($allClients)) {
                                foreach ($allClients as $key => $client) { ?>
                                    <option value="<?php echo $client->code; ?>" <?= (!empty($_POST['party_code']) && $_POST['party_code'] == $client->code ? 'selected' : '') ?>>
                                        <?php echo $client->code . '-' . filter($client->name) . " ( " . $client->address . " ) "; ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From (YYYY-MM-DD)"
                                   value="<?= (!empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')) ?>">
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To (YYYY-MM-DD)"
                                   value="<?= (!empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')) ?>">
                            <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <input type="submit" name="show" value="Show" class="btn btn-primary">
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <hr class="none">

            <?php if (empty($allItems)) { ?>
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">All Order</h4>
                    <?php
                    if (!empty($allOrder)) { ?>
                        <table class="table table-bordered table2">
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Vou No</th>
                                <th>Client's Name</th>
                                <th>Weight (Kg)</th>
                                <th>Quantity</th>
                                <th>Total Amount (Tk)</th>
                                <!--<th>Status</th>-->
                                <th class="none" width="165">Action</th>
                            </tr>


                            <?php
                            $total_bill = $total_quantity = $totalwhight = [];

                            foreach ($allOrder as $key => $row) {
                                ?>
                                <tr>
                                    <td style="width: 50px;"> <?php echo($key + 1); ?> </td>
                                    <td> <?php echo $row->sap_at; ?> </td>
                                    <td> <?php echo $row->voucher_no; ?> </td>
                                    <td> <?php echo filter($row->name); ?> </td>
                                    <td>
                                        <?php
                                        $voucher_no = $row->voucher_no;
                                        $weight     = get_sum('sapitems', 'total_weight', ['voucher_no' => $voucher_no, 'trash' => 0]);

                                        $weight = !empty($weight) ? $weight : 0;
                                        echo $weight;
                                        $totalwhight[] += $weight;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $row->total_quantity;
                                        $total_quantity[] += $row->total_quantity;
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $row->total_bill;
                                        $total_bill[] += $row->total_bill; ?>
                                    </td>
                                    <td class="none text-center">
                                        <?php
                                        $status = get_result('sapitems', ['voucher_no' => $row->voucher_no], 'status', 'status');

                                        if (!empty($status)) {
                                            if ($status[0]->status == 'processing' && count($status) == 1) { ?>
                                                <a title="Sale" class="btn btn-success"
                                                   href="<?php echo site_url("sale/order/sale/$row->voucher_no"); ?>">
                                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                                </a>
                                            <?php }
                                        } ?>


                                        <a title="View" class="btn btn-primary"
                                           href="<?php echo site_url("sale/order/preview/$row->voucher_no"); ?>">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                        <a title="Edit" class="btn btn-warning"
                                           href="<?php echo site_url("sale/order/edit/$row->voucher_no"); ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>

                                        <?php if ($this->session->userdata['privilege'] !== "user") { ?>
                                            <a title="Delete"
                                               onclick="return confirm('Are you sure to delete this data?');"
                                               class="btn btn-danger"
                                               href="<?php echo site_url("sale/order/delete/$row->voucher_no"); ?>">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Total</strong></td>
                                <th><?php echo f_number(array_sum($totalwhight), 3); ?> Kg</th>
                                <th><?php echo array_sum($total_quantity); ?> </th>
                                <th><?php echo f_number(array_sum($total_bill)); ?> Tk</th>
                                <!--<th></th>-->
                                <th class="none"></th>
                            </tr>
                        </table>
                    <?php } else {
                        echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
                    } ?>
                </div>
            <?php } else { ?>

                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="text-center hide" style="margin-top: 0px;">All Order</h4>
                    <?php
                    echo form_open('', ['id' => 'form']);
                    if (!empty($allItems)) {
                        $count = count($allItems);
                        ?>

                        <table class="table table-bordered table2">
                            <tr>
                                <th width="50">SL</th>
                                <th>Date</th>
                                <th>Vou No</th>
                                <th>Client's Name</th>
                                <th>Product</th>
                                <th>Weight (Kg)</th>
                                <th>Quantity</th>
                                <th>Total Amount (Tk)</th>
                                <th>Status</th>
                                <th class="none" width="170">Action</th>
                            </tr>
                            <?php
                            $total_amount = $total_quantity = $total_weight = 0;
                            foreach ($allItems as $key => $value) {
                                $total_weight   += $value['total_weight'];
                                $total_quantity += $value['total_quantity'];
                                $total_amount   += $value['total_amount'];
                                ?>
                                <tr>
                                    <th colspan="10">Category: <?= filter($value['category']) ?> || Order
                                        Time: <?= filter($value['order_time']) ?></th>
                                </tr>

                                <?php foreach ($value['orderItem'] as $_key => $row) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo($_key + 1); ?>
                                            <input type="hidden" name="sap_id[]" value="<?= $row['id'] ?>">
                                        </td>
                                        <td> <?= $row['sap_at'] ?> </td>
                                        <td> <?= $row['voucher_no'] ?> </td>
                                        <td> <?= filter($row['party_name']) ?> </td>
                                        <td> <?= filter($row['product_name']) ?> </td>
                                        <td> <?= $row['total_weight'] ?> </td>
                                        <td> <?= $row['quantity'] ?> </td>
                                        <td> <?= $row['amount'] ?> </td>
                                        <td> <?php
                                            if ($row['status'] == 'pending') {
                                                $color = 'label-warning';
                                            } else if ($row['status'] == 'processing') {
                                                $color = 'label-info';
                                            } else {
                                                $color = 'label-success';
                                            }
                                            echo '<span class="label ' . $color . '" style="font-size: 14px;">' . filter($row['status']) . "</span>";
                                            ?>
                                        </td>
                                        <td class="none text-center">
                                            <a title="View" class="btn btn-primary"
                                               href="<?php echo site_url("sale/order/preview/" . $row['voucher_no']); ?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>

                                            <?php if ($row['status'] == 'pending' && $this->session->userdata['privilege'] !== "user") { ?>

                                                <a title="Edit" class="btn btn-warning"
                                                   href="<?php echo site_url("sale/order/edit/" . $row['voucher_no']); ?>">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>

                                                <a title="Delete"
                                                   onclick="return confirm('Are you sure to delete this data?');"
                                                   class="btn btn-danger"
                                                   href="<?php echo site_url("sale/order/delete/" . $row['voucher_no']); ?>">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                                    <th><?= $value['total_weight'] ?> Kg</th>
                                    <th><?= $value['total_quantity'] ?> </th>
                                    <th><?= $value['total_amount'] ?> Tk</th>
                                    <th class="none" colspan="2"></th>
                                </tr>
                                <input type="hidden" name="order_time[]"
                                       value="<?= (!empty($value['order_time']) ? $value['order_time'] : '') ?>">
                                <input type="hidden" name="category_code[]"
                                       value="<?= (!empty($value['category_code']) ? $value['category_code'] : '') ?>">
                                <input type="hidden" name="total_weight[]"
                                       value="<?= (!empty($value['total_weight']) ? $value['total_weight'] : '') ?>">
                                <?php
                                if ($key < $count) {
                                    echo '<tr> <td colspan="10">&nbsp;</td> </tr>';
                                }
                            }
                            ?>

                            <tr>
                                <td colspan="5" class="text-right"><strong>Grand Total</strong></td>
                                <th><?= f_number($total_weight) ?> Kg</th>
                                <th><?= f_number($total_quantity) ?> </th>
                                <th><?= f_number($total_amount) ?> Tk</th>
                                <th class="none" colspan="2"></th>
                            </tr>
                        </table>


                        <?php if ($value['orderItem'][0]['status'] == 'pending') { ?>
                            <input class="pull-right btn btn-primary" type="submit" name="processing"
                                   value="Processing">
                        <?php } ?>

                        <?php
                        form_close();
                    } else {
                        echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
                    } ?>
                </div>
            <?php } ?>

            <div class="panel-footer"> &nbsp;</div>
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

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
