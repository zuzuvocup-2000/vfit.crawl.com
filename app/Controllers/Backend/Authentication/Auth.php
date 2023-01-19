<?php 
namespace App\Controllers\Backend\Authentication;
use App\Controllers\BaseController;

class Auth extends BaseController{
	protected $data;
	

	public function __construct(){
		$this->authService = service('AuthService');
		$this->data = [];
	}

	public function login(){
		try{
	        $session = session();
			$validate = [
				'email' => 'required|valid_email',
				'password' => 'required|min_length[6]',
			];
			$errorValidate = [
				'email' => [
					'valid_email' => 'Định dạng Email không hợp lệ!',
					'required' => 'Xin vui lòng nhập vào trường Email!',
				],
				'password' => [
					'required' => 'Xin vui lòng nhập vào trường mật khẩu!',
					'min_length' => 'Mật khẩu phải lớn hơn 6 kí tự!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				$dataLogin = $this->authService->login([
					'email' => $this->request->getPost('email'),
					'password' => $this->request->getPost('password')
				]);
				
		        if($dataLogin['code'] == 200){
					$ses_data = [
	                    'isLoggedIn' => TRUE,
	                    'accessToken' => $dataLogin['accessToken'],
	                    'name' => $dataLogin['name'],
	                    'email' => $dataLogin['email'],
	                ];
	                $session->set($ses_data);
	                return redirect()->to(BASE_URL.'dashboard');
		        }else{
		           $this->data['validate'] = $dataLogin['message'];
		        }
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }

	        return view('backend/authentication/login', $this->data);
	    }catch(\Exception $e ){
         	echo $e->getMessage();die();
      	}
	}	

	public function login_view(){
		return view('backend/authentication/login');
	}

	public function logout(){
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
	}

	public function forgot(){
		helper(['mymail']);
		$session = session();
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email|check_email',
			];
			$errorValidate = [
				'email' => [
					'valid_email' => 'Định dạng Email không hợp lệ!',
					'required' => 'Xin vui lòng nhập vào trường Email!',
					'check_email' => 'Email không tồn tại trong hệ thống!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				$user = $this->authService->sendOtpForgotPassword($this->request->getPost('email'));
				$session->setFlashdata('message-success', 'Mã OTP đã được gửi vào Email của bạn!');
	 			return redirect()->to(BASE_URL.'verify?token='.base64_encode(json_encode([
	 				'email' => $user['data']['email'],
	 				'name' => $user['data']['name'],
	 				'_id' => $user['data']['_id'],
	 			])));
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		return view('backend/authentication/forgot', $this->data);
	}

	public function verify(){
		helper('text');
		$session = session();
		if($this->request->getMethod() == 'post'){
			$validate = [
				'otp' => 'required|check_otp',
			];
			$errorValidate = [
				'otp' => [
					'required' => 'Xin vui lòng nhập vào trường OTP',
					'check_otp' => 'Mã OTP không chính xác hoặc đã hết thời gian sử dụng!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				$user = $this->authService->resetPassword($_GET['token']);
		 		if($user == true) {
		 			$session->setFlashdata('message-success', 'Mật khẩu mới đã được gửi vào Email của bạn!');
		 			return redirect()->to(BASE_URL);
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		return view('backend/authentication/verify', $this->data);
	}
}
