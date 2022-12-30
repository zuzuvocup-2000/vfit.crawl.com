$(document).ready(function(){
    
	$(".toggle-password").click(function() {
	  	$(this).toggleClass("fa-eye fa-eye-slash");
	  	var input = $($(this).attr("toggle"));
	  	if (input.attr("type") == "password") {
	    	input.attr("type", "text");
	  	} else {
		    input.attr("type", "password");
	  	}
	});

    $(".btn-submit-form-user").click(function() {
        let _this= $(this);
        let form = $('#form-user').serializeArray()
        let form_URL = 'ajax/frontend/auth/update_info_member';

       $.post(form_URL, {
            form: form
        },
        function(data){
            if(data.trim() == 'no_email'){
                toastr.error('Email does not exist in the system!','Please try again!');
            }else if(data.trim() == 'error'){
                toastr.error('An error occurred!','Please try again!');
            }else{
                toastr.success('Cập nhật hồ sơ cá nhân Success!','Success!');
                window.location.reload()
            }
        }); 
       return false;
    });

	if($('.select2').length){
		$('.select2').select2();
	}
	
    $('#signup-email').blur(function() {
        var email = $('#signup-email').val();
        if (IsEmail(email) == false) {
            $(this).addClass('input-warning');
    		toastr.error('Invalid Email Format!','Please try again!');
        } else {
            $(this).removeClass('input-warning');
        }
    });
    $('#confirm-password').blur(function() {
        console.log(1);
        if ($('#password-field').val() !== $('#confirm-password').val()) {
            $(this).addClass('input-warning');
    		toastr.error('Mật khẩu bạn nhập không đúng!','Please try again!');
        } else {
            $(this).removeClass('input-warning');
        }
    }); 
    $('#password-field').blur(function() {
        if ($('#password-field').val().length < 6) {
            $(this).addClass('input-warning');
    		toastr.error('Mật khẩu phải ít nhất 6 kí tự!','Please try again!');
        } else {
            $(this).removeClass('input-warning');
        }
    });
    $('#contact-number').blur(function() {
        if ($('#contact-number').val().length != 10) {
            $(this).addClass('input-warning');
    		toastr.error('Số điện thoại không hợp lệ!','Please try again!');
        } else {
            $(this).removeClass('input-warning');
        }
    });

    $('.btn-otp-email').on('click', function(){
        let _this = $(this)
    	let password = $('input.signup-password[name=password]').val();
    	let email = $('input.signup-email[name=email]').val();
    	let form_URL = 'ajax/frontend/auth/send_otp_signup';
    	if(password.length < 6){
    		toastr.error('Please enter password!','Please try again!');
    	}else if(IsEmail(email) == false){
    		toastr.error('Invalid email format!','Please try again!');
    	}else{
            _this.html('<img src="public/loading.svg" alt="loading">')
            _this.attr('disabled' , 'disabled')
    		$.post(form_URL, {
				password: password,  email: email
			},
			function(data){
                _this.html('CREATE ACCOUNT')
                _this.removeAttr('disabled')
				if(data== 0){
    				toastr.error('Something went wrong!','Please try again!');
				}else if(data== 2){
    				toastr.error('Email already exists in the system!','Please try again!');
				}else{
                    $('.modal-auth-general').removeClass('block')
                    $('.wrap-modal-verify').addClass('block')
                    $('.wrap-modal-verify').find('.btn-otp-verify').attr('data-target', 'create')
                    $('.wrap-modal-verify').find('.email-check-otp').val(email)
					toastr.success('OTP has been sent to your email!','Success!');
				}
			});	
    	}
    	return false;
    })

    $('.btn-get-otp-forgot').on('click', function(){
        let _this  = $(this)
        let email = $('input.input-email-forgot[name=email]').val();
        let form_URL = 'ajax/frontend/auth/send_otp_forgot';
        if(IsEmail(email) == false){
            toastr.error('Invalid Email Format!','Please try again!');
        }else{
            _this.html('<img src="public/loading.svg" alt="loading">')
            _this.attr('disabled' , 'disabled')
            $.post(form_URL, {
                email: email
            },
            function(data){
                _this.html('SEND EMAIL')
                _this.removeAttr('disabled')
                if(data.trim() == 'no_email'){
                    toastr.error('Email does not exist in the system!','Please try again!');
                }else if(data.trim() == 'error'){
                    toastr.error('An error occurred!','Please try again!');
                }else{
                    $('.modal-auth-general').removeClass('block')
                    $('.wrap-modal-verify').addClass('block')
                    $('.wrap-modal-verify').find('.btn-otp-verify').attr('data-target', 'forgot')
                    $('.wrap-modal-verify').find('.email-check-otp').val(email)
                    toastr.success('OTP has been sent to your Email!','Success!');
                }
            }); 
        }
        return false;
    }) 

    $('.btn-otp-verify ').on('click', function(){
        let _this = $(this)
        let email = $('.email-check-otp').val()
        let otp = $('.signup-otp').val()
        let type = _this.attr('data-target')
        if(type == 'create'){
            let form_URL = 'ajax/frontend/auth/signup';
            _this.html('<img src="public/loading.svg" alt="loading">')
            _this.attr('disabled' , 'disabled')
            $.post(form_URL, {
                email: email, type:type, otp:otp
            },
            function(data){
                _this.html('VERIFY')
                _this.removeAttr('disabled')
                let json = JSON.parse(data)
                if(json == 'otp'){
                    toastr.error('OTP code is incorrect or has expired!');
                }else if(json == 'email_exist'){
                    toastr.error('Email already exists in the system!');
                }else{
                    toastr.success('You have registered Success!','Success!');
                    $('.modal-auth-general').removeClass('block')
                    $('.wrap-modal-login').addClass('block')
                }
            }); 
        }else{
            let form_URL = 'ajax/frontend/auth/get_new_password';
            if(IsEmail(email) == false){
                toastr.error('Invalid Email Format!','Please try again!');
            }else if(otp == '' || otp.length != 6){
                toastr.error('OTP code is incorrect or has expired!','Please try again!');
            }else{
                $.post(form_URL, {
                    email: email, otp : otp
                },
                function(data){
                    if(data.trim() == 'error'){
                        toastr.error('An error occurred!','Please try again!');
                    }else if(data.trim() == 'error_otp'){
                        toastr.error('OTP code is incorrect or has expired!','Please try again!');
                    }else{
                        toastr.success('New password has been sent to your Email!','Success!');
                        window.location.reload();
                    }
                }); 
            }
        }
        return false;
    })

    $('.btn-submit-change-password').on('click', function(){
        let form = $('#form-password').serializeArray();
        let error = false;

        for (var i = 0; i < form.length; i++) {
            if(form[i].value == ''){
                toastr.warning('Vui lòng điền đầy đủ thông tin các trường!','Please try again!'); 
                error = true; 
                break;
            }
        }

        $('#form-password .input-warning').each(function(){
            toastr.warning('Mật khẩu mới không hợp lệ hoặc không tương thích!','Please try again!'); 
            error = true; 
        })

        if(error == false){
            let form_URL = 'ajax/frontend/auth/change_password';
            $.post(form_URL, {
                form: form
            },
            function(data){
                if(data.trim() == 'error_confirm'){
                    toastr.error('Mật khẩu và Mật khẩu xác nhận không giống nhau!','Please try again!');
                }else if(data.trim() == 'error_email'){
                    toastr.error('An error occurred!','Please try again!');
                }else if(data.trim() == 'error_password'){
                    toastr.error('Mật khẩu không chính xác!','Please try again!');
                }else{
                    toastr.success('Bạn đã đổi mật khẩu Success!','Success!');
                    window.location.reload();
                }
            }); 
        }
        
        return false;
    })
    
    $('.btn-submit-forgot').on('click', function(){
        let email = $('input[name=email]').val();
        let otp = $('input[name=otp]').val();
        let form_URL = 'ajax/frontend/auth/get_new_password';
        if(IsEmail(email) == false){
            toastr.error('Invalid Email Format!','Please try again!');
        }else if(otp == '' || otp.length != 6){
            toastr.error('Mã OTP không chính xác hoặc đã hết thời gian sử dụng!','Please try again!');
        }else{
            $.post(form_URL, {
                email: email, otp : otp
            },
            function(data){
                if(data.trim() == 'error'){
                    toastr.error('An error occurred!','Please try again!');
                }else if(data.trim() == 'error_otp'){
                    toastr.error('Mã OTP không chính xác hoặc đã hết thời gian sử dụng!','Please try again!');
                }else{
                    toastr.success('Mật khẩu mới đã được gửi vào Email của bạn!','Success!');
                    window.location.href = BASE_URL+'login.html';
                }
            }); 
        }
        return false;
    })
    $('.send-back-otp').on('click', function(){
        let _this  = $(this)
        let email = $('input[name=email]').val();
        $('.email-check-otp-forgot').addClass('hidden')
        _this.addClass('hidden')
        $('.btn-get-otp-forgot').removeClass('hidden')
        $('.btn-submit-forgot').addClass('hidden')
        return false;
    })

    

    $('.login-form .button-login ').on('click', function(){
    	let email = $('input.login-input-email[name=email]').val()
    	let password = $('input.login-input-password[name=password]').val()
    	let form_URL = 'ajax/frontend/auth/login';
    	if(email == '' || password == ''){
			toastr.warning('Xin vui lòng điền đầy đủ thông tin các trường!','An error occurred!');
    	}else{
    		$.post(form_URL, {
				email: email,password: password
			},
			function(data){
				console.log(data);
				if(data.trim() == '0'){
    				toastr.error('Tài khoản hoặc mật khẩu không đúng!','Please try again!');
				}else if(data.trim() == '1'){
    				toastr.error('Tài khoản của bạn đang bị khóa!','Please try again!');
				}else if(data.trim() == 'error'){
    				toastr.error('An error occurred!','Please try again!');
    				$.removeCookie('HTVIETNAM_member', { path: '/' });
				}else{
    				toastr.success('Đăng nhập Success!','Success!');
    				window.location.href = BASE_URL;
				}
			});	
    	}
    	return false;
    })

	function begin() {
	    timing = 60;
	    $('.60s-countdown').removeClass('display-none')
	    $('.send-otp-text').addClass('display-none')
	    $('.60s-countdown').html(timing);
	    $('.btn-otp-email').addClass('isDisabled');
	    myTimer = setInterval(function() {
	      --timing;
	      $('.60s-countdown').html(timing);
	      if (timing === 0) {
	        clearInterval(myTimer);
	        $('.60s-countdown').addClass('display-none')
	    	$('.send-otp-text').removeClass('display-none')
	    	$('.btn-otp-email').removeClass('isDisabled');
	      }
	    }, 1000);

	 }

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

})