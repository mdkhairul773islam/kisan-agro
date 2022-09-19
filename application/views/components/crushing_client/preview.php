<style>
    @media print{
        aside{display: none !important;}
        nav{display: none;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .none{display: none;}
        .panel-heading{display: none;}
        .panel-footer{display: none;}
        .panel .hide{display: block !important;}
        .title{font-size: 25px;}
        table tr th,table tr td{font-size: 12px;}
    }
    .table tr th {width: 22%;}
</style>


<div class="container-fluid" >

  <!--pre><?php //print_r($partyInfo); ?></pre-->
    <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
    <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">Profile</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
               <!--  <img class="img-responsive print-banner hide" src="<?php //echo site_url('public/img/banner.png'); ?>"> -->

                <h4 class="text-center hide" style="margin-top: 0px;">Profile</h4>

                <table class="table table-bordered table-hover">
                    <tr>
                      <th>ID</th>
                       <td><?php echo $partyInfo[0]->code; ?></td>
                      <th>Opening Date</th>
                      <td><?php echo $partyInfo[0]->opening; ?></td>
                   	</tr>

                    <tr>
                       <th>Client/Company Name</th>
                       <td><?php echo filter($partyInfo[0]->name); ?></td>
                       <th>Contact Person</th>
                       <td><?php echo filter($partyInfo[0]->contact_person); ?></td>
                    </tr>

                    <tr>
                       <th>Mobile Number</th>
                       <td><?php echo $partyInfo[0]->mobile; ?></td>
                       <th>Address</th>
                       <td><?php echo filter($partyInfo[0]->address); ?></td>
                   </tr>

                   	<tr>
                       	<th> Type</th>
                       	<td><?php echo filter($partyInfo[0]->type); ?></td>
                        <th>Initial Balance </th>
                        <td><?php $init_balance = $partyInfo[0]->initial_balance;
                          $status = ($init_balance < 0) ? " Payable" : " Receivable";
                          echo abs($init_balance) . ' TK &nbsp; [' . $status . '&nbsp;]'; ?>
                        </td>
                   	</tr>

                    <tr>
                        <th>Balance </th>
                        <td><?php $init_balance = $partyInfo[0]->balance;
                          $status = ($init_balance < 0) ? " Payable" : " Receivable";
                          echo abs($init_balance) . ' TK &nbsp; [' . $status . '&nbsp;]'; ?>

                        </td>
                        <th>Credit Limit </th>
                        <td><?php echo $partyInfo[0]->credit_limit;?> TK</td>
                    </tr>

                   	<tr>
                       	<th>Status</th>
                       	<td colspan="3"><?php echo filter($partyInfo[0]->status);?></td>
                   </tr>
                </table>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
