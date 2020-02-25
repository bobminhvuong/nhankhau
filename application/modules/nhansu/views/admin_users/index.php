<div class="box box-primary">
	<div class="box-header">
     	<form action="" method="GET" class="form-inline" role="form">
     		<div class="form-group">
     			<label>Từ khóa</label><div class="clearfix"></div>
     			<input type="text" name="key" class="form-control" placeholder="Họ tên, điện thoại" value="<?php if(isset($key)) echo $key;?>">
     		</div>
            <div class="form-group">
            	<label>Chi nhánh</label><div class="clearfix"></div>
                <select class="form-control select2" name="store_id[]" multiple placeholder="Chi nhánh">
                	<?php foreach (all_stores() as $key => $store) { ?>
					<option <?php if(isset($store_id) && in_array($store->id, $store_id)) echo 'selected="selected"';?> value="<?php echo $store->id;?>"><?php echo $store->description;?></option>
					<?php } ?>
                </select>
            </div>
            <div class="form-group">
            	<label>Nhóm quản trị</label><div class="clearfix"></div>
                <select class="form-control select2" name="group_id[]" multiple placeholder="Nhóm">
                	<?php 
                	$all_groups = all_groups();
                	unset($all_groups[0]);
                	foreach ($all_groups as $key => $group) { ?>
					<option <?php if(isset($group_id) && in_array($group->id, $group_id)) echo 'selected="selected"';?> value="<?php echo $group->id;?>"><?php echo $group->description;?></option>
					<?php } ?>
                </select>
            </div>
            <div class="form-group">
            	<label>Trạng thái</label><div class="clearfix"></div>
                <select class="form-control" name="online">
                	<option value="">Toàn bộ</option>
					<option <?php if(isset($online) && $online == 1) echo 'selected="selected"';?> value="1">Online</option>
					<option <?php if(isset($online) && $online == 0) echo 'selected="selected"';?> value="0">Offline</option>
                </select>
            </div>
            <div class="form-group">
            	<label>Tình trạng</label><div class="clearfix"></div>
                <select class="form-control" name="active">
                	<option value="">Toàn bộ</option>
					<option <?php if(isset($active) && $active == 1) echo 'selected="selected"';?> value="1">Đang làm việc</option>
					<option <?php if(isset($active) && $active == 0) echo 'selected="selected"';?> value="0">Đã nghỉ việc</option>
                </select>
            </div>
         	<div class="form-group">
         		<label></label><div class="clearfix"></div>
            	<input type="hidden" name="filter" value="1">
            	<button type="submit" class="form-control btn-primary">Hiển thị</button>
         	</div>
      	</form>
   	</div>
</div>

<?php if($results){ ?>
<div class="box box-primary">
	<div class="box-body table-responsive">
		<table class="table table-bordered">
			<thead>
				<th class="text-center">#</th>
				<th>Mã NV</th>
				<th>Họ tên</th>
				<th>Điện thoại</th>
				<th>Nhóm quản trị</th>
				<th>Chi nhánh CHÍNH</th>
				<th style="max-width: 400px">Chi nhánh</th>
				<th>Tình trạng</th>
				<th class="text-center">Tác vụ</th>
			</thead>
		  	<tbody>
		  		<?php 
		  		$i = 0;
		  		foreach ($results as $key => $value) { 
		  		$i++;?>
		  		<tr>
		  			<td class="text-center">
						<?php echo $i;?>
		  			</td>
		  			<td>
		  				<b><?php echo $value->id;?></b>
		  			</td>
		  			<td>
		  				<?php if($value->online == 1){ ?>
		  				<i class="fa fa-circle text-success fa-xs"></i>
		  				<?php }else{ ?>
		  				<i class="fa fa-circle"></i>
		  				<?php } ?>
		  				<?php echo $value->last_name.' '.$value->first_name;
		  				if($value->profiles){ ?>
		  					<i class="fa fa-image" style="cursor: pointer; color: blue" data-toggle="modal" data-target="#image-<?php echo $value->id;?>"></i>
		  					<div class="modal fade" id="image-<?php echo $value->id;?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			                    <div class="modal-dialog modal-lg">
			                        <div class="modal-content">
			                           	<div id="carousel-example-generic-<?php echo $value->id;?>" class="carousel slide" data-ride="carousel" data-interval="false">
			                           		<div class="carousel-inner text-center">
				                       			<?php foreach ($value->profiles as $key => $profile) {?>
				                          		<div class="item <?php if($key==0) echo 'active'; ?>">   
				                          			<img class="img-responsive" data-src="<?php echo base_url()?>assets/uploads/staffs/<?php echo $profile->file;?>">
				                          		</div>
				                      			<?php } ?>
				                      		</div>
				                          	<a class="left carousel-control" href="#carousel-example-generic-<?php echo $value->id;?>" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
				                          	<a class="right carousel-control" href="#carousel-example-generic-<?php echo $value->id;?>" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			                           </div>
			                         </div>
			                    </div>
		                  	</div>
		  				<?php }?>
		  				<?php if($value->online == 0){ ?>
		  				<br><small><?php echo time_last_login($value->last_action);?></small>
		  				<?php } ?>
		  			</td>
		  			<td>
		  				<?php echo $value->phone;?>
		  			</td>
		  			<td>
		  				<?php
		  				foreach ($value->groups as $group) {
							echo '<span class="label-store">'.get_group_name($group->group_id).'</span>';
		  				}
		  				?>
		  			</td>
		  			<td>
		  				<?php $main_store = get_store_name($value->main_store_id);
		  					if($main_store!='Uknow') echo '<span class="label label-primary">'.$main_store.'</span>';
		  				    else echo '<span class="label label-default">'.'Chưa cập nhật'.'</span>';
		  				?>
		  			</td>
		  			<td style="max-width: 400px">
		  				<?php
		  				if(count($value->stores) > 2){
		  					echo '<span class="label-store">Nhiều chi nhánh</span>';
		  				}else{
			  				foreach ($value->stores as $store) {
			  					echo '<span class="label-store">'.get_store_name($store->store_id).'</span>';
			  				}
		  				}
		  				?>
		  			</td>
		  			<td>
		  				<?php if($value->active == 1){ ?>
		  				<span class="label label-primary">Đang làm việc</span>
		  				<?php } else{ ?>
		  				<span class="label label-warning">Đã nghỉ việc</span>
		  				<?php } ?>
		  			</td>
		  			<td class="text-center">
		  				<a href="admin_users/logout/<?php echo $value->id;?>"  data-toggle="tooltip" title="Đăng nhập" class="btn btn-xs btn-primary"><i class="fa fa-unlock-alt"></i></a>
		  				<a href="admin_users/edit/<?php echo $value->id;?>" data-toggle="tooltip" title="Chỉnh sửa" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
		  				<a href="admin_users/setup/<?php echo $value->id;?>" class="btn btn-xs btn-warning"><i class="fa fa-dollar"></i></a>
		  				<?php if($value->image_url){?>
		  				<span class="btn btn-xs btn-success" data-toggle="collapse" data-target="#<?php echo $value->id;?>"><i class="fa fa-user"></i></span>
		  					<?php }
		  				else{?>
		  					<span class="btn btn-xs btn-danger" data-toggle="collapse" data-target="#<?php echo $value->id;?>"><i class="fa fa-user"></i></span>
		  				<?php }?>
		  			</td>
		  		</tr>
		  		<tr id="<?php echo $value->id;?>" class="collapse" style="background: #cfcfcf">
		  			<td colspan="10">
		  				
						<form class="form-inline form-users-update-avatar" method="post" enctype="multipart/form-data">
		  					<input type="hidden" name="id" value="<?php echo $value->id;?>">
		  					<div class="form-group">
		  						<small>Cập nhật avatar</small><br>
		  						<label>
				                  	<input type="file" name="avatar<?php echo  $value->id;?>"/>
				                </label>
		  					</div>
		  					<div class="form-group">
		  						<small>Đường dây nội bộ</small><br>
		  						<label>
				                  	<input type="number" name="line<?php echo  $value->id;?>" value="<?php echo get_user_line($value->id); ?>"/>
				                </label>
		  					</div>
		  					<div class="form-group pull-right">
		  						<small>Tác vụ</small><br>
		  						<input  class="btn btn-sm btn-success" type="submit" name="fileSubmit" value="Cập nhật" />
		  					</div>
						</form>
		  			
		  				
		  			</td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>
	</div>
</div>
<?php } ?>
<script type="text/javascript">
	$('.fa-image').click(function(){
		var id = $(this).data('target');
		$(id+" img" ).each(function( index ) {
		  	$(this).attr('src', $(this).data('src'));
		});
	});
</script>

	