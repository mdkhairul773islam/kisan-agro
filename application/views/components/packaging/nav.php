<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">

        <?php if (ck_action("packaging_menu", "add-purchase")) { ?>
            <a href="<?php echo site_url('packaging/purchase'); ?>" class="btn btn-default" id="add-purchase">
                Purchase
            </a>
        <?php } ?>

        <?php if (ck_action("packaging_menu", "all-purchase")) { ?>
            <a href="<?php echo site_url('packaging/purchase/show_purchase'); ?>" class="btn btn-default"
               id="all-purchase">
                All Purchase
            </a>
        <?php } ?>

        <?php if (ck_action("packaging_menu", "item-wise")) { ?>
            <a href="<?php echo site_url('packaging/purchase/item_wise'); ?>" class="btn btn-default" id="item-wise"">
               Item Wise Search
            </a>
        <?php } ?>


        <?php if (ck_action("packaging_menu", "stock")) { ?>
            <a href="<?php echo site_url('packaging/stock'); ?>" class="btn btn-default" id="stock"">
                Stock
            </a>
        <?php } ?>

        <?php if (ck_action("packaging_menu", "add-new")) { ?>
            <a href="<?php echo site_url('packaging/used'); ?>" class="btn btn-default" id="add-new">
                Used
            </a>
        <?php } ?>

        <?php if (ck_action("packaging_menu", "show")) { ?>
            <a href="<?php echo site_url('packaging/used/show'); ?>" class="btn btn-default" id="show">
                All Used
            </a>

            <a href="<?php echo site_url('packaging/used/item_wise_used'); ?>" class="btn btn-default" id="item-wise-used">
                Item Wise Used
            </a>
        <?php } ?>

    </div>
</div>
