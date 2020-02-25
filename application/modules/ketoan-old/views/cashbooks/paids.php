<div class="box box-primary">
	<div class="box-body table-responsive">
		<table class="table table-bordered table-striped table-middle">
			<thead> 
				<tr>
					<th>Chi nhánh</th>
					<?php 
					foreach ($filter as $key => $value) { ?>
					<th>
						<?php 
						echo $key;
						$lists[$key]['count'] = 0;
						?>
					</th>
					<?php } ?>
					<th>Chi nhánh</th>
				</tr>
			</thead>
		  	<tbody>
		  		<?php 
		  		$i = 0;
		  		foreach ($results as $name => $result) {?>
		  		<tr>
		  			<td><?php echo get_store_name($name);?></td>
		  			<?php 
		  			foreach ($filter as $key => $value) {
		  			$date = date('m/d/Y', strtotime($key));?>
		  			<td>
		  				<a href="cashbooks/paid_detail?date_filter=<?php echo $date;?>+-+<?php echo $date;?>&store_id=<?php echo $name;?>&filter=1" target="_blank">
		  				<?php 
		  				echo number_format($result[$key]);
		  				$lists[$key]['count'] += $result[$key];?>
		  				</a>
		  			</td>
		  			<?php } ?>
		  			<td><?php echo get_store_name($name);?></td>
		  		</tr>
		  		<?php } ?>
		  	</tbody>
		  	<tfoot>
		  		<tr>
			  		<th>Tổng</th>
			 		<?php 
			 		$total_new = 0;
			  		foreach ($lists as $key => $value) {
			  		$total_new += $value['count']; ?>
			  		<th><?php echo number_format($value['count']);?></th>
			  		<?php } ?>
			  		<th><?php echo number_format($total_new);?></th>
		  		</tr>
		  	</tfoot>
		</table>
	</div>
</div>



	