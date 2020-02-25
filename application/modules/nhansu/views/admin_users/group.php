<div class="box box-primary">
	<div class="box-body">
		<form action="" method="post">
			<input type="hidden" name="id" value="<?php echo $group->id;?>">
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Mã nhóm<span class="required">*</span>                     
	            </label>
	            <div class="col-sm-6">
	               	<input type="text" class="form-control" name="name" placeholder="Mã nhóm" required="required" value="<?php echo $group->name;?>">   
	            </div><div class="clearfix"></div>
	        </div>
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Tên nhóm<span class="required">*</span>                     
	            </label>
	            <div class="col-sm-6">
	               	<input type="text" class="form-control" name="description" placeholder="Tên nhóm" required="required" value="<?php echo $group->description;?>">   
	            </div><div class="clearfix"></div>
	        </div>
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Phân quyền<span class="required">*</span>                     
	            </label>
	            <div class="col-sm-6">
	               	<select class="form-control select2" name="permissions[]" multiple data-placeholder="Lựa chọn">
	            		<?php foreach ($all_permissions as $permission) { ?>
	            		<option <?php echo $permission->status;?> value="<?php echo $permission->id;?>"><?php echo $permission->name;?></option>
	            		<?php } ?>
	               	</select>    
	            </div><div class="clearfix"></div>
	        </div>
	        <div class="form-group">
	            <div class="col-sm-6 col-sm-offset-3">
	               	<input class="btn btn-success" type="submit" name="save" value="Lưu">    
	            </div><div class="clearfix"></div>
	        </div>
		</form>
	</div>
</div>
	