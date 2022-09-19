<style>
    .invoice {
        text-align: center;
        margin-bottom: 0;
    }
    .invoice h4 {
        border: 1px solid #212121;
        border-radius: 25px;
        padding: 4px 25px;
        font-size: 14px;
        margin-top: 0;
        display: inline-block;
    }
    .table > tbody > tr > td {padding: 2px 6px}
    @media print {
        .table > tbody > tr > th,
        .table > tbody > tr > td {padding: 2px 6px;}
    }
    .header_info {
        margin-bottom: 15px;
        flex-wrap: wrap;
        display: flex;
        width: 100%;
    }
    .header_info li {
        min-width: 220px;
        width: 33.33%;
        font-size: 15px;
        margin: 5px 0;
    }
    .header_info li strong {
        display: inline-block;
        min-width: 50px;
    }
    .signature_box {
        border: 1px solid transparent;
        margin-top: 65px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .signature_box h4 {
        border-top: 2px dashed #212121;
        color: #212121;
        padding: 6px 0;
        margin: 10px 0 0;
        font-size: 17px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Challan Details</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner Start -->
                <?php $this->load->view('components/print'); ?>
                <!-- Print banner end -->
                
                <div class="row">
                    <div class="col-xs-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Client Info</th>
                            </tr>

                            <tr>
                                <td>Voucher No: <?php echo $info->voucher_no; ?></td>
                            </tr>

                            <tr>
                                <td>Name: <?php echo $partyInfo->name; ?></td>
                            </tr>

                            <tr>
                                <td>Mobile: <?php echo $partyInfo->mobile; ?></td>
                            </tr>

                            <tr>
                                <td>Address: <?php echo $partyInfo->address; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-xs-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Transport Info</th>
                            </tr>

                            <tr>
                                <td>Company Name: <?php echo $info->company_name; ?></td>
                            </tr>

                            <tr>
                                <td>Manage Name: <?php echo $info->t_name; ?></td>
                            </tr>

                            <tr>
                                <td>Mobile: <?php echo $info->t_mobile; ?></td>
                            </tr>

                            <tr>
                                <td>Address: <?php echo $info->t_address; ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-xs-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Driver/Vehicle Info</th>
                            </tr>

                            <tr>
                                <td>Driver Name: <?php echo $info->driver_name; ?></td>
                            </tr>

                            <tr>
                                <td>Mobile: <?php echo $info->driver_mobile; ?></td>
                            </tr>

                            <tr>
                                <td>Address: <?php echo $info->driver_address; ?></td>
                            </tr>

                            <tr>
                                <td>Vehicle No: <?php echo $info->vehicle_no; ?></td>
                            </tr>
                            <tr>
                                <td>Engine No: <?php echo $info->engine_no; ?></td>
                            </tr>
                            <tr>
                                <td>Chassis No: <?php echo $info->chassis_no; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 20px;">SL</th>
                        <th>Product Name</th>
                        <th class="text-right" style="width: 100px;">Qty</th>
                    </tr>
                    
                    <?php
                        foreach ($results as $key => $row) {
                    ?>
                        <tr>
                            <td><?php echo ($key + 1); ?></td>
                            <td><?php echo filter($row->name); ?></td>
                            <td class="text-right"><?php echo $row->quantity; ?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <td colspan="3"><strong>Remarks</strong>: <?php echo $info->remarks; ?></td>
                    </tr>
                </table>
                
                <div class="signature_box">
                    <h4>Signature of Customer</h4>
                    <h4>Signature of Authority</h4>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".inword").html(inWorden(<?php echo $total; ?>));
    });
</script>
