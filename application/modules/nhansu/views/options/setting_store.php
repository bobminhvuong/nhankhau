
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
                <th>Chi nhánh</th>
                <th>Địa chỉ</th>
                <th>Mật mã</th>
                <th>Latitude GPS</th>
                <th>Longitude GPS</th>
                <th>Địa chỉ IP</th>
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
                    <td><?php echo $value->description ;?></td>
                    <td>
                        <?php echo $value->address;?>
                    </td>
                    <td>
                        <?php echo $value->password;?>
                    </td>
                    <td>
                        <?php echo $value->latitude_gps;?>
                    </td>
                    <td>
                        <?php echo $value->longitude_gps;?>
                    </td>
                    <td>
                        <?php echo $value->ipaddress;?>
                    </td>
                    
                   
                </tr>
                <tr id="<?php echo $value->id;?>" class="collapse" style="background: #cfcfcf">
                    <td colspan="10">
                        <form class="form-inline form-shift-manager" method="post">
                            <input type="hidden" name="id" value="<?php echo $value->id;?>">
                            <div class="form-group">
                                <small>Mật mã</small><br>
                                <input type="text" name="password" class="form-control input-sm" value="<?php echo $value->password;?>">
                            </div>
                            <div class="form-group">
                                <small>Latitude GPS</small><br>
                                <input type="text" name="latitude_gps" class="form-control input-sm" value="<?php echo $value->latitude_gps;?>">
                            </div>
                            <div class="form-group">
                                <small>Longitude GPS</small><br>
                                <input type="text" name="longitude_gps" class="form-control input-sm" value="<?php echo $value->longitude_gps;?>">
                            </div>
                            <div class="form-group">
                                <small>Địa chỉ IP</small><br>
                                <input type="text" name="ipaddress" class="form-control input-sm" value="<?php echo $value->ipaddress;?>">
                            </div>
                            <div class="form-group pull-right">
                                <small>Tác vụ</small><br>
                                <input type="submit" name="submit_edit" class="btn btn-sm btn-success" value="Cập nhật"></input>
                                
                            </div>
                            
                        </form>
                        
                    </td>
                </tr>
                <?php } ?>
                
            </tbody>
        </table>
    </div>
</div>
<?php } ?>



	