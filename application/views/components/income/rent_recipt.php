<?php   $header_info = $footer_info = null;
        if (isset($meta->header)) {$header_info = json_decode($meta->header,true);}
        if (isset($meta->footer)) {$footer_info = json_decode($meta->footer,true);}
?>
<style>
    .table>tbody>tr>td {padding: 2px;}
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer { display: none !important; }
        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .hide{display: block !important;}
        .panel-body {height: 96vh;}
        .table-bordered, .print-font { font-size: 14px !important; }
    }
    .print-text {text-align: center;box-shadow: 1px 1px 1px 2px #999; width: 100%;}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default ">
            <div class="panel-heading none">
                <div class="panal-header-title">
                    <h1 class="pull-left">Rent Recipt</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            <div class="panel-body">
                <!-- Print banner -->
                <!--<img class="img-responsive print-banner hide" src="<?php //echo site_url($banner_info[0]->path); ?>">-->
                <div class="print-text hide">
                    <h1><?php echo $header_info['site_name']; ?></h1>
                    <p><?php echo $header_info['place_name']; ?></p>
                    <p><span><?php echo $footer_info['addr_moblile']; ?></span> || <span><?php echo $footer_info['addr_email']; ?></span></p>
                </div>
                
                
                <div class="row">
                    <div class="col-xs-8 print-font">
                        <label>Received By : <?php echo $rentInfo[0]->received_by; ?></label>
                    </div>

                    <div class="col-xs-4 print-font">
                        <label>Given By : <?php echo $rentInfo[0]->remark; ?></label>
                    </div>
                </div><br>
                
                <table class="table table-bordered text-center">
                    <tr>
                        <th class="text-center">Date</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Month</th>
                        <th class="text-center">Amount (TK)</th>
                    </tr>

                    <tr>
                        <td><?php echo $rentInfo[0]->date; ?></td>
                        <td><?php echo $rentInfo[0]->year; ?></td>
                        <td><?php echo $rentInfo[0]->month; ?></td>
                        <td><?php echo $rentInfo[0]->amount.' TK'; ?></td>
                    </tr>
                </table>

                <div class="col-sm-6 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-left print-font">
                        ------------------------------ <br>
                        Signature of Proprietor
                    </h4>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <h4 style="margin-top: 40px;" class="text-right print-font">
                        ------------------------------ <br>
                        Signature of Lessee
                    </h4>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo site_url("private/js/inworden.js"); ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){$("#inword").html(inWorden(<?php echo $gtotal; ?>));});
</script>