//<![CDATA[
$(document).ready(function() {
    $('form[name=main]').submit(function (event) {
        var action = $('select[name="action"]').val();
        if (action === 'delete') {
            if (confirm("Bạn có thật sự muốn xóa các hình ảnh này? Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa. Bạn sẽ không thể phục hồi lại chúng sau này!")) {
                return true;
            }
            return false;
        }
    });

    $('.delete_bootbox').on('click', function(e, confirmed) {
        var link = $(this).attr('href');
        if (!confirmed) {
            e.preventDefault();
            BootstrapDialog.confirm({
                title: 'XÁC NHẬN THÔNG TIN',
                message: 'Bạn có thật sự muốn xóa ảnh này? Nếu đồng ý, tất cả dữ liệu liên quan sẽ bị xóa. Bạn sẽ không thể phục hồi lại chúng sau này!',
                type: BootstrapDialog.TYPE_DANGER,
                closable: true,
                draggable: true,
                btnCancelLabel: 'Hủy bỏ',
                btnOKLabel: 'Đồng ý',
                btnOKClass: 'btn-primary',
                callback: function(result) {
                    if (result) {
                        window.location.href = link;
                    }
                }
            });
        }
    });

    $(".change-status").on('ifChanged', function () {
        var id = $(this).val();
        if ($(this).is(':checked')) {
            var form_data = {'id': id, 'value': 1};
        } else {
            var form_data = {'id': id, 'value': 0};
        }

        $.ajax({
            type: "POST",
            url: base_url + 'admin/images/change-status',
            data: form_data,
            success: function (html) {
                $("#notify").html(html);
            }
        });

        return false;
    });
});
//]]>