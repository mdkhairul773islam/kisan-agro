<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">

		<?php if(ck_action("report_menu","purchase_report")){ ?>
    		<a href="<?php echo site_url('report/purchase_report'); ?>" class="btn btn-default" id="purchase_report">
                Daily Report
    		</a>
        <?php } ?>

        <?php if(ck_action("report_menu","date_wise_purchase_report")){ ?>
    		<a href="<?php echo site_url('report/purchase_report/date_wise_purchase_report'); ?>" class="btn btn-default" id="date_wise_purchase_report">
    			Date Wise Report
    		</a>
       <?php } ?>
       
    </div>
</div>
