<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left"> Production Details </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide" style="margin-top: 0px;">Production Details</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="10"><strong>Date:</strong> <?php echo $productFrom[0]->created; ?> || <strong>Voucher
                                    No:</strong>
                            <?php echo $productFrom[0]->voucher_no; ?></th>
                        </tr>
                        <tr>
                            <th colspan="10" class="bg-info">Row Product</th>
                        </tr>

                        <tr>
                            <th width="40">SL</th>
                            <th width="100">Code</th>
                            <th>Product Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Waste(%)</th>
                            <th>Waste Qty.</th>
                            <th>Wast Amount</th>
                            <th>Amount</th>
                        </tr>

                        <?php
                        $totalQty = $totalWasteQty = $totalAmount = $totalWasteAmount = 0;
                        if (!empty($productFrom)) {
                            foreach ($productFrom as $key => $row) {

                                $totalQty         += $row->quantity;
                                $totalWasteQty    += $row->waste_quantity;
                                $wasteAmount      = $row->waste_quantity * $row->purchase_price;
                                $amount           = $row->quantity * $row->purchase_price;
                                $totalWasteAmount += $wasteAmount;
                                $totalAmount      += $amount;
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $row->product_code; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->unit; ?></td>
                                    <td><?php echo $row->purchase_price; ?></td>
                                    <td><?php echo $row->quantity; ?></td>
                                    <td><?php echo $row->waste_percentage; ?></td>
                                    <td><?php echo $row->waste_quantity; ?></td>
                                    <td><?php echo $wasteAmount; ?></td>
                                    <td><?php echo $amount; ?></td>
                                </tr>
                            <?php }
                        } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo $totalQty; ?></th>
                            <th></th>
                            <th><?php echo $totalWasteQty; ?></th>
                            <th><?php echo $totalWasteAmount; ?></th>
                            <th><?php echo $totalAmount; ?></th>
                        </tr>
                    </table>

                    <table class="table table-bordered">

                        <tr>
                            <th colspan="7" class="bg-info">Finish Product</th>
                        </tr>

                        <tr>
                            <th width="40">SL</th>
                            <th width="100">Code</th>
                            <th>Product Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>

                        <?php
                        $totalQty = $subtotal = 0;
                        if (!empty($productTo)) {
                            foreach ($productTo as $key => $row) {
                                $amount   = $row->quantity * $row->purchase_price;
                                $subtotal += $amount;
                                $totalQty += $row->quantity;
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $row->product_code; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->unit; ?></td>
                                    <td><?php echo $row->purchase_price; ?></td>
                                    <td><?php echo $row->quantity; ?></td>
                                    <td><?php echo $amount; ?></td>
                                </tr>
                            <?php }
                        } ?>
                        <tr>
                            <th colspan="5" class="text-right">Total</th>
                            <th><?php echo $totalQty; ?></th>
                            <th><?php echo $subtotal; ?></th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<script>
    $('#datetimepickerSMSFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerSMSTo').datetimepicker({
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