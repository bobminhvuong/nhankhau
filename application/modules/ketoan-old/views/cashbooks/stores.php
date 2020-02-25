<div class="box box-primary">
	<div class="box-header">
     	<form action="" method="GET" role="form">
     		<div class="form-inline">
	        	<div class="form-group">
	                <div class="input-group">
	                    <div class="input-group-addon">
	                        <i class="fa fa-calendar"></i>
	                    </div>
	                    <input id="reportrange" name="date_filter" class="pull-right" data-start="<?php echo $start;?>" data-end="<?php echo $end;?>">
	                </div>
	            </div>
	           
	            <div class="form-group">
	                <select class="form-control select2" name="status">
	          			<option <?php if($stt == 'all') echo 'selected="selected"';?> value="all">Tất cả</option>
	                	<option <?php if($stt == 'verify') echo 'selected="selected"';?> value="verify">Đã duyệt</option>
	                	<option <?php if($stt == 'none') echo 'selected="selected"';?> value="none">Chưa duyệt</option>
	                </select>
	            </div>
        	</div>
        	<div class="form-group" style="margin: 10px 0">
                <select class="form-control select2" name="store_id[]" multiple="multiple">
                	<?php foreach(all_spas() as $spa){ ?>
                	<option <?php if(in_array($spa->id, $store_id)) echo 'selected="selected"';?> value="<?php echo $spa->id;?>"><?php echo $spa->description;?></option>
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

<?php if($list_stores){
foreach ($list_stores as $key => $store) { ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="box-title"><?php echo get_store_name($key);?></div>
		</div>
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
						<th>Tên người duyệt</th>
						<th>Người duyệt</th>
						<th>Trạng thái</th>
						<th>Ngày tạo</th>
						<th>Tác vụ</th>
					</tr>
				</thead>
				<?php if($store['results']){?>
				<tbody>
					<?php 
					$total_paid = 0;
					foreach ($store['results'] as $key => $value) {

					if($value->type == 'expenditures' && $value->type_id !=1){
						$total_paid+= $value->price;
					}
					?>
					<tr>
						<td  class="text-center"><?php echo $key+1;?></td>
						<td>
							<?php echo $value->title;?>
							<?php if($value->file != ''){?>
							<a href="<?php echo base_url()?>assets/uploads/certificates/<?php echo $value->file;?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
							<?php } ?>
						</td>
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
						<td><?php echo $value->verify_name;?></td>
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
							<a href="cashbooks/view/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
							<a href="cashbooks/cashbook_print/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>
							<?php if(is_admin()){ ?>
							<a href="cashbooks/delete/<?php echo $value->id;?>?table=<?php echo $table;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4" class="text-right">Tổng chi</th>
						<th><?php echo number_format($total_paid);?></th>
					</tr>
				</tfoot>
				<?php } ?>
			</table>
		</div>
	</div>
<?php }} ?>


<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Tồn cuối</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Chi nhánh</th>
					<th>Tiền mặt</th>
					<th>Tài khoản</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$all_spa_amount = $all_spa_transfer = 0;
				foreach (all_spas() as $key => $spa) {
				$CI = get_instance();
				$spas_amount = $CI->db->query("SELECT * FROM cashbook_revenues WHERE date = '".date('Y-m-d')."' AND type = 'amount' AND store_id = ".$spa->id." ")->row();
				$spas_transfer = $CI->db->query("SELECT * FROM cashbook_revenues WHERE date = '".date('Y-m-d')."' AND type = 'transfer'  AND store_id = ".$spa->id." ")->row(); ?>
				<tr>
					<td><?php echo $spa->description;?></td>
					<td><?php 
					$all_spa_amount += $spas_amount->end;
					echo number_format($spas_amount->end);
					?></td>
					<td><?php 
					$all_spa_transfer += $spas_transfer->end;
					echo number_format($spas_transfer->end);?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="text-right">Tổng</th>
					<th><?php echo number_format($all_spa_amount);?></th>
					<th><?php echo number_format($all_spa_transfer);?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

