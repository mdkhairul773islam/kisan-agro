<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
		<?php if(ck_action("transport_menu","createTransport")){ ?>
		<a href="<?php echo site_url('transport/transport/create'); ?>" class="btn btn-default" id="createTransport">
			Add Transport
		</a>
		<?php } ?>
		
        <?php if(ck_action("transport_menu","allTransport")){ ?>
		<a href="<?php echo site_url('transport/transport'); ?>" class="btn btn-default" id="allTransport">
			All Transport
		</a>
		<?php } ?>
    </div>
</div>