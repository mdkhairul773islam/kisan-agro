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
</style>

<div class="container-fluid" ng-controller="showsubcategoryCtrl">
    <div class="row">
	    <?php  echo $this->session->flashdata('confirmation'); ?>

	    <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>

	    <div class="panel panel-default loader-hide" id="data">
	        <div class="panel-heading">
	            <div class="panal-header-title">
	                <h1 class="pull-left">View All Species</h1>
	                <a
						class="btn btn-primery pull-right"
						style="font-size: 14px; margin-top: 0;"
						onclick="window.print()">
						<i class="fa fa-print"></i> Print
					</a>
				</div>
	        </div>

	        <div class="panel-body" ng-init="showroom_id='<?php echo $branch; ?>'" ng-cloak>
	            <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.png'); ?>">
                
	            <h4 class="text-center hide" style="margin-top: 0px;">All Species </h4>

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

	            <table class="table table-bordered">
	                <tr>
	                    <th style="width: 50px;">SL</th>
	                    <th style="cursor:pointer;" ng-click="sortField='category'; reverse = !reverse;">Category &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
	                    <th>Species Name </th>
	                    <th class="none" style="width: 115px;">Action</th>
	                </tr>

	                <tr dir-paginate="(index,subcategory) in allSubcategory|filter:search|itemsPerPage:perPage|orderBy:sortField:reverse">
	                    <td>{{index+1}}</td>
	                    <td>{{subcategory.category}}</td>
	                    <td>{{subcategory.subCategory}}</td>
	                    <td  class="none">
	                        <a
								class="btn btn-warning"
								title="Edit" href="<?php echo site_url('subCategory/subCategory/editsubCategory?id={{subcategory.id}}');?>">
								<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
							</a>

							<a onclick="return confirm('Do you want to delete this Sub Category?');"
								class="btn btn-danger" title="Delete"
								href="<?php echo site_url('subCategory/subCategory/deletesubCategory/{{subcategory.id}}'); ?>">
								<i class="fa fa-trash-o" aria-hidden="true"></i>
							</a>
	                    </td>
	                </tr>
	            </table>

	            <dir-pagination-controls max-size="perPage" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>
	        </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
