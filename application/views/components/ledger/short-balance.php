<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Client Short Balance</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                           onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <div class="row none">
                    <?php echo form_open(); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom"
                                       value="<?= !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : date('Y-m-d'); ?>"
                                       class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo"
                                       value="<?= !empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d'); ?>"
                                       class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                
                <hr style="margin-top: 0px" class="none">
                
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                
                <h4 class="text-center hide" style="margin-top: 0px;">Client Short Balance</h4>
                
                
                <table class="table table-bordered">
                    
                    <tr>
                        <th width="30">SL</th>
                        <th>Date</th>
                        <th class="text-center">Balance (Tk)</th>
                    </tr>
                    
                    <?php 
                    if(!empty($results)){
                    foreach ($results as $key => $row) { ?>
                        <tr>
                            <td><?= ++$key ?></td>
                            <td><?= $row->date ?></td>
                            <td class="text-center"><?= $row->balance ?></td>
                        </tr>
                    <?php }} ?>
                    
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // linking between two date
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#datetimepickerFrom").on("dp.change", function (e) {
        $('#datetimepickerTo').data("DateTimePicker").minDate(e.date);
    });

    $("#datetimepickerTo").on("dp.change", function (e) {
        $('#datetimepickerFrom').data("DateTimePicker").maxDate(e.date);
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
