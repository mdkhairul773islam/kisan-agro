<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>
<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer, .dt-buttons, .dataTables_filter, .dataTables_info, .dataTables_paginate {
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

    .wid-100 {
        width: 100px;
    }

    #loading {
        text-align: center;
    }

    #loading img {
        display: inline-block;
    }

</style>

<div class="container-fluid">
    <div class="row">

        <!--<div id="loading">
            <img src="<?php /*echo site_url("private/images/loading-bar.gif"); */ ?>" alt="Image Not found"/>
        </div>-->

        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class=" pull-left">Packaging Material Stock</h1>
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
                        <select name="search[code]" class="selectpicker form-control" data-show-subtext="true"
                                data-live-search="true">
                            <option value="" selected disabled>-- Select Product --</option>
                            <?php
                            if (!empty($all_product)) {
                                foreach ($all_product as $key => $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->code . '-' . filter($row->name); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>


                    <div class="col-md-3">
                        <select name="stock_alert" class="form-control">
                            <option value="" selected>All</option>
                            <option value="stock_alert">Stock Alert</option>
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


            <?php if (!empty($rawStock)) { ?>
                <div class="panel-body">

                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>
                    <!-- <img class="img-responsive print-banner hide" src="<?php // echo site_url('public/img/banner.jpg'); ?>" > -->

                    <h4 class="hide text-center" style="margin-top: 0px;">Packaging Stock</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="DataTable">
                            <thead>
                            <tr>
                                <th style="width: 40px;">SL</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Quantity (Kg)</th>
                                <th>Purchase Price (Tk)</th>
                                <th>Amount (Tk)</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $totalAmount = 0;
                            foreach ($rawStock as $_key => $item) {
                                $color  = '';
                                if ($item['quantity'] <= $item['stock_alert']) {
                                    $color = 'red';
                                }

                                $totalAmount += $item['amount']; ?>
                                <tr>
                                    <td><?= ++$_key ?></td>
                                    <td><?= $item['code'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td style="color: <?= $color ?>;"><?= $item['quantity'] ?></td>
                                    <td><?= $item['price'] ?></td>
                                    <td><?= f_number($item['amount']) ?></td>
                                </tr>
                                <?php
                            } ?>
                            </tbody>

                            <tfooter>
                                <tr>
                                    <th colspan="5" class="text-right">Total</th>
                                    <th><?= f_number($totalAmount) ?></th>
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
<style>
    .btn-group, .btn-group-vertical {
        float: left;
    }

    div.dt-button-collection ul.dropdown-menu {
        min-width: 120px;
    }
</style>
<script>
    $(document).ready(function () {
        $('#DataTable').DataTable({
            dom: 'Bfrtip',
            "paging":   false,
            "info":     false,
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
