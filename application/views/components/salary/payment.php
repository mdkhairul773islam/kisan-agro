<style type="text/css">
    .custom-table tr td {padding: 0 !important;}
    .info-view {
        border: 1px solid #ddd;
        max-height: 230px;
        max-width: 230px;
        width: 100%;
        padding: 5px;
        text-align: center;
    }
    .custom-table tr td .form-control {
        border: transparent;
    }
</style>

<div class="container-fluid" ng-controller="PaymentCtrl" ng-cloak>

    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left"><h1>Payment</h1></div>
            </div>


            <div class="panel-body">

                <?= form_open('', ['class' => 'form-horizontal']) ?>

                <div class="form-group">
                    <label class="col-md-3 control-label"> Date <span class="req">*</span> </label>
                    <div class="col-md-5">
                        <div class="input-group date" id="datetimepickerFrom">
                            <input type="text" name="date" class="form-control" value="<?= date('Y-m-d') ?>"
                                   placeholder="YYYY-MM-DD">
                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 control-label">Payment Month <span class="req">*</span></label>
                    <div class="col-md-5">
                        <div class="col-md-6">
                            <div class="row">
                                <select name="year" class="form-control">
                                    <option value="" selected disabled>-- Year --</option>
                                    <?php
                                    for ($y = date('Y') + 1; $y >= 2018; $y--) {
                                        echo '<option value="' . $y . '" ' . (!empty($_POST['year']) && $_POST['year'] == $y ? "selected" : (empty($_POST['year']) && $y == date('Y') ? "selected" : "")) . ' > ' . $y . ' </option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <select name="month" class="form-control">
                                    <option value="" selected disabled>-- Month --</option>
                                    <?php
                                    if (!empty(config_item('all_months')))
                                        foreach (config_item('all_months') as $_key => $m_value) {
                                            echo '<option value="' . $_key . '" ' . (!empty($_POST['month']) && $_POST['month'] == $_key ? "selected" : (empty($_POST['month']) && date('m') == $_key ? "selected" : "")) . '> ' . $m_value . ' </option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 text-right">
                        <input type="submit" name="show" class="btn btn-primary" value="Search">
                    </div>
                </div>
                <?= form_close() ?>

                <?php if (!empty($results)) { ?>

                    <?= form_open('salary/payment/store_payment') ?>


                    <input type="hidden" name="created"
                           value="<?= (!empty($_POST['date']) ? $_POST['date'] : date('Y-m-d')) ?>">

                    <input type="hidden" name="payment_date"
                           value="<?= ((!empty($_POST['year']) && !empty($_POST['month'])) ? date('Y-m-t', strtotime(($_POST['year'] . '-' . $_POST['month']))) : date('Y-m-t', strtotime('today'))) ?>">

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="60">
                                        <input type="checkbox" checked id="check_all"> SL
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Photo</th>
                                    <th>Mobile</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Adjust</th>
                                    <th>Advance</th>
                                    <th>Total Due</th>
                                    <th>Payment</th>
                                </tr>

                                <?php
                                $totalSalary = $totalAdvance =  $adjustAmount = $previousPaid = $totalPaid = 0;
                                $sl_no = 0;
                                
                                foreach ($results as $key => $row) {
                                    
                                    $salaryInfo = get_employee_salary($row->emp_id, $paymentMonth);
                                    
                                    $advancePaid     = $salaryInfo->paid_amount + $salaryInfo->advance_paid;
                                    $totalSalary    += $row->employee_salary;
                                    $adjustAmount   += $salaryInfo->adjust_amount;
                                    $totalAdvance   += $advancePaid; 
                                    $totalPaid      += $salaryInfo->due_salary;
                                    ?>

                                    <input type="hidden" name="total_salary[]" value="<?= $salaryInfo->employee_salary ?>">
                                    <input type="hidden" name="due_salary[]" value="<?= $salaryInfo->due_salary ?>">
                                    <input type="hidden" name="mobile[]" value="<?= $row->mobile ?>">
                                    <input type="hidden" name="emp_id[]" value="<?= $row->emp_id ?>">

                                    <tr>
                                        <td>
                                            <input type="checkbox" name="id[]" checked value="<?= $key ?>">&nbsp;&nbsp;<?= ++$key ?>
                                        </td>
                                        <td><?= $row->emp_id ?></td>
                                        <td><?= filter($row->name); ?></td>
                                        <td style="padding: 0 !important;">
                                            <img class="img-responsive" src="<?= site_url($row->path) ?>"
                                                 width="60" height="50" alt="">
                                        </td>
                                        <td><?= $row->mobile ?></td>
                                        <td><?= filter($row->designation) ?></td>
                                        <td><?= get_number_format($row->employee_salary) ?></td>
                                        <td><?= get_number_format($salaryInfo->adjust_amount) ?></td>
                                        <td><?= get_number_format($advancePaid) ?></td>
                                        <td><?= get_number_format($salaryInfo->due_salary); ?></td>
                                        <td>
                                           <input type="text" name="paid[]" value="<?= $salaryInfo->due_salary ?>" class="form-control">
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <th colspan="6" class="text-right">Total</th>
                                    <th><?= get_number_format($totalSalary) ?></th>
                                    <th><?= get_number_format($adjustAmount) ?></th>
                                    <th><?= get_number_format($totalAdvance) ?></th>
                                    <th><?= get_number_format($totalPaid) ?></th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="btn-group pull-right">
                            <input type="submit" name="create" value="Paid" class="btn btn-info"/>
                        </div>
                    </div>

                    <?= form_close() ?>
                <?php } ?>
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

<script type="text/javascript">
    $(document).ready(function () {
        $("#check_all").on("change", function () {
            if ($(this).is(":checked") == true) {
                $('input[name="id[]"]').prop("checked", true);
            } else {
                $('input[name="id[]"]').prop("checked", false);
            }
        });
    });
</script>
