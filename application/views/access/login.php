<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
		<title><?php echo (!empty(config_item('site_name')) ? config_item('site_name') : '') . " | ". filter($meta_title); ?></title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
		<link href="<?php echo site_url('private/css/login.css'); ?>" rel="stylesheet">
	</head>
	
	<body>
		<section class="login_wrapper">
			<?php
				$attr=array('class'=>'login_form');
				echo form_open('access/users/login',$attr);
			?>
			<h3 title="<?php echo (!empty(config_item('site_name')) ? config_item('site_name') : ''); ?>"><?php echo (!empty(config_item('site_name')) ? config_item('site_name') : ''); ?></h3>
			<div class="flashdata_title">
				<p><?php echo $this->session->flashdata('error'); ?></p>
			</div>
			
			<div class="form_group">
				<label class="control_label" for="username"><i class="fa fa-user" aria-hidden="true"></i></label>
				<input type="text" class="l-form-control" id="username" name="username" placeholder="Username">
			</div>
			<div class="form_group">
				<label class="control_label" for="password"><i class="fa fa-key"  aria-hidden="true"></i></label>
				<input type="password" class="l-form-control" id="password" name="password" placeholder="Password">
			</div>
			<div class="form_checkbox">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me"></label>
                <p>Remember Me</p>
			</div>
			<div class="form_group">
				<input type="submit" name="submit_login" class="login_btn" value="Login">
			</div>
			<div class="form_footer">
				<a href="<?php echo site_url('forgot_password/forgot_password'); ?>">Forgot Password ?</a>
				<a target="_blank" href="http://freelanceitlab.com/">Software By: Freelance IT Lab</a>
			</div>
			<?php echo form_close();?>
		</section>	
	</body>
</html>