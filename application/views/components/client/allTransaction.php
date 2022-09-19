<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid" ng-controller="clientAllTransactionCtrl">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Transaction</h1>
                </div>
            </div>

            <div class="panel-body none">
                <div class="row">
                    <?php echo form_open(); ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true" ng-model="party_code" ng-change="getPartyInfo();">
                                <option value="" selected disabled>Select Client</option>
                                <?php
                                if (!empty($clientList)) {
                                    foreach ($clientList as $row) { ?>
                                        <option value="<?php echo $row->code; ?>"><?php echo $row->code . '-' . filter($row->name) . " ( " . $row->address . " ) "; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="date[from]" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="date[to]" class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">

                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">All Client Transaction</h4>

                <table class="table table-bordered table-print">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Date</th>
                        <th>C.ID</th>
                        <th>Name</th>
                        <th>Transaction By</th>
                        <th>Payment</th>
                        <th>Received</th>
                        <th>Remission</th>
                        <th>Comment</th>
                        <th width="165" class="none">Action</th>
                    </tr>

                    <?php
                        $totalPayment = $totalRemission = $totalReceived = 0;
                        foreach ($results as $key => $row) {
                            $totalPayment       += $row->debit;
                            $totalReceived      += $row->credit;
                            $totalRemission     += $row->remission;
                    ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $row->transaction_at; ?></td>
                            <td><?php echo $row->party_code; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo filter($row->transaction_via); ?></td>
                            <td><?php echo f_number($row->debit); ?> </td>
                            <td><?php echo f_number($row->credit); ?> </td>
                            <td><?php echo f_number($row->remission); ?> </td>
                            <td><?php echo $row->comment; ?> </td>
                            <td class="none">
                                <a class="btn btn-primary" href="<?php echo site_url("client/all_transaction/view/" . $row->id); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <a class="btn btn-warning" href="<?php echo site_url("client/transaction/edit/" . $row->id); ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <?php if ($this->session->userdata['privilege'] !== "user") { ?>
                                <a class="btn btn-danger" href="<?php echo site_url("client/all_transaction/delete/" . $row->id); ?>">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="5" class="text-right"><strong>Total</strong></td>
                        <td><strong><?php echo f_number($totalPayment); ?> TK</strong></td>
                        <td><strong><?php echo f_number($totalReceived); ?> TK</strong></td>
                        <td><strong><?php echo f_number($totalRemission); ?> TK</strong></td>
                    </tr>
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