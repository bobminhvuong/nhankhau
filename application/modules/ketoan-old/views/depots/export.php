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
   		<form action="depots/export" method="POST" enctype="multipart/form-data">
   			<div class="form-group">
		      	<label  class="col-sm-3 control-label text-right">Lý do:</label>
		      	<div class="col-sm-6">
		      		<input type="text" class="form-control" name="title" required>
		      	</div><div class="clearfix"></div>
		    </div>
		    <div class="form-group">
		      	<label  class="col-sm-3 control-label text-right">Xuất đến:</label>
		      	<div class="col-sm-6">
			      	<select class="form-control" name="receive">
			      		<option value="store" style="font-weight: bold"><b>XUẤT VỀ CHI NHÁNH</b></option>
			      		<option value="other">Xuất khác</option>
			      	</select>
			    </div><div class="clearfix"></div>
		    </div>
		    <div class="form-group list_store">
		      	<label  class="col-sm-3 control-label text-right">Chi nhánh:</label>
		      	<div class="col-sm-6">
			      	<select class="form-control" name="store">
			      		<?php foreach (all_spas() as $key => $value) { ?>
			      		<option value="<?php echo $value->id;?>"><?php echo $value->description;?></option>
			      		<?php } ?>
			      	</select>
		      	</div><div class="clearfix"></div>
		    </div>
		    <div class="form-group">
		      	<label  class="col-sm-3 control-label text-right">Người duyệt:</label>
		      	<div class="col-sm-6">
			      	<select class="form-control" name="verify_id" style="width: 100%">
			      		<option>Chọn người duyệt</option>
			      		<optgroup label="Nhóm Quản lý">
			      		<?php foreach ($this->_list_manager as $key => $value) { ?>
			      		<option value="<?php echo $value->id;?>"><?php echo $value->last_name.' '.$value->first_name;?></option>
			      		<?php } ?>
			      		</optgroup>
			      		
			      		<optgroup label="Nhóm Trưởng KTV">
			      		<?php foreach ($this->_list_leader as $key => $value) { ?>
			      		<option value="<?php echo $value->id;?>"><?php echo $value->last_name.' '.$value->first_name;?></option>
			      		<?php } ?>
			      		</optgroup>
			      		<optgroup label="Nhóm Lễ tân">
			      		<?php foreach ($this->_list_receptionist as $key => $value) { ?>
			      		<option value="<?php echo $value->id;?>"><?php echo $value->last_name.' '.$value->first_name;?></option>
			      		<?php } ?>
			      		</optgroup>
			      		<optgroup label="Nhóm Tổng công ty">
			      		<?php foreach ($this->_list_admin as $key => $value) { ?>
			      		<option value="<?php echo $value->id;?>"><?php echo $value->last_name.' '.$value->first_name;?></option>
			      		<?php } ?>
			      		</optgroup>
			      	</select>
		      	</div><div class="clearfix"></div>
		    </div>
		    
		    <div class="form-group">
		    	<label  class="col-sm-3 control-label text-right">Chứng từ:</label>
		    	<div class="col-sm-6">
		    		<input type="file" name="file">
		    	</div><div class="clearfix"></div>
		    </div>
		    <div class="form-group">
		    	<label  class="col-sm-3 control-label text-right">Ghi chú:</label>
		    	<div class="col-sm-6">
		    		<textarea class="form-control" name="note"></textarea>
		    	</div><div class="clearfix"></div>
		    </div>

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
		               		foreach (all_products_full() as $product) { ?>
		               		<option value="<?php echo $product->id;?>"><?php echo $product->code.'_'.$product->description.'_'.number_format($product->price);?></option>
		               		<?php } ?>
		               	</select>  
		               	<span class="btn btn-primary add-product"><i class="fa fa-plus"></i></span>
	               	</div>    
	            </div><div class="clearfix"></div>
	        </div>
		    <!--div class="form-group">
		      	<label>Số lượng:</label>
		      	<input type="number" class="form-control number" name="quantity" required>
		    </div>
		    <div class="form-group">
		      	<label>Sản phẩm:</label>
		      	<select class="form-control select2" name="product_id" style="width: 100%">
		      		<option value="1">Thuốc mụn</option>
		      		<option value="2">Kem thâm</option>
		      	</select>
		    </div-->
		    <div class="col-sm-6 col-sm-offset-3">
		    	<input type="submit" name="save" class="btn btn-success" value="Thêm mới">
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
					<th>Nhận</th>
					<th>Người tạo</th>
					<th>Trạng thái</th>
					<th>Người duyệt</th>
					<th class="text-center">Tác vụ</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php foreach ($results as $key => $value) {?>
		  		<tr>
		  			<td class="text-center"><?php echo $key+1;?></td>
		  			<td><?php echo $value->title;?></td>
		  			<td><?php echo get_depot_item_product_code('depot_actions', $value->id);?></td>
		  			<td><?php echo get_depot_items('depot_actions', $value->id);?></td>
		  			<td>
		  				<span class="label label-default">
		  				<?php if($value->receive == 'store') echo get_store_name($value->store);
		  				else echo 'Khác';?>
		  				</span>
		  			</td>
		  			<td>
		  				<?php echo get_user_name($value->import_id);?>
		  				<br>
		  				<small><?php echo $value->created;?></small>
		  			</td>
		  			<td>
		  				<?php echo get_verify_status('depot_actions', $value->id);?>
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

<script type="text/javascript">
jQuery(document).ready(function($) {
	$("select[name='receive']").change(function() {
		if($(this).val() == 'store'){
			$('.list_store').removeClass('hide');
		}else{
			$('.list_store').addClass('hide');
		}
	});
});	
</script>
	