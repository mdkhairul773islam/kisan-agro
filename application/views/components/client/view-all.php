<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Clients</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;"
                       onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body" ng-cloak>
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide" style="margin-top: 0px;">All Customer</h4>
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th width="50">SL</th>
                            <th width="75">Godown</th>
                            <th width="75">C.ID</th>
                            <th>Name</th>
                            <th width="120">Mobile</th>
                            <th>Road/Area</th>
                            <th width="115">Credit Limit</th>
                            <th width="115">Due Limit(%)</th>
                            <th width="115">Balance</th>
                            <th width="115">Status</th>
                            <th class="none" style="width: 165px;">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                            $totalAmount = 0;
                            foreach ($results as $key => $row) {
                            $balanceInfo = get_client_balance($row->code);
                            $totalAmount += $balanceInfo->balance;
                        ?>
                        <tr>
                            <td><?php echo ++$key; ?></td>
                            <td>
                                <?php 
                                    $godown = get_name("godowns", 'name', ['code'=>$row->godown_code]);
                                    echo filter($godown);
                                ?>
                            </td>
                            <td><?php echo $row->code; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->mobile; ?></td>
                            <td><?php echo $row->address; ?></td>
                            <td><?php echo $row->credit_limit; ?></td>
                            <td><?php echo $row->due_limit; ?></td>
                            <td><?php echo $balanceInfo->balance; ?></td>
                            <td><?php echo filter($row->status); ?></td>
                            <td>
                                <?php if (is_access("client", "view")) { ?>
                                <a class="btn btn-primary" title="Preview" href="<?php echo site_url('client/client/preview/' . $row->id); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                                <?php } ?>
                                
                                <?php if (is_access("client", "edit")) { ?>
                                <a class="btn btn-warning" title="Edit" href="<?php echo site_url('client/client/edit/' . $row->id); ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <?php } ?>
                                
                                <?php if (is_access("client", "delete") && $this->session->userdata['privilege'] !== "user") { ?>
                                <a onclick="return confirm('Do you want to delete this Client?');" class="btn btn-danger" title="Delete" href="<?php echo site_url('client/client/delete/' . $row->code); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="panel-footer"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

<style>
    .btn-group, .btn-group-vertical {
        float: left;
    }
    div.dt-button-collection ul.dropdown-menu {
        min-width: 120px;
    }
</style>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            dom: 'Bfrtip',
            "paging": false,
            "info": false,
            lengthMenu: [
                [25, 50, 100, 250, 500, -1],
                ['25', '50', '100', '250', '500', 'all']
            ],
            buttons: [
                /*'pageLength',*/
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }, 'colvis'
            ]
        });
    });
</script>