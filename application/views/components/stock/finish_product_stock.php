<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet"
      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Finish Product Stock</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                echo $this->session->flashdata('deleted');
                echo form_open("");
                ?>

                <div class="row">
                    <div class="col-md-3">
                        <select name="product_code" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>-- Select Product --</option>
                            <?php
                            if (!empty($productList)) {
                                foreach ($productList as $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->code . '-' . filter($row->name); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="category_id" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>Select Category</option>
                            <?php
                            if (!empty($categoryList)) {
                                foreach ($categoryList as $row) { ?>
                                    <option value="<?php echo $row->id; ?>">
                                        <?php echo filter($row->category); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

            <hr class="none" style="margin: 5px;">


            <?php if (!empty($results)) { ?>
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="hide text-center" style="margin-top: 0px;">Finish Product Stock</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="DataTable">
                            <thead>
                            <tr>
                                <th style="width: 40px;">SL</th>
                                <th>Batch No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Bag Bize</th>
                                <th>Quantity</th>
                                <th>P.Price (Tk)</th>
                                <th>S.Price (Tk)</th>
                                <th>P.Amount (Tk)</th>
                                <th>S.Amount (Tk)</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $totalPurchaseAmount = $totalQuantity = $totalSaleAmount = 0;
                            foreach ($results as $key => $row) {

                                $purchaseAmount = $row->purchase_price * $row->quantity;
                                $saleAmount     = $row->sale_price * $row->quantity;

                                $totalPurchaseAmount += $purchaseAmount;
                                $totalSaleAmount     += $saleAmount;
                                $totalQuantity       += $row->quantity; ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->batch_no; ?></td>
                                    <td><?php echo $row->product_code; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->category; ?></td>
                                    <td><?php echo $row->unit; ?></td>
                                    <td><?php echo $row->bag_size > 1 ? $row->bag_size : ''; ?></td>
                                    <td><?php echo $row->quantity; ?></td>
                                    <td><?php echo $row->purchase_price; ?></td>
                                    <td><?php echo $row->sale_price; ?></td>
                                    <td><?php echo f_number($purchaseAmount); ?></td>
                                    <td><?php echo f_number($saleAmount); ?></td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>

                            <tfooter>
                                <tr>
                                    <th colspan="7" class="text-right">Total</th>
                                    <th><?= f_number($totalQuantity) ?></th>
                                    <th></th>
                                    <th></th>
                                    <th><?= f_number($totalPurchaseAmount) ?></th>
                                    <th><?= f_number($totalSaleAmount) ?></th>
                                </tr>
                            </tfooter>
                        </table>
                    </div>
                </div>
            <?php } else {
                echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
            } ?>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function () {
        $('#DataTable').DataTable({
            dom: 'Bfrtip',
            "paging": false,
            "info": false,
            lengthMenu: [
                [25, 50, 100, 250, 500, -1],
                ['25', '50', '100', '250', '500', 'all']
            ],
            buttons: [
                /*'pageLength',*/
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, 'colvis'
            ]
        });
    });
</script>
