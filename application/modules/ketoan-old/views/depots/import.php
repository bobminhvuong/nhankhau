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
         	<div class="pull-right">
         		<span class="btn btn-success" data-toggle="collapse" data-target="#demo">Thêm mới</span>
         	</div>
      	</form>
   	</div>
   	<div class="box-body collapse" id="demo">
   		<form action="depots/import" method="POST" enctype="multipart/form-data">
   			<div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Tiêu đề<span class="required">*</span>                     
	            </label>
	            <div class="col-sm-6">
	               	<input type="text" class="form-control" name="title" placeholder="Tiêu đề" required="required">   
	            </div><div class="clearfix"></div>
	        </div>
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Ghi chú                    
	            </label>
	            <div class="col-sm-6">
	               	<textarea class="form-control" name="note"></textarea>   
	            </div><div class="clearfix"></div>
	        </div>
			<hr>
	        <div class="form-group">
	            <label  class="col-sm-3 control-label text-right">
	            	Sản phẩm                   
	            </label>
	            <div class="col-sm-6">
	            	<div class="list-products">
	            		
	            	</div>
	               	<div class="form-inline">
		            	<input type="number" name="product_quantity" class="form-control select-quantity" placeholder="Số lượng">
		               	<select class="form-control select2" name="products">
		               		<?php 
		               		foreach (all_products() as $product) { ?>
		               		<option value="<?php echo $product->id;?>"><?php echo $product->code.'_'.$product->description.'_'.number_format($product->price);?></option>
		               		<?php } ?>
		               	</select>  
		               	<span class="btn btn-primary add-product"><i class="fa fa-plus"></i></span>
	               	</div>    
	            </div><div class="clearfix"></div>
	        </div>
	        
	        <div class="form-group">
	            <div class="col-sm-6 col-sm-offset-3">
	               	<input class="btn btn-success" type="submit" name="save" value="Thêm mới">    
	            </div><div class="clearfix"></div>
	        </div>
   		</form>
   	</div>
</div>

<div class="box box-primary">
   	<?php if($results){?>
   	<div class="box-body table-responsive">
		<table class="table table-bordered tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Lý do</th>
					<th>Mã sản phẩm</th>
					<th>Sản phẩm</th>
					<th>Kiểu</th>
					<th>Nguồn</th>
					<th>Nhận</th>
					<th>Người tạo</th>
					<th>Trạng thái</th>
					<th>Người duyệt</th>
					<th class="text-center">Tác vụ</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php foreach ($results as $key => $value) {
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
		  		} ?>
		  		<tr>
		  			<td class="text-center"><?php echo $key+1;?></td>
		  			<td><?php echo $value->title;?></td>
		  			<td><?php echo get_depot_item_product_code($table, $value->id);?></td>
		  			<td><?php echo get_depot_items($table, $value->id);?></td>
		  			<td>
		  				<?php if($value->type == 'import'){ ?>
		  				<span class="label label-info">Nhập</span>
		  				<?php } else { ?>
		  				<span class="label label-primary">Xuất</span>
		  				<?php } ?>
		  			</td>
		  			<td><span class="label label-default"><?php echo $source;?></span></td>
		  			<td><span class="label label-default"><?php echo $receive;?></span></td>
		  			<td>
		  				<?php echo get_user_name($value->import_id);?>
		  				<br>
		  				<small><?php echo $value->created;?></small>
		  			</td>
		  			<td>
		  				<?php echo get_verify_status($table, $value->id);?>
		  			</td>
		  			<td><?php echo get_user_name($value->verify_id);?></td>
		  			<td>
		  				<a target="_blank" class="btn btn-danger" href="depots/remove/<?php echo $value->id;?>"><i class="fa fa-trash"></i></a>
		  			</td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		</table>	
	</div>
	<?php } ?>
</div>
	