<div class="login-box">
	<!--div class="login-logo"><b><?php echo $site_name; ?></b></div-->
	<div class="login-logo"><img src="assets/images/logo-text.png" width="212px"></div>
	<div class="login-box-body">
		<p class="login-box-msg">Đăng nhập hệ thống</p>
		<?php echo $form->open(); ?>
			<?php echo $form->messages(); ?>
			<?php echo $form->bs3_text('Tài khoản', 'username', ''); ?>
			<?php echo $form->bs3_password('Mật khẩu', 'password', ''); ?>

			<?php if($this->input->get('redirect')) { ?>
			<input type="hidden" name="redirect" value="<?php echo $this->input->get('redirect');?>">
			<?php } ?>
			<div class="row">
				<div class="col-xs-6">
					<div class="checkbox">
						<input type="checkbox" name="remember" class="icheck-blue">  Ghi nhớ
					</div>
				</div>
				<div class="col-xs-6">
					<?php echo $form->bs3_submit('Đăng nhập', 'btn btn-primary btn-block btn-flat'); ?>
				</div>
			</div>
		<?php echo $form->close(); ?>
	</div>
</div>