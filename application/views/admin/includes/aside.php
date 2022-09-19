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


<!-- Sidebar Wrapper -->
<aside id="sidebar-wrapper">
    <div class="sidebar-nav">
        <h3 class="sidebar-brand <?php if ($this->data['width'] == 'full-width') {echo 'sidebar-slide';} ?>">
            <a style="font-size: 23px !important;" href="<?php echo site_url('admin/dashboard'); ?>">
                Admin <span>Panel</span>
            </a>
        </h3>
    </div>
    <nav class="aside-nav">
        <ul class="sidebar-nav">
            <?php if (ck_menu("dashboard")) { ?>
            <li id="dashboard">
                <a href="<?php echo site_url('admin/dashboard'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Dashboard
                </a>
            </li>
            <?php } ?>

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
            
            <?php if (ck_menu("purchase_menu")) { ?>
            <li id="purchase_menu">
                <a href="#purchase" data-toggle="collapse">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Raw Materials
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="purchase" class="sidebar-nav collapse">
                    
                    <?php if (ck_action("purchase_menu", "requisition")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/requisition/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Requisition
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "allRequisition")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/requisition'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Requisition
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "purchaseOrder")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchaseOrder/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Order
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "allPurchaseOrder")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchaseOrder'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase Order
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "stockEntry")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/stockEntry/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Stock Entry
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "allStockEntry")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/stockEntry'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Stock Entry
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/show_Purchase'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Purchase
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "wise")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase/itemWise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise Search
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "return")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Return
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "all_return")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/purchase_return/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Return
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "stock")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/stock'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Stock
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Ledger
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("purchase_menu", "product")) { ?>
                    <li>
                        <a href="<?php echo site_url('purchase/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Product
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("product_menu")) { ?>
            <li id="product_menu">
                <a href="#product_" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Product
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="product_" class="sidebar-nav collapse">
                    <?php if (ck_action("product_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('product/product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Finish Product
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("product_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('product/product/all_product'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Finish Product
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("product_menu", "category")) { ?>
                    <li>
                        <a href="<?php echo site_url('product/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Category
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("production_menu")) { ?>
            <li id="production_menu">
                <a href="#production" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Production
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="production" class="sidebar-nav collapse">
                    <?php if (ck_action("production_menu", "createProduction")) { ?>
                    <li>
                        <a href="<?php echo site_url('production/production/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Production
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("production_menu", "allProduction")) { ?>
                    <li>
                        <a href="<?php echo site_url('production/production'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Production
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("sale_menu")) { ?>
            <li id="sale_menu">
                <a href="#sale" data-toggle="collapse">
                    <i class="fa fa-shopping-cart"></i> Sale
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sale" class="sidebar-nav collapse">
                    <?php if (ck_action("sale_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New Sale
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/sale/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All Sale
                        </a>
                    </li>
                    <?php } ?>
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
                    
                    <?php if (ck_action("sale_menu", "allChallan")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/challan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Challan
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sale_menu", "itemWise")) { ?>
                    <li>
                        <a href="<?php echo site_url('sale/sale/item_wise'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Item Wise Report
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("product_stock_menu")) { ?>
            <li id="product_stock_menu">
                <a href="<?php echo site_url('stock/stock/finish_product_stock'); ?>">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Finish Goods Stock
                </a>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("zone_menu")) { ?>
            <li id="zone_menu">
                <a href="#zone" data-toggle="collapse">
                    <i class="fa fa-area-chart"></i> Zone
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="zone" class="sidebar-nav collapse">
                    <?php if (ck_action("zone_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('zone/zone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("zone_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('zone/zone/allzone'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("sr_menu")) { ?>
            <li id="sr_menu">
                <a href="#sr" data-toggle="collapse">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i> Sr
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sr" class="sidebar-nav collapse">
                    <?php if (ck_action("sr_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('sr/sr'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sr_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('sr/sr/allsr'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sr_menu", "add_comission")) { ?>
                    <li>
                        <a href="<?php echo site_url('sr/sr/add_comission'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Comission
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("sr_menu", "all_comission")) { ?>
                    <li>
                        <a href="<?php echo site_url('sr/sr/all_comission'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Comission
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("supplier-menu")) { ?>
            <li id="supplier-menu">
                <a href="#company" data-toggle="collapse">
                    <i class="fa fa-building-o"></i> Supplier
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="company" class="sidebar-nav collapse">
                    <?php if (ck_action("supplier-menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Supplier
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("supplier-menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/supplier/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Supplier
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("supplier-menu", "transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("supplier-menu", "all-transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('supplier/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("client_menu")) { ?>
            <li id="client_menu">
                <a href="#client" data-toggle="collapse">
                    <i class="fa fa-users"></i> Client
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="client" class="sidebar-nav collapse">
                    <?php if (ck_action("client_menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/client'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("client_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/client/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("client_menu", "transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/transaction/'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("client_menu", "all-transaction")) { ?>
                    <li>
                        <a href="<?php echo site_url('client/all_transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("commitment_menu")){ ?>
            <li id="commitment_menu">
                <a href="#commitment" data-toggle="collapse">
                    <i class="fa fa-users"></i> Client Commitment
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="commitment" class="sidebar-nav collapse">
                    <?php if(ck_action("commitment_menu","add")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/commitment');?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("commitment_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('client/commitment/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("ledger_menu")) { ?>
            <li id="ledger_menu">
                <a href="#ledger" data-toggle="collapse">
                    <i class="fa fa-book"></i> Ledger
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="ledger" class="sidebar-nav collapse">
                    <?php if (ck_action("ledger_menu", "company-ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('ledger/companyLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("ledger_menu", "client-ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("rawdamage_menu")) { ?>
            <li id="rawdamage_menu">
                <a href="#rawdamage" data-toggle="collapse">
                    <i class="fa fa-trash" aria-hidden="true"></i> Damage Raw Materials
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="rawdamage" class="sidebar-nav collapse">
                    <?php if (ck_action("rawdamage_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('raw_damage/damage'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add New
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("rawdamage_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('raw_damage/damage/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("income_menu")) { ?>        
            <li id="income_menu">
                <a href="#income" data-toggle="collapse">
                    <i class="fa fa-money"></i> Income
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="income" class="sidebar-nav collapse">
                    <?php if (ck_action("income_menu", "field")) { ?>
                    <li>
                        <a href="<?php echo site_url('income/income'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Income
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("income_menu", "new")) { ?>
                    <li>
                        <a href="<?php echo site_url('income/income/newIncome'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Income
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("income_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('income/income/all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Income
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("cost_menu")) { ?>
            <li id="cost_menu">
                <a href="#cost" data-toggle="collapse">
                    <i class="fa fa-money"></i> Expenditure
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cost" class="sidebar-nav collapse">
                    <?php if (ck_action("cost_menu", "createCost")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost/create'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Expenditure
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("cost_menu", "allCost")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/cost'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Expenditure
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("cost_menu", "category")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/category'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Category
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("cost_menu", "field")) { ?>
                    <li>
                        <a href="<?php echo site_url('cost/field'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Field
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("transport_menu")) { ?>
                <li id="transport_menu">
                    <a href="#transport" data-toggle="collapse">
                        <i class="fa fa-car"></i> Transport Management
                        <span class="icon"><i class="fa fa-sort-desc"></i></span>
                    </a>
                    <ul id="transport" class="sidebar-nav collapse">
                        <?php if (ck_action("transport_menu", "createTransport")) { ?>
                        <li>
                            <a href="<?php echo site_url('transport/transport/create'); ?>">
                                <i class="fa fa-angle-right"></i>
                                Add Transport
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php if (ck_action("transport_menu", "allTransport")) { ?>
                        <li>
                            <a href="<?php echo site_url('transport/transport'); ?>">
                                <i class="fa fa-angle-right"></i>
                                All Transport
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            
            
            <?php if (ck_menu("due_list_menu")) { ?>
            <li id="due_list_menu">
                <a href="#due_list" data-toggle="collapse">
                    <i class="fa fa-male"></i> Due List
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="due_list" class="sidebar-nav collapse">
                    <?php if (ck_action("due_list_menu", "cash")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list?type=cash'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Client
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("due_list_menu", "collection-list")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list/collection_list'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Collection List
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("due_list_menu", "credit")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list?type=credit'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Dealer Client
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("due_list_menu", "supplier")) { ?>
                    <li>
                        <a href="<?php echo site_url('due_list/due_list?type=supplier'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Supplier
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("loan-menu")) { ?>
            <li id="loan-menu">
                <a href="#loan" data-toggle="collapse">
                    <i class="fa fa-money" aria-hidden="true"></i> Loan
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="loan" class="sidebar-nav collapse">
                    <?php if (ck_action("loan-menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan/loan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Received & Paid
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("loan-menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan/loan/view_all'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All Loan
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("loan-menu", "trans")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan/loan/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("loan-menu", "alltrans")) { ?>
                    <li>
                        <a href="<?php echo site_url('loan/loan/alltransaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            View All Transaction
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("cc_loan_menu")) { ?>
            <li id="cc_loan_menu">
                <a href="#cc_loan" data-toggle="collapse">
                    <i class="fa fa-money" aria-hidden="true"></i> CC Loan
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="cc_loan" class="sidebar-nav collapse">
                    <?php if (ck_action("cc_loan_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            CC Loan Account
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("cc_loan_menu", "all-loan")) { ?>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/allloan'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All CC Loan
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("cc_loan_menu", "loan_trx")) { ?>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/loan_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            CC Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("cc_loan_menu", "all_cc_trx")) { ?>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/all_cc_trx'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All CC Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("bank_menu", "all-trnx")) { ?>
                    <li>
                        <a href="<?php echo site_url('cc_loan/cc_loan/alltransaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            CC Ledger
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("bank_menu")) { ?>
            <li id="bank_menu">
                <a href="#bank" data-toggle="collapse">
                    <i class="fa fa-university"></i> Banking
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="bank" class="sidebar-nav collapse">
                    <?php if (ck_action("bank_menu", "add-bank")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Bank
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("bank_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Account
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("bank_menu", "all-acc")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/all_account'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Account
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("bank_menu", "add")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/transaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Add Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("bank_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/allTransaction'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Transaction
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("bank_menu", "ledger")) { ?>
                    <li>
                        <a href="<?php echo site_url('bank/bankInfo/ledger'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Bank Ledger
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("report_menu")) { ?>
            <li id="report_menu">
                <a href="#report" data-toggle="collapse">
                    <i class="fa fa-book"></i> Report
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="report" class="sidebar-nav collapse">
                    <?php if (ck_action("report_menu", "cash_book")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/cash_book'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Cash Book
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "product_wise_sale")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/product_wise_sale'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Product Wise Sale
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "purchase_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/purchase_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Purchase Report
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("report_menu", "sales_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/sales_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Sales Report
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("report_menu", "client_wise_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('ledger/clientLedger?type=client_wise_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Client Wise Report
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("report_menu", "cost_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/cost_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Expenditure Report
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "profit_loss")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/report/profit_loss_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Profit / Loss
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("report_menu", "balance_sheet")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/balance_sheet'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Balance Sheet
                        </a>
                    </li>
                    <?php } ?>
                    <?php if (ck_action("report_menu", "pl_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/pl_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            P/L Report
                        </a>
                    </li>
                    <?php } ?>
                    <?php if (ck_action("report_menu", "new_balance_report")) { ?>
                    <li>
                        <a href="<?php echo site_url('report/new_balance_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Balance Sheet
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("employee_menu")) { ?>
            <li id="employee_menu">
                <a href="#employee" data-toggle="collapse">
                    <i class="fa fa-users"></i> Employee
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id='employee' class="sidebar-nav collapse">
                    <?php if (ck_action("employee_menu", "add-new")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Employee
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("employee_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/employee/show_employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Employee
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("employee_menu", "activeAll")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/employee/active_employee'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Active Employee
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("employee_menu", "designation")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/designation'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Designation
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("employee_menu", "department")) { ?>
                    <li>
                        <a href="<?php echo site_url('employee/department'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Department
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("salary_menu")) { ?>
            <li id="salary_menu">
                <a href="#salary" data-toggle="collapse">
                    <i class="fa fa-money"></i> Salary
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="salary" class="sidebar-nav collapse">
                    <?php if (ck_action("salary_menu", "advanced")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/salary/advanced'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Advanced
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("salary_menu", "payment")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Monthly Payment
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("salary_menu", "all_payment")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/payment/all_payment'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Monthly Payment
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if (ck_action("salary_menu", "dueSalary")) { ?>
                    <li>
                        <a href="<?php echo site_url('salary/salary/due_salary'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Due Salary
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("fixed_assate_menu")) { ?>
            <li id="fixed_assate_menu">
                <a href="#fixed_assate" data-toggle="collapse">
                    <i class="fa fa-bar-chart"></i> Fixed Assets
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="fixed_assate" class="sidebar-nav collapse">
                    <?php if (ck_action("fixed_assate_menu", "field")) { ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Field of Fixed Assets
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("fixed_assate_menu", "new")) { ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/newfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Fixed Assets
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("fixed_assate_menu", "all")) { ?>
                    <li>
                        <a href="<?php echo site_url('fixed_assate/fixed_assate/allfixed_assate'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Fixed Assets
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if(ck_menu("depriciation_menu")){ ?>
            <li id="depriciation_menu">
                <a href="#depriciation" data-toggle="collapse">
                    <i class="fa fa-male"></i> Depreciation
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="depriciation" class="sidebar-nav collapse">
                    <?php if(ck_action("depriciation_menu","add-new")){ ?>
                    <li>
                        <a href="<?php echo site_url('depriciation/depriciation'); ?>">
                            <i class="fa fa-angle-right"></i>
                            New Depreciation
                        </a>
                    </li>
                    <?php } ?>
                    
                    <?php if(ck_action("depriciation_menu","all")){ ?>
                    <li>
                        <a href="<?php echo site_url('depriciation/depriciation/allDepriciation'); ?>">
                            <i class="fa fa-angle-right"></i>
                            All Depreciation
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("sms_menu")) { ?>
            <li id="sms_menu">
                <a href="#sms" data-toggle="collapse">
                    <i class="fa fa-envelope-o"></i> Mobile SMS
                    <span class="icon"><i class="fa fa-sort-desc"></i></span>
                </a>
                <ul id="sms" class="sidebar-nav collapse">
                    <?php if (ck_action("sms_menu", "send-sms")) { ?>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Send SMS
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sms_menu", "custom-sms")) { ?>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/send_custom_sms'); ?>">
                            <i class="fa fa-angle-right"></i>
                            Custom SMS
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (ck_action("sms_menu", "sms-report")) { ?>
                    <li>
                        <a href="<?php echo site_url('sms/sendSms/sms_report'); ?>">
                            <i class="fa fa-angle-right"></i>
                            SMS Report
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            
            <?php if (ck_menu("access_info")) { ?>
            <li id="access_info">
                <a href="<?php echo site_url('access/info'); ?>">
                    <i class="fa fa-list" aria-hidden="true"></i> Access Info
                </a>
            </li>
            <?php } ?>
            
            
            <?php if (ck_menu("theme_menu")) { ?>
            <li id="theme_menu">
                <a href="<?php echo site_url('theme/general_settings'); ?>">
                    <i class="fa fa-cog"></i> Settings
                </a>
            </li>
            <?php } ?>


            <?php if (ck_menu("backup_menu")) { ?>
            <li id="backup_menu">
                <a href="<?php echo site_url('data_backup'); ?>">
                    <i class="fa fa-database"></i>
                    Data Backup
                </a>
            </li>
            <?php } ?>
            
            
            
            <li>&nbsp;</li>
            <li>&nbsp;</li>
        </ul>
    </nav>
</aside>
<!-- Sidebar Wrapper -->


<style>
    .warning {
        background: rgba(255, 255, 255, 0.85);
        justify-content: center;
        align-items: center;
        position: fixed;
        z-index: 99999;
        height: 100vh;
        display: flex;
        width: 100%;
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
    if(typeof navigator.connection !== 'undefined'){
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