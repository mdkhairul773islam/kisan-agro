<style type="text/css">
    .info-view {
        width: 100%;
        display: flex;
        align-items: center;
    }

    .info-view img {
        max-width: 190px;
        margin-right: 15px;
    }

    .info-view figcaption p {
        margin-bottom: 5px;
    }

    .customBtn {
        font-size: 22px !important;
        font-weight: bold !important;
        color: #555 !important;
    }

    .custom-table tr td {
        padding: 0 !important;
    }

    .custom-table tr td .form-control {
        border: transparent;
    }

</style>

<div class="container-fluid" ng-controller="PayrollCtrl" ng-cloak>
    <div class="row">
       <?= $this->session->flashdata('confirmation') ?>
        <!-- Basic Salary -->
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1> Due Salary </h1>
                </div>
            </div>

            <div class="panel-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30">SL</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th width="150">Amount</th>
                    </tr>
                    
                    <?php
                    $totalDue = 0;
                    if(!empty($results)){
                        foreach($results as $key => $row){ 
                            
                            $salaryInfo = get_employee_salary($row->emp_id);
                            
                            $totalDue += $salaryInfo->due_salary;
                        ?>
                            <tr>
                                <td><?php echo ++$key; ?></td>
                                <td><?php echo $row->emp_id; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->mobile; ?></td>
                                <td><?php echo $row->present_address; ?></td>
                                <td><?php echo f_number($salaryInfo->due_salary); ?></td>
                            </tr>
                        <?php }
                    }
                    ?>
                    <tr>
                        <th colspan="5" class="text-right">Total</th>
                        <th><?php echo f_number($totalDue); ?></th>
                    </tr>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
