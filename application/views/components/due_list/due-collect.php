<style>
    .action-btn a {
        margin-right: 0;
        margin: 3px 0;
    }

    .checkbox {
        margin: 0 !important;
    }

    @media print {

        aside,
        .panel-heading,
        .panel-footer,
        nav,
        .none {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }

        table tr th,
        table tr td {
            font-size: 12px;
        }

        .print_banner_logo {
            width: 19%;
            float: left;
        }

        .print_banner_logo img {
            margin-top: 10px;
        }

        .print_banner_text {
            width: 80%;
            float: right;
            text-align: center;
        }

        .print_banner_text h2 {
            margin: 0;
            line-height: 38px;
            text-transform: uppercase !important;
        }

        .print_banner_text p {
            margin-bottom: 5px !important;
        }

        .print_banner_text p:last-child {
            padding-bottom: 0 !important;
            margin-bottom: 0 !important;
        }
    }
</style>

<div class="container-fluid" ng-controller="dueCollectCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Due Collect</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i
                                class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <div class="row">
                    <div class="col-xs-4 print-font">
                        <?php
                        $paid = 0;
                        $partyInfo = json_decode($info->client_info, true);
                        $name       = $info->party_code;
                        $mobile     = filter(check_null($partyInfo['mobile']));
                        $address    = filter(check_null($partyInfo['address']));
                        $payment = get_sum('due_collectio', 'paid', ['voucher_no' => $info->voucher_no, 'trash' => 0]);
                        $paid = (!empty($payment) ? $payment + $info->paid :  $info->paid);
                        ?>

                        <label>Name : <?php echo $name; ?></label> <br>
                        <label>Mobile : <?php echo $mobile; ?></label><br>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label style="margin-bottom: 10px;">
                            Voucher No : <?php echo $info->voucher_no; ?>
                        </label> <br>
                        <?php $metaInfo = $this->action->read("sapmeta", array("meta_key" => "sale_by", "voucher_no" => $info->voucher_no)); ?>
                        <label style="margin-bottom: 10px;">
                            Sales Man : <?php echo $metaInfo[0]->meta_value; ?>
                        </label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Date : <?php echo $info->sap_at; ?></label> <br>
                        <label>Print Time : <?php echo date('Y-m-d - t:m:s:A'); ?></label> <br>

                    </div>
                </div>

                <div class="col-md-12">&nbsp;</div>

                <?php echo form_open('due_list/due_list/due_collect?vno='.$info->voucher_no, ["class" => "form-horizontal"]); ?>

                <table class="table table-bordered">
                    <tr>
                        <th>Voucher No</th>
                        <th>Total Bill</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </tr>
                    <tr>
                        <td><?php echo $info->voucher_no; ?></td>
                        <td><?php echo $info->total_bill; ?></td>
                        <td><?php echo $paid; ?></td>
                        <td><?php echo $info->total_bill - $paid; ?></td>
                    </tr>
                </table>

                <!-- hidden field -->
                <input type="hidden" name="voucher_no" ng-init="voucher_no='<?php echo $info->voucher_no; ?>'" ng-value="voucher_no">
                <input type="hidden" ng-init="amount.total_bill=<?php echo $info->total_bill; ?>" ng-model="amount.total_bill" ng-value="amount.total_bill">
                <input type="hidden" name="godown_code" value="<?php echo $info->godown_code; ?>">

                <div class="col-md-8 col-md-offset-1">
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Previous Paid </label>
                        <div class="col-md-8">
                            <p class="p-input">{{amount.previousPaid}}</p>
                            <input type="hidden" name="previous_paid" class="form-control"
                                   ng-init="amount.previousPaid=<?php echo $paid; ?>"
                                   ng-model="amount.previousPaid" ng-value="amount.previousPaid">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Paid </label>
                        <div class="col-md-8">
                            <input type="text" name="paid" ng-model="amount.paid" class="form-control" placeholder="0"
                                   autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Total Paid </label>
                        <div class="col-md-8">
                            <p class="p-input">{{ getTotalFn() }}</p>
                            <input type="hidden" name="total_paid" ng-value="getTotalFn()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Remission </label>
                        <div class="col-md-8">
                            <input type="text" name="remission" ng-model="amount.remission" class="form-control"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Total Remission </label>
                        <div class="col-md-8">
                            <p class="p-input">{{ getTotalRemissionFn() }}</p>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label"> Due </label>
                        <div class="col-md-8">
                            <p class="p-input"> {{ getTotalDueFn() }}</p>
                            <input type="hidden" name="due" ng-value="getTotalDueFn()" class="form-control" step="any"
                                   readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"> Next Promise Date </label>
                        <div class="col-md-8">
                            <div class="input-group date" id="datetimepicker">
                                <input type="text" name="promise_date" value="<?php echo $info->promise_date; ?>"
                                       class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <dic class="col-md-11">
                            <div class="pull-right">
                                <input type="submit" name="save" value="Collect" class="btn btn-primary">
                            </div>
                        </dic>
                    </div>
                </div>
                <?php form_close(); ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>