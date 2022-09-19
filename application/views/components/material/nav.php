
<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<?php if(ck_action("row_material_menu","add")){ ?>
    		<a href="<?php echo site_url('material/material'); ?>" class="btn btn-default" id="add">
    			Add New
    		</a>
        <?php } ?>
		
		<?php if(ck_action("row_material_menu","all")){ ?>
    		<a href="<?php echo site_url('material/material/view_all'); ?>" class="btn btn-default" id="all">
    			View All
    		</a>
        <?php } ?>		
    </div>
</div>
