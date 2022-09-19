<style type="text/css">
    .profile-title {display: flex;}
    .profile-title img {
        margin-bottom:  10px;
        width: 70px;
        height: 70px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">View Wages Payment</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs none" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="profile">
                                <div class="row profile-title no-padding">
                                    <div class="col-xs-6">
                                        <div class="profile-title">
                                            <h3 class="pull-left img-show" 
                                                style="margin-bottom: 20px;">
                                                <?php echo $result['name']; ?>
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="col-xs-6">&nbsp;</div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">ID</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['eid']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Post</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['post']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Mobile</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['mobile']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Gender</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['gender']; ?> </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-xs-12 no-padding">
                                        <label class="control-label col-xs-5">Joining Date</label>
                                        <div class="col-xs-7">
                                            <p> <?php echo $result['joining']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php if(!empty($info)){ ?>
                <table class="table table-bordered">
                    <tr>
                        <th>Date</th>
                        <th>Attendance</th>
                        <th>Salary <small>(Tk)</small></th>
                        <th>Bonus <small>(Tk)</small></th>
                        <th>Total Salary <small>(Tk)</small></th>
                        <th>Payemnt <small>(Tk)</small></th>
                    </tr>

                    <?php foreach($info as $key => $val){ ?>
                    <tr>
                        <td><?php echo $val->created_at; ?></td>
                        <td><?php echo $val->attendance; ?></td>
                        <td><?php echo $val->salary; ?></td>
                        <td><?php echo $val->bonus; ?></td>
                        <td><?php echo ($val->salary * $val->attendance) + $val->bonus; ?></td>
                        <td><?php echo $val->payment; ?></td>
                    </tr>
                    <?php } ?>
                </table>
                <?php } ?>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>