<div class="container-fluid" ng-controller="showSrCtrl">
    <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>
        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>
        <div class="panel panel-default loader-hide" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All SR</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
            
            <div class="panel-body"  ng-cloak>
                <h4 class="text-center hide" style="margin-top: 0px;">All SR</h4>
                <div class="row none" style="margin-bottom:15px;">
                    <div class="col-sm-4" style="margin-bottom:15px;">
                        <input type="text" ng-model="search" placeholder="Search.........." class="form-control">
                    </div>
                    <div class="col-sm-offset-4 col-sm-4">
                        <div style="display: flex;" class="pull-right">
                            <label style="line-height: 34px; padding-right: 5px;">Per Page</label>
                            <select ng-model="perPage" class="form-control" style="width:75px;">
                                <option value="">All</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                         </div>
                    </div>
                </div>
                
                <table class="table table-bordered" ng-cloak>
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th style="cursor:pointer;" ng-click="sortField='name'; reverse = !reverse;">Name &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
                        <th style="cursor:pointer;" ng-click="sortField='mobile'; reverse = !reverse;">Mobile &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
                        <th style="cursor:pointer;" ng-click="sortField='address'; reverse = !reverse;">Address &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
                        <!--<th style="cursor:pointer;" ng-click="sortField='area'; reverse = !reverse;">Area</th> &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>-->
                        <th class="none" style="width: 115px;">Action</th>
                    </tr>

                    <tr dir-paginate="sr in srList|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
                        <td>{{sr.sl}}</td>
                        <td>{{sr.name | removeUnderScore}}</td>
                        <td>{{sr.mobile | removeUnderScore}}</td>
                        <td>{{sr.address | removeUnderScore}}</td>
                        <!--<td>{{sr.area | removeUnderScore}}</td>-->
                        <td  class="none">
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('sr/sr/editsr/{{sr.id}}');?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="return confirm('Do you want to delete this reference?');" class="btn btn-danger" title="Delete" href="<?php echo site_url("sr/sr/deletesr/{{sr.id}}"); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                </table>
                <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
