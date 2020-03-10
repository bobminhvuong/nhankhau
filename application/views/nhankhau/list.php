<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; ?>

<body class="skin-red" style="height: auto;" cz-shortcut-listen="true">
    <div class="wrapper" style="height: auto;">

        <header class="main-header">
            <!--a href="" class="logo"><b>Admin Panel</b></a-->
            <!-- <a href="http://localhost/crm-diem-nhan/" class="logo" style="background: white"><img
                    src="http://localhost/crm-diem-nhan/assets/images/logo-text.png" width="135px"></a> -->
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar" style="height: auto;">
                <div class="user-panel" style="height:65px">

                    <div class="pull-left info" style="left:5px">

                        <div class="row pull-right">
                            <div class="col-xs-12 text-center text-danger">
                               <h3 style="font-weight: bold;">Nhân khẩu</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="sidebar-menu">

                    <li class="active">
                        <a href="nhankhau"><i class="fa fa-home"></i> Tạo nhân khẩu </a>
                    </li>
                    <li>
                        <a href="nhankhau/list?nk=1"><i class="fa fa-home"></i> Danh sách nhân khẩu</a>
                    </li>
                </ul>
                <style>
                #countmail {
                    width: 20px;
                    height: 20px;
                    line-height: 20px;
                    text-align: center;
                    border-radius: 50%;
                }
                </style>
            </section>
        </aside>
        <div class="content-wrapper" style="min-height: 989px;">
            <section class="content">
                <h3>Danh sách nhân khẩu</h3>
                <div class="box box-success">

                    <div class="box box-header">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                            <form action="" method="GET" class="form-inline" role="form">
                                <div class="form-group">
                                    <label>Tên hoặc CMND</label>
                                    <div class="clearfix"></div>
                                    <input class="form-control" type="text" name="find" placeholder="Họ tên"
                                        value="<?php echo $find ?>">
                                </div>
                                <div class="form-group">
                                    <label>Số hộ khẩu</label>
                                    <div class="clearfix"></div>
                                    <input class="form-control" type="text" name="number_hk" placeholder="Hộ khẩu"
                                        value="<?php echo $number_hk ?>">
                                </div>

                                <div class="form-group">
                                    <label>Giới tính</label>
                                    <div class="clearfix"></div>
                                    <select class="form-control" name="sex" placeholder="Giới tính">
                                        <option value="">Tất cả</option>
                                        <option <?php if($sex == 'NAM') echo 'selected' ?> value="NAM">NAM</option<>
                                        <option <?php if($sex == 'NỮ') echo 'selected' ?> value="NỮ">NỮ</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Ngày sinh</label>
                                    <div class="clearfix"></div>
                                    <div class="input-group" style="width: 300px">
                                        <input class="form-control" type="text" name="birtdate_from" style="width: 50%"
                                            value="<?php echo $birtdate_from; ?>" placeholder="Từ ngày">

                                        <input class="form-control" type="text" name="birtdate_to" style="width: 50%"
                                            value="<?php echo $birtdate_to; ?>" placeholder="Đến ngày">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <div class="clearfix"></div>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="from" value="<?php echo $from; ?>"
                                            placeholder="Địa chỉ">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Nguyên quán</label>
                                    <div class="clearfix"></div>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="nguyenquan"
                                            value="<?php echo $nguyenquan; ?>" placeholder="Nguyên quán">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <div class="clearfix"></div>
                                    <select class="form-control" name="status" placeholder="Loại">
                                        <option value="">Tất cả</option<>
                                        <option <?php if($status == 1) echo 'selected' ?> value="1">Hộ mới</option<>
                                        <option <?php if($status == 2) echo 'selected' ?> value="2">Chuyển đến</option<>
                                        <option <?php if($status == 3) echo 'selected' ?> value="3">Chuyển đi</option<>
                                        <option <?php if($status == 4) echo 'selected' ?> value="4">Khai sinh</option<>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label> </label>
                                    <div class="clearfix"></div>
                                    <div class="input-group">
                                        <input type="hidden" name="filter" value="1">
                                        <button style="margin-top: 5px" type="submit"
                                            class="form-control btn-primary">Hiển
                                            thị</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <form action="" method="POST">
                                <input class="btn btn-primary pull-right" type="submit" name="export" value="export">
                            </form>
                        </div>

                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th  class="text-center">Hộ khẩu</th>
                                        <th>Họ tên</th>
                                        <th class="text-center">Quan hệ</th>
                                        <th class="text-center">CMND</th>
                                        <th class="text-center">Giới tính</th>
                                        <th class="text-center" style="min-width: 100px">Ngày sinh</th>
                                        <th style="width: 220px">Đến từ</th>
                                        <th style="width: 220px">Hiện tại</th>
                                        <th style="width: 220px">Chuyển đến</th>
                                        <th class="text-center">Nguyên quán</th>
                                        <th class="text-center">Dân tộc</th>
                                        <th class="text-center">Tôn giáo</th>
                                        <th class="text-center">Loại</th>
                                        <th class="text-center" style="min-width: 100px">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($arrReturn)){
                                    foreach ($arrReturn as $key => $value) {?>
                                    <tr>
                                        <td class="text-center"><?php echo $key+1 ?></td>
                                        <td class="text-center">
                                            <span><?php echo $value->number_hk;  ?></span> <br>
                                            <span>
                                                <?php echo $value->type;  ?>
                                            </span>
                                        </td>
                                        <td><?php echo $value->full_name?></td>
                                        <td class="text-center">
                                            <?php echo $value->top ==1 ? 'CHỦ HỘ' : (!empty($value->qh) ? $value->qh : ''); ?>
                                        </td>
                                        <td class="text-center"><?php echo  !empty($value->cmnd) ? $value->cmnd :''; ?>
                                        </td>
                                        <td class="text-center"><?php echo !empty($value->sex) ?$value->sex : '';  ?>
                                        </td>
                                        <td><?php echo  !empty($value->birtdate) ? date('d/m/Y',strtotime($value->birtdate)) : '';  ?>
                                        </td>

                                        <td><?php echo (!empty($value->from_strees) ?$value->from_strees : '' ).' '.
                                                            (!empty($value->from_ward) ? $value->from_ward:'').' '.
                                                            (!empty($value->from_city) ? $value->from_city : '')  ?>
                                        </td>
                                        <td><?php  echo (!empty($value->to_strees) ?$value->to_strees : '' ).' '.
                                                        (!empty($value->to_ward) ? $value->to_ward:'').' '.
                                                        (!empty($value->to_city) ? $value->to_city : '')   ?>
                                        </td>
                                        <td>
                                            <?php echo $value->noichuyendi ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo !empty($value->nguyenquan) ? $value->nguyenquan :''; ?></td>
                                        <td class="text-center">
                                            <?php echo !empty($value->dantoc) ? $value->dantoc : '' ?></td>
                                        <td class="text-center">
                                            <?php echo !empty($value->tongiao) ? $value->tongiao : '' ?></td>
                                        <td class="text-center">
                                            <span class="label <?php 
                                                if($value->status ==1) echo 'label-primary' ;
                                                if($value->status ==2) echo 'label-warning' ;
                                                if($value->status ==3) echo 'label-danger' ;
                                                if($value->status ==4) echo 'label-success' ;
                                             ?>">
                                                <?php 
                                                    if($value->status ==1) echo 'Hộ mới' ;
                                                    if($value->status ==2) echo 'Chuyển đến' ;
                                                    if($value->status ==3) echo 'Chuyển đi' ;
                                                    if($value->status ==4) echo 'Khai sinh' ;
                                                ?>
                                            </span>
                                        </td>
                                        <td class="text-center">

                                            <form action="nhankhau/edit/<?php echo $value->id ?>" method="post"
                                                style="float: left; ">
                                                <button class="btn btn-xs btn-warning" type="submit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </form>


                                            <form action="" method="post" style="margin-left: 2px;">
                                                <input type="hidden" value="<?php echo $value->id; ?>" name="delete">
                                                <button class="btn btn-xs btn-danger" type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    Hiển thị <?php echo $results->currentShow ?> trên tổng số
                                    <?php echo $results->total ?>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <nav aria-label="Page navigation ">
                                        <ul class="pagination pull-right">
                                            <li>
                                                <a href="
                                                <?php 
                                                
                                                    if(strpos($actual_link,'?') >= 0){
                                                        echo $actual_link.'&page='.($results->page -1);
                                                    }else{
                                                        echo $actual_link.'?page='.($results->page -1);
                                                    }
                                                    
                                                ?>
                                                " aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="active"><a href="#"><?php echo $results->page ?></a></li>
                                            <li>
                                                <a href="
                                                    <?php 
                                                        if(strpos($actual_link,'?') >= 0){
                                                            echo $actual_link.'&page='.($results->page +1);
                                                        }else{
                                                            echo $actual_link.'?page='.($results->page +1);
                                                        }
                                                    ?>
                                                " aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


            </section>
        </div>

    </div>
</body>