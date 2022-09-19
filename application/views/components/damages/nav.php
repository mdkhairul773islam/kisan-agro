<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
		 <?php if(ck_action("damages_menu","add-new")){ ?>
    		<a href="<?php echo site_url('damages/damages'); ?>" class="btn btn-default" id="add-new">
    			Add New
    		</a>
		<?php } ?>
		
         <?php if(ck_action("damages_menu","all")){ ?>
    		<a href="<?php echo site_url('damages/damages/view_all'); ?>" class="btn btn-default" id="all">
    			View All
    		</a>
		<?php } ?>

    </div>
</div>