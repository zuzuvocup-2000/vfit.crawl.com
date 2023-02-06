$(document).on('click','.btn-delete-user',function(){
	let _this = $(this);
	let id = _this.attr('data-id');
	swal({
		title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
		text: 'Xóa tài khoản được chọn',
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Thực hiện!",
		cancelButtonText: "Hủy bỏ!",
		closeOnConfirm: false,
		closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				var formURL = 'user/delete/'+id;
				$.post(formURL, {},
				function(data){
					let json = JSON.parse(data)
					if(json.code && json.code != 200){
						sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
					}else{
						_this.parents('.list-item').remove()
						swal("Xóa thành công!", "Bản ghi đã được xóa khỏi danh sách.", "success");
					}
					if(json.reload == true) location.reload();
				});
		} else {
			swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
		}
	});
	return false;
});
