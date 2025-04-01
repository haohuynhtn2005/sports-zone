$(document).ready(function() {
    $("#f-content").validate({
        rules: {
            title: {
                required: true
            }
        },
        messages: {
            title: {
                required: 'Nhập tiêu đề hình ảnh'
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

$(document).on('click', '.remove-element', function () {
    $(this).closest('.container-element').remove();
});
$(document).on('click', '#more-attributes', function (e) {
    e.preventDefault();
    var data = {'attribute': 'attributes'};
    $.ajax({
        url: base_url + 'admin/images/get-attribute-ajax',
        type: 'POST',
        async: false,
        data: data,
        success: function (html) {
            $(html).appendTo("#attributes");
        }
    });
    return false;
});