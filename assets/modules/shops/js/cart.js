function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getQuerystring(key, default_) {
    if (default_ == null)
        default_ = "";
    key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
    var qs = regex.exec(window.location.href);
    if (qs == null)
        return default_;
    else
        return qs[1];
}

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?|&])" + key + "=.*?(&|#|$)", "i");
    if (uri.match(re)) {
        return uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        var hash = '';
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.indexOf('#') !== -1) {
            hash = uri.replace(/.*#/, '#');
            uri = uri.replace(/#.*/, '');
        }
        return uri + separator + key + "=" + value + hash;
    }
}

function deleteQueryStringParameter(key) {
    var url = document.location.href;
    var urlparts = url.split('?');

    if (urlparts.length >= 2) {
        var urlBase = urlparts.shift();
        var queryString = urlparts.join("?");

        var prefix = encodeURIComponent(key) + '=';
        var pars = queryString.split(/[&;]/g);
        for (var i = pars.length; i-- > 0;)
            if (pars[i].lastIndexOf(prefix, 0) !== -1)
                pars.splice(i, 1);
        if(pars.length){
            url = urlBase + '?' + pars.join('&');
        }else{
            url = urlBase;
        }
        window.history.pushState('', document.title, url);

    }
    return url;
}

function goToURLFilter(param, this_value, url = '') {
    var query_string_value = getQuerystring(param);
    var query_string_character = '?';

    if (document.location.search.length) {
        query_string_character = '&';
    }

    if($.trim(url) === ''){
        url = document.URL;
    }

    if (query_string_value === '') {
        window.location.href = url + query_string_character + param + '=' + this_value;
    } else {
        window.location.href = updateQueryStringParameter(url, param, this_value);
    }
}

$(document).ready(function() {
	$('.after-btn-cart').bootstrapNumber({
		upClass: "default btn-mini-cart-up",
		downClass: "default btn-mini-cart-down",
		center: true
	});
});

$(document).on('submit', '#f-add-to-cart', function() {
    var $this = $(this);
    var id = parseInt($this.find('input[name=product_id]').val());
    var qty = parseInt($this.find('input[name=qty]').val());
    var data = {
        'product_id': id,
        'qty': qty
    };
    var el_param = $this.find('input[name=param]');
    var el_access = $this.find('input[name=access]');
    if(el_param.length && el_access.length){
        data.param = el_param.val();
        data.access = el_access.val();
    }

    $.ajax({
        url: base_url + 'gio-hang-them-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.status === 'success') {
                $('.mini-cart').html(response.content);
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', '.btn-buy-now', function(event) {
    event.preventDefault();
    var $this = $(this).closest("form#f-add-to-cart");
    var id = parseInt($this.find('input[name=product_id]').val());
    var qty = parseInt($this.find('input[name=qty]').val());
    var data = {
        'product_id': id,
        'qty': qty
    };
    var el_param = $this.find('input[name=param]');
    var el_access = $this.find('input[name=access]');
    if(el_param.length && el_access.length){
        data.param = el_param.val();
        data.access = el_access.val();
    }

    $.ajax({
        url: base_url + 'gio-hang-them-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            alert(response.message);
            if (response.status === 'success') {
                $('.mini-cart').html(response.content);
                window.location.href = base_url + 'thanh-toan.html';
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', '.btn-add-to-cart', function(event) {
    event.preventDefault();
    var $this = $(this);
    var id = parseInt($this.attr('data-id'));
    var qty = 1;
    var data = {
        'product_id': id,
        'qty': qty
    };
    var url = $this.attr('data-url');
    var param = getParameterByName('param', url);
    var access = getParameterByName('access', url);
    if($.trim(param) != '' && $.trim(access) != ''){
        data.param = param;
        data.access = access;
    }

    $.ajax({
        url: base_url + 'gio-hang-them-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            alert(response.message);
            if (response.status === 'success') {
                $('.mini-cart').html(response.content);
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', "#btn-address-add", function (event) {
	$('#addressModal').modal('show');
});

$(document).on('click', ".btn-address-edit", function (event) {
	var id = parseInt($(this).attr('data-id'));
	if(id == 0){
		return false;
	}
    var data = {
        'id': id
    };
    $.ajax({
        url: base_url + 'get-address-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
            	var $this = $('#f-address-content');
            	var content = response.content.row;
            	$('#addressModalLabel').html('Cập nhật địa chỉ');
            	$this.find('input[name=id]').val(content.id);
            	$this.find('input[name=full_name]').val(content.full_name);
            	$this.find('input[name=place_of_receipt]').val(content.place_of_receipt);
            	$this.find('input[name=phone]').val(content.phone);
            	$this.find('select[name=province_id]').val(response.content.province);
            	$this.find('select[name=district_id]').html(response.content.district);
            	$this.find('select[name=commune_id]').html(response.content.commune);
                $('#addressModal').modal('show');
            }else{
                $('.address-message').html(response.message);
            }
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('submit', "#f-address-content", function (event) {
	var $this = $(this);
	var id = parseInt($this.find('input[name=id]').val());

	var el_full_name = $this.find('input[name=full_name]');
	var full_name = el_full_name.val();
	if($.trim(full_name) == ''){
		alert('Vui lòng nhập họ tên!');
		el_full_name.focus();
		return false;
	}

	var el_place_of_receipt = $this.find('input[name=place_of_receipt]');
	var place_of_receipt = el_place_of_receipt.val();
	if($.trim(place_of_receipt) == ''){
		alert('Vui lòng nhập địa chỉ nhận hàng (tầng, số nhà, đường)!');
		el_place_of_receipt.focus();
		return false;
	}

	var el_province_id = $this.find('select[name=province_id]');
	var province_id = parseInt(el_province_id.val());
	if(province_id == 0){
		alert('Vui lòng chọn tỉnh/thành phố!');
		el_province_id.focus();
		return false;
	}

	var el_district_id = $this.find('select[name=district_id]');
	var district_id = parseInt(el_district_id.val());
	if(district_id == 0){
		alert('Vui lòng chọn quận/huyện!');
		el_district_id.focus();
		return false;
	}

	var el_commune_id = $this.find('select[name=commune_id]');
	var commune_id = parseInt(el_commune_id.val());
	if(commune_id == 0){
		alert('Vui lòng chọn phường/xã!');
		el_commune_id.focus();
		return false;
	}

	var letter = /^\d{10,11}$/;
    var el_phone = $this.find('input[name=phone]');
    var phone = el_phone.val();
    if($.trim(phone) == ''){
        alert('Vui lòng nhập số điện thoại!');
        el_phone.focus();
        return false;
    }else if (!phone.match(letter)){
        alert('Số điện thoại không hợp lệ. Vui lòng nhập lại!');
        el_phone.focus();
        return false;
    }

	var data = {
	    'id': id,
	    'full_name': full_name,
	    'place_of_receipt': place_of_receipt,
	    'province_id': province_id,
	    'district_id': district_id,
	    'commune_id': commune_id,
	    'phone': phone
	};
	$.ajax({
	    url: base_url + 'content-address-ajax',
	    data: data,
	    type: 'POST',
	    dataType: 'json',
	    success: function (response) {
	        if (response.status === 'success') {
	        	$('.address-message').html(response.message);
	        	$('#addressModal').modal('hide');
	        	if(id > 0){
	        		var content = response.content;
	        		var item = $('.row-address-item-' + id);
	        		item.find('.address-full-name').html(content.full_name);
	        		item.find('.address-full-address').html(content.full_address);
	        		item.find('.address-phone').html(content.phone);
	        	}else{
	        		$('.address-list').append(response.content);
	        	}
	        }else{
	        	$('.address-modal-message').html(response.message);
	        }
	    },
	    error: function (e) {
	        console.log('Error processing your request: ' + e.responseText);
	    }
	});
	return false;
});

$(document).on('submit', "#f-address-checkout-content", function (event) {
    var $this = $(this);
    var id = parseInt($this.find('input[name=id]').val());

    var el_full_name = $this.find('input[name=full_name]');
    var full_name = el_full_name.val();
    if($.trim(full_name) == ''){
        alert('Vui lòng nhập họ tên!');
        el_full_name.focus();
        return false;
    }

    var el_place_of_receipt = $this.find('input[name=place_of_receipt]');
    var place_of_receipt = el_place_of_receipt.val();
    if($.trim(place_of_receipt) == ''){
        alert('Vui lòng nhập địa chỉ nhận hàng (tầng, số nhà, đường)!');
        el_place_of_receipt.focus();
        return false;
    }

    var el_province_id = $this.find('select[name=province_id]');
    var province_id = parseInt(el_province_id.val());
    if(province_id == 0){
        alert('Vui lòng chọn tỉnh/thành phố!');
        el_province_id.focus();
        return false;
    }

    var el_district_id = $this.find('select[name=district_id]');
    var district_id = parseInt(el_district_id.val());
    if(district_id == 0){
        alert('Vui lòng chọn quận/huyện!');
        el_district_id.focus();
        return false;
    }

    var el_commune_id = $this.find('select[name=commune_id]');
    var commune_id = parseInt(el_commune_id.val());
    if(commune_id == 0){
        alert('Vui lòng chọn phường/xã!');
        el_commune_id.focus();
        return false;
    }

    var letter = /^\d{10,11}$/;
    var el_phone = $this.find('input[name=phone]');
    var phone = el_phone.val();
    if($.trim(phone) == ''){
        alert('Vui lòng nhập số điện thoại!');
        el_phone.focus();
        return false;
    }else if (!phone.match(letter)){
        alert('Số điện thoại không hợp lệ. Vui lòng nhập lại!');
        el_phone.focus();
        return false;
    }

    var data = {
        'id': id,
        'full_name': full_name,
        'place_of_receipt': place_of_receipt,
        'province_id': province_id,
        'district_id': district_id,
        'commune_id': commune_id,
        'phone': phone
    };
    $.ajax({
        url: base_url + 'create-address-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('.address-message').html(response.message);
                $('#addressModal').modal('hide');
                $('.address-list').append(response.content);
                if($('.address-item').length){
                    $('.address-list, .btn-view-more-address, .btn-view-less-address').removeClass('d-none');
                }
            }else{
                $('.address-modal-message').html(response.message);
            }
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', ".btn-address-delete", function (event) {
    if (!confirm("Bạn có muốn xóa địa chỉ này?")){
        return false;
    }
    var item = $(this).closest('.block-address-item');
    var id = parseInt($(this).attr('data-id'));
    if(id == 0){
		return false;
	}
    var data = {
        'id': id
    };
    $.ajax({
        url: base_url + 'delete-address-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
        	$('.address-message').html(response.message);
            if (response.status === 'success') {
            	item.remove();
            }
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', ".btn-address-set-is-default", function (event) {
    if (!confirm("Bạn có muốn đặt địa chỉ này làm mặc định giao hàng?")){
        return false;
    }
});

$('#addressModal').on('shown.bs.modal', function() {
    var $this = $(this);
    $('.address-message').html('');
    $('.address-modal-message').html('');
});

$('#addressModal').on('hidden.bs.modal', function() {
    var $this = $(this);
    if($('#f-address-content').length){
        $('#f-address-content')[0].reset();
    }
    if($('#f-address-checkout-content').length){
        $('#f-address-checkout-content')[0].reset();
    }
    $this.find('input[name=id]').val(0);
    $('#addressModalLabel').html('Thêm địa chỉ');
    $('#el-province').trigger('change');
});

$(document).on('click', '.address-item', function (e) {
    e.preventDefault();
    if($(this).hasClass("active")){
        return false;
    }
    $(".address-item").removeClass("active");
    $('input[name=address_id]').removeAttr('checked');
    $(this).addClass("active");
    var $this = $(this).find('input[name=address_id]');
    $this.attr('checked', 'checked');
    $(".box-choices-address").removeClass("expanded");
    $(".address-item").addClass("d-none");
    var address_id = parseInt($this.val());
    if(address_id == 0){
        alert('Vui lòng chọn địa chỉ giao hàng!');
        return false;
    }
    var data = {
        'id' : address_id
    }
    $.ajax({
        url: base_url + 'get-address-cost-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('.fee-value').html(response.content.cost);
                $('.total-value').html(response.content.total);
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', '.btn-view-more-address, .btn-view-less-address', function (e) {
    e.preventDefault();
    var $this = $(this);
    $this.parents('.box-address-on-checkout').find('.box-choices-address').toggleClass('expanded');
    return true;
});

$(document).on('submit', "#f-checkout", function (event) {
    var $this = $(this);
    var address_id = 0;
    if($(this).find("input[name='address_id']:checked").length){
        address_id = parseInt($(this).find("input[name='address_id']:checked").val());
    }
    if(address_id == 0){
        alert('Vui lòng chọn địa chỉ giao hàng!');
        return false;
    }

    var el_full_name = $this.find('input[name=full_name]');
    var full_name = el_full_name.val();
    if($.trim(full_name) == ''){
        alert('Vui lòng nhập họ tên!');
        el_full_name.focus();
        return false;
    }

    var letter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var el_email = $this.find('input[name=email]');
    var email = el_email.val();
    if ($.trim(email) == '') {
        alert('Vui lòng nhập email!');
        el_email.focus();
        return false;
    }else if (!email.match(letter)){
        alert('Email không hợp lệ. Vui lòng nhập lại!');
        el_email.focus();
        return false;
    }

    var letter = /^\d{10,11}$/;
    var el_phone = $this.find('input[name=phone]');
    var phone = el_phone.val();
    if($.trim(phone) == ''){
        alert('Vui lòng nhập số điện thoại!');
        el_phone.focus();
        return false;
    }else if (!phone.match(letter)){
        alert('Số điện thoại không hợp lệ. Vui lòng nhập lại!');
        el_phone.focus();
        return false;
    }

    // var data = {
    //     'address_id': address_id,
    //     'full_name': full_name,
    //     'phone': phone
    // };
    // console.log(data); return false;
});

$(document).on('click', ".mini-cart-remove-item", function (e) {
    e.preventDefault();
    if(!confirm("Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?")){
        return false;
    }
    var rowid = $(this).attr('data-rowid');

    var data = {
        'rowid': rowid
    };
    $.ajax({
        url: base_url + 'gio-hang-xoa-san-pham-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('.mini-cart').html(response.content);
            }
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('click', ".btn-mini-cart-up, .btn-mini-cart-down", function (e) {
    $(this).closest('li').find('.mini-cart-qty').trigger('blur');
});

$(document).on('blur', ".mini-cart-qty", function (e) {
    var qty = parseInt($(this).val());
    var rowid = $(this).attr('data-rowid');
    if(qty <= 0){
        return false;
    }
    $(this).closest('li').addClass('my-active');

    var data = {
        'rowid': rowid,
        'qty': qty
    };
    $.ajax({
        url: base_url + 'gio-hang-cap-nhat-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                //$('.container-mini-cart li.my-active').find('.cart-subtotal').html(response.content.item.subtotal + ' ₫');
                $('#mini-cart-total').html(response.content.total + ' ₫');
            }
            $('.container-mini-cart li').removeClass('my-active');
        },
        error: function (e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('change', '#filter-by', function() {
    var param = 'filter';
    var this_value = $(this).val();
    var query_string_value = getQuerystring(param);
    var query_string_character = '?';

    if (document.location.search.length) {
        query_string_character = '&';
    }

    if (query_string_value === '') {
        window.location.href = document.URL + query_string_character + param + '=' + this_value;
    } else {
        window.location.href = updateQueryStringParameter(document.URL, param, this_value);
    }
});

$(document).on('change', '#per-page-by', function() {
    var param = 'per_page';
    var this_value = $(this).val();
    var query_string_value = getQuerystring(param);
    var query_string_character = '?';

    if (document.location.search.length) {
        query_string_character = '&';
    }

    if (query_string_value === '') {
        window.location.href = document.URL + query_string_character + param + '=' + this_value;
    } else {
        window.location.href = updateQueryStringParameter(document.URL, param, this_value);
    }
});

$(document).on('change', "#el-province", function(e) {
    $("#el-commune").html('<option value="0">-- Chọn phường/xã --</option>');
    var province = parseInt($(this).val());
    if (province == 0) {
        $("#el-district").html('<option value="0">-- Chọn quận/huyện --</option>');
        return false;
    }

    var data = {
        'id': province,
        'not_display_first': 1
    };
    $.ajax({
        url: base_url + 'gets-district-ajax',
        data: data,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $("#el-district").html('<option value="0">-- Chọn quận/huyện --</option>' + response.content.district);
            }
        },
        error: function(e) {
            console.log('Error processing your request: ' + e.responseText);
        }
    });
    return false;
});

$(document).on('change', "#el-district", function(e) {
    var district = parseInt($(this).val());
    if (district == 0) {
        $("#el-commune").html('<option value="0">-- Chọn phường/xã --</option>');
    } else {
        var data = {
            'id': district,
            'not_display_first': 1
        };
        $.ajax({
            url: base_url + 'gets-commune-ajax',
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $("#el-commune").html('<option value="0">-- Chọn phường/xã --</option>' + response.content.commune);
                }
            },
            error: function(e) {
                console.log('Error processing your request: ' + e.responseText);
            }
        });
    }

    return false;
});