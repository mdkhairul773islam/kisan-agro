<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Expenditure Field</h1>
                    <div class="pull-right">
                        <button class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-print"></i> Add New</button>
                        <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
           
            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                
                <h4 class="hide text-center" style="margin-top: 0px;">Expenditure Field</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" id="DataTable">
                        <thead>
                            <tr>
                                <th style="width: 40px;">SL</th>
                                <th>Field Name</th>
                                <th>Category Name</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($results as $key => $row) {
                               ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->cost_field; ?></td>
                                    <td><?php echo !empty($row->cost_category) ? $row->cost_category : 'N/A'; ?></td>
                                    <td>
                                        <a title="Edit" href="" class="btn btn-warning" onclick="editDate(<?= $row->id ?>)" data-toggle="modal" data-target="#editModal">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>
                                        
                                        <a title="Delete" onclick="return confirm('Do you want to delete this data?')" href="<?php echo site_url('cost/field/delete/'.$row->id);?>" class="btn btn-danger">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Field</h4>
            </div>
            
            <?php echo form_open('cost/field/store'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-lable">Category</label>
                    <select name="cost_category_id" id="costFieldList" class="form-control" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Category</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="control-lable">Field Name</label>
                    <input type="text" name="cost_field" class="form-control" autocomplete="off" required>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="save" value="Save" class="btn btn-primary">
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Field</h4>
            </div>
            
            <?php echo form_open('cost/field/update'); ?>
            <div class="modal-body">
                
                <input type="hidden" name="cost_field_id" id="costFieldId">
                
                <div class="form-group">
                    <label class="control-lable">Category</label>
                    <select name="cost_category_id" id="updateCostFieldList" class="form-control" data-show-subtext="true" data-live-search="true" required>
                        <option value="" selected>Select Category</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="control-lable">Field Name</label>
                    <input type="text" name="cost_field" id="costField" class="form-control" autocomplete="off" required>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="update" value="Update" class="btn btn-primary">
            </div>
            <?php echo form_close(); ?>
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
    
    function getCostCategoryList(){
        $('#costFieldList').empty();
        $.post("<?= site_url('cost/category/ajaxCategoryList') ?>").success(function(response){
            $('#costFieldList').append(response);
            $('#costFieldList').selectpicker('refresh'); 
        });
    }
    getCostCategoryList();
    
    function editDate(id){
        
        $('#costFieldId').val('');
        $('#costField').val('');
        $('#updateCostFieldList').empty();
        
        $.post("<?= site_url('cost/field/edit') ?>", {id: id}).success(function(response){
            var data = JSON.parse(response);
            
            $('#costFieldId').val(data.id);
            $('#costField').val(data.cost_field);
            
            // update category list
            $.post("<?= site_url('cost/category/ajaxCategoryList') ?>", {id: data.cost_category_id}).success(function(response){
                $('#updateCostFieldList').append(response);
                $('#updateCostFieldList').selectpicker('refresh'); 
            });
        });
    }

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
