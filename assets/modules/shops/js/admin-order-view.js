//<![CDATA[
$(document).on("click", ".btn-print", function() {
    $("#element-print").print({
        globalStyles: true,
        mediaPrint: false,
        stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
        noPrintSelector: ".noPrint"
    });
});

$(document).on("click", ".btn-confirm", function() {
    bootbox.confirm("Bạn có xác nhận thanh toán đơn hàng này?", function(result) {
        if (result === true) {
            var id = parseInt($(".btn-confirm").attr('data-id'));
            $('#notify').html('Đang xử lý...').fadeIn(5000);
            var data = {
                'id': id,
                'status': 1
            };
            $.ajax({
                url: base_url + 'admin/orders/confirm-ajax',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $("#notify").html(response.message);
                    if (response.status === 'success') {
                        $('.btn-group-action').remove();
                        $("#btn-group-action").prepend('<button class="btn btn-success" type="button">Đã thanh toán</button>');
                        $(".payment").text('Đã thanh toán');
                    }
                },
                error: function(e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
        }
    });
    return false;
});

$(document).on("click", ".btn-cancel", function() {
    bootbox.confirm("Bạn có hủy đặt phòng khách sạn này?", function(result) {
        if (result === true) {
            var id = parseInt($(".btn-confirm").attr('data-id'));
            $('#notify').html('Đang xử lý...').fadeIn(5000);
            var data = {
                'id': id,
                'status': -1
            };
            $.ajax({
                url: base_url + 'admin/orders/confirm-ajax',
                data: data,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    $("#notify").html(response.message);
                    if (response.status === 'success') {
                        $('.btn-group-action').remove();
                        $("#btn-group-action").prepend('<button class="btn btn-danger" type="button">Đã hủy</button>');
                        $(".payment").text('Đã hủy');
                    }
                },
                error: function(e) {
                    console.log('Error processing your request: ' + e.responseText);
                }
            });
        }
    });
    return false;
});
//]]>