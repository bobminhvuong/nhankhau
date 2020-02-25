<p class="label label-danger"><?php echo (isset($error)&&$error!='')? $error:''; ?></p>
<form action="admin_users/save" id="form_add" method="post" class="form-users" enctype="multipart/form-data">
	<input type="hidden" name="id"  value="<?php echo $admin_user->id;?>"> 

	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Thông tin cơn bản</div>
				</div>
				<div class="box-body">
					<div class="form-group">
				        <label class="control-label">Họ<span class="required">*</span></label>
				        <input type="text" class="form-control" name="last_name" placeholder="Họ" required="required" value="<?php echo $admin_user->last_name;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Tên<span class="required">*</span></label>
				        <input type="text" class="form-control" name="first_name" placeholder="Tên" required="required" value="<?php echo $admin_user->first_name;?>">   

				    </div>
				    <div class="form-group">
				        <label class="control-label">Điện thoại<span class="required">*</span></label>
				        <input type="text" class="form-control" name="phone" placeholder="Điện thoại" required="required" value="<?php echo $admin_user->phone;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Tài khoản<span class="required">*</span></label>
				        <input type="text" class="form-control" name="username" placeholder="Tài khoản" required="required" value="<?php echo $admin_user->username;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Mật khẩu<span class="required">*</span></label>
				        <input type="text" class="form-control" name="password" placeholder="Mật khẩu">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Ngày vào làm<span class="required">*</span></label>
				        <input type="text" class="form-control datepicker" required="required" name="date_start" value="<?php echo $admin_user->date_start;?>">   
				    </div>
				    <div class="form-group">
		  				<label>Chi nhánh chính</label>
		  				<select class="form-control select1" name="main_store_id">
				        <?php foreach($stores as $store){?>
				        	<option <?php echo (get_main_store_id($admin_user->id)==$store->id)?'selected="selected"':'';?> value="<?php echo $store->id;?>"><?php echo $store->description;?></option>
				                    <?php } ?>
				        </select>
		  			</div>
		  			<div class="form-group">
		  				<label>Làm việc trên CRM (nhận tour)</label>
				        <input type="checkbox" name="can_work" class="icheck-blue" value="1" <?php if($admin_user->can_work == 1) echo 'checked="checked"';?>>
				                
		  			</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Thông tin liên hệ</div>
				</div>
				<div class="box-body">
					<div class="form-group">
				        <label class="control-label">Điện thoại liên hệ khi cần<span class="required">*</span></label>
				        <input type="text" class="form-control" name="phone_contact" placeholder="Điện thoại" required="required" value="<?php echo $admin_user->phone_contact;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Ngày sinh<span class="required">*</span></label>
				        <input type="text" class="form-control datepicker" required="required" name="birthday" value="<?php echo $admin_user->birthday;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Địa chỉ thường trú<span class="required">*</span></label>
				        <input type="text" class="form-control" name="address" placeholder="Địa chỉ thường trú" value="<?php echo $admin_user->address;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Địa chỉ liên lạc<span class="required">*</span></label>
				        <input type="text" class="form-control" name="address_contact" placeholder="Địa chỉ liên lạc" value="<?php echo $admin_user->address_contact;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Số chứng minh thư<span class="required">*</span></label>
				        <input type="text" class="form-control" name="id_card" required="required" placeholder="Số chứng minh thư" value="<?php echo $admin_user->id_card;?>">   
				    </div>
				    <div class="form-group">
				        <label class="control-label">Ngày cấp<span class="required">*</span></label>
				        <input type="text" class="form-control datepicker" required="required" name="id_date" value="<?php echo $admin_user->id_date;?>">   
				    </div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Thông tin chung</div>
				</div>
				<div class="box-body">
					<div class="form-group">
				        <label class="control-label">Ngày nghỉ</label>
				        <input type="text" class="form-control" readonly value="<?php echo $admin_user->date_end;?>">
				    </div>
				    <div class="form-group">
				        <label class="control-label">Hồ sơ<span class="required">*</span></label>
				       	<input type="file" name="file" class="form-control"> 
				    </div>

				    <div class="form-group">
				        <label class="control-label">Nhóm quản trị</label>
				        <select class="form-control select2" name="groups[]" multiple required>
			        		<?php foreach ($groups as $group) { ?>
			        		<option value="<?php echo $group->id;?>" <?php foreach ($admin_user->groups as $gr) { if($gr->group_id == $group->id) echo 'selected="selected"'; } ?>><?php echo $group->description;?></option>
			        			
			        		<?php } ?>
			           	</select> 	  
				    </div>
				    <div class="form-group">
				        <label class="control-label">Chi nhánh</label>
			        	<select class="form-control select2" name="stores[]" multiple required>
			           		<?php foreach ($stores as $store) { ?>
			        		<option value="<?php echo $store->id;?>" <?php foreach ($admin_user->stores as $st) { if($st->store_id == $store->id) echo 'selected="selected"'; } ?> ><?php echo $store->description;?></option>
			        		<?php } ?>
			           	</select> 	  
				    </div>
				    <div class="form-group">
				        <label class="control-label">Hợp đồng lao động<span class="required">*</span></label>
				  
				        <select class="form-control" name="contract">
			           		<option value="0" <?php if($admin_user->contract == 0) echo 'selected="selected"';?>>Chưa có</option>
			           		<option value="1" <?php if($admin_user->contract == 1) echo 'selected="selected"';?>>Đã có</option>	
				        </select> 
				    </div>
				    <div class="form-group">
				        <label class="control-label">Phê duyệt tài khoản<span class="required">*</span></label>
			           	<select class="form-control" name="verify">
			           		<option value="0" <?php if($admin_user->verify == 0) echo 'selected="selected"';?>>Chưa duyệt</option>
			           		<option value="1" <?php if($admin_user->verify == 1) echo 'selected="selected"';?>>Đã duyệt</option>	
			           	</select> 
				    </div>
				    <div class="form-group">
				        <label class="control-label">Trạng thái<span class="required">*</span></label>
			           	<select class="form-control" name="active">
			           		<option value="1" <?php if($admin_user->active == 1) echo 'selected="selected"';?>>Đang làm việc</option>
			           		<option value="0" <?php if($admin_user->active == 0) echo 'selected="selected"';?>>Đã nghỉ việc</option>
			           	</select> 
				    </div>
				    <input type="text" name="save" hidden value="Cập nhật">
				    <div class="form-group">
				        <div class="form-submit">
				           	<input class="btn btn-success" type="submit" name="save" value="Cập nhật"> 

				        </div>  
				       
				    </div>

				</div>
			</div>
		</div>
		<span class="label label-danger"><?php echo (isset($error)&&$error!='')? $error:''; ?></span> 
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Hồ sơ đã upload</div>
				</div>
				<div class="box-body">
					<?php if($admin_user->profiles){?>
				    <div class="form-group">
				        <div class="col-sm-12">
				        	<div class="row">
				               	<?php foreach ($admin_user->profiles as $key => $profile) {?>
				              		<div class="col-xs-6 col-sm-3">
				              			<img data-toggle="modal" data-target="#image" style="cursor: pointer; width: 100%; height: 70px; object-fit: cover" src="<?php echo base_url();?>assets/uploads/staffs/<?php echo $profile->file;?>" >
				              			<?php if(is_admin()){?>
				              			<div class="text-center">
				              				<a class="label label-danger" href="admin_users/remove_img/<?php echo $profile->id;?>">Xóa</a>
				              			</div>
				              			<?php } ?>
				              		</div>
				          		<?php } ?>
				      		</div>
				        </div><div class="clearfix"></div>
				    </div>

				    <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				        <div class="modal-dialog modal-lg">
				            <div class="modal-content">
				               	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
				               		<div class="carousel-inner text-center">
				               			<?php foreach ($admin_user->profiles as $key => $profile) {?>
				                  		<div class="item <?php if($key==0) echo 'active'; ?>">   
				                  			<img class="img-responsive" src="<?php echo base_url();?>assets/uploads/staffs/<?php echo $profile->file;?>">

				                  		</div>
				              			<?php } ?>
				              		</div>
				                  	<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
				                  	<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				               </div>
				             </div>
				         </div>
				  	</div>
				    <?php } ?>
				</div>
			</div>
		</div>
	</div>  
</form>


<script type="text/javascript">
	jQuery(document).ready(function() {
		setTimeout(function(){
			$( "input[name=last_name]" ).focus();
			$( "input[name=last_name]" ).click();
			});
		
		 }, 1000);
	$( "#form_add" ).submit(function( event ) {
		//$("input[type=submit]").click();
		document.forms["form_add"].submit();
		$("input[type=submit]").attr("disabled","true");

		//$("#form_add").submit();
	  	//event.preventDefault();
	});
	

</script>
	