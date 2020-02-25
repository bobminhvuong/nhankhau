$(document).ready(function() {
	$(".add-invoice-products").click(function (event) {
		event.preventDefault();
		var product_type = $('select[name="product_type"]').val();
        var product_quantity = $('input[name="product_quantity"]').val();
        var product_id = $('select[name="products"]').val();
        var product_name = $('select[name="products"] option:selected').text();
        var product_discount = $('input[name="product_discount"]').val();
        var product_discount_type = $('select[name="product_discount_type"]').val();
        if(product_quantity > 0){
            if(product_discount > 0){
                swal({
                    title: "Lý do giảm giá",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    animation: "slide-from-top",
                    inputPlaceholder: "Nhập nội dung"
                }, function(inputValue) {
                    if (inputValue === false){ 
                        return false;
                    }
                    if (inputValue === "") {
                        swal.showInputError("Bắt buộc nhập nội dung!");
                        return false
                    }
                    swal({
                        title: "Thành công!",
                        text: "Nội dung: "+inputValue,
                        type: "success",
                        timer: 2000
                   });

                    var content = '<tr><td>'+product_type+'<input type="hidden" name="product-type[]" value="'+product_type+'"><input type="hidden" name="product-note[]" value="'+inputValue+'"></td><td>'+product_name+'<input type="hidden" name="product-id[]" value="'+product_id+'"></td><td>'+product_quantity+'<input type="hidden" name="product-quantity[]" value="'+product_quantity+'"></td><td>'+product_discount+'<input type="hidden" name="product-discount[]" value="'+product_discount+'"> '+product_discount_type+'<input type="hidden" name="product-discount-type[]" value="'+product_discount_type+'"></td><td class="text-center"><span class="label label-danger empty-invoice-item">Xoá</span></td></tr>';
                    $('.list-products').append(content);
                 
                });
            }else{
                 var content = '<tr><td>'+product_type+'<input type="hidden" name="product-type[]" value="'+product_type+'"><input type="hidden" name="product-note[]" value=""></td><td>'+product_name+'<input type="hidden" name="product-id[]" value="'+product_id+'"></td><td>'+product_quantity+'<input type="hidden" name="product-quantity[]" value="'+product_quantity+'"></td><td>'+product_discount+'<input type="hidden" name="product-discount[]" value="'+product_discount+'"> '+product_discount_type+'<input type="hidden" name="product-discount-type[]" value="'+product_discount_type+'"></td><td class="text-center"><span class="label label-danger empty-invoice-item">Xoá</span></td></tr>';
                    $('.list-products').append(content);
            }
        
            
        } 
    });

    $(".add-invoice-services").click(function (event) {
        event.preventDefault();
        var service_type = $('select[name="service_type"]').val();
        var service_id = $('select[name="services"]').val();
        var service_name = $('select[name="services"] option:selected').text();
        var service_discount = $('input[name="service_discount"]').val();
        var service_discount_type = $('select[name="service_discount_type"]').val();

        if(service_discount > 0){
            swal({
                title: "Lý do giảm giá",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Nhập nội dung"
            }, function(inputValue) {
                if (inputValue === false){ 
                    return false;
                }
                if (inputValue === "") {
                    swal.showInputError("Bắt buộc nhập nội dung!");
                    return false
                }
                swal({
                    title: "Thành công!",
                    text: "Nội dung: "+inputValue,
                    type: "success",
                    timer: 2000
               });

                var content = '<tr><td>'+service_type+'<input type="hidden" name="service-type[]" value="'+service_type+'"><input type="hidden" name="service-note[]" value="'+inputValue+'"></td><td>'+service_name+'<input type="hidden" name="service-id[]" value="'+service_id+'"></td><td>'+service_discount+'<input type="hidden" name="service-discount[]" value="'+service_discount+'"> '+service_discount_type+'<input type="hidden" name="service-discount-type[]" value="'+service_discount_type+'"></td><td class="text-center"><span class="label label-danger empty-invoice-item">Xoá</span></td></tr>';
                $('.list-services').append(content);
             
            });
        }else{
            var content = '<tr><td>'+service_type+'<input type="hidden" name="service-type[]" value="'+service_type+'"><input type="hidden" name="service-note[]" value=""></td><td>'+service_name+'<input type="hidden" name="service-id[]" value="'+service_id+'"></td><td>'+service_discount+'<input type="hidden" name="service-discount[]" value="'+service_discount+'"> '+service_discount_type+'<input type="hidden" name="service-discount-type[]" value="'+service_discount_type+'"></td><td class="text-center"><span class="label label-danger empty-invoice-item">Xoá</span></td></tr>';
            $('.list-services').append(content);
        }
    });

    $(".remove-invoice-item").click(function () {
        var id = $(this).data('id');
        var table = $(this).data('table');     
        var parent = $(this).closest('tr');
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
});


$(document).delegate('.empty-invoice-item', 'click', function(){
    $(this).closest('tr').remove();
});

