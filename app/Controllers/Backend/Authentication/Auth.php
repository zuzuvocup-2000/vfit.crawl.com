<?php 
namespace App\Controllers\Backend\Authentication;
use App\Controllers\BaseController;
use App\Libraries\Mailbie;
use App\Models\UserModel;

class Auth extends BaseController{
	protected $data;
	

	public function __construct(){
		$this->usermodel = new UserModel();
		$this->data = [];
	}

	public function login(){
		$session = session();

		$email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
		$user = $this->usermodel->get_user_by_email($email);
		if($user){
            $pass = $user['password'];
            $authenticatePassword = password_verify($password, $pass);
            if($authenticatePassword){
                $ses_data = [
                    'id' => $user['_id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'isLoggedIn' => TRUE
                ];

                $session->set($ses_data);
                return redirect()->to(BASE_URL.'dashboard');
            
            }else{
                $session->setFlashdata('message-danger', 'Mật khẩu không chính xác!');
                return redirect()->to(BASE_URL);
            }
        }else{
            $session->setFlashdata('message-danger', 'Email không tồn tại!');
            return redirect()->to(BASE_URL);
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
		if($this->request->getMethod() == 'post'){
			$validate = [
				'email' => 'required|valid_email|check_email',
			];
			$errorValidate = [
				'email' => [
					'check_email' => 'Email không tồn tại trong hệ thống!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
		 		$user = $this->AutoloadModel->_get_where([
		 			'select' => 'id, fullname, email',
		 			'table' => 'user',
		 			'where' => ['email' => $this->request->getVar('email'),'deleted_at' => 0],
		 		]);

		 		$otp = $this->otp(); 
		 		$otp_live = $this->otp_time();
		 		$mailbie = new MailBie();
		 		$otpTemplate = otp_template([
		 			'fullname' => $user['fullname'],
		 			'otp' => $otp,
		 		]);

		 		$flag = $mailbie->send([
		 			'to' => $user['email'],
		 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
		 			'messages' => $otpTemplate,
		 		]);

		 		$update = [
		 			'otp' => $otp,
		 			'otp_live' => $otp_live,
		 		];
		 		$countUpdate = $this->AutoloadModel->_update([
		 			'table' => 'user',
		 			'data' => $update,
		 			'where' => ['id' => $user['id']],
		 		]);

		 		if($countUpdate > 0 && $flag == true){
		 			return redirect()->to(BASE_URL.'backend/authentication/auth/verify?token='.base64_encode(json_encode($user)));
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		return view('backend/authentication/forgot', $this->data);
	}

	public function verify(){
		helper('text');
		if($this->request->getMethod() == 'post'){
			$validate = [
				'otp' => 'required|check_otp',
			];
			$errorValidate = [
				'otp' => [
					'check_otp' => 'Mã OTP không chính xác hoặc đã hết thời gian sử dụng!',
				],
			];
			if ($this->validate($validate, $errorValidate)){
				$user = json_decode(base64_decode($_GET['token']), TRUE);
		 		$salt = random_string('alnum', 168);
		 		$password = random_string('numeric', 6);
		 		$password_encode = password_encode($password, $salt);

		 		$update = [
		 			'password' => $password_encode,
		 			'salt' => $salt,
		 		];

		 		$flag = $this->AutoloadModel->_update([
		 			'table' => 'user',
		 			'data' => $update,
		 			'where' => ['id' => $user['id']]
		 		]);
		 		if($flag > 0){
		 			$mailbie = new Mailbie();
				 	$mailFlag = $mailbie->send([
			 			'to' => $user['email'],
			 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
			 			'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url(BACKEND_DIRECTORY).'">Click vào đây để tiến hành đăng nhập</a></div>',
			 		]);
			 		if($mailFlag == true){
			 			return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
			 		}
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		return view('backend/authentication/verify', $this->data);
	}

	private function otp(){
		helper(['text']);
		$otp = random_string('numeric', 6);
		return $otp;
	}

	private function otp_time(){
		$timeToLive = gmdate('Y-m-d H:i:s', time() + 7*3600 + 300);
		return $timeToLive;
	}

}
