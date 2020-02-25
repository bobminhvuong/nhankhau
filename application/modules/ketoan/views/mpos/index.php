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
            <div class="pull-right">
               <span class="btn btn-success" data-toggle="collapse" data-target="#demo">Thêm mới</span>
            </div>
        </form>
    </div>
    <div class="box-body collapse" id="demo">
        <form action="mpos" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <div class="form-group">
                        <label>Tiêu đề:</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label>Ghi chú:</label>
                        <textarea class="form-control" name="note"></textarea>
                    </div>
                    <div class="form-group">
                        <label>File:</label>
                        <input type="file" class="form-control number" name="file" required>
                    </div>
                    <input type="submit" name="save" class="btn btn-success" value="Thêm mới">
                </div>
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
                    <th>Tiêu đề</th>
                    <th>File</th>
                    <th>Người tạo</th>
                    <th>Ngày tạo</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $key => $value) { ?>
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo $value->title;?></td>
                    <td><a href="mpos/detail/<?php echo $value->id;?>" target="blank"><?php echo $value->file;?></a></td>
                    <td><?php echo get_user_name($value->import_id);?></td>
                    <td><?php echo $value->created;?></td>
                    <td><a href="mpos/delete/<?php echo $value->id;?>" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>