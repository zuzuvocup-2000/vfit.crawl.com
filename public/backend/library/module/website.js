

$(document).on('click', '.onoffswitch-checkbox', function(){
    let val = $(this).is(":checked");
    let id = $(this).attr('data-id');
    var formURL = '/website/url/update-status/'+id;
	$.post(formURL, {status: val},
	function(data){});
})

// $(document).on('change', '.select-website', function(){
//     let val = $(this).val();
//     window.location.href = val;
// })

$(document).on('click','.btn-delete-website',function(){
	let _this = $(this);
	let id = _this.attr('data-id');
	swal({
		title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
		text: 'Xóa Website được chọn',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Thực hiện!",
		cancelButtonText: "Hủy bỏ!",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				var formURL = 'website/delete/'+id;
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

$(document).on('click','.btn-crawl-url-sitemap',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "website/crawl-sitemap";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-url-normal',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "website/crawl-normal";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-url-javascript',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "website/crawl-javascript";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});