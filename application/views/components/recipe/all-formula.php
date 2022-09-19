<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>
<style>
    @media print {
        aside, nav, .none, .panel-heading, .panel-footer, .dt-buttons, .dataTables_filter, .dataTables_info, .dataTables_paginate {
            display: none !important;
        }

        .panel {
            border: 1px solid transparent;
            left: 0px;
            position: absolute;
            top: 0px;
            width: 100%;
        }

        .hide {
            display: block !important;
        }
    }

    .wid-100 {
        width: 100px;
    }

    #loading {
        text-align: center;
    }

    #loading img {
        display: inline-block;
    }
</style>

<div class="container-fluid">
    <div class="row">
    <?php echo $this->session->flashdata('confirmation'); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">View All Formula </h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                
                <h4 class="text-center hide" style="margin-top: 0px;">All Formula</h4>
                <div class="table-responsive">
                    <?php if (!empty($recipes)){ ?>
                    <table class="table table-bordered" id="DataTable">
                        <thead>
                        <tr>
                            <th width="50" >SL</th>
                            <th>Recipe Name</th>
                            <th class="none" width="180">Action</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                        <?php foreach($recipes as $key => $recipe){ ?>
                        <tr>
                            <td><?php echo ($key+1); ?></td>
                            <td><?php echo filter($recipe->category_name); ?></td>
                            <td class="none">
                                <a class="btn btn-primary" title="Show" href="<?php echo site_url('recipe/make_formula/show/'.$recipe->category_code); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-warning" title="Edit" href="<?php echo site_url('recipe/make_formula/edit/'.$recipe->category_code); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <?php if($this->session->userdata['privilege'] !== "user"){ ?>
                                    <a class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure to delete this data?');" href="<?php echo site_url('recipe/make_formula/delete/'.$recipe->category_code) ;?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php } else {
                        echo "<p class='text-center'> <strong>No data found!</strong> </p>";
                    } ?>
                </div>

            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
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
        $('#DataTable').DataTable({
            dom: 'Bfrtip',
            "paging":   false,
            "info":     false,
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
