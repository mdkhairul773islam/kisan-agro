<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <!-- horizontal form -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Expenditure</h1>
                    <div class="pull-right">
                        <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="row none"> 
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[cost_category_id]" id="categoryList" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" >
                              <option value="">Select Expenditure Category</option>
                               <?php foreach ($costCategoryList as $row) {?>
                                 <option value="<?php echo $row->id; ?>"><?php echo filter($row->cost_category); ?></option>
                               <?php } ?>                                 
                             </select> 
                        </div> 
                    </div> 
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[cost_field_id]" id="costFieldList" class="form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Field</option>
                            </select> 
                        </div>                            
                    </div>                            
                                         
                
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group" id="datetimepickerFrom">
                                <input type="text" name="date[from]" placeholder="From" class="form-control" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>   
                    </div>   

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" placeholder="To" class="form-control" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>  
                    </div>  

                    <div class="col-md-1">
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="show" value="Search">
                        </div>
                    </div>
                </div>
                <hr class="none" style="margin-top: 0px;">
                
                <table class="table table-bordered" id="DataTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Field of Expenditure</th>
                            <th>Expenditure Category</th>
                            <th>Description </th>
                            <th>Spender </th>
                            <th>Amount </th>
                            <th class="none" width="115">Action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                            $total=0;
                            foreach ($results as $key => $row) {
                                $total += $row->amount;
                        ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $row->date; ?></td>
                            <td><?php echo filter($row->cost_field); ?></td>
                            <td><?php echo filter($row->cost_category); ?></td>
                            <td><?php echo $row->description; ?></td>
                            <td><?php echo $row->spend_by; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td class="none text-center " style="width: 110px;">
                                 <?php 
                                    $privilege = $this->data['privilege'];
                                    if($privilege != 'user'){
                                ?>
                                        <a title="edit" class="btn btn-warning" href="<?php echo site_url('cost/cost/edit/'.$row->id);?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this Cost?');" href="<?php echo site_url('cost/cost/delete/'.$row->id);?>" ><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                            
                                <?php  } ?>   
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <th colspan="6"><span class="pull-right">Total</span> </th>
                            <th><?php echo f_number($total); ?> TK</th>
                            <th class="none">&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script>
     $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    
    $('#categoryList').on('change', function(){
        var costCategoryId = $(this).val();
        $('#costFieldList').empty();
        $.post("<?= site_url('cost/field/ajaxFieldList') ?>", {cost_category_id: costCategoryId}).success(function(response){
            $('#costFieldList').append(response);
            $('#costFieldList').selectpicker('refresh'); 
        });
    })
    
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

