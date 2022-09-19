<style>
    ul li a span.icon {
        margin-right: 10px;
        float: right;
    }
    .aside-head {
        position: fixed;
        z-index: 2;
        width: 150px;
    }
    .sidebar-brand {
        transition: all 0.4s ease-in-out;
        position: absolute;
        width: 250px;
        z-index: 2;
    }
    .sidebar-brand.sidebar-slide {
        transition: all 0.4s ease-in-out;
        transform: translateX(-100%);
    }
    .aside-nav {
        margin-top: 65px;
        z-index: -3;
    }
    @media screen and (max-width: 768px) {
        .sidebar-brand {
            transition: all 0.4s ease-in-out;
            transform: translateX(-100%);
        }
        .sidebar-brand.sidebar-slide {
            transition: all 0.4s ease-in-out;
            transform: translateX(0%);
        }
    }
</style>


<!-- Sidebar -->
<aside id="sidebar-wrapper">
    <div class="sidebar-nav">
        <h3 class="sidebar-brand <?php if ($this->data['width'] == 'full-width') { echo 'sidebar-slide';} ?>">
            <a style="font-size: 23px !important;" href="<?php echo site_url('super/dashboard'); ?>">
                Admin <span>Panel</span>
            </a>
        </h3>
    </div>

    <nav class="aside-nav">
        <ul class="sidebar-nav">
            <li id="dashboard">
                <a href="<?php echo site_url('super/dashboard'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Dashboard
                </a>
            </li>
            
            <li id="godown_menu">
                <a href="#godown" data-toggle="collapse">
                    <i class="fa fa-archive" aria-hidden="true"></i> Showroom
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="godown" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('godown/godown'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('godown/godown/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="purchase_menu">
                <a href="#purchase" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Raw Materials
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase" class="sidebar-nav collapse">
                    
                    <li>
                        <a href="<?php echo site_url('purchase/requisition/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Requisition
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/requisition'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Requisition
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('purchase/purchaseOrder/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Order
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchaseOrder'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase Order
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('purchase/stockEntry/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Stock Entry
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/stockEntry'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Stock Entry
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/show_Purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/item_wise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise Search
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Return
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Return
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('purchase/stock'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Stock
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('purchase/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Ledger
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('purchase/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Product
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="product_menu">
                <a href="#product" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="product" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('product/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Finish Product
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('product/product/all_product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Finish Product
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('product/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Category
                        </a>
                    </li>
                </ul>
            </li>

            <li id="production_menu">
                <a href="#production" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Production
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="production" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('production/production/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Production
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('production/production'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Production
                        </a>
                    </li>
                </ul>
            </li>

            <li id="sale_menu">
                <a href="#sales" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sales" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('sale/do_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            DO Sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/do_sale/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All DO Sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New Sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/sale/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All Sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/challan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Challan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sale/sale/item_wise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise Report
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="product_stock_menu">
                <a href="<?php echo site_url('stock/stock/finish_product_stock'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Finish Goods Stock
                </a>
            </li>
            
            <li id="zone_menu">
                <a href="#zone" data-toggle="collapse">
                    <i class="fa fa-area-chart"></i> Zone
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="zone" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('zone/zone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('zone/zone/allzone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="sr_menu">
                <a href="#sr" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Sr
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sr" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('sr/sr'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sr/sr/allsr'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sr/sr/add_comission'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Comission
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sr/sr/all_comission'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Comission
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="supplier-menu">
                <a href="#company" data-toggle="collapse">
                    <i class="fa fa-building-o"></i> Supplier
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="company" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('supplier/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('supplier/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="client_menu">
                <a href="#client" data-toggle="collapse">
                    <i class="fa fa-users"></i> Client
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="client" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('client/client'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/client/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="commitment_menu">
                <a href="#commitment" data-toggle="collapse">
                    <i class="fa fa-users"></i> Client Commitment
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="commitment" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('client/commitment');?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('client/commitment/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="ledger-menu">
                <a href="#ledger" data-toggle="collapse">
                    <i class="fa fa-money"></i> Ledger
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="ledger" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('ledger/companyLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="rawdamage_menu">
                <a href="#rawdamage" data-toggle="collapse">
                    <i class="fa fa-trash" aria-hidden="true"></i> Damage Raw Materials
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="rawdamage" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('raw_damage/damage'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('raw_damage/damage/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="income_menu">
                <a href="#income" data-toggle="collapse">
                    <i class="fa fa-money"></i> Income
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="income" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('income/income'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Income
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('income/income/newIncome'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Income
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('income/income/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Income
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="cost_menu">
                <a href="#cost" data-toggle="collapse">
                    <i class="fa fa-money"></i> Expenditure
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cost" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('cost/cost/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Expenditure
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cost/cost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Expenditure
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('cost/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Category
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('cost/field'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Field
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="transport_menu">
                <a href="#transport" data-toggle="collapse">
                    <i class="fa fa-car"></i> Transport Management
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="transport" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('transport/transport/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transport
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('transport/transport'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transport
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="due_list_menu">
                <a href="#due_list" data-toggle="collapse">
                    <i class="fa fa-male"></i> Due List
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="due_list" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('due_list/due_list?type=cash'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Client
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/collection_list'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Collection List
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list?type=credit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Dealer Client
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list?type=supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="loan-menu">
                <a href="#loan" data-toggle="collapse">
                    <i class="fa fa-money" aria-hidden="true"></i> Loan
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="loan" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('loan/loan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Received & Paid
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('loan/loan/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All Loan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('loan/loan/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('loan/loan/alltransaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All Transaction
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="cc_loan_menu">
                <a href="#cc_loan" data-toggle="collapse">
                    <i class="fa fa-money" aria-hidden="true"></i> CC Loan
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cc_loan" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            CC Loan Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/allloan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All CC Loan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/loan_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            CC Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/all_cc_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All CC Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/alltransaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            CC Ledger
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="bank_menu">
                <a href="#bank" data-toggle="collapse">
                    <i class="fa fa-university"></i>Banking
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="bank" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Bank
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Account
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/allTransaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bank Ledger
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="report_menu">
                <a href="#report" data-toggle="collapse">
                    <i class="fa fa-money"></i> Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="report" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('report/cash_book'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Book
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/product_wise_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Product Wise Sale
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/purchase_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/sales_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger?type=client_wise_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client Wise Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/cost_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/report/profit_loss_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Profit / Loss
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/balance_sheet'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Balance Sheet
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/pl_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            P/L Report
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/new_balance_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Balance Sheet
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/daily_delivery'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Daily Delivery
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/daily_production'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Daily Production
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('report/daily_delivery_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Daily Delivery Report
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="employee_menu">
                <a href="#employee" data-toggle="collapse">
                    <i class="fa fa-users"></i> Employee
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id='employee' class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('employee/employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Employee
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('employee/employee/show_employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Employee
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('employee/employee/active_employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Active Employee
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('employee/designation'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Designation
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo site_url('employee/department'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Department
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="salary_menu">
                <a href="#salary" data-toggle="collapse">
                    <i class="fa fa-money"></i> Salary
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="salary" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('salary/salary/advanced'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Advanced
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Monthly Payment
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/payment/all_payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Monthly Payment
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('salary/salary/due_salary'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Due Salary
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="fixed_assate_menu">
                <a href="#fixed_assate" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Fixed Assets
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="fixed_assate" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Fixed Assets
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Fixed Assets
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Fixed Assets
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="depriciation_menu">
                <a href="#depriciation" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Depreciation
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="depriciation" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('depriciation/depriciation'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Depreciation
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('depriciation/depriciation/allDepriciation'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Depreciation
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="sms_menu">
                <a href="#sms" data-toggle="collapse">
                    <i class="fa fa-envelope-o"></i> Mobile SMS
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sms" class="sidebar-nav collapse">
                    <li>
                        <a href="<?php echo site_url('sms/sendSms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Send SMS
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/send_custom_sms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Custom SMS
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/sms_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            SMS Report
                        </a>
                    </li>
                </ul>
            </li>
            
            <li id="privilege-menu">
                <a href="<?php echo site_url('privilege/privilege'); ?>">
                    <i class="fa fa-book"></i> Privilege
                </a>
            </li>
            
            <li id="access_info">
                <a href="<?php echo site_url('access/info'); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Access Info
                </a>
            </li>
            
            <li id="theme_menu">
                <a href="<?php echo site_url('theme/general_settings'); ?>">
                    <i class="fa fa-cog"></i> Settings
                </a>
            </li>
            
            <li id="backup_menu">
                <a href="<?php echo site_url('data_backup'); ?>">
                    <i class="fa fa-database"></i> Data Backup
                </a>
            </li>
            
            <li>&nbsp;</li>
            <li>&nbsp;</li>

        </ul>
    </nav>
</aside>
<!-- sidebar-wrapper -->

<style>
    .warning {
        background: rgba(255, 255, 255, 0.85);
        justify-content: center;
        align-items: center;
        position: fixed;
        height: 100vh;
        display: flex;
        width: 100%;
        z-index: 99999;
        top: 0;
        left: 0;
        color: red;
        display: none;
        user-select: none;
        font-family: serif;
    }
</style>

<div class="warning">
    <div>
        <h1>YOU'R OFFLINE</h1>
    </div>
</div>
<script>
    if (typeof navigator.connection !== 'undefined') {
        navigator.connection.onchange = function () {
            var warning = document.querySelector('.warning');
            if (navigator.onLine) {
                warning.style.display = 'none';
            } else {
                warning.style.display = 'flex';
            }
        }
    }
</script>