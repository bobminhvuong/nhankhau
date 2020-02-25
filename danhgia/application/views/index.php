<?php  $store_id = $this->session->userdata('store')?$this->session->userdata('store'):1;
	$nation_id = $this->session->userdata('nation')?$this->session->userdata('nation'):1;
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $nation_id==1? 'Đánh giá':'វាយតម្លៃ';?></title>
	<base href="<?php echo base_url();?>">
	<link rel="stylesheet" href="assets/awesome/font-awesome.min.css">
	<link rel="stylesheet" href="assets/Roboto.css">
	<link rel="stylesheet" href="assets/sticky.css">
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="assets/sweetalert/css/sweetalert2.min.css">

	<script src='assets/jQuery/jQuery-2.1.4.min.js'></script>
	<script src='assets/sweetalert/js/sweetalert2.min.js'></script>
	
	
</head>
<body>
	<header class="text-center">
		<a href=""><img src="assets/images/logo<?php echo $nation_id==1?'':'_cpc' ;?>.png"></a>
	</header>
	<div class="customers">
		<p><span><?php echo $nation_id==1? 'Tên Khách Hàng:':'ឈ្មោះអតិថិជន:';?></span> <?php echo $customer->name;?></p>
		<p><span><?php echo $nation_id==1? 'Số phiếu thu:':'លេខប័ណ្ណចំនូល:'; ?></span> <?php echo $invoice->id;?></p>
		<p><span><?php echo $nation_id==1? 'Tổng:':'សរុប:';?></span> <?php echo $nation_id==1? number_format($invoice->total).' đ':number_format($invoice->total/100).' $';?></p>
	</div>
  	<section class="stars">
	    <form action="" class="text-center" method="post">
	    	<div class="list-star">
		    	<input class="star star-5" id="star-5" type="radio" name="star" value="5" required />
		    	<label class="star star-5" for="star-5"></label>
		    	<input class="star star-4" id="star-4" type="radio" name="star" value="4"  required />
		    	<label class="star star-4" for="star-4"></label>
		    	<input class="star star-3" id="star-3" type="radio" name="star" value="3"  required />
		    	<label class="star star-3" for="star-3"></label>
		    	<input class="star star-2" id="star-2" type="radio" name="star" value="2"  required />
		    	<label class="star star-2" for="star-2"></label>
		    	<input class="star star-1" id="star-1" type="radio" name="star" value="1"  required />
		    	<label class="star star-1" for="star-1"></label>
	    	</div>
	    	<div class="clearfix"></div>
	    	<!--p class="description">Bạn đánh giá 1 sao</p-->
	    	<input type="hidden" name="id" value="<?php echo $invoice->id;?>">
	    	<textarea placeholder="<?php echo $nation_id==1? 'Nội dung':'មាតិកា:';?>" name="content"></textarea>
	    	<input type="submit" name="send" value="<?php echo $nation_id==1? 'Gửi đi':'បញ្ចូនទៅ:'; ?>">
	    </form>
  	</section>
  	<a href="index.php/store" target="_blank">
  	<footer class="text-center">
	  <?php echo $nation_id==1? 'Cám ơn quý khách đã sử dụng dịch vụ':'សូមអរគុណអតិថិជនដែលបានប្រើប្រាស់សេវ៉ាកម្:';?>
  	</footer>
  	</a>
</body>
</html>
