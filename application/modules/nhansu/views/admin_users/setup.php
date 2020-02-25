<div class="box box-primary">
	<div class="box-header">
      <div class="pull-left">
         <div class="box-title">Thông tin chung</div>
      </div>
     	<div class="pull-right">
         <?php if(isset($item)){?>
         <a class="btn btn-success" href="admin_users/setup/<?php echo $user_id;?>">Thêm mới</a>
         <?php } else{ ?>
     		<span class="btn btn-success" data-toggle="collapse" data-target="#demo">Thêm mới</span>
         <?php } ?>
     	</div>
   </div>
	<div class="box-body collapse <?php if(isset($item)) echo 'in';?>" id="demo">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3">
					<?php if(isset($item)){ ?>
					<input type="hidden" name="id" value="<?php echo $item->id;?>">
					<?php } ?>
					<div class="form-group">
			    	<label>Danh mục</label>
			    	<div class="clearfix"></div>
			    	<select name="type" class="form-control" style="width: 100%">
			    		<?php foreach($this->_type as $key => $value) { ?>
			    		<option <?php if(isset($item) && $item->type == $value) echo 'selected="selected"';?> value="<?php echo $key;?>"><?php echo $value;?></option>
			    		<?php } ?>
			    	</select>
			   </div>
	   		<div class="form-group">
			      <label>Số tiền:</label>
			      <input type="text" class="form-control number" name="value" required value="<?php if(isset($item)) echo $item->value;?>">
			   </div>
			   <div class="form-group">
			      <label>Ngày áp dụng:</label>
			      <input type="text" class="form-control datepicker" name="date" required value="<?php if(isset($item)) echo $item->date; else echo date('Y-m-01');?>">
			   </div>
			   <div class="form-group">
			      <label>Ghi chú:</label>
			      <textarea name="note" class="form-control" rows="4"><?php if(isset($item)) echo $item->note;?></textarea>
			   </div>
			   <div class="form-group">
			    	<label>File đính kèm:</label>
			    	<input type="file" name="file">
			    	<?php if(isset($item)){ ?>
			    	<span style="color: red"><a target="_blank" href="<?php echo base_url()?>assets/uploads/staffs/<?php echo $item->file;?>"><?php if(isset($item) && $item->file != '') echo $item->file;?></a></span>
			    	<?php } ?>
			   </div>
			   <input type="submit" name="save" class="btn btn-success" value="Thêm mới">
			</div>
		</form>
	</div>
</div>

<div class="box box-primary">
   <?php if($results){ ?>
   <div class="box-body">
      <ul class="nav nav-tabs" style="margin-bottom: 15px">
         <li class="active"><a data-toggle="tab" href="#active">Kích hoạt</a></li>
         <li><a data-toggle="tab" href="#deactive">Không kích hoạt</a></li>
      </ul>
      <div class="tab-content">
         <div id="active" class="tab-pane fade in active">
         	<div class="table-responsive">
         		<table class="table table-bordered">
         			<thead>
         				<tr>
         					<th>STT</th>
         					<th>Kiểu</th>
         					<th>Giá trị</th>
         					<th>Ngày áp dụng</th>
         					<th>File đính kèm</th>
         					<th>Trạng thái</th>
         					<th>Người tạo</th>
         					<th>Ngày tạo</th>
         					<th>Tác vụ</th>
         				</tr>
         			</thead>
         			<tbody>
         				<?php foreach ($results as $key => $value) {
                     if($value->active == 1){ ?>
         				<tr>
         					<td><?php echo $key+1;?></td>
         					<td><?php echo $this->_type[$value->type];?></td>
         					<td><?php echo number_format($value->value);?></td>
         					<td><?php echo $value->date;?></td>
         					<td><a target="_blank" href="<?php echo base_url()?>assets/uploads/staffs/<?php echo $value->file;?>"><?php echo $value->file;?></a></td>
         					<td>
      	   					<label class="switch">
                              <input type="checkbox" <?php if($value->active == 1) echo 'checked="checked"';?> class="change-active" data-table="admin_user_infos" value="<?php echo $value->id; ?>" >
                              <div class="slider round"></div>
                           </label>	
         					</td>
         					<td><?php echo get_user_name($value->import_id);?></td>
         					<td><?php echo $value->created;?></td>
         					<td>
         						<a class="btn btn-xs btn-primary" href="admin_users/setup/<?php echo $value->user_id;?>?id=<?php echo $value->id;?>">
         							<i class="fa fa-pencil"></i>
         						</a>
         					</td>
         				</tr>
         				<?php }} ?>
         			</tbody>
         		</table>
         	</div>
         </div>

         <div id="deactive" class="tab-pane fade">
            <div class="box-body table-responsive">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>STT</th>
                        <th>Kiểu</th>
                        <th>Giá trị</th>
                        <th>Ngày áp dụng</th>
                        <th>File đính kèm</th>
                        <th>Trạng thái</th>
                        <th>Người tạo</th>
                        <th>Ngày tạo</th>
                        <th>Tác vụ</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($results as $key => $value) {
                     if($value->active == 0){ ?>
                     <tr>
                        <td><?php echo $key+1;?></td>
                        <td><?php echo $this->_type[$value->type];?></td>
                        <td><?php echo number_format($value->value);?></td>
                        <td><?php echo $value->date;?></td>
                        <td><a target="_blank" href="<?php echo base_url()?>assets/uploads/staffs/<?php echo $value->file;?>"><?php echo $value->file;?></a></td>
                        <td>
                           <label class="switch">
                              <input type="checkbox" <?php if($value->active == 1) echo 'checked="checked"';?> class="change-active" data-table="admin_user_infos" value="<?php echo $value->id; ?>" >
                              <div class="slider round"></div>
                           </label> 
                        </td>
                        <td><?php echo get_user_name($value->import_id);?></td>
                        <td><?php echo $value->created;?></td>
                        <td>
                           <a class="btn btn-xs btn-primary" href="admin_users/setup/<?php echo $value->user_id;?>?id=<?php echo $value->id;?>">
                              <i class="fa fa-pencil"></i>
                           </a>
                        </td>
                     </tr>
                     <?php }} ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
   <?php } ?>    
   <div class="box-footer">
      <a class="btn btn-warning" href="admin_users/custom/<?php echo $user_id;?>" target="_blank">Cài đặt hàng tháng
      </a>
      <small style="display: block; margin-top: 8px">Cài đặt những thông tin Thưởng - Tăng ca - Vi phạm nội quy hàng tháng</small>
   </div>
</div>
	