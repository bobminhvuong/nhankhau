<?php  $store_id = $this->session->userdata('store')?$this->session->userdata('store'):1;
	$nation_id = $this->session->userdata('nation')?$this->session->userdata('nation'):1;
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $nation_id==1? 'Đánh giá':'វាយតម្លៃ' ;?></title>
	<base href="<?php echo base_url();?>">
	<link rel="stylesheet" href="assets/awesome/font-awesome.min.css">
	<link rel="stylesheet" href="assets/Roboto.css">
	<link rel="stylesheet" href="assets/sticky.css">
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="assets/sweetalert/css/sweetalert2.min.css">

	<script src='assets/jQuery/jQuery-2.1.4.min.js'></script>
	<script src='assets/sweetalert/js/sweetalert2.min.js'></script>
	
	
</head>
<?php if($this->session->userdata('success')){ ?>
<script>
$(document).ready(function() {
	swal(
		'<?php echo $nation_id==1?'Thành công!':'បានជោគជ័យ';?>',
		'<?php echo $nation_id==1?'Xin cám ơn quý khách!':'បានជោគជ័យ';?>',
		'success'
	);			
});
</script>
<?php 
$this->session->unset_userdata('success');
} ?>
<body>
	<header class="text-center">
		<a href=""><img src="assets/images/logo<?php echo $nation_id==1?'':'_cpc' ;?>.png"></a>
	</header>
  	<section class="text-center">
  		<img src="assets/images/banner<?php echo $nation_id==1?'':'_cpc' ;?>.png" style="width: 100%">
  	</section>
  	<a href="index.php/store" target="_blank">
  	<footer class="text-center">
  		<?php echo $nation_id==1? 'Cám ơn quý khách đã sử dụng dịch vụ':'សូមអរគុណអតិថិជនដែលបានប្រើប្រាស់សេវ៉ាកម្';?>
  	</footer>
  	</a>
</body>
</html>

<script type="text/javascript">
	var do_alert = function(){
	    location.reload();
	};
	//setTimeout(do_alert, 5000);
</script>
