<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">

		<?php if(ck_action("report_menu","sales_report")){ ?>
    		<a href="<?php echo site_url('report/sales_report'); ?>" class="btn btn-default" id="sales_report">
    			Daily Report
    		</a>
        <?php } ?>
        
        <?php  if(ck_action("report_menu","sales_report_item")){ ?>
    		<a href="<?php echo site_url('report/sales_report/sales_report_item'); ?>" class="btn btn-default" id="sales_report_item">
    			Sales Item Report
    		</a>
        <?php } ?>
        
        <?php /*if(ck_action("report_menu","sales_return_report")){ ?>
    		<a href="<?php echo site_url('report/sales_report/sales_return_report'); ?>" class="btn btn-default" id="sales_return_report">
    			Sales Return Report
    		</a>
        <?php }*/ ?>
        
		<a href="<?php echo site_url('report/sales_report/date_wise_sales_report'); ?>" class="btn btn-default" id="date_wise_sales_report">
			Date wise report
    	</a>
    	
    	<a href="<?php echo site_url('report/sales_report/date_wise_item_sale_report'); ?>" class="btn btn-default" id="date_wise_item_sale_report">
			Date wise Item report
    	</a>
    </div>
</div>
