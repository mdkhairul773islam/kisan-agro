
<div class="container-fluid none" <?php echo $subMenu; ?> style="margin-bottom: 10px;">
    <div class="row">
        <?php if(ck_action("employee_menu","add-new")){ ?>	
		<a href="<?php echo site_url('employee/employee'); ?>" class="btn btn-default" id="add-new">
			Add New
		</a>
		<?php } ?>
		
		<?php if(ck_action("employee_menu","all")){ ?>	
		<a href="<?php echo site_url('employee/employee/show_employee'); ?>" class="btn btn-default" id="all">
			All Employee
		</a>
		<?php } ?>
		
		<?php if(ck_action("employee_menu","activeAll")){ ?>	
		<a href="<?php echo site_url('employee/employee/active_employee'); ?>" class="btn btn-default" id="activeAll">
			Active Employee
		</a>
		<?php } ?>
		
		<?php if(ck_action("employee_menu","designation")){ ?>	
		<a href="<?php echo site_url('employee/designation'); ?>" class="btn btn-default" id="designation">
			Designation
		</a>
		<?php } ?>
		
		<?php if(ck_action("employee_menu","department")){ ?>	
		<a href="<?php echo site_url('employee/department'); ?>" class="btn btn-default" id="department">
			Department
		</a>
		<?php } ?>
    </div>
</div>