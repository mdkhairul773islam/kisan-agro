<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("sr_menu","add-new")){ ?>
		<a href="<?php echo site_url('sr/sr'); ?>" class="btn btn-default" id="add-new">
			Add New
		</a>
		<?php } ?>
		
        <?php if(ck_action("sr_menu","all")){ ?>
		<a href="<?php echo site_url('sr/sr/allsr'); ?>" class="btn btn-default" id="all">
			View All
		</a>
		<?php } ?>
		
        <?php if(ck_action("sr_menu","add_comission")){ ?>
		<a href="<?php echo site_url('sr/sr/add_comission'); ?>" class="btn btn-default" id="add_comission">
			Add Comission
		</a>
		<?php } ?>
		
        <?php if(ck_action("sr_menu","all_comission")){ ?>
		<a href="<?php echo site_url('sr/sr/all_comission'); ?>" class="btn btn-default" id="all_comission">
			All Comission
		</a>
		<?php } ?>
    </div>
</div>