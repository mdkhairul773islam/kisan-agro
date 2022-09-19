<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("factory_menu","add-order")){ ?>
		<a href="<?php echo site_url('sale/factory_order'); ?>" class="btn btn-default" id="order-process">
			New Order
		</a>
		<?php } ?>
		
		<?php if(ck_action("factory_menu","all-order")){ ?>
		<a href="<?php echo site_url('sale/factory_order/all'); ?>" class="btn btn-default" id="all-factory-order">
			All Order
		</a>
		<?php } ?>

		<?php if(ck_action("factory_menu","production")){ ?>
		<a href="<?php echo site_url('sale/factory_order/production'); ?>" class="btn btn-default" id="production">
			Production List
		</a>
		<?php } ?>
		
		<?php if(ck_action("factory_menu","all-stock-order")){ ?>
		<a href="<?php echo site_url('sale/factory_order/all_stock_order'); ?>" class="btn btn-default" id="all-stock-order">
			All Stock Delivery
		</a>
		<?php } ?>
		
		<?php if(ck_action("factory_menu","wise")){ ?>
		<a href="<?php echo site_url('sale/factory_order/item_wise'); ?>" class="btn btn-default" id="wise">
			Item Wise Search
		</a>
		<?php } ?>

		<?php if(ck_action("factory_menu","order_product_rank")){ ?>
		<a href="<?php echo site_url('sale/factory_order/product_rank'); ?>" class="btn btn-default" id="order_product_rank">
			Product Rank
		</a>
		<?php } ?>
    </div>
</div>
