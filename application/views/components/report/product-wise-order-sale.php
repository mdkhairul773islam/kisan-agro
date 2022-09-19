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
            <h1 class="pull-left"> Product Wise Order Stock </h1>
            <a href="#" class="pull-right " style="margin-top: 0px; font-size: 14px;" onclick="window.print()">
                <i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <div class="panel-body none">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <!-- horizontal form -->
        <?php echo form_open('', ['id' => 'form']); ?>

        <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                    <select name="department" class="form-control">
                        <option value="" selected>-- Select Department --</option>
                        <?php
                        if (!empty($allDepartment)) {
                            foreach ($allDepartment as $d_value) {
                                echo '<option value="' . $d_value->department_name . '"' . (!empty($_POST['department']) && $_POST['department'] == $d_value->department_name ? 'selected' : '') . '>' . filter($d_value->department_name) . '</option>';
                            }
                        } ?>
                    </select>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <select name="product_code" class="form-control js-example-basic-single">
                        <option value="">--Select Product --</option> 
                        <?php 
                        if(!empty($allProduct)){ 
                            foreach($allProduct as $key => $row){ ?>
                                <option value="<?php echo $row->code; ?>"> <?php echo $row->code .' - '. filter($row->name); ?> </option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group date" id="datetimepickerFrom">
                        <input type="text" name="date"
                               value="<?= !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d') ?>"
                               placeholder="From ( YYYY-MM-DD )" class="form-control" required>
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

    <hr class="none" style="margin-top: 5px;">


    <!-- show result -->
    <div class="panel-body">
        <!-- Print banner -->
        <div class="hide">
            <!-- Print banner Start Here -->
            <?php $this->load->view('components/print'); ?>
            <!-- Print banner End Here -->
            <h3 class="text-center"> Product wse order stock</h3>
        </div>

        <?php if (!empty($result)) { ?>

            <table class="table table-bordered " id="DataTable">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Weight</th>
                    <th width="140">Total Weight (Kg)</th>
                    <th width="140">Total Amount (Tk)</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $totalQuantity = $totalWeight = $totalAmount = 0;
                foreach ($result as $key => $row) { ?>
                    <tr>
                        <td><?= ($key + 1); ?></td>
                        <td><?= $row['code']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['unit']; ?></td>
                        <td class="text-center">
                            <?php
                            $totalQuantity += $row['totalQuantity'];
                            echo $row['totalQuantity']; ?>
                        </td>
                        <td><?= $row['weight']; ?></td>
                        <td class="text-center">
                            <?php
                            $totalWeight += $row['totalWeight'];
                            echo f_number($row['totalWeight'], 3); ?>
                        </td>
                        <td class="text-center">
                            <?php
                            $totalAmount += $row['totalAmount'];
                            echo f_number($row['totalAmount']); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="4" class="text-center"> Total</th>
                    <th class="text-center"> <?php echo f_number($totalQuantity, 3); ?> </th>
                    <th></th>
                    <th class="text-center"> <?php echo f_number($totalWeight, 3); ?> </th>
                    <th class="text-center"> <?php echo f_number($totalAmount); ?> </th>
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
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $("#form").submit(function () {
        $(this).find(":submit").css("pointer-events", "none").val('Submitted...');
    });
</script>