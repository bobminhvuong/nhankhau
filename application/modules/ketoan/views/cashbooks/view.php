<div class="box box-primary">
	<div class="box-body">
		<?php if($result){
		if($result->type == 'expenditures'){
			$type = 'PHIẾU CHI';
			$verify_name = get_user_name($result->verify_id);
			if($result->verify_status == 1){
				$status = 'Đã duyệt <small>('.date('d-m-Y H:i:s', strtotime($result->verify_time)).')</small>';
			}else{
				$status = 'Chưa duyệt';
			}
		}else if($result->type == 'receipts'){
			$type = 'PHIẾU THU';
		}

		if(isset($result->store_id)){
			$source = 'Chi nhánh '.get_store_name($result->store_id);
		}else{
			$source = 'Tổng công ty';
		}

		if($result->type_id != 0){
			if($result->type_id == 1){
				$type_name = 'Chi về Tổng công ty';
			}else if($result->type_id == 2){
				$type_name = 'Chi về chi nhánh '.get_store_name($result->store);
			}else{
				$type_name = $this->_type[$result->type_id];
			}
		}

		if($result->formality == 'amount'){
			$formality = 'Tiền mặt';
		}else if($result->formality == 'transfer'){
			$formality = 'Chuyển khoản';
		}

		if($result->file != ''){
			$file = '<a href="../assets/uploads/certificates/'.$result->file.'">'.$result->file.'</a>';
		}else{
			$file = 'Không có chứng từ';
		}

		?>
 		<h4><?php echo $type;?></h4>	
 		<div class="row">
 			<div class="col-xs-12 col-sm-6">
 				<p>Nguồn: <b><?php echo $source;?></b></p>
		        <p>Lý do: <?php echo $result->title;?></p>
		        <p>Nội dung: <?php echo $result->note;?></p>
		        <?php if(isset($type_name)){?>
		        <p>Loại: <b><?php echo $type_name;?></b></p>
		    	<?php } ?>
		        <p>Số tiền: <b><?php echo number_format($result->price);?></b></p>
		        <p>Hình thức: <?php echo $formality;?></p>
		        <p>Chứng từ: <?php echo $file;?></p>
 			</div>
 			<div class="col-xs-12 col-sm-6">
 				<p>Người tạo: <?php echo get_user_name($result->import_id);?></p>
 				<p>Ngày tạo: <?php echo date('d-m-Y H:i:s', strtotime($result->created));?></p>
 				<?php if(isset($verify_name)){?>
 				<p>Người duyệt: <?php echo $verify_name;?></p>
 				<?php } ?>
 				<?php if(isset($status)){?>
 				<p>Trạng thái: <?php echo $status;?></p>
 				<?php } ?>
 			</div>
 		</div>
        
    	<?php } else{ ?>
    	<h4>Không tìm thấy thông tin</h4>
    	<?php } ?>
   	</div>
</div>