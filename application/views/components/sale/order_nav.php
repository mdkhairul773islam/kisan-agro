<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("order_menu","add-order")){ ?>
		<a href="<?php echo site_url('sale/order'); ?>" class="btn btn-default" id="add-order">
			New Order
		</a>
		<?php } ?>
		
		<?php if(ck_action("order_menu","all-order")){ ?>
		<a href="<?php echo site_url('sale/order/all'); ?>" class="btn btn-default" id="all-client-order">
			All Order
		</a>
		<?php } ?>

		<?php if(ck_action("order_menu","production")){ ?>
		<a href="<?php echo site_url('sale/order/production'); ?>" class="btn btn-default" id="production">
			Production List
		</a>
		<?php } ?>
		
		<?php if(ck_action("order_menu","all-delivery-order")){ ?>
		<a href="<?php echo site_url('sale/order/all_delivery_order'); ?>" class="btn btn-default" id="all-delivery-order">
			All Client Delivery
		</a>
		<?php } ?>
		
		<?php if(ck_action("order_menu","wise")){ ?>
		<a href="<?php echo site_url('sale/order/item_wise'); ?>" class="btn btn-default" id="wise">
			Item Wise Search
		</a>
		<?php } ?>

		<?php if(ck_action("order_menu","order_product_rank")){ ?>
		<a href="<?php echo site_url('sale/order_product_rank'); ?>" class="btn btn-default" id="order_product_rank">
			Product Rank
		</a>
		<?php } ?>
    </div>
</div>
