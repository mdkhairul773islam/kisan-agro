<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
		
		<?php if(ck_action("product_menu","add-new")){ ?>
    		<a href="<?php echo site_url('product/product'); ?>" class="btn btn-default" id="add-new">
    			Add Finish Product
    		</a>
    	<?php } ?>	
        
        <?php if(ck_action("product_menu","all")){ ?>
    		<a href="<?php echo site_url('product/product/all_product'); ?>" class="btn btn-default" id="all">
    			All Finish Product
    		</a>
    	<?php } ?>
    	
    	<?php /*if(ck_action("product_menu","deactive")){ ?>
    		<a href="<?php echo site_url('product/product/deactive_product'); ?>" class="btn btn-default" id="deactive">
                Unavailable All
    		</a>
    	<?php }*/ ?>	
    	
    	<a href="<?php echo site_url('product/category'); ?>" class="btn btn-default" id="category">
    		Category
    	</a>
    </div>
</div>