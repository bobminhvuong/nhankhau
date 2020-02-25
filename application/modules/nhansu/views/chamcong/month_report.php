<?php $param = 'chamcong/month_report?date_filter='.$start.'-'.$end.'&store_id='.$store_id.'&filter=1' ;?>
<div class="box box-primary">
    <div class="box-header">
        <form action="" method="GET" class="form-inline" role="form" name="form_get_month_report">
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
                    
                    <?php foreach(all_spas() as $value){?>
                    <option <?php echo ($store_id==$value->id)?'selected="selected"':'';?> value="<?php echo $value->id;?>"><?php echo $value->description;?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <input type="hidden" name="filter" value="1">
                <button type="submit" class="form-control btn-primary">Xuất Excel</button>
            </div>
        </form>

    </div>
    <?php if(isset($month_report)){?>
    <div id="download">
        <h3 class="text-center text-success">File excel sẽ được tải tự động trong <i id="giay">5</i> giây. Nếu không tải được vui lòng click vào <a target="_blank" href="<?php echo $month_report->download_url;?>">đây!</a></h3><div style="height: 1em;"></div>
    </div>
<?php }?>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        var giay = 5;

        var t = setTimeout(check5s, 1000);
        function check5s() {
          if(giay==0) {
           window.open("<?php echo $month_report->download_url;?>", "_blank");
            return true;
          }
          giay = giay-1;
          $('#giay').html(giay);
          var tt = setTimeout(check5s, 1000);
        }
    });

</script>
