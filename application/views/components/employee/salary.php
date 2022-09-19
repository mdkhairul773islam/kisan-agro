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
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                     <?php  $addfield=$this->uri->segment('4'); ?>
                        <?php if($addfield){ ?>
                             <h1 class="pull-left">Bonus</h1></h1>
                        <?php }else{ ?>
                             <h1 class="pull-left">Salary</h1>
                        <?php } ?>
                       
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i>Print</a>
                </div>
            </div>

            <div class="panel-body">
                
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php //echo site_url($banner_info[0]->path); ?>">
                
                <hr class="hide" style="border-bottom: 1px solid #ccc;">
                <h4 class="text-center hide" style="margin-top: -10px;">All Salary</h4>
               
                <?php if(!empty($rows)){ ?>
                 <?php
                $attr = array(
                    "class" => "form-horizontal",
                    "id" => "search_data"
                );
                if(($this->uri->segment(4)) == 'bonus'){
                    echo form_open("employee/employee/salary/bonus", $attr);
                }else{
                    echo form_open("employee/employee/salary", $attr);
                }
                
                ?>
                <div class="table-responsive ">
                    <table class="table table-bordered table-striped text-left none "  style="width:400px;">
                        <tr>
                            <th>
                                <?php
                                    //by default calculation for current month
                                    $year = date('Y');
                                    $month = date('m');
                                ?>
                                <select name="year"  class="form-control selectpicker" data-show-subtext="true" data-live-search="true" required>
                                        <option value="<?php echo $year;  ?>"><?php echo $year;  ?></option>
                                     <?php for($y=2019;$y<=2025;$y++){  ?>
                                        <option value="<?php echo $y; ?>">
                                            <?php echo $y; ?>
                                        </option>
                                     <?php } ?>
                                </select>
                                
                            </th>
                            <th>
                                <select name="month"  class="form-control selectpicker" data-show-subtext="true" data-live-search="true" required>
                                        <option selected disabed >- Select Month -</option>
                                        <option value="<?php echo $month;  ?>">
                                            <?php 
                                                    if($month==1){
                                                        echo 'January';
                                                    }elseif($month==2){
                                                        echo 'February';
                                                    }elseif($month==3){
                                                       echo 'March'; 
                                                    }elseif($month==4){
                                                        echo 'April';
                                                    }elseif($month==5){
                                                        echo 'May';
                                                    } elseif($month==6){
                                                        echo 'June';
                                                    } elseif($month==7){
                                                        echo 'July';
                                                    } elseif($month==8){
                                                        echo 'August';
                                                    } elseif($month==9){
                                                        echo 'September';
                                                    } elseif($month==10){
                                                        echo 'October';
                                                    } elseif($month==11){
                                                        echo 'November';
                                                    }else{
                                                        echo 'December';
                                                    }
                                                 
                                                ?>
                                            </option>
                                        </option>
                                         
                                         <?php for($m=1;$m<=12;$m++){  ?>
                                            
                                            <option value="<?php echo $m; ?>">
                                                <?php 
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
                            
                            
                            <th><input type="submit" value="Show" name="show" class="btn btn-primary"></th>
                        </tr>
                    </table>
                <?php echo form_close(); ?>   
                   
                <?php
                    $attr = array(
                        "class" => "form-horizontal",
                        "id" => "search_data"
                    );
                    echo form_open("employee/employee/salary", $attr);
                ?>    
                    <h3>
                        <?php
                            if(isset($_POST['show'])){
                                 $year = $_POST['year'];
                                 $month = $_POST['month'];
                             }else{
                                //by default calculation for current month
                                 $year = date('Y');
                                 $month = date('m');
                            }
                                     $m = $month;
                                     echo 'Salary  For  '; 
             
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
                       
                      &nbsp;&nbsp;<?php  echo ','.$year;  ?>
                       
                        
                    </h3>
                    
                    
                    
                 
                <?php
                    $where = array();
                    if((isset($_POST['month'])) && $_POST['month'] != ''){
                        $month = $this->input->post('month');
                        $year = $this->input->post('year');
                    }else{
                        $month = date('m');
                        $year = date('Y');
                    }
        
                    if((isset($_POST['type'])) && $_POST['type'] != ''){
                        $type = $this->input->post('type');
                        $where['type'] = $type;
                    }else{
                        $where['type'] = '';
                    }
                    $starting_date = $year.'-'.$month.'-'.'01';
                  
                    $where['starting_date'] = $starting_date;

                    $salray_paid_existence = $this->action->read('salary',$where);
                    $salray_existence = count($salray_paid_existence);
                    
                ?>
                
                <?php if(($salray_existence != 0)){ ?>    
                    <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Salary Already Paid !!</strong> 
                    </div>
                <?php } ?> 
                    
                <?php if(($salray_existence == 0)){ ?>       
                    <table class="table table-bordered table-striped text-left ">
                        <tr>
                            <th width="55" class="text-center">SL</th>
                            <th>Employee Id</th>
                            <th>Group</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <?php if($addfield){ ?>
                                <th>Bonus</th>
                            <?php } ?>
                            <th>Basic Salary</th>
                            <th>Current Salary</th>
							<th>Salary Given</th>
                            <th>Advanced Salary</th>
                            <th>Payable Salary</th>
                            
                        </tr>
    
                    <?php 
                        $total_amount=0;
                        $total_salary = 0;
                        $total_advance_salary =0;
                        $total_payable_salary = 0;
                        $total_basic_salary=0;
                        $where =array();
                        foreach ($rows as $key => $value) { 
                            
                            //advance salary calculation
                             if(isset($_POST['show'])){
                                 $year = $_POST['year'];
                                 $month = $_POST['month'];
                                 $from = $year.'-'.$month.'-01';
                                 $to = $year.'-'.$month.'-31';
                                 $where['advance_date >='] = $from;
                                 $where['advance_date <='] = $to; 
                             }else{
                                //by default calculation for current month
                                 $year = date('Y');
                                 $month = date('m');
                                 $from = $year.'-'.$month.'-01';
                                 $to = $year.'-'.$month.'-31';
                                 $where['advance_date >='] = $from;
                                 $where['advance_date <='] = $to;
                            }
                            
                                 $emp_id = $value->emp_id;
                                 $where['emp_id'] = $emp_id;   
                                 $advance_salary = $this->action->read_sum('advanced_salary','amount',$where);
                                 if(!empty($advance_salary)){
                                     $advance_salary = $advance_salary[0]->amount; 
                                 }else{
                                     $advance_salary = 0;
                                 }
                            
                                
                                $adjust_salary = $this->action->readOrderby('salary','id',array('employee_id' => $emp_id),'desc');
                                if(!empty($adjust_salary)){
                                    $adjust_salary = $adjust_salary[0]->adjust_salry;
                                }else{
                                    $adjust_salary = 0;
                                }
                                
                                ?>
                        <tr>
                            <td>
                                <input type="hidden" name="year" value="<?php echo $year; ?>" >
                                <input type="hidden" name="month" value="<?php echo $month; ?>" >
                                <?php echo $sl=$key+1;  ?>
                            </td>
                            
                            <td> 
                                <?php echo $value->emp_id; ?>
                                <input type="hidden" name="employee_id<?php echo $sl; ?>" value="<?php echo $value->emp_id; ?>" >
                                <input type="hidden" name="type<?php echo $sl; ?>" value="<?php echo $value->type; ?>" >
                            </td>
                            
                            <td> 
                                Group-<?php echo $value->type; ?>
                            </td>
                            
                            <td> 
                                <?php echo $value->name; ?>
                                <input type="hidden" name="employee_name<?php echo $sl; ?>" value="<?php echo $value->name; ?>" >
                            </td>
                            
                            <td> 
                                <?php   
                                    $dept = $this->action->read('employee',array('emp_id' => $value->emp_id)); 
                                    if(!empty($dept)){
                                        echo $dept[0]->dept;
                                    }
                                ?>
                            </td>                            
                            
                            <td> 
                                <?php echo  $value->designation; ?>
                                <input type="hidden" name="employee_designation<?php echo $sl; ?>" value="<?php echo $value->designation; ?>" >
                            </td>
                            
                             <?php if($addfield){ ?>
                                <td> 
                                    <input type="text" name="bonus<?php echo $sl; ?>" value="<?php echo $value->employee_salary/2; ?>" >
                                     
                                     <input type="hidden" name="bonus" value="bonus">
                                </td>                           
                           <?php } ?>
                            <td>
                                <?php echo  $value->employee_salary; ?> 
                            </td>    
                            <td> 
                                
                                <?php echo  $value->employee_salary+$adjust_salary; $total_salary += $value->employee_salary+$adjust_salary;  ?>    
                                
                                <input type="hidden" name="id<?php echo $sl; ?>" value="<?php echo $value->id; ?>">
                                <?php 
                                     $previous_month_adjustment = $this->action->readOrderBy('salary','insert_date',array('employee_id' => $value->emp_id),'desc');
                                     
                                     if(!empty($previous_month_adjustment)){
                                         $previous_month_adjustment = $previous_month_adjustment[0]->adjust_salry;
                                     }else{
                                         $previous_month_adjustment = 0;
                                     }
                                     
                                ?>     
                                
                                <input type="hidden" name="adjust_salry<?php echo $sl; ?>"  id="adjust_salry<?php echo $sl; ?>"   value="<?php echo ($value->employee_salary-$advance_salary + $previous_month_adjustment); ?>">
								
								<input type="hidden" name="salary<?php echo $sl; ?>" id="salary<?php echo $sl; ?>"   value="<?php echo ($value->employee_salary); ?>" >
								
							</td>
                            
							<td>    
                                <input type="text" name="given_salary<?php echo $sl; ?>" value="<?php echo $value->employee_salary+$adjust_salary; ?>"  id="given_salary<?php echo $sl; ?>"  onkeyup="calculate_salary(<?php echo $sl; ?>);"  >
                            </td>
							
							<td>
                                <?php echo $advance_salary; $total_advance_salary += $advance_salary;  ?>
                                <input type="hidden" name="advance_salary<?php echo $sl; ?>"  id="advance_salary<?php echo $sl; ?>"   value="<?php echo $advance_salary; ?>" >
                            </td>
                            <td>
                                <input type="hidden" name="due_salary<?php echo $sl; ?>"   value="<?php echo $value->employee_salary-$advance_salary; ?>"    readonly>
                                <input type="text" name="payable_salary<?php echo $sl; ?>"  id="payable_salary<?php echo $sl; ?>"   value="<?php echo $value->employee_salary+$adjust_salary-$advance_salary; ?>"   readonly >
                                <?php 
                                
                                        $total_payable_salary += $value->employee_salary-$advance_salary;
                                        $total_basic_salary += $value->employee_salary;
                                ?>
                            </td>
                          
                          
                        </tr>
                        
                        <?php } ?>
                        <tr>
                            <td colspan="6" style="text-align:right"> Total</td> 
                            <td><?php  echo number_format($total_basic_salary,2);  ?></td>
                            <td > <?php  echo number_format($total_salary,2);  ?> </td>
                            <td></td>
                            <td> <?php echo number_format($total_advance_salary,2);  ?> </td>
                            <td> <?php  echo number_format($total_payable_salary,2); ?> </td>
                        </tr>    
                        <tr class="none">
                            <td <?php if($addfield){ ?> colspan="12" <?php }else{ ?> colspan="11" <?php } ?> class="text-right" >
                                <input type="hidden" name="length" value="<?php  echo $sl; ?>">
                                <input type="hidden" name="type" value="<?php  if(isset($_POST['type'])){ echo $_POST['type']; }else{ echo '0'; } ?>">
                                <input type="submit" value="Close" name="save" class="btn btn-primary">
                            </td>
                            
                        </tr> 
                    </table>
                </div>
                <?php echo form_close(); ?>
               <?php  } }else{  ?>
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
<script>
function calculate_salary(row){
	var given_salary = $('#given_salary'+row).val();
	var advance_salary = $('#advance_salary'+row).val();
	var current_salary = $('#salary'+row).val();
    var adjust_salary = 0;
	
	var salary_calculate = 0;
	salary_calculate = given_salary	- advance_salary;
	$('#payable_salary'+row).val(salary_calculate);
	$('#salary'+row).val(given_salary);
	
	if(given_salary == current_salary){
	      adjust_salary = $('#adjust_salry'+row).val();
	}else{
	      adjust_salary = $('#payable_salary'+row).val();
	}
	
	$('#adjust_salry'+row).val(adjust_salary);
}
</script>