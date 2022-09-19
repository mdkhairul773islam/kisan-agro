<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .panel .hide{
            display: block !important;
        }
    }
    .sm-table{
        max-width:800px;
        margin:0 auto;
    }
</style>
<div class="container-fluid">
   <div class="row">   
        
        <?php echo $this->session->flashdata('confirmation'); ?>
    
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <div class="pull-left">
                        <h1>Designation</h1>
                    </div>
                    
                    <div class="pull-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fa fa-plus"></i> Add New</button>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30">SL</th>
                        <th>Designation</th>
                        <th width="125">Action</th>
                    </tr>
                    
                    <?php if(!empty($results)) {
                        foreach($results as $key => $row){ ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $row->designation; ?></td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#updateModal" onclick="getDesignationInfo('<?= $row->id ?>', '<?= $row->designation ?>')"><i class="fa fa-pencil-square-o"></i></a>
                                    <a class="btn btn-danger" onclick="return confirm('Do you want to delete this data?');" href="<?php echo site_url('employee/designation/delete/'.$row->id) ;?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


<!-- create model -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New</h4>
            </div>
        
            <?php echo form_open('employee/designation/store'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <label>Designation <span class="req">*</span></label>
                    <input type="text" name="designation" class="form-control" autocomplete="off" required>
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


<!-- edit model -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit</h4>
            </div>
        
            <?php echo form_open('employee/designation/update'); ?>
            <div class="modal-body">
                
                <input type="hidden" id="designationId" name="id">
                <input type="hidden" id="oldDesignation" name="old_designation">
                
                <div class="form-group">
                    <label>Designation <span class="req">*</span></label>
                    <input type="text" id="designationName" name="designation" class="form-control" autocomplete="off" required>
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

<script>
    
    function getDesignationInfo(id, designation){
        
        $('#designationId').val();
        $('#oldDesignation').val();
        $('#designationName').val();
        
        console.log(id);
        console.log(designation);
        
        if(id != '' && designation != ''){
            $('#designationId').val(id);
            $('#oldDesignation').val(designation);
            $('#designationName').val(designation);
        }
    }
</script>

