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

td{
	padding: 10px;
}
tr td:nth-child(1){
	width: 100px;

}
tr td:nth-child(2){
	
}
tr td:nth-child(3){
	width: 100px;
	
}
tr td:nth-child(4){
	width: 100px;
	
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
	<h2 style="text-align:center; margin-top: 0">PHIẾU XUẤT KHO</h2>
	<div class="col">
		<p>Chi nhánh: <?php echo get_store_name($item->store);?></p>
	</div>
	<table border="1|0">
		<tr>
			<td>STT</td>
			<td>TÊN SẢN PHẨM</td>
			<td>SỐ LƯỢNG</td>
			<td>QUY CÁCH</td>
		</tr>
		<?php foreach($results as $key => $value){ ?>
		<tr>
			<td><?php echo $key+1;?></td>
			<td><?php echo get_product_name($value->item_id);?></td>
			<td><?php echo $value->quantity;?></td>
			<td></td>
		</tr>
		<?php } ?>
	</table>
	<p style="text-align: right">Ngày <?php echo date('d', strtotime($item->created));?> tháng <?php echo date('m', strtotime($item->created));?> năm <?php echo date('Y', strtotime($item->created));?></p>
	<div class="col" style="text-align: center">
		<p>Người kiểm hàng</p>
	</div>
	<div class="col" style="text-align: center">
		<p>Người lập</p>
		<p></p>
		<p></p>
		<p><?php echo get_user_name($item->import_id);?></p>
	</div>
	<!-- <div id="footer">
		<img src="<?php echo base_url('assets/images/footer.png');?>" width="100%">
	</div> -->
</body>
</html>
<script>
function myFunction() {
    window.print();
}
window.onload = myFunction;
</script>