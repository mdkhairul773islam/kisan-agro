<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
		
		<?php if(ck_action("closing-menu","add-new")){ ?>
    		<a href="<?php echo site_url('closing/closing'); ?>" class="btn btn-default" id="add-new">
    			Daily
    		</a>
		<?php } ?>
		
		<?php if(ck_action("closing-menu","report")){ ?>
    		<a href="<?php echo site_url('closing/closing/report'); ?>" class="btn btn-default" id="report">
    			Report
    		</a>
		<?php } ?>
		
    </div>
</div>