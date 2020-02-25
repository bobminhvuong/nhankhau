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

<?php if($invoices){ ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="box-title">Phiếu thu</div>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Phiếu thu</th>
                    <th>Ngày</th>
                    <th>Số tiền PM</th>
                    <th>Số tiền mPos</th>
                    <th>Mã mPos</th>
                    <th>Trạng thái</th>
                    <th>Chi nhánh</th>
                    <th>Sửa mã</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_soft = $total_mpos = $i = 0;
                $list_ctgd = array();
                foreach ($invoices as $value) { 
                if(isset($value->list_id)){
                $i++;
                $result = get_invoice_mpos($value->list_id, $value->list_code, $value->date);
                $total_soft += $result['price_soft'];
                $total_mpos += $result['price_mpos'];
                foreach ($result['list_ctgd'] as $ctgd) {
                    $list_ctgd[] = $ctgd;
                }
                ?>
                <tr>
                    <td><?php echo $i;?></td>
                    <td>
                        <?php 
                        $count = count($value->list_id) - 1;
                        foreach ($value->list_id as $key => $id) {
                        ?>
                        <a href="../invoices/detail/<?php echo $id;?>" target="_blank"><?php echo $id;?><?php echo $key < $count?', ':'';?></a>
                        <?php } ?>
                    </td>
                    <td><?php echo $value->date;?></td>
                    <td><?php echo number_format($result['price_soft']);?></td>
                    <td><?php echo number_format($result['price_mpos']);?></td>
                    <td><?php echo $result['code'];?></td>
                    <td><?php echo $result['status'];?></td>
                    <td><?php echo get_store_name($value->store_id);?></td>
                    <td>
                    	<?php 
                        $count = count($value->list_id) - 1;
                        foreach ($value->list_id as $key => $id) {
                        ?>
                        <a href="../invoices/edit_visa/<?php echo $id;?>" target="_blank"><?php echo $id;?><?php echo $key < $count?', ':'';?></a>
                        <?php } ?>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Tổng</th>
                    <th><?php echo number_format($total_soft);?></th>
                    <th><?php echo number_format($total_mpos);?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php } ?>

<?php 
$CI = get_instance();


$rule_mpo_detail = array(
    'thoigian >=' => date('Y-m-d', strtotime($start)),
    'thoigian <=' => date('Y-m-d', strtotime($end)),
);
if(!empty($list_ctgd)){
    $rule_mpo_detail['ctgd NOT'] = $list_ctgd;
}
$results = $CI->mpos_detail->get_many_by($rule_mpo_detail);

if($results){ ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="box-title">Doanh số mPos không có trong phần mềm</div>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày</th>
                    <th>Chi tiết GD</th>
                    <th>Mã chuẩn chi</th>
                    <th>Số tiền</th>
                    <th>Tài khoản</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_mpos_notisset = 0;
                foreach ($results as $key => $value) {

                if(strlen($value->machuanchi) == 6 && $value->machuanchi != '000000' ){
                    $href = $value->machuanchi;
                }else{
                    $href = substr($value->ctgd, -8);
                }

                $total_mpos_notisset += $value->sotien;?>
                
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo $value->thoigian;?></td>
                    <td><a href="mpos/view/<?php echo $href;?>" target="_blank"><?php echo $value->ctgd;?></a></td>
                    <td><a href="mpos/view/<?php echo $href;?>" target="_blank"><?php echo $value->machuanchi;?></a></td>
                    <td><?php echo number_format($value->sotien);?></td>
                    <td><?php echo $value->tk_thanhtoan;?></td>
                    <td>
                        <span class="label label-<?php echo $value->trangthai=='Đảo'?'danger':'info';?>"><?php echo $value->trangthai;?></span>      
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Tổng</th>
                    <th><?php echo number_format($total_mpos_notisset);?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php } ?> 

