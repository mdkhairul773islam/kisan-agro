<style>
    @media print {
        aside {
            display: none !important;
        }

        nav {
            display: none;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .none {
            display: none;
        }

        .panel-heading {
            display: none;
        }

        .panel-footer {
            display: none;
        }

        .panel .hide {
            display: block !important;
        }

        .title {
            font-size: 25px;
        }

        table tr th, table tr td {
            font-size: 12px;
        }
    }

    .table tr th {
        width: 22%;
    }
</style>


<div class="container-fluid">

    <!--pre><?php //print_r($info); ?></pre-->
    
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Profile</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">Client Profile</h4>

                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Code</th>
                        <td><?php echo $info->code; ?></td>
                        <th>Opening Date</th>
                        <td><?php echo $info->opening; ?></td>
                    </tr>

                    <tr>
                        <th>Client/Company Name</th>
                        <td><?php echo filter($info->name); ?></td>
                        <th>Contact Person</th>
                        <td><?php echo filter($info->contact_person); ?></td>
                    </tr>

                    <tr>
                        <th>Mobile Number</th>
                        <td><?php echo $info->mobile; ?></td>
                        <th>Road/Area</th>
                        <td><?php echo filter($info->address); ?></td>
                    </tr>

                    <tr>
                        <th> Type</th>
                        <td><?php echo filter($info->type); ?></td>
                        <th>Initial Balance</th>
                        <td>
                            <?php
                            $init_balance = $info->initial_balance;
                            $status       = ($init_balance < 0) ? " Payable" : " Receivable";
                            echo abs($init_balance) . ' TK &nbsp; [' . $status . '&nbsp;]'; ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Balance</th>
                        <td><?php echo abs($balanceInfo->balance) . ' TK &nbsp; [' . $balanceInfo->status . '&nbsp;]'; ?>

                        </td>
                        <th>Status</th>
                        <td><?php echo filter($info->status); ?></td>
                    </tr>
                    <tr>
                        <th>Loan</th>
                        <td>
                            <?php if(!empty($info->loan)){ ?> <iframe src="<?= site_url($info->loan)?>"  title="Iframe Example"></iframe><?php } ?>
                        </td>
                        <th>Agreement</th>
                        <td>
                            <?php if(!empty($info->agreement)){ ?> <iframe src="<?= site_url($info->agreement)?>"  title="Iframe Example"></iframe><?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>NID</th>
                        <td>
                            <?php if(!empty($info->nid)){ ?> <iframe src="<?= site_url($info->nid)?>" title="Iframe Example"></iframe><?php } ?>
                        </td>
                        <th>Trade License</th>
                        <td>
                            <?php if(!empty($info->trade_license)){ ?> <iframe src="<?= site_url($info->trade_license)?>"  title="Iframe Example"></iframe><?php } ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
