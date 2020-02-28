
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
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown notifications-menu">
                            <a href="http://localhost/crm-diem-nhan/notifies/view/1">
                                <i class="fa fa-phone"></i>
                            </a>
                        </li>

                        <li class="dropdown notifications-menu" id="notifications-menu">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-calendar"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header notifications-count">Bạn có 0 lịch hẹn</li>
                                <li>
                                    <div class="slimScrollDiv"
                                        style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                        <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                        </ul>
                                        <div class="slimScrollBar"
                                            style="background: rgb(0, 0, 0); width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;">
                                        </div>
                                        <div class="slimScrollRail"
                                            style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;">
                                        </div>
                                    </div>
                                </li>
                                <li class="footer">
                                    <!-- <a href="http://localhost/crm-diem-nhan/admin/notifications">Xem tất cả các thông báo</a> -->
                                    <a>Khách chưa đến</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="http://dev.seoulspa.vn/assets/uploads/avatars/0f0ced513c0088852e5966119990dd44.jpg"
                                    height="20px">
                                <span class="hidden-xs">Vương</span>
                                <!-- <span class="visible-xs"><i class="fa fa-user"></i></span> -->
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <p>Vương</p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="http://localhost/crm-diem-nhan/panel/account"
                                            class="btn btn-default btn-flat">Tài khoản</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="http://localhost/crm-diem-nhan/panel/logout"
                                            class="btn btn-default btn-flat">Đăng xuất</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar" style="height: auto;">
                <div class="user-panel" style="height:65px">

                    <div class="pull-left info" style="left:5px">

                        <div class="row pull-right">
                            <div class="col-xs-4">
                                <img src="http://dev.seoulspa.vn/assets/uploads/avatars/0f0ced513c0088852e5966119990dd44.jpg"
                                    height="50px" width="50px">
                            </div>
                            <div class="col-xs-8" style="margin-top: .5em;">
                                <a href="panel/account">
                                    <p>Vương</p>
                                    <i class="fa fa-circle text-success"></i> Online
                                </a>
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
                <h3>Chỉnh sửa nhân khẩu</h3>
                <div class="box box-success">
                    <div class="box-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Số<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="id" 
                                        value="<?php echo $nk->id; ?>">

                                    <input type="text" class="form-control" name="number" 
                                        value="<?php echo $nk->number; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Mã hộ khẩu
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="number_hk" 
                                        value="<?php echo $nk->number_hk; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Mã hộ khẩu củ
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="number_hk_old" 
                                        value="<?php echo $nk->number_hk_old; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Họ tên
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="full_name" 
                                        value="<?php echo $nk->full_name; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Chứng minh
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="cmnd" 
                                        value="<?php echo $nk->cmnd; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Giới tính
                                </label>
                                <div class="col-sm-6">
                                    <select type="text" class="form-control" name="sex" >
                                        <option <?php echo $nk->sex =='NAM' ? 'selected':''; ?> value="NAM">NAM</option>
                                        <option <?php echo $nk->sex =='NỮ' ? 'selected':''; ?> value="NỮ">NỮ</option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Đến từ<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <input type="text" class="form-control" name="from_strees"
                                                placeholder="Đường" 
                                                value="<?php echo $nk->from_strees; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <input type="text" class="form-control" name="from_ward" placeholder="Quận"
                                                 value="<?php echo $nk->from_ward; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                                            <input type="text" class="form-control" name="from_city" placeholder="Tỉnh"
                                                 value="<?php echo $nk->from_city; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Chỗ hiện tại<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <input type="text" class="form-control" name="to_strees" placeholder="Đường"
                                                 value="<?php echo $nk->to_strees; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <input type="text" class="form-control" name="to_ward" placeholder="Quận"
                                                 value="<?php echo $nk->to_ward; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                                            <input type="text" class="form-control" name="to_city" placeholder="Tỉnh"
                                                 value="<?php echo $nk->to_city; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Ngày sinh
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="birtdate" class="form-control up_number"
                                        value="<?php echo $nk->birtdate;  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Nguyên quán
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="nguyenquan" class="form-control up_number"
                                        value="<?php echo $nk->nguyenquan;  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Dân tộc
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="dantoc" class="form-control up_number"
                                        value="<?php echo $nk->dantoc;  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Tôn giáo
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="tongiao" class="form-control up_number"
                                        value="<?php echo $nk->tongiao;  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>


                            <?php if($nk->status ==3){ ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Ngày chuyển đi<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $nk->ngaychuyendi; ?> " name="ngaychuyendi"
                                        class="form-control up_number">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Nơi chuyển đi<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $nk->noichuyendi; ?> " name="noichuyendi"
                                        class="form-control up_number">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Lưu thông tin</button>
                                <a href="nhankhau/list" class="btn btn-danger">Hủy</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

    </div>
</body>