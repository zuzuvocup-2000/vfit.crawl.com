<?php 
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;

class Auth extends FrontendController{
	
	public function __construct(){
		helper(['mymail','mystring','mydata','text']);
	}

	public function login(){
		$param['email'] = $this->request->getPost('email');
		$param['password'] = $this->request->getPost('password');
		$user = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, fullname, email, password, salt, image',
			'where' => ['email' => $param['email'],'deleted_at' => 0]
		]);
		if(!isset($user) || is_array($user) == false || count($user) == 0){
			echo 0;die();
		}
		$passwordEncode = password_encode($param['password'], $user['salt']);
		if($passwordEncode != $user['password']){
			echo 0;die();
		}

		$user_active = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $param['email'],'deleted_at' => 0,'publish' => 1]
		]);
		if(!isset($user_active) || is_array($user_active) == false || count($user_active) == 0){
			echo 1;die();
		}
 		
 		$cookieAuth = [
 			'id' => $user['id'],
 			'fullname' => $user['fullname'],
 			'email' => $user['email'],
 			'image' => $user['image']
 		];
 		setcookie(AUTH.'member', json_encode($cookieAuth), time() + 1*24*3600, "/");
 		$_update = [
 			'last_login' => gmdate('Y-m-d H:i:s', time() + 7*3600),
			'user_agent' => $_SERVER['HTTP_USER_AGENT'],
			'remote_addr' => $_SERVER['REMOTE_ADDR']
 		];
 		$flag = $this->AutoloadModel->_update([
 			'table' => 'member',
 			'where' => ['id' => $user['id']],
 			'data' => $_update
 		]);

 		if($flag >0){
 			echo 'complete';die();
 		}else{
 			echo 'error';die();
 		}
	}

	public function change_password(){
	 	$param = $this->request->getPost('form');
	 	$data = [];
	 	$store = [];
	 	foreach ($param as $key => $value) {
	 		$data[$value['name']] = $value['value'];
	 	}
	 	if($data['new_password'] != $data['confirm_password']){
	 		echo 'error_confirm';die();
	 	}

	 	$user = $this->AutoloadModel->_get_where([
			'table' => 'member',
			'select' => 'id, fullname, email ,password, salt',
			'where' => ['email' => $data['email']]
		]);
		$passwordEncode = password_encode($data['password'], $user['salt']);
		if(!isset($user) || is_array($user) == false || count($user) == 0){
			echo 'error_email';die();
		}
		if($passwordEncode != $user['password']){
			echo 'error_password';die();
		}

	 	$store['salt'] = random_string('alnum', 168);
	 	$store['password'] = password_encode($data['new_password'],$store['salt']);
		$store['publish'] = 1;
		$store['updated_at'] = $this->currentTime;
		$flag = $this->AutoloadModel->_update(['table'=>'member','data' => $store, 'where' => ['email' => $data['email'], 'deleted_at' =>0]]);
		if($flag > 0){
			echo 'success';die();
		}
	}

	public function send_otp_signup(){
	 	$param['password'] = $this->request->getPost('password');
	 	$param['email'] = $this->request->getPost('email');
		$check_member = $this->AutoloadModel->_get_where([
	 		'select' => 'id',
	 		'table' => 'member',
	 		'where' => [
	 			'email' => $param['email'],
	 			'deleted_at' => 0,
	 		],
	 		'count' => true
	 	]);
	 	if($check_member != 0){
	 		echo 2;die();
	 	}
	 	$check = $this->AutoloadModel->_get_where([
	 		'select' => 'id',
	 		'table' => 'clipboard_signup',
	 		'where' => [
	 			'email' => $param['email']
	 		],
	 		'count' => true
	 	]);
	 	if($check != 0){
	 		$this->AutoloadModel->_delete([
		 		'table' => 'clipboard_signup',
		 		'where' => [
		 			'email' => $param['email'],
		 		]
		 	]);
	 	}


	 	helper(['text']);
		$salt = random_string('alnum', 168);
 		$store = [
	 		'email' => $param['email'],
	 		'salt' => $salt,
	 		'password' => password_encode($param['password'], $salt),
	 		'created_at' => $this->currentTime
	 	];
	 	$param['id'] = $this->AutoloadModel->_insert([
	 		'table' => 'clipboard_signup',
	 		'data' => $store
	 	]);

	 	$otp = $this->otp(); 
 		$otp_live = $this->otp_time();
 		$mailbie = new MailBie();
 		$otpTemplate = otp_template_signup([
 			'fullname' => '',
 			'otp' => $otp,
 		]);

 		$flag = $mailbie->send([
 			'to' => $param['email'],
 			'subject' => 'Mã OTP đăng ký cho Email: '.$param['email'],
 			'messages' => $otpTemplate,
 		]);

 		$update = [
 			'otp' => $otp,
 			'otp_live' => $otp_live,
 		];
 		$countUpdate = $this->AutoloadModel->_update([
 			'table' => 'clipboard_signup',
 			'data' => $update,
 			'where' => ['id' => $param['id']],
 		]);
 		if($flag != 0 && $countUpdate != 0){
 			echo 1;die();
 		}else{
 			echo 0;die();
 		}
	}

	public function signup(){
	 	$param['email'] = $this->request->getPost('email');
	 	$param['type'] = $this->request->getPost('type');
	 	$param['otp'] = $this->request->getPost('otp');



	 	$count = $this->AutoloadModel->_get_where([
	 		'select' => 'otp, otp_live, salt, password',
	 		'table' => 'clipboard_signup',
	 		'where' => [
	 			'email' => $param['email'],
	 			'otp' => $param['otp']
	 		]
	 	]);

	 	if($count == [] || (strtotime($this->currentTime) > strtotime($count['otp_live']))){
	 		echo json_encode($flag['error'] = 'otp'); die();
	 	}
	 	$count_member = $this->AutoloadModel->_get_where([
	 		'select' => 'email',
	 		'table' => 'member',
	 		'where' => [
	 			'email' => $param['email'],
	 			'deleted_at' => 0
	 		],
	 		'count' => true
	 	]);

	 	if($count_member > 0){
	 		echo json_encode($flag['error'] = 'email_exist'); die();
	 	}
	 	$store['otp'] = $count['otp'];
	 	$store['otp_live'] = $count['otp_live'];

 		$store['password'] = $count['password'];
 		$store['salt'] = $count['salt'];
 		$store['email'] = $param['email'];
 		$store['created_at'] = $this->currentTime;
		$store['publish'] = 1;
		$insertid = $this->AutoloadModel->_insert(['table' => 'member','data' => $store]);
		if($insertid > 0){
			$this->AutoloadModel->_delete([
				'table' => 'clipboard_signup',
				'where' => [
					'email' => $param['email']
				]
			]);
		}
		if($insertid > 0){
			echo json_encode($flag['error'] = 'no_error'); die();
		}
	}

	public function send_otp_forgot(){
	 	$param['email'] = $this->request->getPost('email');
		$check_email = $this->AutoloadModel->_get_where([
	 		'select' => 'id, fullname',
	 		'table' => 'member',
	 		'where' => [
	 			'email' => $param['email']
	 		],
	 	]);
	 	if(count($check_email) == 0){
	 		echo 'no_email';die();
	 	}

	 	$otp = $this->otp(); 
 		$otp_live = $this->otp_time();
 		$mailbie = new MailBie();
 		$otpTemplate = otp_template([
 			'fullname' => $check_email['fullname'],
 			'otp' => $otp,
 		]);

 		$flag = $mailbie->send([
 			'to' => $param['email'],
 			'subject' => 'Quên mật khẩu cho tài khoản: '.$param['email'],
 			'messages' => $otpTemplate,
 		]);

		$update = [
 			'otp' => $otp,
 			'otp_live' => $otp_live,
 		];
 		$countUpdate = $this->AutoloadModel->_update([
 			'table' => 'member',
 			'data' => $update,
 			'where' => ['id' => $check_email['id']],
 		]);
 		if($countUpdate > 0 && $flag == true){
 			echo 'success';die();
 		}else{
 			echo 'error';die();
 		}
 		
	}
	public function get_new_password(){
	 	$param['email'] = $this->request->getPost('email');
	 	$param['otp'] = $this->request->getPost('otp');

	 	$user = $this->AutoloadModel->_get_where([
	 		'select' => 'id, fullname, email, otp, otp_live',
	 		'table' => 'member',
	 		'where' => [
	 			'email' => $param['email'],
	 			'deleted_at' => 0
	 		],
	 	]);
		$currentTime = gmdate('Y-m-d H:i:s', time() + 7*3600);
		if(strtotime($currentTime) > strtotime($user['otp_live'])){
			echo 'error_otp';die();
		}
		if($user['otp'] != $param['otp']){
			echo 'error_otp';die();
		}
	 	$salt = random_string('alnum', 168);
 		$password = random_string('numeric', 6);
 		$password_encode = password_encode($password, $salt);
 		$update = [
 			'password' => $password_encode,
 			'salt' => $salt,
 		];

 		$flag = $this->AutoloadModel->_update([
 			'table' => 'member',
 			'data' => $update,
 			'where' => ['id' => $user['id']]
 		]);
 		if($flag > 0){
 			$mailbie = new Mailbie();
		 	$mailFlag = $mailbie->send([
	 			'to' => $user['email'],
	 			'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
	 			'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url('login.html').'">Click vào đây để tiến hành đăng nhập</a></div>',
	 		]);
	 		if($mailFlag == true){
	 			echo 'success';die();
	 		}
 		}
		echo 'error';die();
	}

	public function update_info_member(){
	 	$form = $this->request->getPost('form');
	 	$param = [];
	 	if(isset($form) && is_array($form) && count($form)){
	 		foreach ($form as $key => $value) {
	 			$param[$value['name']] = $value['value'];
	 		}
	 	}

	 	$check_email = $this->AutoloadModel->_get_where([
	 		'select' => 'id, fullname',
	 		'table' => 'member',
	 		'where' => [
	 			'email' => $param['email']
	 		],
	 		'count' => true
	 	]);
	 	if($check_email == 0){
	 		echo 'no_email';die();
	 	}

	 	$flag = $this->AutoloadModel->_update([
	 		'table' => 'member',
	 		'data' => $param,
	 		'where' => [
	 			'deleted_at' => 0,
	 			'publish' => 1,
	 			'email' => $param['email']
	 		]
	 	]);
	 	if($flag > 0){
	 		echo 'success';die();
	 	}else{
	 		echo 'error';die();
	 	}
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
