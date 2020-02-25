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
                <select class="form-control" name="store_id">
                	<?php foreach (all_spas() as $key => $value) {?>
                	<option <?php if($value->id == $store_id) echo 'selected="selected"';?> value="<?php echo $value->id;?>"><?php echo $value->description;?></option>
                	<?php } ?>
                </select>
            </div>
         	<div class="form-group">
            	<input type="hidden" name="filter" value="1">
            	<button type="submit" class="form-control btn-primary">Hiển thị</button>
         	</div>
      	</form>
   	</div>
</div>

<?php if($results){?>
<div class="box box-primary">
	<div class="box-body table-responsive">
		<table class="table tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th>Lý do</th>
					<th>Kiểu chi</th>
					<th>HT nhận</th>
					<th>Số tiền</th>
					<th>Người tạo</th>
					<th>Người duyệt</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$total = 0;
				$table = 'cashbook_stores';
				foreach ($results as $key => $value) {
				$total += $value->price;
				?>
				<tr>
					<td  class="text-center"><?php echo $key+1;?></td>
					<td><?php echo $value->title;?></td>
					<td>
						<span class="label label-default">
						<?php
						if($value->type_id == 0) echo 'Chưa chọn';
						else if($value->type_id == 1) echo 'Tổng công ty';
						else echo $this->_type[$value->type_id];
						?>
						</span>
						<span class="label label-default">
						<?php
						if($value->source == 'amount') echo 'Tiền mặt';
						else if($value->source == 'transfer') echo 'Tài khoản';
						else 'Null';
						?>
						</span>
					</td>
					<td>
						<span class="label label-default">
						<?php
						if($value->formality == 'amount') echo 'Tiền mặt';
						else if($value->formality == 'transfer') echo 'Chuyển khoản';
						else echo 'None';
						?>
						</span>
					</td>
					<td>
						<?php echo number_format($value->price);?>	
					</td>
					<td><?php echo get_user_name($value->import_id);?></td>
					<td>
						<?php //echo get_user_name($value->verify_id);
						if(isset($value->verify_name)) $value->verify_name;
						else echo 'Null';
						?>
					</td>
					<td>
						<?php 
						//if($value->verify_id != get_current_user_id()){
						if(!is_admin()){
							if($value->verify_status == 0) echo '<span class="label label-primary">Chờ duyệt</span>';
							else if($value->verify_status == 1) echo '<span class="label label-success">Đã duyệt</span>';
							else if($value->verify_status == 2) echo '<span class="label label-danger">Không duyệt</span>';
						}else{?>
							<div class="verify">
	                            <div class="panel list-group" style="margin-bottom: 5px">
	                                <?php
	                                if($value->verify_status == 0){ 
	                                    $class = '';
	                                    $title = 'Chưa duyệt';
	                                }
	                                else if($value->verify_status == 1){ 
	                                    $class = 'btn-success';
	                                    $title = 'Đã duyệt';
	                                }
	                                else if($value->verify_status == 2) {
	                                    $class = 'btn-danger';
	                                    $title = 'Không duyệt';
	                                }
	                                else{ 
	                                    $class = 'btn-warning';
	                                    $title = 'Unknown';
	                                }
	                                ?>
	                                <button class="btn btn-xs <?php echo $class;?>" data-toggle="collapse" data-target="#packages-<?php echo $value->id;?>" data-parent="#menu">
	                                    <?php echo $title;?>
	                                </button>
	                                <div id="packages-<?php echo $value->id;?>" class="sublinks collapse">
	                                    <a class="list-group-item small btn-verify" data-table="cashbook_stores" data-id="<?php echo $value->id;?>" data-status="0">Chưa duyệt</a>
	                                    <a class="list-group-item small btn-verify" data-table="cashbook_stores" data-id="<?php echo $value->id;?>" data-status="1">Duyệt</a>
	                                    <a class="list-group-item small btn-verify" data-table="cashbook_stores" data-id="<?php echo $value->id;?>" data-status="2">Không duyệt</a>
	                                </div>
	                            </div>
	                        </div>
						<?php } ?>
					</td>
					<td>
						<?php echo date('d-m-Y', strtotime($value->created));
						echo ' <small>',date('H:i:s', strtotime($value->created)).'<small>';?>	
					</td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-right">Tổng</th>
					<th><?php echo number_format($total);?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php } ?>


