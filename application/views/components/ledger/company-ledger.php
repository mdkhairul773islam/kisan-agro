<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Supplier Ledger</h1>
                </div>
            </div>

            <div class="panel-body none">
                <div class="row">
                    <?php echo form_open(); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true"
                                    data-live-search="true" required>
                                <option value="" selected disabled>Select Supplier</option>
                                <?php
                                if (!empty($partyList)) {
                                    foreach ($partyList as $row) {
                                        echo '<option value="' . $row->code . '" ' . (!empty($_POST['party_code']) && $_POST['party_code'] == $row->code ? "selected" : "") . ' >' . $row->code . '-' . $row->name . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom"
                                       value="<?= !empty($_POST['dateFrom']) ? $_POST['dateFrom'] : ""; ?>"
                                       class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo"
                                       value="<?= !empty($_POST['dateTo']) ? $_POST['dateTo'] : ""; ?>"
                                       class="form-control" placeholder="YYYY-MM-DD">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary pull-right">
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>

    <?php if (!$this->input->post("show")) { if (!empty($defaultData)) { ?>
    <div class="row">
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

                <h4 class="text-center hide" style="margin-top: 0px;">Supplier Ledger</h4>

                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Code</th>
                        <th>Supplier Name</th>
                        <th class="text-center">Opening Balance</th>
                        <th class="text-center">Debit (Tk)</th>
                        <th class="text-center">commission (Tk)</th>
                        <th class="text-center">Credit (Tk)</th>
                        <th class="text-center">Balance (Tk)</th>
                        <th>Status</th>
                    </tr>

                    <?php
                    $totalDebit = $totalCredit = $totalCommission = $totalBalance = 0;

                    foreach ($defaultData as $key => $row) {
                        $totalDebit      += $row->debit;
                        $totalCommission += $row->commission;
                        $totalCredit     += $row->credit;
                        $totalBalance    += $row->balance;
                        ?>
                        <tr>
                            <td><?= ++$key ?></td>
                            <td><?= filter($row->name) ?></td>
                            <td><?= $row->code ?></td>
                            <td class="text-center"><?= $row->initial_balance ?></td>
                            <td class="text-center"><?php echo f_number($row->debit); ?> </td>
                            <td class="text-center"><?php echo f_number($row->commission); ?> </td>
                            <td class="text-center"><?php echo f_number($row->credit); ?> </td>
                            <td class="text-center"><?php echo f_number($row->balance); ?> </td>
                            <td><?php echo $row->status; ?> </td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th class="text-center"><strong><?php echo f_number($totalDebit); ?></strong></th>
                        <th class="text-center"><strong><?php echo f_number($totalCommission); ?></strong>
                        </th>
                        <th class="text-center"><strong><?php echo f_number($totalCredit); ?></strong></th>
                        <th class="text-center">
                            <?= f_number(abs($totalBalance)); ?>
                        </th>
                        <th>
                            <?= ($totalBalance > 0 ? "Receivable" : "Payable") ?></th>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
    <?php } } else { ?>

    <?php if (!empty($results)) { ?>
    <div class="row">
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
                <h4 class="text-center hide" style="margin-top: 0px;">Client Ledger</h4>

                <div class="row">
                    <div class="col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">Client ID :</th>
                                <td><?php echo $partyInfo->code; ?></td>
                            </tr>

                            <tr>
                                <th>Client :</th>
                                <td><?php echo $partyInfo->name; ?></td>
                            </tr>

                            <tr>
                                <th> Address :</th>
                                <td> <?php echo $partyInfo->address; ?> </td>
                            </tr>

                            <tr>
                                <th> Mobile :</th>
                                <td> <?php echo $partyInfo->mobile; ?> </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-xs-offset-2 col-xs-5">
                        <table class="table table-bordered">
                            <tr>
                                <th>Date :</th>
                                <td>
                                    <?php
                                    if (!empty($fromDate) || !empty($toDate)) {
                                        echo $fromDate . ' To ' . $toDate;
                                    }
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <th width="40%">Opening Balance :</th>
                                <td>
                                    <strong>
                                        <?php
                                        $status = ($balanceInfo->initial_balance < 0 ? "Payable" : "Receivable");
                                        echo abs($balanceInfo->initial_balance) . "/- " . $status;
                                        ?>
                                    </strong>
                                </td>
                            </tr>

                            <tr>
                                <th>Current Balance :</th>
                                <td>
                                    <strong>
                                        <?php
                                        echo f_number(abs($balanceInfo->balance)) . "/- " . $balanceInfo->status;
                                        ?>
                                    </strong>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Commission :</th>
                                <td><strong><?php echo 0; ?>/-</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30px;">SL</th>
                        <th>Date</th>
                        <th>Details</th>
                        <th>Invoice No</th>
                        <th width="120" class="text-center">Debit (Tk)</th>
                        <th width="120" class="text-center">Commission (Tk)</th>
                        <th width="120" class="text-center">Credit (Tk)</th>
                        <th width="120" class="text-center">Balance (Tk)</th>
                        <th width="120">Status</th>
                    </tr>
                    
                    <tr>
                        <td>1</td>
                        <td colspan="6">Previous Balance</td>
                        <td class="text-center">
                            <?php echo f_number(abs($previous_balance)); ?>
                        </td>
                        <td><?= ($previous_balance < 0 ? 'Payable' : 'Receivable') ?></td>
                    </tr>
                    
                    <?php
                    $totalDebit   = $totalCredit = $totalCommission = $totalBalance = 0;
                    $totalBalance = $previous_balance;
                    foreach ($results as $key => $row) {
                        $totalDebit      += $row->debit;
                        $totalCommission += $row->commission;
                        $totalCredit     += $row->credit;
                        $totalBalance    += ($row->debit + $row->commission) - $row->credit;
                        ?>
                        <tr>
                            <td><?= ($key + 2) ?></td>
                            <td><?= $row->transaction_at ?></td>
                            <td><?= filter($row->remark) ?></td>
                            <td><?= $row->relation ?></td>
                            <td class="text-center"><?= f_number($row->debit) ?></td>
                            <td class="text-center"><?= f_number($row->commission) ?></td>
                            <td class="text-center"><?= f_number($row->credit) ?></td>
                            <td class="text-center"><?= f_number(abs($totalBalance)) ?></td>
                            <td><?= ($totalBalance < 0 ? 'Payable' : 'Receivable') ?></td>

                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th class="text-center"><strong><?= f_number($totalDebit) ?></strong></th>
                        <th class="text-center"><strong><?= f_number($totalCommission) ?></strong></th>
                        <th class="text-center"><strong><?= f_number($totalCredit) ?></strong></th>
                        <th class="text-center"><strong><?= f_number(abs($totalBalance)) ?></strong></th>
                        <th><?= ($totalBalance < 0 ? "Payable" : "Receivable") ?></th>
                    </tr>
                </table>
                
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
    <?php } } ?>
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
