
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
   		<form action="cashbooks/receipts" method="POST" enctype="multipart/form-data">
   			<div class="row">
   				<div class="col-xs-12 col-sm-6 col-sm-offset-3">
		   			<div class="form-group">
				      	<label>Lý do:</label>
				      	<input type="text" class="form-control" name="title" required>
				    </div>
				    <div class="form-group">
				    	<label>Ghi chú:</label>
				    	<textarea class="form-control" name="note"></textarea>
				    </div>
				    <div class="form-group">
				      	<label>Số tiền:</label>
				      	<input type="text" class="form-control number" name="price" required>
				    </div>
				    <div class="form-group">
				      	<label>Hình thức:</label>
				      	<div class="clearfix"></div>
				      	<div class="radio">
		                    <label>
		                    	<input type="radio" name="formality" value="amount" checked="checked">
		                     	Tiền mặt
		                    </label>
		                </div>
		                <div class="radio">
		                    <label>
		                    	<input type="radio" name="formality" value="transfer">
		                     	Chuyển khoản
		                    </label>
		                </div>
				    </div>
				    <input type="submit" name="save" class="btn btn-success" value="Thêm mới">
				</div>
			</div>
   		</form>
   	</div>
</div>

<?php if($result_stores){?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Thu ở Chi nhánh</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th>Tiêu đề</th>
					<th>Số tiền</th>
					<th>Hình thức</th>
					<th>Người tạo</th>
					<th>Người duyệt</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th>Chi nhánh</th>
					<th>Tác vụ</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($result_stores as $key => $value) {
				$table = 'cashbook_stores';
				?>
				<tr>
					<td  class="text-center"><?php echo $key+1;?></td>
					<td><?php echo $value->title;?></td>
					<td>
						<?php echo number_format($value->price);?>		
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
					<td><?php echo get_user_name($value->import_id);?></td>
					<td><?php echo get_user_name($value->verify_id);?></td>
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
					<td><?php echo get_store_name($value->store_id);?></td>
					<td>
						<a href="../cashbooks/expenditures/<?php echo $value->id;?>" target="blank" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
						<a href="cashbooks/view/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
						<a href="cashbooks/cashbook_print/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>
						<a href="cashbooks/delete/<?php echo $value->id;?>?table=<?php echo $table;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>
<?php if($results){?>
<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Thu ở Tổng</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th>Tiêu đề</th>
					<th>Số tiền</th>
					<th>Hình thức</th>
					<th>Người tạo</th>
					<th>Người duyệt</th>
					<th>Trạng thái</th>
					<th>Ngày tạo</th>
					<th>Tác vụ</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				foreach ($results as $key => $value) {
				$table = 'cashbooks';
				$i++;	
				?>
				<tr>
					<td  class="text-center"><?php echo $i;?></td>
					<td><?php echo $value->title;?></td>
					<td>
						<?php echo number_format($value->price);?>		
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
	                                    <a class="list-group-item small btn-verify" data-table="cashbooks" data-id="<?php echo $value->id;?>" data-status="0">Chưa duyệt</a>
	                                    <a class="list-group-item small btn-verify" data-table="cashbooks" data-id="<?php echo $value->id;?>" data-status="1">Duyệt</a>
	                                    <a class="list-group-item small btn-verify" data-table="cashbooks" data-id="<?php echo $value->id;?>" data-status="2">Không duyệt</a>
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
						<a href="cashbooks/view/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
						<a href="cashbooks/cashbook_print/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>
						<a href="cashbooks/delete/<?php echo $value->id;?>?table=<?php echo $table;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php } ?>




