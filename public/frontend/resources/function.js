var inview_together = true;
$(document).ready(function(){
	$('.buy-together').on('inview', function(event, isInView) {
		if(inview_together == true){
		  	if (isInView) {
		  		inview_together = false;
				let _this = $(this);
				let load = render_loading();
				let id = _this.attr('data-id');
				let module = _this.attr('data-module');
				_this.find('.wrap-combo-list').html(load)
				setTimeout(function(){
					let ajaxUrl = "ajax/frontend/dashboard/view_combo";
					$.ajax({
						method: "POST",
						url: ajaxUrl,
						data: {id: id, module: module},
						dataType: "json",
						cache: false,
						success: function(data){
							_this.find('.wrap-combo-list').html('')
							let html  = render_combo(data.data);
							_this.find('.wrap-combo-list').append(html)
						}
					});
				} , 300);
		  	}
		}
	});

	$(document).on('click','.open-category', function(){
		let _this = $(this)
		$('.list-menu-hd').toggleClass('active')
		return false;
	})

	$(document).on('click','.open-search-hd', function(){
		let _this = $(this)
		$('.search-hd').toggleClass('active')
		return false;
	})
	$(document).on('click','.share_link', function(){
		let _this = $(this)
		let canonical = $('.input_link_share').val();
		$('.input_link_share').val($('.input_link_share').val()).select();
		document.execCommand("copy");
		_this.html('Copied')
		setTimeout(function(){
			_this.html('Copy')
		} , 3000);
		return false;
	})

	$('.trailer-item').click(function(){
		let playIcon = '<svg fill="none" height="2em" viewBox="0 0 25 25" width="2em" class="mc-mr-3 mc-icon--3 play-icon"><circle cx="12.938" cy="12.938" fill="#191c21" opacity="0.6" r="12.063"></circle><path clip-rule="evenodd" d="M17.294 12.774l-5.67-3.679a.634.634 0 00-.57-.05c-.186.075-.304.23-.304.401v7.358c0 .17.118.326.304.401a.636.636 0 00.57-.05l5.67-3.68a.423.423 0 00.206-.35.423.423 0 00-.206-.35z" fill="#fff" fill-rule="evenodd"></path></svg>';
		let pauseIcon = '<svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-mr-3 mc-icon--3"><path d="M7.5 17.25V6.75H9v10.5H7.5z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M6.75 6.75A.75.75 0 017.5 6H9a.75.75 0 01.75.75v10.5A.75.75 0 019 18H7.5a.75.75 0 01-.75-.75V6.75z" fill="currentColor"></path><path d="M15 17.25V6.75h1.5v10.5H15z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M14.25 6.75A.75.75 0 0115 6h1.5a.75.75 0 01.75.75v10.5a.75.75 0 01-.75.75H15a.75.75 0 01-.75-.75V6.75z" fill="currentColor"></path></svg>';
		let _this = $(this);

		_this.removeClass('active');
		$('.trailer-item .icon').html(playIcon);
		let video = _this.attr('data-video')
		video = b64DecodeUnicode(video)


		_this.find('.icon').html(pauseIcon);
		_this.addClass('active');
		$('.main-screen-video').html(video)
	});

	$(document).on('click','.btn-modal-iframe', function(){
        let _this = $(this);
        let iframe = _this.attr('data-iframe')
        iframe = b64DecodeUnicode(iframe)

        $('.modal-iframe').html(iframe);
        return false;
    });
	function render_combo(data){
		let html = '';

		$.each( data, function( key, value ) {
			html = html+'<div class="p-item mb10">';
				html = html+'<div class="uk-flex uk-flex-middle uk-flex-space-between">';
					html = html+'<div class="checkbox" style="width: 30px;">';
						html = html+'<input type="checkbox" class="checkbox-item" name="pick" value="'+value[0].id+'">';
					html = html+'</div>';
					html = html+'<div class="wrap-combo w100">'
						$.each( value, function( keyChild, valueChild ) {
							let show_price = 0;
							let new_price = 0;
							html = html+'<div class="uk-flex uk-flex-middle w100">';
								html = html+'<div class="product-image mr5" style="width: 48px">';
									html = html+'<a href="'+valueChild.canonical+SUFFIX+'" title="'+valueChild.title+'" class="image img-scaledown">';
										html = html+'<img src="'+valueChild.image+'" alt="'+valueChild.title+'">';
									html = html+'</a>';
								html = html+'</div>';
								html = html+'<div class="product-name limit-line-2 mr5" style="width: calc(100% - 138px)">';
									html = html+valueChild.title;
								html = html+'</div>';
								show_price = parseFloat((valueChild.price_promotion > 0 ? valueChild.price_promotion : valueChild.price ));
								if(valueChild.type == 'normal'){
									new_price = ((show_price > valueChild.value) ? (show_price - valueChild.value) : show_price);
								}else if(valueChild.type == 'percent'){
									new_price = ((valueChild.value > 0) ? (show_price - (show_price * valueChild.value /100) ) : show_price);
								}
								html = html+'<div class="product-price" style="width: 80px">';
									html = html+'<div class="fs-price">'+format_curency(String(new_price))+'??</div>';
									html = html+'<div class="s-price">'+format_curency(String(show_price))+'??</div>';
								html = html+'</div>';
							html = html+'</div>';
						})
					html = html+'</div>';
				html = html+'</div>';
			html = html+'</div>';
		})
		return html ;
	}
	$(document).on('click','.btn-modal-iframe', function(){
		let _this = $(this);
		let iframe = _this.attr('data-iframe')
		iframe = atob(iframe)
		$('.modal-iframe').html('');
		$('.modal-iframe').html(iframe);
		return false;
	});

	if($('.datetimepicker').length > 0){
		$('.datetimepicker').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true,
			dateFormat: "dd/mm/yy"
		});
	}





	$(document).on('click','.product-view-detail', function(){
		let _this = $(this);
		let id = _this.attr('data-id');
		let $module = _this.attr('data-module');
		var formURL = 'ajax/frontend/dashboard/get_modal_product';

		$.post(formURL, {
			id: id,module: $module},
			function(data){
				let json = JSON.parse(data)
				console.log(json);
				let owlInit = {
			        'margin' : 20,
			        'lazyload' : true,
			        'nav' : false,
			        'dots' : false,
			        'loop' : true,
			        'items': 1
			    };

				let slide = '';
				slide = slide + '<div class="owl-slide">';
					slide = slide + '<ul class="owl-carousel owl-theme" >';
						for (var i = 0; i < json.album.length; i++) {
							slide = slide + '<li>';
					       	 	slide = slide + '<img src="'+json.album[i]+'"  alt="'+json.title+'">';
					    	slide = slide + '</li>';
						}
					slide = slide + '</ul>';
				slide = slide + '</div>';
			 	let $price_cart = ((json.price_promotion != 0) ? json.price_promotion : json.price);
				$price_cart = parseFloat($price_cart.replaceAll('.',''))
				let $avatar_cart = ((json.album.length > 0) ? json.album[0] : 'public/not-found.png');
			    let data_array = {
			        'title' : json.title,
			        'price' : $price_cart,
			        'avatar' : $avatar_cart,
			        'code' : json.productid,
			        'url' : json.canonical,
			    };
				$('.slide-img-modal').html(slide)
				$('.product-modal-title').html(json.title)
				if(json.price_promotion == 0){
					$('.product-modal-price .old').removeClass('line-price')
					$('.product-modal-price .old').html(json.price)
					$('.product-modal-price .new').hide()
				}else{
					$('.product-modal-price .new').html(json.price_promotion)
					$('.product-modal-price .old').html(json.price)
				}
				// let decode = btoa(unescape(encodeURIComponent(JSON.stringify(data_array))));
				let sku = 'SKU_'+id;
				$('.btn_add_cart').attr('data-sku', sku)
				$('.slide-img-modal .owl-slide .owl-carousel').each(function() {
		            $(this).owlCarousel(owlInit);
		        });

			});
		return false;
	});
	$(document).on('click','.search-box .input-submit', function(){
		let _this = $(this);
		let canonical = $('.search-dropdown').val();
		let keyword = $('.form-search input').val()
		if(canonical == 0){
			window.location.href = BASE_URL+'tat-ca-san-pham'+SUFFIX+'?keyword='+slug(keyword);
		}else{
			window.location.href = BASE_URL+canonical+SUFFIX+'?keyword='+slug(keyword)+'&cat='+canonical;
		}
		return false;
	});

	$(document).on('change','.form-wholesale input[name=wholesale]', function(){
		let _this = $(this);
		let val = _this.val();
		$('.product-detail-body').find('.wrap-price .new').html(format_curency(val)+' ??')
		return false;
	});

	// $(document).on('click','.btn-finish-cart', function(){
	// 	let _this = $(this);
	// 	let form = $('.form-cart').serializeArray()
	// 	let error = false;
	// 	for (var i = 0; i < form.length - 1; i++) {
	// 		error = true;
	// 		break;
	// 	}
	// 	if(error == true){
	// 		toastr.error('Vui l??ng ??i???n ?????y ????? th??ng tin giao h??ng!','Xin vui l??ng th??? l???i!');
	// 		return false;
	// 	}
	// });
	// ========================================== Comment =======================================================

	// Ch???n b???t t???t view

	$(document).on('click','.publishonoffswitch', function(){
		let _this = $(this);
		let id = _this.attr('data-id');
		let field = _this.attr('data-field');
		let $module = _this.attr('data-module');
		var formURL = 'ajax/dashboard/update_field';

		$.post(formURL, {
			id: id,module: $module, field:field},
			function(data){
				if(data == 0){
					sweet_error_alert('C?? l???i x???y ra! Xin vui l??ng th??? l???i!')
				}else{
					let json = JSON.parse(data);
					let text = (json.value == 1) ? true : false;
					if(text == true){
						_this.find('input').prop('checked',true)
					}else{
						_this.find('input').prop('checked',false)
					}
				}
			});
		return false;
	});

	$(document).ready(function(){

		let count_li = $('.list-comment-item').length;
		if(count_li > 3){
	    	$('.list-comment-item').eq(2).nextAll().hide().addClass('primary-comment').removeClass('ajax_get_cmt');
	  		$('.loadmore-cmt').show()
	    	$('.btn-loadmore-cmt').html('Xem th??m t???t c??? b??nh lu???n');
	  	}else{
	  		$('.loadmore-cmt').hide()
	  	}
	})

	$(document).on('click','.btn-loadmore-cmt', function(){
	  	if( $(this).hasClass('loadless') ){
	    	$(this).text('Xem th??m t???t c??? b??nh lu???n').removeClass('loadless');
	  	}else{
	    	$(this).text('R??t g???n').addClass('loadless');
	  	}
	  	$('.list-comment-item.primary-comment').slideToggle();
	  	$('.list-comment-item.primary-comment').each(function(){
			let _this = $(this);
			let val = _this.find('.admin_select_hidden').attr('data-value');
			let load = render_loading();
			_this.find('.list-reply').html(load)
			setTimeout(function(){
				let ajaxUrl = "ajax/frontend/dashboard/view_sub_comment";
				$.ajax({
					method: "POST",
					url: ajaxUrl,
					data: {val: val},
					dataType: "json",
					cache: false,
					success: function(data){
						_this.find('.list-reply').html('')
						let html  = sub_comment(data);
						_this.find('.list-reply').append(html)
						jQuery("time.sub_comment_timeago").timeago();
						more_less_subcomment(_this)
					}
				});
			} , 300);
		})
	  	return false;
	});

	// H???y/t???t ?? input cmt

	$(document).on('click' , '.cancel-cmt .btn-cancel' , function(){
		let _this = $(this);

		let dataInfo  = _this.attr('data-info');
		data = window.atob(dataInfo); //decode base64
		let json = JSON.parse(data);

		let param = {
			'id' : _this.attr('data-id'),
			'table' : _this.attr('data-table'),
			'parentid' : json.parentid,
			'fullname' : json.fullname,
			'comment' : json.comment,
			'image' : (json.image.length)? JSON.parse(json.image) : json.image,
			'dataInfo' : dataInfo,
			'created' : json.created_at,
			'updated' : (typeof(json.updated) != "undefined")? json.updated : "0000-00-00 00:00:00",
		};

		let prevHtml = get_prev_html(param);
		_this.closest('li').html('').html(prevHtml);
		jQuery("time.sub_comment_timeago").timeago();
		return false;
	});


	// S???a cmt

	$(document).on('click' , '.edit-cmt .btn-edit' , function(){
		let _this = $(this);
		let liComment = _this.closest('li');
		let dataInfo  = _this.attr('data-info');
		data = window.atob(dataInfo); //decode base64
		let json = JSON.parse(data); // chuy???n string v??? object
		let param = {
			'id' : _this.attr('data-id'),
			'table' : _this.attr('data-table'),
			'parentid' : json.parentid,
			'fullname' : json.fullname,
			'comment' : json.comment,
			'image' : (json.image.length > 0)? JSON.parse(json.image) : json.image,
			'dataInfo' : dataInfo,
		};
		console.log(param);
		let htmlEdit = get_edit_comment_html(param);
		_this.closest('li').html('').html(htmlEdit);
		let textReply = liComment.find('.text-reply');
		textReply.val(textReply.val() + ' ').focus();
		return false;
	});

	var inview = true;


	// Khi load ?????n th?? b???t ?????u l???y cmt con

	$('.in-active').on('inview', function(event, isInView) {
		if(inview == true){
		  	if (isInView) {
		  		inview = false;
		    	$('.list-comment-item.ajax_get_cmt').each(function(){
					let _this = $(this);
					let val = _this.find('.admin_select_hidden').attr('data-value');
					let load = render_loading();
					_this.find('.list-reply').html(load)
					setTimeout(function(){
						let ajaxUrl = "ajax/frontend/dashboard/view_sub_comment";
						$.ajax({
							method: "POST",
							url: ajaxUrl,
							data: {val: val},
							dataType: "json",
							cache: false,
							success: function(data){
								_this.find('.list-reply').html('')
								let html  = sub_comment(data);
								_this.find('.list-reply').append(html)
								jQuery("time.sub_comment_timeago").timeago();
								more_less_subcomment(_this)
							}
						});
					} , 300);
				})
		  	}
		}
	});

	$(document).on('keyup' , '.text-reply', function(){
		let _this = $(this);

		let text = $.trim(_this.val()); //x??a kho???ng tr???ng
		let galleryBlock = _this.closest('.box-reply').find('.gallery-block'); //kh???i h??nh ???nh ??? phi??n hi???n t???i
		let btnSubmit = _this.closest('.box-reply').find('.btn-submit'); //n??t g???i cmt

		if(text.length <= 0 && galleryBlock.is(":hidden")){
			// ???n n??t g???i cmt
			btnSubmit.attr('disabled', '');
		}else{
			btnSubmit.removeAttr('disabled');
		}

		return false;
	});

	$(document).on('click' , '.sent-cmt .btn-submit', function(){
		//l???y th??ng tin comment: t??n, n???i dung
		let _this = $(this);
		let html = render_loading();

		let user = _this.parents('.admin_select_hidden').attr('data-user')
		let value = _this.parents('.admin_select_hidden').attr('data-value')
		let album = [];
		_this.closest('form').find('input[name="album[]"]').each(function(){
			let abc = $(this).val();
			album.push(abc);
		})
		console.log(album);
		let reply = $('.text-reply').val()
		_this.parents('.show-reply').find('.bg-loading').html(html)
		$('.bg-loading').siblings('form').hide();
		setTimeout(function(){
			let ajaxUrl = "ajax/frontend/dashboard/reply_comment";
			$.ajax({
				method: "POST",
				url: ajaxUrl,
				data: {user: user, value: value, reply: reply, album:album},
				dataType: "json",
				cache: false,
				success: function(data){
					_this.parents('.show-reply').find('.bg-loading').html('')
					let $array = [];
					$array.push(data)
					let list  = sub_comment($array);
					_this.parents('.show-reply').siblings('.wrap-list-reply').find('.list-reply').append(list)
					jQuery("time.sub_comment_timeago").timeago();
					_this.parents('.show-reply').siblings('._cmt-reply').find('.btn-reply').attr('data-comment', 1)
					_this.parents('.show-reply').siblings('._cmt-reply').find('.btn-reply').html('Tr??? l???i');

				}
			});
		} , 300);

		return false;
	});

	$(document).on('click' , '.update-cmt .btn-submit:enabled' , function(){
		let _this = $(this);

		let comment = _this.closest('.box-reply').find('.text-reply').val();
		let album = []; // list ???nh

		_this.closest('.box-reply').find('.album').each(function(){
			album.push($(this).val());
		});

		let dataInfo = _this.closest('.comment').find('.btn-cancel').attr('data-info');
		data = window.atob(dataInfo); //decode base64
		let json = JSON.parse(data); // convert chu???i th??nh object

		let param = {
			'comment' : comment,
			'album' : album,
			'id' : _this.attr('data-id'),
			'parentid' : json.parentid,
			'fullname' : json.fullname,
			'dataInfo' : json,
		};
		console.log(param);
		let ajaxUrl = "ajax/frontend/dashboard/update_comment";
		$.ajax({
			method: "POST",
			url: ajaxUrl,
			data: {param: param, comment: param.comment},
			dataType: "json",
			cache: false,
			success: function(json){
				if(json == 0){
					swal("C???p nh???t th??nh c??ng!", "B??nh lu???n ???? ???????c c???p nh???t.", "success");
				}else{
					swal("C???p nh???t kh??ng th??nh c??ng!", "???? c?? l???i x???y ra.", "error");
				}
			}
		});
	})

	$(document).on('click' , '.delete-cmt .btn-delete' , function(){
		let _this = $(this);
		_this.siblings('.ajax-delete').trigger('click');
		return false;
	});

	/* X??A RECORD */
	$(document).on('click','.ajax-delete',function(){
		let _this = $(this);
		let param = {
			'title' : _this.attr('data-title'),
			'name'  : _this.attr('data-name'),
			'table': _this.attr('data-table'),
			'id'    : _this.attr('data-id'),
			'child' : _this.attr('data-child'),
		}
		let closest = _this.attr('data-closest'); // ????y l?? kh???i m?? s??? ???n sau khi x??a
		let listReply = _this.closest('.list-reply');
		let numReply = _this.closest('.cmt-content').find('.num-reply');
		swal({
			title: "H??y ch???c ch???n r???ng b???n mu???n th???c hi???n thao t??c n??y?",
			text: param.title,
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Th???c hi???n!",
			cancelButtonText: "H???y b???!",
			closeOnConfirm: false,
			closeOnCancel: false },
			function (isConfirm) {
				if (isConfirm) {
					let ajaxUrl = 'ajax/frontend/dashboard/ajax_delete';
					$.ajax({
						method: "POST",
						url: ajaxUrl,
						data: {table: param.table, id: param.id},
						dataType: 'json',
						cache: false,
						success: function(json){

							if(json == 1){
								sweet_error_alert('C?? v???n ????? x???y ra',json.error.message);
							}else{
								if(typeof closest != 'undefined'){
									let target = _this.closest(''+closest+'');
									target.hide('slow', function(){
										target.remove();
										numReply.text('('+listReply.children('li').length+')');
										numReply.attr('data-num' , listReply.children('li').length);
									});
									console.log(target.length);
									if(target.length <= 3){
										_this.closest('ul').find('.cmt-sub-item').removeClass('toggleable');
										_this.closest('ul').find('.more').remove();
									}
								}else{
									let target = _this.closest('tr');
									target.hide('slow', function(){
										target.remove();
										numReply.text('('+listReply.children('li').length+')');
										numReply.attr('data-num' , listReply.children('li').length);
									});
								}
								swal("X??a th??nh c??ng!", "H???ng m???c ???? ???????c x??a kh???i danh s??ch.", "success");
							}
						}
					});
				} else {
					swal("H???y b???", "Thao t??c b??? h???y b???", "error");
				}
			});
	});

	$(document).on('click','.btn-reply', function(e){
		let _this = $(this);
		let param = {
			'id' : _this.attr('data-id'),
			'module' : _this.attr('data-module'),
		};
		let reply = get_comment_html(param);
		let replyName = _this.parent().parent().siblings().find('._cmt-name').text();
		let commentAttr = _this.attr('data-comment');

		if(commentAttr == 1){
			_this.parent().siblings('.show-reply').html(reply);
			let replyTo = _this.parent().siblings('.show-reply').find('.text-reply').text('@'+ replyName + ' : ');
			replyTo.focus();
			textLength = $.trim(_this.parent().siblings('.show-reply').find('.text-reply').val()).length;
			//ban ?????u ta ???n n??t g???i cmt
			_this.parent().siblings('.show-reply').find('.btn-submit').attr('disabled' , '');

			_this.attr('data-comment', 0);
			_this.html('B??? comment');
		}else{
			_this.parent().siblings('.show-reply').html('');
			_this.attr('data-comment', 1);
			_this.html('Tr??? l???i');
		}
		e.preventDefault();
	});

	$(document).on('submit','#form-front-comment', function(){
		let _this = $(this);
		let fullname = $('input[name=comment_name]').val()
		let phone = $('input[name=comment_phone]').val()
		let email = $('input[name=comment_email]').val()
		let rate = $('input[name=data-rate]').val()
		let comment = $('textarea[name=comment_note]').val()
		let canonical = _this.attr('data-canonical')
		let module = _this.attr('data-module')
		let form_URL = 'ajax/frontend/dashboard/send_comment';
		if(fullname == ''){
			toastr.error('Vui l??ng ??i???n H??? v?? t??n!','Xin vui l??ng th??? l???i!');
		}else if(phone == ''){
			toastr.error('Vui l??ng ??i???n S??? ??i???n tho???i!','Xin vui l??ng th??? l???i!');
		}else if(email == ''){
			toastr.error('Vui l??ng ??i???n Email!','Xin vui l??ng th??? l???i!');
		}else if(comment == ''){
			toastr.error('Vui l??ng vi???t nh???n x??t, ????nh g??a!','Xin vui l??ng th??? l???i!');
		}else{
			$.post(form_URL, {
				fullname: fullname, phone: phone, email: email, rate: rate, comment: comment, module: module, canonical: canonical,
			},
			function(data){
				toastr.success('????nh gi?? c???a b???n ???? ???????c g???i ??i, c??m ??n b???n ???? s??? d???ng d???ch v???!','Th??nh c??ng!');
				window.location.reload();
			});
		}

		return false;
	})

	$(document).on('change','input[name=rate]', function(){
		let _this = $(this);
		let val = $("input[name=rate]:checked").val()
		$('.data-rate').val(val)
	});

	// function render_loading(){
	// 	let html  = '';
	// 	html = html+'<div class="loading loading-squares">';
	// 	    html = html+'<div></div>';
	// 	    html = html+'<div></div>';
	// 	    html = html+'<div></div>';
	// 	 html = html+' </div>';
	// 	 return html;
	// }

	$(document).on('click','.upload .upload-picture', function(){
        openKCFinderThumb($(this));
        return false;
    });

    $(document).on('click','.select-img-avatar-user a, .select-btn-avatar-user a', function(){
        UploadAvatarMember($(this));
        return false;
    });

    $(document).ready(function(){
		$('.int').trigger('change')
	})

	$(document).on('click','.float, .int',function(){
		let data = $(this).val();
		if(data == 0){
			$(this).val('');
		}
	});
	$(document).on('keydown','.float, .int',function(e){
		let data = $(this).val();
		if(data == 0){
			let unicode=e.keyCode || e.which;
			if(unicode != 190){
				$(this).val('');
			}
		}
	});

	$(document).on('change keyup blur','.int',function(){
		let data = $(this).val();
		if(data == '' ){
			$(this).val('0');
			return false;
		}
		data = data.replace(/\./gi, "");
		$(this).val(addCommas(data));
		data = data.replace(/\./gi, "");
		if(isNaN(data)){
			$(this).val('0');
			return false;
		}
	});

	function addCommas(nStr){
		nStr = String(nStr);
		nStr = nStr.replace(/\./gi, "");
		let str ='';
		for (i = nStr.length; i > 0; i -= 3){
			a = ( (i-3) < 0 ) ? 0 : (i-3);
			str= nStr.slice(a,i) + '.' + str;
		}
		str= str.slice(0,str.length-1);
		return str;
	}

    $(document).on('click' , '.delete-img' , function(){
		let _this = $(this);
		let boxReply = _this.closest('.box-reply'); // h???p tho???i
		let listImg = _this.closest('ul.lightBoxGallery'); //album ???nh
		_this.closest('li').remove();

		let numImg = listImg.find('li').length; // s??? l?????ng ???nh c??n l???i trong album

		//???n kh???i h??nh ???nh khi all ???nh x??a h???t
		if(numImg <= 0){
			listImg.parent().hide();
			textLength = $.trim(boxReply.find('.text-reply').val().length);
			//ki???m tra cmt k c?? text => ???n n??t g???i
			if(textLength > 0){
				boxReply.find('.btn-submit').removeAttr('disabled');
			}else{
				boxReply.find('.btn-submit').attr('disabled', '')
			}
		}

		return false;
	});

	function get_edit_comment_html(param = ''){
		let comment = '';
		comment += '<div class="comment">';
			comment += '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
				comment += '<div class="cmt-profile">';
					comment += '<div class="uk-flex uk-flex-middle">';
						comment += '<div class="_cmt-avatar"><img src="'+(param.image == '' ? 'public/avatar.png' : param.image)+'" alt="" class="img-sm"></div>';
						comment += '<div class="_cmt-name">'+param.fullname+'</div>';
						comment += '<i>Admin</i>';
					comment += '</div>';
				comment += '</div>';
				comment += '<div class="uk-flex uk-flex-middle toolbox-cmt">';
					comment += '<div class="cancel-cmt"><a type="button" title="" class="btn-cancel" data-info="'+param.dataInfo+'" data-id="'+param.id+'" data-table="comment" data-closest="li" style="color: #e74c3c;">H???y b???</a></div>';
				comment += '</div>';
			comment += '</div>';
			comment += '<div class="box-comment box-reply" style="margin-top: 10px; margin-left: 42px;">';
				comment += '<div class="bg-loading"></div>';
				comment += '<form action="" class="form uk-form uk-clearfix">';
					comment += '<textarea name="text-reply" class="form-control text-reply " placeholder="B???n h??y nh???p ??t nh???t 1 k?? t??? ????? b??nh lu???n" autocomplete="off">'+param.comment+'</textarea>';
					comment += '<div class="gallery-block mt10" style="'+((param.image.length > 0) ? '':"display: none")+'">';
						comment += '<ul class="uk-list uk-flex uk-flex-middle clearfix lightBoxGallery uk-flex-wrap">';
							// list ???nh s??? ??c ????? ??? ????y
							if(param.image.length > 0){
								for(let i = 0; i < param.image.length ; i++){
									comment += thumb_render(param.image[i] , param.parentid);
								}
							}
						comment += '</ul>';
					comment += '</div>';
					comment += '<div class="uk-flex uk-flex-middle uk-flex-space-between mt5">';
						comment += '<div class="upload">';
						let cookie = $.cookie('HTVIETNAM_backend');
							if(cookie != undefined && cookie !=''){
							comment += '<i class="fa fa-camera"></i> ';
							comment += '<a  href="" title="" class="upload-picture">Ch???n h??nh</a>';
							}
						comment += '</div>';
						comment += '<div class="btn-cmt update-cmt"><button type="submit" name="update_comment" value="update_comment" class="btn-success btn-submit" data-id='+param.id+' data-table = '+param.table+'>C???p nh???t</button></div>';
					comment += '</div>';
				comment += '</form>';
			comment += '</div>';
		comment += '</div>';


	  return comment;
	}

	function get_prev_html(param = ''){
		$html = '';
			$html += '<div class="comment">';
				$html += '<div class="uk-flex uk-flex-middle uk-flex-space-between">';
					$html += '<div class="cmt-profile">';
						$html += '<div class="uk-flex uk-flex-middle">';
							$html += '<div class="_cmt-avatar"><img src="'+(param.image == '' ? 'public/avatar.png' : param.image)+'" alt="" class="img-sm"></div>';
							$html += '<div class="_cmt-name">'+param.fullname+'</div>';
							$html += '<i>Admin</i>';
						$html += '</div>';
					$html += '</div>';
					$html += '<div class="uk-flex uk-flex-middle">';
						let cookie = $.cookie('HTVIETNAM_backend');
							if(cookie != undefined && cookie !=''){
								$html += '<div class="edit-cmt"><a type="button" title="" class="btn-edit" data-info="'+param.dataInfo+'" data-id="'+param.id+'" data-table="comment">S???a</a></div>';
								$html += '<div class="delete-cmt">';
									$html += '<a type="hidden" title="" class="ajax-delete" data-title="L??u ??: D??? li???u s??? kh??ng th??? kh??i ph???c. H??y ch???c ch???n r???ng b???n mu???n th???c hi???n h??nh ?????ng n??y!" data-id="'+param.id+'" data-table="comment" data-closest="li"></a>';
									$html += '<a type="button" title="" class="btn-delete" style="color: #e74c3c;">X??a</a>';
								$html += '</div>';
							}
					$html += '</div>';
				$html += '</div>';
				$html += '<div class="cmt-content">';
					$html += '<p>'+param.comment+'</p>';
					$html += '<div class="gallery-block mb10" style="'+((param.image.length > 0) ? '':"display: none")+'">';
						$html += '<ul class="uk-list uk-flex uk-flex-middle clearfix lightBoxGallery uk-flex-wrap">';
							// list ???nh s??? ??c ????? ??? ????y
							if(param.image.length > 0){
								for(let i = 0; i < param.image.length ; i++){
									$html += '<li>';
										$html += '<div class="thumb">';
											$html +='<a href="'+param.image[i]+'" title="" data-gallery="#blueimp-gallery-'+param.parentid+'-'+param.id+'"><img src="'+param.image[i]+'" class="img-md"></a>';
											$html += '<input type = "hidden" class="album" value="'+param.image[i]+'" name="album[]">';
										$html += '</div>';
									$html += '</li>'
								}
							}
						$html += '</ul>';
					$html += '</div>';
					$html += '<i class="fa fa-clock-o"></i> <time class="sub_comment_timeago" datetime="'+((param.updated> param.created)? param.updated : param.created)+'"></time>';
				$html += '</div>';
			$html += '</div>';
		return $html;
	}

	function get_comment_html(param = ''){
		let comment = '';

		comment += '<div class="box-comment box-reply" style="margin-top: 10px;">';
			comment += '<div class="bg-loading"></div>';
			comment += '<form action="" class="form uk-form uk-clearfix">';
				comment += '<textarea name="text-reply" class="form-control text-reply " placeholder="B???n h??y nh???p ??t nh???t 1 k?? t??? ????? b??nh lu???n" autocomplete="off"></textarea>';
				comment += '<div class="gallery-block mt10" style="display: none;">';
					comment += '<ul class="uk-list uk-flex uk-flex-middle clearfix lightBoxGallery uk-flex-wrap">';
						// list ???nh s??? ??c ????? ??? ????y
					comment += '</ul>';
				comment += '</div>';
				comment += '<div class="uk-flex uk-flex-space-between mt5">';
					comment += '<div class="upload">';
					// let cookie = $.cookie('HTVIETNAM_backend');
					// 		if(cookie != undefined && cookie !=''){
					// 		comment += '<i class="fa fa-camera"></i> ';
					// 		comment += '<a  href="" title="" class="upload-picture">Ch???n h??nh</a>';
					// 	}
						comment += '</div>';
					comment += '<div class="btn-cmt sent-cmt"><button type="submit" name="sent_comment" value="sent_comment" disabled class="btn-success btn-submit" data-parentid = '+param.id+' data-module = '+param.module+'  >G???i</button></div>';
				comment += '</div>';
			comment += '</form>';
		comment += '</div>';

	  return comment;
	}

	function sub_comment(param){
		let comment = '';
		let info='';
		for (let i = 0; i < param.length; i++) {
			comment += '<li class="cmt-sub-item mt20">';
				comment += '<div class="comment">';
					comment += '<div class="uk-flex uk-flex-space-between">';
						comment += '<div class="cmt-profile">';
							comment += '<div class="uk-flex uk-flex-middle">';
								comment += '<div class="img-user-cmt"><img src="public/user.png" alt="" class="img-sm"></div>';
								comment += '<div>';
								comment += '<div class="hlm-cmt-user-name">'+param[i].fullname+'</div>';
								comment += '<div class="cmt-time">';
								comment += '<i class="fa fa-clock-o mr5"></i>';
								comment += '<time class="sub_comment_timeago" datetime="'+param[i].created_at+'"></time>';
								comment += '</div>';
								comment += '<div class="cmt-content">';
									let album = param[i].album;
										comment += '<p>'+param[i].comment+'</p>';
											comment += '<div class="gallery-block mb10" '+((album != null && album != []) ? '' : 'style="display:none"')+'>';
												comment += '<ul class="uk-list uk-flex uk-flex-middle clearfix lightBoxGallery">';
													if(album != null && album != []){
														for (var j = 0; j < album.length; j++) {
															comment += '<li>';
																comment += '<div class="thumb">';
																	comment += '<a href="'+param[i].album[j]+'" title="'+param[i].album[j]+'" ><img src="'+param[i].album[j]+'" class="img-md" alt="'+param[i].album[j]+'"></a>';
																comment += '</div>';
															comment += '</li>';
														}
													}
												comment += '</ul>';
											comment += '</div>';

									comment += '</div>';
								comment += '</div>';

								// comment += '<i>Admin</i>';
							comment += '</div>';
						comment += '</div>';

						comment += '<div class="uk-flex uk-flex-middle toolbox-cmt">';
							let cookie = $.cookie('HTVIETNAM_backend');
							if(cookie != undefined && cookie !=''){
								// comment += '<div class="edit-cmt"><a type="button" title="" class="btn-edit" data-info="'+param[i].data_info+'" data-id="'+param[i].id+'" data-table="comment">S???a</a></div>';
								comment += '<div class="delete-cmt">';
									comment += '<a type="hidden" title="" class="ajax-delete" data-title="L??u ??: D??? li???u s??? kh??ng th??? kh??i ph???c. H??y ch???c ch???n r???ng b???n mu???n th???c hi???n h??nh ?????ng n??y!" data-id="'+param[i].id+'" data-table="comment" data-closest="li"></a>';
									comment += '<a type="button" title="" class="btn-delete" style="color: #e74c3c;">X??a</a>';
								comment += '</div>';
							}
						comment += '</div>';
					comment += '</div>';

				comment += '</div>';
			comment += '</li>';
		}

	  return comment;
	}
	function more_less_subcomment($object){

	  	let LiN = $object.find('ul.list-reply').find('li.cmt-sub-item').length;
	  	if( LiN > 3){
	    	$('li.cmt-sub-item', $object.find('ul.list-reply')).eq(2).nextAll().hide().addClass('toggleable');
	    	$object.find('ul.list-reply').append('<li class="more">Xem t???t c???</li>');
	  	}
	}

	$('ul.list-reply').on('click','.more', function(){
	  	if( $(this).hasClass('less') ){
	    	$(this).text('Xem t???t c???').removeClass('less');
	  	}else{
	    	$(this).text('Thu g???n').addClass('less');
	  	}
	  	$(this).siblings('li.toggleable').slideToggle();
	});



	function openKCFinderThumb(object, type){
	    if(typeof(type) == 'undefined'){
	        type = 'Images';
	    }
	    var finder = new CKFinder();
	    finder.resourceType = type;
	    finder.selectActionFunction = function( fileUrl , data, allFiles ) {
	    	var files = allFiles;
	        for(var i = 0 ; i < files.length; i++){
	            files[i].url =  files[i].url.replace(BASE_URL, "/");
	        }
	        let numImage = object.closest('.box-reply').find('.lightBoxGallery img').length; // s??? l?????ng ???nh ???? t???n t???i ??? l???n upload trc
			let $galleryBlock = object.closest('.box-reply').find('.gallery-block');
			let $lightBoxGallery = object.closest('.box-reply').find('.lightBoxGallery');
			let $parentid = object.closest('.cmt-content').find('.btn-reply').attr('data-id'); // l???y id c???a cmt ??ang ??c t????ng t??c
			$galleryBlock.show();
			object.parent().siblings('.btn-cmt').find('.btn-submit').removeAttr('disabled');
			for (var i = 0; i < files.length; i++){
				$lightBoxGallery.prepend(thumb_render(files[i].url , $parentid));
			}
	    }
	    finder.popup();
	}

	function UploadAvatarMember(object, type){
	    if(typeof(type) == 'undefined'){
	        type = 'Images';
	    }
	    var finder = new CKFinder();
	    finder.resourceType = type;
	    finder.selectActionFunction = function( fileUrl, data ) {
	        fileUrl =  fileUrl.replace(BASE_URL, "/");
	        $('.input-avatar-user').val(fileUrl)
	        $('.select-img-avatar-user').find('img').attr('src',fileUrl)
	    }
	    finder.popup();
	    return false;
	}

	function thumb_render(src = '' , parentid = 0){
		let html = '';

			html += '<li>';
				html += '<div class="thumb">';
					html +='<a href="'+src+'" title="" data-gallery="#blueimp-gallery-'+parentid+'"><img src="'+src+'" class="img-md"></a>';
					html += '<input type = "hidden" class="album" value="'+src+'" name="album[]">';
					html += '<div class="overlay-img"></div>';
					html += '<div class="delete-img"><i class="fa fa-times-circle" aria-hidden="true"></i></div>';
				html += '</div>';
			html += '</li>'

		return html;
	}

	// ==========================================================================================================
	$('.moreless-button').click(function() {
	  	$('.moretext').slideToggle();
	  	if ($('.moreless-button').text() == "T??m ki???m n??ng cao") {
	   		$(this).text("Thu g???n")
	  	} else {
	    	$(this).text("T??m ki???m n??ng cao")
	  	}
	  	return false;
	});
	// ========================================== Gio hang =====================================================
	$(document).ready(function(){
		$(".cart-panel .input-check-label").click(function(){
			$(this).parents(".check-box").find(".input-check").trigger("click")
		})
	})


	$(document).on('change', '#city', function(e, data){
		let _this = $(this);
		let id = _this.val();
		let param = {
			'id' : id,
			'text' : '[Ch???n Qu???n/Huy???n]',
			'table' : 'vn_district',
			'trigger_district': (typeof(data) != 'undefined') ? true : false,
			'where' : {'provinceid' : id},
			'select' : 'districtid as id, name',
			'object' : '#district',
		};
		get_location(param);
	});

	if(typeof(cityid) != 'undefined' && cityid != ''){
		$('#city').val(cityid).trigger('change', [{'trigger':true}]);
	}

	$(document).on('change', '#district', function(){
		let _this = $(this);
		let id = _this.val();
		let param = {
			'id' : id,
			'text' : '[Ch???n Ph?????ng/X??]',
			'table' : 'vn_ward',
			'where' : {'districtid' : id},
			'select' : 'wardid as id, name',
			'object' : '#ward',
		};
		get_location(param);
	});

	function get_location(param){
		if(districtid == '' || param.trigger_district == false) districtid = 0;
		if(wardid == ''  || param.trigger_ward == false) wardid = 0;

		let formURL = 'ajax/dashboard/get_location';
		$.post(formURL, {
			param: param},
			function(data){
				let json = JSON.parse(data);
				if(param.object == '#district'){
					$(param.object).html(json.html).val(districtid).trigger('change');
				}else if(param.object == '#ward'){
					$(param.object).html(json.html).val(wardid);
				}

			});
	}

	// ========================================================================================================

	function format_curency(data) {
		let format = data.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
		return format;
	}

	$(document).ready(function(){
		$('.countdown').each(function(){
			let _this = $(this);
			let val = _this.find('.days').html()
			if(val == 0){
				_this.find('.status-deal').html('H???t h???n')
			}
		})
	})


	function sweet_error_alert(title, message){
		swal({
			title: title,
			text: message,
			type: 'error',
		});
	}
	if($('.select2').length){
		$('.select2').select2();
	}

	$('.countdown').each(function(){
      	let _this = $(this);
      	let time = _this.attr('data-time');
      	_this.countdown(time, function(event) {
	        let day = event.strftime('%D');
	        let hour = event.strftime('%H');
	        let mins = event.strftime('%M');
	        let second = event.strftime('%S');
	        _this.find('.days').html('').html(day);
	        _this.find('.hours').html('').html(hour);
	        _this.find('.mins').html('').html(mins);
	        _this.find('.second').html('').html(second);

      	});
    });



	$(document).on('click','.language_widget', function(){
		let _this = $(this)
		let keyword = _this.attr('data-keyword')
		let form_URL = 'ajax/frontend/dashboard/language';
		$.post(form_URL, {
			keyword : keyword
		},
		function(data){
			location.reload();
		});
	})
	$(document).on('click','.create-help', function(){
		return false;
	})
	$(document).on('click','.create-help', function(){
		return false;
	})

	$(document).on('submit','.va-form-contact', function(){
		let _this = $(this)
		let fullname = $('.va-fullname-contact').val()
		let email = $('.va-email-contact').val()
		let phone = $('.va-phone-contact').val()
		let message = $('.va-message-contact').val()
		let check = 0;
		if (fullname.length == 0) {
    		toastr.error('H??? v?? t??n kh??ng ???????c ????? tr???ng!','Xin vui l??ng th??? l???i!');
        } else if(IsEmail(email) == false) {
    		toastr.error('?????nh d???ng Email kh??ng h???p l???!','Xin vui l??ng th??? l???i!');
        }else if(phone.length != 10) {
    		toastr.error('S??? ??i???n tho???i kh??ng h???p l???!','Xin vui l??ng th??? l???i!');
        } else if(message.length < 10){
    		toastr.error('Xin vui l??ng ch???n kh??a h???c ho???c ??i???n n???i dung c???n g???i!','Xin vui l??ng th??? l???i!');
        }else{
        	let form_URL = 'ajax/frontend/action/contact_full';
			$.post(form_URL, {
				email : email,fullname : fullname,phone : phone,message : message
			},
			function(data){
				if(data.trim() == 'success'){
					toastr.success('Th??nh c??ng','B???n ???? g???i y??u c???u th??nh c??ng, ch??ng t??i s??? li??n h??? v???i b???n s???m nh???t!');
					$('.va-form-contact')[0].reset();
				}else{
					toastr.error('An error occurred!','Xin vui l??ng th??? l???i!');
				}
			});
        }
		return false;
	})

	$(document).on('submit','.contact_email_va', function(){
		let _this = $(this)
		let email = _this.find(".email_contact_va").val();
		let check = _this.find(".check-agree:checked").val();
	 	if (IsEmail(email) == false) {
    		toastr.error('Invalid Email Format!','Please try again!');
        } else if(check != 0){
    		toastr.error('Please choose to agree to receiving email messages!','Please try again!');
    	}else {
        	let form_URL = 'ajax/frontend/action/contact_email';
			$.post(form_URL, {
				email : email
			},
			function(data){
				if(data.trim() == 'success'){
					toastr.success('Success','You have successfully subscribed to the news!');
					_this[0].reset();
				}else{
					toastr.error('An error occurred!','Please try again!');
				}
			});
        }

		return false;
	})

	function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

	$(document).on('change','.va-choose-tour input[type="radio"]', function(){
		let _this = $(this)
		let val = _this.val()
		let form_URL = 'ajax/frontend/dashboard/get_select2';
		$.post(form_URL, {
			id : val
		},
		function(data){
			let json = JSON.parse(data);
			$('.check_end').html(json.html);
		});
	})

	function render_loading(){
		let html  = '';
		html = html+'<div class="loading medium"></div>';
	 	return html;
	}

	// ====================================================FILTER PRODUCT==============================================

	$(document).on('change','.check-aside-product input', function(){
		let _this = $(this)
		$('.product_list_panel').hide();
		$('.product_search_panel').html("");
		filterProduct();
	})

	$(document).on('click','#pagination_ajax li a', function(){
		let _this = $(this)
		$('.product_list_panel').hide();
		$('.product_search_panel').html("");
		let page = _this.attr('data-ci-pagination-page');
		filterProduct(page);
		return false;
	})

	function filterProduct(page = 1){
		let price = [];
		let catalogue = [];
		let brand = [];
		let module = $('.va-articleCat-panel').attr('data-module');
		let canonical = $('.va-articleCat-panel').attr('data-canonical');
    	$('.check-price input[name="price[]"]:checked').each(function(){
    		let valthis = $(this);
    		let valChild = valthis.val();
    		price.push(valChild)
    	})
    	$('.check-brand input:checked').each(function(){
    		let valthis = $(this);
    		let valChild = valthis.val();
    		brand.push(valChild)
    	})
    	$('.check-catalogue input:checked').each(function(){
    		let valthis = $(this);
    		let valChild = valthis.val();
    		catalogue.push(valChild)
    	})
    	if(price.length == 0 && brand.length == 0 &&  catalogue.length == 0){
			$('.product_list_panel').show();
    	}else{
    		let form_URL = 'ajax/frontend/filterproduct/render_product';
			$.post(form_URL, {
				price: price, brand: brand, catalogue: catalogue, module:module, url: canonical,page : page
			},
			function(data){
				let json = JSON.parse(data);
				let decode = b64DecodeUnicode(json.html);
				console.log(decode);
				$('.product_search_panel').html(decode);
				$('#pagination_ajax').html(json.pagination);
			});
    	}
	}

	// ***************************************************************************************************************

	function slug(title){
		title = cnvVi(title);
		return title;
	}


	function cnvVi(str) {
		str = str.toLowerCase(); // chuyen ve ki tu biet thuong
		str = str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g, "a");
		str = str.replace(/??|??|???|???|???|??|???|???|???|???|???/g, "e");
		str = str.replace(/??|??|???|???|??/g, "i");
		str = str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g, "o");
		str = str.replace(/??|??|???|???|??|??|???|???|???|???|???/g, "u");
		str = str.replace(/???|??|???|???|???/g, "y");
		str = str.replace(/??/g, "d");
		str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|,|\.|\:|\;|\'|\???| |\"|\&|\#|\[|\]|\\|\/|~|$|_/g, "-");
		str = str.replace(/-+-/g, "-");
		str = str.replace(/^\-+|\-+$/g, "");
		return str;
	}
	function replace(Str=''){
		if(Str==''){
			return '';
		}else{
			Str = Str.replace(/\./gi, "");
			return Str;
		}
	}

	function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
	    return decodeURIComponent(atob(str).split('').map(function(c) {
	        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
	    }).join(''));
	}
});
	(function($) {
	    "use strict";
	    var HT = {};

	    /* MAIN VARIABLE */

	    var $window = $(window),
	        $document = $(document),
	        $slide_item = $('.slide-item'),
			$btn_modal = $('.btn-modal-general'),
	        $num = $('.num'),
	        owl = $('.owl-carousel'),
	        $btn_tab = $('.btn-tab'),
	        $active_menu = $('.hd-menu-item'),
	        $num = $('.num'),
	        $document = $(document),
	        $js_dropdown = $('.js-dropdown');

	    // Check if element exists
	    $.fn.elExists = function() {
	        return this.length > 0;
	    };


	    HT.carousel = function() {
	        $('.owl-slide .owl-carousel').each(function() {
	            let _this = $(this);
	            let data_owl = _this.attr('data-owl');
	            data_owl = window.atob(data_owl);
	            data_owl = JSON.parse(data_owl);
	            _this.owlCarousel(data_owl);
	        });
	    }

	    HT.lazyLoad = function() {
	        $('img.lazyloading').imgLazyLoad({
				container: window,
				effect: 'fadeIn',
				speed: 600,
				delay: 400,
				callback: function(){
					$( this ).css( 'opacity', .99 );
				}
			});
	    }
	    // HT.lazyLoad_body = function() {
	    //     $("body").lazyScrollLoading({
	    //         lazyItemSelector: ".w_content , .lazyloading_box",
	    //         onLazyItemVisible: function(e, $lazyItems, $visibleLazyItems) {
	    //             $visibleLazyItems.each(function() {
	    //                 $(this).addClass("show");
	    //             });
	    //         }
	    //     });
	    // }

	    HT.modal_review = function() {
			if ($btn_modal.elExists) {
				let data_modal = '';
				$btn_modal.click(function() {
					let _this = $(this);
					data_modal = _this.attr('href');
					console.log(data_modal)
					$(data_modal).addClass('enable');
				})
				$('.modal').add($('.modal-close')).add($('.btn-cancel')).click(function() {
					$(data_modal).removeClass('enable');
				})

				$('.modal-content-review').click(function(e) {
					e.stopPropagation();
				})
			}

		}
	    HT.sum = function(start, dataCount, display) {
	        display.text(start);
	        start += 1;
	        if (start <= dataCount) {
	            setTimeout(function() {
	                HT.sum(start, dataCount, display)
	            }, 50)
	        }
	    }

	    HT.countUp = function() {
	        if ($num.elExists) {
	            $num.each(function(e) {
	                let _this = $(this)
	                let dataCount = _this.attr('data-count');
	                let display = _this.text(dataCount);
	                let start = 1;
	                HT.sum(start, dataCount, display)
	            })


	        }
	    }

	    HT.tabs = function() {
            $('ul.tabs li').click(function() {
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            })
            $('ul.tabs-detail li').click(function() {
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs-detail li').removeClass('current');
                $('.tab-content-detail').removeClass('current');

                $(this).addClass('current');
                $("#" + tab_id).addClass('current');
            })
        }
        // rating

    HT.vote = function() {
        $(document).ready(function() {

            //Action on hover

            $('#stars li').on('mouseover', function() {
                var onStar = parseInt($(this).data('value'), 10);


                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function() {
                $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });

            // Action on click

            $('#stars li').on('click', function() {
                var onStar = parseInt($(this).data('value'), 10);
                var stars = $(this).parent().children('li.star');
                var i;
                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }
            });
        });
    }

    // Nice select

    HT.niceSelect = function() {
        $('select').niceSelect();
    }

	    // Document ready functions
	    $document.on('ready', function() {
	    	// HT.tabs(),
            // HT.vote(),
            HT.lazyLoad(),
            // HT.lazyLoad_body(),
            HT.niceSelect(),
	        // HT.countUp(),
	        HT.carousel();
	        // HT.modal_review();
	    });

	})(jQuery);
