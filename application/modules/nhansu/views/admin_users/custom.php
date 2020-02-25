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
               <input type="text" class="form-control number" name="overtime" required value="<?php echo $item->overtime;?>">
            </div>
            <div class="form-group">
               <label>Tiền thưởng:</label>
               <input type="text" class="form-control number" name="bonus" required value="<?php echo $item->bonus;?>">
            </div>
            <div class="form-group">
               <label>Vi phạm nội quy:</label>
               <input type="text" class="form-control number" name="infringe" required value="<?php echo $item->infringe;?>">
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
                  <th>Tăng ca</th>
                  <th>Thưởng</th>
                  <th>Vi phạm nội quy</th>
                  <th>Tác vụ</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($results as $key => $value) { ?>
               <tr>
                  <td><?php echo $key+1;?></td>
                  <td><?php echo $value->month;?></td>
                  <td><?php echo number_format($value->overtime);?></td>
                  <td><?php echo number_format($value->bonus);?></td>
                  <td><?php echo number_format($value->infringe);?></td>
                  <td>
                     <a class="btn btn-xs btn-primary" href="admin_users/custom/<?php echo $value->user_id;?>?id=<?php echo $value->id;?>">
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