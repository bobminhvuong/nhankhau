<?php if($results){ ?>
<div class="box box-primary">
    <div class="box-body table-responsive">
        <table class="table table-bordered tablelte-full-excel">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Thời gian</th>
                    <th>Kết toán</th>
                    <th>Chi tiết GD</th>
                    <th>Tên chủ thẻ</th>
                    <th>Số thẻ</th>
                    <th>Ngân hàng</th>
                    <th>Mã ĐVCNT</th>
                    <th>Mã thiết bị</th>
                    <th>Mã chuẩn chi</th>
                    <th>Trạng thái</th>
                    <th>Số tiền</th>
                    <th>Loại thẻ</th>
                    <th>Phí giao dịch</th>
                    <th>Kỳ hạn</th>
                    <th>Phí trả góp</th>
                    <th>NH hỗ trợ</th>
                    <th>Địa điểm GD</th>
                    <th>Đầu đọc thẻ</th>
                    <th>TK thanh toán</th>
                    <th>Mô tả</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $key => $value) { ?>
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo $value->thoigian;?></td>
                    <td><?php echo $value->tgketoan;?></td>
                    <td><?php echo $value->ctgd;?></td>
                    <td><?php echo $value->tenchuthe;?></td>
                    <td><?php echo $value->sothe;?></td>
                    <td><?php echo $value->card_bank;?></td>
                    <td><?php echo $value->mid;?></td>
                    <td><?php echo $value->tid;?></td>
                    <td><?php echo $value->machuanchi;?></td>
                    <td><?php echo $value->trangthai;?></td>
                    <td><?php echo number_format($value->sotien);?></td>
                    <td><?php echo $value->loaithe;?></td>
                    <td><?php echo number_format($value->phigiaodich);?></td>
                    <td><?php echo $value->kyhan;?></td>
                    <td><?php echo $value->phitragop;?></td>
                    <td><?php echo $value->nh_hotro;?></td>
                    <td><?php echo $value->diadiem_thuchien;?></td>
                    <td><?php echo $value->daudocthe;?></td>
                    <td><?php echo $value->tk_thanhtoan;?></td>
                    <td><?php echo $value->motagiaodich;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>