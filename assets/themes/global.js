jQuery(document).ready(function($) {

    for (var i = 0; i < 25; i++) {
        UpdateLastAction(i);
    }

    function UpdateLastAction(i){
        setTimeout(function(){
            $.ajax({
                url: base_url + "ajax/update_last_action",
                data: {},
                type: "POST",
                dataType: "json",
                success: function(data){
                    if(data.success){
                        //toastr["success"]("Cập nhật Online");
                        var time = new Date().getHours() + "h:" + new Date().getMinutes()+"p";
                        console.log('Update Online in '+time);
                    }else{
                        //toastr["error"]("Cập nhật Online");
                        console.log('Error Online');
                    }
                }
            });
        }, i*60000);

    }

    $("input.change-appointment-status").click(function () {
        console.log('create invoice');
        var id = $(this).val(); 
        var parent = $(this).closest('td');  
        $.ajax({
            url: base_url + "appointments/change_status",
            data: {'id': id},
            type: "POST",
            dataType: "json",
            success: function(data){
                if(data.success){
                    toastr["success"]("Cập nhật thành công");
                    parent.html('<a target="blank" href="invoices/detail/'+data.invoice_id+'"><span class="label label-success">Chi tiết</span></a>');
                }else{
                    toastr["error"]("Đã có lỗi");
                }
            }
        });
    });
    	

    if($('input.number').length){
        $('input.number').number(true, 0, ",", ".");
    }

    $(".empty-package-item").click(function () {      
        $(this).closest('p').remove();
    });


    if($('.icheck-blue').length){
        $('.icheck-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    }
    if($('.icheck-green').length){
        $('.icheck-green').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    }


    if($('.select2').length){
        $(".select2").select2({
            placeholder: function($){
                $(this).data('placeholder');
            }
        });
    }
    
    if($('.datepicker').length){
        $( ".datepicker" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    if($('.monthpicker').length){
        $('.monthpicker').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'yy-mm',
            
            monthNamesShort: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7',
      'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
    ],
            onClose: function(dateText, inst) { 
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
    }
    
    if($('.timepicker').length){
        $(".timepicker").timepicker({
            showInputs: false,
            showMeridian:false
        });
    }

    if($('.tablelte-full').length){
        $('.tablelte-full').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            "language": {
                "search": "Tìm kiếm",
                "lengthMenu": "Hiển thị _MENU_",
                "zeroRecords": "Không tìm thấy dữ liệu",
                "info": "Đang hiển thị trang _PAGE_ ",
                "infoEmpty": "Không tìm thấy kết quả",
                "infoFiltered": "(Tìm kiếm trong tổng _MAX_ kết quả)",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước",
                }
            } 
        });
        $('.dt-buttons').remove();

    }

    if($('.tablelte-sort').length){
        $('.tablelte-sort').DataTable({
            "searching": false, 
            "paging": false, 
            "info": false,
            "order": [[ 2, 'desc' ]]
        });
    }


    
    if($('.tablelte-excel').length){
        $('.tablelte-excel').DataTable({
            dom: 'Bfrtip',
            "paging": false, 
            "searching": false,
            "ordering": false,
            "bInfo" : false,
            buttons: [
                { extend: 'excel',}
            ]
        });
       
    }

    if($('.tablelte-sort-excel').length){
        $('.tablelte-sort-excel').DataTable({
            "searching": false, 
            "paging": false, 
            "info": false,
            "order": [[ 2, 'desc' ]],
            dom: 'Bfrtip',
            buttons: [
                { extend: 'excel',}
            ]
        });
    }


    
    if($('.tablelte-full-excel').length){
        $('.tablelte-full-excel').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            "paging": false,
            "language": {
                "search": "Tìm kiếm",
                "lengthMenu": "Hiển thị _MENU_",
                "zeroRecords": "Không tìm thấy dữ liệu",
                "info": "Đang hiển thị trang _PAGE_ ",
                "infoEmpty": "Không tìm thấy kết quả",
                "infoFiltered": "(Tìm kiếm trong tổng _MAX_ kết quả)",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước",
                }
            } 
        });
    }
    
    if($('.textarea').length){
        $('.textarea').wysihtml5();
    }
    
    if($('#reportrange').length){
        var start = $('#reportrange').data('start');
        var end = $('#reportrange').data('end');
        if (typeof start === "undefined") {
            start = end = moment().format("MM/DD/YYYY");
        }
        $('#reportrange').daterangepicker({
            opens: 'right',
            alwaysShowCalendars: true,
            showCustomRangeLabel: false,
            startDate: start,
            endDate: end,
            ranges: {
               'Hôm nay': [moment(), moment()],
               'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               '7 ngày trước': [moment().subtract(6, 'days'), moment()],
               '30 ngày trước': [moment().subtract(29, 'days'), moment()],
               'Tháng này': [moment().startOf('month'), moment().endOf('month')],
               'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });
    }

    //son add new
    if($('#reportrange_invoices').length){
        var start_invoices = $('#reportrange_invoices').data('start');
        var end_invoices = $('#reportrange_invoices').data('end');
        if (typeof start_invoices === "undefined") {
            start_invoices = end_invoices = moment().format("MM/DD/YYYY HH:mm:ss");
        }
        $('#reportrange_invoices').daterangepicker({
            opens: 'right',
            alwaysShowCalendars: true,
            showCustomRangeLabel: false,
            startDate: start_invoices,
            endDate: end_invoices,
            timePicker: true,
            timePicker24Hour: true,
            timePickerSeconds: true,
            locale: {
                format: 'MM/DD/YYYY HH:mm:ss'
            },
            ranges: {
               'Hôm nay': [moment(), moment()],
               'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               '7 ngày trước': [moment().subtract(6, 'days'), moment()],
               '30 ngày trước': [moment().subtract(29, 'days'), moment()],
               'Tháng này': [moment().startOf('month'), moment().endOf('month')],
               'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });
    }

    if($('.percent-total').length){
        $(".percent-item").each(function(index) {
            var parent = $(this).closest('.box-primary');
            var total = $(parent).find('.percent-total').data('value');
            var value = $(this).data('value')
            var percent = value/total*100;

            var n = parseFloat(percent); 
            percent = Math.round(n * 1000)/1000; 
            $(this).html(percent+'%');
        });
    }   

});

jQuery(document).delegate('.empty-package-item', 'click', function(){
    $(this).closest('p').remove();
});