<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class UserRules {

	protected $AutoloadModel;
	protected $user;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->client = \Config\Services::curlrequest();

	}

	public function check_email(string $email = ''){
		$param = [
			'email' => $email
		];
		$result = $this->client->post(API_GET_USER_BY_EMAIL,['debug' => true,'json' => $param]);
		$body = json_decode($result->getBody(),true);
		if(isset($body) && $body['code'] == 200){
			return true;
		}
		return false;
	}

	public function check_otp($otp = ''){
		$token = json_decode(base64_decode($_GET['token']), TRUE);

		if(!isset($token) || is_array($token) == false || count($token) == 0){
			return false;
		}

		$param = [
			'email' => $token['email']
		];
		$result = $this->client->post(API_GET_USER_BY_EMAIL,['debug' => true,'json' => $param]);
		$body = json_decode($result->getBody(),true);
		$user = $body['data'];
		$currentTime = gmdate('Y-m-d H:i:s', time() + 7*3600);
		if(strtotime($currentTime) > strtotime(gmdate('Y-m-d H:i:s', strtotime($user['otpLive']) + 7*3600))){
			return false;
		}

		if($user['otp'] != $otp){
			return false;
		}
		return true;
	}
}

