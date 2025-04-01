$(document).on('click', '#insert-code-tag', function() {
    var code_tag = $("#variable_name").val();
    if ($.trim(code_tag) == '') {
        return false;
    }
    CKEDITOR.instances.bodyhtml.insertText(code_tag); //chen text
    /*
    var oEditor = CKEDITOR.instances.bodyhtml;
    var fragment = oEditor.getSelection().getRanges()[0].extractContents();
    var container = CKEDITOR.dom.element.createFromHtml("<br/>", oEditor.document);//chen the html
    console.log(fragment);
    fragment.appendTo(container);
    oEditor.insertElement(container);
    */
});

$(document).on('change', "#template", function() {
    var id = parseInt($(this).val());
    var content_confirm = "Bạn muốn xóa tất cả nội dung đang có?";
    if (id != 0) {
        content_confirm = "Bạn muốn email mẫu được chọn sẽ ghi đè lên nội dung đang có?";
    }

    var r = confirm(content_confirm);
    if (r != true) {
        return false;
    } else {
        if (id == 0) {
            CKEDITOR.instances.bodyhtml.setData('');
        } else {
            var strURL = base_url + 'admin/emails/template/ajax-get';
            var data = { 'id': id };
            $.ajax({
                url: strURL,
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    CKEDITOR.instances.bodyhtml.setData(response.content.bodyhtml);
                },
                error: function(e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
            return false;
        }
    }
});

$(document).on('change', "#variable_label", function() {
    var key = $(this).val();
    if ($.trim(key) == '') {
        $("#variable_name").val('');
        return false;
    }

    var data = {
        'key': key
    };
    $.ajax({
        url: base_url + 'admin/emails/ajax_get_code_tag',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            $("#variable_name").val(response.content);
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });

    return false;
});

$(document).on('click', "#send", function() {
    $('#status').val(1);
});

$(document).on('click', "#drap", function() {
    $('#status').val(0);
});

$(document).ready(function() {
    $("#f-content").validate({
        ignore: [],
        rules: {
            full_name: {
                required: true
            },
            email: {
                required: true
            },
            // "mailings[]": {
            //     required: true
            // },
            "mailings_group[]": {
                required: true
            },
            subject: {
                required: true
            },
            bodyhtml: {
                required: function() {
                    CKEDITOR.instances.bodyhtml.updateElement();
                }
            }
        },
        messages: {
            full_name: {
                required: 'Nhập họ tên người gửi'
            },
            email: {
                required: 'Nhập email người gửi'
            },
            // "mailings[]": {
            //     required: 'Chọn danh sách người nhận'
            // },
            "mailings_group[]": {
                required: 'Chọn nhóm người nhận'
            },
            subject: {
                required: 'Nhập tiêu đề gửi mail'
            },
            bodyhtml: {
                required: 'Nhập nội dung gửi mail'
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
    $(".chosen-select").chosen({ search_contains: true });
});