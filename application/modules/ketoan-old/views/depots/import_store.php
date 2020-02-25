<div class="box box-primary">
	<div class="box-header">
     	<form action="" method="GET" class="form-inline" role="form">
        	<div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input id="reportrange" name="date_filter" class="pull-right" data-start="<?php echo $start;?>" data-end="<?php echo $end;?>">
                </div>
            </div>
         	<div class="form-group">
            	<input type="hidden" name="filter" value="1">
            	<button type="submit" class="form-control btn-primary">Hiển thị</button>
         	</div>
      	</form>
   	</div>
</div>
<?php foreach ($all_stores as $store) { ?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title"><?php echo $store->description;?></div>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>  
		</div>
	</div>
   	<?php if($store->results){?>
   	<div class="box-body table-responsive">
		<table class="table table-bordered tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Lý do</th>
					<th>Mã sản phẩm</th>
					<th>Sản phẩm</th>
					<th>Người tạo</th>
					<th>Trạng thái</th>
					<th>Người duyệt</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php 
		  		foreach ($store->results as $key => $value) {
		  		$table = 'depot_stores_actions';
		  		?>
		  		<tr>
		  			<td class="text-center"><?php echo $key+1;?></td>
		  			<td><?php echo $value->title;?></td>
		  			<td><?php echo get_depot_item_product_code($table, $value->id);?></td>
		  			<td><?php echo get_depot_items($table, $value->id);?></td>
		  			<td>
		  				<?php echo get_user_name($value->import_id);?>
		  				<br>
		  				<small><?php echo $value->created;?></small>
		  			</td>
		  			<td>
		  				<?php echo get_verify_status($table, $value->id);?>
		  			</td>
		  			<td><?php echo get_user_name($value->verify_id);?></td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>	
	</div>
	<?php }else{ ?>
	<div class="box-body">
		Không có dữ liệu
	</div>
	<?php } ?>
</div>
<?php } ?>
	