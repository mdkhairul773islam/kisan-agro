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
       
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Salary</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i>Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <?php $this->load->view('components/print'); ?>
                <hr class="hide" style="border-bottom: 1px solid #ccc;">
                <h4 class="text-center hide" style="margin-top: -10px;">All Salary</h4>
                
                <?php if($rows){ ?>
                 <?php
                $attr = array(
                    "class" => "form-horizontal",
                    "id" => "search_data"
                );
                echo form_open("employee/employee/report", $attr);
                ?>
            
                    <table class="table table-bordered table-striped text-left none"  style="width:800px;">
                        <tr>
                            
                            <th>
                                <select name="name"  class="form-control selectpicker" data-show-subtext="true" data-live-search="true" >
                                    <option value="">-- Select Employee --</option>
                                     <?php foreach($employees as $emp){  ?>
                                        <option value="<?php echo $emp->name; ?>">
                                            <?php echo $emp->emp_id.'-'.$emp->name; ?>
                                        </option>
                                     <?php } ?>
                                </select>
                                
                            </th>
                            
                            <th>
                                <select name="type"  class="form-control selectpicker" data-show-subtext="true" data-live-search="true" required>
                                    <option value="" selected disabled> Select  Group  </option>
                                    <option  value="1">Group 1</option>
                                    <option  value="2">Group 2</option>
                                    <option  value="3">Group 3</option>
                                </select>
                            </th>
                            
                            <th>
                                <div class="input-group date datetimepickerTo" >
                                    <input type="text" name="from" class="form-control"  placeholder="From Date"  >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </th>
                            
                            
                            <th>
                                <div class="input-group date datetimepickerTo" >
                                    <input type="text" name="to" class="form-control"  placeholder="To Date"  >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </th> 
                            <th>
                                <input type="submit" value="Show" name="show" class="btn btn-primary">
                            </th>
                        </tr>
                    </table>
                   
                   
                   
                <?php  
                        /*$all_employee = $this->action->readOrderBy('employee','emp_id',array(),'asc');
                        
                        foreach($all_employee as $emp){
                            
                            $adjust_previous_month_salary = 0;
                            
                            $rec_salary_each_employee = $this->action->readOrderBy('salary','employee_id,insert_date',array('employee_id'=> $emp->emp_id),'asc');
                            
                            foreach($rec_salary_each_employee as $emp_salary){
                             if($emp_salary->employee_id == '0009'){
                             echo $emp_salary->employee_id.'=';
                             $adjust_salary = $emp_salary->salary-$emp_salary->advance_salary+$adjust_previous_month_salary;
                             echo $adjust_salary;
                             echo '<br>';
                             }
                             
                             //$this->action->update('salary',array('adjust_salry' => $adjust_salary),array('id' => $emp_salary->id));
                             
                             
                             $adjust_previous_month_salary = $emp_salary->adjust_salry;
                            }
                        }*/
                        
                ?>                   
                   
                   
                    <table class="table table-bordered table-striped text-left ">
                        <tr>
                            <th width="55" class="text-center">SL</th>
                            <th>Employee Id</th>
                            <th>Name</th>
                            <th>Group</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Salary</th>
                            <th>Advanced Salary</th>
                            <th>Payable Salary</th>
                            <th>Bonus</th>
                            <th>Extra Bonus Paid</th>
                        </tr>
    
                    <?php 
                        $total_salary=0;
                        $total_bonus=0;
                        $total_advance_salary =0;
                        $total_payable_salary =0;
                        foreach ($rows as $key => $value) { 
                    ?>
                        <tr>
                            <td> 
                                <?php echo $sl=$key+1;  ?>
                            </td>
                            <td> 
                                <?php echo $value->employee_id; ?>
                            </td>
                            <td> 
                                <?php echo $value->employee_name; ?>
                            </td>
                            <td> 
                                <?php echo $value->type; ?>
                            </td>
                            <td> 
                                <?php   
                                    $dept = $this->action->read('employee',array('emp_id' => $value->employee_id)); 
                                    if(!empty($dept)){
                                        echo $dept[0]->dept;
                                    }
                                ?>
                            </td>
                            
                            <td> 
                                <?php echo  $value->employee_designation; ?>
                            </td>
                            
                            <td> 
                                <?php 
                                      $date = explode("-",$value->starting_date);
                                      echo $date[0];
                                ?>
                            </td>                            
                            
                            <td> 
                                <?php 
                                      $m = $date[1];
                                      if($m==1){
                                            echo 'January';
                                        }elseif($m==2){
                                            echo 'February';
                                        }elseif($m==3){
                                           echo 'March'; 
                                        }elseif($m==4){
                                            echo 'April';
                                        }elseif($m==5){
                                            echo 'May';
                                        } elseif($m==6){
                                            echo 'June';
                                        } elseif($m==7){
                                            echo 'July';
                                        } elseif($m==8){
                                            echo 'August';
                                        } elseif($m==9){
                                            echo 'September';
                                        } elseif($m==10){
                                            echo 'October';
                                        } elseif($m==11){
                                            echo 'November';
                                        }else{
                                            echo 'December';
                                        }
                                ?>
                            </td>                              
                            
                            <td> 
                                <?php 
                                    if($value->salary != 0){ 
                                        echo  number_format($value->salary,2); $total_salary = $total_salary+$value->salary;
                                    }    
                                ?>
                            </td>
                     
                            <td> 
                                <?php 
                                    
                                    echo  number_format($value->advance_salary,2); $total_advance_salary = $total_advance_salary+$value->advance_salary;
                                    
                                ?>
                            </td>                     
                     
                            <td> 
                                <?php 
                                  
                                    
                                    if($value->payable_salary == 0){
                                        echo  number_format($value->payable_salary,2);
                                    }elseif($value->payable_salary >0){
                                        echo '<span style="color:orange">';
                                            $ps = abs($value->payable_salary);
                                            echo  number_format($ps,0);
                                            echo '</span>';
                                    }else{
                                        echo '<span style="color:red">';
                                            echo 'over:';
                                            $ps = abs($value->payable_salary);
                                            echo  number_format($ps,0);
                                        echo '</span>';
                                    }
                                    
                                    //$total_payable_salary = $total_payable_salary+$value->payable_salary;
                                 
                                    $last_salary_paid_date = $this->action->readOrderBy('salary','starting_date',array(),'desc');
                                    
                                    if(!empty($last_salary_paid_date)){
                                        if($value->starting_date == $last_salary_paid_date[0]->starting_date){
                                            $total_payable_salary = $total_payable_salary+$value->payable_salary;
                                            
                                        }
                                    }
                                 
                                ?>
                            </td>                     
                     
                     
                            <td> 
                                <?php 
                                    if($value->bonus != 0){  
                                    echo  number_format(($value->bonus+$value->extra_bonus),2); $total_bonus = $total_bonus + $value->bonus; 
                                    }
                                ?>
                            </td>
                            
            
                            <td>
                                <?php 
                                    if($value->bonus != 0){  
                                ?>        
                                    <a href="<?php echo site_url('employee/employee/extra_bonus').'/'.$value->id; ?>"><i class="fa fa-edit"></i>
                                <?php } ?>
                            </td>
                            
                        </tr>
                        
                        <?php } ?>
                        <tr>
                            <td colspan="8" class="text-right" > <b>Total </b></td> 
                            <td> <b><?php echo number_format($total_salary,2);  ?></b></td>
                            <td> <b><?php echo number_format($total_advance_salary,2);  ?></b></td>
                            <td> <b><?php echo number_format($total_payable_salary,2);  ?></b></td>
                            <td> <b><?php echo number_format($total_bonus,2);  ?></b></td>
                            <td>&nbsp;</td>
                        </tr> 
                    </table>
                </div>
                <?php echo form_close(); ?>
               <?php }else{  ?>
                      <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>No Data Found !!</strong> 
                     </div>
               <?php }  ?>
            
            <div class="panel-footer">&nbsp;</div>
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
