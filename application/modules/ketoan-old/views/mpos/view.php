<?php if($results){ 
foreach ($results as $value) { ?>
<div class="box box-primary">
    <div class="box-body table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Mã chuẩn chi: </td>
                    <td><?php echo $value->machuanchi;?></td>
                </tr>
                <tr>
                    <td>Chi tiết giao dịch: </td>
                    <td><?php echo $value->ctgd;?></td>
                </tr>
                <tr>
                    <td>Số tiền: </td>
                    <td><?php echo number_format($value->sotien);?></td>
                </tr>
                <tr>
                    <td>Ngày: </td>
                    <td><?php echo $value->thoigian;?></td>
                </tr>
                <tr>
                    <td>Tên chủ thẻ: </td>
                    <td><?php echo $value->tenchuthe;?></td>
                </tr>
                <tr>
                    <td>Số thẻ: </td>
                    <td><?php echo $value->sothe;?></td>
                </tr>
                <tr>
                    <td>Trạng thái: </td>
                    <td><?php echo $value->trangthai;?></td>
                </tr>
                <tr>
                    <td>Tài khoản: </td>
                    <td><?php echo $value->tk_thanhtoan;?></td>
                </tr>
                <tr>
                    <td>Thay đổi ngày: </td>
                    <td>
                        <form action="" method="post" class="form-inline">
                            <input type="hidden" name="ctgd" value="<?php echo $value->ctgd;?>">
                            <div class="input-group input-group-sm">
                            <input type="text" class="form-control datepicker" name="date" value="<?php echo $value->thoigian;?>">
                                <span class="input-group-btn ">
                                    <input type="submit" class="btn btn-info btn-flat" name="update" value="Cập nhật">
                                </span>
                            </div>
                        </form>
                            
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php }}
else{ ?>
<div class="alert alert-danger alert-dismissible">
    <h4><i class="icon fa fa-ban"></i> Cảnh báo!</h4>
    Không tìm thấy thông tin
</div>
<?php } ?>