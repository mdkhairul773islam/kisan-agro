<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading panal-header">
                <div class="panal-header-title pull-left">
                    <h1>Add New Recipe</h1>
                </div>
            </div>

            <div class="panel-body">

                <?php $attr = array(
                    'class' =>'form-horizontal'
                    );
	            echo form_open('recipe/make_recipe/addRecipe',$attr); ?>


                <div class="form-group">
                    <label class="col-md-2 control-label"> Name <span class="req">*</span></label>
                    <div class="col-md-5">
                        <input type="text" name="name" placeholder="" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-7">
                        <input type="submit" value="Save" name="catetory_submit" class="btn btn-primary pull-right">
                    </div>
                </div>

                <?php echo form_close(); ?>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

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
        .title{
            font-size: 25px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
    <?php  echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">All Make Recipe </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>


            <div class="panel-body">
                <!-- Print banner -->
                <img class="img-responsive print-banner hide" src="<?php echo site_url('public/img/banner.png'); ?>">

                <h4 class="text-center hide" style="margin-top: 0px;">All Make Recipe</h4>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 50px;">SL</th>
                        <th>Date</th>
                        <th style="cursor:pointer;" ng-click="sortField='category'; reverse = !reverse;">Name &nbsp;<span><i class="fa fa-sort pull-right none" aria-hidden="true"></i></span></th>
                        <th class="none" style="width: 115px;">Action</th>
                    </tr>
                    <?php foreach($make_recipe as $key => $value){ ?>
                    <tr>
                        <td><?php echo ($key+1); ?></td>
                        <td><?php echo $value->date; ?></td>
                        <td><?php echo filter($value->name); ?></td>
                        <td  class="none">
                            <a class="btn btn-warning" title="Edit" href="<?php echo site_url('recipe/make_recipe/editRecipe/'.$value->id);?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            <a onclick="return confirm('Do you want to delete this Recipe?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('recipe/make_recipe/deleteRecipe/'.$value->id);?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>


