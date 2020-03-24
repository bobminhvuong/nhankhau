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
                <h3>Chỉnh sửa nhân khẩu</h3>
                <div class="box box-success">
                    <div class="box-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Loại<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">

                                    <select name="status" class="form-control" required="required">
                                        <option <?php echo !empty($nk->status) && $nk->status ==1 ?  'selected': ''  ?> value="1">Hộ mới</option>
                                        <option <?php echo !empty($nk->status) && $nk->status ==2 ?  'selected': ''  ?> value="2">Chuyển đến</option>
                                        <option <?php echo !empty($nk->status) && $nk->status ==3 ?  'selected': ''  ?> value="3">Chuyển đi</option>
                                        <option <?php echo !empty($nk->status) && $nk->status ==4 ?  'selected': ''  ?> value="4">Khai sinh</option>
                                    </select>

                                </div>
                                <div class="clearfix"></div>

                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Số<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control" name="id" value="<?php echo $id; ?>">

                                    <input type="text" class="form-control" name="number"
                                        value="<?php echo !empty($nk->number) ?$nk->number : '' ; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Mã hộ khẩu
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="number_hk"
                                        value="<?php echo !empty($nk->number_hk) ?$nk->number_hk: '' ; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Mã hộ khẩu củ
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="number_hk_old"
                                        value="<?php echo !empty( $nk->number_hk_old) ? $nk->number_hk_old: '' ; ?>">
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Họ tên
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="full_name"
                                        value="<?php echo !empty($nk->full_name) ? $nk->full_name : ''; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group" id="product_ref">
                                <label class="col-sm-3 control-label text-right text-danger">
                                    Chứng minh
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="cmnd"
                                        value="<?php echo !empty($nk->cmnd) ?$nk->cmnd: '' ; ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Giới tính
                                </label>
                                <div class="col-sm-6">
                                    <select type="text" class="form-control" name="sex">
                                        <option <?php echo !empty($nk->sex) && $nk->sex =='NAM' ? 'selected':''; ?>
                                            value="NAM">NAM</option>
                                        <option <?php echo !empty($nk->sex) && $nk->sex =='NỮ' ? 'selected':''; ?>
                                            value="NỮ">NỮ</option>
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
                                                value="<?php echo !empty($nk->from_strees) ? $nk->from_strees : '' ; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <input type="text" class="form-control" name="from_ward" placeholder="Quận"
                                                value="<?php echo !empty($nk->from_ward) ? $nk->from_city: '' ; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                                            <input type="text" class="form-control" name="from_city" placeholder="Tỉnh"
                                                value="<?php echo !empty($nk->from_city) ?$nk->from_city: '' ; ?>">
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
                                                value="<?php echo !empty($nk->to_strees) ? $nk->to_strees: '' ; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <input type="text" class="form-control" name="to_ward" placeholder="Quận"
                                                value="<?php echo  !empty($nk->to_ward) ?$nk->to_ward : '' ; ?>">
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                                            <input type="text" class="form-control" name="to_city" placeholder="Tỉnh"
                                                value="<?php echo !empty($nk->to_city) ?$nk->to_city : '' ; ?>">
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
                                        placeholder="dd/mm/yyyy"
                                        value="<?php echo !empty($nk->birtdate) ? date('d/m/Y',strtotime($nk->birtdate)) : '';  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Quan hệ
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="qh" class="form-control"
                                        value="<?php echo !empty($nk->qh) ? $nk->qh : '';  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Nguyên quán
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="nguyenquan" class="form-control up_number"
                                        value="<?php echo !empty($nk->nguyenquan) ? $nk->nguyenquan:'';  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Dân tộc
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="dantoc" class="form-control up_number"
                                        value="<?php echo !empty($nk->dantoc) ? $nk->dantoc : '';  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Tôn giáo
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="tongiao" class="form-control up_number"
                                        value="<?php echo !empty($nk->tongiao) ? $nk->tongiao : '';  ?>">
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <?php if(!empty($nk->status) &&  $nk->status==2){ ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Ngày chuyển đến<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text"
                                        value="<?php echo !empty($nk->ngaychuyenden) ? $nk->ngaychuyenden : ''; ?> "
                                        name="ngaychuyenden" class="form-control up_number">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php } ?>


                            <?php if(!empty($nk->status) &&  $nk->status==3){ ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Ngày chuyển đi<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text"
                                        value="<?php echo !empty($nk->ngaychuyendi) ? $nk->ngaychuyendi : ''; ?> "
                                        name="ngaychuyendi" class="form-control up_number">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">
                                    Nơi chuyển đi<span class="required">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text"
                                        value="<?php echo !empty($nk->noichuyendi) ? $nk->noichuyendi : ''; ?> "
                                        name="noichuyendi" class="form-control up_number">
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