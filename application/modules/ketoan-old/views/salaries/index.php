<?php if(isset($item)){ ?>
<div class="box box-primary">
   <div class="box-header">
      <div class="box-title">Tháng: <?php echo $item->month;?></div>
   </div>
   <div class="box-body">
      <form action="" method="POST" enctype="multipart/form-data">
         <div class="col-xs-12 col-sm-6 col-sm-offset-3">
            <input type="hidden" name="id" value="<?php echo $item->id;?>">
            <div class="form-group">
               <label>Tăng ca:</label>
               <input type="text" class="form-control number" name="count_day" required value="<?php echo $item->count_day;?>">
            </div>
            <input type="submit" name="save" class="btn btn-success" value="Thêm mới">
         </div>
      </form>
   </div>
</div>
<?php } ?>

<div class="box box-primary">
   <?php if($results){ ?>
   <div class="box-body">
      <div class="table-responsive">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>STT</th>
                  <th>Tháng</th>
                  <th>Số ngày làm việc</th>
                  <th>Tác vụ</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($results as $key => $value) { ?>
               <tr>
                  <td><?php echo $key+1;?></td>
                  <td><?php echo $value->month;?></td>
                  <td><?php echo $value->count_day;?></td>
                  <td>
                     <a class="btn btn-xs btn-primary" href="salaries/index/<?php echo $value->id;?>">
                        <i class="fa fa-pencil"></i>
                     </a>
                  </td>
               </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>
   <?php } ?>     
</div>