//get-link-and-copy
var clipboard = new Clipboard('.btn-copy');
$(document).on("click", ".open-popup-get-link-modal", function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var data = {
        'id': id
    };
    $.ajax({
        url: base_url + 'get-product-link-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            //console.log(response);
            if (response.status === 'success') {
                $("#link-share-product").val(response.content);
                $("#get-link-modal").modal("show");
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on("click", ".btn-get-travel-link", function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    var data = {
        'id': id
    };
    $.ajax({
        url: base_url + 'get-travel-link-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            if (response.status === 'success') {
                $("#link-share-product").val(response.content);
                $("#get-link-modal").modal("show");
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$('#get-link-modal').on('shown.bs.modal', function() {
    $("#link-share-product").focus();
    $("#link-share-product").select();
});