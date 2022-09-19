<style>
    .view-image {
        border: 1px solid #eee;
        position: relative;
        width: 100%;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .view-image img {width: 100%;}
    .view-image figcaption {
        position: absolute;
        width: 100%;
        bottom: 0;
    }
    .view-image figcaption a {
        border-radius: 0 0 4px 4px;
        width: 100%;
    }
</style>

<div class="container-fluid">
    <div class="row" ng-controller="showAllProductCtrl">
	    <?php echo $this->session->flashdata('confirmation'); ?>
        <div id="loading">
            <img src="<?php echo site_url("private/images/loading-bar.gif"); ?>" alt="Image Not found"/>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Sister Concern</h1>
                </div>
            </div>
            
            <div ng-cloak class="panel-body">
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.png'); ?>">
               
                <div class="row">
                    <?php 
                        if ($info != null) {
                        foreach ($info as $key => $row) {
                    ?>
                    <div class="col-md-3">
                        <figure class="view-image">
                            <img src="<?php echo site_url($row->image); ?>" alt="Photo not found..!" width="150px">
                            <figcaption>
                                <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure want to delete this Product?');" href="<?php echo site_url("sister_concern/sister_concern/all?id=".$row->id) ; ?>"> Delete </a>
                            </figcaption>
                        </figure>
                    </div>
                    <?php }} ?> 
                </div>
            </div>
            
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

