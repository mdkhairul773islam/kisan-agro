<style>
    .deshitem {margin-bottom: 15px !important;}
    .privilege tr th {
        white-space: nowrap;
    }
    .view {color: green;}
    .edit {color: #EC971F;}
    .checkbox-inline, .checkbox label, .radio label {
        font-weight: bold;
        padding-left: 0;
    }
    .checkbox label:after, .radio label:after {
        content: '';
        display: table;
        clear: both;
    }
    .checkbox .cr, .radio .cr {
        border: 1px solid #a9a9a9;
        display: inline-block;
        border-radius: .25em;
        position: relative;
        width: 1.3em;
        float: left;
        height: 1.3em;
        margin-right: 5px;
    }
    .checkbox-inline, .radio-inline + .radio-inline {
        margin-right: 10px !important;
        margin-top: 0 !important;
        margin-left: 0 !important;
    }
    .radio .cr {border-radius: 50%;}
    .checkbox .cr .cr-icon, .radio .cr .cr-icon {
        position: absolute;
        font-size: .8em;
        line-height: 0;
        top: 50%;
        left: 20%;
    }
    .radio .cr .cr-icon {margin-left: 0.04em;}
    .checkbox label input[type="checkbox"], .radio label input[type="radio"] {
        display: none;
    }
    .checkbox label input[type="checkbox"] + .cr > .cr-icon, .radio label input[type="radio"] + .cr > .cr-icon {
        transform: scale(3) rotateZ(-20deg);
        opacity: 0;
        transition: all .3s ease-in;
    }
    .checkbox label input[type="checkbox"]:checked + .cr > .cr-icon, .radio label input[type="radio"]:checked + .cr > .cr-icon {
        transform: scale(1) rotateZ(0deg);
        opacity: 1;
    }
    .checkbox label input[type="checkbox"]:disabled + .cr, .radio label input[type="radio"]:disabled + .cr {
        opacity: .5;
    }
    #progress {display: none;}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panal-header">
                <div class="panal-header-title">
                    <h1 class="pull-left">Set Privilege</h1>
                    <img id="progress" class="pull-right" src="#" alt=""></span>
                </div>
            </div>

            <div class="panel-body">
                <form action="" class="row">
                    <div class="col-md-4">
                        <label class="control-label">Privilege <span class="req">*</span></label>
                        <div class="form-group">
                            <select name="privilege" id="privilege" class="form-control" required>
                                <option value="">Select Menu</option>
                                <?php foreach ($privileges as $privilege) { ?>
                                    <option value="<?php echo $privilege->privilege; ?>">
                                        <?php echo filter($privilege->privilege); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="control-label">User Name<span class="req">*</span></label>
                        <div class="form-group">
                            <select name="user_id" id="user_id" class="form-control" required> </select>
                        </div>
                        <div class="col-md-12">
                            <hr style="margin-bottom: 0">
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="active">
                            <th rowspan="2" style="vertical-align: middle;">Menu Item</th>
                            <th colspan="3">Navbar Items</th>
                        </tr>
                        </thead>

                        <tbody>
                        <!-- Dashboard Start here -->
                        <tr>
                            <th style="width: 235px;">
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="dashboard">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Dashboard</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="todays_sale">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Today's Sale
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="todays_client_pay">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Today's Client Pay
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="total_client_due">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Total Client Due
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="raw_mat_stock">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Raw Mats Stock
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="todays_purchase">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Today's Purchase
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="supplier_pay">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Todays Supplier Pay
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_expenses">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Today's Expenses
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action" value="todays_income">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Today's Income
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="total_exp_pay">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Total EXP/PAY
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="supplier_due">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Total Supplier Due
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="finish_stock">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Finish Product Stock
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="bank_deposit">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Bank Deposit
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="bank_withdraw">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Bank Withdraw
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="total_bank_balance">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Total Bank Balance
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="total_supplier">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Total Supplier
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="total_client">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Total Client
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="cash_in_hand">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Today's Cash In Hand
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="raw_stock_alert">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Raw Meterial's Stock Alert
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="dashboard" data-item="action"
                                               value="finish_stock_alert">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Finish Product Stock Alert
                                    </label>
                                </div>
                            </td>
                        </tr>

                        <!-- Raw Materials Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="purchase_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Raw Materials</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="requisition">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Requisition
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="allRequisition">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Requisition
                                    </label>
                                </div>
                                
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="purchaseOrder">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Purchase Order
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="allPurchaseOrder">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Purchase Order
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="stockEntry">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Stock Entry
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="allStockEntry">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Stock Entry
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Purchase
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Purchase
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="wise">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Item Wise Search
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="return">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Return
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="all_return">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Return
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="stock">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Stock
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="ledger">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Ledger
                                    </label>
                                </div>
                                
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="purchase_menu" data-item="action" value="product">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Product
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Product Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="product_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Product</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Product
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Product
                                    </label>
                                </div>
                                <!--<div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="deactive">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Unavailable All
                                    </label>
                                </div>-->
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="product_menu" data-item="action" value="category">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Category
                                    </label>
                                </div>
                            </td>
                        </tr>


                        <!-- Production Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="production_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Production</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="production_menu" data-item="action"
                                               value="createProduction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Production
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="production_menu" data-item="action"
                                               value="allProduction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Production
                                    </label>
                                </div>
                            </td>
                        </tr>


                        <!-- Sale Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="sale_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Sale</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sale_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add New
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sale_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sale_menu" data-item="action" value="allChallan">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Challan
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sale_menu" data-item="action" value="itemWise">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Item Wise Report
                                    </label>
                                </div>
                                <!--<div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sale_menu" data-item="action"
                                               value="multi-return">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Sale Return
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sale_menu" data-item="action"
                                               value="multi-return-all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Sale Return
                                    </label>
                                </div>-->
                            </td>
                        </tr>


                        <!-- Finished Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="product_stock_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Finished Goods Stock</span>
                                    </label>
                                </div>
                            </th>
                            <td></td>
                        </tr>
                        
                        
                        <!-- Zone Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="zone_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Zone</span>
                                    </label>
                                </div>
                            </th>
                            <td colspan="3" width="320">
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="zone_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add New
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="zone_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Sr Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="sr_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Sr</span>
                                    </label>
                                </div>
                            </th>
                            <td colspan="3" width="320">
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sr_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add New
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sr_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sr_menu" data-item="action" value="add_comission">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Comission
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sr_menu" data-item="action" value="all_comission">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Comission
                                    </label>
                                </div>
                            </td>
                        </tr>
                            
                            
                        <!-- Supplier Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="supplier-menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Supplier</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action" value="add">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Supplier
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Supplier
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action"
                                               value="transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="supplier-menu" data-item="action"
                                               value="all-transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Transaction
                                    </label>
                                </div>
                            </td>
                        </tr>


                        <!-- Client Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="client_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Client</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action" value="add">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add New
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action"
                                               value="transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="client_menu" data-item="action"
                                               value="all-transaction">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Transaction
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Client Commitment Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="commitment_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Client Commitment</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="commitment_menu" data-item="action" value="add">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add New
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="commitment_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Ledger Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="ledger_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Ledger</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="ledger_menu" data-item="action"
                                               value="company-ledger">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Supplier
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="ledger_menu" data-item="action"
                                               value="client-ledger">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Client
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Damage Raw Pack Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="rawdamage_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Damage Raw Materials</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="rawdamage_menu" data-item="action"
                                               value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add New
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="rawdamage_menu" data-item="action"
                                               value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All
                                    </label>
                                </div>
                            </td>
                        </tr>


                        <!-- Income Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="income_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Income</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="income_menu" data-item="action" value="field">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Field Of Income
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="income_menu" data-item="action" value="new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        New Income
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="income_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Income
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Expenditure Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="cost_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Expenditure</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cost_menu" data-item="action" value="new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        New Expenditure
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cost_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Expenditure
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cost_menu" data-item="action" value="category">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Expenditure Category
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cost_menu" data-item="action" value="field">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Expenditure Field
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Transport Management here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="transport_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Transport Management</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="transport_menu" data-item="action"
                                               value="createTransport">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Transport
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="transport_menu" data-item="action"
                                               value="allTransport">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Transport
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Due List Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="due_list_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Due List</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="due_list_menu" data-item="action"
                                               value="cash">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Cash Client
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="due_list_menu" data-item="action"
                                               value="collection-list">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Cash Collection List
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="due_list_menu" data-item="action"
                                               value="credit">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Dealer Client
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="due_list_menu" data-item="action"
                                               value="supplier">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Supplier
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Loan Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="loan-menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Loan</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="loan-menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Received & Paid
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="loan-menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All Loan
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="loan-menu" data-item="action" value="trans">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="loan-menu" data-item="action" value="alltrans">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        View All Transaction
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Loan Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="cc_loan_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>CC Loan</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cc_loan_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        CC Loan Account
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cc_loan_menu" data-item="action" value="all-loan">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All CC Loan
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cc_loan_menu" data-item="action" value="loan_trx">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        CC Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cc_loan_menu" data-item="action" value="all_cc_trx">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All CC Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="cc_loan_menu" data-item="action" value="all-trnx">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        CC Ledger
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Banking Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="bank_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Banking</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="bank_menu" data-item="action" value="add-bank">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Bank
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="bank_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Account
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="bank_menu" data-item="action" value="all-acc">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Account
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="bank_menu" data-item="action" value="add">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Add Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="bank_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Transaction
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="bank_menu" data-item="action" value="ledger">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Bank Ledger
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Report Start here -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="report_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Report</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="cash_book">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Cash Book
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="product_wise_sale">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Product Wise Sale
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="purchase_report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Purchase Report
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="sales_report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Sales Report
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="client_wise_report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Client Wise Report
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="cost_report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Expenditure Report
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="profit_loss">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Profit / Loss
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="balance_sheet">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Balance Sheet
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="pl_report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        PL Report
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="report_menu" data-item="action" value="new_balance_report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        New Balance Sheet
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Employee Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="employee_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Employee</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="employee_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        New Employee
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="employee_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Employee
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="employee_menu" data-item="action" value="activeAll">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Active Employee
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="employee_menu" data-item="action" value="designation">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Designation
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Salary Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="salary_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Salary</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="salary_menu" data-item="action" value="advanced">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Advanced
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="salary_menu" data-item="action" value="payment">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Monthly Payment
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="salary_menu" data-item="action" value="all_payment">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Monthly Payment
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="salary_menu" data-item="action" value="dueSalary">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Due Salary
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Fixed Assets Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="fixed_assate_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Fixed Assets</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="fixed_assate_menu" data-item="action" value="field">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Field Of Fixed Assets
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="fixed_assate_menu" data-item="action" value="new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        New Fixed Assets
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="fixed_assate_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Fixed Assets
                                    </label>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- Depreciation Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="depriciation_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Depreciation</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="depriciation_menu" data-item="action" value="add-new">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        New Depreciation
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="depriciation_menu" data-item="action" value="all">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        All Depreciation
                                    </label>
                                </div>
                            </td>
                        </tr>


                        <!-- Mobile SMS Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="sms_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Mobile SMS</span>
                                    </label>
                                </div>
                            </th>
                            <td>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sms_menu" data-item="action" value="send-sms">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Send SMS
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sms_menu" data-item="action" value="custom-sms">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        Custom SMS
                                    </label>
                                </div>
                                <div class="deshitem checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-menu="sms_menu" data-item="action" value="sms-report">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        SMS Report
                                    </label>
                                </div>
                            </td>
                        </tr>


                        <!-- access info -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="access_info">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Access Info</span>
                                    </label>
                                </div>
                            </th>
                            <td></td>
                        </tr>
                        
                        <!-- Settings Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="theme_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Settings</span>
                                    </label>
                                </div>
                            </th>
                            <td></td>
                        </tr>


                        <!-- Data Backup Start -->
                        <tr>
                            <th>
                                <div class="checkbox checkbox-inline view">
                                    <label>
                                        <input type="checkbox" data-item="menu" value="backup_menu">
                                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                        <span>Data Backup</span>
                                    </label>
                                </div>
                            </th>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer">&nbsp;</div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // get all users
        $('select#privilege').on("change", function () {
            var data = [];
            var obj = {'privilege': $(this).val()};

            $.ajax({
                type: "POST",
                url: "<?php echo site_url("ajax/retrieveBy/users"); ?>",
                data: "condition=" + JSON.stringify(obj)
            }).done(function (response) {
                var items = $.parseJSON(response);
                data.push('<option value="">Select User</option>');
                $.each(items, function (i, el) {
                    data.push('<option value="' + el.id + '">' + el.username + '</option>');
                });

                $('select#user_id').html(data);

            });
        });

        $("#check_view").on('change', function (event) {
            if ($(this).is(":checked")) {
                $('input[type="checkbox"][value="view"]').prop({checked: true});
            } else {
                $('input[type="checkbox"][value="view"]').prop({checked: false});
            }
        });


        $("#check_edit").on('change', function (event) {
            if ($(this).is(":checked")) {
                $('input[type="checkbox"][value="edit"]').prop({checked: true});
            } else {
                $('input[type="checkbox"][value="edit"]').prop({checked: false});
            }
        });

        $("#check_delete").on('change', function (event) {
            if ($(this).is(":checked")) {
                $('input[type="checkbox"][value="delete"]').prop({checked: true});
            } else {
                $('input[type="checkbox"][value="delete"]').prop({checked: false});
            }
        });
        //Getting All Menu Name It's Just for use the data
        var input = $('input[type="checkbox"][data-item="menu"]');
        var list = [];
        $.each(input, function (index, el) {
            list.push($(el).val());
        });
        // console.log(list);

        //Set Privilege Data Start
        $('input[type="checkbox"]').on('change', function (event) {
            if ($('select[name="privilege"]').val() != "" && $('select[name="user_id"]').val() != "") {
                $("#progress").fadeIn(300);
                //Collecting all data start here
                var access_item = {};

                var input = $('input[type="checkbox"]');

                $.each(input, function (index, el) {
                    if ($(el).is(":checked")) {
                        //access_item.push($(el).val());
                        if ($(el).data("item") == "menu") {
                            //action data collection Start here
                            var ac_el = $('input[data-menu="' + $(el).val() + '"]');
                            var action_data = [];
                            $.each(ac_el, function (ac_i, ac_el) {
                                if ($(ac_el).is(":checked")) {
                                    action_data.push($(ac_el).val());
                                }
                            });
                            //action data collection End here
                            access_item[$(el).val()] = action_data;
                        }
                    }
                });
                //console.log(access_item);

                var access = JSON.stringify(access_item);
                //console.log(access);
                var privilege_name = $('select[name="privilege"]').val();
                var user_id = $('select[name="user_id"]').val();
                //Collecting All data end here


                //Sending Request Start here
                $.ajax({
                    url: '<?php echo site_url("privilege/privilege/set_privilege_ajax"); ?>',
                    type: 'POST',
                    data: {
                        privilege_name: privilege_name,
                        user_id: user_id,
                        access: access
                    }
                })
                    .done(function (response) {
                        //console.log(response);
                        $("#progress").fadeOut(300);
                    });
                //Sending Request End here
            } else {
                alert("Please select a Privilege and User Name.");
                return false
            }
        });
        //Set Privilege Data End

        //Get Privilege Data Start
        $('select[name="user_id"]').on('change', function (event) {
            $('input[type="checkbox"]').prop({checked: false});
            //Sending Request Start here
            var user_id = $(this).val();
            var privilege_name = $('#privilege').val();
            $.ajax({
                url: '<?php echo site_url("privilege/privilege/get_privilege_ajax"); ?>',
                type: 'POST',
                data: {user_id: user_id, privilege_name: privilege_name}
            }).done(function (response) {
                if (response != "error") {
                    var data = $.parseJSON(response);
                    access = $.parseJSON(data.access);

                    //console.log(access);
                    $.each(access, function (access_index, access_val) {
                        //console.log(access_index);
                        //data-item="menu" value="theme_ettings"
                        $('input[data-item="menu"][value="' + access_index + '"]').prop({checked: true});
                        $.each(access_val, function (action_in, action_val) {
                            $('input[data-item="action"][data-menu="' + access_index + '"][value="' + action_val + '"]').prop({checked: true});
                        });
                        //$('input[name="'+el.module_name+'"][value="'+access_val+'"]').prop({checked: true});
                    });
                }
            });
            //Sending Request End here
        });
        //Get Privilege Data End
    });
</script>
