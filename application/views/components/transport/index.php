<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default">
            <div class="panel-heading none">
                <div class="panal-header-title pull-left">
                    <h1>All Transport</h1>
                </div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                        <tr>
                            <th style="width: 20px;">SL</th>
                            <th>Date</th>
                            <th>Transport Name</th>
                            <th>Manager Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Remarks</th>
                            <th class="none" style="width: 85px;">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        if (!empty($results)) {
                            foreach ($results as $key => $row) { ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $row->created; ?></td>
                                    <td><?php echo $row->company_name; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->mobile; ?></td>
                                    <td><?php echo $row->email; ?></td>
                                    <td><?php echo $row->address; ?></td>
                                    <td><?php echo $row->remarks; ?></td>
                                    <td class="none text-center">
                                        <a class="btn btn-warning"
                                           href="<?php echo site_url('transport/transport/edit/' . $row->id); ?>">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </a>

                                        <a class="btn btn-danger"
                                           onclick="return confirm('Are you sure delete this data!')"
                                           href="<?php echo site_url('transport/transport/delete/' . $row->id); ?>">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

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
