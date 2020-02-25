
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Upload bảng lương</div>
	</div>
	<div class="box-body">
     	<form action="" method="post" enctype="multipart/form-data" class="col-sm-6 col-sm-offset-3">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="name" required>
			</div>
			<label>Chọn file</label>
			<div class="input-group">
		    	<input type="file" class="form-control" name="file" required>
		        <span class="input-group-btn">
		            <input type="submit" name="upload_excel" class="btn btn-info btn-flat" value="Upload !">
		        </span>
			</div>
		</form>
   	</div>
</div>



<div class="box box-primary">
	<div class="box-body">
		<?php if($results){ ?>
		<div class="table-responsive">
			<table class="table table-bordered tablelte-full">
				<thead>
					<th class="text-center">#</th>
					
					<th>Tiêu đề</th>
					<th>File</th>
					<th>Người tạo</th>
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
			  			<td><?php echo $value->name;?></td>
			  			<td><?php echo $value->file;?></td>
			  			<td>
			  				<?php echo get_user_name($value->import_id);?>
			  				<br><small><?php echo $value->created;?></small>
			  			</td>
			  			<td class="text-center">
			  				<a href="salaries/salary_view/<?php echo $value->id;?>"  data-toggle="tooltip" title="Xem file" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-eye"></i></a>
			  			</td>
			  		</tr>
			  		<?php } ?>
			  	</tbody>
			</table>
		</div>
		<?php } else{ ?>
		<h4>Không có dữ liệu</h4>
		<?php } ?>
	</div>
</div>


	