<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
    
    .select2-product_code-ji-container {height: 35px !important; }
    .select2-selection__arrow, .select2-selection--single {height: 36px !important;}
</style>

<div class="panel panel-default">
    <div class="panel-heading none">
        <div class="panal-header-title">
            <h1 class="pull-left"> Production Ledger </h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()">
                <i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="panel-body none">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <!-- horizontal form -->
        <?php echo form_open('', ['id' => 'form']); ?>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group date" id="datetimepickerFrom">
                        <input type="text" name="dateFrom" value="<?= $dateFrom ?>" class="form-control"  placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <div class="input-group date" id="datetimepickerTo">
                        <input type="text" name="dateTo" value="<?= $dateTo ?>" class="form-control" placeholder="YYYY-MM-DD">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="btn-group">
                <input class="btn btn-primary" type="submit" name="show" value="Search">
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>

    <hr class="none" style="margin-top: 0px;">


    <!-- show result -->
    <div class="panel-body">
        <!-- Print banner -->
        <div class="hide">
            <!-- Print banner Start Here -->
            <?php $this->load->view('components/print'); ?>
            <!-- Print banner End Here -->
            <h3 class="text-center"> Production Ledger </h3>
        </div>

        <?php if (!empty($results)) { ?>

            <table class="table table-bordered " id="DataTable">
                <thead>
                <tr>
                    <th width="30">SL</th>
                    <th>Date</th>
                    <th width="140">Weight (Kg)</th>
                    <th width="140">Amount (Tk)</th>
                </tr>
                </thead>

                <tbody>
                    
                <?php
                $totalWeight = $totalAmount = $count = 0;
                foreach ($results as $key => $row) { ?>
                
                <tr>
                    <th colspan="4"><?= '('.(++$key) .') '. $row->department ?></th>
                </tr>
                
                <?php
                $departmentTotalWeight = $departmentTotalAmount = 0;
                foreach ($row->data as $key => $row) {
                    $departmentTotalWeight += $row->total_weight;
                    $departmentTotalAmount += $row->purchase_amount;
                ?>
                    <tr>
                        <td><?= (++$count); ?></td>
                        <td><?= $row->date; ?></td>
                        <td class="text-center"><?= f_number($row->total_weight, 3); ?></td>
                        <td class="text-center"><?= f_number($row->purchase_amount, 3); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="2" class="text-right"> Total</th>
                    <th class="text-center"> <?php echo f_number($departmentTotalWeight, 3); ?> Kg </th>
                    <th class="text-center"> <?php echo f_number($departmentTotalAmount, 3); ?> Tk</th>
                </tr>
                
                <?php
                $totalWeight += $departmentTotalWeight;
                $totalAmount += $departmentTotalAmount;
                } ?>
                    
                <tr>
                    <th colspan="2" class="text-right">Grand Total</th>
                    <th class="text-center"> <?php echo f_number($totalWeight, 3); ?> Kg </th>
                    <th class="text-center"> <?php echo f_number($totalAmount, 3); ?> Tk</th>
                </tr>
                </tbody>
            </table>
        <?php } else {
            echo '<p class="text-center"> <scrong> No data found....! </scrong> </p>';
        } ?>
    </div>
    <div class="panel-footer">&nbsp;</div>
</div>


<script>

	$(document).ready(function() {
		$('.js-example-basic-single').select2();
	});
	
  
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


    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>