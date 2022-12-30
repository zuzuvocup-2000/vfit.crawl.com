(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
        $cart_button            = $('.add-cart'),
        $cart_modal            = $('.add_to_cart'),
        $cart_combo            = $('.btn-create-cart-combo');

	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };

    HT.add_cart = () => {
        if($cart_button.elExists){
            $cart_button.on('click', function(){
                let _this = $(this);
                let sku = _this.attr('data-sku');
                let qty = $('input[name="quantity"]').val();
                console.log(qty);
                let ajaxUrl = 'ajax/frontend/cart/insert';
                if(qty > 0){
                    $.post(ajaxUrl, {
                        sku: sku, qty: qty},
                        function(data){
                            let json = JSON.parse(data);
                            if(json.response.code == 10){
                                $('.hlm-qty').html(json.response.totalItems);
                                toastr.success('Thêm sản phẩm vào giỏ hàng thành công!');
                            }else{
                                toastr.error('Có lỗi xảy ra, vui lòng thử lại, mã lỗi: !' + json.response.code);
                            }
                        });
                }else{
                    toastr.error('Có lỗi xảy ra, bạn phải mua ít nhất 1 sản phẩm');
                }

            });
        }
    }

    HT.add_combo = () => {
        if($cart_combo.elExists){
            $cart_combo.on('click', function(){
                let id = [];
                let _this = $(this);
                let sku = _this.attr('data-sku');
                $('.checkbox-item:checked').each(function(){
                    let _this = $(this);
                    id.push(_this.val());
                });

                if(id.length > 0){
                    swal({
                        title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                        text: 'Thêm vào giỏ hàng các Combo được chọn?',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Thực hiện!",
                        cancelButtonText: "Hủy bỏ!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                    function (isConfirm) {
                        if (isConfirm) {
                            var formURL = 'ajax/frontend/cart/add_combo';
                            $.post(formURL, {
                                id: id,sku: sku },
                                function(data){
                                    let json = JSON.parse(data);
                                    if(json.response.code == 10){
                                        $('.hlm-qty').html(json.response.totalItems);
                                        swal("Thành công!", json.response.message , "success");
                                    }else{
                                        sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
                                    }
                                });
                        } else {
                            swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                        }
                    });
                }
                else{
                    sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
                    return false;
                }
                return false;
            });
        }
    }

    


    HT.add_cart_modal = () => {
        if($cart_modal.elExists){
            $cart_modal.on('click', function(){
                let _this = $(this);
                let sku = _this.attr('data-sku');
                let qty = $('#qtym_modal').val();
                console.log(qty);
                let ajaxUrl = 'ajax/frontend/cart/insert';
                if(qty > 0){
                    $.post(ajaxUrl, {
                        sku: sku, qty: qty},
                        function(data){
                            let json = JSON.parse(data);
                            if(json.response.code == 10){
                                $('.bag .number').html(json.response.totalItems);
                                toastr.success('Thêm sản phẩm vào giỏ hàng thành công!');
                            }else{
                                toastr.error('Có lỗi xảy ra, vui lòng thử lại, mã lỗi: !' + json.response.code);
                            }
                        });
                }else{
                    toastr.error('Có lỗi xảy ra, bạn phải mua ít nhất 1 sản phẩm');
                }

            });
        }
    }

    HT.render_cart = (sum) => {
        $('.new_price').each(function(){
            let abc = $(this).html();
            abc = parseFloat(abc.replaceAll('.',''))
            sum = sum + abc;
        })
        let discount = parseFloat($('#total_discount').attr('data-price')) / 100;
        let shipping = parseFloat($('#total_shipping').attr('data-price')) ;
        let new_sum= 0;
        new_sum = (sum * discount) + shipping;
        sum = sum.toString()
        new_sum = new_sum.toString()
        $('#subtotal').html(format_curency(sum) + 'đ');
        $('.pay_total').val(sum);
        $('#total').html(format_curency(new_sum) + 'đ');
        $('#total_primary').html(format_curency(new_sum) + 'đ');
    }
    HT.update = (__this, type) => {
        let _this = __this;
        let price = _this.parents('li').find('.price_view').html();
        let code = _this.parents('li').find('.productid_hidden').val();
        let quantity;
        if(type == 'button'){
             quantity = _this.siblings('.input-quantity').val()
        }else{
             quantity = _this.val()
        }
        let new_price = 0;
        let sum = 0;
        price = parseFloat(price.replaceAll('.',''))
        new_price = price*quantity;
        let form_URL = 'ajax/frontend/cart/change_quantity';
        $.post(form_URL, {
            quantity: quantity,code:code
        },
        function(data){
            new_price = new_price.toString()
            _this.parents('li').find('.new_price').html(format_curency(new_price) + 'đ');
            HT.render_cart(sum);
        });
    }

    HT.cart_update = () => {
        $('.input-quantity').on('change', function(){
            HT.update($(this));
    	})
        $('.button_quantity_cart').on('click', function(){
    		HT.update($(this), 'button');
    	})
    }

    HT.cart_remove = () => {
        $('.fc-cart-remove').on('click', function(){
    		let _this = $(this)
    		let code = _this.parents('li').find('.productid_hidden').val();
            let comboid = _this.attr('data-comboid')
            let type = _this.attr('data-type')
            let value = _this.attr('data-value')
            let sum = 0;
            
            if(comboid == ''){
        		let form_URL = 'ajax/frontend/cart/remove';
        		$.post(form_URL, {
        			code: code
        		},
        		function(data){
        			_this.parents('li').remove()
        			let count = $('.list-product-cart li').length;
        			$('.panel-head .count').html(count+' Sản phẩm');
                    $('.hlm-qty').html(count);
        			if(count == 0){
        				$('.list-product-cart').remove();
        				$('.panel-body ').append('<p class="info-cart text-danger">Chưa có đơn hàng nào được chọn</p>');
        				$('#subtotal').html(0);
        				$('#total').html(0);
        			}else{

                        HT.render_cart(sum);
        			}
        		});
            }else{
                swal({
                    title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                    text: 'Khi xóa sản phẩm này đồng nghĩa bạn sẽ xóa toàn bộ combo, bạn có chắc chắn khi sử dụng chức năng này?',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Thực hiện!",
                    cancelButtonText: "Hủy bỏ!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        var formURL = 'ajax/frontend/cart/remove_combo';
                        $.post(formURL, {
                            code: code,comboid: comboid,type: type ,value: value },
                        function(data){
                            let json = JSON.parse(data);
                            if(json.response.code == 10){
                                $('.cart-combo-'+comboid).remove()
                                let count = $('.list-product-cart li').length;
                                $('.panel-head .count').html(count+' Sản phẩm');
                                $('.hlm-qty').html(count);
                                if(count == 0){
                                    $('.list-product-cart').remove();
                                    $('.panel-body ').append('<p class="info-cart text-danger">Chưa có đơn hàng nào được chọn</p>');
                                    $('#subtotal').html(0);
                                    $('#total').html(0);
                                }else{
                                    HT.render_cart(sum);
                                }
                                swal("Thành công!", json.response.message , "success");
                            }else{
                                sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
                            }
                        });
                    } else {
                        swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
                    }
                });
            }
    	})
    }





  // Document ready functions
    $document.on('ready', function() {
        HT.add_cart();
        HT.cart_update();
        HT.add_combo();
        HT.cart_remove();
        HT.add_cart_modal();
    });

})(jQuery);
function sweet_error_alert(title, message){
    swal({
        title: title,
        text: message
    });
}

function format_curency(data) {
    let format = data.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    return format;
}
