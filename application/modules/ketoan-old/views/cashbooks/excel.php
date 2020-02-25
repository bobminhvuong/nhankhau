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
<?php if(isset($results)){ ?>

<div class="box box-primary">
	<div class="box-header">
		<!-- <div class="box-title">Tồn đầu tiền mặt <?php echo date('d-m-Y', strtotime($start));?>: <?php echo number_format($start_amount);?></div><br>
		<div class="box-title">Tồn đầu chuyển khoản <?php echo date('d-m-Y', strtotime($start));?>: <?php echo number_format($start_transfer);?></div><br> -->
		<div class="box-title">Tồn đầu Tổng: <?php echo date('d-m-Y', strtotime($start));?>: <?php echo number_format($start_amount);?></div>
	</div>
	<div class="box-body table-responsive">
		<table class="table tablelte-excel">
			<thead>
				<tr>
					<th class="text-center">STT</th>
					<th>Ngày</th>
					<th>Tiêu đề</th>
					<th>Ghi chú</th>
					<th>Loại</th>
					<th>Thu</th>
					<th>Chi</th>
					<th>Tồn</th>
					<th>Người tạo</th>
					<th>Người duyệt</th>
					<th>Tác vụ</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i = 0;
				$tong = $start_amount;
				foreach ($results as $key => $value) {
				$table = 'cashbooks';
				if($value->formality == 'amount'){
				$i++;
				?>
				<tr <?php if($value->import_id == $value->verify_id) echo 'style="background: #CCC"';?>>
					<td  class="text-center"><?php echo $i;?></td>
					<td>
						<?php echo date('d-m-Y', strtotime($value->created));?>
					</td>
					<td>
						<?php echo $value->title;?>
						<?php if($value->file != ''){?>
						<a href="<?php echo base_url()?>assets/uploads/certificates/<?php echo $value->file;?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i></a>
						<?php } ?>
					</td>
					<td>
						<?php echo $value->note;?>
					</td>
					<td>
						<?php
						if(isset($value->store_id)){
							$table = 'cashbook_stores';
							if($value->type == 'expenditures') echo '<span class="label label-primary">Thu_'.get_store_name($value->store_id).'</span>';
							$tong += $value->price;
							$type = 'thu';
						}else{
							if($value->type == 'expenditures'){ 
								echo '<span class="label label-warning">Chi</span>';
								$tong -= $value->price;
								$type = 'chi';
							}
							else if($value->type == 'receipts'){ 
								echo '<span class="label label-primary">Thu</span>';
								$tong += $value->price;
								$type = 'thu';
							}
						}
						?>
					</td>
					<!-- <td><?php echo number_format($value->price);?></td> -->
					<?php if($type == 'thu'){ ?>
					<td><?php echo number_format($value->price);?></td>
					<td></td>
					<?php } else if($type == 'chi') { ?>
					<td></td>
					<td><?php echo number_format($value->price);?></td>
					<?php } ?>
					<td><?php echo number_format($tong);?></td>
					<td>
						<?php 
						echo get_user_name($value->import_id);
						echo '<br>';
						echo '<small>',date('d/m/Y H:i:s', strtotime($value->created)).'<small>';
						?>		
					</td>
					<td><?php echo get_user_name($value->verify_id);?></td>
					<td>
						<a href="cashbooks/view/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
						<a href="cashbooks/cashbook_print/<?php echo $value->id;?>?table=<?php echo $table;?>" target="blank" class="btn btn-xs btn-primary"><i class="fa fa-print"></i></a>
						<a href="cashbooks/delete/<?php echo $value->id;?>?table=<?php echo $table;?>" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
				<?php }} ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="7" class="text-right">Tổng tồn</th>
					<th>
						<?php
						echo number_format($tong);
						?>		
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?php } ?>

