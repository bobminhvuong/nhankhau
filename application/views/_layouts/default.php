<div class="wrapper">

	<?php $this->load->view('_partials/navbar'); ?>

	<?php // Left side column. contains the logo and sidebar ?>
	<aside class="main-sidebar">
		<section class="sidebar">
			<div class="user-panel" style="height:65px">

				<div class="pull-left info" style="left:5px">
					
					<div class="row pull-right">
						<div  class="col-xs-4">
							<img src="<?php echo (isset($user->image_url)&&($user->image_url!=''))?$user->image_url:'assets/uploads/avatars/default.png'; ?>" height="50px" width="50px"/>
						</div>
						<div   class="col-xs-8" style="margin-top: .5em;">
							<a href="panel/account">
							<p><?php echo $user->first_name; ?></p>
							<i class="fa fa-circle text-success"></i> Online
							</a>
						</div>
					</div>
				</div>
			</div>
			<?php // (Optional) Add Search box here ?>
			<?php //$this->load->view('_partials/sidemenu_search'); ?>
			<?php $this->load->view('_partials/sidemenu'); ?>
		</section>
	</aside>

	<?php // Right side column. Contains the navbar and content of the page ?>
	<div class="content-wrapper">

		<?php if(get_option('notify_status') == 'true'){?>
		<section class="alert alert-warning alert-dismissible" style="border-radius: 0; margin-bottom: 0">   
            <?php echo get_option('notify_content');?>
      	</section>
		<?php } ?>

		<section class="content-header">
			<h1><?php echo $page_title; ?></h1>
			<?php $this->load->view('_partials/breadcrumb'); ?>
		</section>
		<section class="content">
			<?php $this->load->view($inner_view); ?>
			<?php $this->load->view('_partials/back_btn'); ?>
		</section>
	</div>

	<?php // Footer ?>
	<?php $this->load->view('_partials/footer'); ?>

</div>