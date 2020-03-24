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
                <h3>Nhập nhân khẩu</h3>

                <div class="box box-success">
                    <div class="box-header">
                        <form method="post" id="import_form" enctype="multipart/form-data">
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Chọn file excel</label>
                                    <div class="clearfix"></div>
                                    <input type="file" name="file[]" id="file" multiple required accept=".xls, .xlsx" />
                                    <br />
                                </div>

                                <div class="form-group">
                                    <label>Loại import</label>
                                    <div class="clearfix"></div>
                                    <select style="width: 220px" class="form-control" name="type"
                                        placeholder="Giới tính" require>
                                        <option <?php echo $type =='NEW' ? 'selected':'' ?> value="NEW">Nhập hộ mới
                                        </option>
                                        <option <?php echo $type =='IN' ? 'selected':'' ?> value="IN">Chuyển đến
                                        </option>
                                        <option <?php echo $type =='OUT' ? 'selected':'' ?> value="OUT">Chuyển đi
                                        </option>
                                        <option <?php echo $type =='KSINH' ? 'selected':'' ?> value="KSINH">Nhập khai
                                            sinh</option>
                                    </select>
                                </div>
                                <input type="submit" name="import" value="Nhập dữ liệu" class="btn btn-info" />
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <?php if(!empty($arrReturn)){ ?>
                                <div class="row">
                                    <h3>Kết quả</h3>
                                </div>
                                <div class="row">
                                    <h4>Số nhân khẩu được thêm : <?php echo $insert ?></h4>
                                </div>
                                <div class="row">
                                    <h4>Số nhân khẩu đã tồn tại : <?php echo $hasNK ?></h4>
                                </div>
                                <div class="row">
                                    <h4>Số nhân khẩu lọc được : <?php echo count($arrReturn) ?></h4>
                                </div>
                                <?php } ?>
                            </div>

                        </form>
                        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <form action="nhankhau/edit/0" method="post">
                                <button class="btn btn-primary pull-right" type="submit">
                                    <i class="fa fa-plus"></i> Tạo nhân khẩu
                                </button>
                            </form>
                        </div>
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
                                        <th style="min-width: 100px">Ngày sinh</th>
                                        <th>Quan hệ</th>
                                        <th>Đến từ</th>
                                        <th>Hiện tại</th>
                                        <th>Nguyên quán</th>
                                        <th>Dân tộc </th>
                                        <th>Ngày </th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($arrReturn)){
                                    foreach ($arrReturn as $key => $value) {?>
                                    <tr>
                                        <td><?php echo $key+1 ?></td>
                                        <td><?php echo !empty($value->number_hk) ? $value->number_hk : '';  ?></td>
                                        <td><?php echo $value->full_name?></td>
                                        <td><?php echo !empty($value->cmnd) ? $value->cmnd : '' ?></td>
                                        <td><?php echo !empty($value->sex) ? $value->sex :$value->sex ?></td>
                                        <td><?php echo !empty($value->birtdate) ?   date('d/m/Y',strtotime($value->birtdate)) : '' ?>
                                        </td>

                                        <td><?php echo !empty($value->qh) ?  $value->qh : '' ?></td>

                                        <td><?php if($value->status ==3){
                                            echo (!empty($value->to_strees) ?$value->to_strees : '' ).' '.
                                            (!empty($value->to_ward) ? $value->to_ward:'').' '.
                                            (!empty($value->to_city) ? $value->to_city : '');
                                        }else{
                                            echo (!empty($value->from_strees) ?$value->from_strees : '' ).' '.
                                            (!empty($value->from_ward) ? $value->from_ward:'').' '.
                                            (!empty($value->from_city) ? $value->from_city : '');
                                        }   ?>
                                        </td>
                                        <td><?php if($value->status ==3){
                                            echo !empty($value->noichuyendi) ? $value->noichuyendi: '';
                                        }else{
                                            echo (!empty($value->to_strees) ?$value->to_strees : '' ).' '.
                                            (!empty($value->to_ward) ? $value->to_ward:'').' '.
                                            (!empty($value->to_city) ? $value->to_city : '') ;
                                        }  ?>
                                        </td>
                                        <td><?php echo isset($value->nguyenquan) ? $value->nguyenquan: ''  ?></td>
                                        <td class="text-center">
                                            <span><?php echo $value->dantoc; ?></span><br>
                                        </td>
                                        <td>
                                            <span><?php echo isset($value->date) ? $value->date :'';  ?></span><br>
                                            <span class="label label-primary"><?php echo isset($value->type) ? $value->type :'';  ?></span>
                                    </td>
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