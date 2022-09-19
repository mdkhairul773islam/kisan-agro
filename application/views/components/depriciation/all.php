<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<div class="container-fluid block-hide">
    <div class="row">
        <?php
            $attribute = array(
                'name' => '',
                'class' => 'form-horizontal',
                'id' => ''
            );
            echo form_open_multipart('', $attribute);
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Depriciation</h1>
                </div>
            </div>
            
            <div class="panel-body no-padding none">
                <div class="no-title">&nbsp;</div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-3">
                            <select name="godown_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>Select Showroom</option>
                                <?php foreach ($showroom as $key => $value) {?>
                                <option value="<?php echo $value->code; ?>" <?php echo $value->code==$godown_code?'selected':''; ?>><?php echo filter($value->name); ?></option>
                                <?php } ?>                             
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="input-group" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" value="<?= !empty($_POST['dateFrom']) ? $_POST['dateFrom']:'' ?>" placeholder="From" class="form-control" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" value="<?= !empty($_POST['dateTo']) ? $_POST['dateTo']:'' ?>" placeholder="To" class="form-control" >
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="btn-group">
                                <input class="btn btn-primary" type="submit" name="show" value="Search">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
            <?php echo form_close(); ?>
        </div>
    </div>
    
    <div class="row">
        <?php  echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Depriciation</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body"  ng-cloak>
                <!-- Print banner Start -->
                <?php $this->load->view('components/print'); ?>
                
                <div class="col-md-12 text-center hide">
                    <h3>All Depriciation</h3>
                </div>
                
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Date</th>
                        <th>Showroom</th>
                        <th>Amount</th>
                        <th>Particulars</th>
                        <th class="none" style="width: 120px;">Action</th>
                    </tr>
                    <?php $total=$i=0; foreach($result as $key => $value){ ?>
                    <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo array_key_exists($value->godown_code, $showroom) ? $showroom[$value->godown_code]->name:'N/A' ?></td>
                        <td><?php echo $value->amount; ?></td>
                        <td><?php echo $value->particulars; ?></td>
                        <td class="none">
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('depriciation/depriciation/edit/'.$value->id);?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                            <a onclick="return confirm('Do you want to delete this Sub Category?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('depriciation/depriciation/delete/'.$value->id); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $total+=$value->amount; } ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td colspan="3"><strong><?= $total ?></strong>TK</td>
                    </tr>
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

