<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		
		<?php if (ck_action("loan-menu", "add-new")) { ?>
		<a href="<?php echo site_url('loan/loan'); ?>" class="btn btn-default" id="add-new">
			Received & Paid
		</a>
		<?php } ?>

		<?php if (ck_action("loan-menu", "all")) { ?>
		<a href="<?php echo site_url('loan/loan/view_all'); ?>" class="btn btn-default" id="all">
			View All Loan
		</a>
		<?php } ?>

		<?php if (ck_action("loan-menu", "trans")) { ?>
		<a href="<?php echo site_url('loan/loan/transaction'); ?>" class="btn btn-default" id="trans">
			Transaction
		</a>
		<?php } ?>

		<?php if (ck_action("loan-menu", "alltrans")) { ?>
		<a href="<?php echo site_url('loan/loan/alltransaction'); ?>" class="btn btn-default" id="alltrans">
			Transaction Ledger
		</a>
		<?php } ?>
    </div>
</div>
