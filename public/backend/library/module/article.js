$(document).on('change', '.click-change-rate-dom', function(){
	let _this = $(this);
	let val = _this.val()
	$('.wrap-selector-normal').remove()
	$('.js-open-normal-rate .row').remove()
	if(val == 'RATE'){
		$('.js-open-normal-rate').append(add_wrap_rate_normal())
	}else{
		$('.wrap-selector-article').append(add_selector_normal())
	}
})

$(document).on('change', '.click-change-rate-type', function(){
	let _this = $(this);
	let val = _this.val()
	$('.wrap-selector-normal, .wrap-selector-type-rate').remove()
	$('.js-open-plugin-rate .row, .js-open-click-rate .row, .js-open-scroll-rate .row').remove()
	if(val == 'RATE'){
		$('.wrap-selector-article').append(add_selector_type_rate())
	}else{
		$('.wrap-selector-article').append(add_selector_normal())
	}
})

$(document).on('change', '.selector-type-rate', function(){
	let _this = $(this);
	let val = _this.val()
	$('.js-open-plugin-rate .row, .js-open-click-rate .row, .js-open-scroll-rate .row').remove()
	switch (val) {
		case 'PLUGIN':
			$('.js-open-plugin-rate').append(add_wrap_rate_plugin())
			break;
		case 'SCROLL':
			$('.js-open-scroll-rate').append(add_wrap_rate_scroll())
			break;
		case 'CLICK':
			$('.js-open-click-rate').append(add_wrap_rate_click())
			break;
	}
})

function add_selector_normal(){
	let html = '<div class="col-md-6 wrap-selector-normal">';
        html =  html + '<div class="form-group">';
            html =  html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML  <span class="text-danger">(*)</span></label>';
            html =  html + '<input type="text" name="selector" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
        html =  html + '</div>';
    html =  html + '</div>';

    return html;
}

function add_selector_type_rate(){
	let html = '';
	html = html + '<div class="col-md-6 wrap-selector-type-rate">';
        html = html + '<div class="form-group">';
            html = html + '<label for="example-text-input" class="form-control-label">Loại đánh giá</label>';
            html = html + '<select name="selector[type]" onfocus="focused(this)" onfocusout="defocused(this)" class="form-control selector-type-rate">';
				html = html + '<option value="" selected="selected">Chọn loại đánh giá</option>';
				html = html + '<option value="PLUGIN">PLUGIN</option>';
				html = html + '<option value="CLICK">CLICK</option>';
				html = html + '<option value="SCROLL">SCROLL</option>';
			html = html + '</select>';
        html = html + '</div>';
    html = html + '</div>';
    return html;
}

function add_wrap_rate_plugin(){
	let html = '';
	html = html +'<div class="row">';
	    html = html +'<p class="text-sm">';
	        html = html +'<span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá plugin</span>';
	        html = html +'<span class="text-warning text-xs">Plugin bình luận Facebook</span>';
	    html = html +'</p>';
	    html = html +'<div class="col-md-6">';
	        html = html +'<div class="form-group">';
	            html = html +'<label for="example-text-input" class="form-control-label">Bộ chọn HTML để thu thập URL plugin Facebook  </label>';
	            html = html +'<input type="text" name="selector[selector]" value=".fb-comments iframe" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html +'</div>';
	    html = html +'</div>';
	    html = html +'<div class="col-md-6">';
	        html = html +'<div class="form-group">';
	            html = html +'<label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>';
	            html = html +'<input type="text" name="selector[comment]" value="._30o4" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html +'</div>';
	    html = html +'</div>';
	    html = html +'<div class="col-md-6">';
	        html = html +'<div class="form-group">';
	            html = html +'<label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>';
	            html = html +'<input type="text" name="selector[name]" value=".UFICommentActorName" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html +'</div>';
	   	html = html +' </div>';
	    html = html +'<div class="col-md-6">';
	        html = html +'<div class="form-group">';
	            html = html +'<label for="example-text-input" class="form-control-label">Bộ chọn HTML nút xem thêm  </label>';
	            html = html +'<input type="text" name="selector[selector]" value="div._5o4h > button" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html +'</div>';
	    html = html +'</div>';
	html = html +'</div>';
    return html;
}

function add_wrap_rate_click(){
	let html = '';
	html = html + '<div class="row">';
	    html = html + '<p class="text-sm">';
	        html = html + '<span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá click</span>';
	        html = html + '<span class="text-warning text-xs">Click để xem thêm bình luận</span>';
	    html = html + '</p>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>';
	            html = html + '<input type="text" name="selector[comment]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>';
	            html = html + '<input type="text" name="selector[name]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML nút xem thêm  </label>';
	            html = html + '<input type="text" name="selector[view_more]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML sự kiện ẩn hoặc loại bỏ  </label>';
	            html = html + '<input type="text" name="selector[class_hide]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	html = html + '</div>';
	return html;
}

function add_wrap_rate_scroll(){
	let html = '';
	html = html + '<div class="row">';
	    html = html + '<p class="text-sm">';
	        html = html + '<span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá scroll</span>';
	        html = html + '<span class="text-warning text-xs">Scroll để xem thêm bình luận</span>';
	    html = html + '</p>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>';
	            html = html + '<input type="text" name="selector[comment]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>';
	            html = html + '<input type="text" name="selector[name]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	html = html + '</div>';
	return html;
}

function add_wrap_rate_normal(){
	let html = '';
	html = html + '<div class="row">';
	    html = html + '<p class="text-sm">';
	        html = html + '<span class="text-uppercase ">Bộ chọn HTML cho loại thu thập đánh giá DOM</span>';
	    html = html + '</p>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML bình luận  </label>';
	            html = html + '<input type="text" name="selector[comment]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	    html = html + '<div class="col-md-6">';
	        html = html + '<div class="form-group">';
	            html = html + '<label for="example-text-input" class="form-control-label">Bộ chọn HTML tên người bình luận  </label>';
	            html = html + '<input type="text" name="selector[name]" value="" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">';
	        html = html + '</div>';
	    html = html + '</div>';
	html = html + '</div>';
	return html;
}


$(document).on('click','.btn-delete-article',function(){
	let _this = $(this);
	let id = _this.attr('data-id');
	swal({
		title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
		text: 'Xóa thiết lập bài viết được chọn',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Thực hiện!",
		cancelButtonText: "Hủy bỏ!",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				var formURL = 'config/article/delete/'+id;
				$.post(formURL, {},
				function(data){
					let json = JSON.parse(data)
					if(json.code && json.code != 200){
						sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
					}else{
						_this.parents('.list-item').remove()
						swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
					}
				});
		} else {
			swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
		}
	});
	return false;
});