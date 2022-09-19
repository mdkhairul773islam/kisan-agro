<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<?php if(ck_action("ledger_menu","company-ledger")){ ?>
    		<a href="<?php echo site_url('ledger/companyLedger'); ?>" class="btn btn-default" id="company-ledger">
    			Supplier Ledger
    		</a>
		<?php } ?>

	    <?php if(ck_action("ledger_menu","client-ledger")){ ?>
    		<a href="<?php echo site_url('ledger/clientLedger'); ?>" class="btn btn-default" id="client-ledger">
    			Client Ledger
    		</a>
		<?php } ?>
		
		<?php if(checkAuth('super')){ ?>
		<a href="<?php echo site_url('ledger/short_balance'); ?>" class="btn btn-default" id="shortBalance">
			Client Short Balance
		</a>
		<?php } ?>
    </div>
</div>
