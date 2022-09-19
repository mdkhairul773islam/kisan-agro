<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("income_menu","field")){ ?>
		<a href="<?php echo site_url('income/income'); ?>" class="btn btn-default" id="field">
			Field of Income 
		</a>
		<?php } ?>
		
		<?php if(ck_action("income_menu","new")){ ?>
		<a href="<?php echo site_url('income/income/newIncome'); ?>" class="btn btn-default" id="new">
			New Income
		</a>
		<?php } ?>
		
		<?php if(ck_action("income_menu","all")){ ?>
		<a href="<?php echo site_url('income/income/all'); ?>" class="btn btn-default" id="all">
			All Income
		</a>
		<?php } ?>
    </div>
</div>