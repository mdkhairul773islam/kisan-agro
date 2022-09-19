<style type="text/css">
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

    .table-title {
        font-size: 20px;
        color: #333;
        background: #f5f5f5;
        text-align: center;
        border-left: 1px solid #ddd;
        border-top: 1px solid #ddd;
        border-right: 1px solid #ddd;
    }
</style>
<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Products</h1>

                    <div class="pull-right">
                        <button title="Add Unit" class="btn btn-success" data-toggle="modal" data-target="#createModel">
                            <i class="fa fa-plus"></i> Add New
                        </button>

                        <button title="Add Unit" class="btn btn-primary" onclick="window.print()">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                
                <div class="row">
                    <?php echo form_open(); ?>
                    <div class="col-md-3">
                        <div class="form-group"> 
                            <select name="product_type" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Product Type</option>
                                <?php
                                $typeList = config_item('product_type');
                                foreach($typeList as $item){
                                    echo '<option value="'. $item.'">'. filter($item) .'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <div class="col-md-12 text-center hide">
                    <h3>All Materials</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="DataTable">
                        <thead>
                        <tr>
                            <th width="40">SL</th>
                            <th>Product Name</th>
                            <th>Specification</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>P.Price</th>
                            <th>Stock Alert</th>
                            <!--<th>Lead time</th>-->
                            <th>Type</th>
                            <th>Status</th>
                            <th width="100" class="none"> Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($results)) {
                            foreach ($results as $key => $row) {
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <!--<td><?php //echo $row->code; ?></td>-->
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->specification; ?></td>
                                    <td><?php echo $row->category; ?></td>
                                    <td><?php echo $row->unit; ?></td>
                                    <td><?php echo $row->purchase_price; ?></td>
                                    <td><?php echo $row->stock_alert; ?></td>
                                    <!--<td><?php //echo $row->lead_time; ?></td>-->
                                    <td><?php echo filter($row->type); ?></td>
                                    <td><?php echo filter($row->status); ?></td>
                                    <td class="none">
                                        <a class="btn btn-warning" title="Edit" href=""
                                           onclick="updateModel('<?= $row->id ?>')" data-toggle="modal"
                                           data-target="#updateModel">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>

                                        <a class="btn btn-danger" title="Delete"
                                           onclick="return confirm('Are you sure want to delete this data?');"
                                           href="<?php echo site_url('purchase/product/delete/' . $row->id); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<!-- Add Modal -->
<div class="modal fade" id="createModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <?php echo form_open('purchase/product/store'); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Product</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="control-label">Product Name <span class="req">*</span> </label>
                    <input type="text" name="name" class="form-control" autocomplete="off" required>
                </div>
                
                <div class="form-group">
                    <label for="" class="control-label">Specification </label>
                    <textarea class="form-control" name="specification" autocomplete="off"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="" class="control-label">Category <span class="req">*</span> </label>
                    <select class="form-control" name="category_id" id="categoryList" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Category</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Purchase Price <span class="req">*</span> </label>
                    <input type="number" name="purchase_price" class="form-control" placeholder="0" autocomplete="off" step="any" required>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Unit <span class="req">*</span> </label>
                    <select class="form-control" name="unit" id="unitList" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Unit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Stock Alert <span class="req">*</span> </label>
                    <input type="number" name="stock_alert" class="form-control" placeholder="0" autocomplete="off" required>
                </div>
                
                <div class="form-group">
                    <label for="" class="control-label">Product Type <span class="req">*</span> </label>
                    <select class="form-control" name="product_type" id="productTypeList" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Type</option>
                    </select>
                </div>
                
                <!--<div class="form-group">
                    <label for="" class="control-label">Lead time<span class="req"></span> </label>
                    <select name="lead_time" class="form-control" id="leadTimeList" data-show-subtext="true" data-live-search="true">
                      <option value="" selected>Lead Time</option>
                    </select>
                </div>-->
            </div>

            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="save" value="Save" class="btn btn-primary">
            </div>
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<!-- edit Modal -->
<div class="modal fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <?php echo form_open('purchase/product/update'); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Update Materials</h4>
            </div>

            <div class="modal-body">

                <input type="hidden" id="productId" name="id">
                <input type="hidden" id="productCode" name="code">

                <div class="form-group">
                    <label for="" class="control-label">Product Name <span class="req">*</span> </label>
                    <input type="text" name="name" id="productName" class="form-control" autocomplete="off" required>
                </div>
                
                 <div class="form-group">
                    <label for="" class="control-label">Specification </label>
                    <textarea class="form-control" id="productSpecification" name="specification" autocomplete="off"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="" class="control-label">Category <span class="req">*</span> </label>
                    <select class="form-control" name="category_id" id="updateCategoryList" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Category</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Purchase Price <span class="req">*</span> </label>
                    <input type="number" name="purchase_price" id="productPurchasePrice" placeholder="0" step="any" class="form-control"
                           autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Unit <span class="req">*</span> </label>
                    <select class="form-control" name="unit" id="updateUnitList" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Unit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Stock Alert <span class="req">*</span> </label>
                    <input type="number" name="stock_alert" id="productStockAlert" placeholder="0" class="form-control" autocomplete="off"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="" class="control-label">Product Type <span class="req">*</span> </label>
                    <select class="form-control" name="product_type" id="updateProductTypeList" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Type</option>
                    </select>
                </div>

                <!--<div class="form-group">
                    <label for="" class="control-label">Lead time<span class="req"></span> </label>
                    <select name="lead_time" class="form-control" id="updateleadTimeList" data-show-subtext="true" data-live-search="true">
                      <option value="" selected>Lead Time</option>
                    </select>
                </div>-->
            </div>

            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="update" value="Update" class="btn btn-primary">
            </div>
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

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
    
    function getCategoryList() {

        $('#categoryList').empty();
        $.post('<?= site_url('product/category/ajaxCategoryList') ?>').success(function (response) {
            $('#categoryList').append(response);
            $('#categoryList').selectpicker('refresh');
        });
    }
    getCategoryList();
    
    
    function getUnitList() {

        $('#unitList').empty();
        $.post('<?= site_url('purchase/product/ajaxUnitList') ?>').success(function (response) {
            $('#unitList').append(response);
            $('#unitList').selectpicker('refresh');
        });
    }
    getUnitList();
    
    function getProductTypeList() {

        $('#productTypeList').empty();
        $.post('<?= site_url('purchase/product/ajaxProductTypeList') ?>').success(function (response) {
            $('#productTypeList').append(response);
            $('#productTypeList').selectpicker('refresh');
        });
    }
    getProductTypeList();
    
    function getLeadTimeList() {

        $('#leadTimeList').empty();
        $.post('<?= site_url('purchase/product/ajaxLeadTimeList') ?>').success(function (response) {
            $('#leadTimeList').append(response);
            $('#leadTimeList').selectpicker('refresh');
        });
    }
    getLeadTimeList();


    function updateModel(productId) {

        $('#productId').val('');
        $('#productCode').val('');
        $('#productName').val('');
        $('#productPurchasePrice').val('');
        $('#productStockAlert').val('');


        $.post("<?= site_url('purchase/product/edit') ?>", {id: productId}).success(function (response) {

            var data = JSON.parse(response);
            
            $('#productId').val(data.id);
            $('#productCode').val(data.code);
            $('#productName').val(data.name);
            $('#productSpecification').val(data.specification);
            $('#productPurchasePrice').val(data.purchase_price);
            $('#productStockAlert').val(data.stock_alert);
            $('#productUnit').val(data.unit);
            $('#productLeadTime').val(data.lead_time);

            $('#updateCategoryList').empty();
            $.post('<?= site_url('product/category/ajaxCategoryList') ?>', {category_id: data.category_id}).success(function (response) {
                $('#updateCategoryList').append(response);
                $('#updateCategoryList').selectpicker('refresh');
            });
            
            $('#updateProductTypeList').empty();
            $.post('<?= site_url('purchase/product/ajaxProductTypeList') ?>', {select: data.type}).success(function (response) {
                $('#updateProductTypeList').append(response);
                $('#updateProductTypeList').selectpicker('refresh');
            });
            
            $('#updateUnitList').empty();
            $.post('<?= site_url('purchase/product/ajaxUnitList') ?>', {select: data.unit}).success(function (response) {
                $('#updateUnitList').append(response);
                $('#updateUnitList').selectpicker('refresh');
            });  
              
            $('#updateleadTimeList').empty();
            $.post('<?= site_url('purchase/product/ajaxLeadTimeList') ?>', {select: data.lead_time}).success(function (response) {
                $('#updateleadTimeList').append(response);
                $('#updateleadTimeList').selectpicker('refresh');  
            });
        })
    }
</script>