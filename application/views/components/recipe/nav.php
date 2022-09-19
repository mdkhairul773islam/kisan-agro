<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		
        <?php if(ck_action("recipe_menu","make-formula")){ ?>
    		<a href="<?php echo site_url('recipe/make_formula'); ?>" class="btn btn-default" id="make-formula">
    			Make Formula
    		</a>
    	<?php } ?>
    	
        <?php if(ck_action("recipe_menu","all-formula")){ ?>		
    		<a href="<?php echo site_url('recipe/make_formula/all'); ?>" class="btn btn-default" id="all-formula">
    			All Formula
    		</a>
		<?php } ?>
		
        <?php if(ck_action("recipe_menu","make-recipe")){ ?>		
    		<a href="<?php echo site_url('recipe/recipe'); ?>" class="btn btn-default" id="make-recipe">
    			Make Recipe
    		</a>
    	<?php } ?>


        <?php if (ck_action("recipe_menu", "pending-recipe")) { ?>
    		<a href="<?php echo site_url('recipe/recipe/pending_recipe'); ?>" class="btn btn-default" id="pending-recipe">
                Pending Recipe
    		</a>
    	<?php } ?>


        <?php if (ck_action("recipe_menu", "pending-recipe-list")) { ?>
    		<a href="<?php echo site_url('recipe/recipe/pending_recipe_list'); ?>" class="btn btn-default" id="pending-recipe-list">
                Pending Recipe List
    		</a>
    	<?php } ?>
    	
        <?php if(ck_action("recipe_menu","all-recipe")){ ?>
    		<a href="<?php echo site_url('recipe/recipe/all'); ?>" class="btn btn-default" id="all-recipe">
    			All Recipe
    		</a>
    	<?php } ?>	
    	
    	<?php if(ck_action("recipe_menu","report")){ ?>
    		<a href="<?php echo site_url('recipe/report'); ?>" class="btn btn-default" id="report">
    			Report
    		</a>
    	<?php } ?>	
    		
    </div>
</div>