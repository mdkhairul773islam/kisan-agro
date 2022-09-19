<style>
    @media print{
        aside, nav, .none, .panel-heading, .panel-footer{
            display: none !important;
        }
        .panel{
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }
        .panel .hide{
            display: block !important;
        }
    }
</style>

<div class="container-fluid" ng-controller="ShowGodownCtrl">
    <?php echo $this->session->flashdata('confirmation'); ?>
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">সকল শো-রুম </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()">
                        <i class="fa fa-print"></i> 
                        প্রিন্ট
                    </a>
                </div>
            </div>

            <div class="panel-body">
                
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.png'); ?>">
                
                <hr class="hide" style="border-bottom: 1px solid #ccc;">
                <h4 class="text-center hide" style="margin-top: -10px;">সকল শো-রুম </h4>
                
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>স্থান</th>
                        <th>সোপারভাইজার</th>
                        <th>যোগাযোগ নম্বর</th>
                        <th>ঠিকানা</th>
                        <th class="none">একশন</th>
                    </tr>
               
                    <tr dir-paginate="row in result|itemsPerPage:20">
                        <td> {{ row.sl }} </td>
                        <td> {{ row.place }} </td>
                        <td> {{ row.supervisor }} </td>
                        <td> {{ row.contact_no }} </td>
                        <td> {{ row.address }} </td>
                        <td class="none" style="width: 115px;">
                            <a class="btn btn-warning" href="<?php echo site_url('godown/godown/edit_godown?id='); ?>{{ row.id }}">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>

                            <a class="btn btn-danger" onclick="return confirm('Are you sure delete this data!')" href="<?php echo site_url('godown/godown/delete/{{row.id}}'); ?>">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                </table>

                <dir-pagination-controls max-size="20" direction-links="true" boundary-links="true" class="none"></dir-pagination-controls>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

