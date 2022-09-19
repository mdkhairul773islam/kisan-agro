<style>
    @media print {
        aside,
        nav,
        .none,
        .panel-heading,
        .panel-footer {
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

        .block-hide {
            display: none;
        }

        .balance h4 {
            margin: 0;
            line-height: 25px;
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

    .balance {
        background: rgb(245, 245, 245);
    }

    .balance h4 {
        line-height: 48px;
        font-weight: bold;
    }

    .red {
        color: red;
        font-weight: bold;
        background-color: #FFE4E3;
    }

    .green {
        color: green;
        font-weight: bold;
        background-color: #CCE3DF;
    }

    .s_red {
        background-color: #FE3939;
        font-weight: bold;
        color: #fff;
        cursor: default;
        font-size: 1.2em;
        padding: 13px 0px !important;
    }

    .s_red:hover {
        color: #fff;
    }

    .s_green {
        background-color: #449D44;
        font-weight: bold;
        color: #fff;
        cursor: default;
        font-size: 1.2em;
        padding: 13px 0px !important;
    }

    .s_green:hover {
        color: #fff;
    }

    .table-header {
        border-bottom: transparent !important;
        font-size: 18px !important;
        background: #f5f5f5;
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading none">
        <div class="panal-header-title">
            <h1 class="pull-left"> Cash Book </h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()">
                <i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="panel-body none">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <!-- horizontal form -->
        <?php echo form_open('', ['class' => 'form-horizontal', 'id' => 'form1']); ?>

        <div class="row">
            <div class="col-md-4">
                <div class="input-group date" id="datetimepickerFrom">
                    <input type="text" name="date"
                           value="<?= !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d') ?>"
                           placeholder="From ( YYYY-MM-DD )" class="form-control" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="btn-group">
                <input class="btn btn-primary" type="submit" name="show" value="Search">
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>

    <hr class="none" style="margin-top: 5px;">


    <!-- show result -->
    <div class="panel-body">
        <!-- Print banner -->
        <div class="hide">
            <!-- Print banner Start Here -->
            <?php $this->load->view('components/print'); ?>
            <!-- Print banner End Here -->
            <h3 class="text-center">Cash book </h3>
        </div>

        <?php
        $totalCredit = $totalDebit = 0;
        if (!empty($result)) { ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <?php
                    foreach ($result as $info) {
                        ?>
                        <tr>
                            <th colspan="5" class="table-header"> <?= filter($info['title']) ?> </th>
                        </tr>
                        <tr>
                            <th width="50" class="text-center">SL</th>
                            <th width="120">Date</th>
                            <th>Details</th>
                            <th width="150" class="text-center">Debit</th>
                            <th width="150" class="text-center">Credit</th>
                        </tr>
                        <?php
                        foreach ($info['info'] as $_key => $item) { ?>
                            <tr>
                                <td class="text-center"><?= ++$_key ?></td>
                                <td><?= $item['date'] ?></td>
                                <td><?= filter($item['description']) ?></td>
                                <td class="text-center"> <?= $item['debit']; ?> </td>
                                <td class="text-center"> <?= $item['credit']; ?> </td>
                            </tr>

                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-right"> Total</th>
                            <th class="text-center">
                                <?php echo f_number($info['debit'], 2);
                                $totalDebit += $info['debit']; ?>/-Tk
                            </th>
                            <th class="text-center">
                                <?php echo f_number($info['credit'], 2);
                                $totalCredit += $info['credit']; ?>/-Tk
                            </th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="5">&nbsp;</th>
                    </tr>

                    <tr>
                        <th colspan="3" class="text-right">Grand Total</th>
                        <th class="text-center"><?= f_number($totalDebit, 2) ?>/-Tk</th>
                        <th class="text-center"><?= f_number($totalCredit, 2) ?>/-Tk</th>
                    </tr>
                </table>
            </div>
        <?php } else {
            echo '<p class="text-center"> <strong>No data found....!</strong> </p>';
        } ?>

        <br>

        <?php
        echo form_open('', ['id' => 'form2']);

        $date         = (!empty($_POST['date']) ? $_POST['date'] : date('Y-m-d'));
        $previousDAte = date('Y-m-d', strtotime('-1 day', strtotime($date)));
        $balanceInfo  = get_row('opening_balance', ['created_at' => $previousDAte]);
        if (!empty($balanceInfo)) {
            $previousBalance = $balanceInfo->balance;
        } else {
            $previousBalance = 0;
        }

        $currentBalance =  ($totalCredit - $totalDebit);
        $balance = $previousBalance + $currentBalance;
        ?>

        <table class="table table-bordered">
            <tr class="bg-info">
                <th> Previous Balance </th>
                <th> Current Balance </th>
                <th> Total Cash </th>
            </tr>

            <tr>
                <td> <?= f_number($previousBalance) ?> </td>
                <td>
                    <?= f_number($currentBalance) ?>
                </td>
                <td>
                    <?= f_number($balance) ?>
                </td>
            </tr>

            <tr>
                <td colspan="3" class="text-right">

                    <input type="hidden" name="created_at" value="<?= $date ?>">
                    <input type="hidden" name="current_balance" value="<?= $currentBalance ?>">
                    <input type="hidden" name="balance" value="<?= $balance ?>">
                    <input type="submit" name="closing" value="Closing Balances" class="btn btn-primary">
                </td>
            </tr>
        </table>
        <?php echo form_close(); ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
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

    $("#form1").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });

    $("#form2").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>