<style>
    @media print{
        aside, .panel-heading, .panel-footer, nav, .none{display: none !important;}
        .panel{border: 1px solid transparent;left: 0px;position: absolute;top: 0px;width: 100%;}
        .hide{display: block !important;}
        table tr th,table tr td{font-size: 12px;}
    }
    .action-btn a{
        margin-right: 0;
        margin: 3px 0;
    }
</style>

<div class="container-fluid" ng-controller="allCrushingClientCtrl" ng-cloak>
    <div class="row">
    	<?php  echo $this->session->flashdata('confirmation'); ?>

        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>

    	<div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Crushing Clients</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
				</div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.jpg'); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">All Customer</h4>

                <div class="row none">
                    <div class="col-md-3" style="margin-bottom:15px;">
                        <input type="text" ng-model="search" placeholder="Search...." class="form-control">
                    </div>
                    <div class="col-md-offset-6 col-md-3">
                        <select ng-model="perPage" class="form-control pull-right" style="width:100px;">
                            <option value="">All</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                        </select>
                    </div>

                    <?php if ($branch == "godown") { ?>
                    <div class="col-md-3" style="margin-bottom:0px;">
                        <select class="form-control" ng-model="searchItem.showroom_id">
                            <option value="">-- Showroom --</option>
                            <option value="godown">Head Office</option>
                            <?php foreach ($allShowroom as $key => $value) { ?>
                            <option value="<?php echo $value->showroom_id; ?>"><?php echo $value->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php } ?>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th width="50">SL</th>
                        <th width="75">C.ID</th>
                        <th>Client Name</th>
                        <th>Address</th>
                        <th width="120">Mobile</th>
                        <th width="115">Balance</th>
                        <th width="115">Credit Limit</th>
                        <th class="none" style="width: 160px;">Action</th>
                    </tr>

                    <tr dir-paginate="row in allParty|filter:search|filter:searchItem|orderBy:sortField:reverse|itemsPerPage:perPage">
                        <input type="hidden" ng-value="row.showroom_id">
                        <td>{{ row.sl }}</td>
                        <td>{{ row.code }}</td>
                        <td>{{ row.name | textBeautify}} </td>
                        <td>{{ row.address | textBeautify}} </td>
                        <td>{{ row.mobile }}</td>
                        <td style="font-weight:bold; color:{{ row.balanceColor}}">{{ row.balance }}</td>
                        <td style="font-weight:bold; color:{{ row.clColor}}">{{ row.credit_limit}}</td>
                        <td class="none action-btn">
                            <a
                                class="btn btn-info"
                                title="Preview"
                                href="<?php echo site_url('crushing_client/crushing_client/preview?partyCode={{row.code}}'); ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>

                            <a 
                                class="btn btn-warning" 
                                title="Edit" 
                                href="<?php echo site_url('crushing_client/crushing_client/edit?partyCode={{row.code}}');?>">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <a
                                onclick="return confirm('Do you want to delete this Crushing Client?');" class="btn btn-danger"
                                title="Delete"
                                href="<?php echo site_url('crushing_client/crushing_client/delete/{{row.code}}'); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                </table>
                <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>

            <div class="panel-footer"> </div>
        </div>
    </div>
</div>
