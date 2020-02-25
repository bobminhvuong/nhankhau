<header class="main-header">
	<!--a href="" class="logo"><b><?php echo $site_name; ?></b></a-->
	<a href="<?php echo base_url();?>" class="logo" style="background: white"><img src="<?php echo base_url('assets/images/logo-text.png');?>" width="135px"></a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<?php
		$user_stores = get_user_stores();
		$selected = '';
		if(count($user_stores) == 1){
		echo '<span class="store-name">'.$user_stores[0]->description.'</span>';
		} else{
		echo '<select id="change-store" class="form-control">';
		foreach ($user_stores as $key => $store) {
			if(get_current_store_id() == $store->id){ $selected = 'selected = "selected"'; }
			echo '<option '.$selected.' value="'.$store->id.'">'.$store->id.': '.$store->description.'</option>';
			$selected = '';
		} 
		echo '</select>';
		} ?>
		
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<?php $verify = get_verify();
				if($verify > 0){?>
				<li class="dropdown notifications-menu">
	                <a href="<?php echo base_url('cashbooks/verify');?>">
	                  	<i class="fa fa-bullhorn"></i>
	                  	<?php if($verify > 0){ ?>
	                  	<span class="label label-danger notifications-count" id="notifications-baged"><?php echo $verify; ?></span>
	                  	<?php } ?>
	                </a>
            	</li>
            	<?php } ?>

            	<li class="dropdown notifications-menu">
	                <a href="<?php echo base_url('notifies/view/1');?>">
	                  	<i class="fa fa-phone"></i>
	                </a>
            	</li>
            	
				<?php
				$notif_appointments = notif_appointments();
				?>
				<li class="dropdown notifications-menu" id="notifications-menu">
	                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
	                  	<i class="fa fa-calendar"></i>
	                  	<?php if(count($notif_appointments) > 0){ ?>
	                  	<span class="label label-danger notifications-count" id="notifications-baged"><?php echo count($notif_appointments); ?></span>
	                  	<?php } ?>
	                </a>
	                <ul class="dropdown-menu">
	                  	<li class="header notifications-count"><?php echo 'Bạn có '.count(notif_appointments()).' lịch hẹn'; ?></li>
	                  	<li>
		                    <ul class="menu">
		                        <?php foreach ($notif_appointments as $notif) { ?>
		                        <li>
		                           	<a href="appointments/edit/<?php echo $notif->id;?>" target="_blank">
		                             	<?php echo $notif->name.' - '.$notif->phone; ?><br>
		                              	<small><i class="fa fa-clock-o"></i> <?php echo (int)((strtotime($notif->time) - time())/60).' phút nữa'; ?></small>
		                           	</a>
		                        </li>
		                    	<?php } ?>
		                    </ul>
	                  	</li>
	                  	<li class="footer">
	                    	<!-- <a href="<?php echo base_url('admin/notifications'); ?>">Xem tất cả các thông báo</a> -->
	                    	<a>Khách chưa đến</a>
	                  	</li>
	                </ul>
            	</li>

				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo (isset($user->image_url)&&($user->image_url!=''))?$user->image_url:base_url().'assets/uploads/avatars/default.png'; ?>" height="20px">
						<span class="hidden-xs"><?php echo $user->first_name; ?></span>
						<!-- <span class="visible-xs"><i class="fa fa-user"></i></span> -->
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<p><?php echo $user->first_name; ?></p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo base_url();?>panel/account" class="btn btn-default btn-flat">Tài khoản</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url();?>panel/logout" class="btn btn-default btn-flat">Đăng xuất</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>