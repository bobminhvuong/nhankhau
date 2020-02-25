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
            	<button type="submit" name="search" class="form-control btn-primary">Hiển thị</button>
         	</div>
         	<div class="pull-right">
         		<a href="depots/depot_update" class="form-control btn-primary">Cập nhật</a>
         	</div>
      	</form>
   	</div>
</div>

<?php if($actions){ ?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Xuất nhập hàng</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Loại</th>
					<th>Nguồn</th>
					<th>Người nhận</th>
					<th>Tiêu đề</th>
					<th>Mã sản phẩm</th>
					<th>Sản phẩm</th>
					<th>Người duyệt</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php 
		  		$check_products = $list_products = array();
		  		foreach ($actions as $key => $value) { 
		  		$table = 'depot_stores_actions';
		  		$receive = 'Tổng công ty';
		  		if(isset($value->store)){
		  			$source = 'Tổng công ty';
		  			$table = 'depot_actions';
		  			if($value->receive == 'store'){
		  				$receive = get_store_name($value->store);
		  			}
		  		}else{
		  			$receive = 'Tổng công ty';
		  			$source = get_store_name($value->store_id);
		  		}

		  		$products = get_item_depots($table, $value->id);
		  		foreach ($products as $pr) {
		  			
		  			if(!in_array($pr->item_id, $check_products)){
		  				$check_products[] = $pr->item_id;
		  				$list_products[$pr->item_id]['minus'] = 0;
		  				$list_products[$pr->item_id]['plus'] = 0;
		  				$list_products[$pr->item_id]['product_id'] = $pr->item_id;
		  			}
		  			

		  			if($pr->tbl_name == 'depot_actions'){
		  				if($value->type == 'import'){
		  					$list_products[$pr->item_id]['plus'] += $pr->quantity;
		  				}
		  				else if($value->type == 'export'){
		  					$list_products[$pr->item_id]['minus'] += $pr->quantity;
		  				}
		  			}

		  			if($pr->tbl_name == 'depot_stores_actions'){
		  				$list_products[$pr->item_id]['plus'] += $pr->quantity;
		  			}

		  		}

		  		?>
		  		<tr>
		  			<td class="text-center"><?php echo $key+1;?></td>
		  			<td>
		  				<?php if($value->type == 'import') { ?>
		  					<span class="label label-info">Nhập</span>
		  				<?php } else if($value->type == 'export') { ?>
		  					<span class="label label-primary">Xuất</span>
		  				<?php } ?>
		  			</td>
		  			<td><?php echo $source;?></td>
		  			<td><span class="label label-default"><?php echo $receive;?></span></td>
		  			<td><?php echo $value->title;?></td>
		  			<td><?php echo get_depot_item_product_code($table, $value->id);?></td>
		  			<td><?php echo get_depot_items($table, $value->id);?></td>
		  			<td>
		  				<?php echo get_user_name($value->verify_id);
		  				echo '<br><small>'.$value->verify_time.'</small>';
		  				?>
		  			</td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>
	</div>
</div>
<?php } ?>

<?php if(isset($list_products)){ ?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Số lượng</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Mã sản phẩm</th>
					<th>Tên sản phẩm</th>
					<th>Nhập</th>
					<th>Xuất</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php 
		  		$i = 0;
		  		foreach ($list_products as $key => $value) {
		  		$i++; ?>
		  		<tr>
		  			<td class="text-center"><?php echo $i;?></td>
		  			<td><?php echo product_code('products', $value['product_id']);?></td>
		  			<td><?php echo get_product_name($key);?></td>
		  			<td><?php echo number_format($value['plus']);?></td>
		  			<td><?php echo number_format($value['minus']);?></td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>
	</div>
</div>
<?php } ?>




<?php if($update) {?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">
			Kho hàng trong ngày <small>(cập nhật tồn cuối)</small>
		</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Mã sản phẩm</th>
					<th>Tên sản phẩm</th>
					<th>Tồn đầu</th>
					<th>Nhập</th>
					<th>Xuất</th>
					<th>Tồn cuối</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php foreach ($results as $key => $value) {
		  		$end = $value->begin;
		  		?>
		  		<tr>
		  			<td class="text-center"><?php echo $key+1;?></td>
		  			<td><?php echo product_code('products', $value->product_id);?></td>
		  			<td><?php echo get_product_name($value->product_id);?></td>
		  			<td><?php echo number_format($value->begin);?></td>
		  			<td>
		  				<?php 
		  				if(isset($list_products[$value->product_id])){
		  					$data['import'] = $list_products[$value->product_id]['plus'];
		  					echo $list_products[$value->product_id]['plus'];
		  					$end += $list_products[$value->product_id]['plus'];
		  				}
		  				else echo 0;
		  				?>	
		  			</td>
		  			<td>
		  				<?php 
		  				if(isset($list_products[$value->product_id])){
		  					$data['export'] = $list_products[$value->product_id]['minus'];
		  					echo $list_products[$value->product_id]['minus'];
		  					$end -= $list_products[$value->product_id]['minus'];
		  				}
		  				else echo 0;
		  				?>		
		  			</td>
		  			<td>
		  				<?php 
		  				echo number_format($end);
		  				$data['end'] = $end;
		  				$this->db->where('id', $value->id);
						$this->db->update('depots', $data);
		  				?>		
		  			</td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>
	</div>
</div>
<?php } else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Kho hàng</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-bordered tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Mã sản phẩm</th>
					<th>Tên sản phẩm</th>
					<th>Tồn đầu</th>
					<th>Nhập</th>
					<th>Xuất</th>
					<th>Tồn cuối</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php foreach ($results as $key => $value) { ?>
		  		<tr>
		  			<td class="text-center"><?php echo $key+1;?></td>
		  			<td><?php echo product_code('products', $value->product_id);?></td>
		  			<td><?php echo get_product_name($value->product_id);?></td>
		  			<td><?php echo number_format($value->begin);?></td>
		  			<td><?php echo number_format($value->import);?></td>
		  			<td><?php echo number_format($value->export);?></td>
		  			<td><?php echo number_format($value->end);?></td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>
	</div>
</div>
<?php } ?>
	