
<?php 
    
?>

<style type="text/css">
    /*
    input[name=birthday]{
        width: 85px;
    }
    input[name=id_card]{
        width: 85px;
    }
    input[name=id_date]{
        width: 85px;
    }
    */
    .icheckbox_flat-blue{ 
        margin-top: 5px;
        margin-left: 15px;
    }
</style>
<?php if($results){ ?>
<div class="box box-primary">
    <div class="box-body table-responsive">
        <table class="table table-bordered">
            <thead>
                <th class="text-center">#</th>
                <th>Tên ca</th>
                <th>Giờ bắt đầu</th>
                <th>Giờ kết thúc</th>
                <th>Trạng thái</th>
                
            </thead>
            <tbody>
                <?php 
                $i = 0;
                foreach ($results as $key => $value) { 
                $style = '';
                
                $i++;?>
                <tr <?php echo $style;?> >
                    <td class="text-center">
                        <span class="btn btn-xs btn-primary" data-toggle="collapse" data-target="#<?php echo $value->id;?>"><?php echo $i;?></span>
                    </td>
                    <td><?php echo $value->name ;?></td>
                    <td>
                        <?php echo $value->begin;?>
                    </td>
                    <td>
                        <?php echo $value->end;?>
                    </td>
                    <td>
                        <?php echo $value->active?'Hoạt động':'Vô hiệu hóa';?>
                    </td>
                   
                </tr>
                <tr id="<?php echo $value->id;?>" class="collapse" style="background: #cfcfcf">
                    <td colspan="10">
                        <form class="form-inline form-shift-manager" method="post">
                            <input type="hidden" name="id" value="<?php echo $value->id;?>">
                            <div class="form-group">
                                <small>Tên Ca</small><br>
                                <input type="text" name="name" class="form-control input-sm" value="<?php echo $value->name;?>">
                            </div>
                            <div class="form-group">
                                <small>Giờ bắt đầu</small><br>
                                <input type="text" name="begin" class="form-control input-sm" value="<?php echo $value->begin;?>">
                            </div>
                            <div class="form-group">
                                <small>Giờ kết thúc</small><br>
                                <input type="text" name="end" class="form-control input-sm" value="<?php echo $value->end;?>">
                            </div>
                            <div class="form-group">
                                <small>Hoạt động</small><br>
                                <input type="checkbox" name="active" class="icheck-blue" <?php echo $value->active?'checked':'';?> >
                            </div>
                            <div class="form-group pull-right">
                                <small>Tác vụ</small><br>
                                <input type="submit" name="submit_edit" class="btn btn-sm btn-success" value="Cập nhật"></input>
                                <?php echo $value->in_use_shift==0? 
                                '<input type="submit" name="submit_delete" class="btn btn-sm btn-danger" value="Xóa ca"></input>':''
                                ?>
                            </div>
                            
                        </form>
                        
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="10">
                        <form class="form-inline" method="post">
                            
                            <div class="form-group">
                                <small>Tên Ca</small><br>
                                <input type="text" name="name" class="form-control input-sm" value="Tên Ca">
                            </div>
                            <div class="form-group">
                                <small>Giờ bắt đầu</small><br>
                                <input type="text" name="begin" class="form-control input-sm" value="00:00:00">
                            </div>
                            <div class="form-group">
                                <small>Giờ kết thúc</small><br>
                                <input type="text" name="end" class="form-control input-sm" value="00:00:00">
                            </div>
                            <div class="form-group">
                                <small>Hoạt động</small><br>
                                <input type="checkbox" name="active" class="icheck-blue" value="Hoạt động">
                            </div>
                            <div class="form-group pull-right">
                                <small>Tác vụ</small><br>
                                <input type="submit" name="submit_add" class="btn btn-sm btn-primary" value="Thêm ca"></input>
                               
                            </div>
                            
                        </form>
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>



	