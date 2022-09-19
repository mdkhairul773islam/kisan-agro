<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<a href="<?php echo site_url('crushing_client/crushing_client'); ?>" class="btn btn-default" id="add">
			Add Crushing Client
		</a>

		<a href="<?php echo site_url('crushing_client/crushing_client/view_all'); ?>" class="btn btn-default" id="all">
			All Crushing Client
		</a>

		<a href="<?php echo site_url('crushing_client/transaction/'); ?>" class="btn btn-default" id="transaction">
			Add Transaction
		</a>

		<a href="<?php echo site_url('crushing_client/all_transaction'); ?>" class="btn btn-default" id="all-transaction">
			All Transaction
		</a>
    </div>
</div>
