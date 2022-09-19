<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Search Payment</h1>
                </div>
            </div>
            <div class="panel-body none">
                <?php
                    $attr = array("class" => "row");
                    echo form_open("", $attr);
                ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="search[emp_id]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                            <option value="" disabled selected>Select Employee</option>
                            <?php if (!empty($employee)) {
                                foreach ($employee as $key => $value) {
                                    echo '<option value="' . $value->emp_id . '" ' . (!empty($emp_id) && $emp_id == $value->emp_id ? "selected" : "") . '>' . get_filter($value->name) . '</option>';
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="dateFrom" value="" class="form-control" placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group date" id="datetimepickerTo">
                            <input type="text" name="dateTo" value="" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" name="show" value="Show" class="btn btn-info">
                    </div>
                </div>
                <?php echo form_close(); ?>
                <hr style="margin-bottom: 0;">
            </div>
            
            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30">SL</th>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Paid</th>
                        <th width="65">Action</th>
                    </tr>
                    
                    <?php
                        $totalPaid = 0;
                        if(!empty($results)){
                            foreach($results as $key => $row){
                                $totalPaid += $row->amount;
                            ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->created; ?></td>
                                    <td><?php echo $row->emp_id; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td><?php echo $row->designation; ?></td>
                                    <td><?php echo $row->department; ?></td>
                                    <td><?php echo $row->amount; ?></td>
                                    <td>
                                        <a title="Delete" class="btn btn-danger" onclick="return confirm('Do you want to delete this data?')" href="<?php echo site_url('salary/payment/delete/'.$row->id); ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        }
                    ?>
                    <tr>
                        <th colspan="7" class="text-right">Total</th>
                        <th><?php echo f_number($totalPaid); ?></th>
                    </tr>
                </table>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM',
        useCurrent: false
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>