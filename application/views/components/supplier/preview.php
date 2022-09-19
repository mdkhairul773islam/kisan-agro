<div class="container-fluid">
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

                <h4 class="text-center hide" style="margin-top: 0px;">Supplier Profile</h4>

                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Date</th>
                        <td><?php echo $info->opening; ?></td>
                    </tr>

                    <tr>
                        <th width="40%">ID</th>
                        <td><?php echo $info->code; ?></td>
                    </tr>

                    <tr>
                        <th>Name</th>
                        <td><?php echo filter($info->name); ?></td>
                    </tr>

                    <tr>
                        <th>Mobile Number</th>
                        <td><?php echo $info->mobile; ?></td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td><?php echo $info->address; ?></td>
                    </tr>

                    <tr>
                        <th>Initial Balance</th>
                        <td>
                            <?php
                            $init_balance = $info->initial_balance;
                            $status       = ($init_balance < 0) ? " Payable" : " Receivable";
                            echo abs($init_balance) . ' TK &nbsp; [' . $status . '&nbsp;]';
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Current Balance</th>
                        <td>
                            <?php
                            $balanceInfo = get_supplier_balance($info->code);
                            echo abs($balanceInfo->balance) . ' TK &nbsp; [' . $balanceInfo->status . '&nbsp;]';
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td><?php echo filter($info->status); ?></td>
                    </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
