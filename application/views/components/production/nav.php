
<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        
		<?php if(ck_action("production_menu","createProduction")){ ?>
    		<a href="<?php echo site_url('production/production/create'); ?>" class="btn btn-default" id="createProduction">
    			Add New
    		</a>
        <?php } ?>
        
		<?php if(ck_action("production_menu","allProduction")){ ?>
    		<a href="<?php echo site_url('production/production'); ?>" class="btn btn-default" id="allProduction">
    			View All
    		</a>
		<?php } ?>
    </div>
</div>