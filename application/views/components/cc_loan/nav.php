<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
		<?php if(ck_action("cc_loan_menu","add-new")){ ?>
		<a href="<?php echo site_url('cc_loan/cc_loan'); ?>" class="btn btn-default" id="add-new">
			CC Loan Account
		</a>
		<?php } ?>
		
		<?php if(ck_action("cc_loan_menu","all-loan")){ ?>
		<a href="<?php echo site_url('cc_loan/cc_loan/allloan'); ?>" class="btn btn-default" id="all-loan">
		    All CC Loan
		</a>
		<?php } ?>
		
		<?php if(ck_action("cc_loan_menu","loan_trx")){ ?>
		<a href="<?php echo site_url('cc_loan/cc_loan/loan_trx'); ?>" class="btn btn-default" id="loan_trx">
		    CC Transaction
		</a>
		<?php } ?>
		
		<?php if(ck_action("cc_loan_menu","all_cc_trx")){ ?>
		<a href="<?php echo site_url('cc_loan/cc_loan/all_cc_trx'); ?>" class="btn btn-default" id="all_cc_trx">
		    All CC Transaction
		</a>
		<?php } ?>
		
		<?php if(ck_action("cc_loan_menu","all-trnx")){ ?>
		<a href="<?php echo site_url('cc_loan/cc_loan/alltransaction'); ?>" class="btn btn-default" id="all-trnx">
		    CC Ledger
		</a>
		<?php } ?>
    </div>
</div>
