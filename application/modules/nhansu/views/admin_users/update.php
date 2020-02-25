<style type="text/css">
	/*
	input[name=birthday]{
		width: 85px;
	}
	input[name=id_card]{
		width: 85px;
	}
	input[name=id_date]{
		width: 85px;
	}
	*/
	.icheckbox_flat-blue{ 
		margin-top: 5px;
    	margin-left: 15px;
	}
</style>
<?php if($results){ ?>
<div class="box box-primary">
	<div class="box-body table-responsive">
		<table class="table table-bordered">
			<thead>
				<th class="text-center">#</th>
				<th>Họ tên</th>
				<th>Điện thoại</th>
				<th>Ngày sinh</th>
				<th>Số CMND</th>
				<th>Ngày cấp</th>
				<th>Hợp đồng</th>
				<th>Liên hệ khi cần</th>
				<th>Phê duyệt</th>
				<th class="text-center">Tác vụ</th>
			</thead>
		  	<tbody>
		  		<?php 
		  		$i = 0;
		  		foreach ($results as $key => $value) { 
		  		$style = '';
		  		if($value->birthday == '0000-00-00' && $value->phone_contact == ''){
		  			$style = 'style="border-bottom: solid 2px red; border-left: solid 4px red"';
		  		}
		  		$i++;?>
		  		<tr <?php echo $style;?> >
		  			<td class="text-center">
						<span class="btn btn-xs btn-primary" data-toggle="collapse" data-target="#<?php echo $value->id;?>"><?php echo $i;?></span>
		  			</td>
		  			<td><?php echo $value->last_name.' '.$value->first_name; ?></td>
		  			<td>
		  				<?php echo $value->phone;?>
		  			</td>
		  			<td>
		  				<?php echo $value->birthday;?>
		  			</td>
		  			<td>
		  				<?php echo $value->id_card;?>
		  			</td>
		  			<td>
		  				<?php echo $value->id_date;?>
		  			</td>
		  			<td>
		  				<?php if($value->contract == 1){?>
		  				<span class="label label-success">Có</span>
		  				<?php } else{ ?>
		  				<span class="label label-warning">Không</span>
		  				<?php } ?>
		  			</td>
		  			<td>
		  				<?php echo $value->phone_contact;?>
		  			</td>
		  			<td>
		  				<?php if($value->verify == 1){?>
		  				<span class="label label-success">Đã duyệt</span>
		  				<?php } else{ ?>
		  				<span class="label label-warning">Chưa duyệt</span>
		  				<?php } ?>
		  			</td>
		  			<td class="text-center">
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
		  				<form class="form-inline form-users-update" method="post">
		  					<input type="hidden" name="id" value="<?php echo $value->id;?>">
		  					<div class="form-group">
		  						<small>Ngày sinh</small><br>
		  						<input name="birthday" class="form-control input-sm datepicker" value="<?php echo $value->birthday;?>">
		  					</div>
		  					<div class="form-group">
		  						<small>Số CMND</small><br>
		  						<input name="id_card" class="form-control input-sm" value="<?php echo $value->id_card;?>">
		  					</div>
		  					<div class="form-group">
		  						<small>Ngày cấp</small><br>
		  						<input name="id_date" class="form-control input-sm datepicker" value="<?php echo $value->id_date;?>">
		  					</div>
		  					<div class="form-group">
		  						<small>Hợp đồng</small><br>
		  						<label>
				                  	<input type="checkbox" name="contract" class="icheck-blue" value="1" <?php if($value->contract == 1) echo 'checked="checked"';?> >
				                </label>
		  					</div>
		  					<div class="form-group">
		  						<small>Liên hệ khi cần</small><br>
		  						<input name="phone_contact" class="form-control input-sm" value="<?php echo $value->phone_contact;?>">
		  					</div>
		  					<div class="form-group">
		  						<small>Chi nhánh chính</small><br>
		  						<select class="form-control select1" name="main_store_id">
				                    <?php foreach($store_lists as $store){?>
				                    <option <?php echo (get_main_store_id($value->id)==$store->id)?'selected="selected"':'';?> value="<?php echo $store->id;?>"><?php echo $store->description;?></option>
				                    <?php } ?>
				                </select>
		  					</div>
		  					<div class="form-group">
		  						<small>Làm việc trên CRM (nhận tour)</small><br>
		  						<label>
				                  	<input type="checkbox" name="can_work" class="icheck-blue" value="1" <?php if($value->can_work == 1) echo 'checked="checked"';?> >
				                </label>
		  					</div>
		  					<div class="form-group">
		  						<small>Phê duyệt</small><br>
		  						<label>
				                  	<input type="checkbox" name="verify" class="icheck-blue" value="1" <?php if($value->verify == 1) echo 'checked="checked"';?> >
				                </label>
		  					</div>
		  					<div class="form-group pull-right">
		  						<small>Tác vụ</small><br>
		  						<button name="submit" class="btn btn-sm btn-success" value="update">Cập nhật</button>
		  					</div>

						</form>
						<hr>
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
jQuery(document).ready(function($) {
	$(".form-users-update").on( "submit", function(event) {
        event.preventDefault();
        var data = $(this).serialize();
        console.log(data);
        $.ajax({
            url: "admin_users/ajax_update",
            type: "POST",
            dataType: "text",
            data: {'data': data},
            success: function(res){
                toastr["success"]("Cập nhật thành công");
                console.log(res);
            },
            error: function(err){
                toastr["error"]("Lỗi, nội dung chưa được gửi đi");
            }
        });
    });
});
</script>


	