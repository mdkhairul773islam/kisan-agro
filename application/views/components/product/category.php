<style>
    @media print {

        aside,
        nav,
        .none,
        .panel-heading,
        .panel-footer {
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

        .print_banner_logo {
            width: 19%;
            float: left;
        }

        .print_banner_logo img {
            margin-top: 10px;
        }

        .print_banner_text {
            width: 80%;
            float: right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin: 0;
            line-height: 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">

        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Category</h1>

                    <div class="pull-right">
                        <button title="Add Unit" class="btn btn-success" data-toggle="modal" data-target="#addData">
                            <i class="fa fa-plus"></i> Add New
                        </button>

                        <button title="Add Unit" class="btn btn-primary" onclick="window.print()">
                            <i class="fa fa-print""></i> Print
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-body">

                <!--<h4 class="hide text-center" style="margin-top: 0px;">All Products</h4>-->
                <div class="col-md-12 text-center hide">
                    <h3>All Category</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40">SL</th>
                            <th>Category</th>
                            <th width="120" class="none"> Action</th>
                        </tr>

                        <?php if (!empty($results)) {
                            foreach ($results as $key => $row) { ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->category; ?></td>
                                    <td class="none">
                                        <a class="btn btn-warning" title="Edit" href="" onclick="updateData('<?= $row->id ?>')" data-toggle="modal"
                                           data-target="#updateData">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>

                                        <a class="btn btn-danger" title="Delete"
                                           onclick="return confirm('Are you sure want to delete this data?');"
                                           href="<?php echo site_url('product/category/delete/' . $row->id); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <th colspan="3" class="text-center">No records found....!</th>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<!-- Add Modal -->
<div class="modal fade" id="addData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <?php echo form_open('product/category/store'); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Unit</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="control-label">Category <span class="req">*</span> </label>
                    <input type="text" name="category" class="form-control" autocomplete="off" required>
                </div>
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
<div class="modal fade" id="updateData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <?php echo form_open('product/category/update'); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Update Category</h4>
            </div>

            <div class="modal-body">

                <input type="hidden" id="categoryId" name="id">

                <div class="form-group">
                    <label for="" class="control-label">Category <span class="req">*</span> </label>
                    <input type="text" id="categoryName" name="category" class="form-control" autocomplete="off" required>
                </div>
            </div>

            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="update" value="Update" class="btn btn-primary">
            </div>
        </div>
        <?php echo form_close() ?>
    </div>
</div>

<script>
    function updateData(categoryId) {

        $('#categoryId').val('');
        $('#categoryName').val('');

        var url = "<?php echo site_url('product/category/edit/'); ?>/" + categoryId;
        $.post( url, function( data ) {

            var data = JSON.parse(data);

            $('#categoryId').val(data.id);
            $('#categoryName').val(data.category);
        });
    }
</script>