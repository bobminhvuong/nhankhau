<p class="label label-danger"><?php echo (isset($error)&&$error!='')? $error:''; ?></p>
<form action="admin_users/save" id="form_add" method="post" class="form-users" enctype="multipart/form-data">
	<input type="hidden" class="form-control" name="verify" value="<?php echo ($basic == 1)?0:1;?>" required="required">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Thông tin cơn bản</div>
				</div>
				<div class="box-body">
					<div class="form-group">
			            <label class="control-label">Họ<span class="required"> *</span></label>                   
			            <input type="text" class="form-control" name="last_name" placeholder="Họ" required="required">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Tên<span class="required">*</span></label>
			            <input type="text" class="form-control" name="first_name" placeholder="Tên" required="required">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Điện thoại<span class="required">*</span></label>
			            <input type="text" class="form-control" name="phone" placeholder="Điện thoại" required="required">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Tài khoản<span class="required">*</span></label>
			            <input type="text" class="form-control" name="username" required="required" placeholder="Tài khoản">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Mật khẩu<span class="required">*</span></label>
			            <input type="text" class="form-control" name="password" required="required" placeholder="Mật khẩu" required="required">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Ngày vào làm<span class="required">*</span></label>
			            <input type="text" class="form-control datepicker" name="date_start" required="required">
			        </div>
			        <div class="form-group">
		  				<label>Chi nhánh chính</label>
		  				<select class="form-control select1" name="main_store_id">
				        <?php foreach($stores as $store){?>
				        	<option <?php echo (get_current_store_id()==$store->id)?'selected="selected"':'';?> value="<?php echo $store->id;?>"><?php echo $store->description;?></option>
				                    <?php } ?>
				        </select>
		  			</div>
		  			<div class="form-group">
		  				<label>Làm việc trên CRM (nhận tour)</label>
				        <input type="checkbox" name="can_work" class="icheck-blue" value="1" checked="checked">
				                
		  			</div>
		    	</div>
	    	</div>
		</div>

		<?php if($basic != 1) { ?>
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Thông tin liên hệ</div>
				</div>
				<div class="box-body">
			        <div class="form-group">
			            <label class="control-label text-right">Điện thoại liên hệ khi cần<span class="required">*</span></label>
			            <input type="text" class="form-control" name="phone_contact" placeholder="Điện thoại liên hệ khi cần" required="required" required="required">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Ngày sinh<span class="required">*</span></label>
			            <input type="text" class="form-control datepicker" name="birthday">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Địa chỉ thường trú<span class="required">*</span></label>
			            <input type="text" class="form-control" name="address" required="required" placeholder="Địa chỉ thường trú">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Địa chỉ liên lạc<span class="required">*</span></label>
			            <input type="text" class="form-control" name="address_contact" required="required" placeholder="Địa chỉ liên lạc">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Số chứng minh thư<span class="required">*</span></label>
			            <input type="text" class="form-control" name="id_card" required="required" placeholder="Số chứng minh thư">   
			        </div>
			        <div class="form-group">
			            <label class="control-label">Ngày cấp<span class="required">*</span></label>
		               	<input type="text" class="form-control datepicker" required="required" name="id_date">   
			        </div>
			    </div>
			</div>
		</div>
		<?php } ?>

		<?php if($basic != 1) { ?>
		<div class="col-xs-12 col-sm-3"></div>
		<?php } ?>
		<div class="col-xs-12 col-sm-6">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Thông tin chung</div>
				</div>
				<div class="box-body">
					<?php if($basic != 1) { ?>
			        <div class="form-group">
			            <label class="control-label">Hồ sơ<span class="required">*</span></label>
		               	<input type="file" name="file" class="form-control" required> 
			        </div>
			       	<?php } ?>

			       	<div class="form-group">
			            <label class="control-label">Nhóm quản trị</label>
			            <select class="form-control select2" name="groups[]" multiple required>
		            		<?php foreach ($groups as $group) { ?>
		            		<option value="<?php echo $group->id;?>"><?php echo $group->description;?></option>
		            		<?php } ?>
		               	</select> 	  
			        </div>

			        <div class="form-group">
			            <label class="control-label">Chi nhánh</label>
		            	<select class="form-control select2" name="stores[]" multiple required>
		               		<?php foreach ($stores as $store) { ?>
		            		<option value="<?php echo $store->id;?>"><?php echo $store->description;?></option>
		            		<?php } ?>
		               	</select> 	  
			        </div>
			        <div class="form-group">
			            <label class="control-label">Hợp đồng lao động<span class="required">*</span></label>
		               	<select class="form-control" name="contract">
		               		<option value="0">Chưa có</option>
		               		<option value="1">Đã có</option>
		               	</select> 
			        </div>
			        <div class="form-group">
			            <label class="control-label">Trạng thái<span class="required">*</span></label>
		               	<select class="form-control" name="active">
		               		<option value="1">Đang làm việc</option>
		               		<option value="0">Đã nghỉ việc</option>
		               	</select> 
			        </div>
			        <input type="text" name="save" hidden value="Cập nhật">
			        <div class="form-group">
			            <div class="form-submit">
			               	<input class="btn btn-success" id="save" type="submit" name="save" value="Cập nhật"> 
			            </div>  
			            
			        </div>

				</div>
			</div>
			 <p class="label label-danger"><?php echo (isset($error)&&$error!='')? $error:''; ?></p>
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

	/*
		setTimeout(function(){
			console.log("click r");
	  		$("input[type=submit]").attr("disabled","true");
			$("input[type=submit]").click(function() {
				console.log("click r");
	  		$("input[type=submit]").attr("disabled","true");
			$("#form_add").submit();
			});
		
		 }, 2000);*/

		

	
	
</script>

	