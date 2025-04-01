function today() {
    var d = new Date();
    var curr_date = d.getDate();
    if (curr_date < 10) {
        curr_date = '0' + curr_date;
    }
    var curr_month = d.getMonth() + 1;
    if (curr_month < 10) {
        curr_month = '0' + curr_month;
    }
    var curr_year = d.getFullYear();
    var today = curr_date + "-" + curr_month + "-" + curr_year;

    return today;
}

$(function() {
    $('#datePickerStartday').datepicker({
        format: 'dd-mm-yyyy',
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        showOn: 'focus',
        language: 'vi',
        autoclose: true,
        startDate: today()
    });
});

$(document).ready(function() {
	jQuery.validator.addMethod("phoneCheck", function () {
        var isSuccess = false;
        var phone = $('#phone').val();

        var id = 0;
        if ($('#id').length) {
            id = $('#id').val();
        }

        var data = {'phone': phone, 'id': id, 'ajax': 1};
		//console.log(data);
        $.ajax({
            url: base_url + 'admin/emails/customers/check-phone-availablity',
            type: 'POST',
            async: false,
            data: data,
            success: function (response) {
                var getData = $.parseJSON(response);
                if (getData.status === 'success') {
                    isSuccess = true;
                }
            }
        });

        return isSuccess;
    }, 'Số điện thoại này đã tồn tại');

    $("#f-content").validate({
        rules: {
            full_name: {
                required: true
            },
			phone: {
                required: true,
                phoneCheck: true
            }
        },
        messages: {
            full_name: {
                required: 'Nhập tên khách hàng'
            },
			phone: {
                required: 'Nhập số điện thoại'
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});