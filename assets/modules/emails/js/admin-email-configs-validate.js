$(document).ready(function() {
    $("#f-content").validate({
        rules: {
            protocol: {
                required: true
            },
            smtp_host: {
                required: true
            },
            smtp_port: {
                required: true
            },
            smtp_user: {
                required: true
            }
        },
        messages: {
            protocol: {
                required: 'Nhập protocol'
            },
            smtp_host: {
                required: 'Nhập SMTP host'
            },
            smtp_port: {
                required: 'Nhập SMTP port'
            },
            smtp_user: {
                required: 'Nhập email'
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