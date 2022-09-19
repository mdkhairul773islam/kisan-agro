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
</style>
<div class="container-fluid">
   <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>Search Data</h1>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $attr = array(
                    "class" => "form-horizontal",
                    "id" => "search_data"
                );
                echo form_open("employee/employee/advanced_salary_history", $attr);
                ?>
                <div class="form-group">
                    <div class="col-md-3">
                         <select name="emp_id"    class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                            <option value="">-- Select Employee --</option>
                             <?php 
                             $listing = $this->action->read('employee',array('trash' => 0));
                             foreach($listing as $rowc){  ?>
                                <option value="<?php echo $rowc->emp_id; ?>">
                                    <?php echo $rowc->emp_id.'-'.$rowc->name ?>
                                </option>
                             <?php } ?>
                        </select>
                    </div>    
                    <div class="col-md-3">
                        <div class="input-group date datetimepickerTo" >
                            <input type="text" name="from" class="form-control"  placeholder="From">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="input-group date datetimepickerTo" >
                            <input type="text" name="to" class="form-control" placeholder="To">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <input type="submit" value="Show" name="show" class="btn btn-primary">
                    </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>       
   
   <div class="row">       
       
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Advanced Salary Transaction</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i>Print</a>
                </div>
            </div>

            <div class="panel-body">
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide" style="margin-top: -10px;">Adavanced Salary Transaction</h4>
                <?php if($rows){ ?>
                <table class="table table-bordered table-striped text-left ">
                    <tr>
                        <th width="55" class="text-left">SL</th>
                        <th class="text-left">Employee ID</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Advanced Date</th>
                        <th class="text-left">Amount</th>
                        <th width="110" class="text-left none">Action</th>
                    </tr>

                <?php 
                    $total_amount=0;
                    $total_salary=0;
                    foreach ($rows as $key => $value) { 
                ?>
                    <tr>
                        <td> <?php echo $key+1 ?> </td>
                        <td> 
                            <?php 
                                $id = $value->emp_id;
                                echo $value->emp_id;
                            ?> 
                        </td>
                        
                        <td> 
                            <?php 
                                $id = $value->emp_id;
                                $emp_info = $this->action->read('employee',array('emp_id' => $id));
                                if(!empty($emp_info)){
                                    echo $emp_info[0]->name;
                                }
                            ?> 
                        </td>
                        
                        <td>
                            <?php 
                                $date=date_create($value->advance_date);
                                echo date_format($date,"Y,M,d");
                            ?> 
                        </td>
                        <td> <?php echo  $value->amount; ?> </td>
                        <td class="none">
                            <a class="btn btn-warning" href="<?php echo site_url('employee/employee/advanced_salary_history_edit/'.$value->id); ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-danger" href="<?php echo site_url('employee/employee/advanced_salary_history_delete/'.$value->id); ?>"  onclick="return confirm('Are you sure want to delete ?');" >
                                <i class="fa fa-trash"></i>
                            </a>                            
                        </td>
                    </tr>
                    <?php $total_salary += $value->amount;  } ?>
                    
                    <tr>
                        <td colspan="4" style="text-align:right">Total</td>
                        <td><?php echo number_format($total_salary,2); ?></td>
                        <td></td>
                    </tr>
                </table>
                <?php }else{  ?>
                      <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>No Data Found !!</strong> 
                     </div>
               <?php }  ?>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('.datetimepickerTo').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: false
        });

    });    
</script>