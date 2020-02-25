<div class="box box-primary">
	<div class="box-header">
     	<div class="pull-right">
     		<a href="admin_users/permission" class="btn btn-success">Tạo mới Phân quyền</a>
     	</div>
    </div>
	<div class="box-body">
		<?php if($results){ ?>
			<table class="table table-bordered tablelte-full">
			<thead>
				<th class="text-center">#</th>
				<th>Tên</th>
				<th>Action</th>
				<th>Mô tả</th>
				<th class="text-center">Tác vụ</th>
			</thead>
		  	<tbody>
		  		<?php 
		  		foreach ($results as $key => $value) { ?>
		  		<tr>
		  			<td class="text-center">
						<?php echo $key+1;?>
		  			</td>
		  			<td>
		  				<?php echo $value->name;?>
		  			</td>
		  			<td>
		  				<?php echo $value->action;?>
		  			</td>
		  			<td>
		  				<?php echo $value->description;?>
		  			</td>
		  			<td class="text-center">
		  				<a href="admin_users/permission/<?php echo $value->id;?>" data-toggle="tooltip" title="Chỉnh sửa" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></a>
		  			</td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>
		<?php } else{ ?>
		<h4>Không có dữ liệu</h4>
		<?php } ?>
	</div>
</div>
	