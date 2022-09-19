<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Finish Products</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body none">
                <?php
                    echo $this->session->flashdata('deleted');
                    echo form_open("product/product/all_product");
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <select name="search[code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>Select Product</option>
                            <?php
                            if (!empty($productList)) {
                                foreach ($productList as $key => $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo $row->code . '-' . filter($row->name); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="search[category_id]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" selected disabled>Select Category</option>
                            <?php
                            if (!empty($categoryList)) {
                                foreach ($categoryList as $key => $value) { ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->category; ?></option>
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
                <div class="panel-body">
                    <!-- Print banner -->
                    <?php $this->load->view('components/print'); ?>

                    <h4 class="hide text-center" style="margin-top: 0px;">Finish Product List</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="DataTable">
                            <thead>
                            <tr>
                                <th width="10">SL</th>
                                <th>P.ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <!--<th>Weight</th>-->
                                <th>Unit</th>
                                <th>Bag Size</th>
                                <th>P.Price</th>
                                <th>MRP.Price</th>
                                <th>D.P Price</th>
                                <th>T.P Price</th>
                                <th width="80"> Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($results as $key => $row) { ?>
                                <tr>
                                    <td> <?php echo($key + 1); ?> </td>
                                    <td> <?php echo $row->code; ?> </td>
                                    <td> <?php echo filter($row->name); ?> </td>
                                    <td> <?php echo filter($row->category); ?> </td>
                                    <!--<td> <?php //echo $row->weight; ?> </td>-->
                                    <td> <?php echo filter($row->unit); ?> </td>
                                    <td> <?php echo $row->bag_size > 1 ? $row->bag_size: ''; ?> </td>
                                    <td> <?php echo $row->purchase_price; ?> </td>
                                    <td> <?php echo $row->sale_price; ?> </td>
                                    <td> <?php echo $row->dealer_price; ?> </td>
                                    <td> <?php echo $row->tp_price; ?> </td>
                                    <td class="none">
                                        <a class="btn btn-warning" title="Edit" href="<?php echo site_url('product/product/edit/' . $row->id); ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        <?php if ($this->session->userdata['privilege'] !== "user") { ?>
                                        <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure want to delete this Product?');" href="<?php echo site_url('product/product/delete/' . $row->code); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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