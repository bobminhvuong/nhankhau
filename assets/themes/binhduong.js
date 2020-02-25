jQuery(document).ready(function($) {

    $("input.change-active").change(function () {
        if($(this).is(":checked")) {
            var active = 1;
        }
        else{
            var active = 0;
        }
        var id = $(this).val();
        var table = $(this).data('table');        
        $.ajax({
            url: base_url + "ajax/change_active",
            data: {'table': table, 'id': id, 'active': active},
            type: "POST",
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr["success"]("Cập nhật thành công");
                }else{
                    console.log('Error ');
                }
            }
        });
    });
    $(".add-service").click(function () {
        var service_quantity = $('input[name="service_quantity"]').val();
        var service_id = $('select[name="services"]').val();
        var service_name = $('select[name="services"] option:selected').text();
        if(service_quantity > 0){
            var content = '<p>'+service_quantity+' x '+service_name+' <span class="label label-danger empty-package-item">Xoá</span><input type="hidden" name="service-quantity[]" value="'+service_quantity+'"><input type="hidden" name="service-id[]" value="'+service_id+'"></p>';
            $('.list-services').append(content);
        } 
    });

    $(".add-product").click(function () {
        var product_quantity = $('input[name="product_quantity"]').val();
        var product_id = $('select[name="products"]').val();
        var product_name = $('select[name="products"] option:selected').text();
        if(product_quantity > 0){
            var content = '<p>'+product_quantity+' x '+product_name+' <span class="label label-danger empty-package-item">Xoá</span><input type="hidden" name="product-quantity[]" value="'+product_quantity+'"><input type="hidden" name="product-id[]" value="'+product_id+'"></p>';
            $('.list-products').append(content);
        } 
    });

    $(".remove-package-item").click(function () {
        var id = $(this).data('id');
        var table = $(this).data('table');     
        var parent = $(this).closest('p');
        $.ajax({
            url: base_url + "ajax/remove_package_item",
            data: {'table': table, 'id': id},
            type: "POST",
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr["success"]("Cập nhật thành công");
                    parent.remove();
                }else{
                    console.log('Error ');
                }
            }
        });
    });

    $(".remove-unit-item").click(function () {
        var id = $(this).data('id');    
        var parent = $(this).closest('tr');
        $.ajax({
            url: base_url + "ajax/remove_unit_item",
            data: {'id': id},
            type: "POST",
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr["success"]("Cập nhật thành công");
                    parent.remove();
                }else{
                    console.log('Error ');
                }
            }
        });
    });


    $("input.use-checkbox").change(function () {
        var parent = $(this).closest('tr');
        var id = $(this).val();
        var invoice_id = $('#invoice_id').val();
        var use_type = $(parent).find('input[name="use_type"]').val();
        var use_invoice_type = $(parent).find('select[name="use_invoice_type"]').val();
        var use_unit_id = $(parent).find('input[name="use_unit_id"]').val();
        var use_quantity = $(parent).find('select[name="use_quantity"]').val();  
        console.log('ajax');
        $.ajax({
            url: base_url + "ajax/use_init",
            data: {
                'customer_package_id': id, 
                'type': use_type,
                'invoice_id': invoice_id, 
                'invoice_type': use_invoice_type, 
                'unit_id': use_unit_id, 
                'quantity': use_quantity 
            },
            type: "POST",
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr["success"]("Cập nhật thành công");
                }else{
                    toastr["error"]("Đã có lỗi");
                }
            }
        });

    });

    if($('#accountant').length){
        var statistics = $('.accountant').html();
        $('#accountant').append(''+statistics+'');
    }

    if($('.btn-depot').length){
        $(".btn-depot").click(function () {  
            parent = $(this).closest('tr');    
            $(this).fadeOut();
            $(parent).find('input').removeClass('hide');
        });
    }

    $("#change-store").change(function () {
        var val = this.value;
        $.ajax({
            url: base_url + 'ajax/change_store',
            type: "POST",
            dataType: "json",
            data: {
                'val': val,
            },
            success: function(data){
                console.log(data.success);
                if(data.success){
                    location.reload();
                }else{
                    console.log('Error cmnr');
                }
            }
        });
    });

    if($('.form-users').length){
        $(".form-submit").empty();
        $(".form-users :input").click(function(event) {
            var id = $('input[name="id"]').val();
            var username = $('input[name="username"]').val();
            if (typeof id === "undefined") {id = 0;}
            $.ajax({
                url: base_url + 'admin_users/check_username',
                type: "POST",
                dataType: "json",
                data: {
                    'id': id,
                    'username': username,
                },
                success: function(data){
                    if(data.success){
                        $(".form-submit").html('<input class="btn btn-success" type="submit" name="save" value="Cập nhật">');
                    }else{
                        $(".form-submit").html('<div class="callout callout-warning"><a href="admin_users/edit/'+data.id+'"><h4>Tài khoản đã tồn tại!</h4><p>Xem chi tiết ở đây.</p></a></div>');
                    }
                }
            });
        });
    }

    if($('#normal').length){
        $('.nav-tabs li a').click(function(){
            var type = $(this).data('type');
            $('input[name="type"]').val(type);
        });
    }

    if($('.btn-rating').length){
        $('.btn-rating').click(function(){
            $(this).find('i').removeClass('hide');
            var id = $(this).data('id');
            $.ajax({
                url: base_url + 'ajax/rating',
                type: "POST",
                dataType: "json",
                data: {
                    'id': id,
                },
                success: function(data){
                    $('.btn-rating i').addClass('hide');
                    if(data.isset){
                        toastr["warning"]("Đã được đánh giá");
                    }else if(data.error){
                        toastr["error"]("Gửi đi thất bại");
                    }else if(data.success){
                        toastr["success"]("Yêu cầu thành công");
                    }else if(data.date){
                        toastr["warning"]("Không dùng được phiếu thu ngày trước");
                    }
                }
            });
        });
    }

    if($('.btn-verify').length){
        $('.btn-verify').click(function(){
            var title = $(this).html();
            var verify_status = $(this).data('status');
            var id = $(this).data('id');
            var table = $(this).data('table');
            var verify = $(this).closest('.verify');
            $(verify).find('.sublinks').toggleClass('in');
            $(verify).find('button.btn-xs').toggleClass('collapsed');
            $(verify).find('button.btn-xs').html('<i class="fa fa-spinner fa-spin"></i> Xử lý');
            $.ajax({
                url: base_url + 'ajax/verify',
                type: "POST",
                dataType: "json",
                data: {
                    'id': id,
                    'table': table,
                    'verify_status': verify_status
                },
                success: function(data){

                    if(data.error){
                        toastr["error"]("Gửi đi thất bại");
                    }else if(data.success){
                        toastr["success"]("Phê duyệt thành công");
                        $(verify).find('button.btn-xs').html(title);
                    }
                }
            });
        });
    }

    if($('.add-visa-value').length){
        $('.add-visa-value').click(function(){
            var name = $(this).data('name');
            if(name == 'code'){
                var input = '<input type="text" class="form-control" name="visa_code[]" placeholder="Nhập mã cấp phép">';
            }
            else if(name == 'file'){
                var input = '<input type="file" class="form-control" name="visa_file[]">';
            }
            $(this).closest('.form-group').find('.input-group').append(input);
        });

        $('.remove-visa-value').click(function(){
            var id = $(this).data('id');
            var parent = $(this).closest('label');
            $.ajax({
                url: base_url + 'invoices/remove_visa_value',
                type: "POST",
                dataType: "json",
                data: {
                    'id': id,
                },
                success: function(data){
                    if(data.error){
                        toastr["error"]("Gửi đi thất bại");
                    }else if(data.success){
                        toastr["success"]("Thành công");
                        parent.remove();
                    }

                }
            });
        });
       
    }

    $("select.ajax-change-category").change(function () {
        var val = $(this).val();
        var id = $(this).data('id');
        $.ajax({
            url: base_url + "ajax/change_category_service",
            data: {'id': id, 'val': val},
            type: "POST",
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr["success"]("Cập nhật thành công");
                }else{
                    console.log('Error');
                }
            }
        });
    });

    if($('.viewCustomerImages').length){
        $('.viewCustomerImages').click(function(){
            var id = $(this).data('id');
            $.ajax({
                url: base_url + 'appointments/customer_images',
                type: "POST",
                dataType: "text",
                data: {
                    'id': id,
                },
                success: function(data){
                    $('.modalCustomerImages .carousel-inner').html(data);
                    $('.modalCustomerImages').modal('show');
                }
            });
        });
       
    }

    // luyen add js
    
    //luyen end js
});


