<div class="box box-primary">
	<div class="box-body">
		<form action="" method="post">
			<input type="hidden" name="id" value="<?php echo $group->id;?>">
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Tên phân quyền<span class="required">*</span>                     
	            </label>
	            <div class="col-sm-6">
	               	<input type="text" class="form-control" name="name" placeholder="Tên phân quyền" required="required" value="<?php echo $group->name;?>">   
	            </div><div class="clearfix"></div>
	        </div>
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Action<span class="required">*</span>                     
	            </label>
	            <div class="col-sm-6">
	               	<input type="text" class="form-control" name="action" placeholder="" required="required" value="<?php echo $group->action;?>">   
	            </div><div class="clearfix"></div>
	        </div>
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Mô tả               
	            </label>
	            <div class="col-sm-6">
	            	<textarea class="form-control" name="description" rows="3"><?php echo $group->description;?></textarea>  
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
	