

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
	let ajaxUrl = "ajax/website/website/crawl_sitemap";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			console.log('Crawl url sitemap')
			toastr.success('Thu thập Url sitemap thành công!','Thành công!');
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-url-normal',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "ajax/website/website/crawl_normal";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			console.log('Crawl url normal')
			toastr.success('Thu thập Url bình thường thành công!','Thành công!');
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-url-sitemap-pending',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "ajax/website/website/crawl_sitemap_pending";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			console.log('Crawl sitemap pending')
			toastr.success('Thu thập Url theo sitemap chờ thành công!','Thành công!');
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-url-chunk-site',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "ajax/website/website/chunk_site";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			console.log('Chunk site')
			toastr.success('Chia đều website theo 5 luồng thành công!','Thành công!');
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-url-chunk-article',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "ajax/website/website/chunk_article";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			console.log('Chunk article')
			toastr.success('Chia đều bài viết theo 10 luồng thành công!','Thành công!');
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});

$(document).on('click','.btn-crawl-data',function(){
	$('.screen-loading').removeClass('d-none')
	for (let i = 1; i <= 5; i++) {
	  	$.ajax({
		    method: "POST",
		    url: "ajax/website/website/crawl_data",
		    data: {id: i},
		    cache: false,
		    success: function(data){}
	  	});
	}
	toastr.warning('Cần chút thời gian để hệ thống tiến hành thu thập dữ liệu!','Xin vui lòng chờ!');

	setTimeout(function(){
		$('.screen-loading').addClass('d-none')
	}, 30000);
	return false;
});


$(document).on('click','.btn-statistic',function(){
	$('.screen-loading').removeClass('d-none')
	for (let i = 1; i <= 10; i++) {
	  	$.ajax({
		    method: "POST",
		    url: "ajax/website/website/statistic",
		    data: {id: i},
		    cache: false,
		    success: function(data){}
	  	});
	}
	toastr.warning('Cần chút thời gian để hệ thống tiến hành phân tích dữ liệu!','Xin vui lòng chờ!');

	setTimeout(function(){
		$('.screen-loading').addClass('d-none')
	}, 30000);
	return false;
});

$(document).on('click','.btn-result',function(){
	$('.screen-loading').removeClass('d-none')
	let ajaxUrl = "ajax/website/website/result";
	$.ajax({
		method: "POST",
		url: ajaxUrl,
		cache: false,
		success: function(data){
			console.log('Calculate Statistic')
			toastr.success('Tổng kết dữ liệu thành công!','Thành công!');
			$('.screen-loading').addClass('d-none')
		}
	});

	return false;
});