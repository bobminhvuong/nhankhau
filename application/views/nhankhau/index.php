<body class="skin-red" style="height: auto;" cz-shortcut-listen="true">
    <div class="wrapper" style="height: auto;">

        <header class="main-header">
            <!--a href="" class="logo"><b>Admin Panel</b></a-->
            <a href="http://localhost/crm-diem-nhan/" class="logo" style="background: white"><img
                    src="http://localhost/crm-diem-nhan/assets/images/logo-text.png" width="135px"></a>
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
                        <a href="nhankhau"><i class="fa fa-home"></i> Nhập excel </a>
                    </li>
                    <li>
                        <a href="nhankhau/list"><i class="fa fa-home"></i> Danh sách nhân khẩu</a>
                    </li>
                    <li>
                        <a href="nhankhau"><i class="fa fa-home"></i>Nhập khai sinh</a>
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
                <h3>Nhập danh sách người dân</h3>

                <div class="box box-success">

                    <div class="box-header">
                        <form method="post" id="import_form" enctype="multipart/form-data">
                            <p><label>Select Excel File</label>
                                <input type="file" name="file[]" id="file" multiple required accept=".xls, .xlsx" /></p>
                            <br />
                            <input type="submit" name="import" value="Import" class="btn btn-info" />
                        </form>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Hộ khẩu</th>
                                        <th>Họ tên</th>
                                        <th>CMND</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Đến từ</th>
                                        <th>Hiện tại</th>
                                        <th>Nguyên quán</th>
                                        <th>Dân tộc</th>
                                        <th>Tôn giáo</th>
                                        <th>Quốc tịch</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($arrReturn)){
                                    foreach ($arrReturn as $key => $value) {?>
                                    <tr>
                                        <td><?php echo $key+1 ?></td>
                                        <td><?php echo $value->number_hk;  ?></td>
                                        <td><?php echo $value->full_name?></td>
                                        <td><?php echo $value->cmnd ?></td>
                                        <td><?php echo $value->sex ?></td>
                                        <td><?php echo $value->birtdate  ?></td>
                                        <td><?php if(!empty($value->top) && $value->top==1 ) echo $value->from_strees.' '.$value->from_ward.' '.$value->from_city  ?>
                                        </td>
                                        <td><?php if(!empty($value->top) && $value->top==1 ) echo $value->to_strees.' '.$value->to_ward.' '.$value->to_city;   ?>
                                        </td>
                                        <td><?php echo $value->nguyenquan  ?></td>
                                        <td><?php echo $value->dantoc  ?></td>
                                        <td><?php echo $value->tongiao  ?></td>
                                        <td><?php echo isset($value->quoctich) ? $value->quoctich :'';  ?></td>
                                        <td><?php if($value->is_insert ==1) {
                            echo '<span class="label label-success">Đã lưu</span>';
                            }else{
                                echo '<span class="label label-warning">Đã tồn tại</span>';
                            }  ?>
                                        </td>
                                    </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </section>
        </div>

    </div>
</body>