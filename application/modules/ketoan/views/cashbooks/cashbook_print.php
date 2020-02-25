
<?php 
if($result->type == 'expenditures'){
	$code = 'PC'.$result->id;
	$type = 'PHIẾU CHI';
	$verify_name = get_user_name($result->verify_id);
	if($result->verify_status == 1){
		$status = 'Đã duyệt <small>('.date('d-m-Y H:i:s', strtotime($result->verify_time)).')</small>';
	}else{
		$status = 'Chưa duyệt';
	}
}else if($result->type == 'receipts'){
	$code = 'PT'.$result->id;
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


<style>
@page {
    size: auto;
    margin: 0;
}
html{
	padding: 0;
	position: relative;
}
#header, #footer{
	position: absolute;
	width: 100%;
	left: 0;
	right: 0;
}
#header{
	top: .5cm;
}
#footer{
	bottom: .5cm;
}
.col{
	width: 50%;
	float: left;
}
body{
	margin: 4cm 1cm 3cm 1cm;
}
table{
	width: 100%;
	font-size: 13px;
}
tr{
	border-bottom: solid 1px #8682825c;
    display: block;
    padding: 10px 0;
    overflow: hidden;
}
tr td:nth-child(1){
	float: left;
}
tr td:nth-child(2){
	float: right;
}
h2{
	font-size: 20px;
}
h4,h5{
	margin: 0;
	font-weight: 600;
}
h4{
	font-size: 18px;
}
h5{
	font-size: 16px;
}

</style>
<html>
<body>
	<div id="header">
		<img src="<?php echo base_url('assets/images/header.png');?>" width="100%">
	</div>
	<h2 style="text-align:center; margin-top: 0"><?php echo $type;?></h2>
	<div class="col">
		<p>Người tạo: <?php echo get_user_name($result->import_id);?></p>
		<p>Ngày tạo: <?php echo date('d-m-Y H:i:s', strtotime($result->created));?></p>
		<!--p>Điện thoại: <?php echo get_customer_phone($invoice->customer_id);?></p-->
		
	</div>
	<div class="col">
		<p>Mã: <?php echo $code;?></p>
		<p>Nguồn: <?php echo $source;?></p>
	</div>
	<table>
		
		<tr>
			<td>Lý do</td>
			<td><?php echo $result->title;?></td>
		</tr>
		<tr>
			<td>Nội dung</td>
			<td><?php echo $result->note;?></td>
		</tr>
		<?php if(isset($type_name)){ ?>
		<tr>
			<td>Loại</td>
			<td><?php echo $type_name;?></td>
		</tr>
		<?php } ?>
		<tr>
			<td>Số tiền</td>
			<td><?php echo number_format($result->price);?></td>
		</tr>
		<tr>
			<td>Hình thức</td>
			<td><?php echo $formality;?></td>
		</tr>
		<tr>
			<td>Chứng từ</td>
			<td><?php echo $result->file!=''?'Có chứng từ':'Không có';?></td>
		</tr>
		<?php if($result->type == 'expenditures'){ ?>
		<tr>
			<td>Người duyệt</td>
			<td><?php echo $verify_name;?></td>
		</tr>
		<tr>
			<td>Trạng thái</td>
			<td><?php echo $status;?></td>
		</tr>
		<?php } ?>
	</table>
	<div id="footer">
		<img src="<?php echo base_url('assets/images/footer.png');?>" width="100%">
	</div>
</body>
</html>
<script>
function myFunction() {
    window.print();
}
window.onload = myFunction;
</script>