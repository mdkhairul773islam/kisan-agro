<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        <div class="panel panel-default" id="data">
            <div class="panel-heading">
                <div class="panal-header-title">
                    <h1 class="pull-left">View All Supplier</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>

                <h4 class="text-center hide" style="margin-top: 0px;">All Supplier</h4>
                <?php
                    echo $this->session->flashdata('deleted');
                    $attr = array("class" => "form-horizontal");
                    echo form_open("", $attr);
                ?>
                <div class="form-group">
                    <div class="col-md-4">
                        <select name="party_code" class="selectpicker form-control" data-show-subtext="true" data-live-search="true" required>
                            <option value="" selected disabled>Select Supplier</option>
                            <?php if ($allParty != null) {
                                foreach ($allParty as $key => $row) { ?>
                                    <option value="<?php echo $row->code; ?>">
                                        <?php echo filter($row->name); ?>
                                    </option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
                <hr>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                        <tr>
                            <th style="width: 50px;">SL</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Mobile</th>
                            <th>Current Balance</th>
                            <th>Type</th>
                            <th class="none">Status</th>
                            <th class="none" style="width: 170px;">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($results as $key => $value) {
                            // get supplier balnce info
                            $balanceInfo = get_supplier_balance($value->code);
                            ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo $value->code; ?></td>
                                <td><?php echo filter($value->name); ?></td>
                                <td><?php echo filter($value->contact_person); ?></td>
                                <td><?php echo $value->mobile; ?></td>
                                <td class="text-right"><?php echo f_number(abs($balanceInfo->balance)); ?></td>
                                <td><?php echo $balanceInfo->status; ?></td>
                                <td class="none"><?php echo $value->status; ?></td>
                                <td class="none">
                                    <a class="btn btn-primary" title="Preview"
                                        href="<?php echo site_url('supplier/supplier/preview/' . $value->id); ?>"><i
                                                class="fa fa-eye" aria-hidden="true"></i></a>

                                    <a class="btn btn-warning" title="Edit"
                                        href="<?php echo site_url('supplier/supplier/edit/' . $value->id); ?>"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                    <?php if ($this->session->userdata['privilege'] !== "user") { ?>
                                        <a onclick="return confirm('Do you want to delete this information?');"
                                            class="btn btn-danger" title="Delete"
                                            href="<?php echo site_url('supplier/supplier/delete/' . $value->code); ?>"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>

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
