<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
		<?php if(ck_action("due_list_menu","cash")){ ?>	
		<a href="<?php echo site_url('due_list/due_list?type=cash'); ?>" class="btn btn-default" id="cash">
			Retail Client
		</a>
		<?php } ?>

		<?php if(ck_action("due_list_menu","collection-list")){ ?>	
		<a href="<?php echo site_url('due_list/due_list/collection_list'); ?>" class="btn btn-default" id="collection-list">
			Retail Collection List
		</a>
		<?php } ?>
		
		<?php if(ck_action("due_list_menu","credit")){ ?>	
		<a href="<?php echo site_url('due_list/due_list?type=credit'); ?>" class="btn btn-default" id="credit">
			Dealer Client 
		</a>
		<?php } ?>

        <?php if(ck_action("due_list_menu","supplier")){ ?>	
		<a href="<?php echo site_url('due_list/due_list?type=supplier'); ?>" class="btn btn-default" id="supplier">
			Supplier 
		</a>
		<?php } ?>
		
    </div>
</div>