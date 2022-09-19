<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        
        <a href="<?php echo site_url('sale/do_sale'); ?>" class="btn btn-default" id="do">
    		New DO Sale
    	</a>

        <a href="<?php echo site_url('sale/do_sale/all'); ?>" class="btn btn-default" id="all-do-sale">
    		All DO Sale
    	</a>
    		
        <?php if(ck_action("sale_menu","add-new")){ ?>		
    		<a href="<?php echo site_url('sale/sale'); ?>" class="btn btn-default" id="add-new">
    			Add Sale
    		</a>
        <?php } ?>
        
		<?php if(ck_action("sale_menu","all")){ ?>
    		<a href="<?php echo site_url('sale/sale/all'); ?>" class="btn btn-default" id="all">
    			All Sale
    		</a>
         <?php } ?>

        <?php if(ck_action("sale_menu","allChallan")){ ?>
            <a href="<?php echo site_url('sale/challan'); ?>" class="btn btn-default" id="allChallan">
                All Challan
            </a>
        <?php } ?>
         
		<?php if(ck_action("sale_menu","itemWise")){ ?>
    		<a href="<?php echo site_url('sale/sale/item_wise'); ?>" class="btn btn-default" id="itemWise">
                Item Wise Report
    		</a>
		 <?php } ?>
		 
		<?php /*if(ck_action("sale_menu","multi-return")){ ?>
    		<a href="<?php echo site_url('sale/multiSaleReturn'); ?>" class="btn btn-default" id="multi-return">
    			Return
    		</a>
		 <?php } ?>
		 
		<?php if(ck_action("sale_menu","multi-return-all")){ ?>
    		<a href="<?php echo site_url('sale/multiSaleReturn/all'); ?>" class="btn btn-default" id="multi-return-all">
    			All Return
    		</a>
        <?php }*/ ?>

        <?php /*if(ck_action("sale_menu","product_rank")){ */?><!--
            <a href="<?php /*echo site_url('sale/product_rank'); */?>" class="btn btn-default" id="product_rank">
                Product Report
            </a>
        --><?php /*}*/ ?>
    </div>
</div>
