<!doctype html>
<html>

<body>
	<form action="" method="post">
		<select name="store">
			<?php foreach ($stores as $value) { ?>
			<option <?php echo ($store_id == $value->id)?'selected="selected"':'';?> value="<?php echo $value->id;?>"><?php echo $value->description;?></option>
			<?php } ?>
		</select>
		<input type="submit" name="submit" value="Chọn chi nhánh">
	</form>
	<a href="<?php echo base_url();?>">Trở về</a>
</body>
</html>

