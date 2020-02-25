<div class="box box-primary">
    <div class="box-header">
        <form action="" method="GET" class="form-inline" enctype="multipart/form-data">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input id="reportrange" name="date_filter" class="pull-right" data-start="<?php echo $start;?>" data-end="<?php echo $end;?>">
                </div>
            </div>
            <div class="form-group">
               <input type="hidden" name="filter" value="1">
               <button type="submit" class="form-control btn-primary">Hiển thị</button>
            </div>
        </form>
    </div>
</div> 

<?php if($results){ ?>
<div class="box box-primary">
    <div class="box-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Phiếu thu</th>
                    <th>Ngày</th>
                    <th>Số tiền</th>
                    <th>Chứng từ</th>
                    <th>Chi nhánh</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = $total = 0;
                foreach($results as $value){
                $total += $value->invoice_visa_transfer;
                $i++;?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td><a href="../invoices/detail/<?php echo $value->id;?>" target="_blank"><?php echo $value->id;?></a></td>
                    <td><?php echo $value->date;?></td>
                    <td><?php echo number_format($value->invoice_visa_transfer);?></td>
                    <td>
                        <?php
                        if(get_mpos_image($value->id) != NULL)
                        {
                            ?><a href="../assets/uploads/visas/<?php echo get_mpos_image($value->id)?>" target="_blank"><?php echo get_mpos_image($value->id)?></a>
                            <?php
                        }
                        else
                        {
                            echo "không có chứng từ";
                        }
                        ?>
                    </td>
                    <td><?php echo get_store_name($value->store_id);?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Tổng</th>

                    <th><?php echo number_format($total);?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php } ?>

