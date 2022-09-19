<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        
        <?php if (ck_action("purchase_menu", "requisition")) { ?>
        <a href="<?php echo site_url('purchase/requisition/create'); ?>" class="btn btn-default" id="requisition">
            Requisition
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "allRequisition")) { ?>
        <a href="<?php echo site_url('purchase/requisition'); ?>" class="btn btn-default" id="allRequisition">
            All Requisition
        </a>
        <?php } ?>
        
        
        <?php if (ck_action("purchase_menu", "purchaseOrder")) { ?>
        <a href="<?php echo site_url('purchase/purchaseOrder/create'); ?>" class="btn btn-default" id="purchaseOrder">
            Purchase Order
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "allPurchaseOrder")) { ?>
        <a href="<?php echo site_url('purchase/purchaseOrder'); ?>" class="btn btn-default" id="allPurchaseOrder">
            All Purchase Order
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "stockEntry")) { ?>
        <a href="<?php echo site_url('purchase/stockEntry/create'); ?>" class="btn btn-default" id="stockEntry">
            Stock Entry
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "allStockEntry")) { ?>
        <a href="<?php echo site_url('purchase/stockEntry'); ?>" class="btn btn-default" id="allStockEntry">
            All Stock Entry
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "add-new")) { ?>
        <a href="<?php echo site_url('purchase/purchase'); ?>" class="btn btn-default" id="add-new">
            Purchase
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "all")) { ?>
        <a href="<?php echo site_url('purchase/purchase/show_Purchase'); ?>" class="btn btn-default" id="all">
            All Purchase
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "wise")) { ?>
        <a href="<?php echo site_url('purchase/purchase/item_wise'); ?>" class="btn btn-default" id="wise">
            Item Wise Search
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "return")) { ?>
        <a href="<?php echo site_url('purchase/purchase_return'); ?>" class="btn btn-default" id="return">
            Return
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "all_return")) { ?>
        <a href="<?php echo site_url('purchase/purchase_return/all'); ?>" class="btn btn-default" id="all_return">
            All Return
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "stock")) { ?>
        <a href="<?php echo site_url('purchase/stock'); ?>" class="btn btn-default" id="stock">
            Stock
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "ledger")) { ?>
        <a href="<?php echo site_url('purchase/ledger'); ?>" class="btn btn-default" id="ledger">
            Ledger
        </a>
        <?php } ?>
        
        <?php if (ck_action("purchase_menu", "product")) { ?>
        <a href="<?php echo site_url('purchase/product'); ?>" class="btn btn-default" id="product">
            Product
        </a>
        <?php } ?>
    </div>
</div>
