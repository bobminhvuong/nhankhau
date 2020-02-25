
<?php 
    $param = 'chamcong/store_report?date_filter='.$start.'-'.$end.'&store_id='.$store_id.'&user_id='.$user_id.'&filter=1&page=' ;
        $total_page = intval($all_staff_of_store->total/$limit) + 1;
    
        //echo $total_page.' '.($all_staff_of_store->total) ;
?>

<div class="box box-primary">
    <div class="box-header">
        <form action="" method="GET" class="form-inline" role="form">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input id="reportrange" name="date_filter" class="pull-right" data-start="<?php echo $start;?>" data-end="<?php echo $end;?>">
                </div>
            </div>
            <div class="form-group">
                <select class="form-control select2" name="store_id" id="store_id">
                    
                    <?php foreach($all_stores as $value){?>
                    <option <?php echo ($store_id==$value->id)?'selected="selected"':'';?> value="<?php echo $value->id;?>"><?php echo $value->description;?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control select2" id="user_id" name="user_id" style="min-width: 120px;">
                    <option value="">Nhân viên</option>
                    <?php foreach($all_staff_option->data as $st){?>
                    <option <?php echo ($user_id==$st->id)?'selected="selected"':'';?> value="<?php echo $st->id;?>"><?php echo $st->name;?></option>
                    <?php } ?>
                    
                </select>
            </div>
            <div class="form-group">
                <input type="hidden" name="filter" value="1">
                <button type="submit" class="form-control btn-primary">Hiển thị</button>
            </div>
        </form>
        <?php if($user_id>0) { ?>

            <i style="float: right;" class="btn fa fa-plus fa-2x text-success" data-toggle="modal" data-target="#add_chamcong"></i> 
            <i style="float: right; margin-top: 0.5em;" class="text-info"><?php echo isset($submit_add)?$submit_add->message:'' ;?></i> 
            <!-- Modal -->
                <div id="add_chamcong" class="modal fade" role="dialog" style="padding-right: 17px;">
                    
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="float: left;">Thêm chấm công thủ công</h4>
                        <h4 id="cus-info" style="float: right;margin-top: .5em;color: red;"></h4>
                        <div id="mes_ajax"></div>
                      </div>
                      <form class="form" method="post">
                      <div class="modal-body">
                            
                                                        <input type="hidden" name="user_id_add" value="<?php echo $user_id ;?>">
                                                        <input type="hidden" name="store_id_add" value="<?php echo $store_id ;?>">
                                                        <div class="form-group">
                                                            <label for="name_add">Nhân viên</label>
                                                            <input readonly type="text" name="name_add" class="form-control input-sm" value="<?php echo get_user_name($user_id);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name_store_add">Chi nhánh</label>
                                                            <input readonly type="text" name="name_store_add" class="form-control input-sm" value="<?php echo get_store_name($store_id);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="shift_add">Ca làm việc</label>
                                                            <select class="form-control" name="shift_add">
                                                            <?php foreach($all_shifts as $shift){?>
                                                            <option  value="<?php echo $shift->id;?>"><?php echo $shift->name.'  '.$shift->begin.' -> '.$shift->end;?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="is_off_add">
                                                            <label class="form-check-label" for="is_off_add">OFF</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="date">Ngày</label>
                                                            <input type="text" class="form-control datepicker" name="date" value="<?php echo date('Y/m/d');?>" style="width: 100px">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="begin_add">Giờ vào</label>
                                                            <input type="text" name="begin_add" class="form-control input-sm" value="<?php echo date('d/m/Y H:i:s');?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="end_add">Giờ ra</label>
                                                            <input type="text" name="end_add" class="form-control input-sm" value="<?php echo date('d/m/Y H:i:s');?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="reason_add">Lý do</label>
                                                            <input type="text" name="reason_add" class="form-control input-sm" placeholder="Nhập lý do"  value="">
                                                        </div>
                      </div>
                      <div class="modal-footer">
                          <input type="submit" name="submit_add" class="btn btn-sm btn-success" value="Thêm"></input>
                        
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                
        <?php } ?>
    </div>
</div>

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Tổng</h3>
    </div>
    <div class="box-body no-padding">
        <div class="row">
            <?php   
                $total_time_plan = $total_time_real = $total_time_difference = $total_time_late = $total_time_early = $total_off = 0;

            ?>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_time_plan;?></h5>
                            <a href="#"><span class="description-text">Tổng thời gian làm việc theo lịch</span></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo '0';?></h5>
                            <a href="#"><span class="description-text">Số ngày công</span></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_time_late;?></h5>
                            <a href="#"><span class="description-text">Tổng thời gian đi trễ</span></a>
                        </div>
                   </div>
                   <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_time_real;?></h5>
                            <a href="#"><span class="description-text">Tổng thời gian làm việc thực tế</span></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_off;?></h5>
                            <a href="#"><span class="description-text">Số ngày off</span></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_time_early;?></h5>
                            <a href="#"><span class="description-text">Tổng thời gian về sớm</span></a>
                        </div>
                   </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_time_difference;?></h5>
                            <a href="#"><span class="description-text">Tổng chênh lệch</span></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo '';?></h5>
                            <a href="#"><span class="description-text"></span></a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="description-block border-right">
                            <h5 class="description-header"><?php echo $all_staff_of_store->total_times_late.' / '.$all_staff_of_store->total_times_early;?></h5>
                            <a href="#"><span class="description-text">Tổng số lần đi trễ / Về sớm</span></a>
                        </div>
                   </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div  id="piechart" style="width: 100%; 
  min-height: 350px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-body table-responsive">
        
        <a href="<?php echo $param.'&export=1';?>" target="_blank" data-ci-pagination-page="1"><button class="btn btn-success">Xuất excel</button></a>
        <table class="table"> 
            <thead>
                <tr>
                    <th class="text-center">STT</th>
                    <th>ID</th>
                    <th>Ngày</th>
                    <th>Nhân viên</th>
                    <th>Ca làm việc</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Ghi chú</th>
                    <th>Hình phạt</th>
                    <th>Phạt phát sinh</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                foreach ($all_staff_of_store->data as $key => $value) { 
                $style = '';
                ?>
                                <tr  style="<?php echo ($value->edit_reason!='')?'background-color: silver;':''?>
                                ">
                                <td class="text-center">
                                    <span class="btn btn-xs btn-primary" data-toggle="collapse" data-target="#<?php echo (50*($current_page-1)+$i);?>"><?php echo (50*($current_page-1)+$i);?></span>
                                </td>
                                <td>
                                    <?php echo $value->id; ?>
                                </td>
                                <td>
                                    <?php echo $value->date; echo ($value->edit_reason!='')?'<br>'.$value->edit_reason:''?>
                                </td>
                                <td class="<?php echo ($value->isworkout&&$value->isworkout==1)?'text-danger':'';?>"><?php echo $value->name ;echo ($value->isworkout&&$value->isworkout==1)? ('<br>'.$value->store_name).' - công tác':'';?>
                                    
                                </td>
                                
                                <td>
                                    <?php echo $value->shift_name;?>
                                </td>
                                <td>
                                    <?php echo $value->checkin;?>
                                </td>
                                <td>
                                    <?php echo $value->checkout;?>
                                </td>
                                <td class="text-danger">
                                    <?php echo $value->status;?>
                                </td>
                                <td>
                                    <?php echo $value->penalties_auto;?>
                                </td>
                                <td>
                                    <?php echo $value->penalties;?>
                                </td>
                            </tr>
                                <tr id="<?php echo (50*($current_page-1)+$i);?>" class="collapse" style="background: #cfcfcf">
                                <td colspan="10">
                                    <form class="form-inline form-shift-manager" method="post">
                                        <input type="hidden" name="id" value="<?php echo $value->id;?>">
                                        <input type="hidden" name="shift_name" value="<?php echo $value->shift_id;?>">
                                        <div class="form-group">
                                            <small>Ca làm việc</small><br>
                                            <select class="form-control" name="shift">
                                           
                                            <?php foreach($all_shifts as $shift){?>
                                            <option <?php echo ($value->shift_id==$shift->id)?'selected="selected"':'';?> value="<?php echo $shift->id;?>"><?php echo $shift->name;?></option>
                                            <?php } ?>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <small>Giờ vào</small><br>
                                            <input required type="text" name="begin" class="form-control input-sm" value="<?php echo $value->checkin_full;?>">
                                        </div>
                                        <div class="form-group">
                                            <small>Giờ ra</small><br>
                                            <input type="text" name="end" class="form-control input-sm" value="<?php echo $value->checkout_full;?>">
                                        </div>
                                        <div class="form-group">
                                            <small>Lý do</small><br>
                                            <input required type="text" name="reason" class="form-control input-sm" placeholder="Bắt buộc nhập lý do"  value="<?php echo $value->edit_reason;?>">
                                        </div>
                                        <div class="form-group">
                                            <small>Số tiền phạt</small><br>
                                            <input required type="number" name="penalties" class="form-control input-sm" placeholder=""  value="<?php echo $value->penalties;?>">
                                        </div>
                                        <div class="form-group pull-right">
                                            <small>Tác vụ</small><br>
                                            <input type="submit" name="submit_edit" class="btn btn-sm btn-success" value="Cập nhật"></input>
                                            <input type="submit" name="submit_delete" class="btn btn-sm btn-danger" value="Xóa"></input>
                                            
                                        </div>
                                        
                                    </form>
                                    
                                </td>
                                </tr>
                            <?php $i++;
                } ?>
            </tbody>
            <tfoot>
                <tr>
                    
                    
                </tr>
            </tfoot>

        </table>
        <?php 
            if($total_page>1){
        ?>
        <ul class="pagination pull-right">
            <ul class="pagination">
                <li><a href="<?php echo $param.'1';?>" data-ci-pagination-page="1">«</a></li>
                <li class="pg-prev" ><a <?php echo $current_page==1?'disabled':'';?> href="<?php echo $param;echo($current_page-1)>0?($current_page-1):1;?>" data-ci-pagination-page="<?php echo $param;echo($current_page-1)>0?($current_page-1):1;?>" rel="prev">Trang trước</a></li>
                
                <li class="active"><a href="javascript:void(0);"><?php echo($current_page);?></a></li>
               
                <li class="pg-next"><a href="<?php echo $param;echo($current_page+1)<$total_page?($current_page+1):$total_page;?>" data-ci-pagination-page="4" rel="next">Trang tiếp</a></li>
                <li><a href="<?php echo $param;echo($total_page);?>" data-ci-pagination-page="27">»</a></li>
            </ul>        
        </ul>
        <?php }?>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Thời gian', 'theo %'],
  ['<?php echo isset($all_staff_of_store->total_time_real_percent) ? round((float)($all_staff_of_store->total_time_real_percent),2,PHP_ROUND_HALF_UP) : '';?> % Tổng giờ làm', <?php echo isset($all_staff_of_store->total_time_real_percent) ? $all_staff_of_store->total_time_real_percent : 4;?>],
  ['<?php echo isset($all_staff_of_store->total_time_late_percent) ? round($all_staff_of_store->total_time_late_percent,2) : 3;?> % Tổng đi trễ',  <?php echo isset($all_staff_of_store->total_time_late_percent) ? $all_staff_of_store->total_time_late_percent : 3;?>],
  ['<?php echo isset($all_staff_of_store->total_time_early_percent) ? round($all_staff_of_store->total_time_early_percent,2) : 2;?> % Tổng về sớm', <?php echo isset($all_staff_of_store->total_time_early_percent) ? $all_staff_of_store->total_time_early_percent : 2;?>],
  ['<?php echo isset($all_staff_of_store->total_off_percent) ? round($all_staff_of_store->total_off_percent,2) : 0;?> % Tổng off', <?php echo isset($all_staff_of_store->total_off_percent) ? $all_staff_of_store->total_off_percent : 0;?>]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {pieSliceText: 'percentage',theme: 'material',legend: {position:'bottom',maxLines:2}};


  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
$(window).resize(function(){
  drawChart();

  //drawChart2();
});
$( "#store_id" ).change(function() {
    $('#user_id').empty();
    var selected_val = $(this).children("option:selected").val();
    try{
      $.ajax({
      url: ('chamcong/ajax_change_store/'+selected_val.toString()),
      data: {store_id: selected_val}, 
      type: 'POST',  
      datatype: 'json', 
      success: function(data){ 
        $('#user_id').empty();
        var option = '<option value="">Nhân viên</option>';
        
        $.each($.parseJSON(data),function(key, value){
          option += "<option value='"+value['id']+"'>"+value['name']+"</option>"
        })
        $("#user_id").html(option);
        }
      });
    }
    catch{}
});
jQuery(window).load(function () {
    setTimeout(function () {
        <?php 
            if(isset($submit_edit)){
                if($submit_edit->status==1) echo 'toastr["success"]("'.$submit_edit->message.'");';
                else echo 'toastr["error"]("'.$submit_edit->message.'");';
            }
        ?>
    }, 1000);

});
</script>

<!-- <script type="text/javascript">
jQuery(document).ready(function($) {
    $(".form-users-update").on( "submit", function(event) {
        event.preventDefault();
        var data = $(this).serialize();
        console.log(data);
        $.ajax({
            url: "admin_users/ajax_update",
            type: "POST",
            dataType: "text",
            data: {'data': data},
            success: function(res){
                toastr["success"]("Cập nhật thành công");
                console.log(res);
            },
            error: function(err){
                toastr["error"]("Lỗi, nội dung chưa được gửi đi");
            }
        });
    });
});
</script> -->

