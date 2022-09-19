<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<?php if(ck_action("cost_menu", "createCost")){ ?>
		<a href="<?php echo site_url('cost/cost/create'); ?>" class="btn btn-default" id="createCost">
			New Expenditure
		</a>
		<?php } ?>
		
        <?php if(ck_action("cost_menu","allCost")){ ?>
		<a href="<?php echo site_url('cost/cost'); ?>" class="btn btn-default" id="allCost">
			All Expenditure
		</a>
		<?php } ?>
		
		<?php if(ck_action("cost_menu", "category")){ ?>
		<a href="<?php echo site_url('cost/category'); ?>" class="btn btn-default" id="category">
			Expenditure Category
		</a>
		<?php } ?>
		
        <?php if(ck_action("cost_menu","field")){ ?>
		<a href="<?php echo site_url('cost/field'); ?>" class="btn btn-default" id="field">
			Expenditure Field
		</a>
		<?php } ?>	
    </div>
</div>