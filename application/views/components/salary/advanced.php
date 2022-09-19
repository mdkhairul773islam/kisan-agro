<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<style type="text/css">
    .info-view {
        border: 1px solid #ddd;
        max-height: 230px;
        max-width: 230px;
        width: 100%;
        padding: 5px;
        text-align: center;
    }
    .custom-table tr td {
        padding: 0 !important;
    }
    .custom-table tr td .form-control {
        border: transparent;
    }
</style>

<div class="container-fluid" ng-controller="AdvancedPaymentCtrl" ng-cloak>
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left"><h1>Advanced Payment </h1></div>
            </div>

            <div class="panel-body">
                <?php
                    $attr = array("class" => "form-horizontal");
                    echo form_open('salary/salary/store_advance', $attr);
                ?>
                <div>
                    <h3 style="margin-top: 0;">Employee Information</h3>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-7">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Date <span class="req">*</span></label>
                                <div class="col-md-8">
                                    <div class="input-group date" id="datetimepickerFrom">
                                        <input type="text" name="created" class="form-control" value="<?= date('Y-m-d') ?>" placeholder="YYYY-MM-DD">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Employee ID <span class="req">*</span></label>
                                <div class="col-md-8">
                                    <select type="text" name="emp_id" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required ng-model="emp_id" ng-change="getEmployeeInfoFn(emp_id); getSalaryFn()" required>
                                        <option value="" selected disabled="">Select Employee</option>
                                        <?php if (!empty($employee)) {
                                            foreach ($employee as $key => $value) {
                                                echo '<option value="' . $value->emp_id . '">' . $value->emp_id .' - '. get_filter($value->name) . '</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name </label>
                                <div class="col-md-8">
                                    <input type="text" ng-model="profile.name" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Post</label>
                                <div class="col-md-8">
                                    <input type="text" ng-model="profile.post" class="form-control" readonly>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Department</label>
                                <div class="col-md-8">
                                    <input type="text" ng-model="profile.department" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Mobile </label>
                                <div class="col-md-8">
                                    <input type="text" ng-model="profile.mobile" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <figure class="info-view" ng-if="profile.active">
                                <img class="img-responsive img-thumbnail" ng-src="{{ profile.image }}" alt="profile pic not found!">
                            </figure>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px dashed  #ddd;">
                
                <div class="row">
                    <div class="col-md-offset-1 col-md-7">
                        <div class="form-group ">
                            <label class="col-md-4 control-label">Payment Month<span class="req"> *</span></label>

                            <div class="col-md-8">
                                <div class="col-md-6">
                                    <div class="row">
                                        <select name="year" ng-model="year" ng-init="year='<?= date('Y') ?>'"
                                                ng-change="getSalaryFn()" class="form-control">
                                            <option value="" selected disabled>-- Year --</option>
                                            <?php
                                            for ($y = date('Y') + 1; $y >= 2018; $y--) {
                                                echo '<option value="' . $y . '"> ' . $y . ' </option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <select name="month" ng-model="month" ng-init="month='<?= date('m') ?>'"
                                                ng-change="getSalaryFn()" class="form-control">
                                            <option value="" selected disabled>-- Month --</option>
                                            <?php
                                            if (!empty(config_item('all_months')))
                                                foreach (config_item('all_months') as $_key => $m_value) {
                                                    echo '<option value="' . $_key . '"> ' . $m_value . ' </option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Salary</label>
                            <div class="col-md-8">
                                <input type="text" name="total_salary" ng-model="profile.salary" class="form-control" placeholder="0" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Previous Paid</label>
                            <div class="col-md-8">
                                <input type="text" name="previous_paid" ng-model="profile.previous_paid" class="form-control" placeholder="0" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Paid <span class="req"> *</span></label>
                            <div class="col-md-8">
                                <input type="number" name="amount" ng-model="paid" class="form-control" step="any" placeholder="0" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-4 control-label">Due <span class="req"> *</span></label>
                            <div class="col-md-8">
                                <input type="number" ng-value="getDueFn()" class="form-control" step="any" placeholder="0" readonly>
                            </div>
                        </div>
                        

                        <div class="pull-right">
                            <input type="submit" name="create" value="Paid" class="btn btn-primary">
                        </div>
                    </div>
                </div>

                <?php echo form_close(); ?>
                <div ng-if="advanced_payment.length > 0" ng-cloak>
                    <hr style="border: 1px dashed  #ddd;">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>All Advanced Paid</h2>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th width="30">SL</th>
                                    <th width="150">Date</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Amount</th>
                                    <th width="60">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="row in advanced_payment">
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ row.created}}</td>
                                    <td>{{ row.year }}</td>
                                    <td>{{ row.month }}</td>
                                    <td>{{ row.amount }}</td>
                                    <td>
                                        <a title="Delete" class="btn btn-danger"
                                           onclick="return confirm('Are you sure want to delete this Payment?');"
                                           href="{{ row.delete }}"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-right" colspan="4">Total</th>
                                    <th colspan="2"> {{ total_advanced_payment }}</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>