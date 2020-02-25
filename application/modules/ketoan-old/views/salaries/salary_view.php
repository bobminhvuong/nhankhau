<div class="box box-primary">
	<div class="box-header">
		<div class="box-title">Thông tin</div>
	</div>
	<div class="box-body row">
     	<div class="col-xs-12 col-sm-6">
     		<p>Người tạo: <?php echo get_user_name($salary->import_id);?></p>
     		<p>Thời gian: <?php echo $salary->created;?></p>
     	</div>
     	<div class="col-xs-12 col-sm-6">
     		<p>Tiêu đề: <?php echo $salary->name;?></p>
     		<p>File: <?php echo $salary->file;?></p>
     	</div>
   	</div>
</div>
<div class="box box-primary">
	<div class="box-body">
		<div class="box-header">
			<div class="box-title">Nội dung</div>
		</div>
		<?php if($results){ ?>
		<div class="table-responsive">
			<table class="table table-bordered tablelte-full">
				<thead>
					<tr>
						<th>STT</th>
						<th>Mã</th>
						<th>Họ tên</th>
						<th>CN</th>
						<th>Chức vụ</th>
						<th>Ngày làm cơ bản</th>
						<th>Số ngày làm việc</th>
						<th>Lương cơ bản</th>
						<th>BQ</th>
						<th>Lương theo số ngày</th>
						<th>Phụ cấp trách nhiệm</th>
						<th>Phụ cấp cơm</th>
						<th>HHDV/HH Doanh số</th>
						<th>HHSP/ HH học viên</th>
						<th>HHDV (4%)</th>
						<th>HHDV phụ</th>
						<th>Tư vấn DV+SP quản lý</th>
						<th>Tăng Ca</th>
						<th>Thưởng</th>
						<th>Tổng lương</th>
						<th>Các khoản khấu trừ</th>
						<th>Vi phạm</th>
						<th>Thực lãnh</th>
					</tr>
				</thead>
			  	<tbody>
			  		<?php 
			  		$i = 0;
			  		foreach ($results as $key => $value) { 
			  		$i++;?>
			  		<tr>
			  			<td class="text-center">
							<?php echo $i;?>
			  			</td>
			  			<!--td><?php echo $key;?></td-->
			  			<?php for ($j = 1; $j <= 22; $j++) { ?>
			  			<td>
			  				<?php 
			  				if (is_numeric($value[$j])) {
			  					echo number_format($value[$j]);
			  				}else{
			  					echo $value[$j];
			  				}
			  				?>	
			  			</td>
			  			<?php } ?>
			  		</tr>
			  		<?php } ?>
			  	</tbody>
			</table>
		</div>
		<?php } else{ ?>
		<h4>Không có dữ liệu</h4>
		<?php } ?>
	</div>
</div>


	