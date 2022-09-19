<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Commission</h1>
                </div>
            </div>
            
            <div class="panel-body">
                <?php
                    $attr = array("class" => "form-horizontal");
                    echo form_open("", $attr);
                ?>
                <div class="form-group">
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date[from]" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="date[to]" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
        
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Sr Comission</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <h4 class="text-center hide" style="margin-top: 0px;">All Sr Comission</h4>

                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th width="100">Date</th>
                        <th>Name</th>
                        <th width="110">Mobile</th>
                        <th>Address</th>
                        <th width="150">Amount</th>
                        <th class="none" style="width: 115px;">Action</th>
                    </tr>
                    <?php foreach($sr_comission as $key => $value){ ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo $value->name; ?></td>
                        <td><?php echo $value->mobile; ?></td>
                        <td><?php echo $value->address; ?></td>
                        <td><?php echo $value->amount; ?></td>
                        <td  class="none">
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('sr/sr/edit_comission_show/'.$value->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="return confirm('Do you want to delete this comission?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('sr/sr/deletecomission/'.$value->id);?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
