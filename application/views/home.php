<div class="row">
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'blue', $home['appointment'], 'Lịch hẹn', 'fa fa-calendar', 'appointments'); ?>
	</div>
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'green', number_format($home['revenue']), 'Doanh số', 'fa fa-dollar', 'invoices'); ?>
	</div>
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'yellow', number_format($home['paid']), 'Chi', 'fa fa-credit-card', 'invoices/paids'); ?>
	</div>
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'blue', number_format($home['sms_balance']), 'SMS', 'fa fa-comment', 'invoices'); ?>
	</div>
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'green', number_format($home['revenue']), 'AdsWord', 'fa fa-database', 'invoices'); ?>
	</div>
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'yellow', number_format($home['revenue']), 'Đánh giá', 'fa fa-star', 'invoices'); ?>
	</div>
	<div class="col-sm-6 col-md-4">
		<?php echo modules::run('widget/info_box', 'blue', 2, 'Nhạc', 'fa fa-youtube', 'home/music'); ?>
	</div>
</div>
