<style>
    .balance {background: rgb(245, 245, 245);}
    .balance h4 {
        line-height: 48px;
        font-weight: bold;
    }
    .red {
        background-color: #FFE4E3;
        color: red;
        font-weight: bold;
    }
    .green {
        background-color: #CCE3DF;
        color: green;
        font-weight: bold;
    }
    .s_red {
        background-color: #FE3939;
        font-weight: bold;
        color: #fff;
        cursor: default;
        font-size: 1.2em;
        padding: 13px 0px !important;
    }
    .s_red:hover {color: #fff;}
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

<?php echo $this->session->flashdata('confirmation'); ?>
<div class="panel panel-default">
    <div class="panel-heading none">
        <div class="panal-header-title">
            <h1 class="pull-left"> Balance Sheed </h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()">
                <i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="panel-body none">
        <?php echo form_open('', ['class' => 'row']); ?>
        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group date" id="datetimepickerFrom">
                    <input type="text" name="date[from]" value="<?= !empty($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d') ?>" placeholder="From ( YYYY-MM-DD )" class="form-control" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <div class="input-group date" id="datetimepickerTo">
                    <input type="text" name="date[to]" value="<?= !empty($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d') ?>" placeholder="To ( YYYY-MM-DD )" class="form-control" required>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="show" value="Show">
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
    <hr class="none" style="margin-top: 5px;">
    
    <div class="panel-body">
        <!-- Print banner Start Here -->
        <?php $this->load->view('components/print'); ?>
        <!-- Print banner End Here -->
        <h3 class="text-center hide">Balance Report <br>
            <small>
                From : <?php echo(isset($_POST['date']['from']) ? $_POST['date']['from'] : date('Y-m-d')); ?> &nbsp;&nbsp;
                To : <?php echo(isset($_POST['date']['to']) ? $_POST['date']['to'] : date('Y-m-d')); ?>
            </small>
        </h3>

        <?php if (!empty($result)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <?php
                $totalCredit = $totalDebit = 0;
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
                            <td class="text-center"> <?= $item['debit'];?> </td>
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
</script>