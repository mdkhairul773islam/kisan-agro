<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">	
        <?php if(ck_action("bank_menu","add-bank")){ ?>
        <a href="<?php echo site_url('bank/bankInfo/add_bank'); ?>" class="btn btn-default" id="add-bank">
			Add Bank 
		</a>
		<?php } ?>
		
		<?php if(ck_action("bank_menu","add-new")){ ?>
		<a href="<?php echo site_url('bank/bankInfo'); ?>" class="btn btn-default" id="add-new">
			Add Account 
		</a>
		<?php } ?>
		
		<?php if(ck_action("bank_menu","all-acc")){ ?>
		<a href="<?php echo site_url('bank/bankInfo/all_account'); ?>" class="btn btn-default" id="all-acc">
			 All Account
		</a>
		<?php } ?>
		
		<?php if(ck_action("bank_menu","add")){ ?>
		<a href="<?php echo site_url('bank/bankInfo/transaction'); ?>" class="btn btn-default" id="add">
			Add Transaction
		</a>
		<?php } ?>
		
		<?php if(ck_action("bank_menu","all")){ ?>
		<a href="<?php echo site_url('bank/bankInfo/allTransaction'); ?>" class="btn btn-default" id="all">
			All Transaction
		</a>
		<?php } ?>
		
		<?php if(ck_action("bank_menu","ledger")){ ?>
		<a href="<?php echo site_url('bank/bankInfo/ledger'); ?>" class="btn btn-default" id="ledger">
			Bank ledger
		</a>
		<?php } ?>
    </div>
</div>