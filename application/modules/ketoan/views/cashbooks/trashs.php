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

<?php if($results){ ?>

	<div class="box box-primary">
		<div class="box-body table-responsive">
			<table class="table tablelte-excel">
				<thead>
					<tr>
						<th class="text-center">STT</th>
						<th>Tiêu đề</th>
						<th>Nguồn</th>
						<th>Kiểu</th>
						<th>Số tiền</th>
						<th>Hình thức</th>
						<th>Người tạo</th>
						<th>Người duyệt</th>
						<th>Trạng thái</th>
						<th>Ngày tạo</th>
						<th>Ngày xóa</th>
						<th>Người xóa</th>
						<th>Tác vụ</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $row) { ?>
					<?php 
					$i = 0;
					$value = json_decode($row->value);
					$i++;?>
					<tr>
						<td  class="text-center"><?php echo $i;?></td>
						<td><?php echo $value->title;?></td>
						<td>
							<span class="label label-default">
							<?php if(isset($value->store_id)){ 
								echo 'Chi nhánh';
								$table = 'cashbook_stores';
							}else{
								echo 'Tổng công ty';
								$table = 'cashbooks';
							}?>
							</span>
						</td>
						<td>
							
							<?php if($value->type == 'receipts'){ 
								echo '<span class="label label-success">Thu</span>';
							}else if($value->type == 'expenditures'){
								echo '<span class="label label-warning">Chi</span>';
							}?>
							</span>
						</td>
						<td><?php echo number_format($value->price);?></td>
						<td>
							<span class="label label-default">
							<?php
							if($value->formality == 'amount') echo 'Tiền mặt';
							else if($value->formality == 'transfer') echo 'Chuyển khoản';
							else echo 'None';
							?>
							</span>
						</td>
						<td><?php echo get_user_name($value->import_id);?></td>
						<td><?php echo get_user_name($value->verify_id);?></td>
						<td>
							<?php 
							if($value->verify_id != get_current_user_id()){
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
		                                    <a class="list-group-item small btn-verify" data-table="<?php echo $table;?>" data-id="<?php echo $value->id;?>" data-status="0">Chưa duyệt</a>
		                                    <a class="list-group-item small btn-verify" data-table="<?php echo $table;?>" data-id="<?php echo $value->id;?>" data-status="1">Duyệt</a>
		                                    <a class="list-group-item small btn-verify" data-table="<?php echo $table;?>" data-id="<?php echo $value->id;?>" data-status="2">Không duyệt</a>
		                                </div>
		                            </div>
		                        </div>
							<?php } ?>
						</td>
						<td>
							<?php echo date('d-m-Y', strtotime($value->created));
							echo ' <small>',date('H:i:s', strtotime($value->created)).'<small>';?>	
						</td>
						<td>
							<?php echo date('d-m-Y', strtotime($row->created));
							echo ' <small>',date('H:i:s', strtotime($row->created)).'<small>';?>
						</td>
						<td>
							<?php echo get_user_name($row->import_id);?>	
						</td>
						<td>
					
							<a href="cashbooks/view/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
							<a href="cashbooks/cashbook_print/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>
							<?php if(is_admin()){ ?>
							<a href="cashbooks/restore/<?php echo $row->id;?>?table=<?php echo $table;?>" class="btn btn-xs btn-danger"><i class="fa fa-undo"></i></a>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php } ?>