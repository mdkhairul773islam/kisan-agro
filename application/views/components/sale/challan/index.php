<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css"/>

<div class="container-fluid">
    <div class="row">
        <?php echo $this->session->flashdata('confirmation'); ?>
        
        <div class="panel panel-default none">
            <div class="panel-heading">
                <div class="panal-header-title pull-left">
                    <h1>All Challan</h1>
                </div>
            </div>
            
            <div class="panel-body">
                <div class="row">
                    <?php echo form_open(); ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="search[voucher_no]" placeholder="Voucner no" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[party_code]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected disabled>Select Client</option>
                                <?php
                                if (!empty($clientList)) {
                                    foreach ($clientList as $row) { ?>
                                        <option value="<?php echo $row->code; ?>">
                                            <?php echo filter($row->name) . " ( " . $row->address . " ) "; ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="search[transport_id]" class="selectpicker form-control" data-show-subtext="true" data-live-search="true">
                                <option value="" selected>Select Transport</option>
                                <?php
                                if (!empty($transportList)) {
                                    foreach ($transportList as $row) { ?>
                                        <option value="<?php echo $row->id; ?>">
                                            <?php echo filter($row->company_name); ?>
                                        </option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerFrom">
                                <input type="text" name="dateFrom" class="form-control" placeholder="From">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="input-group date" id="datetimepickerTo">
                                <input type="text" name="dateTo" class="form-control" placeholder="To">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="submit" name="show" value="Show" class="btn btn-primary">
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>


        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panal-header-title ">
                    <h1 class="pull-left">Show Result</h1>
                    <a class="btn btn-primery pull-right" style="font-size: 14px; margin-top: 0;" onclick="window.print()"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div class="panel-body">
                <!-- Print banner -->
                <?php $this->load->view('components/print'); ?>
                <h4 class="text-center hide" style="margin-top: 0px;">All Challan</h4>
                
                <div class="table-responsive">
                    <table class="table table-bordered " id="DataTable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Voucher No</th>
                                <th>Client's Name</th>
                                <th>Mobile</th>
                                <th>Transport Name</th>
                                <th>Mobile</th>
                                <th>Driver Name</th>
                                <th>Mobile</th>
                                <th>Vehicle No</th>
                                <th>Quantity</th>
                                <th class="none" style="min-width: 135px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $key => $row) {?>
                            <tr>
                                <td> <?php echo($key + 1); ?> </td>
                                <td> <?php echo $row->created; ?> </td>
                                <td> <?php echo $row->voucher_no; ?> </td>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->mobile; ?></td>
                                <td><?php echo $row->company_name; ?></td>
                                <td><?php echo $row->t_mobile; ?></td>
                                <td><?php echo $row->driver_name; ?></td>
                                <td><?php echo $row->driver_mobile; ?></td>
                                <td><?php echo $row->vehicle_no; ?></td>
                                <td><?php echo $row->total_quantity; ?></td>
                                <td class="none">
                                    <a title="Gate pass" class="btn btn-info" href="<?php echo site_url('sale/challan/gate_pass'); ?>">
                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                    </a>
                                    <a title="View" class="btn btn-primary" href="<?php echo site_url('sale/challan/show?cNo=' . $row->challan_no); ?>">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    <a onclick="return confirm('Are you sure want to delete this Sale?');" title="Delete" class="btn btn-danger"
                                       href="<?php echo site_url('sale/challan/delete?cNo=' . $row->challan_no); ?>">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<style>
    .dataTables_wrapper .dataTables_filter input {
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
    }

    table.dataTable thead th,
    table.dataTable {
        border-bottom: transparent;
    }

    table.dataTable.no-footer {
        border-bottom: transparent;
    }

    table.dataTable tfoot th, table.dataTable tfoot td {
        border-top: transparent;
    }

    table.dataTable.display tbody td {
        border-top: transparent;
        border-right: transparent;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!-- Style for data table -->
<link rel="stylesheet" href="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.css') ?>">
<script src="<?= site_url('private/plugins/dataTable/jquery.dataTables.min.js') ?>"></script>

<script>
    $('#datetimepickerFrom').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });

    $('#datetimepickerTo').datetimepicker({
        format: 'YYYY-MM-DD',
        useCurrent: false
    });
    
    $(document).ready(function () {
        $('#DataTable').DataTable({
            "pageLength": 50
        });
    });
</script>

