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
                                    <select style="width: 220px" class="form-control" name="type" placeholder="Giới tính" require>
                                        <option <?php echo $type == 'NEW' ? 'selected' : '' ?> value="NEW">Nhập hộ mới
                                        </option>
                                        <option <?php echo $type == 'IN' ? 'selected' : '' ?> value="IN">Chuyển đến
                                        </option>
                                        <option <?php echo $type == 'OUT' ? 'selected' : '' ?> value="OUT">Chuyển đi
                                        </option>
                                        <option <?php echo $type == 'KSINH' ? 'selected' : '' ?> value="KSINH">Nhập khai
                                            sinh</option>
                                    </select>
                                </div>
                                <input type="submit" name="import" value="Nhập dữ liệu" class="btn btn-info" />
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <?php if (!empty($arrReturn)) { ?>
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
                    <div class="box-body" ng-app="app" ng-controller="nkCtrl" ng-init="init()">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Nhân khẩu</th>
                                        <th>Thông tin</th>
                                        <th>Địa chỉ</th>
                                        <th>Thông tin File</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($arrReturn)) {
                                        foreach ($arrReturn as $key => $value) { ?>
                                            <tr>
                                                <td class="text-center"><?php echo $key + 1 ?></td>
                                                <td>
                                                    <table>
                                                        <tr data-toggle="tooltip" title="Hộ khẩu">
                                                            <td class="text-center" style="width:30px">
                                                                <i class="fa fa-home text-primary"></i>
                                                            </td>
                                                            <td>
                                                                <?php echo !empty($value->number_hk) ? $value->number_hk : '' ?>
                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="Họ tên">
                                                            <td class="text-center">
                                                                <?php if (!empty($value->sex)) {
                                                                    if ($value->sex == 'NAM') {
                                                                        echo '<i class="fa fa-male text-primary"></i>';
                                                                    } else {
                                                                        echo '<i class="fa fa-female text-primary"></i>';
                                                                    }
                                                                } else {
                                                                    echo '<i class="fa fa-user text-primary"></i>';
                                                                } ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value->full_name ?>
                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="cmnd">
                                                            <td class="text-center">
                                                                <i class="fa fa-credit-card text-primary"></i>
                                                            </td>
                                                            <td>
                                                                <?php echo !empty($value->cmnd) ? $value->cmnd : '' ?>
                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="Ngày sinh">
                                                            <td class="text-center">
                                                                <i class="fa fa-calendar text-primary"></i>
                                                            </td>
                                                            <td>
                                                                <span class="bdate-<?php echo $value->nk_id ?>" ng-if="isView != <?php echo $value->nk_id ?>">
                                                                    <?php echo $value->birtdate ? date('d/m/Y', strtotime($value->birtdate)) : '' ?>
                                                                </span>
                                                                <input ng-model="data.date" style="width:120px;height:20px" placeholder="dd/mm/yyyy" ng-if="isView == <?php echo $value->nk_id ?>" type="text" class="idate">
                                                                <button ng-if="isView != <?php echo $value->nk_id ?>" class="btn btn-xs btn-warning" ng-click="editDate(<?php echo $value->nk_id ?>,'')">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button ng-if="isView == <?php echo $value->nk_id ?>" class="btn btn-xs btn-primary" ng-click="saveDate()">
                                                                    <i class="fa fa-check"></i>
                                                                </button>

                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="Ngày sinh chưa format">
                                                            <td class="text-center">
                                                                <i class="fa fa-file-excel-o text-primary"></i>
                                                            </td>
                                                            <td>
                                                                <span>
                                                                    <?php echo !empty($value->birtdate_import) ?  $value->birtdate_import : '' ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>

                                                    <table>
                                                        <tr data-toggle="tooltip" title="Quan hệ với chủ hộ">
                                                            <td style="width: 35px">
                                                                <strong>
                                                                    QH:
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <?php echo !empty($value->qh) ?  $value->qh : '' ?>
                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="Nguyên quán">
                                                            <td>
                                                                <strong>
                                                                    NQ:
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <?php echo isset($value->nguyenquan) ? $value->nguyenquan : ''  ?>
                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="Dân tộc">
                                                            <td>
                                                                <strong>
                                                                    DT:
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <span><?php echo $value->dantoc; ?></span>
                                                            </td>
                                                        </tr>
                                                        <tr data-toggle="tooltip" title="Ngày đến / đi">
                                                            <td>
                                                                <strong>
                                                                    NN:
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <span><?php echo isset($value->date) ? $value->date : '';  ?></span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="width: 65px">
                                                                <strong>Đến từ: </strong>
                                                            </td>
                                                            <td>
                                                                <?php if ($value->status == 3) {
                                                                    echo (!empty($value->to_strees) ? $value->to_strees : '') . ' ' .
                                                                        (!empty($value->to_ward) ? $value->to_ward : '') . ' ' .
                                                                        (!empty($value->to_city) ? $value->to_city : '');
                                                                } else {
                                                                    echo (!empty($value->from_strees) ? $value->from_strees : '') . ' ' .
                                                                        (!empty($value->from_ward) ? $value->from_ward : '') . ' ' .
                                                                        (!empty($value->from_city) ? $value->from_city : '');
                                                                }   ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 65px">
                                                                <strong>Hiện tại:</strong>
                                                            </td>
                                                            <td>
                                                                <?php if ($value->status == 3) {
                                                                    echo !empty($value->noichuyendi) ? $value->noichuyendi : '';
                                                                } else {
                                                                    echo (!empty($value->to_strees) ? $value->to_strees : '') . ' ' .
                                                                        (!empty($value->to_ward) ? $value->to_ward : '') . ' ' .
                                                                        (!empty($value->to_city) ? $value->to_city : '');
                                                                }  ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <strong>
                                                                    Tên file:
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <?php echo isset($value->type) ? $value->type : '';  ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <strong>
                                                                    Ngày nhập:
                                                                </strong>
                                                            </td>
                                                            <td>
                                                                <?php echo isset($value->created) ? $value->created : '';  ?>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                                <td class="text-center">
                                                    <?php if ($value->is_insert == 1) {
                                                        echo '<span class="label label-success">Đã lưu</span>';
                                                    } else {
                                                        echo '<span class="label label-warning">Đã tồn tại</span>';
                                                    }  ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-xs btn-warning" ng-click="edit(<?php echo $value->nk_id ?>)">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<script>
    angular.module('app', [])
        .controller('nkCtrl', function($scope, $http) {
            $scope.init = () => {
                $scope.isView = 0;
                $scope.data = {
                    date: ''
                };
            }

            $scope.editDate = (id, date, dateTmp) => {
                $scope.isView = id;
                $scope.data.id = id;
                $scope.data.date = $('.bdate-' + id).text().replace(/ /g, "");
                $scope.data.date = $scope.data.date.replace(/\n/g, "");
            }

            $scope.saveDate = () => {
                $scope.isView = 0;
                let date = {
                    id: $scope.data.id,
                    date: $scope.data.date
                }

                $http.post(base_url + '/nhankhau/ajax_update_birtdate', date).then(r => {
                    if (r.data && r.data.status == 1) {
                        toastr['success']('Cập nhật thành công');
                        $('.bdate-' + $scope.data.id).text($scope.data.date);
                    } else {
                        toastr['error'](r.data && r.data.messages ? r.data.messages : 'Có lỗi xẩy ra! Vui lòng thử lại sau');
                    }
                })
            }

            $scope.edit = (id) => {
                window.open(base_url + '/nhankhau/edit/' + id)
            }
        })
</script>