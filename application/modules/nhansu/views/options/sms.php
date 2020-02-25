<div class="box box-primary">
	<div class="box-header">
     	<form action="" method="GET" role="form">
        	<div class="form-group" style="margin: 10px 0">
                <select class="form-control select2" name="store_id[]" multiple="multiple">
                	<?php foreach(all_spas() as $spa){ ?>
                	<option <?php if(in_array($spa->id, $store_id)) echo 'selected="selected"';?> value="<?php echo $spa->id;?>"><?php echo $spa->description;?></option>
                	<?php } ?> 
                </select>
            </div>
            <div class="form-group" style="margin: 10px 0">
                <select class="form-control select2" name="group_id[]" multiple="multiple">
                	<?php 
                	$all_groups = all_groups();
                	unset($all_groups[0]);
                	foreach($all_groups as $group){ ?>
                	<option <?php if(in_array($group->id, $group_id)) echo 'selected="selected"';?> value="<?php echo $group->id;?>"><?php echo $group->description;?></option>
                	<?php } ?> 
                </select>
            </div>
            <div class="form-inline">
	         	<div class="form-group">
	            	<input type="hidden" name="filter" value="1">
	            	<button type="submit" class="form-control btn-primary">Hiển thị</button>
	         	</div>
         	</div>
      	</form>
   	</div>
</div>

<?php if(isset($_GET['status']) && $_GET['status'] == 'success' ){ ?>
<div class="callout callout-success">
    <h4>Thành công!</h4>
    <p>SMS đã được gửi đi.</p>
</div>
<?php } ?>

<?php if($results){ ?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Danh sách nhân viên</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>STT</th>
					<th>Chọn</th>
					<th>Nhân viên</th>
					<th>Điện thoại</th>
				</tr>
			</thead>
			<tbody>
				<form action="" method="post">
				<?php foreach ($results as $key => $value) { ?>
				<tr>
					<td><?php echo $key+1;?></td>
					<td>
						<input type="checkbox" name="phone[]" value="<?php echo $value->phone;?>" checked="checked">
					</td>
					<td><?php echo $value->last_name.' '.$value->first_name;?></td>
					<td><?php echo $value->phone;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td>Gửi sms</td>
					<td>
						<textarea class="form-control" name="content" placeholder="Nhập nội dung sms"></textarea>
					</td>
					<td colspan="2">
						<input type="submit" name="send" class="btn btn-success" value="Gửi đi">
					</td>
				</tr>
				</form>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>


<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Gửi riêng qua sdt</div>
	</div>
	<div class="box-body">
		<form action="options/sms_v2" method="post">
			<div class="form-group">
				<label>Nhập số điện thoại, ngăn cách bằng dấu ,</label>
				<textarea class="form-control" name="phone" placeholder="0909000999, 0123456789, 0334562564"></textarea>
			</div>
			<div class="form-group">
				<label>Nhập nội dung</label>
				<textarea class="form-control" name="content" placeholder="Nội dung sms"></textarea>
			</div>
			<input type="submit" name="send" class="btn btn-success" value="Gửi đi">
		</form>
	</div>
</div>



<div class="">

<style type="text/css">
	input[type=checkbox]{
		transform: scale(1.5);
	}
</style>

